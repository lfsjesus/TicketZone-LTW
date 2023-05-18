<?php

declare(strict_types=1);

require_once(__DIR__ .  '/../templates/common.tpl.php');
require_once(__DIR__ .  '/../templates/ticket.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../utils/utils.php');

$session = new Session();

if (!$session->isLoggedIn()) {
  header('Location: ../pages/login_page.php');
  die();
}

$db = getDatabaseConnection();
drawHeader("My Tickets");
?>
<section id="main-wrapper">
  <?php
  drawNavbar($session);
  ?>
  <main>
    <?php
    drawUserTicketHeader($session);
    if (!$session->isLoggedIn()) {
      echo '<h1>Access denied</h1>';
    } else {
      $user = $session->getUser();
    ?>
      <table class="ticket-list">
        <form>
          <thead>
            <tr>
              <th><input type="checkbox" id="select-all" name="select-all" value="select-all"></th>
              <th>
                <select name="author" id="author" <?= !$isAdminOrAgent ? 'disabled' : ''?>>
                  <option value="" disabled selected hidden>Author</option>
                  <option value="all">All</option>
                  <?php
                  $users = User::getUsers($db);
                  foreach ($users as $user) {
                    echo '<option value="' . $user->id . '">' . $user->name() . '</option>';
                  }
                  ?>
                </select>
              </th>
              <th>Message</th>
              <th>
                <select name="assignee" id="assignee" <?= !$isAdminOrAgent  ? 'disabled' : ''?>>
                  <option value="" disabled selected hidden>Assignee</option>
                  <option value="all">All</option>
                  <?php
                  $agents = User::getAgents($db);
                  foreach ($agents as $agent) {
                    echo '<option value="' . $agent->id . '">' . $agent->name() . '</option>';
                  }
                  ?>
                </select>
              </th>
              <th>
                <select name="status" id="status">
                  <option value="" disabled selected hidden>Status</option>
                  <option value="all">All</option>
                  <?php
                  $statuses = getStatus($db);
                  foreach ($statuses as $status) {
                    echo '<option>' . $status['name'] . '</option>';
                  }
                  ?>
                </select>
              </th>
              <th>
                <select name="priority" id="priority">
                  <option value="" disabled selected hidden>Priority</option>
                  <option value="all">All</option>
                  <option value="high">High</option>
                  <option value="medium">Medium</option>
                  <option value="low">Low</option>
                </select>
              </th>
              <th>
                <select name="department" id="department">
                  <option value="" disabled selected hidden>Department</option>
                  <option value="all">All</option>
                  <?php
                  $departments = Department::getDepartments($db);
                  foreach ($departments as $department) {
                    echo '<option value="' . $department->id . '">' . $department->name . '</option>';
                  }
                  ?>
                </select>
              </th>
              <th>
                <select name="date" id="date">
                  <option value="newest">Newest</option>
                  <option value="oldest">Oldest</option>
                </select>
              </th>
            </tr>
          </thead>
        </form>
        <tbody>
        <?php
      }
        ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="8">
              <div class="pagination">
              </div>
            </td>
          </tr>
        </tfoot>
      </table>

  </main>
</section>
<?php
drawFooter();
?>