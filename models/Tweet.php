<?php
    // Tweet.php
    $baseDir = __DIR__ . '/';
    include_once $baseDir . '/Database.php';
    include_once $baseDir . '/Like.php';
    
    class Tweet
    {
        public static function create($userId, $content, $imagePath)
        {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("INSERT INTO tweets (user_id, content, image_path) VALUES (:user_id, :content, :image_path)");
            $stmt->execute(['user_id' => $userId, 'content' => $content, 'image_path' => $imagePath]);
        }
        
        public static function getAll($userId)
        {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT tweets.*, users.username, tweets.likes_count AS like_count,
                                 (SELECT COUNT(*) FROM likes WHERE likes.tweet_id = tweets.id AND likes.user_id = :user_id) AS user_liked
                                 FROM tweets
                                 JOIN users ON tweets.user_id = users.id
                                 ORDER BY tweets.created_at DESC");
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public static function getByUserId($userId)
        {
            // Get the PDO connection from the Database class
            $pdo = Database::getConnection();
            
            $sql = "SELECT t.id, t.content, t.image_path, t.created_at,
                   u.username,
                   (SELECT COUNT(*) FROM likes WHERE likes.tweet_id = t.id) AS like_count
            FROM tweets t
            INNER JOIN users u ON t.user_id = u.id
            WHERE t.user_id = :user_id
            ORDER BY t.created_at DESC";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $userId]); // Bind parameters and execute
            
            // Fetch results as an associative array
            $tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $tweets ?: []; // Return an empty array if no tweets are found
        }
        
        public static function getByFollowedUsers($userId)
        {
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
        
        public static function likeTweet($userId, $tweetId)
        {
            $pdo = Database::getConnection();
            
            // Add the like to the "likes" table
            Like::add($userId, $tweetId);
            
            // Increment the like count in the "tweets" table
            $stmt = $pdo->prepare("UPDATE tweets SET likes_count = likes_count + 1 WHERE id = :tweet_id");
            $stmt->execute(['tweet_id' => $tweetId]);
        }
        
        public static function unlikeTweet($userId, $tweetId)
        {
            $pdo = Database::getConnection();
            
            // Remove the like from the "likes" table
            Like::remove($userId, $tweetId);
            
            // Decrement the like count in the "tweets" table
            $stmt = $pdo->prepare("UPDATE tweets SET likes_count = likes_count - 1 WHERE id = :tweet_id");
            $stmt->execute(['tweet_id' => $tweetId]);
        }
    }