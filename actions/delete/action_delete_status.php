<?php 
declare(strict_types = 1);
require_once(__DIR__ . '/../../utils/session.php');
require_once(__DIR__ . '/../../database/connection.db.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../../pages/login_page.php');
    die();
}

if (!$session->getUser()->isAdmin()) {
    header('Location: ../../pages/userTicket_page.php');
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $db = getDatabaseConnection();

    $status_id = $_POST['status_id'];

    $stmt = $db->prepare('DELETE FROM Statuses WHERE id = ?');
    $stmt->execute(array($status_id));

    header('Location: ../../pages/management_page.php?tab=2');
}