<?php
    /**
     * register.php
     *
     * This script handles user registration for the Social Tweet application.
     * It processes form submissions, hashes passwords, stores new user data
     * in the database, and manages user sessions upon successful registration.
     */
    
    use App\Models\Database;
    
    session_start();
    
    // Require necessary configuration and model files.
    // __DIR__ ensures the path is relative to the current script's directory.
    require_once __DIR__ . '/config.php';          // Contains application-wide configurations (e.g., database credentials).
    require_once MODEL_PATH . 'Database.php';      // Includes the Database class definition for database connection.
    require_once VIEW_PATH . 'header.php';         // Includes the common HTML header for the page.
    
    // Get the database connection
    $pdo = Database::getConnection();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password]);
        
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username; // Store username in session
        header("Location: index.php");
    }
?>

<main>
    <h1>Register New Social Tweet Account</h1>
    <form method="POST" action="register.php">
        <label >
            <input type="text" name="username" placeholder="Username" required>
        </label >
        <label >
            <input type="email" name="email" placeholder="Email" required>
        </label >
        <label >
            <input type="password" name="password" placeholder="Password" required>
        </label >
        <button type="submit">Register</button>
    </form>
</main>

<?php
    require_once VIEW_PATH . 'footer.php';
?>
