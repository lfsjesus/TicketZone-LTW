<?php
declare(strict_types=1);
require_once __DIR__ . '/../../database/connection.db.php';
require_once __DIR__ . '/../../utils/session.php';

$session = new Session();
$userType = $session->getUser()->type;

if (!$session->isLoggedIn()) {
    header('Location: ../pages/login_page.php');
    die();
}

if ($userType !== 'admin' && $userType !== 'agent') {
    header('Location: ../pages/userTicket_page.php');
    die();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $db = getDatabaseConnection();

    $question = $_POST['question'];
    $answer = $_POST['answer'];

    $stmt = $db->prepare('INSERT INTO FAQ (question, answer) VALUES (?, ?)');
    $stmt->execute(array($question, $answer));

    header('Location: ../../pages/faq_page.php');
}