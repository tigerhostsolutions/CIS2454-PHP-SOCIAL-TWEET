<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

// Define base directory and include necessary files
    $baseDir = __DIR__ . '/';
    include $baseDir . 'header.php';
    include_once $baseDir . '../models/Tweet.php'; // Include Tweet class
    include_once $baseDir . '../models/User.php'; // Include the User class

// Fetch tweets from followed users
    $tweets = Tweet::getByFollowedUsers($_SESSION['user_id']);
?>

    <main>
        <h1>Home</h1>
        <!-- Tweets Section -->
        <section class="tweets-section">
            <h2>Tweets from Users You Follow</h2>
            <div class="tweets-container">
                <?php if (!empty($tweets)): ?>
                    <?php foreach ($tweets as $tweet): ?>
                        <div class="tweet">
                            <div class="tweet-header">
                                <strong><?php echo htmlspecialchars($tweet['username']); ?></strong>
                                <span class="tweet-time"><?php echo htmlspecialchars($tweet['created_at']); ?></span>
                            </div>
                            <p class="tweet-content"><?php echo htmlspecialchars($tweet['content']); ?></p>
                            <div class="tweet-footer">
                                <span class="likes">Likes: <?php echo $tweet['like_count']; ?></span>
                                <?php if ($tweet['user_liked']): ?>
                                    <form method="POST" action="index.php" style="display:inline;">
                                        <input type="hidden" name="unlike_tweet_id" value="<?php echo $tweet['id']; ?>">
                                        <button type="submit" class="like-button unlike">Unlike</button>
                                    </form>
                                <?php else: ?>
                                    <form method="POST" action="index.php" style="display:inline;">
                                        <input type="hidden" name="like_tweet_id" value="<?php echo $tweet['id']; ?>">
                                        <button type="submit" class="like-button like">Like</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No tweets to display.</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Followers and Following Section -->
        <section class="followers-following-section">
            <div class="followers-section">
                <h2>Your Followers</h2>
                <ul class="followers-list">
                    <?php
                        $followers = User::getFollowers($_SESSION['user_id']);
                        
                        if (!empty($followers)) {
                            foreach ($followers as $follower) {
                                if (is_array($follower) && isset($follower['username'])) {
                                    echo "<li class='follower-item'>" . htmlspecialchars($follower['username']) . "</li>";
                                }
                            }
                        } else {
                            echo "<li>You currently have no followers!</li>";
                        }
                    ?>
                </ul>
            </div>

            <div class="following-section">
                <h2>Your Following</h2>
                <ul class="following-list">
                    <?php
                        $following = User::getFollowing($_SESSION['user_id']);
                        
                        if (!empty($following)) {
                            foreach ($following as $followed) {
                                if (is_array($followed) && isset($followed['username'])) {
                                    echo "<li class='following-item'>" . htmlspecialchars($followed['username']) . "</li>";
                                }
                            }
                        } else {
                            echo "<li>You are not following anyone yet.</li>";
                        }
                    ?>
                </ul>
            </div>
        </section>
    </main>

<?php
    $baseDir = __DIR__ . '/';
    include $baseDir . 'footer.php';
    ?>