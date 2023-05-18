<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();
$userType = $session->getUser()->type;

if (!$session->isLoggedIn()) {
    header('Location: ../pages/login_page.php');
    die();
}

if ($userType !== 'admin' && $userType !== 'agent') {
    header('Location: ../pages/userTicket.php');
    die();
}

$db = getDatabaseConnection();

$id = $_POST['id'];

$stmt = $db->prepare('DELETE FROM FAQ WHERE id = ?');
$stmt->execute(array($id));

header('Location: ../pages/faq_page.php');
