<?php
    /**
     * index.php
     *
     * This file serves as the primary entry point for the Social Tweet application.
     * It is responsible for setting up the necessary environment and delegating
     * the request handling to the appropriate controller.
     */
    
    use App\Controllers\TweetController;
    
    require_once __DIR__ . '/config.php';
    require_once MODEL_PATH . 'Database.php';
    require_once CONTROLLER_PATH . 'TweetController.php';
    
    TweetController::handleRequest();