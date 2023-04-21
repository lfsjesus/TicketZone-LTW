<?php 
  declare(strict_types = 1);

  require_once(__DIR__ .  '/../templates/common.tpl.php');
  require_once(__DIR__ .  '/../templates/ticket.tpl.php');
  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/connection.db.php');

  $session = new Session();
  $db = getDatabaseConnection();
  drawHeader();
  drawNavbar($session);
  drawSearchbar();
?>

<main>
<?php 
  if (!$session->isLoggedIn()) {
    echo '<h1>Access denied</h1>';
  }
  else {
    $user = $session->getUser();
    $tickets = $user->getMyTickets($db); ?>
    <table>
      <thead>
        <tr>
          <th><input type="checkbox" id="select-all" name="select-all" value="select-all"></th>
          <th>Author</th>
          <th>Message</th>
          <th>Assignee</th>
          <th>Status</th>
          <th>Priority</th>
          <th>Last Update</th>
        </tr>
      </thead>
      <tbody>
<?php
    foreach ($tickets as $ticket) {
      drawTicket($ticket);
    }
  }
?>
      </tbody>
    </table>
  </main>
<?php
  drawFooter();
?>