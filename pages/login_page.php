<?php

declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');

function draw_login()
{
    $error = $_GET['error'];
?>
<!DOCTYPE html>
  <html lang="en-US">

  <head>
    <title>Login - TicketZone</title>
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
  </head>
    <main class="authentication">
        <section id="credentials-form">
            <h1>Nice to see you again...</h1>
            <p> Login to your account to continue.</p>
            <form method="post" action="../actions/action_login.php" class="login">
                <input type="email" id="email" name="email" placeholder="Email" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <input type="submit" name="login" value="Login">
                <p>Don't have an account? <a href="registration_page.php">Register here</a></p>
                <span><?php echo $error ?></span>
            </form>
        </section>
    </main>
</body>
</html>
<?php
}
$session = new Session();
if ($session->isLoggedIn()) {
    header('Location: ../pages/userTicket_page.php');
} else {
    draw_login();
}

?>