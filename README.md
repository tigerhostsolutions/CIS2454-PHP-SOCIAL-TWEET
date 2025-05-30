PHP Bad Twitter
A simple, basic social media application built with PHP, demonstrating fundamental web development concepts including user management, tweet creation, and interactions like liking and following.

📝 Description
This project is a small-scale social media platform where users can register, log in, post tweets (with optional images), view a feed of tweets (including their own and those from users they follow), like/unlike tweets, and follow/unfollow other users. It's built with a focus on core PHP functionalities and basic MVC-like separation, utilizing PDO for database interactions and Composer for dependency management.

✨ Features
User Authentication: Secure user registration, login, and logout.

Tweet Management: Create new tweets with text content and optional image uploads.

Tweet Feed: View a timeline of tweets, including those from followed users.

User Interactions:

Like/Unlike: Users can like and unlike tweets.

Follow/Unfollow: Users can follow and unfollow other users to customize their feed.

User Profiles: Dedicated pages to view a user's own tweets, their followers, and who they are following.

Environment Configuration: Utilizes .env files for managing sensitive credentials and environment-specific settings.

🛠️ Technologies Used
PHP: Core backend logic and templating.

MySQL: Relational database for storing user, tweet, like, and follow data.

PDO: PHP Data Objects for secure and efficient database interaction.

Composer: PHP dependency manager (specifically for vlucas/phpdotenv).

Dotenv: Library for loading environment variables from .env files.

HTML & CSS: For structuring and styling the web interface.

🚀 Getting Started
Follow these steps to get a local copy of the project up and running on your machine.

Prerequisites
PHP 7.4 or higher

MySQL (or a compatible database)

Composer (for dependency management)

A web server (Apache, Nginx, or PHP's built-in server)

Installation
Clone the repository:

git clone https://github.com/your-username/php-bad-twitter.git
cd php-bad-twitter

(Note: Replace https://github.com/your-username/php-bad-twitter.git with your actual repository URL)

Install Composer dependencies:

composer install

Database Setup:

Create a new MySQL database (e.g., php_bad_twitter).

Execute the following SQL schema to set up the necessary tables:

-- SQL Schema for php_bad_twitter database

-- Create users table
CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(50) NOT NULL UNIQUE,
email VARCHAR(100) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL, -- Hashed password
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create tweets table
CREATE TABLE tweets (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
content TEXT NOT NULL,
image_path VARCHAR(255), -- Optional image path
likes_count INT DEFAULT 0,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create likes table
CREATE TABLE likes (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
tweet_id INT NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
FOREIGN KEY (tweet_id) REFERENCES tweets(id) ON DELETE CASCADE,
UNIQUE (user_id, tweet_id) -- A user can like a tweet only once
);

-- Create follows table
CREATE TABLE follows (
id INT AUTO_INCREMENT PRIMARY KEY,
follower_id INT NOT NULL,
following_id INT NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (follower_id) REFERENCES users(id) ON DELETE CASCADE,
FOREIGN KEY (following_id) REFERENCES users(id) ON DELETE CASCADE,
UNIQUE (follower_id, following_id) -- A user can follow another user only once
);

(Optional: You might want to add some dummy data for testing.)

Environment Configuration (.env):

Create a file named .env in the project root directory (same level as composer.json).

Add your database credentials and application environment settings to it.

ENVIRONMENT=local # Set to 'local' for development, 'production' for deployment

DB_LOCAL_HOST=localhost
DB_REMOTE_HOST=your_remote_db_host # If applicable
DB_PORT=3306
DB_NAME=php_bad_twitter
DB_USER=your_db_username
DB_PASS=your_db_password

Ensure your web server has read access to this file.

Web Server Configuration:

Document Root: Point your web server's document root to the project root directory (/php-bad-twitter/).

For Apache, your Virtual Host might look something like this:

<VirtualHost *:80>
DocumentRoot "/path/to/your/php-bad-twitter"
<Directory "/path/to/your/php-bad-twitter">
AllowOverride All
Require all granted
</Directory>
ErrorLog ${APACHE_LOG_DIR}/error.log
CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

(Adjust /path/to/your/php-bad-twitter accordingly)

For PHP's built-in server (for quick local testing):

php -S localhost:8000

Then open your browser to http://localhost:8000.

🏃 Usage
Register: Navigate to http://localhost[:port]/register.php (or your configured URL) to create a new user account.

Login: After registration, or if you already have an account, log in via http://localhost[:port]/login.php.

Tweet Feed: Upon successful login, you will be redirected to index.php which displays the main tweet feed.

Profile: Access your profile via profile.php to see your tweets, followers, and who you're following.

Logout: Use logout.php to end your session.

📁 File Structure Overview
config.php: Central configuration file for base URLs and directory paths.

index.php: The main entry point of the application, delegating to TweetController.

login.php: Handles user login.

logout.php: Handles user logout.

profile.php: Entry point for the user profile page, delegating to UserController.

register.php: Handles new user registration.

uploads/: Directory for storing uploaded tweet images.

vendor/: Composer dependencies (e.g., phpdotenv).

App/: Contains the application's core logic.

Controllers/: Handles incoming requests, processes data, and delegates to models/views.

TweetController.php: Manages tweet-related actions (create, like, unlike).

UserController.php: Manages user profile and follow/unfollow actions.

Models/: Encapsulates database interactions and business logic.

Database.php: Manages PDO database connections.

Like.php: Handles liking and unliking tweets (used by Tweet model).

Tweet.php: Manages tweet data (create, retrieve, like/unlike logic).

User.php: Manages user data and follow/unfollow relationships.

Views/: Contains HTML templates for different parts of the application.

header.php: Common HTML header.

footer.php: Common HTML footer.

tweets.php: The main tweet feed display.

⚠️ Important Notes
Security: This is a basic demonstration. For a production environment, additional security measures would be required (e.g., more robust input validation, CSRF protection, secure password hashing algorithms like Argon2id, proper error logging without exposing details to users, stricter file upload validation).

Error Handling: Basic error handling is present, but could be enhanced with custom error pages and more sophisticated logging mechanisms.

Scalability: The current model is simple. For large-scale applications, consider more advanced architectural patterns and database optimizations.