<?php
/**
 * Laptop Controller - Public laptop pages
 * Updated to use external Inventory API
 */

declare(strict_types=1);

class LaptopController
{
    public function index(): void
    {
        // Fetch laptops from inventory API
        $apiResponse = InventoryAPI::getLaptops();
        
        if (!$apiResponse['success']) {
            // Fallback: show error page or empty state
            View::render('pages/laptops', [
                'title' => 'Laptops — Ditronics',
                'description' => 'Browse our selection of enterprise-ready laptops configured for optimal performance.',
                'laptops' => [],
                'error' => 'Unable to load laptops at the moment. Please try again later.',
            ]);
            return;
        }
        
        // Format laptops for display
        $laptops = array_map([InventoryAPI::class, 'formatProduct'], $apiResponse['data']);

        View::render('pages/laptops', [
            'title' => 'Laptops — Ditronics',
            'description' => 'Browse our selection of enterprise-ready laptops configured for optimal performance.',
            'laptops' => $laptops,
        ]);
    }

    public function show(string $slug): void
    {
        // Find laptop by slug from inventory API
        $laptop = InventoryAPI::getProductBySlug($slug);

        if ($laptop === null) {
            http_response_code(404);
            View::render('pages/laptop-not-found', [
                'title' => 'Laptop Not Found — Ditronics',
            ]);
            return;
        }
        
        // Only show if it's actually a laptop
        if ($laptop['category'] !== 'laptop') {
            http_response_code(404);
            View::render('pages/laptop-not-found', [
                'title' => 'Laptop Not Found — Ditronics',
            ]);
            return;
        }
        
        // Format laptop for display
        $laptop = InventoryAPI::formatProduct($laptop);

        // Get related laptops (same brand, limit to 3)
        $apiResponse = InventoryAPI::getLaptops();
        $relatedLaptops = [];
        
        if ($apiResponse['success']) {
            $allLaptops = array_map([InventoryAPI::class, 'formatProduct'], $apiResponse['data']);
            
            // Filter related laptops (same brand, different product)
            foreach ($allLaptops as $otherLaptop) {
                if ($otherLaptop['id'] !== $laptop['id'] && 
                    $otherLaptop['brand'] === $laptop['brand'] && 
                    count($relatedLaptops) < 3) {
                    $relatedLaptops[] = $otherLaptop;
                }
            }
            
            // If not enough same-brand laptops, add other laptops
            if (count($relatedLaptops) < 3) {
                foreach ($allLaptops as $otherLaptop) {
                    if ($otherLaptop['id'] !== $laptop['id'] && 
                        !in_array($otherLaptop, $relatedLaptops) && 
                        count($relatedLaptops) < 3) {
                        $relatedLaptops[] = $otherLaptop;
                    }
                }
            }
        }

        // Get settings for contact info
        $settings = getSettings();

        View::render('pages/laptop-detail', [
            'title' => $laptop['name'] . ' — Ditronics',
            'description' => $laptop['notes'] 
                ?: "{$laptop['name']} - {$laptop['brand']} {$laptop['model']}. Available at Ditronics.",
            'laptop' => $laptop,
            'relatedLaptops' => $relatedLaptops,
            'settings' => $settings,
        ]);
    }
}
