<?php

declare(strict_types=1);

require_once(__DIR__ .  '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../templates/user.tpl.php');

$session = new Session();

if (!$session->isLoggedIn()) {
  header('Location: ../pages/login_page.php');
  die();
}

$db = getDatabaseConnection();
$user = User::getUser($db, $session->getId());

if ($user->id !== $session->getUser()->id) {
  header('Location: ../pages/userTicket_page.php');
  die();
}

drawHeader("Edit Profile");
?>
  <?php
  drawNavbar($session);
  ?>
  <main id="profile">
    <?php
    drawProfileForm($user);
    ?>
  </main>
<?php
drawFooter();
?>