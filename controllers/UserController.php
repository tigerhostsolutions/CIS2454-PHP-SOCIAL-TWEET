<?php
    /**
     * UserController.php
     *
     * This file defines the `UserController` class, which is responsible for
     * managing user-specific actions and profile-related functionalities
     * within the Social Tweet application. It handles requests for viewing
     * user profiles, and managing follow/unfollow relationships.
     */
    
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
                if (isset($_POST['action'])) {
                    switch ($_POST['action']) {
                        case 'tweet':
                            TweetController::createTweet();
                            break;
                        case 'follow':
                            self::followUser();
                            break;
                        case 'unfollow':
                            self::unfollowUser();
                            break;
                        default:
                            header("Location: profile.php?error=invalid_action");
                            exit;
                    }
                }
            } else {
                self::showProfile();
            }
        }
        
        private static function followUser()
        {
            $followerId = $_SESSION['user_id'];
            $followingId = $_POST['following_id'] ?? NULL;
            
            if ($followingId) {
                User::follow($followerId, $followingId);
            }
            header("Location: profile.php");
            exit;
        }
        
        private static function unfollowUser()
        {
            $followerId = $_SESSION['user_id'];
            $followingId = $_POST['following_id'] ?? NULL;
            if ($followingId) {
                User::unfollow($followerId, $followingId);
            }
            header("Location: profile.php");
            exit;
        }
        private static function showProfile()
        {
            $userId = $_SESSION['user_id'];
            $user = User::getById($userId);
            $following = User::getFollowing($userId);
            $followers = User::getFollowers($userId);
            $tweets = Tweet::getByUserId($userId);
            $isFollowing = FALSE; // The user cannot follow themselves
            
            // Pass variables to the view
            require_once VIEW_PATH . 'profile.php';
        }
    }