<?php 
declare(strict_types = 1);
require_once(__DIR__ . '/../templates/common.tpl.php');

drawHeader("Registration");
?>
<main class="authentication">
    <section id="credentials-form">
        <h1>Welcome to TicketZone!</h1>
        <p>Register to create and manage your tickets.</p>
        <form method="post" action="../actions/action_registration.php ">
            <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
            <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="password" id="repeat_password" name="repeat_password" placeholder="Repeat Password" required>
            <input type="submit" value="Register">
            <p>Already have an account? <a href="../pages/login_page.php">Login here</a></p>
        </form>
    </section>
</main>
<?php
drawFooter();
?>
