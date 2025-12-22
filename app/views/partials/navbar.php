<?php
$navLinks = [
    ['href' => '/', 'label' => 'Home'],
    ['href' => '/services', 'label' => 'Services'],
    ['href' => '/studio', 'label' => 'Studio'],
    ['href' => '/laptops', 'label' => 'Laptops'],
    ['href' => '/contact', 'label' => 'Contact'],
];
?>
<header class="sticky top-0 z-50 w-full border-b border-gray-100 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80">
    <nav class="container flex h-16 items-center justify-between">
        <!-- Logo -->
        <a href="/" class="flex items-center gap-2 text-xl font-bold text-anchor-dark hover:opacity-80 transition-opacity">
            <img src="/images/DITRONICS-COMPANY-LOGO.png" alt="Ditronics Logo" width="40" height="40" class="rounded-full">
            <span>Ditronics</span>
        </a>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center gap-8">
            <?php foreach ($navLinks as $link): ?>
                <a href="<?= e($link['href']) ?>" class="text-sm font-medium text-neutral-text hover:text-anchor-dark transition-colors <?= isCurrentPath($link['href']) ? 'text-anchor-dark' : '' ?>">
                    <?= e($link['label']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- CTA Button -->
        <div class="hidden md:flex items-center gap-4">
            <a href="/contact" class="btn btn-primary btn-sm">Get Started</a>
        </div>

        <!-- Mobile Menu Toggle -->
        <button id="mobile-menu-toggle" class="md:hidden p-2 text-anchor-dark" aria-label="Toggle menu">
            <i data-lucide="menu" class="menu-icon w-6 h-6"></i>
            <i data-lucide="x" class="close-icon w-6 h-6 hidden"></i>
        </button>
    </nav>

    <!-- Mobile Navigation -->
    <div id="mobile-menu" class="md:hidden overflow-hidden transition-all duration-300 ease-[cubic-bezier(.2,.9,.2,1)] max-h-0">
        <div class="container py-4 flex flex-col gap-4">
            <?php foreach ($navLinks as $link): ?>
                <a href="<?= e($link['href']) ?>" class="text-base font-medium text-neutral-text hover:text-anchor-dark transition-colors py-2">
                    <?= e($link['label']) ?>
                </a>
            <?php endforeach; ?>
            <a href="/contact" class="btn btn-primary btn-md mt-2">Get Started</a>
        </div>
    </div>
</header>
