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
                        <i data-lucide="user" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input
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
                        <i data-lucide="lock" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input
                            name="password"
                            type="password"
                            required
                            placeholder="Enter password"
                            class="form-input pl-10"
                        >
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-full">
                    Sign In
                </button>
            </form>
        </div>
    </div>
</div>

<style>
.space-y-4 > * + * { margin-top: 1rem; }
.transform { transform: translateY(-50%); }
.-translate-y-1\/2 { transform: translateY(-50%); }
.pl-10 { padding-left: 2.5rem; }
</style>
