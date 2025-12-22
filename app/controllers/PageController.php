<?php
/**
 * Page Controller - Static Pages
 */

declare(strict_types=1);

class PageController
{
    public function services(): void
    {
        View::render('pages/services', [
            'title' => 'Services — Ditronics',
            'description' => 'Software integration, IT infrastructure, custom business software, DSP solutions, and R&D services for modern enterprises.',
        ]);
    }

    public function studio(): void
    {
        View::render('pages/studio', [
            'title' => 'Ditronics Studios — Video, Film and Digital Contents Production',
            'description' => 'Professional video production, film production, graphics design, motion graphics, live streaming, and digital content creation services.',
        ]);
    }

    public function contact(): void
    {
        $settings = getSettings();
        
        View::render('pages/contact', [
            'title' => 'Contact — Ditronics',
            'description' => 'Get in touch with our team. We\'re here to help with your IT needs.',
            'settings' => $settings,
            'csrfToken' => CSRF::getToken(),
        ]);
    }

    public function submitContact(): void
    {
        // Validate CSRF token
        CSRF::validateOrFail();

        // Rate limiting
        if (!checkRateLimit('contact_' . getClientIp())) {
            if (isAjaxRequest()) {
                jsonResponse(['success' => false, 'message' => 'Too many requests. Please try again later.'], 429);
            } else {
                redirect('/contact?error=rate_limit');
            }
            return;
        }

        // Get and validate input
        $name = sanitize($_POST['name'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $company = sanitize($_POST['company'] ?? '');
        $message = sanitize($_POST['message'] ?? '');

        $errors = [];

        if (strlen($name) < 2) {
            $errors['name'] = 'Name must be at least 2 characters';
        }

        if (!isValidEmail($email)) {
            $errors['email'] = 'Please enter a valid email address';
        }

        if (strlen($message) < 10) {
            $errors['message'] = 'Message must be at least 10 characters';
        }

        if (!empty($errors)) {
            if (isAjaxRequest()) {
                jsonResponse([
                    'success' => false,
                    'message' => 'Please fix the errors below',
                    'errors' => $errors,
                ], 400);
            } else {
                $_SESSION['contact_errors'] = $errors;
                $_SESSION['contact_data'] = compact('name', 'email', 'company', 'message');
                redirect('/contact');
            }
            return;
        }

        // Save to database
        try {
            $db = Database::getInstance();
            $db->insert('contact_inquiries', [
                'name' => $name,
                'email' => $email,
                'company' => $company ?: null,
                'message' => $message,
            ]);

            if (isAjaxRequest()) {
                jsonResponse([
                    'success' => true,
                    'message' => 'Thank you! We\'ll get back to you within 24 hours.',
                ]);
            } else {
                $_SESSION['contact_success'] = true;
                redirect('/contact?success=1');
            }
        } catch (Exception $e) {
            if (isAjaxRequest()) {
                jsonResponse([
                    'success' => false,
                    'message' => 'Something went wrong. Please try again later.',
                ], 500);
            } else {
                redirect('/contact?error=server');
            }
        }
    }
}
