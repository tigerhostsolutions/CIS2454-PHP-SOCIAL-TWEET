<?php
    // index.php
    
    require_once __DIR__ . '/config.php';
    require_once MODEL_PATH . 'Database.php';
    require_once CONTROLLER_PATH . 'TweetController.php';
    
    TweetController::handleRequest();