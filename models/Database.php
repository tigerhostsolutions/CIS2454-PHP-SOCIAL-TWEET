<?php
// Database.php
namespace App\Models;
    
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload for phpdotenv

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
        /* Load environment variables */
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        /* DB credentials */
        $username = $_ENV['DB_USER'] ?? getenv('DB_USER') ?? 'root';
        $password = $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?? 'root';
        $dbname = $_ENV['DB_NAME'] ?? '';
        $dbport = $_ENV['DB_PORT'] ?? '8889';

        /* Determine host */
        $dbhost = $type === 'remote'
            ? ($_ENV['DB_REMOTE_HOST'] ?? getenv('DB_REMOTE_HOST'))
            : ($_ENV['DB_LOCAL_HOST'] ?? getenv('DB_LOCAL_HOST'));

        /* DSN string */
        $charset = 'utf8mb4';
        $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};charset={$charset}";

        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("ERROR: Could not connect. Host: {$dbhost}, DB: {$dbname}, User: {$username}, Error: " .
                $e->getMessage());
        }
    }
}