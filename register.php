<?php
    session_start();
    include 'includes/config/database.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
   
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password]);
        
        $_SESSION['user_id'] = $pdo->lastInsertId();
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
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
        <br > <br >
        <button type="submit" formtarget="_blank">Register</button>
        <a href = "login.php" >
            <button type="button" formtarget="_blank">Login</button>
        </a >
    </form>
    
</main>

