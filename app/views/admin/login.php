<?php
$error = $_SESSION['login_error'] ?? null;
unset($_SESSION['login_error']);
?>
<div class="min-h-screen bg-gradient-hero flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <img
                src="/public/images/DITRONICS-COMPANY-LOGO.png"
                alt="Ditronics"
                width="80"
                height="80"
                class="mx-auto rounded-full mb-4"
            >
            <h1 class="text-2xl font-bold text-anchor-dark">Admin Login</h1>
            <p class="text-neutral-text">Sign in to manage your content</p>
        </div>
        
        <div class="bg-white rounded-lg border border-gray-200 p-8">
            <?php if ($error): ?>
                <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-sm">
                    <?= e($error) ?>
                </div>
            <?php endif; ?>
            
            <form action="/admin/login" method="POST" class="space-y-4">
                <?= CSRF::field() ?>
                
                <div>
                    <label class="block text-sm font-medium text-anchor-dark mb-2">
                        Username
                    </label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" aria-hidden="true"></i>
                        <input
                            id="username"
                            name="username"
                            type="text"
                            required
                            placeholder="Enter username"
                            class="form-input pl-10"
                        >
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-anchor-dark mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" aria-hidden="true"></i>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            placeholder="Enter password"
                            class="form-input pl-10 pr-10"
                        >

                        <button
                            type="button"
                            id="toggle-password"
                            class="absolute right-3 top-1/2 -translate-y-1/2 p-2 text-gray-400"
                            aria-label="Show password"
                            aria-pressed="false"
                        >
                            <i data-lucide="eye" class="js-eye w-4 h-4" aria-hidden="true"></i>
                            <i data-lucide="eye-off" class="js-eye-off w-4 h-4 hidden" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-md w-full">
                    Sign In
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('toggle-password');
    const input = document.getElementById('password');

    if (!toggle || !input) return;

    const eye = toggle.querySelector('.js-eye');
    const eyeOff = toggle.querySelector('.js-eye-off');

    function setVisible(isVisible) {
        input.type = isVisible ? 'text' : 'password';
        toggle.setAttribute('aria-pressed', String(isVisible));
        toggle.setAttribute('aria-label', isVisible ? 'Hide password' : 'Show password');

        if (eye) eye.classList.toggle('hidden', isVisible);
        if (eyeOff) eyeOff.classList.toggle('hidden', !isVisible);
    }

    setVisible(false);

    toggle.addEventListener('click', function () {
        setVisible(input.type === 'password');
    });
});
</script>
