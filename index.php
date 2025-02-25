<main>
    
    <h1>Home</h1>
    <ul>
        <?php
            session_start();
            include 'includes/config/database.php';
            
            $stmt = $pdo->prepare("SELECT * FROM tweets ORDER BY created_at DESC");
            $stmt->execute();
            $tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($tweets as $tweet) {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
                $stmt->execute(['id' => $tweet['user_id']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                echo "<li>{$user['username']} - {$tweet['content']}</li>";
            }
        ?>
    </ul>
    <form method="POST" action="post_tweet.php">
        <label >
            <textarea name="content" placeholder="What's happening?" required></textarea>
        </label >
        <br ><br >
        <button type="submit">Tweet</button>
    </form>
    
</main>

