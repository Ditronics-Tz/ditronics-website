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
?>

<!-- Hero Section -->
<section class="py-20 bg-gradient-hero">
    <div class="container">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="mb-6">Laptop Catalog</h1>
            <p class="text-xl text-neutral-text">
                Enterprise-ready laptops configured for optimal performance.
                Browse our selection and find the perfect machine for your needs.
            </p>
        </div>
    </div>
</section>

<!-- Filters & Grid -->
<section class="py-12 bg-white">
    <div class="container">
        <!-- Filter Bar -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <!-- Search -->
                <div class="relative">
                    <input
                        type="text"
                        id="laptop-search"
                        placeholder="Search laptops..."
                        class="h-10 w-64 rounded-lg border border-gray-200 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-vermilion"
                    >
                </div>
            </div>

            <p class="text-sm text-neutral-text">
                <span id="laptop-count"><?= count($laptops) ?></span> laptop<?= count($laptops) !== 1 ? 's' : '' ?> found
            </p>
        </div>

        <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="md:w-64 flex-shrink-0 hidden md:block">
                <div class="bg-off-white rounded-lg p-6 sticky top-24">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-semibold text-anchor-dark">Filters</h3>
                        <button id="clear-filters" class="btn btn-ghost btn-sm text-sm hidden">Clear all</button>
                    </div>

                    <!-- Stock Status -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-anchor-dark mb-3">Availability</h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="filter-stock form-checkbox" value="In Stock">
                                <span class="text-sm text-neutral-text">In Stock</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="filter-stock form-checkbox" value="Limited">
                                <span class="text-sm text-neutral-text">Limited</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="filter-stock form-checkbox" value="Out of Stock">
                                <span class="text-sm text-neutral-text">Out of Stock</span>
                            </label>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-anchor-dark mb-3">Price Range</h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="priceRange" class="filter-price form-checkbox" value="">
                                <span class="text-sm text-neutral-text">All Prices</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="priceRange" class="filter-price form-checkbox" value="0-1500000">
                                <span class="text-sm text-neutral-text">Under 1,500,000 TZS</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="priceRange" class="filter-price form-checkbox" value="1500000-3000000">
                                <span class="text-sm text-neutral-text">1,500,000 - 3,000,000 TZS</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="priceRange" class="filter-price form-checkbox" value="3000000-100000000">
                                <span class="text-sm text-neutral-text">Over 3,000,000 TZS</span>
                            </label>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Laptops Grid -->
            <div class="flex-1">
                <?php if (empty($laptops)): ?>
                    <div class="text-center py-20">
                        <i data-lucide="laptop" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                        <p class="text-neutral-text mb-4">No laptops available yet.</p>
                        <a href="/contact" class="btn btn-primary">Contact Us</a>
                    </div>
                <?php else: ?>
                    <div id="laptops-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($laptops as $laptop): ?>
                            <div class="laptop-card card group" 
                                 data-name="<?= e(strtolower($laptop['name'])) ?>"
                                 data-brand="<?= e(strtolower($laptop['brand'] ?? '')) ?>"
                                 data-model="<?= e(strtolower($laptop['model'] ?? '')) ?>"
                                 data-cpu="<?= e(strtolower($laptop['specifications']['cpu'] ?? '')) ?>"
                                 data-gpu="<?= e(strtolower($laptop['specifications']['gpu'] ?? '')) ?>"
                                 data-price="<?= (int)$laptop['price'] ?>"
                                 data-condition="<?= e($laptop['condition']) ?>"
                                 data-status="<?= e($laptop['status']) ?>">
                                <!-- Image -->
                                <div class="relative aspect-[4/3] bg-gray-50 overflow-hidden">
                                    <?php if (!empty($laptop['image'])): ?>
                                        <img
                                            src="<?= e($laptop['image']) ?>"
                                            alt="<?= e($laptop['name']) ?>"
                                            class="w-full h-full object-contain p-4 transition-transform duration-500 group-hover:scale-105"
                                        >
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-50">
                                            <i data-lucide="monitor" class="w-16 h-16 text-gray-300"></i>
                                        </div>
                                    <?php endif; ?>
                                    <span class="badge <?= $stockStatusVariant[$laptop['status']] ?? 'badge-muted' ?> absolute top-4 right-4">
                                        <?= e(ucfirst($laptop['status'])) ?>
                                    </span>
                                    <span class="badge badge-outline absolute top-4 left-4">
                                        <?= e($conditionVariant[$laptop['condition']] ?? ucfirst($laptop['condition'])) ?>
                                    </span>
                                </div>

                                <div class="p-6">
                                    <!-- Title & Price -->
                                    <div class="flex items-start justify-between mb-4">
                                        <h3 class="font-bold text-anchor-dark group-hover:text-vermilion transition-colors">
                                            <?= e($laptop['name']) ?>
                                        </h3>
                                        <span class="text-xl font-bold text-vermilion">
                                            $<?= number_format($laptop['price'], 0) ?>
                                        </span>
                                    </div>

                                    <!-- Specs -->
                                    <div class="grid grid-cols-2 gap-3 mb-6">
                                        <div class="flex items-center gap-2 text-sm text-neutral-text">
                                            <i data-lucide="cpu" class="w-4 h-4 text-anchor-dark"></i>
                                            <span class="truncate"><?= e($laptop['specifications']['cpu'] ?? 'N/A') ?></span>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-neutral-text">
                                            <i data-lucide="memory-stick" class="w-4 h-4 text-anchor-dark"></i>
                                            <span><?= e($laptop['specifications']['ram_size'] ?? 'N/A') ?></span>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-neutral-text">
                                            <i data-lucide="hard-drive" class="w-4 h-4 text-anchor-dark"></i>
                                            <span><?= e($laptop['specifications']['storage_capacity'] ?? 'N/A') ?> <?= e($laptop['specifications']['storage_type'] ?? '') ?></span>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-neutral-text">
                                            <i data-lucide="monitor" class="w-4 h-4 text-anchor-dark"></i>
                                            <span class="truncate"><?= e($laptop['specifications']['gpu'] ?? 'N/A') ?></span>
                                        </div>
                                    </div>

                                    <!-- CTA -->
                                    <a href="/laptops/<?= e($laptop['slug']) ?>" class="btn btn-secondary w-full">
                                        <i data-lucide="eye" class="w-4 h-4 mr-2"></i>
                                        View Details
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div id="no-results" class="text-center py-20 hidden">
                        <p class="text-neutral-text mb-4">No laptops match your filters.</p>
                        <button id="clear-filters-btn" class="btn btn-outline">Clear Filters</button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Info Section -->
<section class="py-16 bg-off-white">
    <div class="container">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="mb-4">Need Help Choosing?</h2>
            <p class="text-neutral-text mb-6">
                Our team can help you find the perfect laptop for your specific
                needs. We offer custom configurations and enterprise volume
                pricing.
            </p>
            <a href="/contact" class="btn btn-primary">Contact Us</a>
        </div>
    </div>
</section>

<style>
.space-y-2 > * + * { margin-top: 0.5rem; }
.focus\:ring-vermilion:focus { box-shadow: 0 0 0 2px var(--vermilion); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('laptop-search');
    const stockFilters = document.querySelectorAll('.filter-stock');
    const priceFilters = document.querySelectorAll('.filter-price');
    const laptopCards = document.querySelectorAll('.laptop-card');
    const laptopCount = document.getElementById('laptop-count');
    const noResults = document.getElementById('no-results');
    const laptopsGrid = document.getElementById('laptops-grid');
    const clearBtn = document.getElementById('clear-filters');
    const clearBtn2 = document.getElementById('clear-filters-btn');

    function filterLaptops() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedStock = Array.from(stockFilters)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
        const selectedPrice = document.querySelector('.filter-price:checked')?.value || '';
        
        let visibleCount = 0;

        laptopCards.forEach(card => {
            const name = card.dataset.name;
            const cpu = card.dataset.cpu;
            const gpu = card.dataset.gpu;
            const price = parseInt(card.dataset.price);
            const stock = card.dataset.stock;

            let show = true;

            // Search filter
            if (searchTerm && !name.includes(searchTerm) && !cpu.includes(searchTerm) && !gpu.includes(searchTerm)) {
                show = false;
            }

            // Stock filter
            if (selectedStock.length > 0 && !selectedStock.includes(stock)) {
                show = false;
            }

            // Price filter
            if (selectedPrice) {
                const [min, max] = selectedPrice.split('-').map(Number);
                if (price < min || price > max) {
                    show = false;
                }
            }

            card.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });

        laptopCount.textContent = visibleCount;
        
        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
            laptopsGrid.classList.add('hidden');
        } else {
            noResults.classList.add('hidden');
            laptopsGrid.classList.remove('hidden');
        }

        // Show/hide clear button
        const hasFilters = searchTerm || selectedStock.length > 0 || selectedPrice;
        if (clearBtn) clearBtn.classList.toggle('hidden', !hasFilters);
    }

    function clearFilters() {
        searchInput.value = '';
        stockFilters.forEach(cb => cb.checked = false);
        priceFilters.forEach(cb => cb.checked = false);
        filterLaptops();
    }

    searchInput?.addEventListener('input', filterLaptops);
    stockFilters.forEach(cb => cb.addEventListener('change', filterLaptops));
    priceFilters.forEach(cb => cb.addEventListener('change', filterLaptops));
    clearBtn?.addEventListener('click', clearFilters);
    clearBtn2?.addEventListener('click', clearFilters);

    // Re-initialize icons after page load
    lucide.createIcons();
});
</script>
