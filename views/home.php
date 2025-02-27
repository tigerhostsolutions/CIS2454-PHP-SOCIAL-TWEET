<?php include 'views/header.php'; ?>
<main>
    <h1>Home</h1>
    <h2>Tweets from users you follow</h2>
    <ul>
        <?php foreach ($tweets as $tweet): ?>
            <li>
                <strong><?php echo htmlspecialchars($tweet['username']); ?>:</strong>
                <?php echo htmlspecialchars($tweet['content']); ?>
                <br>
                <small><?php echo htmlspecialchars($tweet['created_at']); ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
</main>
<?php include 'views/footer.php'; ?><?php
