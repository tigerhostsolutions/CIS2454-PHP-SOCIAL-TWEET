<?php
    /**
     * Database.php
     *
     * This file defines the `Database` class, which is responsible for establishing
     * and managing database connections using PDO (PHP Data Objects). It supports
     * loading environment variables from a .env file and provides a singleton-like
     * pattern for database connections to prevent multiple connections to the same database.
     */
    
    namespace App\Models;
    
    require_once __DIR__ . '/../vendor/autoload.php'; // Composer autoload
    
    use Dotenv\Dotenv;
    use PDO;
    use PDOException;
    
    class Database
    {
        private static $connections = [];
        
        public static function getConnection($type = 'remote')
        {
            if (!isset(self::$connections[$type])) {
                self::$connections[$type] = self::createConnection($type);
            }
            return self::$connections[$type];
        }
        
        private static function createConnection($type)
        {
            // Load .env file only in local environments
            if (getenv('ENVIRONMENT') === 'local' && file_exists(__DIR__ . '/../.env')) {
                Dotenv::createImmutable(__DIR__ . '/../')->safeLoad();
            }
            
            // Fetch DB credentials-
            $username = $_ENV['DB_USER'] ?? getenv('DB_USER') ;
            $password = $_ENV['DB_PASS'] ?? getenv('DB_PASS') ;
            $dbname   = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ;
            $dbport   = $_ENV['DB_PORT'] ?? getenv('DB_PORT');
            
            // Host selection
            $dbhost = $type === 'remote'
                ? ($_ENV['DB_REMOTE_HOST'] ?? getenv('DB_REMOTE_HOST'))
                : ($_ENV['DB_LOCAL_HOST'] ?? getenv('DB_LOCAL_HOST'));
            
            $charset = 'utf8mb4';
            $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};charset={$charset}";
            
            try {
                $pdo = new PDO($dsn, $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
            } catch (PDOException $e) {
                if (getenv('ENVIRONMENT') === 'local') {
                    die("DB connection error: " . $e->getMessage());
                } else {
                    error_log("Database connection failed: " . $e->getMessage());
                    die("Internal server error.");
                }
            }
        }
    }
