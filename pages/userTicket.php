<?php 
  declare(strict_types = 1);

  require_once(__DIR__ .  '/../templates/common.tpl.php');
  require_once(__DIR__ .  '/../templates/ticket.tpl.php');
  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/user.class.php');

  $session = new Session();
  $db = getDatabaseConnection();
  drawHeader("My Tickets");
?>
  <section id="main-wrapper">
<?php
  drawNavbar($session);
?>
<main>
<?php 
drawSearchbar();
if (!$session->isLoggedIn()) {
  echo '<h1>Access denied</h1>';
}
else {
  $user = $session->getUser();
?>
    <table class="ticket-list">
    <form action="../api/api.php?" method="get">
      <thead>
        <tr>
          <th><input type="checkbox" id="select-all" name="select-all" value="select-all"></th>
          <th>
            <select name="author" id="author">
              <option value="all">All</option>
              <?php
                $users = User::getUsers($db);
                foreach ($users as $user) {
                  echo '<option value="' . $user->id . '">' . $user->name() . '</option>';
                }
              ?>

          </th>
          <th>Message</th>
          <th>
            <select name="assignee" id="assignee">
            <option value="all">All</option>
            <?php
                $agents = User::getAgents($db);
                foreach ($agents as $agent) {
                  echo '<option value="' . $agent->id . '">' . $agent->name() . '</option>';
                }
              ?>

          </th>
          <th>
            <select name="status" id="status">
              <option value="all">All</option>
              <option value="open">Open</option>
              <option value="closed">Closed</option>
          </th>
          <th>
            <select name="priority" id="priority">
              <option value="all">All</option>
              <option value="high">High</option>
              <option value="medium">Medium</option>
              <option value="low">Low</option>
          </th>
          <th>
            <select name="date" id="date">
              <option value="newest">Newest</option>
              <option value="oldest">Oldest</option>
          </th>
        </tr>       
      </thead>
      <th style="display:none"><button type="submit" class="material-symbols-outlined" >filter_alt</button><th>
      </form>
      <tbody>
    <?php
      }
    ?>
      </tbody>

    </table>
    <div class = "pagination"></div>
  </main>
</section>
<?php
  drawFooter();
?>