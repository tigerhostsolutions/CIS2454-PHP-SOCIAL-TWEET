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
                $username = $_ENV['DB_USER'] ?? 'badtwitter';
                $password = $_ENV['DB_PASSWORD'] ?? 'badtwitter';
                $dsn = "mysql:host={$host};dbname={$db}";
                
                // RDS connection
//                $dbhost = $_SERVER['RDS_HOSTNAME'] ?? 'awseb-e-7y9hai72sh-stack-awsebrdsdatabase-q8jzlxxm6uxj.cx0w4awbhwbr.us-east-1.rds.amazonaws.com';
//                $dbport = $_SERVER['RDS_PORT'] ?? 3306;
//                $dbname = $_SERVER['RDS_DB_NAME'] ?? 'ebdb';
//                $charset = 'utf8';
//                $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};charset={$charset}";
//                $username = $_SERVER['RDS_USERNAME'] ?? 'badtwitter';
//                $password = $_SERVER['RDS_PASSWORD'] ?? 'badtwitter';
                
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