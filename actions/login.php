<?php 
declare(strict_types = 1);

require_once(__DIR__ .  '/../templates/common.tpl.php');

?>

<?php

if(isset($_SESSION['user'])){
    header('Location: ../pages/index.php');
} 

session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // input validation
    if(filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/^[a-zA-Z0-9]+$/', $password)){
        // database connection and query
        $pdo = new PDO('sqlite:' . __DIR__ . '/../database/tickets.db');
        $stmt = $pdo->prepare('SELECT * FROM Users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        // password verification
        if($user && password_verify($password, $user['password'])){
            $_SESSION['user'] = $user;
            header('Location: ../pages/index.php');
            exit();
        } else {
            $error = 'Incorrect email or password.';
        }
    } else {
        $error = 'Invalid input.';
    }
}
?>

<?php if(isset($error)): ?>
<p><?php echo $error; ?></p>
<?php endif; ?>


<?php 
    drawHeader();
    drawNavbar();
   ?> 
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <input type="submit" value="Login">
</form>

<p>Don't have an account? <a href="registration.php">Register here</a></p>
<?php 
    drawFooter();
   ?> 