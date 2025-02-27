<?php include 'views/header.php'; ?>
<main>
    <h1>User Profile</h1>
    <form method="POST" action="profile.php">
        <label>
            Username:
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </label>
        <br>
        <label>
            Email:
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </label>
        <br>
        <button type="submit">Update Profile</button>
    </form>
    
    <h2>Following</h2>
    <ul>
        <?php foreach ($following as $followedUser): ?>
            <li><?php echo htmlspecialchars($followedUser['username']); ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Followers</h2>
    <ul>
        <?php foreach ($followers as $follower): ?>
            <li><?php echo htmlspecialchars($follower['username']); ?></li>
        <?php endforeach; ?>
    </ul>
</main>
<?php include 'views/footer.php'; ?>