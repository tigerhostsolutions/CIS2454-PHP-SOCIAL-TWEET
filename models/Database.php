<?php
    // Database.php
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
                $dsn = "mysql:host={$host};dbname={$db}";
                
                // Localhost username & password credentials
                $username = $_ENV['DB_USER'] ?? 'badtwitter';
                $password = $_ENV['DB_PASSWORD'] ?? 'badtwitter';
                
                // RDS connection
//                $dbhost = $_ENV['RDS_HOSTNAME'] ?? getenv('RDS_HOSTNAME') ?? 'badtwitterclone.c36iwsaw0x1s.us-east-1.rds.amazonaws.com';
//                $dbport = $_ENV['RDS_PORT'] ?? getenv('RDS_PORT') ?? 3306;
//                $dbname = $_ENV['RDS_DB_NAME'] ?? getenv('RDS_DB_NAME') ?? 'socialtweet';
//                $charset = 'utf8mb4';
//                $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};charset={$charset}";
                
                // RDS username & password credentials
//                $username = $_ENV['RDS_USERNAME'] ?? getenv('RDS_USERNAME') ?? 'badtwitter';
//                $password = $_ENV['RDS_PASSWORD'] ?? getenv('RDS_PASSWORD') ?? 'badtwitter';
                
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