<?php
/**
 * Auth Controller - Login/Logout
 */

declare(strict_types=1);

class AuthController
{
    public function loginForm(): void
    {
        // If already logged in, redirect to admin
        if (Auth::check()) {
            redirect('/admin');
            return;
        }

        View::render('admin/login', [
            'title' => 'Admin Login — Ditronics',
            'csrfToken' => CSRF::getToken(),
        ], 'admin');
    }

    public function login(): void
    {
        // Validate CSRF token
        CSRF::validateOrFail();

        // Rate limiting
        if (!checkRateLimit('login_' . getClientIp())) {
            if (isAjaxRequest()) {
                jsonResponse(['error' => 'Too many login attempts. Please try again later.'], 429);
            } else {
                $_SESSION['login_error'] = 'Too many login attempts. Please try again later.';
                redirect('/admin/login');
            }
            return;
        }

        $username = sanitize($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            if (isAjaxRequest()) {
                jsonResponse(['error' => 'Please provide username and password'], 400);
            } else {
                $_SESSION['login_error'] = 'Please provide username and password';
                redirect('/admin/login');
            }
            return;
        }

        if (Auth::attempt($username, $password)) {
            if (isAjaxRequest()) {
                jsonResponse(['success' => true]);
            } else {
                redirect('/admin');
            }
        } else {
            if (isAjaxRequest()) {
                jsonResponse(['error' => 'Invalid credentials'], 401);
            } else {
                $_SESSION['login_error'] = 'Invalid username or password';
                redirect('/admin/login');
            }
        }
    }

    public function logout(): void
    {
        Auth::logout();
        
        if (isAjaxRequest()) {
            jsonResponse(['success' => true]);
        } else {
            redirect('/admin/login');
        }
    }
}
