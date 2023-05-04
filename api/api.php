<?php
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
// get tickets from database according to filters, do it

    $authorFilter = $_GET['author']; // id
    $assigneeFilter = $_GET['assignee']; // id
    $statusFilter = $_GET['status']; // open, closed, 
    $priorityFilter = $_GET['priority']; // high, medium, low
    $sortFilter = $_GET['date']; // newest, oldest
    $searchQuery = $_GET['search']; // string

    $authorFilter = ($authorFilter == 'all' ? null : $authorFilter);
    $assigneeFilter = ($assigneeFilter == 'all' ? null : $assigneeFilter);
    $statusFilter = ($statusFilter == 'all' ? null : $statusFilter);
    $priorityFilter = ($priorityFilter == 'all' ? null : $priorityFilter);
    $searchQuery = (($searchQuery == '' || $searchQuery == null) ? null : $searchQuery);
    $sortFilter = ($sortFilter == 'newest' ? 'DESC' : 'ASC');
    // get tickets from database according to filters, do it
    $db = getDatabaseConnection();

    // start query
    $query = 'SELECT id, user_id, agent_id, department_id, title, description, status, priority, date, faq FROM Tickets WHERE ';
    $params = array();
    // add filters

    // author
    if ($authorFilter) {
        $query .= 'user_id = ? AND ';
        $params[] = $authorFilter;
    }

    // assignee
    if ($assigneeFilter) {
        $query .= 'agent_id = ? AND ';
        $params[] = $assigneeFilter;
    }

    // status
    if ($statusFilter) {
        $query .= 'status = ? AND ';
        $params[] = $statusFilter;
    }

    // priority
    if ($priorityFilter) {
        $query .= 'priority = ? AND ';
        $params[] = $priorityFilter;
    }

    // search to title and description
    if ($searchQuery) {
        $query .= '(title LIKE ? OR description LIKE ?) AND ';
        $params[] = '%' . $searchQuery . '%';
        $params[] = '%' . $searchQuery . '%';
    }


    if (substr($query, -4) == 'AND ') {
        $query = substr($query, 0, -4);
    }
    else if (substr($query, -6) == 'WHERE ') {
        $query = substr($query, 0, -6);
    }

    // add sort
    if ($sortFilter) {
        $query .= ' ORDER BY date ' . $sortFilter;
    }
    
    // execute query
    $stmt = $db->prepare($query);
    $stmt->execute($params);

    // get tickets
    $tickets = array();

    while ($ticket = $stmt->fetch()) {
        // get author
        $ticketCreator = User::getUser($db, $ticket['user_id']);
        $ticketAssignee = User::getUser($db, $ticket['user_id']);
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
            $ticket['department_id'],
            $ticket['status'],
            $ticket['priority'],
            new DateTime($ticket['date']),
            $hashtags,
            $ticket['faq'] == 1 ? true : false
        );
    }

    echo json_encode($tickets);
?>