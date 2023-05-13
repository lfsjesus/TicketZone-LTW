<?php 
declare(strict_types = 1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

$session = new Session();

$db = getDatabaseConnection();

$user = User::getUser($db, (int)$_POST['id']);

if ($user) {
    $stmt = $db->prepare('DELETE FROM Users WHERE id = ?');
    $stmt->execute(array($user->id));
    header('Location: ../pages/management.php');
}

?>