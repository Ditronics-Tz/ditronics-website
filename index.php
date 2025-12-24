<?php
/**
 * Ditronics CMS - Single Entry Point
 * 
 * All requests are routed through this file.
 * No frameworks, no magic - just clean PHP.
 */

declare(strict_types=1);

// Environment detection - only enable error display in development
$isProduction = getenv('APP_ENV') === 'production' || 
                (isset($_SERVER['HTTP_HOST']) && !preg_match('/^(localhost|127\.0\.0\.1|.*\.local)/', $_SERVER['HTTP_HOST']));

if ($isProduction) {
    error_reporting(0);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

// Define base paths
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define('STORAGE_PATH', ROOT_PATH . '/storage');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// Start session
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'cookie_samesite' => 'Strict',
    'use_strict_mode' => true,
]);

// Autoload core files
require_once APP_PATH . '/config/config.php';
require_once APP_PATH . '/core/Database.php';
require_once APP_PATH . '/core/Router.php';
require_once APP_PATH . '/core/Auth.php';
require_once APP_PATH . '/core/CSRF.php';
require_once APP_PATH . '/core/View.php';
require_once APP_PATH . '/core/Helpers.php';
require_once APP_PATH . '/core/InventoryAPI.php';

// Initialize database connection
$db = Database::getInstance();

// Initialize router and define routes
$router = new Router();

// Public routes
$router->get('/', 'HomeController@index');
$router->get('/services', 'PageController@services');
$router->get('/studio', 'PageController@studio');
$router->get('/contact', 'PageController@contact');
$router->post('/contact', 'PageController@submitContact');
$router->get('/products', 'ProductController@index');
$router->get('/products/{category}', 'ProductController@category');
$router->get('/product/{slug}', 'ProductController@show');

// Legacy laptop routes (redirect to products)
$router->get('/laptops', 'ProductController@laptops');
$router->get('/laptops/{slug}', 'ProductController@laptopDetail');

// Auth routes
$router->get('/admin/login', 'AuthController@loginForm');
$router->post('/admin/login', 'AuthController@login');
$router->post('/admin/logout', 'AuthController@logout');

// Admin routes (protected)
$router->get('/admin', 'AdminController@dashboard');
$router->get('/api/laptops', 'AdminController@getLaptops');
$router->post('/api/laptops', 'AdminController@createLaptop');
$router->put('/api/laptops', 'AdminController@updateLaptop');
$router->delete('/api/laptops', 'AdminController@deleteLaptop');
$router->get('/api/settings', 'AdminController@getSettings');
$router->put('/api/settings', 'AdminController@updateSettings');
$router->get('/api/inquiries', 'AdminController@getInquiries');
$router->put('/api/inquiries', 'AdminController@updateInquiry');
$router->delete('/api/inquiries', 'AdminController@deleteInquiry');

// Dispatch the request
$router->dispatch();