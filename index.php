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

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['tweet_id'])) {
        $tweet_id = $_GET['tweet_id'];

        $stmt = $pdo->prepare("SELECT users.username FROM likes JOIN users ON likes.user_id = users.id WHERE likes.tweet_id = :tweet_id");
        $stmt->execute(['tweet_id' => $tweet_id]);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($users);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];

        $stmt = $pdo->prepare("SELECT users.username FROM follows JOIN users ON follows.follower_id = users.id WHERE follows.following_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $followers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($followers);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['following_user_id'])) {
        $user_id = $_GET['following_user_id'];

        $stmt = $pdo->prepare("SELECT users.username FROM follows JOIN users ON follows.following_id = users.id WHERE follows.follower_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $following = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($following);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['tweets_user_id'])) {
        $user_id = $_GET['tweets_user_id'];

        $stmt = $pdo->prepare("SELECT tweets.content, tweets.created_at FROM tweets WHERE tweets.user_id = :user_id ORDER BY tweets.created_at DESC");
        $stmt->execute(['user_id' => $user_id]);
        $tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($tweets);
        exit;
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
                  echo "<button onclick='showLikes({$tweet['id']})'>Show Likes</button>";
                  echo "<ul id='likes-{$tweet['id']}' style='display:none;'></ul>";
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
  
      <h2>Users</h2>
      <ul>
  
          <?php
              $stmt = $pdo->prepare("SELECT users.*,
                                     (SELECT COUNT(*) FROM follows WHERE follows.following_id = users.id AND follows.follower_id = :user_id) AS user_followed
                                     FROM users
                                     WHERE users.id != :user_id");
              $stmt->execute(['user_id' => $_SESSION['user_id']]);
              $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
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
                  echo "<button onclick='showFollowers({$user['id']})'>Show Followers</button>";
                  echo "<ul id='followers-{$user['id']}' style='display:none;'></ul>";
                  echo "<button onclick='showFollowing({$user['id']})'>Show Following</button>";
                  echo "<ul id='following-{$user['id']}' style='display:none;'></ul>";
                  echo "<button onclick='showTweets({$user['id']})'>Show Tweets</button>";
                  echo "<ul id='tweets-{$user['id']}' style='display:none;'></ul>";
                  echo "</li>";
              }
          ?>
  
      </ul>
  
      <script>
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
  
          function showFollowers(userId) {
              fetch(`index.php?user_id=${userId}`)
                  .then(response => response.json())
                  .then(users => {
                      const followersList = document.getElementById(`followers-${userId}`);
                      followersList.innerHTML = '';
                      users.forEach(user => {
                          const li = document.createElement('li');
                          li.textContent = user.username;
                          followersList.appendChild(li);
                      });
                      followersList.style.display = 'block';
                  });
          }
  
          function showFollowing(userId) {
              fetch(`index.php?following_user_id=${userId}`)
                  .then(response => response.json())
                  .then(users => {
                      const followingList = document.getElementById(`following-${userId}`);
                      followingList.innerHTML = '';
                      users.forEach(user => {
                          const li = document.createElement('li');
                          li.textContent = user.username;
                          followingList.appendChild(li);
                      });
                      followingList.style.display = 'block';
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
                          li.textContent = `${tweet.content} - ${tweet.created_at}`;
                          tweetsList.appendChild(li);
                      });
                      tweetsList.style.display = 'block';
                  });
          }
      </script>
  
  </main>