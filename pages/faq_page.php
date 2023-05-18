<?php

declare(strict_types=1);

require_once(__DIR__ .  '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');

$session = new Session();

if (!$session->isLoggedIn()) {
  header('Location: ../pages/login_page.php');
  die();
}

$db = getDatabaseConnection();

$userType = $session->getUser()->type;

drawHeader("FAQ");
?>
<div id="main-wrapper">
  <?php
  drawNavbar($session);
  ?>
  <main id="faq-page">
    <header>
      <h1>Frequently Asked Questions - FAQ</h1>
      <?php
      if ($userType === 'admin' || $userType === 'agent') {
        echo '<a class="create-button" href="/../pages/add_faq.php"><span class="material-symbols-outlined">add_circle</span>Add FAQ</a>';
      }
      ?>
    </header>
    <section class="faq">
      <?php
      $faqs = $db->query('SELECT * FROM FAQ');
      echo '<ol>';
      foreach ($faqs as $faq) {
        echo '<li id="' . $faq['id'] . '">';
        echo '<header>';
        echo '<h2>' . htmlspecialchars($faq['question']) . '</h2>';
        if ($userType === 'admin' || $userType === 'agent') {
          echo '<button class="delete"><span class="material-symbols-outlined">delete</span></button>';
        }
        echo '</header>';
        echo '<p>' . htmlspecialchars($faq['answer']) . '</p>';
        echo '</li>';
      }
      echo '</ol>';
      ?>
    </section>
  </main>
</div>
<?php
drawFooter();
?>