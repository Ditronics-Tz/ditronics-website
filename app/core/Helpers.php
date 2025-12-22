<?php
/**
 * Helper Functions
 * 
 * Common utility functions used throughout the application.
 */

declare(strict_types=1);

/**
 * Redirect to a URL
 */
function redirect(string $url, int $statusCode = 302): void
{
    header('Location: ' . $url, true, $statusCode);
    exit;
}

/**
 * Send JSON response
 */
function jsonResponse(mixed $data, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

/**
 * Check if request is AJAX
 */
function isAjaxRequest(): bool
{
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * Get JSON input from request body
 */
function getJsonInput(): array
{
    $input = file_get_contents('php://input');
    if (empty($input)) {
        return [];
    }
    $data = json_decode($input, true);
    return is_array($data) ? $data : [];
}

/**
 * Generate a URL-friendly slug
 */
function slugify(string $text): string
{
    // Convert to lowercase
    $text = strtolower($text);
    
    // Replace non-alphanumeric characters with hyphens
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    
    // Remove leading/trailing hyphens
    return trim($text, '-');
}

/**
 * Format price with currency
 */
function formatPrice(int $price, string $currency = 'TZS'): string
{
    return number_format($price) . ' ' . $currency;
}

/**
 * Format phone number for display
 */
function formatPhoneDisplay(string $phone): string
{
    if (str_starts_with($phone, '255')) {
        return '+' . substr($phone, 0, 3) . ' ' . substr($phone, 3, 3) . ' ' . substr($phone, 6);
    }
    return '+' . $phone;
}

/**
 * Sanitize input string
 */
function sanitize(string $input): string
{
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email address
 */
function isValidEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Get asset URL
 */
function asset(string $path): string
{
    return '/' . ltrim($path, '/');
}

/**
 * Get current URL path
 */
function currentPath(): string
{
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
}

/**
 * Check if current path matches
 */
function isCurrentPath(string $path): bool
{
    return currentPath() === $path;
}

/**
 * Check if current path starts with
 */
function pathStartsWith(string $prefix): bool
{
    return str_starts_with(currentPath(), $prefix);
}

/**
 * Get all settings as associative array
 */
function getSettings(): array
{
    $db = Database::getInstance();
    $settings = $db->fetchAll('SELECT key, value FROM settings');
    
    $result = [];
    foreach ($settings as $setting) {
        $result[$setting['key']] = $setting['value'];
    }
    return $result;
}

/**
 * Get a single setting value
 */
function getSetting(string $key, ?string $default = null): ?string
{
    $db = Database::getInstance();
    $result = $db->fetchColumn('SELECT value FROM settings WHERE key = ?', [$key]);
    return $result !== false ? $result : $default;
}

/**
 * Handle file upload
 */
function handleFileUpload(array $file, string $directory = 'uploads'): ?string
{
    if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] === 0) {
        return null;
    }

    // Check file size
    if ($file['size'] > MAX_UPLOAD_SIZE) {
        return null;
    }

    // Check file type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, ALLOWED_IMAGE_TYPES)) {
        return null;
    }

    // Sanitize and validate extension - only allow common image extensions
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($extension, $allowedExtensions)) {
        return null;
    }
    
    // Generate unique filename (ignores original filename to prevent injection)
    $filename = time() . '-' . bin2hex(random_bytes(8)) . '.' . $extension;

    // Ensure directory exists
    $uploadDir = PUBLIC_PATH . '/' . $directory;
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $targetPath = $uploadDir . '/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return '/' . $directory . '/' . $filename;
    }

    return null;
}

/**
 * Format date for display
 */
function formatDate(string $date, string $format = 'M d, Y'): string
{
    return date($format, strtotime($date));
}

/**
 * Format datetime for display
 */
function formatDateTime(string $datetime, string $format = 'M d, Y g:i A'): string
{
    return date($format, strtotime($datetime));
}

/**
 * Simple rate limiting
 */
function checkRateLimit(string $key = 'global'): bool
{
    $cacheFile = STORAGE_PATH . '/cache/rate_' . md5($key) . '.json';
    
    $now = time();
    $data = [];
    
    if (file_exists($cacheFile)) {
        $data = json_decode(file_get_contents($cacheFile), true) ?? [];
    }
    
    // Clean old entries
    $data = array_filter($data, fn($timestamp) => $timestamp > ($now - RATE_LIMIT_WINDOW));
    
    if (count($data) >= RATE_LIMIT_REQUESTS) {
        return false;
    }
    
    $data[] = $now;
    file_put_contents($cacheFile, json_encode($data));
    
    return true;
}

/**
 * Get client IP address
 */
function getClientIp(): string
{
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ips[0]);
    }
    return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
}
