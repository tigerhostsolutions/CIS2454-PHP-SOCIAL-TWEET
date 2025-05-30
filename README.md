# PHP Bad Twitter

A simple, basic social media application built with PHP, demonstrating fundamental web development concepts including user management, tweet creation, and interactions like liking and following.

---

## 📝 Description

This project provides a foundational social media experience where users can:

- Register and log in
- Post text-based tweets (with a placeholder for image uploads)
- View their own tweets and those from users they follow
- Manage followers
- Like and unlike tweets

It leverages **core PHP** for backend logic, **PDO** for database interaction, and uses **vlucas/phpdotenv** for environment variable management.

---

## ✨ Features

- **User Authentication:**  
  Complete user registration, secure login via password hashing, and session-based logout.

- **Tweet Management:**  
  - Compose and post new tweets  
  - View all tweets from your network (your own and those you follow)  
  - Like and unlike tweets

- **User Relationships:**  
  - Follow/unfollow other users  
  - View lists of your followers and who you are following

- **User Profiles:**  
  Dedicated profile page displaying a user's own tweets, their followers, and who they are following.

- **Centralized Configuration:**  
  Utilizes `config.php` for application-wide settings and `.env` for sensitive credentials.

---

## 🛠️ Technologies Used

- **PHP:** Core backend logic and view rendering
- **MySQL:** Relational database for storing all application data
- **PDO:** Secure and parameterized database queries
- **Composer:** PHP dependency manager
- **Dotenv (vlucas/phpdotenv):** For loading environment variables
- **HTML & CSS:** Basic structure and styling

---

## 🚀 Getting Started

### Prerequisites

- PHP 7.4 or higher
- Composer
- MySQL (or compatible PDO-supported database)
- A web server (Apache, Nginx, or PHP's built-in server)

### Installation

1. **Clone the repository:**
    ```sh
    git clone https://github.com/tigerhostsolutions/php-bad-twitter.git
    cd php-bad-twitter
    ```

2. **Install Composer dependencies:**
    ```sh
    composer install
    ```

3. **Database Setup:**
    - Create a new MySQL database (e.g., `php_bad_twitter`).
    - Execute the following SQL schema:
    ```sql
    CREATE TABLE users (
      id INT AUTO_INCREMENT PRIMARY KEY,
      username VARCHAR(50) NOT NULL UNIQUE,
      email VARCHAR(100) NOT NULL UNIQUE,
      password VARCHAR(255) NOT NULL,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE tweets (
      id INT AUTO_INCREMENT PRIMARY KEY,
      user_id INT NOT NULL,
      content TEXT NOT NULL,
      image_path VARCHAR(255),
      likes_count INT DEFAULT 0,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    );

    CREATE TABLE likes (
      id INT AUTO_INCREMENT PRIMARY KEY,
      user_id INT NOT NULL,
      tweet_id INT NOT NULL,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
      FOREIGN KEY (tweet_id) REFERENCES tweets(id) ON DELETE CASCADE,
      UNIQUE (user_id, tweet_id)
    );

    CREATE TABLE follows (
      id INT AUTO_INCREMENT PRIMARY KEY,
      follower_id INT NOT NULL,
      following_id INT NOT NULL,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      FOREIGN KEY (follower_id) REFERENCES users(id) ON DELETE CASCADE,
      FOREIGN KEY (following_id) REFERENCES users(id) ON DELETE CASCADE,
      UNIQUE (follower_id, following_id)
    );
    ```

4. **Environment Configuration (`.env`):**
    - Create a `.env` file in the project root:
    ```
    ENVIRONMENT=local
    DB_LOCAL_HOST=localhost
    DB_PORT=3306
    DB_NAME=php_bad_twitter
    DB_USER=your_db_username
    DB_PASS=your_db_password
    ```
    - Ensure your web server can read this file.

5. **Web Server Configuration:**
    - **Apache Example:**
      ```apache
      <VirtualHost *:80>
        DocumentRoot "/path/to/your/php-bad-twitter"
        <Directory "/path/to/your/php-bad-twitter">
          AllowOverride All
          Require all granted
        </Directory>
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
      </VirtualHost>
      ```
    - **PHP Built-in Server:**
      ```sh
      php -S localhost:8000
      ```
      Then open [http://localhost:8000](http://localhost:8000) in your browser.

---

## 🏃 Usage

- **Register:** [http://localhost:8000/register.php](http://localhost:8000/register.php)
- **Login:** [http://localhost:8000/login.php](http://localhost:8000/login.php)
- **Main Feed:** [http://localhost:8000/](http://localhost:8000/)
- **Profile Page:** [http://localhost:8000/profile.php](http://localhost:8000/profile.php)
- **Logout:** [http://localhost:8000/logout.php](http://localhost:8000/logout.php)

---

## 📁 File Structure Overview
📦 php-bad-twitter
├── config.php
├── index.php
├── login.php
├── logout.php
├── profile.php
├── register.php
├── uploads/
├── vendor/
└── App/
    ├── Controllers/
    │   ├── TweetController.php
    │   └── UserController.php
    ├── Models/
    │   ├── Database.php
    │   ├── Like.php
    │   ├── Tweet.php
    │   └── User.php
    └── Views/
        ├── header.php
        ├── footer.php
        ├── profile.php
        └── tweets.php
---
## ☁️ Deployment: AWS Elastic Beanstalk

This project can be deployed on AWS Elastic Beanstalk for scalable PHP hosting.

### Steps

1. **Install the AWS CLI and EB CLI:**
    ```sh
    pip install awsebcli --upgrade
    ```

2. **Initialize Elastic Beanstalk:**
    ```sh
    eb init
    ```

3. **Create and deploy the environment:**
    ```sh
    eb create php-bad-twitter-env
    eb deploy
    ```

4. **Open your application:**
    ```sh
    eb open
    ```

- Ensure your `.env` and database credentials are set up securely.
- For persistent storage (e.g., `uploads/`), use Amazon S3.

See [AWS Elastic Beanstalk PHP documentation](https://docs.aws.amazon.com/elasticbeanstalk/latest/dg/create-deploy-php.html) for more details.