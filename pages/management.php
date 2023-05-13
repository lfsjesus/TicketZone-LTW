<?php 
declare(strict_types = 1);

require_once(__DIR__ .  '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

$session = new Session();
$db = getDatabaseConnection();

  drawHeader("Management");
  ?>
  <section id = "main-wrapper">
  <?php
  drawNavbar($session);
  ?>
    <main id = "management-page">
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
        <!-- list all users -->
            <table>
            <thead>
                <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Role</th>
                <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
            $users = User::getUsers($db);
            foreach ($users as $user) { ?>
                <tr>
                <input type="hidden" name="id" value="<?=$user->id?>">
                <td><?=$user->name()?></td>
                <td><?=$user->email?></td>
                <td>
                    <select name="department_id">
                    <option value="" disabled selected hidden></option>
                    <?php
                    $departments = Department::getDepartments($db);
                    foreach ($departments as $department) { 
                    echo '<option value="' . $department->id . '" ' . ($department->id === $user->department->id ? 'selected' : '') . '>' . $department->name . '</option>';
                    }
                    ?>
                    </select>
                </td>
                <td>
                    <select name="type">
                    <option value="" disabled selected hidden></option>
                    <option value="user" <?php echo $user->type === 'client' ? 'selected' : ''; ?>>Client</option>
                    <option value="agent" <?php echo $user->type === 'agent' ? 'selected' : ''; ?>>Agent</option>
                    <option value="admin" <?php echo $user->type === 'admin' ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </td>
                <td>
                    <form action="../actions/action_delete_user.php" method="post">
                        <button class="delete" name="id" value="<?=$user->id?>" type="submit"><span class="material-symbols-outlined">delete</span></button>
                    </form>
                </td>
                </tr>
            <?php } ?>
            </tbody>
            </table>

        </section>
        <section class="departments">
        <table>
          <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>
                <button class="add-department">
                    <a href=""><span class="material-symbols-outlined">add_circle</span>Add Department</a>
                </button>
              </th>
            </tr>
          </thead>
          <tbody>
          <?php
          $departments = Department::getDepartments($db);
          foreach ($departments as $department) { ?>
            <tr>
              <td><?=$department->id?></td>
              <td><?=$department->name?></td>
              <td>
                <button class="delete"><span class="material-symbols-outlined">delete</span></button>
              </td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
        </section>
        <section class="statuses">
        </section>
    </main>
  </section>
  <?php
  drawFooter();
?>