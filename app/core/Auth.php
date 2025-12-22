<?php
/**
 * Authentication System
 * 
 * Session-based authentication with secure password hashing.
 * Choice: Sessions over JWT for simplicity and server-side control.
 */

declare(strict_types=1);

class Auth
{
    private const SESSION_KEY = 'admin_user';
    private const SESSION_AUTH_KEY = 'authenticated';

    /**
     * Attempt to login with credentials
     */
    public static function attempt(string $username, string $password): bool
    {
        $db = Database::getInstance();
        
        $user = $db->fetch(
            'SELECT id, username, password FROM admin_users WHERE username = ?',
            [$username]
        );

        if ($user === null) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        // Regenerate session ID to prevent session fixation
        session_regenerate_id(true);

        // Store user in session
        $_SESSION[self::SESSION_KEY] = [
            'id' => $user['id'],
            'username' => $user['username'],
        ];
        $_SESSION[self::SESSION_AUTH_KEY] = true;

        return true;
    }

    /**
     * Check if user is authenticated
     */
    public static function check(): bool
    {
        return isset($_SESSION[self::SESSION_AUTH_KEY]) 
            && $_SESSION[self::SESSION_AUTH_KEY] === true
            && isset($_SESSION[self::SESSION_KEY]);
    }

    /**
     * Get the authenticated user
     */
    public static function user(): ?array
    {
        if (!self::check()) {
            return null;
        }
        return $_SESSION[self::SESSION_KEY];
    }

    /**
     * Logout the current user
     */
    public static function logout(): void
    {
        // Unset session variables
        unset($_SESSION[self::SESSION_KEY]);
        unset($_SESSION[self::SESSION_AUTH_KEY]);

        // Regenerate session ID
        session_regenerate_id(true);
    }

    /**
     * Require authentication - redirect to login if not authenticated
     */
    public static function requireAuth(): void
    {
        if (!self::check()) {
            redirect('/admin/login');
            exit;
        }
    }

    /**
     * Require authentication for API requests - return 401 if not authenticated
     */
    public static function requireAuthApi(): void
    {
        if (!self::check()) {
            jsonResponse(['error' => 'Unauthorized'], 401);
            exit;
        }
    }

    /**
     * Hash a password
     */
    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
    }

    /**
     * Change user password
     */
    public static function changePassword(int $userId, string $newPassword): bool
    {
        $db = Database::getInstance();
        $hashedPassword = self::hashPassword($newPassword);
        
        return $db->update(
            'admin_users',
            ['password' => $hashedPassword],
            'id = ?',
            [$userId]
        ) > 0;
    }
}
