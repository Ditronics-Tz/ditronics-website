<?php
$stockStatusVariant = [
    'available' => 'badge-success',
    'sold' => 'badge-muted',
    'reserved' => 'badge-warning',
];

$conditionVariant = [
    'new_condition' => 'New',
    'used' => 'Used',
    'refurbished' => 'Refurbished',
];

$whatsappNumber = $settings['whatsapp_number'] ?? '255717321753';
$phoneNumber = $settings['phone_number'] ?? '255717321753';

$whatsappMessage = urlencode(
    "Hi! I'm interested in the {$laptop['name']} listed at $" . number_format($laptop['price'], 0) . ". Is it still available?"
);

$specs = array_filter([
    ['icon' => 'cpu', 'label' => 'Processor', 'value' => $laptop['specifications']['cpu'] ?? null],
    ['icon' => 'memory-stick', 'label' => 'RAM', 'value' => $laptop['specifications']['ram_size'] ?? null],
    ['icon' => 'hard-drive', 'label' => 'Storage', 'value' => ($laptop['specifications']['storage_capacity'] ?? '') . ' ' . ($laptop['specifications']['storage_type'] ?? '')],
    ['icon' => 'gpu', 'label' => 'Graphics', 'value' => $laptop['specifications']['gpu'] ?? null],
    ['icon' => 'monitor', 'label' => 'Display', 'value' => $laptop['specifications']['screen_size'] ?? null],
    ['icon' => 'battery', 'label' => 'Battery', 'value' => $laptop['specifications']['battery_capacity'] ?? null],
], fn($s) => !empty(trim($s['value'])));

$ports = !empty($laptop['specifications']['ports']) ? array_map('trim', explode(',', $laptop['specifications']['ports'])) : [];
?>

<!-- Breadcrumb -->
<section class="py-4 bg-off-white border-b border-gray-200">
    <div class="container">
        <div class="flex items-center gap-2 text-sm">
            <a href="/" class="text-neutral-text hover:text-vermilion">Home</a>
            <span class="text-gray-400">/</span>
            <a href="/laptops" class="text-neutral-text hover:text-vermilion">Laptops</a>
            <span class="text-gray-400">/</span>
            <span class="text-anchor-dark font-medium"><?= e($laptop['name']) ?></span>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-12 bg-white">
    <div class="container">
        <a href="/laptops" class="inline-flex items-center gap-2 text-neutral-text hover:text-vermilion mb-8 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Laptops
        </a>

        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Image Section -->
            <div>
                <div class="relative aspect-square bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl overflow-hidden">
                    <?php if (!empty($laptop['image'])): ?>
                        <img
                            src="<?= e($laptop['image']) ?>"
                            alt="<?= e($laptop['name']) ?>"
                            class="w-full h-full object-contain p-8"
                        >
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center">
                            <i data-lucide="monitor" class="w-32 h-32 text-gray-300"></i>
                        </div>
                    <?php endif; ?>
                    <span class="badge <?= $stockStatusVariant[$laptop['status']] ?? 'badge-muted' ?> absolute top-6 right-6 text-base px-4 py-2">
                        <?= e(ucfirst($laptop['status'])) ?>
                    </span>
                    <span class="badge badge-outline absolute top-6 left-6 text-base px-4 py-2">
                        <?= e($conditionVariant[$laptop['condition']] ?? ucfirst($laptop['condition'])) ?>
                    </span>
                </div>
            </div>

            <!-- Details Section -->
            <div>
                <!-- Title & Condition -->
                <div class="mb-6">
                    <?php if (!empty($laptop['brand'])): ?>
                        <span class="text-sm text-vermilion font-medium uppercase tracking-wider">
                            <?= e($laptop['brand']) ?>
                        </span>
                    <?php endif; ?>
                    <h1 class="text-3xl md:text-4xl font-bold text-anchor-dark mt-1 mb-3">
                        <?= e($laptop['name']) ?>
                    </h1>
                    <span class="badge badge-secondary text-sm">
                        <?= e($laptop['condition'] ?? 'Brand New') ?>
                    </span>
                </div>

                <!-- Price -->
                <div class="mb-8">
                    <p class="text-4xl font-bold text-vermilion">
                        TZS<?= number_format($laptop['price'], 0) ?>
                    </p>
                    <p class="text-sm text-neutral-text mt-1">
                        Price inclusive of all taxes
                    </p>
                </div>

                <!-- Quick Specs -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <?php foreach ($specs as $spec): ?>
                        <div class="flex items-start gap-3 p-4 bg-off-white rounded-lg">
                            <i data-lucide="<?= e($spec['icon']) ?>" class="w-5 h-5 text-vermilion mt-0.5 flex-shrink-0"></i>
                            <div>
                                <p class="text-xs text-neutral-text uppercase tracking-wider"><?= e($spec['label']) ?></p>
                                <p class="text-sm font-medium text-anchor-dark"><?= e($spec['value']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Description -->
                <?php if (!empty($laptop['description'])): ?>
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-anchor-dark mb-3">Description</h3>
                        <p class="text-neutral-text leading-relaxed"><?= e($laptop['description']) ?></p>
                    </div>
                <?php endif; ?>

                <!-- Notes -->
                <?php if (!empty($laptop['notes'])): ?>
                    <div class="mb-8 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                        <p class="text-amber-800 text-sm"><?= e($laptop['notes']) ?></p>
                    </div>
                <?php endif; ?>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="https://wa.me/<?= e($whatsappNumber) ?>?text=<?= $whatsappMessage ?>" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="btn btn-primary btn-lg flex-1">
                        <i data-lucide="message-circle" class="w-5 h-5 mr-2"></i>
                        WhatsApp Inquiry
                    </a>
                    <a href="tel:+<?= e($phoneNumber) ?>" class="btn btn-outline btn-lg flex-1">
                        <i data-lucide="phone" class="w-5 h-5 mr-2"></i>
                        Call Us
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="flex flex-wrap gap-4 mt-8 pt-8 border-t border-gray-200">
                    <div class="flex items-center gap-2 text-sm text-neutral-text">
                        <i data-lucide="check-circle" class="w-4 h-4 text-teal-green"></i>
                        Quality Assured
                    </div>
                    <div class="flex items-center gap-2 text-sm text-neutral-text">
                        <i data-lucide="check-circle" class="w-4 h-4 text-teal-green"></i>
                        Genuine Products
                    </div>
                    <div class="flex items-center gap-2 text-sm text-neutral-text">
                        <i data-lucide="check-circle" class="w-4 h-4 text-teal-green"></i>
                        Technical Support
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Full Specifications -->
<?php if (!empty($laptop['os']) || !empty($laptop['wifi']) || !empty($laptop['bluetooth']) || !empty($laptop['color']) || !empty($ports)): ?>
<section class="py-12 bg-off-white">
    <div class="container">
        <h2 class="text-2xl font-bold text-anchor-dark mb-8">Full Specifications</h2>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Core Specs Card -->
            <div class="card">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-anchor-dark mb-4 flex items-center gap-2">
                        <i data-lucide="cpu" class="w-5 h-5 text-vermilion"></i>
                        Performance
                    </h3>
                    <div class="space-y-3">
                        <?php if (!empty($laptop['cpu'])): ?>
                            <div class="flex justify-between">
                                <span class="text-neutral-text">Processor</span>
                                <span class="font-medium text-anchor-dark"><?= e($laptop['cpu']) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($laptop['ram'])): ?>
                            <div class="flex justify-between">
                                <span class="text-neutral-text">Memory</span>
                                <span class="font-medium text-anchor-dark"><?= e($laptop['ram']) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($laptop['storage'])): ?>
                            <div class="flex justify-between">
                                <span class="text-neutral-text">Storage</span>
                                <span class="font-medium text-anchor-dark"><?= e($laptop['storage']) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($laptop['gpu'])): ?>
                            <div class="flex justify-between">
                                <span class="text-neutral-text">Graphics</span>
                                <span class="font-medium text-anchor-dark"><?= e($laptop['gpu']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Display Card -->
            <div class="card">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-anchor-dark mb-4 flex items-center gap-2">
                        <i data-lucide="monitor" class="w-5 h-5 text-vermilion"></i>
                        Display & Design
                    </h3>
                    <div class="space-y-3">
                        <?php if (!empty($laptop['display'])): ?>
                            <div class="flex justify-between">
                                <span class="text-neutral-text">Screen</span>
                                <span class="font-medium text-anchor-dark"><?= e($laptop['display']) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($laptop['color'])): ?>
                            <div class="flex justify-between">
                                <span class="text-neutral-text">Color</span>
                                <span class="font-medium text-anchor-dark"><?= e($laptop['color']) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($laptop['weight'])): ?>
                            <div class="flex justify-between">
                                <span class="text-neutral-text">Weight</span>
                                <span class="font-medium text-anchor-dark"><?= e($laptop['weight']) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($laptop['dimensions'])): ?>
                            <div class="flex justify-between">
                                <span class="text-neutral-text">Dimensions</span>
                                <span class="font-medium text-anchor-dark"><?= e($laptop['dimensions']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Connectivity Card -->
            <div class="card">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-anchor-dark mb-4 flex items-center gap-2">
                        <i data-lucide="wifi" class="w-5 h-5 text-vermilion"></i>
                        Connectivity
                    </h3>
                    <div class="space-y-3">
                        <?php if (!empty($laptop['wifi'])): ?>
                            <div class="flex justify-between">
                                <span class="text-neutral-text">WiFi</span>
                                <span class="font-medium text-anchor-dark"><?= e($laptop['wifi']) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($laptop['bluetooth'])): ?>
                            <div class="flex justify-between">
                                <span class="text-neutral-text">Bluetooth</span>
                                <span class="font-medium text-anchor-dark"><?= e($laptop['bluetooth']) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($laptop['webcam'])): ?>
                            <div class="flex justify-between">
                                <span class="text-neutral-text">Webcam</span>
                                <span class="font-medium text-anchor-dark"><?= e($laptop['webcam']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <?php if (!empty($laptop['os']) || !empty($laptop['keyboard']) || !empty($laptop['battery']) || !empty($laptop['warranty'])): ?>
            <div class="card">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-anchor-dark mb-4 flex items-center gap-2">
                        <i data-lucide="package" class="w-5 h-5 text-vermilion"></i>
                        Additional Info
                    </h3>
                    <div class="space-y-3">
                        <?php if (!empty($laptop['os'])): ?>
                            <div class="flex justify-between">
                                <span class="text-neutral-text">OS</span>
                                <span class="font-medium text-anchor-dark"><?= e($laptop['os']) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($laptop['keyboard'])): ?>
                            <div class="flex justify-between">
                                <span class="text-neutral-text">Keyboard</span>
                                <span class="font-medium text-anchor-dark"><?= e($laptop['keyboard']) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($laptop['battery'])): ?>
                            <div class="flex justify-between">
                                <span class="text-neutral-text">Battery</span>
                                <span class="font-medium text-anchor-dark"><?= e($laptop['battery']) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($laptop['warranty'])): ?>
                            <div class="flex justify-between">
                                <span class="text-neutral-text">Warranty</span>
                                <span class="font-medium text-anchor-dark"><?= e($laptop['warranty']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Ports -->
            <?php if (!empty($ports)): ?>
            <div class="card md:col-span-2">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-anchor-dark mb-4">Ports & Slots</h3>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($ports as $port): ?>
                            <span class="badge badge-secondary text-sm"><?= e($port) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Related Laptops -->
<?php if (!empty($relatedLaptops)): ?>
<section class="py-12 bg-white">
    <div class="container">
        <h2 class="text-2xl font-bold text-anchor-dark mb-8">You May Also Like</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <?php foreach ($relatedLaptops as $related): ?>
                <a href="/laptops/<?= e($related['slug']) ?>">
                    <div class="card group h-full overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="relative aspect-[4/3] bg-gray-50">
                            <?php if (!empty($related['image'])): ?>
                                <img
                                    src="<?= e($related['image']) ?>"
                                    alt="<?= e($related['name']) ?>"
                                    class="w-full h-full object-contain p-4"
                                >
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <i data-lucide="monitor" class="w-12 h-12 text-gray-300"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-anchor-dark group-hover:text-vermilion transition-colors mb-2">
                                <?= e($related['name']) ?>
                            </h3>
                            <p class="text-lg font-bold text-vermilion">
                                $<?= number_format($related['price'], 0) ?>
                            </p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Contact CTA -->
<section class="py-16 bg-anchor-dark">
    <div class="container">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Interested in this laptop?</h2>
            <p class="text-gray-300 mb-8">
                Contact us today to check availability, ask questions, or place your order.
                We offer competitive pricing and excellent after-sales support.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="https://wa.me/<?= e($whatsappNumber) ?>?text=<?= $whatsappMessage ?>" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="btn btn-primary btn-lg">
                    <i data-lucide="message-circle" class="w-5 h-5 mr-2"></i>
                    Chat on WhatsApp
                </a>
                <a href="/contact" class="btn btn-lg bg-transparent border-2 border-white text-white hover:bg-white hover:text-anchor-dark">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.space-y-3 > * + * { margin-top: 0.75rem; }
.mt-0\.5 { margin-top: 0.125rem; }
</style>
