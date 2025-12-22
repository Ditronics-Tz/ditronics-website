<?php
/**
 * View Rendering System
 * 
 * Simple template system using output buffering.
 * No template engines - just PHP.
 */

declare(strict_types=1);

class View
{
    private static string $layout = 'main';
    private static array $sections = [];
    private static ?string $currentSection = null;

    /**
     * Render a view with optional layout
     */
    public static function render(string $view, array $data = [], ?string $layout = null): void
    {
        // Extract data to make available in view
        extract($data);

        // Capture the view content
        ob_start();
        $viewFile = APP_PATH . '/views/' . $view . '.php';
        
        if (!file_exists($viewFile)) {
            ob_end_clean();
            throw new RuntimeException("View not found: {$view}");
        }

        include $viewFile;
        $content = ob_get_clean();

        // If layout is explicitly set to false, just output the content
        if ($layout === false || $layout === 'none') {
            echo $content;
            return;
        }

        // Use the specified layout or default
        $layoutName = $layout ?? self::$layout;
        $layoutFile = APP_PATH . '/views/layouts/' . $layoutName . '.php';

        if (!file_exists($layoutFile)) {
            // No layout, just output content
            echo $content;
            return;
        }

        // Render with layout
        include $layoutFile;
    }

    /**
     * Render a partial view
     */
    public static function partial(string $partial, array $data = []): void
    {
        extract($data);
        
        $partialFile = APP_PATH . '/views/partials/' . $partial . '.php';
        
        if (file_exists($partialFile)) {
            include $partialFile;
        }
    }

    /**
     * Set the default layout
     */
    public static function setLayout(string $layout): void
    {
        self::$layout = $layout;
    }

    /**
     * Start a section
     */
    public static function section(string $name): void
    {
        self::$currentSection = $name;
        ob_start();
    }

    /**
     * End a section
     */
    public static function endSection(): void
    {
        if (self::$currentSection !== null) {
            self::$sections[self::$currentSection] = ob_get_clean();
            self::$currentSection = null;
        }
    }

    /**
     * Get section content
     */
    public static function getSection(string $name, string $default = ''): string
    {
        return self::$sections[$name] ?? $default;
    }

    /**
     * Check if section exists
     */
    public static function hasSection(string $name): bool
    {
        return isset(self::$sections[$name]);
    }

    /**
     * Escape HTML to prevent XSS
     */
    public static function escape(mixed $value): string
    {
        if ($value === null) {
            return '';
        }
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Alias for escape
     */
    public static function e(mixed $value): string
    {
        return self::escape($value);
    }
}

// Shorthand functions for views
function e(mixed $value): string
{
    return View::escape($value);
}

function partial(string $partial, array $data = []): void
{
    View::partial($partial, $data);
}
