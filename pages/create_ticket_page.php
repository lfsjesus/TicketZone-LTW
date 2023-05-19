<?php

declare(strict_types=1);

require_once(__DIR__ .  '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/department.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/login_page.php');
    die();
}

$db = getDatabaseConnection();
$departments = Department::getDepartments($db);

drawHeader("Create Ticket");
?>
<div id="main-wrapper">
    <?php
    drawNavbar($session);
    ?>
    <main id="create-ticket-page">
        <h1>Create Ticket</h1>
        <form action="../actions/add/action_add_ticket.php" class="ticket-form" method="post" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" placeholder="Title" required>
            <label for="department">Department</label>
            <select name="department" id="department">
                <?php foreach ($departments as $department) { ?>
                    <option value="<?= $department->name ?>"><?= $department->name ?></option>
                <?php } ?>
                <label for="description">Description</label>
                <textarea name="description" id="description" cols="30" rows="20" placeholder="Ticket description" required></textarea>
                <label for="file">Files</label>
                <input type="file" name="file_name[]" id="file" multiple>
                <input type="submit" value="Create Ticket">
        </form>
    </main>
</div>
<?php
drawFooter();
?>