<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/department.class.php');

$session = new Session();

$db = getDatabaseConnection();

$user = User::getUser($db, $session->getId());
$ticket = Ticket::getTicket($db, (int) $_POST['id']);


$previousStatus = $ticket->status;
$ticket->status = ($_POST['status'] ?? $ticket->status);

if ($ticket->status !== $previousStatus) {
  $statusAction = "Changed status to {$ticket->status}";
  $action_stmt = $db->prepare("INSERT INTO actions (user_id, ticket_id, action, date) VALUES (?, ?, ?, ?)");
  $action_stmt->execute([$session->getUser()->id, $ticket->id, $statusAction, date("Y-m-d H:i:s")]);
}


$previousPriority = $ticket->priority;
$ticket->priority = ($_POST['priority'] ?? $ticket->priority);

if ($ticket->priority !== $previousPriority){
  $priorityAction = "Changed priority to {$ticket->priority}";
  $action_stmt = $db->prepare("INSERT INTO actions (user_id, ticket_id, action, date) VALUES (?, ?, ?, ?)");
  $action_stmt->execute([$session->getUser()->id, $ticket->id, $priorityAction, date("Y-m-d H:i:s")]);
}


$previousDepartmentId = $ticket->department->id;
$ticket->department->id = ((int) $_POST['department'] ?? $ticket->department->id);

if ($ticket->department->id !== $previousDepartmentId) {
  $department = Department::getDepartment($db,$ticket->department->id);
  $departmentAction = "Changed department to {$department->name}";
  $action_stmt = $db->prepare("INSERT INTO actions (user_id, ticket_id, action, date) VALUES (?, ?, ?, ?)");
  $action_stmt->execute([$session->getUser()->id, $ticket->id, $departmentAction, date("Y-m-d H:i:s")]);
}


$previousAssigneeId = $ticket->ticketAssignee->id;
$ticket->ticketAssignee = User::getUser($db, (int) $_POST['assignee']);

if ($ticket->ticketAssignee->id !== $previousAssigneeId) {
  $newUser = User::getUser($db, $ticket->ticketAssignee->id);
  $assigneeAction = "Changed assignee to {$newUser->firstName} {$newUser->lastName}";
  $action_stmt = $db->prepare("INSERT INTO actions (user_id, ticket_id, action, date) VALUES (?, ?, ?, ?)");
  $action_stmt->execute([$session->getUser()->id, $ticket->id, $assigneeAction, date("Y-m-d H:i:s")]);
  $ticket->status = 'assigned';
}


$ticket->title = ($_POST['title'] ?? $ticket->title);

$ticket->description = ($_POST['description'] ? $_POST['description'] : $ticket->description);

$ticket->save($db);
header('Location: ../pages/userTicket.php');
