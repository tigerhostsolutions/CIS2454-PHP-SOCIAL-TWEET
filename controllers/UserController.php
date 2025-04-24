<?php
    // UserController.php
    namespace App\Controllers;
    
    use App\Models\Tweet;
    use App\Models\User;
    
    require_once __DIR__ . '/../config.php';
    require_once MODEL_PATH . 'Tweet.php';
    require_once MODEL_PATH . 'User.php';
    
    class UserController
    {
        public static function handleRequest()
        {
            session_start();
            if (!isset($_SESSION['user_id'])) {
                header("Location: login.php");
                exit;
            }
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                self::updateProfile($_SESSION['user_id']);
            } else {
                self::showProfile($_SESSION['user_id']);
            }
        }
        
        private static function showProfile()
        {
            // Fetch user data
            $userId = $_SESSION['user_id'];
            $user = User::getById($userId);
            $following = User::getFollowing($userId);
            $followers = User::getFollowers($userId);
            $tweets = Tweet::getByUserId($userId);
            $isFollowing = FALSE; // The user cannot follow themselves
            
            // Pass variables to the view
            require_once VIEW_PATH . 'profile.php';
        }
        
        private static function updateProfile($userId)
        {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            User::update($userId, $username, $email);
            header("Location: profile.php");
            exit;
        }
    }