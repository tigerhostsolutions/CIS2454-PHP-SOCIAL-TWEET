<?php
    include_once 'models/User.php';
    include_once 'models/Tweet.php';
    
    class UserController
    {
        public static function handleRequest()
        {
            session_start();
            if (!isset($_SESSION['user_id'])) {
                header("Location: login.php");
                exit;
            }
            
            $userId = $_SESSION['user_id'];
            $followingIds = User::getFollowingIds($userId);
            $tweets = Tweet::getTweetsByUserIds($followingIds);
            include 'views/home.php';
        
        }
        
        private static function showProfile($userId)
        {
            $user = User::getById($userId);
            $following = User::getFollowing($userId);
            $followers = User::getFollowers($userId);
            include 'views/profile.php';
        }
        
        private static function updateProfile($userId)
        {
            $username = $_POST['username'];
            $email = $_POST['email'];
            User::update($userId, $username, $email);
            header("Location: profile.php");
            exit;
        }
    }

?>