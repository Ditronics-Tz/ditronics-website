<?php
/**
 * Application Configuration
 */

// Database configuration
define('DB_PATH', ROOT_PATH . '/data/ditronics.db');

// Site configuration
define('SITE_NAME', 'Ditronics');
define('SITE_TAGLINE', 'Optimize Your Tech');
define('SITE_URL', 'http://localhost:8000'); // Update in production

// Security
define('CSRF_TOKEN_NAME', 'csrf_token');
define('SESSION_LIFETIME', 60 * 60 * 24 * 7); // 1 week

// Upload settings
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);

// Default admin credentials (only used for initial setup)
define('DEFAULT_ADMIN_USERNAME', 'admin');
define('DEFAULT_ADMIN_PASSWORD', 'Ditronics@2036');

// Rate limiting (simple implementation)
define('RATE_LIMIT_REQUESTS', 100);
define('RATE_LIMIT_WINDOW', 60); // seconds
