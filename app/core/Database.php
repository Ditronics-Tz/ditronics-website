<?php
/**
 * Database Handler - PDO with SQLite
 * 
 * Singleton pattern for database connection.
 * Uses prepared statements exclusively for security.
 */

declare(strict_types=1);

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        try {
            $this->pdo = new PDO(
                'sqlite:' . DB_PATH,
                null,
                null,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
            
            // Enable foreign keys
            $this->pdo->exec('PRAGMA foreign_keys = ON');
            
            // Initialize tables if they don't exist
            $this->initializeTables();
            
        } catch (PDOException $e) {
            throw new RuntimeException('Database connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * Execute a query with prepared statements
     */
    public function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Fetch all rows
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * Fetch single row
     */
    public function fetch(string $sql, array $params = []): ?array
    {
        $result = $this->query($sql, $params)->fetch();
        return $result !== false ? $result : null;
    }

    /**
     * Fetch single value
     */
    public function fetchColumn(string $sql, array $params = []): mixed
    {
        return $this->query($sql, $params)->fetchColumn();
    }

    /**
     * Insert and return last insert ID
     */
    public function insert(string $table, array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->query($sql, array_values($data));
        
        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Update rows
     */
    public function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        $set = implode(' = ?, ', array_keys($data)) . ' = ?';
        $sql = "UPDATE {$table} SET {$set} WHERE {$where}";
        
        $params = array_merge(array_values($data), $whereParams);
        return $this->query($sql, $params)->rowCount();
    }

    /**
     * Delete rows
     */
    public function delete(string $table, string $where, array $params = []): int
    {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        return $this->query($sql, $params)->rowCount();
    }

    /**
     * Initialize database tables
     */
    private function initializeTables(): void
    {
        // Check if tables exist
        $tablesExist = $this->fetchColumn(
            "SELECT COUNT(*) FROM sqlite_master WHERE type='table' AND name='laptops'"
        );

        if ($tablesExist > 0) {
            return; // Tables already exist
        }

        // Create tables
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS laptops (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                slug TEXT UNIQUE NOT NULL,
                price INTEGER NOT NULL,
                currency TEXT DEFAULT 'TZS',
                cpu TEXT,
                ram TEXT,
                storage TEXT,
                gpu TEXT,
                display TEXT,
                battery TEXT,
                image TEXT,
                stock_status TEXT DEFAULT 'In Stock',
                condition TEXT DEFAULT 'Brand New',
                notes TEXT,
                featured INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                brand TEXT,
                model_number TEXT,
                os TEXT,
                webcam TEXT,
                ports TEXT,
                wifi TEXT,
                bluetooth TEXT,
                weight TEXT,
                dimensions TEXT,
                color TEXT,
                keyboard TEXT,
                warranty TEXT,
                description TEXT
            );

            CREATE TABLE IF NOT EXISTS admin_users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS settings (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                key TEXT UNIQUE NOT NULL,
                value TEXT,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS contact_inquiries (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT NOT NULL,
                company TEXT,
                message TEXT NOT NULL,
                status TEXT DEFAULT 'new',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                read_at DATETIME
            );
        ");

        // Create default admin user only if none exists
        $adminExists = $this->fetchColumn('SELECT COUNT(*) FROM admin_users WHERE username = ?', [DEFAULT_ADMIN_USERNAME]);
        if ($adminExists == 0) {
            $hashedPassword = password_hash(DEFAULT_ADMIN_PASSWORD, PASSWORD_DEFAULT);
            $this->insert('admin_users', [
                'username' => DEFAULT_ADMIN_USERNAME,
                'password' => $hashedPassword,
            ]);
        }

        // Create default settings
        $defaultSettings = [
            'whatsapp_number' => '255717321753',
            'phone_number' => '255717321753',
            'email' => 'info@ditronics.co.tz',
            'address' => 'Shangwe Kibada, Tanzania',
            'company_name' => 'Ditronics',
        ];

        foreach ($defaultSettings as $key => $value) {
            $this->insert('settings', ['key' => $key, 'value' => $value]);
        }
    }

    // Prevent cloning
    private function __clone() {}

    // Prevent unserialization
    public function __wakeup()
    {
        throw new RuntimeException('Cannot unserialize singleton');
    }
}
