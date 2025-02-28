<?php
    require_once __DIR__ . '/../vendor/autoload.php'; // Autoload for phpdotenv
    
    use Dotenv\Dotenv;
    
    class Database {
        private static $pdo;
        
        public static function getConnection() {
            if (self::$pdo === null) {
                // Load environment variables
                $dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // Path to the directory containing .env
                $dotenv->load();
                
                // Retrieve values from .env
                $host = $_ENV['DB_HOST'] ?? 'localhost';
                $db = $_ENV['DB_NAME'] ?? 'twitter_clone';
                $user = $_ENV['DB_USER'] ?? 'root';
                $password = $_ENV['DB_PASSWORD'] ?? '';
                
                try {
                    self::$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
                    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die("ERROR: Could not connect. " . $e->getMessage());
                }
            }
            return self::$pdo;
        }
    }
?>