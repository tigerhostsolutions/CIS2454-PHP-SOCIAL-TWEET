<?php
    
    class User
    {
        public static function getAllExcept($userId)
        {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT users.*,
                                 (SELECT COUNT(*) FROM follows WHERE follows.following_id = users.id AND follows.follower_id = :user_id) AS user_followed
                                 FROM users
                                 WHERE users.id != :user_id");
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public static function follow($followerId, $followingId)
        {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("INSERT INTO follows (follower_id, following_id) VALUES (:follower_id, :following_id)");
            $stmt->execute(['follower_id' => $followerId, 'following_id' => $followingId]);
        }
        
        public static function unfollow($followerId, $followingId)
        {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("DELETE FROM follows WHERE follower_id = :follower_id AND following_id = :following_id");
            $stmt->execute(['follower_id' => $followerId, 'following_id' => $followingId]);
        }
        
        public static function getById($userId)
        {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute(['id' => $userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        public static function update($userId, $username, $email)
        {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
            $stmt->execute(['username' => $username, 'email' => $email, 'id' => $userId]);
        }
        
        public static function getFollowing($userId) {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT following_id FROM follows WHERE follower_id = :user_id");
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }
        
        public static function getFollowers($userId)
        {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT users.* FROM follows JOIN users ON follows.follower_id = users.id WHERE follows.following_id = :user_id");
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>