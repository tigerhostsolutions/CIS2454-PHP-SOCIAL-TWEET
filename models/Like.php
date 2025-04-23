<?php
    // Like.php
    namespace App\Models;
    
    require_once __DIR__ . '/../config.php';
    require_once MODEL_PATH . 'Database.php';
    
    class Like
    {
        public static function add($userId, $tweetId)
        {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("INSERT INTO likes (user_id, tweet_id) VALUES (:user_id, :tweet_id)");
            $stmt->execute(['user_id' => $userId, 'tweet_id' => $tweetId]);
        }
        
        public static function remove($userId, $tweetId)
        {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("DELETE FROM likes WHERE user_id = :user_id AND tweet_id = :tweet_id");
            $stmt->execute(['user_id' => $userId, 'tweet_id' => $tweetId]);
        }
    }