<?php 
declare(strict_types = 1);
require_once(__DIR__ . '/../utils/session.php');
?>

<?php
function draw_login() {
    ?>
    <form method="post" action="../actions/action_login.php" class="login"> 
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" name="login" value="Login">
    </form>
    <?php
}
    $session = new Session();

    if ($session->isLoggedIn()) {
        header('Location: ../pages/dashboard.php');
    }
    else {
        draw_login();
    }

?>

<p>Don't have an account? <a href="registration_page.php">Register here</a></p>
