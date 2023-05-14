<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');

$db = getDatabaseConnection();

$status = strtolower($_POST['status']);

try {
    $stmt = $db->prepare('INSERT INTO Statuses (name) VALUES (?)');
    $stmt->execute(array($status));
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        echo 'Status already exists';
    }
}

header('Location: ../pages/management.php?tab=2');

?>