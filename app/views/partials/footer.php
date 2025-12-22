<?php
$settings = getSettings();
$phoneNumber = $settings['phone_number'] ?? '255717321753';
$email = $settings['email'] ?? 'info@ditronics.co.tz';
$address = $settings['address'] ?? 'Shangwe Kibada, Tanzania';
$companyName = $settings['company_name'] ?? 'Ditronics';

$footerLinks = [
    'company' => [
        ['href' => '/services', 'label' => 'Services'],
        ['href' => '/studio', 'label' => 'Studio'],
        ['href' => '/contact', 'label' => 'Contact'],
    ],
    'services' => [
        ['href' => '/services#software-integration', 'label' => 'Software & Integration'],
        ['href' => '/services#it-infrastructure', 'label' => 'IT Infrastructure'],
        ['href' => '/services#custom-software', 'label' => 'Custom Software'],
        ['href' => '/services#electrical-electronics', 'label' => 'Electrical & Electronics'],
    ],
    'resources' => [
        ['href' => '/laptops', 'label' => 'Laptop Catalog'],
        ['href' => '/studio', 'label' => 'Case Studies'],
        ['href' => '#', 'label' => 'Documentation'],
        ['href' => '#', 'label' => 'FAQ'],
    ],
];
?>
<footer class="bg-anchor-dark text-white">
    <div class="container py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <!-- Brand Column -->
            <div class="space-y-4">
                <a href="/" class="flex items-center gap-2 text-xl font-bold text-white hover:opacity-80 transition-opacity">
                    <img src="/images/DITRONICS-COMPANY-LOGO.png" alt="<?= e($companyName) ?> Logo" width="40" height="40" class="rounded-full">
                    <span class="text-white"><?= e($companyName) ?></span>
                </a>
                <p class="text-gray-300 text-sm leading-relaxed">
                    Your trusted partner for software integration, IT infrastructure,
                    custom business solutions, and innovative R&D services.
                </p>
                <div class="flex flex-col gap-2 text-sm">
                    <a href="mailto:<?= e($email) ?>" class="flex items-center gap-2 text-gray-300 hover:text-white transition-colors">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                        <span><?= e($email) ?></span>
                    </a>
                    <a href="tel:+<?= e($phoneNumber) ?>" class="flex items-center gap-2 text-gray-300 hover:text-white transition-colors">
                        <i data-lucide="phone" class="w-4 h-4"></i>
                        <span><?= formatPhoneDisplay($phoneNumber) ?></span>
                    </a>
                    <span class="flex items-center gap-2 text-gray-300">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                        <span><?= e($address) ?></span>
                    </span>
                </div>
            </div>

            <!-- Company Links -->
            <div>
                <h4 class="font-semibold text-white mb-4">Company</h4>
                <ul class="space-y-3">
                    <?php foreach ($footerLinks['company'] as $link): ?>
                        <li>
                            <a href="<?= e($link['href']) ?>" class="text-sm text-gray-300 hover:text-white transition-colors block">
                                <?= e($link['label']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Services Links -->
            <div>
                <h4 class="font-semibold text-white mb-4">Services</h4>
                <ul class="space-y-3">
                    <?php foreach ($footerLinks['services'] as $link): ?>
                        <li>
                            <a href="<?= e($link['href']) ?>" class="text-sm text-gray-300 hover:text-white transition-colors block">
                                <?= e($link['label']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Resources Links -->
            <div>
                <h4 class="font-semibold text-white mb-4">Resources</h4>
                <ul class="space-y-3">
                    <?php foreach ($footerLinks['resources'] as $link): ?>
                        <li>
                            <a href="<?= e($link['href']) ?>" class="text-sm text-gray-300 hover:text-white transition-colors block">
                                <?= e($link['label']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="mt-12 pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-sm text-gray-400">
                © <?= date('Y') ?> DITRONICS. All rights reserved.
            </p>
            <div class="flex gap-6 text-sm text-gray-400">
                <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
