<?php
declare(strict_types=1);
require_once(__DIR__ .  '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../utils/utils.php');

$session = new Session();

if (!$session->isLoggedIn()) {
  header('Location: ../pages/login_page.php');
  exit();
} 

if (!$session->getUser()->isAdmin()) {
  header('Location: ../pages/userTicket_page.php');
  exit();
}

$db = getDatabaseConnection();

drawHeader("Management");
?>
<div id="main-wrapper">
  <?php
  drawNavbar($session);
  ?>
  <main id="management-page">
    <header>
      <h1>Management</h1>
      <!-- tabs to switch between people, departments and statuses. icon and text -->
      <div class="tabs">
        <a class="active"><span class="material-symbols-outlined">people</span>People</a>
        <a><span class="material-symbols-outlined">apartment</span>Departments</a>
        <a><span class="material-symbols-outlined">track_changes</span>Statuses</a>
      </div>
    </header>
    <section class="people active">
      <header>
        <form class="search-form">
          <input type="text" placeholder="Search for person's name" name="personName">
          <button type="submit"><span class="material-symbols-outlined">search</span></button>
        </form>
      </header>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
              <th>
                <select name="department_id" id="department_id">
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
                <select name="type" id="type">
                  <option value="" disabled selected hidden>Role</option>
                  <option value="all">All</option>
                  <option value="admin">Admin</option>
                  <option value="agent">Agent</option>
                  <option value="client">Client</option>
                </select>
              </th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="5">
              <div class="pagination">
              </div>
            </td>
          </tr>
        </tfoot>
      </table>
    </section>
    <section class="departments">
      <table>
        <thead>
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>-</td>
            <td class="add-entry">
              <form action="../actions/add/action_add_department.php" method="post">
                <input type="text" name="department" placeholder="Add a new department">
                <button type="submit" class="material-symbols-outlined">add</button>
              </form>
            </td>
            <td></td>
          </tr>
          <?php
          $departments = Department::getDepartments($db);
          foreach ($departments as $department) { ?>
            <tr>
              <td><?= $department->id ?></td>
              <td><?= $department->name ?></td>
              <td>
                <form action="../actions/delete/action_delete_department.php" method="post">
                  <button class="delete" name="department_id" value="<?= $department->id ?>" type="submit"><span class="material-symbols-outlined">delete</span></button>
                </form>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </section>
    <section class="statuses">
      <table>
        <thead>
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>-</td>
            <td class="add-entry">
              <form action="../actions/add/action_add_status.php" method="post">
                <input type="text" name="status" placeholder="Add a new Status">
                <button type="submit" class="material-symbols-outlined">add</button>
              </form>
            </td>
            <td></td>
          </tr>
          <?php
          $statuses = getStatus($db);
          foreach ($statuses as $status) { ?>
            <tr>
              <td><?= $status['id'] ?></td>
              <td><?= $status['name'] ?></td>
              <td>
                <form action="../actions/delete/action_delete_status.php" method="post">
                  <button class="delete" name="status_id" value="<?= $status['id'] ?>" type="submit"><span class="material-symbols-outlined">delete</span></button>
                </form>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </section>
  </main>
</div>
<?php
drawFooter();
?>