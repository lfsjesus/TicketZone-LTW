<?php
declare(strict_types=1);

require_once(__DIR__ . '/../../utils/session.php');
require_once(__DIR__ . '/../../database/connection.db.php');
require_once(__DIR__ . '/../../database/user.class.php');
require_once(__DIR__ . '/../../database/department.class.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $session = new Session();
    $userType = $session->getUser()->type;

    if (!$session->isLoggedIn()) {
      header('Location: ../../pages/login_page.php');
      die();
    }

    if ($userType !== 'admin' && $userType !== 'agent') {
      header('Location: ../../pages/userTicket_page.php');
      die();
    }


    $db = getDatabaseConnection();

    $user = User::getUser($db, $session->getId());
    $ticket = Ticket::getTicket($db, (int) $_POST['id']);


    if (isset($_POST['status'])) {
      $previousStatus = $ticket->status;
      $ticket->status = $_POST['status'];

      if ($previousStatus != $ticket->status) {
        $statusAction = "Changed status to {$ticket->status}";
        $action_stmt = $db->prepare("INSERT INTO actions (user_id, ticket_id, action, date) VALUES (?, ?, ?, ?)");
        $action_stmt->execute([$session->getUser()->id, $ticket->id, $statusAction, date("Y-m-d H:i:s")]);
      }
    }

    if (isset($_POST['priority'])) {
      $previousPriority = $ticket->priority;
      $ticket->priority = $_POST['priority'];

      if ($previousPriority != $ticket->priority) {
        $priorityAction = "Changed priority to {$ticket->priority}";
        $action_stmt = $db->prepare("INSERT INTO actions (user_id, ticket_id, action, date) VALUES (?, ?, ?, ?)");
        $action_stmt->execute([$session->getUser()->id, $ticket->id, $priorityAction, date("Y-m-d H:i:s")]);
      }
    }

    if (isset($_POST['department'])) {
      if ($ticket->department) {
        $previousDepartmentId = $ticket->department->id;
        $ticket->department->id = ((int) $_POST['department']);

        if ($previousDepartmentId != $ticket->department->id) {
          $department = Department::getDepartment($db, $ticket->department->id);
          $departmentAction = "Changed department to {$department->name}";
          $action_stmt = $db->prepare("INSERT INTO actions (user_id, ticket_id, action, date) VALUES (?, ?, ?, ?)");
          $action_stmt->execute([$session->getUser()->id, $ticket->id, $departmentAction, date("Y-m-d H:i:s")]);
        }
      }
      else {
        $ticket->department = Department::getDepartment($db, (int) $_POST['department']);
        $departmentAction = "Set department to {$ticket->department->name}";
        $action_stmt = $db->prepare("INSERT INTO actions (user_id, ticket_id, action, date) VALUES (?, ?, ?, ?)");
        $action_stmt->execute([$session->getUser()->id, $ticket->id, $departmentAction, date("Y-m-d H:i:s")]);
      }

    }

    if (isset($_POST['assignee'])) {
      if ($ticket->ticketAssignee) {
        $previousAssigneeId = $ticket->ticketAssignee->id;
        $ticket->ticketAssignee->id = ((int) $_POST['assignee']);

        if ($previousAssigneeId != $ticket->ticketAssignee->id) {
          $newUser = User::getUser($db, $ticket->ticketAssignee->id);
          $assigneeAction = "Changed assignee to {$newUser->firstName} {$newUser->lastName}";
          $action_stmt = $db->prepare("INSERT INTO actions (user_id, ticket_id, action, date) VALUES (?, ?, ?, ?)");
          $action_stmt->execute([$session->getUser()->id, $ticket->id, $assigneeAction, date("Y-m-d H:i:s")]);
          $ticket->status = 'assigned';
        }
      }
      else {
        $ticket->ticketAssignee = User::getUser($db, (int) $_POST['assignee']);
        $newUser = User::getUser($db, $ticket->ticketAssignee->id);
        $assigneeAction = "Set assignee to {$newUser->firstName} {$newUser->lastName}";
        $action_stmt = $db->prepare("INSERT INTO actions (user_id, ticket_id, action, date) VALUES (?, ?, ?, ?)");
        $action_stmt->execute([$session->getUser()->id, $ticket->id, $assigneeAction, date("Y-m-d H:i:s")]);
        $ticket->status = 'assigned';
      }
    }

    if (isset($_POST['title'])) {
      $previousTitle = $ticket->title;
      $ticket->title = $_POST['title'];

      if ($previousTitle != $ticket->title) {
        $titleAction = "Changed title to {$ticket->title}";
        $action_stmt = $db->prepare("INSERT INTO actions (user_id, ticket_id, action, date) VALUES (?, ?, ?, ?)");
        $action_stmt->execute([$session->getUser()->id, $ticket->id, $titleAction, date("Y-m-d H:i:s")]);
      }
    }

    if (isset($_POST['description'])) {
      $previousDescription = $ticket->description;
      $ticket->description = $_POST['description'];

      if ($previousDescription != $ticket->description) {
        $descriptionAction = "Changed description to {$ticket->description}";
        $action_stmt = $db->prepare("INSERT INTO actions (user_id, ticket_id, action, date) VALUES (?, ?, ?, ?)");
        $action_stmt->execute([$session->getUser()->id, $ticket->id, $descriptionAction, date("Y-m-d H:i:s")]);
      }
    }

    $ticket->save($db);
    header('Location: ../../pages/userTicket_page.php');
}