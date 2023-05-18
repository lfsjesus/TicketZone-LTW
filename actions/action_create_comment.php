<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/userTicket.php');
    die();
}

$db = getDatabaseConnection();

$ticket_id = (int)$_POST['ticket_id'];
$user_id = $session->getId();
$comment = $_POST['message'];
$date = date('Y-m-d H:i:s');

$stmt = $db->prepare("INSERT INTO Comments (ticket_id, user_id, comment, date) VALUES (?, ?, ?, ?)");
$stmt->execute([$ticket_id, $user_id, $comment, $date]);

$filename = array_filter($_FILES['file_name']['name']);

if (!empty($filename) && $stmt->rowCount() == 1) {
    $stmt = $db->prepare("INSERT INTO Files (comment_id, file_data) VALUES (?, ?)");
    $fileTempName = $_FILES['file_name']['tmp_name'];
    $id = $db->lastInsertId();
    foreach ($fileTempName as $index => $file) {
        $file_data = file_get_contents($file);
        $stmt->execute([$id, $file_data]);
    }
}

if ($stmt->rowCount() == 1) {
    header('Location: ../pages/ticket.php?id=' . $ticket_id);
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
