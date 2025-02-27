<?php include 'views/header.php'; ?>
<main>
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
</main>
<script>
  function showLikes(tweetId) {
    fetch(`index.php?tweet_id=${tweetId}`).then(response => response.json()).then(users => {
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
</script>
<?php include 'views/footer.php'; ?>