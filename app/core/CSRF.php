<?php
/**
 * CSRF Protection
 * 
 * Prevents Cross-Site Request Forgery attacks.
 */

declare(strict_types=1);

class CSRF
{
    private const TOKEN_LENGTH = 32;

    /**
     * Generate or get existing CSRF token
     */
    public static function getToken(): string
    {
        if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
            $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(self::TOKEN_LENGTH));
        }
        return $_SESSION[CSRF_TOKEN_NAME];
    }

    /**
     * Generate hidden input field with CSRF token
     */
    public static function field(): string
    {
        $token = self::getToken();
        return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    /**
     * Validate CSRF token from request
     */
    public static function validate(): bool
    {
        $token = $_POST[CSRF_TOKEN_NAME] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        
        if (empty($token) || !isset($_SESSION[CSRF_TOKEN_NAME])) {
            return false;
        }

        return hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
    }

    /**
     * Validate and throw error if invalid
     */
    public static function validateOrFail(): void
    {
        if (!self::validate()) {
            http_response_code(403);
            if (isAjaxRequest()) {
                jsonResponse(['error' => 'Invalid CSRF token'], 403);
            } else {
                die('Invalid CSRF token');
            }
            exit;
        }
    }

    /**
     * Regenerate CSRF token
     */
    public static function regenerate(): string
    {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(self::TOKEN_LENGTH));
        return $_SESSION[CSRF_TOKEN_NAME];
    }
}
