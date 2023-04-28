<?php
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
// get tickets from database according to filters, do it

    $authorFilter = $_GET['author']; // id
    $assigneeFilter = $_GET['assignee']; // id
    $statusFilter = $_GET['status']; // open, closed, 
    $priorityFilter = $_GET['priority']; // high, medium, low
    $sortFilter = $_GET['date']; // newest, oldest

    $authorFilter = ($authorFilter == 'all' ? null : $authorFilter);
    $assigneeFilter = ($assigneeFilter == 'all' ? null : $assigneeFilter);
    $statusFilter = ($statusFilter == 'all' ? null : $statusFilter);
    $priorityFilter = ($priorityFilter == 'all' ? null : $priorityFilter);
    $sortFilter = ($sortFilter == 'newest' ? 'DESC' : 'ASC');
    // get tickets from database according to filters, do it
    $db = getDatabaseConnection();

    // start query
    $query = 'SELECT id, user_id, agent_id, department_id, title, description, status, priority, date, faq FROM Tickets WHERE ';

    // add filters

    // author
    if ($authorFilter) {
    $query .= 'user_id = ' . $authorFilter . ' AND ';
    }

    // assignee
    if ($assigneeFilter) {
    $query .= 'agent_id = ' . $assigneeFilter . ' AND ';
    }

    // status
    if ($statusFilter) {
    $query .= 'status = "' . $statusFilter . '" AND ';
    }

    // priority
    if ($priorityFilter) {
        $query .= 'priority = "' . $priorityFilter . '" AND ';
    }

    if (substr($query, -5) == ' AND ') {
        $query = substr($query, 0, -5);
    }
    else {
        $query = substr($query, 0, -7);
    }

    // add sort
    if ($sortFilter) {
        $query .= ' ORDER BY date ' . $sortFilter;
    }

    // execute query
    $stmt = $db->prepare($query);
    $stmt->execute();

    // get tickets
    $tickets = array();

    while ($ticket = $stmt->fetch()) {
        // get author
        $ticketCreator = User::getUser($db, $ticket['user_id']);
        $ticketAssignee = User::getUser($db, $ticket['user_id']);
        $department = $db->prepare('SELECT name FROM Departments WHERE id = ?');
        $department->execute(array($ticket['department_id']));
        $department = $department->fetch()['name'];
        $department = $department == null ? "None" : $department;
        $hashtags = array();

        $stmt2 = $db->prepare('SELECT th.hashtag FROM TicketHashtags th JOIN TicketTagJunction ttj ON th.id = ttj.hashtag_id WHERE ttj.ticket_id = ?');
        $stmt2->execute(array($ticket['id']));
        foreach ($stmt2->fetchAll() as $hashtag) {
            array_push($hashtags, $hashtag['hashtag']);
        }
        $tickets[] = new Ticket(
            $ticket['id'],
            $ticket['title'],
            $ticket['description'],
            $ticketCreator,
            $ticketAssignee,
            $department,
            $ticket['status'],
            $ticket['priority'],
            new DateTime($ticket['date']),
            $hashtags,
            $ticket['faq'] == 1 ? true : false
        );
    }

    echo json_encode($tickets);
?>