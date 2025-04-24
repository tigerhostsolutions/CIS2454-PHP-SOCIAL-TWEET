-- Drop tables if they exist
DROP TABLE IF EXISTS likes;
DROP TABLE IF EXISTS follows;
DROP TABLE IF EXISTS tweets;
DROP TABLE IF EXISTS users;

-- Users Table
CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       username VARCHAR(50) NOT NULL UNIQUE,
                       email VARCHAR(100) NOT NULL UNIQUE,
                       password VARCHAR(255) NOT NULL,
                       bio TEXT DEFAULT NULL,
                       profile_pic VARCHAR(255) DEFAULT NULL,
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tweets Table
CREATE TABLE tweets (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        user_id INT NOT NULL,
                        content TEXT NOT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        likes_count INT DEFAULT 0,
                        retweets_count INT DEFAULT 0,
                        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

-- Follows Table
CREATE TABLE follows (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         follower_id INT NOT NULL,
                         following_id INT NOT NULL,
                         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                         FOREIGN KEY (follower_id) REFERENCES users (id) ON DELETE CASCADE,
                         FOREIGN KEY (following_id) REFERENCES users (id) ON DELETE CASCADE
);

-- Likes Table
CREATE TABLE likes (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       user_id INT NOT NULL,
                       tweet_id INT NOT NULL,
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
                       FOREIGN KEY (tweet_id) REFERENCES tweets (id) ON DELETE CASCADE
);
