<?php
    
    use models\Database;
    
    include_once 'models/Tweet.php';
        include_once 'models/Like.php';
        include_once 'models/User.php';
        
        class TweetController {
            public static function handleRequest() {
                session_start();
                if (!isset($_SESSION['user_id'])) {
                    header("Location: login.php");
                    exit;
                }
        
                $username = $_SESSION['username'] ?? 'Guest';
                $userId = $_SESSION['user_id'];
                $tweets = Tweet::getAll($userId);
        
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['content'])) {
                        self::createTweet();
                    } elseif (isset($_POST['like_tweet_id'])) {
                        self::likeTweet();
                    } elseif (isset($_POST['unlike_tweet_id'])) {
                        self::unlikeTweet();
                    } elseif (isset($_POST['follow_user_id'])) {
                        self::followUser();
                    } elseif (isset($_POST['unfollow_user_id'])) {
                        self::unfollowUser();
                    }
                } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    if (isset($_GET['tweet_id'])) {
                        self::showLikes();
                    } elseif (isset($_GET['tweets_user_id'])) {
                        self::showTweets();
                    }
                }
        
                include 'views/tweets.php';
                
            }
        
            private static function createTweet() {
                $content = $_POST['content'];
                $imagePath = NULL;
        
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $imageTmpPath = $_FILES['image']['tmp_name'];
                    $imageName = basename($_FILES['image']['name']);
                    $imagePath = 'uploads/' . $imageName;
        
                    if (!is_writable('uploads')) {
                        die("Uploads directory is not writable.");
                    }
        
                    if (!move_uploaded_file($imageTmpPath, $imagePath)) {
                        die("Error uploading image. Temp path: $imageTmpPath, Destination path: $imagePath");
                    }
                }
        
                Tweet::create($_SESSION['user_id'], $content, $imagePath);
                header("Location: index.php");
                exit;
            }
        
            private static function likeTweet() {
                Like::add($_SESSION['user_id'], $_POST['like_tweet_id']);
                header("Location: index.php");
                exit;
            }
        
            private static function unlikeTweet() {
                Like::remove($_SESSION['user_id'], $_POST['unlike_tweet_id']);
                header("Location: index.php");
                exit;
            }
        
            private static function followUser() {
                User::follow($_SESSION['user_id'], $_POST['follow_user_id']);
                header("Location: index.php");
                exit;
            }
        
            private static function unfollowUser() {
                User::unfollow($_SESSION['user_id'], $_POST['unfollow_user_id']);
                header("Location: index.php");
                exit;
            }
        
            private static function showLikes() {
                $tweet_id = $_GET['tweet_id'];
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("SELECT users.username FROM likes JOIN users ON likes.user_id = users.id WHERE likes.tweet_id = :tweet_id");
                $stmt->execute(['tweet_id' => $tweet_id]);
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($users);
                exit;
            }
        
            private static function showTweets() {
                $user_id = $_GET['tweets_user_id'];
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("SELECT tweets.content, tweets.created_at FROM tweets WHERE tweets.user_id = :user_id ORDER BY tweets.created_at DESC");
                $stmt->execute(['user_id' => $user_id]);
                $tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($tweets);
                exit;
            }
        }
        ?>