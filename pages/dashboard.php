<?php 
declare(strict_types = 1);

require_once(__DIR__ .  '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();

drawHeader("Dashboard");
?>
<section id = "dashboard">
<?php
drawNavbar($session);
?>
  <main id = "home_main">
      <h1>Welcome <?php echo $session->getUser()->firstName ?>, to TicketZone.</h1>
  </main>
</section>
<?php
  drawFooter();
?>