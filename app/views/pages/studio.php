<?php
$videoProductionServices = [
    'Wedding Ceremony (Engagement, Pre-wedding, Kitchen party, Send-off, Wedding documentary)',
    'Film Production',
    'Business/Brand Documentary',
    'Commercial Advertisements',
    'Family Documentary',
    'Documentary Films',
    'Corporate Events',
    'Drone Footages',
    'Interview',
];

$graphicsDesignServices = [
    'Business Cards & ID Cards',
    'Calendars & Stickers',
    'Pull-ups & Brochures',
    'Logo Design',
    'Flyers & Banners',
];

$digitalBrandingServices = [
    'Social Media Management',
    'Website Development',
    'Applications',
    'Digital Contents',
    'Live Streaming Services',
    'Motion Graphics Production',
    'Animation Production',
    'Photoshooting',
];
?>

<!-- Hero Section with Image -->
<section class="relative py-20 bg-gradient-hero overflow-hidden">
    <div class="container">
        <div class="max-w-3xl mx-auto text-center mb-12">
            <h1 class="mb-6">Ditronics Studios</h1>
            <p class="text-xl text-vermilion font-semibold mb-4">
                Video, Film and Digital Contents Production
            </p>
            <p class="text-lg text-neutral-text">
                Bring your brand to life with professional video production,
                stunning graphics design, motion graphics, and live streaming
                services. We create content that captivates and converts.
            </p>
        </div>
        
        <!-- Studio Brochure Image -->
        <div class="relative max-w-4xl mx-auto rounded-xl overflow-hidden shadow-2xl">
            <img
                src="/images/DITRONICS-STUDIOS-DOOR-GRAPHICS-PREVIEW.jpg.jpeg"
                alt="Ditronics Studios - Video, Film and Digital Contents Production"
                class="w-full h-auto"
            >
        </div>
    </div>
</section>

<!-- Services Section - 3 Columns -->
<section class="py-16 bg-white">
    <div class="container">
        <div class="text-center mb-12">
            <h2 class="mb-4">Our Services</h2>
            <p class="text-lg text-neutral-text max-w-2xl mx-auto">
                Comprehensive creative services to elevate your brand and engage your audience.
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Video Production -->
            <div class="bg-off-white rounded-lg p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: rgba(255, 74, 0, 0.1);">
                        <i data-lucide="video" class="w-6 h-6 text-vermilion"></i>
                    </div>
                    <h3 class="text-xl font-bold text-anchor-dark">Video Production</h3>
                </div>
                <ul class="space-y-3">
                    <?php foreach ($videoProductionServices as $service): ?>
                        <li class="text-sm text-neutral-text flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-vermilion mt-1.5 flex-shrink-0"></span>
                            <?= e($service) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Graphics Designing -->
            <div class="bg-off-white rounded-lg p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: rgba(255, 74, 0, 0.1);">
                        <i data-lucide="palette" class="w-6 h-6 text-vermilion"></i>
                    </div>
                    <h3 class="text-xl font-bold text-anchor-dark">Graphics Designing</h3>
                </div>
                <ul class="space-y-3">
                    <?php foreach ($graphicsDesignServices as $service): ?>
                        <li class="text-sm text-neutral-text flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-vermilion mt-1.5 flex-shrink-0"></span>
                            <?= e($service) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Digital Branding -->
            <div class="bg-off-white rounded-lg p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: rgba(255, 74, 0, 0.1);">
                        <i data-lucide="monitor" class="w-6 h-6 text-vermilion"></i>
                    </div>
                    <h3 class="text-xl font-bold text-anchor-dark">Digital Branding</h3>
                </div>
                <ul class="space-y-3">
                    <?php foreach ($digitalBrandingServices as $service): ?>
                        <li class="text-sm text-neutral-text flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-vermilion mt-1.5 flex-shrink-0"></span>
                            <?= e($service) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-anchor-dark">
    <div class="container">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-white mb-4">Ready to Create Something Amazing?</h2>
            <p class="text-lg text-gray-400 mb-8">
                Let's discuss your project and bring your creative vision to life.
                From video production to brand design, we're here to help.
            </p>
            <a href="/contact" class="btn btn-primary btn-lg">
                Start Your Project
                <i data-lucide="arrow-right" class="w-5 h-5 ml-2"></i>
            </a>
        </div>
    </div>
</section>

<style>
.space-y-3 > * + * { margin-top: 0.75rem; }
.bg-vermilion { background-color: var(--vermilion); }
.mt-1\.5 { margin-top: 0.375rem; }
</style>
