<?php
// login.php
session_start();
include 'includes/config/database.php';

$pdo = Database::getConnection(); // Initialize the $pdo variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username']; // Store username in session
        header("Location: index.php");
    } else {
        echo "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<main>
    <form method="POST" action="login.php">
        <label>
            <input type="email" name="email" placeholder="Email" required>
        </label>
        <label>
            <input type="password" name="password" placeholder="Password" required>
        </label>
        <br><br>
        <button type="submit">Login</button>
        <a href="register.php">
            <button type="button">Register</button>
        </a>
    </form>
</main>