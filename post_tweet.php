<?php
    /**
     * post_tweet.php
     *
     * This script handles the display of existing tweets and the submission
     * of new tweets for the Social Tweet application. It retrieves tweets
     * from the database, displays them, and processes new tweet submissions
     * from authenticated users.
     */
    
    global $pdo;
    session_start();
    
    require_once __DIR__ . '/config.php';
    require_once MODEL_PATH . 'Database.php';
    
    $tweets = $pdo->query("SELECT tweets.*, users.username FROM tweets JOIN users ON tweets.user_id = users.id ORDER BY tweets.created_at DESC");
    foreach ($tweets as $tweet) {
        echo "<p><strong>{$tweet['username']}:</strong> {$tweet['content']} ({$tweet['created_at']})</p>";
    }
    
    if (isset($_SESSION['user_id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $content = $_POST['content'];
        $user_id = $_SESSION['user_id'];
        
        $stmt = $pdo->prepare("INSERT INTO tweets (user_id, content) VALUES (:user_id, :content)");
        $stmt->execute(['user_id' => $user_id, 'content' => $content]);
        
        header("Location: index.php");
    } else {
        header("Location: login.php");
    }