<?php
declare(strict_types = 1);

require_once(__DIR__ .  '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

$session = new Session();
$db = getDatabaseConnection();
$departments = $db->prepare('SELECT name FROM Departments');
$departments->execute();
$departments = $departments->fetchAll();

drawHeader("Create Ticket");
?>
<section id = "main-wrapper">
    <?php
    drawNavbar($session);
?>
    <main id = "create-ticket-page">
        <h1>Create Ticket</h1>
        <form action="../actions/action_create_ticket.php" class="ticket-form" method="post" enctype="multipart/form-data">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" placeholder="Title" required>
        <label for="department">Department</label>
        <select name="department" id="department">
            <?php foreach ($departments as $department) { ?>
                <option value="<?= $department['name'] ?>"><?= $department['name'] ?></option>
            <?php } ?>
        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="20" placeholder="Ticket description" required></textarea>
        <label for="file">Files</label>
        <input type="file" name="file_name[]" id="file" multiple>
        <input type="submit" value="Create Ticket">
        </form>
    </main>
</section>
<?php
  drawFooter();
?>
