<?php
    // tweets.php
    use App\Models\Tweet;
    use App\Models\User;
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    require_once __DIR__ . '/../config.php';
    require_once VIEW_PATH . 'header.php';
    require_once MODEL_PATH . 'Tweet.php';
    require_once MODEL_PATH . 'Database.php';
    
    // Fetch the username of the logged-in user
    $username = User::getUsernameById($_SESSION['user_id']);
?>

    <main >
        <div class = "tweets-layout" >
            <!-- Form and Tweets Container -->
            <div class = "tweets-and-form" >
                <!-- Form Section -->
                <form class = "tweet-form" method = "POST" action = "<?= BASE_URL ?>index.php" enctype =
                "multipart/form-data" >
                    <h2 >Compose a Tweet</h2 >
                    <label >
                        <textarea name = "content" placeholder = "What's happening?" required ></textarea >
                    </label >
                    <label >
                        <input type = "file" name = "image" accept = "image/*" >
                    </label >
                    <button type = "submit" >Tweet</button >
                </form >

                <!-- Tweets Section -->
                <section class = "tweets" >
                    <h1 >Welcome, <?php
                            echo htmlspecialchars($username); ?>!</h1 >
                    <ul class = "tweets-list" >
                        <?php
                            $tweets = Tweet::getAll($_SESSION['user_id']);
                            foreach ($tweets as $tweet) {
                                echo "<li class='tweet-item'>
                                    <strong>{$tweet['username']}</strong> - {$tweet['content']}
                                    <br>
                                    <small>Likes: {$tweet['like_count']}</small>";
                                if ($tweet['image_path']) {
                                    echo "<br><img src='{$tweet['image_path']}' alt='Tweet image' class='tweet-image'>";
                                }
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
                            }
                        ?>
                    </ul >
                </section >
            </div >

            <!-- User Info Section -->
            <aside class = "users" >
                <h2 >Users</h2 >
                <ul class = "users-list" >
                    <?php
                        $users = User::getAllExcept($_SESSION['user_id']);
                        foreach ($users as $user) {
                            echo "<li>{$user['username']}";
                            if ($user['user_followed'] > 0) {
                                echo "<form method='POST' action='index.php' style='display:inline;'>
                          <input type='hidden' name='unfollow_user_id' value='{$user['id']}'>
                          <button type='submit'>Unfollow</button>
                      </form>";
                            } else {
                                echo "<form method='POST' action='index.php' style='display:inline;'>
                          <input type='hidden' name='follow_user_id' value='{$user['id']}'>
                          <button type='submit'>Follow</button>
                      </form>";
                            }
                        }
                    ?>
                </ul >
            </aside >
        </div >
    </main >

<?php
    require_once VIEW_PATH . 'footer.php';
?>
