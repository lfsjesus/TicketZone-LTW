<?php 
declare(strict_types = 1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    $user = User::getUser($db, (int)$_POST['id']);

    if ($user) {
        $stmt = $db->prepare('DELETE FROM Users WHERE id = ?');
        $stmt->execute(array($user->id));
        header('Location: ../pages/management.php');
    }
}