<?php
    // header.php
    require_once __DIR__ . '/../config.php';
?>
<!DOCTYPE html>
<html lang = "en" >
<head >
    <title >Twitter Clone</title >
    <link rel = "stylesheet" type = "text/css" href = "<?= CSS_URL ?>styles.css" >
</head >
<body >
<header >
    <nav >
        <?php
            if (isset($_SESSION['username'])): ?>
                <div >Welcome, <?php
                        echo htmlspecialchars($_SESSION['username']); ?>!
                </div >
                <br >
                <a href = "<?= BASE_URL ?>index.php" target = "_self" >Home</a >
                <a href = "<?= VIEW_URL ?>profile.php?id=<?= htmlspecialchars($_SESSION['user_id']);
                ?>" target = "_self" >Profile</a >
                <form method = "POST" action = "<?= BASE_URL ?>logout.php" target = "_self"
                      style = "display:inline;" >
                    <button type = "submit" >Logout</button >
                </form >
            <?php
            else: ?>
                <a href = "<?= BASE_URL ?>login.php" >Login</a >
                <a href = "<?= BASE_URL ?>register.php" >Register</a >
            <?php
            endif; ?>
    </nav >
</header >