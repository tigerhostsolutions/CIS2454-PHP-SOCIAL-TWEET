<?php
class Database {
    private static $pdo;

    public static function getConnection() {
        if (self::$pdo === null) {
            $host = 'localhost';
            $db = 'twitter_clone';
            $user = 'root';
            $password = '';

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