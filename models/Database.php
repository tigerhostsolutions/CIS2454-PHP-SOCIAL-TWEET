<?php
    require_once __DIR__ . '/../vendor/autoload.php'; // Autoload for phpdotenv
    
    use Dotenv\Dotenv;
    
    class Database
    {
        private static $pdo;
        
        public static function getConnection()
        {
            if (self::$pdo === NULL) {
                // Determine which environment file to load
                $env = getenv('APP_ENV') ?: 'development'; // Defaults to 'development' if APP_ENV is not set
                $envFile = $env === 'production' ? '.env-production' : '.env';
                
                // Load the appropriate .env file
                $dotenv = Dotenv::createImmutable(__DIR__ . '/../', $envFile);
                $dotenv->load();
                
                // Retrieve values from the .env file
                $host = $_ENV['DB_HOST'] ?? 'localhost';
                $db = $_ENV['DB_NAME'] ?? 'twitter_clone';
                $username = $_ENV['DB_USER'] ?? 'badtwitter';
                $password = $_ENV['DB_PASSWORD'] ?? 'badtwitter';
                $dsn = "mysql:host={$host};dbname={$db}";
                
                // RDS connection
//                $dbhost = $_SERVER['RDS_HOSTNAME'];
//                $dbport = $_SERVER['RDS_PORT'];
//                $dbname = $_SERVER['RDS_DB_NAME'];
//                $charset = 'utf8';
//                $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};charset={$charset}";
//                $username = $_SERVER['RDS_USERNAME'];
//                $password = $_SERVER['RDS_PASSWORD'];
                
                try {
                    self::$pdo = new PDO($dsn, $username, $password);
                    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die("ERROR: Could not connect. " . $e->getMessage());
                }
            }
            return self::$pdo;
        }
    }