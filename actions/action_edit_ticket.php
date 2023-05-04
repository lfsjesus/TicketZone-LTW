<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/user.class.php');

  $session = new Session();

  $db = getDatabaseConnection();

  $user = User::getUser($db, $session->getId());
  $ticket = Ticket::getTicket($db, (int) $_POST['id']);
    
    $ticket->status = $_POST['status'];
    $ticket->priority = $_POST['priority'];
    $ticket->department_id = (int) $_POST['department'];
    $ticket->save($db);
    header('Location: ../pages/userTicket.php');

?>