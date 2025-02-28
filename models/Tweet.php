<?php
    
    $baseDir = __DIR__ . '/';
    include_once $baseDir . '/Database.php';
    
    class Tweet {
    public static function create($userId, $content, $imagePath) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO tweets (user_id, content, image_path) VALUES (:user_id, :content, :image_path)");
        $stmt->execute(['user_id' => $userId, 'content' => $content, 'image_path' => $imagePath]);
    }

    public static function getAll($userId) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT tweets.*, users.username,
                                 (SELECT COUNT(*) FROM likes WHERE likes.tweet_id = tweets.id) AS like_count,
                                 (SELECT COUNT(*) FROM likes WHERE likes.tweet_id = tweets.id AND likes.user_id = :user_id) AS user_liked
                                 FROM tweets
                                 JOIN users ON tweets.user_id = users.id
                                 ORDER BY tweets.created_at DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function getByUserId($userId) {
        if (empty($userId)) {
            return [];
        }
        
        $pdo = Database::getConnection();
        $inQuery = implode(',', array_fill(0, count($userId), '?'));
        $stmt = $pdo->prepare("SELECT tweets.*, users.username FROM tweets JOIN users ON tweets.user_id = users.id WHERE tweets.user_id IN ($inQuery) ORDER BY tweets.created_at DESC");
        $stmt->execute($userId);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        
        public static function getByFollowedUsers($userId) {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("
        SELECT tweets.*, users.username,
               (SELECT COUNT(*) FROM likes WHERE likes.tweet_id = tweets.id) AS like_count,
               (SELECT COUNT(*) FROM likes WHERE likes.tweet_id = tweets.id AND likes.user_id = :user_id) AS user_liked
        FROM tweets
        JOIN users ON tweets.user_id = users.id
        WHERE tweets.user_id IN (
            SELECT following_id FROM follows WHERE follower_id = :user_id
        )
        ORDER BY tweets.created_at DESC
    ");
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
}
?><?php
