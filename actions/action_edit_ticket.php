<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

$session = new Session();

$db = getDatabaseConnection();

$user = User::getUser($db, $session->getId());
$ticket = Ticket::getTicket($db, (int) $_POST['id']);

$ticket->status = ($_POST['status'] ?? $ticket->status);

$ticket->priority = ($_POST['priority'] ?? $ticket->priority);

if ($_POST['department'] !== null) {
  if ($ticket->department === null) {
    $ticket->department = Department::getDepartment($db, (int) $_POST['department']);
  } else {
    $ticket->department->id = ((int) $_POST['department'] ?? $ticket->department->id);
  }
}

if ($_POST['assignee'] !== null) {
  if ($ticket->ticketAssignee === null) {
    $ticket->ticketAssignee = User::getUser($db, (int) $_POST['assignee']);
  } else {
    $ticket->ticketAssignee->id = ((int) $_POST['assignee'] ?? $ticket->ticketAssignee->id);
  }
}

$ticket->title = ($_POST['title'] ?? $ticket->title);

$ticket->description = ($_POST['description'] ? nl2br(htmlspecialchars($_POST['description'])) : $ticket->description);

$ticket->save($db);
header('Location: ../pages/userTicket.php');

?>