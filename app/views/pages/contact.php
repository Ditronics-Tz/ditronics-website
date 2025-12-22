<?php
$email = $settings['email'] ?? 'info@ditronics.co.tz';
$phoneNumber = $settings['phone_number'] ?? '255717321753';
$address = $settings['address'] ?? 'Shangwe Kibada, Tanzania';

// Get session messages
$errors = $_SESSION['contact_errors'] ?? [];
$oldData = $_SESSION['contact_data'] ?? [];
$success = isset($_GET['success']) || isset($_SESSION['contact_success']);

// Clear session data
unset($_SESSION['contact_errors'], $_SESSION['contact_data'], $_SESSION['contact_success']);
?>

<!-- Hero Section -->
<section class="py-20 bg-gradient-hero">
    <div class="container">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="mb-6">Get in Touch</h1>
            <p class="text-xl text-neutral-text">
                Have a question or ready to start a project? We'd love to
                hear from you. Fill out the form below and we'll get back to
                you within 24 hours.
            </p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-12 bg-white">
    <div class="container">
        <div class="grid lg:grid-cols-3 gap-12">
            <!-- Contact Info -->
            <div class="lg:col-span-1">
                <h2 class="text-2xl font-bold text-anchor-dark mb-6">
                    Contact Information
                </h2>
                <p class="text-neutral-text mb-8">
                    Reach out through any of these channels or fill out the form.
                    We're here to help.
                </p>

                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: rgba(255, 74, 0, 0.1);">
                            <i data-lucide="mail" class="w-5 h-5 text-vermilion"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-anchor-dark">Email</h3>
                            <a href="mailto:<?= e($email) ?>" class="text-anchor-dark hover:underline">
                                <?= e($email) ?>
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: rgba(255, 74, 0, 0.1);">
                            <i data-lucide="phone" class="w-5 h-5 text-vermilion"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-anchor-dark">Phone</h3>
                            <a href="tel:+<?= e($phoneNumber) ?>" class="text-anchor-dark hover:underline">
                                <?= formatPhoneDisplay($phoneNumber) ?>
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: rgba(255, 74, 0, 0.1);">
                            <i data-lucide="map-pin" class="w-5 h-5 text-vermilion"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-anchor-dark">Office</h3>
                            <p class="text-neutral-text"><?= e($address) ?></p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: rgba(255, 74, 0, 0.1);">
                            <i data-lucide="clock" class="w-5 h-5 text-vermilion"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-anchor-dark">Hours</h3>
                            <p class="text-neutral-text">
                                Mon - Fri: 9am - 6pm EAT<br>
                                24/7 Support for clients
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-off-white rounded-lg p-8">
                    <h2 class="text-2xl font-bold text-anchor-dark mb-6">
                        Send us a Message
                    </h2>
                    
                    <?php if ($success): ?>
                        <div class="p-8 text-center rounded-lg" style="background-color: rgba(19, 208, 171, 0.1); border: 1px solid var(--teal-green);">
                            <i data-lucide="check-circle" class="w-12 h-12 text-teal-green mx-auto mb-4"></i>
                            <h3 class="text-xl font-semibold text-anchor-dark mb-2">Message Sent!</h3>
                            <p class="text-neutral-text">Thank you! We'll get back to you within 24 hours.</p>
                        </div>
                    <?php else: ?>
                        <form action="/contact" method="POST" class="space-y-6">
                            <?= CSRF::field() ?>
                            
                            <?php if (!empty($errors)): ?>
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-red-600 text-sm">
                                    Please fix the errors below
                                </div>
                            <?php endif; ?>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="form-label text-anchor-dark">Name *</label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        required
                                        placeholder="John Doe"
                                        value="<?= e($oldData['name'] ?? '') ?>"
                                        class="form-input"
                                    >
                                    <?php if (isset($errors['name'])): ?>
                                        <p class="text-red-500 text-sm mt-1"><?= e($errors['name']) ?></p>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <label for="email" class="form-label text-anchor-dark">Email *</label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        required
                                        placeholder="john@company.com"
                                        value="<?= e($oldData['email'] ?? '') ?>"
                                        class="form-input"
                                    >
                                    <?php if (isset($errors['email'])): ?>
                                        <p class="text-red-500 text-sm mt-1"><?= e($errors['email']) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div>
                                <label for="company" class="form-label text-anchor-dark">Company</label>
                                <input
                                    type="text"
                                    id="company"
                                    name="company"
                                    placeholder="Company Inc."
                                    value="<?= e($oldData['company'] ?? '') ?>"
                                    class="form-input"
                                >
                            </div>

                            <div>
                                <label for="message" class="form-label text-anchor-dark">Message *</label>
                                <textarea
                                    id="message"
                                    name="message"
                                    required
                                    placeholder="Tell us about your project and how we can help..."
                                    rows="5"
                                    class="form-input form-textarea"
                                ><?= e($oldData['message'] ?? '') ?></textarea>
                                <?php if (isset($errors['message'])): ?>
                                    <p class="text-red-500 text-sm mt-1"><?= e($errors['message']) ?></p>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-full">
                                Send Message
                            </button>

                            <p class="text-sm text-neutral-text text-center">
                                By submitting this form, you agree to our
                                <a href="#" class="text-anchor-dark hover:underline">Privacy Policy</a>.
                            </p>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="h-96 bg-gray-200 relative">
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m12!1m8!1m3!1d495.1382159487743!2d39.34260127383935!3d-6.877935025779765!3m2!1i1024!2i768!4f13.1!2m1!1sSHANGWE%20KIBADA!5e0!3m2!1sen!2stz!4v1764421644928!5m2!1sen!2stz"
        width="100%"
        height="100%"
        style="border: 0;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        title="Ditronics Location"
    ></iframe>
</section>

<style>
.space-y-6 > * + * { margin-top: 1.5rem; }
.h-96 { height: 24rem; }
</style>
