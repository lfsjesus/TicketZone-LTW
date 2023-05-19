<?php
require_once('../utils/session.php');
require_once('../database/connection.db.php');
require_once('../database/ticket.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/login_page.php');
    die();
}

$userType = $session->getUser()->type;
$isAdminOrAgent = ($userType === 'admin' || $userType === 'agent');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $db = getDatabaseConnection();

    $ticket_id = $_POST['id'];

    $ticket = Ticket::getTicket($db, $ticket_id);

    if (!$isAdminOrAgent && $ticket->ticketCreator->id !== $session->getUser()->id) {
        header('Location: ../pages/userTicket.php');
        die();
    }

    $stmt = $db->prepare('DELETE FROM Tickets WHERE id = ?');
    $stmt->execute([$ticket_id]);

}