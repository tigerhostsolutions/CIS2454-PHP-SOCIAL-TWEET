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