<?php
declare(strict_types=1);
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

$department = ucfirst(strtolower($_POST['department']));

try {
    $stmt = $db->prepare('INSERT INTO Departments (name) VALUES (?)');
    $stmt->execute(array($department));
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        echo 'Department already exists';
    }
}

header('Location: ../pages/management.php?tab=1');
