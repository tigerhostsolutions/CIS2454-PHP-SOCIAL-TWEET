<?php
    // index.php
    
    require_once __DIR__ . '/config.php';
    require_once BASE_DIR . '/models/Database.php';
    require_once BASE_DIR . '/controllers/TweetController.php';
    
    TweetController::handleRequest();