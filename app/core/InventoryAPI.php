<?php
/**
 * Inventory API Service
 * 
 * Handles communication with the external inventory API
 * at inventory.ditronics.co.tz
 */

class InventoryAPI
{
    private const BASE_URL = 'http://127.0.0.1:3009/api/v1';
    private const TIMEOUT = 10;
    
    /**
     * Fetch all products from inventory API
     */
    public static function getAllProducts(): array
    {
        return self::makeRequest('/products');
    }
    
    /**
     * Fetch products by category (laptop, desktop_pc, server, etc.)
     */
    public static function getProductsByCategory(string $category): array
    {
        return self::makeRequest("/products/{$category}");
    }
    
    /**
     * Fetch laptops only
     */
    public static function getLaptops(): array
    {
        return self::getProductsByCategory('laptop');
    }
    
    /**
     * Find a product by ID
     */
    public static function getProductById(string $id): ?array
    {
        $products = self::getAllProducts();
        
        if (!$products['success']) {
            return null;
        }
        
        foreach ($products['data'] as $product) {
            if ($product['id'] === $id) {
                return $product;
            }
        }
        
        return null;
    }
    
    /**
     * Find a product by slug (generated from name)
     */
    public static function getProductBySlug(string $slug): ?array
    {
        $products = self::getAllProducts();
        
        if (!$products['success']) {
            return null;
        }
        
        foreach ($products['data'] as $product) {
            $productSlug = self::generateSlug($product['name']);
            if ($productSlug === $slug) {
                return $product;
            }
        }
        
        return null;
    }
    
    /**
     * Generate URL-friendly slug from product name
     */
    public static function generateSlug(string $name): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));
    }
    
    /**
     * Make HTTP request to inventory API
     */
    private static function makeRequest(string $endpoint): array
    {
        $url = self::BASE_URL . $endpoint;
        
        // Initialize cURL
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => self::TIMEOUT,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'User-Agent: Ditronics-CMS/1.0'
            ],
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        // Handle cURL errors
        if ($response === false || !empty($error)) {
            error_log("Inventory API cURL error: " . $error);
            return [
                'success' => false,
                'error' => 'Failed to connect to inventory API',
                'data' => []
            ];
        }
        
        // Handle HTTP errors
        if ($httpCode !== 200) {
            error_log("Inventory API HTTP error: " . $httpCode);
            return [
                'success' => false,
                'error' => "API returned HTTP {$httpCode}",
                'data' => []
            ];
        }
        
        // Parse JSON response
        $data = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("Inventory API JSON error: " . json_last_error_msg());
            return [
                'success' => false,
                'error' => 'Invalid JSON response from API',
                'data' => []
            ];
        }
        
        return $data;
    }
    
    /**
     * Format product for display in views
     */
    public static function formatProduct(array $product): array
    {
        return [
            'id' => $product['id'],
            'name' => $product['name'],
            'brand' => $product['brand'],
            'model' => $product['model'],
            'category' => $product['category'],
            'condition' => $product['condition'],
            'status' => $product['status'],
            'price' => $product['purchase_price'],
            'slug' => self::generateSlug($product['name']),
            'image' => !empty($product['images']) ? $product['images'][0]['url'] : null,
            'images' => $product['images'],
            'specifications' => $product['specifications'] ?? [],
            'notes' => $product['notes'] ?? '',
            'created_at' => $product['created_at'],
            'updated_at' => $product['updated_at']
        ];
    }
}