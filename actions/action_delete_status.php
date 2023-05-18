<?php 
declare(strict_types = 1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');


$session = new Session();
$userType = $session->getUser()->type;

if (!$session->isLoggedIn()) {
    header('Location: ../pages/login_page.php');
    die();
}

if ($userType !== 'admin') {
    header('Location: ../pages/userTicket.php');
    die();
}

$db = getDatabaseConnection();

$status_id = $_POST['status_id'];

$stmt = $db->prepare('DELETE FROM Statuses WHERE id = ?');
$stmt->execute(array($status_id));

header('Location: ../pages/management.php?tab=2');
