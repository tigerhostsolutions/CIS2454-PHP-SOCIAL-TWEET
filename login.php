<?php
// login.php
    session_start();
    $baseDir = __DIR__ . '/';
    include $baseDir . 'models/Database.php';
    
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
    
    include $baseDir . '/views/header.php';
?>

    <main >
        <h1 >Login Social Tweet</h1 >
        <form method = "POST" action = "login.php" >
            <label >
                <input type = "email" name = "email" placeholder = "Email" required >
            </label >
            <label >
                <input type = "password" name = "password" placeholder = "Password" required >
            </label >
            <button type = "submit" formtarget = "_self" >Login</button >
        </form >
    </main >

<?php
    $baseDir = __DIR__ . '/';
    include $baseDir . '/views/footer.php';
?>