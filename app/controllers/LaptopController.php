<?php
/**
 * Laptop Controller - Public laptop pages
 */

declare(strict_types=1);

class LaptopController
{
    public function index(): void
    {
        $db = Database::getInstance();
        
        $laptops = $db->fetchAll(
            'SELECT * FROM laptops ORDER BY created_at DESC'
        );

        View::render('pages/laptops', [
            'title' => 'Laptops — Ditronics',
            'description' => 'Browse our selection of enterprise-ready laptops configured for optimal performance.',
            'laptops' => $laptops,
        ]);
    }

    public function show(string $slug): void
    {
        $db = Database::getInstance();
        
        $laptop = $db->fetch(
            'SELECT * FROM laptops WHERE slug = ?',
            [$slug]
        );

        if ($laptop === null) {
            http_response_code(404);
            View::render('pages/laptop-not-found', [
                'title' => 'Laptop Not Found — Ditronics',
            ]);
            return;
        }

        // Get related laptops (same brand or similar price range)
        $relatedLaptops = $db->fetchAll(
            'SELECT * FROM laptops 
             WHERE id != ? 
             AND (brand = ? OR (price >= ? AND price <= ?))
             ORDER BY created_at DESC
             LIMIT 3',
            [
                $laptop['id'],
                $laptop['brand'] ?? '',
                (int)($laptop['price'] * 0.7),
                (int)($laptop['price'] * 1.3),
            ]
        );

        // Get settings for contact info
        $settings = getSettings();

        View::render('pages/laptop-detail', [
            'title' => $laptop['name'] . ' — Ditronics',
            'description' => $laptop['description'] 
                ?: "{$laptop['name']} - {$laptop['cpu']}, {$laptop['ram']}, {$laptop['storage']}. Available at Ditronics.",
            'laptop' => $laptop,
            'relatedLaptops' => $relatedLaptops,
            'settings' => $settings,
        ]);
    }
}
