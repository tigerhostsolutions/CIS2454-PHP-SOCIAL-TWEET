<?php
include_once 'models/User.php';

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            self::updateProfile($userId);
        } else {
            self::showProfile($userId);
        }
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