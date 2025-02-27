<?php
class User {
    public static function getAllExcept($userId) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT users.*,
                                 (SELECT COUNT(*) FROM follows WHERE follows.following_id = users.id AND follows.follower_id = :user_id) AS user_followed
                                 FROM users
                                 WHERE users.id != :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?><?php
