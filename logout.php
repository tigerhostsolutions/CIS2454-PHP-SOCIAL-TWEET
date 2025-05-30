<?php
    /**
     * logout.php
     *
     * This script handles the user logout process for the Social Tweet application.
     * It destroys the current user session and redirects the user to the login page.
     */

    session_start();
    session_destroy();
    header("Location: login.php");
    exit;