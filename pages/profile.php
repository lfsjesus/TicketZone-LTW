<?php 
declare(strict_types = 1);

require_once(__DIR__ .  '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../templates/user.tpl.php');

$session = new Session();

$db = getDatabaseConnection();
$user = User::getUser($db, $session->getId());

  drawHeader("Profile");
  ?>
  <section id = "profile">
  <?php
  drawNavbar($session);
  drawProfileForm($user);
  ?>
  </section>
  <?php
  drawFooter();
?>