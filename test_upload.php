<?php
    $uploadsDir = "E:/path/to/uploads"; // Update the path based on your setup
    if (is_writable($uploadsDir)) {
        echo "Uploads folder is writable!";
    } else {
        echo "Uploads folder is not writable.";
    }
?>