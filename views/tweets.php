<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    
    $baseDir = __DIR__ . '/../'; // Base directory of the project
    include_once $baseDir . 'models/Tweet.php'; // Include the Tweet class
    include_once $baseDir . 'models/Database.php'; // Include the Database class if required
    include $baseDir . 'views/header.php'; // Include the header file
?>
<main>
    <div class="tweets-layout">
        <!-- Tweets Section -->
        <section class="tweets">
            <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
            <ul>
                <?php
                    $tweets = Tweet::getAll($_SESSION['user_id']);
                    foreach ($tweets as $tweet) {
                        echo "<li>{$tweet['username']} - {$tweet['content']} - Likes: {$tweet['like_count']}";
                        if ($tweet['image_path']) {
                            echo "<br><img src='{$tweet['image_path']}' alt='Tweet image' style='max-width: 100%; height: auto;'>";
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
                        echo "<button onclick='showLikes({$tweet['id']})'>Show Likes</button>";
                        echo "<ul id='likes-{$tweet['id']}' style='display:none;'></ul>";
                        echo "</li>";
                    }
                ?>
            </ul>
            <form method="POST" action="index.php" enctype="multipart/form-data">
                <label>
                    <textarea name="content" placeholder="What's happening?" required></textarea>
                </label>
                <label>
                    <input type="file" name="image" accept="image/*">
                </label>
                <br><br>
                <button type="submit">Tweet</button>
            </form>
        </section>

        <!-- User Info Section -->
        <aside class="users">
            <h2>Users</h2>
            <ul>
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
                        echo "<button onclick='showTweets({$user['id']})'>Show Tweets</button>";
                        echo "<ul id='tweets-{$user['id']}' style='display:none;'></ul>";
                        echo "</li>";
                    }
                ?>
            </ul>
        </aside>
    </div>
</main>
<script>
  // Scripts for likes and tweets
  function showLikes(tweetId) {
    fetch(`index.php?tweet_id=${tweetId}`)
    .then(response => response.json())
     .then(users => {
      const likesList = document.getElementById(`likes-${tweetId}`);
      likesList.innerHTML = '';
      users.forEach(user => {
        const li = document.createElement('li');
        li.textContent = user.username;
        likesList.appendChild(li);
      });
      likesList.style.display = 'block';
    });
  }

  function showTweets(userId) {
    fetch(`index.php?tweets_user_id=${userId}`)
    .then(response => response.json())
     .then(tweets => {
      const tweetsList = document.getElementById(`tweets-${userId}`);
      tweetsList.innerHTML = '';
      tweets.forEach(tweet => {
        const li = document.createElement('li');
        li.textContent = tweet.content;
        tweetsList.appendChild(li);
      });
      tweetsList.style.display = 'block';
    });
  }
</script>