<?php
    /**
     * profile.php
     *
     * This file serves as the entry point for the user's profile page in the Social Tweet application.
     * It is responsible for setting up the necessary environment and delegating
     * the request handling to the `UserController` to display the user's profile
     * and manage related actions.
     */
    
    use App\Controllers\UserController;
    
    // Require necessary configuration and model/controller files.
    // These files provide essential constants, database connection logic,
    // and the main request handling logic for user profiles.
    require_once __DIR__ . '/config.php';          // Includes application-wide configurations (e.g., paths).
    require_once MODEL_PATH . 'Database.php';      // Ensures the Database class is available for connections.
    require_once CONTROLLER_PATH . 'UserController.php'; // Includes the UserController class definition.
    
    UserController::handleRequest();
