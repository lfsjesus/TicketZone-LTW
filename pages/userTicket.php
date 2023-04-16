<?php 
declare(strict_types = 1);

require_once(__DIR__ .  '/../templates/common.tpl.php');
require_once(__DIR__ .  '/../templates/ticket.tpl.php');

?>

  <?php
  drawHeader();
  drawNavbar();
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