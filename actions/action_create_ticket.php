<?php
declare (strict_types=1);
require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../utils/session.php');

$db = getDatabaseConnection();
$session = new Session();

$department = $_POST['department'];
$department_id = $db->query("SELECT id FROM Departments WHERE name = '$department'")->fetch()['id'];

$user_id = $session->getId();
$title = $_POST['title'];
$description = $_POST['description'];
$status = 'open';
$date = date('Y-m-d H:i:s');   
$faq = false;

$stmt = $db->prepare("INSERT INTO tickets (user_id, department_id, title, description, status, date, faq) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$user_id, $department_id, $title, $description, $status, $date, $faq]);

$filename = array_filter($_FILES['file_name']['name']);

if (!empty($filename) && $stmt->rowCount() == 1) {
    $stmt = $db->prepare("INSERT INTO Files (ticket_id, file_data) VALUES (?, ?)");
    $fileTempName = $_FILES['file_name']['tmp_name'];
    $id = $db->lastInsertId();
    foreach ($fileTempName as $index => $file) {
        $file_data = file_get_contents($file);
        $stmt->execute([$id, $file_data]);
    }
}

if ($stmt->rowCount() == 1) {
    $ticket_id = $db->lastInsertId();
    $action_stmt = $db->prepare("INSERT INTO actions (user_id, ticket_id, action, date) VALUES (?, ?, ?, ?)");
    $action_stmt->execute([$user_id, $ticket_id, "Created a ticket", $date]);
    header('Location: ../pages/userTicket.php');
}

if ($stmt->rowCount() == 1) {
    header('Location: ../pages/userTicket.php');
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
