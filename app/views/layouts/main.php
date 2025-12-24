<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? SITE_NAME) ?></title>
    <meta name="description" content="<?= e($description ?? 'Enterprise-grade tech solutions. OS downgrades, custom builds, and hardware support you can trust.') ?>">
    <meta name="keywords" content="IT services, OS downgrade, custom PC builds, enterprise hardware, tech support">
    
    <!-- Favicon -->
    <link rel="icon" href="/public/images/DITRONICS-COMPANY-LOGO.png">
    <link rel="apple-touch-icon" href="/public/images/DITRONICS-COMPANY-LOGO.png">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= e($title ?? SITE_NAME) ?>">
    <meta property="og:description" content="<?= e($description ?? 'Enterprise-grade tech solutions.') ?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="/public/images/DITRONICS-COMPANY-LOGO.png">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($title ?? SITE_NAME) ?>">
    <meta name="twitter:description" content="<?= e($description ?? 'Enterprise-grade tech solutions.') ?>">
    <meta name="twitter:image" content="/public/images/DITRONICS-COMPANY-LOGO.png">
    
    <!-- Inter Font from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="/public/css/styles.css">
    
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body class="antialiased bg-white text-neutral-text">
    <?php partial('navbar'); ?>
    
    <main id="main-content">
        <?= $content ?>
    </main>
    
    <?php partial('footer'); ?>
    
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Mobile menu toggle
        const menuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', function() {
                const isOpen = mobileMenu.classList.contains('max-h-96');
                if (isOpen) {
                    mobileMenu.classList.remove('max-h-96', 'border-b', 'border-gray-100');
                    mobileMenu.classList.add('max-h-0');
                    menuToggle.querySelector('.menu-icon').classList.remove('hidden');
                    menuToggle.querySelector('.close-icon').classList.add('hidden');
                } else {
                    mobileMenu.classList.remove('max-h-0');
                    mobileMenu.classList.add('max-h-96', 'border-b', 'border-gray-100');
                    menuToggle.querySelector('.menu-icon').classList.add('hidden');
                    menuToggle.querySelector('.close-icon').classList.remove('hidden');
                }
            });
        }
    </script>
</body>
</html>
