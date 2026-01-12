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
    "Hi! I'm interested in the {$product['name']} listed at $" . number_format($product['price'], 0) . ". Is it still available?"
);

// Build specs based on product category
$specs = [];
switch ($product['category']) {
    case 'laptop':
        $specs = array_filter([
            ['icon' => 'cpu', 'label' => 'Processor', 'value' => $product['specifications']['cpu'] ?? null],
            ['icon' => 'memory-stick', 'label' => 'RAM', 'value' => $product['specifications']['ram_size'] ?? null],
            ['icon' => 'hard-drive', 'label' => 'Storage', 'value' => ($product['specifications']['storage_capacity'] ?? '') . ' ' . ($product['specifications']['storage_type'] ?? '')],
            ['icon' => 'gpu', 'label' => 'Graphics', 'value' => $product['specifications']['gpu'] ?? null],
            ['icon' => 'monitor', 'label' => 'Display', 'value' => $product['specifications']['screen_size'] ?? null],
            ['icon' => 'battery', 'label' => 'Battery', 'value' => $product['specifications']['battery_capacity'] ?? null],
        ], fn($s) => !empty(trim($s['value'])));
        break;
        
    case 'desktop_pc':
        $specs = array_filter([
            ['icon' => 'cpu', 'label' => 'Processor', 'value' => $product['specifications']['cpu'] ?? null],
            ['icon' => 'memory-stick', 'label' => 'RAM', 'value' => $product['specifications']['ram_size'] ?? null],
            ['icon' => 'hard-drive', 'label' => 'Storage', 'value' => ($product['specifications']['storage_capacity'] ?? '') . ' ' . ($product['specifications']['storage_type'] ?? '')],
            ['icon' => 'gpu', 'label' => 'Graphics', 'value' => $product['specifications']['gpu'] ?? null],
            ['icon' => 'pc-case', 'label' => 'Form Factor', 'value' => $product['specifications']['form_factor'] ?? null],
        ], fn($s) => !empty(trim($s['value'])));
        break;
        
    case 'server':
        $specs = array_filter([
            ['icon' => 'cpu', 'label' => 'CPU', 'value' => $product['specifications']['cpu_model'] ?? null],
            ['icon' => 'hash', 'label' => 'CPU Count', 'value' => $product['specifications']['cpu_count'] ?? null],
            ['icon' => 'memory-stick', 'label' => 'RAM', 'value' => $product['specifications']['ram_size'] ?? null],
            ['icon' => 'hard-drive', 'label' => 'Storage', 'value' => ($product['specifications']['storage_capacity'] ?? '') . ' ' . ($product['specifications']['storage_type'] ?? '')],
            ['icon' => 'shield-check', 'label' => 'RAID', 'value' => $product['specifications']['raid_level'] ?? null],
            ['icon' => 'server', 'label' => 'Rack Units', 'value' => $product['specifications']['rack_units'] ?? null],
        ], fn($s) => !empty(trim($s['value'])));
        break;
        
    case 'mouse':
        $specs = array_filter([
            ['icon' => 'wifi', 'label' => 'Connectivity', 'value' => $product['specifications']['connectivity'] ?? null],
            ['icon' => 'target', 'label' => 'DPI', 'value' => $product['specifications']['dpi'] ?? null],
            ['icon' => 'mouse-pointer-2', 'label' => 'Buttons', 'value' => $product['specifications']['buttons'] ?? null],
            ['icon' => 'palette', 'label' => 'Color', 'value' => $product['specifications']['color'] ?? null],
            ['icon' => 'battery', 'label' => 'Rechargeable', 'value' => isset($product['specifications']['rechargeable']) ? ($product['specifications']['rechargeable'] ? 'Yes' : 'No') : null],
        ], fn($s) => !empty(trim($s['value'])));
        break;
        
    default:
        // Generic specs for accessories and other products
        $specs = [];
        foreach ($product['specifications'] as $key => $value) {
            if (!empty($value) && is_scalar($value)) {
                $specs[] = [
                    'icon' => 'info',
                    'label' => ucwords(str_replace('_', ' ', $key)),
                    'value' => $value
                ];
            }
        }
        break;
}

$ports = !empty($product['specifications']['ports']) ? array_map('trim', explode(',', $product['specifications']['ports'])) : [];
?>

<!-- Breadcrumb -->
<section class="py-4 bg-off-white border-b border-gray-200">
    <div class="container">
        <div class="flex items-center gap-2 text-sm">
            <a href="/" class="text-neutral-text hover:text-anchor-dark">Home</a>
            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-300"></i>
            <a href="/products" class="text-neutral-text hover:text-anchor-dark">Products</a>
            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-300"></i>
            <a href="/products?category=<?= e($product['category']) ?>" class="text-neutral-text hover:text-anchor-dark"><?= e($categoryName) ?></a>
            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-300"></i>
            <span class="text-anchor-dark font-medium"><?= e($product['name']) ?></span>
        </div>
    </div>
</section>

<!-- Product Details -->
<section class="py-16 bg-white">
    <div class="container">
        <div class="grid lg:grid-cols-2 gap-12 mb-16">
            <!-- Product Image -->
            <div>
                <div class="relative aspect-square bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl overflow-hidden">
                    <?php if (!empty($product['image'])): ?>
                        <img
                            src="<?= e($product['image']) ?>"
                            alt="<?= e($product['name']) ?>"
                            class="w-full h-full object-contain p-8"
                        >
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center">
                            <i data-lucide="package" class="w-32 h-32 text-gray-300"></i>
                        </div>
                    <?php endif; ?>
                    <span class="badge <?= $stockStatusVariant[$product['status']] ?? 'badge-muted' ?> absolute top-6 right-6 text-base px-4 py-2">
                        <?= e(ucfirst($product['status'])) ?>
                    </span>
                    <span class="badge badge-outline absolute top-6 left-6 text-base px-4 py-2">
                        <?= e($conditionVariant[$product['condition']] ?? ucfirst($product['condition'])) ?>
                    </span>
                </div>
            </div>

            <!-- Details Section -->
            <div>
                <!-- Title & Condition -->
                <div class="mb-6">
                    <?php if (!empty($product['brand'])): ?>
                        <span class="text-sm text-vermilion font-medium uppercase tracking-wider">
                            <?= e($product['brand']) ?>
                        </span>
                    <?php endif; ?>
                    <h1 class="text-3xl md:text-4xl font-bold text-anchor-dark mt-1 mb-3">
                        <?= e($product['name']) ?>
                    </h1>
                    <div class="flex items-center gap-3">
                        <span class="text-3xl font-bold text-vermilion">
                            TZS<?= number_format($product['price'], 0) ?>
                        </span>
                        <span class="badge badge-outline">
                            <?= e($categoryName) ?>
                        </span>
                    </div>
                </div>

                <!-- Description/Notes -->
                <?php if (!empty($product['notes'])): ?>
                    <div class="mb-8">
                        <p class="text-neutral-text leading-relaxed">
                            <?= nl2br(e($product['notes'])) ?>
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Quick Actions -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <a href="https://wa.me/<?= e($whatsappNumber) ?>?text=<?= $whatsappMessage ?>" 
                       target="_blank" 
                       class="btn btn-primary flex items-center justify-center gap-2">
                        <i data-lucide="message-circle" class="w-5 h-5"></i>
                        WhatsApp
                    </a>
                    <a href="tel:+<?= e($phoneNumber) ?>" 
                       class="btn btn-secondary flex items-center justify-center gap-2">
                        <i data-lucide="phone" class="w-5 h-5"></i>
                        Call Now
                    </a>
                </div>

                <!-- Key Features -->
                <?php if (!empty($specs)): ?>
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-anchor-dark mb-4">Specifications</h3>
                        <div class="grid gap-4">
                            <?php foreach ($specs as $spec): ?>
                                <div class="flex items-center gap-4 p-4 bg-off-white rounded-lg">
                                    <div class="flex-shrink-0 w-10 h-10 bg-vermilion/10 rounded-lg flex items-center justify-center">
                                        <i data-lucide="<?= e($spec['icon']) ?>" class="w-5 h-5 text-vermilion"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-anchor-dark"><?= e($spec['label']) ?></div>
                                        <div class="text-neutral-text"><?= e($spec['value']) ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Ports & Connectivity (for laptops) -->
                <?php if (!empty($ports)): ?>
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-anchor-dark mb-4">Ports & Connectivity</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($ports as $port): ?>
                                <span class="badge badge-outline">
                                    <?= e(trim($port)) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Additional Images -->
<?php if (count($product['images']) > 1): ?>
<section class="py-16 bg-off-white">
    <div class="container">
        <h2 class="text-2xl font-bold text-anchor-dark mb-8">Product Gallery</h2>
        <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($product['images'] as $index => $image): ?>
                <?php if ($index > 0): // Skip first image as it's already shown above ?>
                    <div class="aspect-square bg-white rounded-lg overflow-hidden border border-gray-200">
                        <img
                            src="<?= e($image['variants']['medium'] ?? $image['url']) ?>"
                            alt="<?= e($product['name']) ?> - Image <?= $index + 1 ?>"
                            class="w-full h-full object-contain p-4"
                        >
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Related Products -->
<?php if (!empty($relatedProducts)): ?>
<section class="py-16 bg-white">
    <div class="container">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-anchor-dark">More <?= e($categoryName) ?></h2>
            <a href="/products?category=<?= e($product['category']) ?>" class="text-vermilion hover:underline">
                View all <?= e($categoryName) ?> →
            </a>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($relatedProducts as $related): ?>
                <div class="card group">
                    <div class="relative aspect-[4/3] bg-gray-50 overflow-hidden">
                        <?php if (!empty($related['image'])): ?>
                            <img
                                src="<?= e($related['image']) ?>"
                                alt="<?= e($related['name']) ?>"
                                class="w-full h-full object-contain p-4 transition-transform duration-500 group-hover:scale-105"
                            >
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-50">
                                <i data-lucide="package" class="w-16 h-16 text-gray-300"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="font-bold text-anchor-dark group-hover:text-vermilion transition-colors">
                                <?= e($related['name']) ?>
                            </h3>
                            <span class="text-xl font-bold text-vermilion">
                                $<?= number_format($related['price'], 0) ?>
                            </span>
                        </div>

                        <a href="/product/<?= e($related['slug']) ?>" class="btn btn-secondary w-full">
                            <i data-lucide="eye" class="w-4 h-4 mr-2"></i>
                            View Details
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Contact Section -->
<section class="py-16 bg-gradient-to-r from-vermilion to-orange-500 text-white">
    <div class="container text-center">
        <h2 class="text-3xl font-bold mb-4">Interested in this product?</h2>
        <p class="text-xl mb-8 text-white/90">
            Contact us for availability, custom configurations, or volume pricing.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="https://wa.me/<?= e($whatsappNumber) ?>?text=<?= $whatsappMessage ?>" 
               target="_blank" 
               class="btn bg-white text-vermilion hover:bg-gray-100">
                <i data-lucide="message-circle" class="w-5 h-5 mr-2"></i>
                Chat on WhatsApp
            </a>
            <a href="/contact" class="btn btn-outline border-white text-white hover:bg-white hover:text-vermilion">
                <i data-lucide="mail" class="w-5 h-5 mr-2"></i>
                Send Inquiry
            </a>
        </div>
    </div>
</section>