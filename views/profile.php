<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    
    $baseDir = __DIR__ . '/';
    include $baseDir . 'header.php';

?>
    <main >
        <h1 >User Profile</h1 >
        <div class = "profile-header" >
            <h2 ><?php
                    echo isset($user['username']) ? htmlspecialchars($user['username']) : 'Unknown User'; ?></h2 >
            <p ><?php
                    echo isset($user['bio']) ? htmlspecialchars($user['bio']) : 'No bio available'; ?></p >
            <p >Location: <?php
                    echo isset($user['location']) ? htmlspecialchars($user['location']) : 'Unknown'; ?></p >
            <p >Joined: <?php
                    echo isset($user['join_date']) ? htmlspecialchars($user['join_date']) : 'Unknown'; ?></p >
        </div >

        <h2 >Following</h2 >
        <ul >
            <?php
                if (isset($following) && is_array($following)): ?>
                    <?php
                    foreach ($following as $followedUser): ?>
                        <li ><?php
                                echo htmlspecialchars($followedUser['username']); ?></li >
                    <?php
                    endforeach; ?>
                <?php
                else: ?>
                    <li >No following users to display.</li >
                <?php
                endif; ?>
        </ul >

        <h2 >Followers</h2 >
        <ul >
            <?php
                if (isset($followers) && is_array($followers)): ?>
                    <?php
                    foreach ($followers as $follower): ?>
                        <li ><?php
                                echo htmlspecialchars($follower['username']); ?></li >
                    <?php
                    endforeach; ?>
                <?php
                else: ?>
                    <li >No followers to display.</li >
                <?php
                endif; ?>
        </ul >

        <h2 >User's Tweets</h2 >
        <ul >
            <?php
                if (isset($tweets) && is_array($tweets)): ?>
                    <?php
                    foreach ($tweets as $tweet): ?>
                        <li ><?php
                                echo htmlspecialchars($tweet['content']); ?> (<?php
                                echo $tweet['created_at']; ?>)
                        </li >
                    <?php
                    endforeach; ?>
                <?php
                else: ?>
                    <li >No tweets to display.</li >
                <?php
                endif; ?>
        </ul >
    </main >
<?php
    $baseDir = __DIR__ . '/';
    include $baseDir . 'footer.php';    ?>