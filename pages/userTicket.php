<?php 
  declare(strict_types = 1);

  require_once(__DIR__ .  '/../templates/common.tpl.php');
  require_once(__DIR__ .  '/../templates/ticket.tpl.php');
  require_once(__DIR__ . '/../utils/session.php');

  $session = new Session();
  drawHeader();
  drawNavbar($session);
  drawSearchbar();
?>

<main>
<?php 
    drawTicket();
    drawTicket();
    drawTicket();
    drawTicket();
?>
  </main>
<?php
  drawFooter();
?>