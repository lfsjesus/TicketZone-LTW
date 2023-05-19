<?php
declare(strict_types=1);
require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../utils/session.php');
require_once (__DIR__ . '/../database/ticket.class.php');

$session = new Session();
$userType = $session->getUser()->type;
$isAdminOrAgent = ($userType === 'admin' || $userType === 'agent');

if (!$session->isLoggedIn()) {
    header('Location: ../pages/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (!isset($_GET['id'])) {
        header('Location: ../pages/userTicket_page.php');
        exit();
    }

    $db = getDatabaseConnection();
    $id = $_GET['id'];


    $stmt = $db->prepare('SELECT * FROM Files WHERE id = ?');
    $stmt->execute(array($id));
    $file = $stmt->fetch();

    $ticket = Ticket::getTicket($db, $file['ticket_id']);

    if (!$isAdminOrAgent && $ticket->ticketCreator->id !== $session->getUser()->id) {
        header('Location: ../pages/userTicket_page.php');
        exit();
    }

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="file"');
    echo $file['file_data'];
}