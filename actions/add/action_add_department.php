<?php
declare(strict_types=1);
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

    $department = ucfirst(strtolower($_POST['department']));

    try {
        $stmt = $db->prepare('INSERT INTO Departments (name) VALUES (?)');
        $stmt->execute(array($department));
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo 'Department already exists';
        }
    }

    header('Location: ../../pages/management_page.php?tab=1');
}