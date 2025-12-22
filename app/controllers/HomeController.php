<?php
/**
 * Home Controller
 */

declare(strict_types=1);

class HomeController
{
    public function index(): void
    {
        $db = Database::getInstance();
        
        // Get featured laptops for potential use
        $featuredLaptops = $db->fetchAll(
            'SELECT * FROM laptops WHERE featured = 1 ORDER BY created_at DESC LIMIT 3'
        );

        // Get settings
        $settings = getSettings();

        View::render('pages/home', [
            'title' => SITE_NAME . ' — ' . SITE_TAGLINE,
            'featuredLaptops' => $featuredLaptops,
            'settings' => $settings,
        ]);
    }
}
