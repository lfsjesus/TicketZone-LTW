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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $db = getDatabaseConnection();

    $department_id = $_POST['department_id'];

    $stmt = $db->prepare('DELETE FROM Departments WHERE id = ?');
    $stmt->execute(array($department_id));

    header('Location: ../pages/management.php?tab=1');
}