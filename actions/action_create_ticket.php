<?php
declare (strict_types=1);
require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../utils/session.php');

$db = getDatabaseConnection();
$session = new Session();

$id = $db->query("SELECT MAX(id) FROM tickets")->fetch()['MAX(id)'] + 1;

$department = $_POST['department'];
$department_id = $db->query("SELECT id FROM Departments WHERE name = '$department'")->fetch()['id'];

$user_id = $session->getId();
$title = htmlspecialchars($_POST['title']);
$description = htmlspecialchars($_POST['description']);
$status = 'open';
$date = date('Y-m-d H:i:s');
$faq = false;

$stmt = $db->prepare("INSERT INTO tickets (id, user_id, department_id, title, description, status, date, faq) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$id, $user_id, $department_id, $title, $description, $status, $date, $faq]);

if ($stmt->rowCount() == 1) {
    $session->addMessage('success', 'Ticket created successfully!');
    header('Location: ../pages/userTicket.php');
} else {
    $session->addMessage('error', 'Error creating ticket!');
    header('Location: ../pages/userTicket.php');
}

?>