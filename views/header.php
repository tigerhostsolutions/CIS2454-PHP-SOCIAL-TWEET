<!DOCTYPE html>
<html lang="en">
<head>
    <title>Twitter Clone</title>
    <link rel="stylesheet" type="text/css" href="/sites/cis2454-bad-twitter-php/includes/css/styles.css">
</head>
<body>
<header>
    <nav>
        <!-- Other navigation links -->
        <?php if (isset($_SESSION['username'])): ?>
            <div>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</div>
            <br >
            <a href="/sites/cis2454-bad-twitter-php/index.php" target="_blank">Home</a>
            <a href="/sites/cis2454-bad-twitter-php/views/profile.php" target="_blank">Profile</a>
            <form method="POST" action="/sites/cis2454-bad-twitter-php/logout.php" target="_blank" style="display:inline;">
                <button type="submit">Logout</button>
            </form>
        <?php else: ?>
            <a href="/sites/cis2454-bad-twitter-php/login.php">Login</a>
            <a href="/sites/cis2454-bad-twitter-php/register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>