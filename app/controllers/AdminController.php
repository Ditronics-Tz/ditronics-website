<?php
/**
 * Admin Controller - Dashboard and API endpoints
 */

declare(strict_types=1);

class AdminController
{
    public function __construct()
    {
        // All methods in this controller require authentication
        // API methods will check in each method for proper response
    }

    public function dashboard(): void
    {
        Auth::requireAuth();

        $db = Database::getInstance();
        
        $laptops = $db->fetchAll('SELECT * FROM laptops ORDER BY created_at DESC');
        $settings = getSettings();
        $inquiries = $db->fetchAll('SELECT * FROM contact_inquiries ORDER BY created_at DESC');
        
        // Count stats
        $totalLaptops = count($laptops);
        $inStock = count(array_filter($laptops, fn($l) => $l['stock_status'] === 'In Stock'));
        $featured = count(array_filter($laptops, fn($l) => $l['featured']));
        $unreadInquiries = count(array_filter($inquiries, fn($i) => $i['status'] === 'new'));

        View::render('admin/dashboard', [
            'title' => 'Admin Dashboard — Ditronics',
            'laptops' => $laptops,
            'settings' => $settings,
            'inquiries' => $inquiries,
            'stats' => [
                'totalLaptops' => $totalLaptops,
                'inStock' => $inStock,
                'featured' => $featured,
                'unreadInquiries' => $unreadInquiries,
            ],
            'csrfToken' => CSRF::getToken(),
        ], 'admin');
    }

    // === LAPTOP API ===

    public function getLaptops(): void
    {
        Auth::requireAuthApi();

        $db = Database::getInstance();
        $laptops = $db->fetchAll('SELECT * FROM laptops ORDER BY created_at DESC');
        
        jsonResponse($laptops);
    }

    public function createLaptop(): void
    {
        Auth::requireAuthApi();

        $name = sanitize($_POST['name'] ?? '');
        if (empty($name)) {
            jsonResponse(['error' => 'Name is required'], 400);
            return;
        }

        $slug = slugify($name);
        $price = (int)($_POST['price'] ?? 0);
        
        // Handle image upload
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = handleFileUpload($_FILES['image'], 'uploads/laptops') ?? '';
        }

        $data = [
            'name' => $name,
            'slug' => $slug,
            'price' => $price,
            'currency' => sanitize($_POST['currency'] ?? 'TZS'),
            'cpu' => sanitize($_POST['cpu'] ?? ''),
            'ram' => sanitize($_POST['ram'] ?? ''),
            'storage' => sanitize($_POST['storage'] ?? ''),
            'gpu' => sanitize($_POST['gpu'] ?? ''),
            'display' => sanitize($_POST['display'] ?? ''),
            'battery' => sanitize($_POST['battery'] ?? ''),
            'image' => $imagePath,
            'stock_status' => sanitize($_POST['stock_status'] ?? 'In Stock'),
            'condition' => sanitize($_POST['condition'] ?? 'Brand New'),
            'notes' => sanitize($_POST['notes'] ?? ''),
            'featured' => ($_POST['featured'] ?? '') === 'true' ? 1 : 0,
            'brand' => sanitize($_POST['brand'] ?? ''),
            'model_number' => sanitize($_POST['model_number'] ?? ''),
            'os' => sanitize($_POST['os'] ?? ''),
            'webcam' => sanitize($_POST['webcam'] ?? ''),
            'ports' => sanitize($_POST['ports'] ?? ''),
            'wifi' => sanitize($_POST['wifi'] ?? ''),
            'bluetooth' => sanitize($_POST['bluetooth'] ?? ''),
            'weight' => sanitize($_POST['weight'] ?? ''),
            'dimensions' => sanitize($_POST['dimensions'] ?? ''),
            'color' => sanitize($_POST['color'] ?? ''),
            'keyboard' => sanitize($_POST['keyboard'] ?? ''),
            'warranty' => sanitize($_POST['warranty'] ?? ''),
            'description' => sanitize($_POST['description'] ?? ''),
        ];

        try {
            $db = Database::getInstance();
            $id = $db->insert('laptops', $data);
            jsonResponse(['success' => true, 'id' => $id]);
        } catch (Exception $e) {
            jsonResponse(['error' => 'Failed to create laptop'], 500);
        }
    }

    public function updateLaptop(): void
    {
        Auth::requireAuthApi();

        // Handle both form data and JSON
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        
        if (strpos($contentType, 'multipart/form-data') !== false) {
            $id = (int)($_POST['id'] ?? 0);
            $data = $_POST;
        } else {
            $input = getJsonInput();
            $id = (int)($input['id'] ?? 0);
            $data = $input;
        }

        if ($id === 0) {
            jsonResponse(['error' => 'ID is required'], 400);
            return;
        }

        $updates = [];
        $fields = [
            'name', 'price', 'currency', 'cpu', 'ram', 'storage', 'gpu', 'display',
            'battery', 'stock_status', 'condition', 'notes', 'brand', 'model_number',
            'os', 'webcam', 'ports', 'wifi', 'bluetooth', 'weight', 'dimensions',
            'color', 'keyboard', 'warranty', 'description'
        ];

        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $updates[$field] = $field === 'price' ? (int)$data[$field] : sanitize($data[$field]);
            }
        }

        if (isset($data['featured'])) {
            $updates['featured'] = $data['featured'] === 'true' || $data['featured'] === true ? 1 : 0;
        }

        // Update slug if name changed
        if (isset($updates['name'])) {
            $updates['slug'] = slugify($updates['name']);
        }

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = handleFileUpload($_FILES['image'], 'uploads/laptops');
            if ($imagePath) {
                $updates['image'] = $imagePath;
            }
        }

        $updates['updated_at'] = date('Y-m-d H:i:s');

        try {
            $db = Database::getInstance();
            $db->update('laptops', $updates, 'id = ?', [$id]);
            jsonResponse(['success' => true]);
        } catch (Exception $e) {
            jsonResponse(['error' => 'Failed to update laptop'], 500);
        }
    }

    public function deleteLaptop(): void
    {
        Auth::requireAuthApi();

        $input = getJsonInput();
        $id = (int)($input['id'] ?? 0);

        if ($id === 0) {
            jsonResponse(['error' => 'ID is required'], 400);
            return;
        }

        try {
            $db = Database::getInstance();
            $db->delete('laptops', 'id = ?', [$id]);
            jsonResponse(['success' => true]);
        } catch (Exception $e) {
            jsonResponse(['error' => 'Failed to delete laptop'], 500);
        }
    }

    // === SETTINGS API ===

    public function getSettings(): void
    {
        // Public endpoint - no auth required
        $settings = getSettings();
        jsonResponse($settings);
    }

    public function updateSettings(): void
    {
        Auth::requireAuthApi();

        $input = getJsonInput();
        
        try {
            $db = Database::getInstance();
            
            foreach ($input as $key => $value) {
                $key = sanitize($key);
                $value = sanitize($value);
                
                $exists = $db->fetchColumn('SELECT COUNT(*) FROM settings WHERE key = ?', [$key]);
                
                if ($exists > 0) {
                    $db->update('settings', [
                        'value' => $value,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ], 'key = ?', [$key]);
                } else {
                    $db->insert('settings', [
                        'key' => $key,
                        'value' => $value,
                    ]);
                }
            }
            
            jsonResponse(['success' => true]);
        } catch (Exception $e) {
            jsonResponse(['error' => 'Failed to update settings'], 500);
        }
    }

    // === INQUIRIES API ===

    public function getInquiries(): void
    {
        Auth::requireAuthApi();

        $db = Database::getInstance();
        $inquiries = $db->fetchAll('SELECT * FROM contact_inquiries ORDER BY created_at DESC');
        
        jsonResponse($inquiries);
    }

    public function updateInquiry(): void
    {
        Auth::requireAuthApi();

        $input = getJsonInput();
        $id = (int)($input['id'] ?? 0);
        $action = $input['action'] ?? '';

        if ($id === 0) {
            jsonResponse(['error' => 'ID is required'], 400);
            return;
        }

        try {
            $db = Database::getInstance();
            
            if ($action === 'read') {
                $db->update('contact_inquiries', [
                    'status' => 'read',
                    'read_at' => date('Y-m-d H:i:s'),
                ], 'id = ?', [$id]);
            } elseif ($action === 'replied') {
                $db->update('contact_inquiries', [
                    'status' => 'replied',
                ], 'id = ?', [$id]);
            }
            
            jsonResponse(['success' => true]);
        } catch (Exception $e) {
            jsonResponse(['error' => 'Failed to update inquiry'], 500);
        }
    }

    public function deleteInquiry(): void
    {
        Auth::requireAuthApi();

        $input = getJsonInput();
        $id = (int)($input['id'] ?? 0);

        if ($id === 0) {
            jsonResponse(['error' => 'ID is required'], 400);
            return;
        }

        try {
            $db = Database::getInstance();
            $db->delete('contact_inquiries', 'id = ?', [$id]);
            jsonResponse(['success' => true]);
        } catch (Exception $e) {
            jsonResponse(['error' => 'Failed to delete inquiry'], 500);
        }
    }
}
