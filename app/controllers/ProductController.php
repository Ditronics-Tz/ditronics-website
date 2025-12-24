<?php
/**
 * Product Controller - All product pages with filtering
 * Handles all product categories from inventory API
 */

declare(strict_types=1);

class ProductController
{
    private const CATEGORIES = [
        'laptop' => 'Laptops',
        'desktop_pc' => 'Desktop PCs', 
        'server' => 'Servers',
        'mouse' => 'Mice',
        'keyboard' => 'Keyboards',
        'accessory' => 'Accessories'
    ];

    public function index(): void
    {
        // Get category filter from query params
        $category = $_GET['category'] ?? 'all';
        
        // Fetch products based on category
        if ($category === 'all') {
            $apiResponse = InventoryAPI::getAllProducts();
        } else {
            $apiResponse = InventoryAPI::getProductsByCategory($category);
        }
        
        if (!$apiResponse['success']) {
            // Fallback: show error page
            View::render('pages/products', [
                'title' => 'Products — Ditronics',
                'description' => 'Browse our selection of enterprise-ready technology products.',
                'products' => [],
                'categories' => self::CATEGORIES,
                'currentCategory' => $category,
                'error' => 'Unable to load products at the moment. Please try again later.',
            ]);
            return;
        }
        
        // Format products for display
        $products = array_map([InventoryAPI::class, 'formatProduct'], $apiResponse['data']);
        
        // Get category name for title
        $categoryName = self::CATEGORIES[$category] ?? 'All Products';

        View::render('pages/products', [
            'title' => $categoryName . ' — Ditronics',
            'description' => "Browse our selection of {$categoryName} configured for optimal performance.",
            'products' => $products,
            'categories' => self::CATEGORIES,
            'currentCategory' => $category,
            'categoryName' => $categoryName,
        ]);
    }

    public function category(string $category): void
    {
        // Redirect to main products page with category filter
        header("Location: /products?category={$category}");
        exit;
    }

    public function show(string $slug): void
    {
        // Find product by slug from inventory API
        $product = InventoryAPI::getProductBySlug($slug);

        if ($product === null) {
            http_response_code(404);
            View::render('pages/product-not-found', [
                'title' => 'Product Not Found — Ditronics',
            ]);
            return;
        }
        
        // Format product for display
        $product = InventoryAPI::formatProduct($product);

        // Get related products (same category, limit to 3)
        $apiResponse = InventoryAPI::getProductsByCategory($product['category']);
        $relatedProducts = [];
        
        if ($apiResponse['success']) {
            $allProducts = array_map([InventoryAPI::class, 'formatProduct'], $apiResponse['data']);
            
            // Filter related products (same category, different product)
            foreach ($allProducts as $otherProduct) {
                if ($otherProduct['id'] !== $product['id'] && count($relatedProducts) < 3) {
                    $relatedProducts[] = $otherProduct;
                }
            }
        }

        // Get settings for contact info
        $settings = getSettings();

        View::render('pages/product-detail', [
            'title' => $product['name'] . ' — Ditronics',
            'description' => $product['notes'] 
                ?: "{$product['name']} - {$product['brand']} {$product['model']}. Available at Ditronics.",
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'settings' => $settings,
            'categoryName' => self::CATEGORIES[$product['category']] ?? ucfirst($product['category']),
        ]);
    }

    // Legacy laptop routes (for backward compatibility)
    public function laptops(): void
    {
        header("Location: /products?category=laptop");
        exit;
    }

    public function laptopDetail(string $slug): void
    {
        header("Location: /product/{$slug}");
        exit;
    }
}