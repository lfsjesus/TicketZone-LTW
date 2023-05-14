<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');

$db = getDatabaseConnection();
// put all lower case except first letter
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

?>