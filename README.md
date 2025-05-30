PHP Bad Twitter
A simple, basic social media application built with PHP, demonstrating fundamental web development concepts including user management, tweet creation, and interactions like liking and following.

📝 Description
This project provides a foundational social media experience where users can register, log in, post text-based tweets (with a placeholder for image uploads), view their own tweets, see tweets from users they follow, manage followers, and interact with tweets by liking them. It leverages core PHP for backend logic, PDO for database interaction, and uses vlucas/phpdotenv for environment variable management.

✨ Features
User Authentication: Complete user registration, secure login via password hashing, and session-based logout.

Tweet Management:

Compose and post new tweets.

View all tweets from your network (your own and those you follow).

Like and unlike tweets.

User Relationships:

Follow other users to see their tweets in your feed.

Unfollow users.

View lists of your followers and who you are following on your profile.

User Profiles: Dedicated profile page displaying a user's own tweets, their followers, and who they are following.

Centralized Configuration: Utilizes config.php for application-wide settings and .env for sensitive credentials.

🛠️ Technologies Used
PHP: Core backend logic and view rendering.

MySQL: Relational database for storing all application data (users, tweets, likes, follows).

PDO: PHP Data Objects for secure and parameterized database queries.

Composer: PHP dependency manager.

Dotenv (vlucas/phpdotenv): For loading environment variables from a .env file.

HTML & CSS: For the basic structure and styling of the web interface.

🚀 Getting Started
Follow these steps to set up and run the application locally.

Prerequisites
PHP 7.4 or higher

Composer

MySQL (or a compatible PDO-supported database)

A web server (e.g., Apache, Nginx, or PHP's built-in development server)

Installation
Clone the repository:

git clone https://github.com/your-username/php-bad-twitter.git
cd php-bad-twitter

(Note: Replace https://github.com/your-username/php-bad-twitter.git with your actual repository URL)

Install Composer dependencies:

composer install

Database Setup:

Create a new MySQL database (e.g., php_bad_twitter).

Execute the following SQL schema to create the necessary tables:

-- SQL Schema for php_bad_twitter database

-- users table: Stores user authentication and profile information
CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(50) NOT NULL UNIQUE,
email VARCHAR(100) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL, -- Stores hashed passwords (e.g., using password_hash())
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- tweets table: Stores user-generated tweets
CREATE TABLE tweets (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
content TEXT NOT NULL,
image_path VARCHAR(255), -- Stores path to optional uploaded images
likes_count INT DEFAULT 0, -- Counter for likes
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- likes table: Records which user liked which tweet
CREATE TABLE likes (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
tweet_id INT NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
FOREIGN KEY (tweet_id) REFERENCES tweets(id) ON DELETE CASCADE,
UNIQUE (user_id, tweet_id) -- Ensures a user can like a specific tweet only once
);

-- follows table: Records follow relationships between users
CREATE TABLE follows (
id INT AUTO_INCREMENT PRIMARY KEY,
follower_id INT NOT NULL,
following_id INT NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (follower_id) REFERENCES users(id) ON DELETE CASCADE,
FOREIGN KEY (following_id) REFERENCES users(id) ON DELETE CASCADE,
UNIQUE (follower_id, following_id) -- Ensures a user can follow another user only once
);

(Optional: Populate with dummy data for initial testing if desired.)

Environment Configuration (.env):

Create a file named .env in the project's root directory.

Add your database credentials and application environment settings to it.

ENVIRONMENT=local # Set to 'local' for development, 'production' for deployment

DB_LOCAL_HOST=localhost
DB_PORT=3306
DB_NAME=php_bad_twitter
DB_USER=your_db_username
DB_PASS=your_db_password

Ensure your web server has read access to this file.

Web Server Configuration:

Document Root: Point your web server's document root to the project's root directory (where index.php and config.php are located).

For Apache (example Virtual Host):

<VirtualHost *:80>
DocumentRoot "/path/to/your/php-bad-twitter"
<Directory "/path/to/your/php-bad-twitter">
AllowOverride All
Require all granted
</Directory>
ErrorLog ${APACHE_LOG_DIR}/error.log
CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

(Adjust /path/to/your/php-bad-twitter to your actual path)

For PHP's built-in development server (for quick local testing):

php -S localhost:8000

Then open your web browser and navigate to http://localhost:8000.

🏃 Usage
Register: Go to http://localhost:8000/register.php to create a new user account.

Login: Access http://localhost:8000/login.php to log into your account.

Main Feed: After logging in, you'll be redirected to index.php (or /), which displays the main tweet feed.

Profile Page: Visit http://localhost:8000/profile.php to see your own tweets, followers, and following.

Logout: Use http://localhost:8000/logout.php to end your session.

📁 File Structure Overview
This project follows a basic organizational structure to separate concerns:

config.php: Central file for application-wide constants and configurations.

index.php: The primary entry point for the main tweet feed.

login.php: Handles user authentication display and processing.

logout.php: Manages session termination.

profile.php: The entry point for user profile pages.

register.php: Handles new user account creation.

uploads/: (Implied) Directory for storing user-uploaded tweet images.

vendor/: Directory for Composer-managed third-party libraries.

App/: Contains the core application logic.

Controllers/: Manages incoming HTTP requests and orchestrates responses.

TweetController.php: Handles tweet creation, liking, and display logic for the main feed.

UserController.php: Manages user profile display, and follow/unfollow actions.

Models/: Encapsulates database interactions and business logic for specific data entities.

Database.php: Manages the PDO database connection.

Like.php: Defines methods for tweet liking/unliking.

Tweet.php: Defines methods for tweet creation, retrieval, and interaction counts.

User.php: Defines methods for user authentication, retrieval, and follow relationships.

Views/: Contains PHP files that act as templates for the HTML output.

header.php: Reusable HTML header for all pages.

footer.php: Reusable HTML footer for all pages.

profile.php: The HTML structure for the user profile page.

tweets.php: The HTML structure for the main tweet feed page.

⚠️ Important Notes
Security: This project is a basic demonstration. For a production environment, comprehensive security measures are crucial, including but not limited to:

Robust input validation and sanitization (beyond htmlspecialchars).

CSRF (Cross-Site Request Forgery) protection.

Using stronger password hashing algorithms (e.g., Argon2id if not already implicitly used by password_hash() in PHP 7.4+).

Proper session handling (e.g., session fixation prevention).

Secure file upload handling (validation, antivirus scanning, storing outside web root).

Error Handling: While basic error handling is present, a production application would benefit from more sophisticated logging, custom error pages, and controlled error reporting.

Scalability: This simple architecture may not scale efficiently for large user bases or complex features. Consider more advanced frameworks or architectural patterns for larger projects.

Missing Features: Based on the submitted files, features like direct messaging, reply functionality, user search, or pagination for feeds are not present.