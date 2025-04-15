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
                /* Determine which environment file to load */
                $env = getenv('APP_ENV') ?: 'development'; // Defaults to 'development' if APP_ENV is not set
                $envFile = $env === 'production' ? '.env-production' : '.env';

                /* Load the appropriate .env file */
                $dotenv = Dotenv::createImmutable(__DIR__ . '/../', $envFile);
                $dotenv->load();
                
                /* Retrieve values from the .env file */
//                $dbhost = $_ENV['DB_LOCAL_HOST'] ;
//                $dbname = $_ENV['DB_LOCAL_NAME'] ;
//                $dbport = $_ENV['DB_LOCAL_PORT'] ;
//                $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";
                
                /* Localhost username & password credentials */
//                $username = $_ENV['DB_LOCAL_USER'] ;
//                $password = $_ENV['DB_LOCAL_PASS'];

                /* RDS connection details */
                $dbhost = $_ENV['DB_REMOTE_HOST'] ?? getenv('DB_REMOTE_HOST') ;
                $dbport = $_ENV['DB_REMOTE_PORT'] ?? getenv('DB_REMOTE_PORT') ;
                $dbname = $_ENV['DB_REMOTE_NAME'] ?? getenv('DB_REMOTE_NAME') ;
                $charset = 'utf8mb4';
                $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};charset={$charset}";
                
                /* RDS username & password credentials */
                $username = $_ENV['DB_REMOTE_USER'] ?? getenv('DB_REMOTE_USER') ;
                $password = $_ENV['DB_REMOTE_PASS'] ?? getenv('DB_REMOTE_PASS') ;
                
                try {
                    self::$pdo = new PDO($dsn, $username, $password);
                    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die("ERROR: Could not connect. Host: {$dbhost}, DB: {$dbname}, User: {$username}, Error: " .
                        $e->getMessage());
                }
            }
            return self::$pdo;
        }
    }