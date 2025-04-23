<?php
    // index.php
    // This is the entry point for the application.
    // It includes the necessary files and initializes the application.
    use App\Controllers\TweetController;
    
    require_once __DIR__ . '/config.php';
    require_once MODEL_PATH . 'Database.php';
    require_once CONTROLLER_PATH . 'TweetController.php';
    
    TweetController::handleRequest();