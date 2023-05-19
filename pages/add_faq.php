<?php

declare(strict_types=1);

require_once(__DIR__ .  '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');

$session = new Session();
$userType = $session->getUser()->type;
$isAdminOrAgent = ($userType == 'admin' || $userType == 'agent');

if (!$session->isLoggedIn()) {
    header('Location: ../pages/login_page.php');
    die();
}

if (!$isAdminOrAgent) {
    header('Location: ../pages/faq_page.php');
    die();
}

$db = getDatabaseConnection();

drawHeader("Add FAQ");
?>
<div id="main-wrapper">
    <?php
    drawNavbar($session);
    ?>
    <main id="add-faq-page">
        <h1>Add FAQ</h1>
        <form action="../actions/action_add_faq.php" class="faq-form" method="post">
            <label for="question">Question</label>
            <input type="text" name="question" id="question" placeholder="Question" required>
            <label for="answer">Answer</label>
            <textarea name="answer" id="description" cols="30" rows="20" placeholder="FAQ answer" required></textarea>
            <input type="submit" value="Create FAQ">
        </form>
    </main>
</div>
<?php
drawFooter();
?>