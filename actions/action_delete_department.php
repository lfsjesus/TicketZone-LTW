<?php 
declare(strict_types = 1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');

$db = getDatabaseConnection();

$department_id = $_POST['department_id'];

$stmt = $db->prepare('DELETE FROM Departments WHERE id = ?');
$stmt->execute(array($department_id));

header('Location: ../pages/management.php?tab=1');
?>