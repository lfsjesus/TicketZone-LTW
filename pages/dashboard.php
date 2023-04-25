<?php 
declare(strict_types = 1);

require_once(__DIR__ .  '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

$session = new Session();
$db = getDatabaseConnection();
$user = User::getUser($db, $session->getId());

drawHeader("Dashboard");
?>
<section id = "main-wrapper">
<?php
  drawNavbar($session);
?>
  <main id = "home_main">
      <h1>Welcome <?php echo $user->username ?>, to TicketZone.</h1>
  </main>
</section>
<?php
  drawFooter();
?>