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

$categoryIcons = [
    'laptop' => 'laptop',
    'desktop_pc' => 'pc-case',
    'server' => 'server',
    'mouse' => 'mouse-pointer-2',
    'keyboard' => 'keyboard',
    'accessory' => 'package'
];
?>

<!-- Hero Section -->
<section class="py-20 bg-gradient-hero">
    <div class="container">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="mb-6"><?= e($categoryName ?? 'All Products') ?> Catalog</h1>
            <p class="text-xl text-neutral-text">
                Enterprise-ready technology products configured for optimal performance.
                Browse our selection and find the perfect solution for your needs.
            </p>
        </div>
    </div>
</section>

<!-- Category Filter Pills -->
<section class="py-8 bg-white border-b border-gray-200">
    <div class="container">
        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="/products" 
               class="btn <?= ($currentCategory === 'all') ? 'btn-primary' : 'btn-outline' ?> btn-sm">
                All Products
            </a>
            <?php foreach ($categories as $key => $name): ?>
                <a href="/products?category=<?= e($key) ?>" 
                   class="btn <?= ($currentCategory === $key) ? 'btn-primary' : 'btn-outline' ?> btn-sm">
                    <i data-lucide="<?= e($categoryIcons[$key] ?? 'package') ?>" class="w-4 h-4 mr-2"></i>
                    <?= e($name) ?>
                </a>
            <?php endforeach; ?>
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
                        id="product-search"
                        placeholder="Search products..."
                        class="h-10 w-64 rounded-lg border border-gray-200 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-vermilion"
                    >
                </div>
                
                <!-- Sort -->
                <select id="sort-products" class="h-10 rounded-lg border border-gray-200 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-vermilion">
                    <option value="name">Sort by Name</option>
                    <option value="price-low">Price: Low to High</option>
                    <option value="price-high">Price: High to Low</option>
                    <option value="brand">Brand A-Z</option>
                </select>
            </div>

            <p class="text-sm text-neutral-text">
                <span id="product-count"><?= count($products) ?></span> product<?= count($products) !== 1 ? 's' : '' ?> found
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

                    <!-- Status Filter -->
                    <div class="mb-6">
                        <h4 class="font-medium text-anchor-dark mb-3">Availability</h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="filter-status form-checkbox" value="available">
                                <span class="text-sm text-neutral-text">Available</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="filter-status form-checkbox" value="reserved">
                                <span class="text-sm text-neutral-text">Reserved</span>
                            </label>
                        </div>
                    </div>

                    <!-- Condition Filter -->
                    <div class="mb-6">
                        <h4 class="font-medium text-anchor-dark mb-3">Condition</h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="filter-condition form-checkbox" value="new_condition">
                                <span class="text-sm text-neutral-text">New</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="filter-condition form-checkbox" value="used">
                                <span class="text-sm text-neutral-text">Used</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="filter-condition form-checkbox" value="refurbished">
                                <span class="text-sm text-neutral-text">Refurbished</span>
                            </label>
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div class="mb-6">
                        <h4 class="font-medium text-anchor-dark mb-3">Price Range</h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="priceRange" class="filter-price form-checkbox" value="0-500">
                                <span class="text-sm text-neutral-text">Under $500</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="priceRange" class="filter-price form-checkbox" value="500-1000">
                                <span class="text-sm text-neutral-text">$500 - $1,000</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="priceRange" class="filter-price form-checkbox" value="1000-2000">
                                <span class="text-sm text-neutral-text">$1,000 - $2,000</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="priceRange" class="filter-price form-checkbox" value="2000-999999">
                                <span class="text-sm text-neutral-text">Over $2,000</span>
                            </label>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="flex-1">
                <?php if (isset($error)): ?>
                    <div class="text-center py-20">
                        <i data-lucide="wifi-off" class="w-16 h-16 text-red-300 mx-auto mb-4"></i>
                        <p class="text-red-600 mb-4"><?= e($error) ?></p>
                        <button onclick="window.location.reload()" class="btn btn-primary">Try Again</button>
                    </div>
                <?php elseif (empty($products)): ?>
                    <div class="text-center py-20">
                        <i data-lucide="package" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                        <p class="text-neutral-text mb-4">No products available yet.</p>
                        <a href="/contact" class="btn btn-primary">Contact Us</a>
                    </div>
                <?php else: ?>
                    <div id="products-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($products as $product): ?>
                            <div class="product-card card group" 
                                 data-name="<?= e(strtolower($product['name'])) ?>"
                                 data-brand="<?= e(strtolower($product['brand'] ?? '')) ?>"
                                 data-model="<?= e(strtolower($product['model'] ?? '')) ?>"
                                 data-category="<?= e($product['category']) ?>"
                                 data-price="<?= (int)$product['price'] ?>"
                                 data-condition="<?= e($product['condition']) ?>"
                                 data-status="<?= e($product['status']) ?>">
                                <!-- Image -->
                                <div class="relative aspect-[4/3] bg-gray-50 overflow-hidden">
                                    <?php if (!empty($product['image'])): ?>
                                        <img
                                            src="<?= e($product['image']) ?>"
                                            alt="<?= e($product['name']) ?>"
                                            class="w-full h-full object-contain p-4 transition-transform duration-500 group-hover:scale-105"
                                        >
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-50">
                                            <i data-lucide="<?= e($categoryIcons[$product['category']] ?? 'package') ?>" class="w-16 h-16 text-gray-300"></i>
                                        </div>
                                    <?php endif; ?>
                                    <span class="badge <?= $stockStatusVariant[$product['status']] ?? 'badge-muted' ?> absolute top-4 right-4">
                                        <?= e(ucfirst($product['status'])) ?>
                                    </span>
                                    <span class="badge badge-outline absolute top-4 left-4">
                                        <?= e($conditionVariant[$product['condition']] ?? ucfirst($product['condition'])) ?>
                                    </span>
                                </div>

                                <div class="p-6">
                                    <!-- Category & Brand -->
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs text-vermilion font-medium uppercase tracking-wider">
                                            <?= e($categories[$product['category']] ?? ucfirst($product['category'])) ?>
                                        </span>
                                        <?php if (!empty($product['brand'])): ?>
                                            <span class="text-xs text-gray-400">•</span>
                                            <span class="text-xs text-gray-600"><?= e($product['brand']) ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Title & Price -->
                                    <div class="flex items-start justify-between mb-4">
                                        <h3 class="font-bold text-anchor-dark group-hover:text-vermilion transition-colors leading-tight">
                                            <?= e($product['name']) ?>
                                        </h3>
                                        <span class="text-xl font-bold text-vermilion ml-2">
                                            $<?= number_format($product['price'], 0) ?>
                                        </span>
                                    </div>

                                    <!-- Key Specs (category specific) -->
                                    <div class="mb-6">
                                        <?php if ($product['category'] === 'laptop'): ?>
                                            <div class="grid grid-cols-2 gap-2 text-sm text-neutral-text">
                                                <div><?= e($product['specifications']['cpu'] ?? 'N/A') ?></div>
                                                <div><?= e($product['specifications']['ram_size'] ?? 'N/A') ?></div>
                                            </div>
                                        <?php elseif ($product['category'] === 'desktop_pc'): ?>
                                            <div class="grid grid-cols-2 gap-2 text-sm text-neutral-text">
                                                <div><?= e($product['specifications']['cpu'] ?? 'N/A') ?></div>
                                                <div><?= e($product['specifications']['form_factor'] ?? 'N/A') ?></div>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-sm text-neutral-text line-clamp-2">
                                                <?= e($product['notes'] ?: $product['model']) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- CTA -->
                                    <a href="/product/<?= e($product['slug']) ?>" class="btn btn-secondary w-full">
                                        <i data-lucide="eye" class="w-4 h-4 mr-2"></i>
                                        View Details
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div id="no-results" class="text-center py-20 hidden">
                        <p class="text-neutral-text mb-4">No products match your filters.</p>
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
                Our team can help you find the perfect product for your specific
                needs. We offer custom configurations and enterprise volume
                pricing.
            </p>
            <a href="/contact" class="btn btn-primary">Contact Us</a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('product-search');
    const sortSelect = document.getElementById('sort-products');
    const productCards = document.querySelectorAll('.product-card');
    const productsGrid = document.getElementById('products-grid');
    const noResults = document.getElementById('no-results');
    const productCount = document.getElementById('product-count');
    const clearFiltersBtn = document.getElementById('clear-filters');
    
    function filterAndSort() {
        let visibleCards = Array.from(productCards);
        
        // Search filter
        const searchTerm = searchInput.value.toLowerCase();
        if (searchTerm) {
            visibleCards = visibleCards.filter(card => {
                const name = card.dataset.name || '';
                const brand = card.dataset.brand || '';
                const model = card.dataset.model || '';
                return name.includes(searchTerm) || brand.includes(searchTerm) || model.includes(searchTerm);
            });
        }
        
        // Status filter
        const checkedStatuses = Array.from(document.querySelectorAll('.filter-status:checked')).map(cb => cb.value);
        if (checkedStatuses.length > 0) {
            visibleCards = visibleCards.filter(card => checkedStatuses.includes(card.dataset.status));
        }
        
        // Condition filter
        const checkedConditions = Array.from(document.querySelectorAll('.filter-condition:checked')).map(cb => cb.value);
        if (checkedConditions.length > 0) {
            visibleCards = visibleCards.filter(card => checkedConditions.includes(card.dataset.condition));
        }
        
        // Price filter
        const checkedPrice = document.querySelector('.filter-price:checked');
        if (checkedPrice) {
            const [min, max] = checkedPrice.value.split('-').map(Number);
            visibleCards = visibleCards.filter(card => {
                const price = parseInt(card.dataset.price);
                return price >= min && price <= max;
            });
        }
        
        // Sort
        const sortBy = sortSelect.value;
        visibleCards.sort((a, b) => {
            switch (sortBy) {
                case 'name':
                    return a.dataset.name.localeCompare(b.dataset.name);
                case 'price-low':
                    return parseInt(a.dataset.price) - parseInt(b.dataset.price);
                case 'price-high':
                    return parseInt(b.dataset.price) - parseInt(a.dataset.price);
                case 'brand':
                    return (a.dataset.brand || '').localeCompare(b.dataset.brand || '');
                default:
                    return 0;
            }
        });
        
        // Show/hide cards
        productCards.forEach(card => card.style.display = 'none');
        visibleCards.forEach(card => card.style.display = 'block');
        
        // Update count and no results message
        productCount.textContent = visibleCards.length;
        if (visibleCards.length === 0) {
            productsGrid.style.display = 'none';
            noResults.style.display = 'block';
        } else {
            productsGrid.style.display = 'grid';
            noResults.style.display = 'none';
        }
        
        // Show/hide clear filters button
        const hasFilters = searchTerm || checkedStatuses.length > 0 || checkedConditions.length > 0 || checkedPrice;
        clearFiltersBtn.style.display = hasFilters ? 'block' : 'none';
    }
    
    // Event listeners
    searchInput.addEventListener('input', filterAndSort);
    sortSelect.addEventListener('change', filterAndSort);
    
    document.querySelectorAll('.filter-status, .filter-condition, .filter-price').forEach(filter => {
        filter.addEventListener('change', filterAndSort);
    });
    
    // Clear filters
    function clearFilters() {
        searchInput.value = '';
        document.querySelectorAll('.filter-status:checked, .filter-condition:checked, .filter-price:checked').forEach(cb => {
            cb.checked = false;
        });
        sortSelect.value = 'name';
        filterAndSort();
    }
    
    clearFiltersBtn.addEventListener('click', clearFilters);
    document.getElementById('clear-filters-btn').addEventListener('click', clearFilters);
});
</script>