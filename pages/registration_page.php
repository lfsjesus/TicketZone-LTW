<?php

declare(strict_types=1);
require_once(__DIR__ . '/../templates/common.tpl.php');

$error = $_GET['error'];
?>
<!DOCTYPE html>
  <html lang="en-US">
  <head>
    <title>Registration - TicketZone</title>
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
  </head>
    <main class="authentication">
        <section id="credentials-form">
            <h1>Welcome to TicketZone!</h1>
            <p>Register to create and manage your tickets.</p>
            <form method="post" action="../actions/action_registration.php">
                <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
                <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
                <input type="text" id="username" name="username" placeholder="Username" required>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <input type="password" id="repeat_password" name="repeat_password" placeholder="Repeat Password" required>
                <input type="submit" value="Register">
                <p>Already have an account? <a href="../pages/login_page.php">Login here</a></p>
                <span><?php echo $error ?></span>
            </form>
        </section>
    </main>
</body>
</html>
