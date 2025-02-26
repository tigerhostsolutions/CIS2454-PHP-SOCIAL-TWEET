<?php
        session_start();
        include 'includes/config/database.php';
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
            $content = $_POST['content'];
    
            $stmt = $pdo->prepare("INSERT INTO tweets (user_id, content) VALUES (:user_id, :content)");
            $stmt->execute(['user_id' => $_SESSION['user_id'], 'content' => $content]);
    
            header("Location: index.php");
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['like_tweet_id'])) {
            $tweet_id = $_POST['like_tweet_id'];
    
            $stmt = $pdo->prepare("INSERT INTO likes (user_id, tweet_id) VALUES (:user_id, :tweet_id)");
            $stmt->execute(['user_id' => $_SESSION['user_id'], 'tweet_id' => $tweet_id]);
    
            header("Location: index.php");
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unlike_tweet_id'])) {
            $tweet_id = $_POST['unlike_tweet_id'];
    
            $stmt = $pdo->prepare("DELETE FROM likes WHERE user_id = :user_id AND tweet_id = :tweet_id");
            $stmt->execute(['user_id' => $_SESSION['user_id'], 'tweet_id' => $tweet_id]);
    
            header("Location: index.php");
        }
    ?>
    
    <!DOCTYPE html>
    <main>
    
        <h1>Home</h1>
        <ul>
    
            <?php
                $stmt = $pdo->prepare("SELECT tweets.*, users.username,
                                       (SELECT COUNT(*) FROM likes WHERE likes.tweet_id = tweets.id) AS like_count,
                                       (SELECT COUNT(*) FROM likes WHERE likes.tweet_id = tweets.id AND likes.user_id = :user_id) AS user_liked
                                       FROM tweets
                                       JOIN users ON tweets.user_id = users.id
                                       ORDER BY tweets.created_at DESC");
                $stmt->execute(['user_id' => $_SESSION['user_id']]);
                $tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                foreach ($tweets as $tweet) {
                    echo "<li>{$tweet['username']} - {$tweet['content']} - Likes: {$tweet['like_count']}";
                    if ($tweet['user_liked'] > 0) {
                        echo "<form method='POST' action='index.php' style='display:inline;'>
                                  <input type='hidden' name='unlike_tweet_id' value='{$tweet['id']}'>
                                  <button type='submit'>Unlike</button>
                              </form>";
                    } else {
                        echo "<form method='POST' action='index.php' style='display:inline;'>
                                  <input type='hidden' name='like_tweet_id' value='{$tweet['id']}'>
                                  <button type='submit'>Like</button>
                              </form>";
                    }
                    echo "</li>";
                }
            ?>
    
        </ul>
        <form method="POST" action="index.php">
            <label >
                <textarea name="content" placeholder="What's happening?" required></textarea>
            </label >
            <br ><br >
            <button type="submit">Tweet</button>
        </form>
    
    </main>