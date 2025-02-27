<?php
    session_start();
    
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

// Define base directory and include necessary files
    $baseDir = __DIR__ . '/';
    include $baseDir . 'header.php';
    include $baseDir . '../models/Tweet.php'; // Include Tweet class

// Fetch tweets from followed users
    $tweets = Tweet::getByFollowedUsers($_SESSION['user_id']);
?>

    <main>
        <h1>Home</h1>
        <h2>Tweets from users you follow</h2>
        <ul>
            <?php if (!empty($tweets)): ?>
                <?php foreach ($tweets as $tweet): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($tweet['username']); ?>:</strong>
                        <?php echo htmlspecialchars($tweet['content']); ?>
                        <br>
                        <small><?php echo htmlspecialchars($tweet['created_at']); ?></small>
                        <span>Likes: <?php echo $tweet['like_count']; ?></span>
                        <?php if ($tweet['user_liked']): ?>
                            <form method="POST" action="index.php" style="display:inline;">
                                <input type="hidden" name="unlike_tweet_id" value="<?php echo $tweet['id']; ?>">
                                <button type="submit">Unlike</button>
                            </form>
                        <?php else: ?>
                            <form method="POST" action="index.php" style="display:inline;">
                                <input type="hidden" name="like_tweet_id" value="<?php echo $tweet['id']; ?>">
                                <button type="submit">Like</button>
                            </form>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No tweets to display.</li>
            <?php endif; ?>
        </ul>
    </main>

<?php
    $baseDir = __DIR__ . '/';
    include $baseDir . 'footer.php';
    ?>