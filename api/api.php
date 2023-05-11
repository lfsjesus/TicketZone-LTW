<?php
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/department.class.php');
// get tickets from database according to filters, do it

    $authorFilter = $_GET['author']; // id
    $assigneeFilter = $_GET['assignee']; // id
    $statusFilter = $_GET['status']; // open, closed, 
    $priorityFilter = $_GET['priority']; // high, medium, low
    $departmentFilter = $_GET['department']; // id
    $sortFilter = $_GET['date']; // newest, oldest
    $searchQuery = $_GET['search']; // string

    $authorFilter = ($authorFilter == 'all' ? null : $authorFilter);
    $assigneeFilter = ($assigneeFilter == 'all' ? null : $assigneeFilter);
    $statusFilter = ($statusFilter == 'all' ? null : $statusFilter);
    $priorityFilter = ($priorityFilter == 'all' ? null : $priorityFilter);
    $departmentFilter = ($departmentFilter == 'all' ? null : $departmentFilter);
    $searchQuery = (($searchQuery == '' || $searchQuery == null) ? null : $searchQuery);
    $sortFilter = ($sortFilter == 'newest' ? 'DESC' : 'ASC');
    // get tickets from database according to filters, do it
    $db = getDatabaseConnection();

    // start query
    $query = 'SELECT id, user_id, agent_id, department_id, title, description, status, priority, date, faq FROM Tickets WHERE ';
    $countQuery = 'SELECT COUNT(*) FROM Tickets WHERE ';
    $params = array();
    // add filters

    // author
    if ($authorFilter) {
        $query .= 'user_id = ? AND ';
        $countQuery .= 'user_id = ? AND ';
        $params[] = $authorFilter;
    }

    // assignee
    if ($assigneeFilter) {
        $query .= 'agent_id = ? AND ';
        $countQuery .= 'agent_id = ? AND ';
        $params[] = $assigneeFilter;
    }

    // status
    if ($statusFilter) {
        $query .= 'status = ? AND ';
        $countQuery .= 'status = ? AND ';
        $params[] = $statusFilter;
    }

    // priority
    if ($priorityFilter) {
        $query .= 'priority = ? AND ';
        $countQuery .= 'priority = ? AND ';
        $params[] = $priorityFilter;
    }

    // department
    if ($departmentFilter) {
        $query .= 'department_id = ? AND ';
        $countQuery .= 'department_id = ? AND ';
        $params[] = $departmentFilter;
    }

    // search to title and description
    if ($searchQuery) {
        // if the search query starts with #, find tickets with like hashtag
        if (substr($searchQuery, 0, 1) === '#') {
            $query .= 'id IN (SELECT ticket_id FROM TicketTagJunction WHERE hashtag_id IN (SELECT id FROM TicketHashtags WHERE hashtag LIKE ?)) AND ';
            $countQuery .= 'id IN (SELECT ticket_id FROM TicketTagJunction WHERE hashtag_id IN (SELECT id FROM TicketHashtags WHERE hashtag LIKE ?)) AND ';
            $params[] = '%' . substr($searchQuery, 1) . '%';
        }
        else {
            $query .= '(title LIKE ? OR description LIKE ?) AND ';
            $countQuery .= '(title LIKE ? OR description LIKE ?) AND ';
            $params[] = '%' . $searchQuery . '%';
            $params[] = '%' . $searchQuery . '%';
        }
    }


    if (substr($query, -4) == 'AND ') {
        $query = substr($query, 0, -4);
        $countQuery = substr($countQuery, 0, -4);
    }
    else if (substr($query, -6) == 'WHERE ') {
        $query = substr($query, 0, -6);
        $countQuery = substr($countQuery, 0, -6);
    }

    // add sort
    if ($sortFilter) {
        $query .= ' ORDER BY date ' . $sortFilter;
    }

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $perPage = 7;

    $offset = ($page - 1) * $perPage;
    $query .= " LIMIT $perPage OFFSET $offset";

    // execute count query
    $stmt = $db->prepare($countQuery);
    $stmt->execute($params);
    $count = $stmt->fetch()['COUNT(*)'];

    // execute query
    $stmt = $db->prepare($query);
    $stmt->execute($params);

    // get tickets
    $tickets = array();

    while ($ticket = $stmt->fetch()) {
        // get author
        $ticketCreator = User::getUser($db, $ticket['user_id']);
        $ticketAssignee = User::getUser($db, $ticket['agent_id']);
        $department = Department::getDepartment($db, $ticket['department_id']);
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

    $response = [
        'tickets' => $tickets,
        'count' => $count        
    ];
    
    echo json_encode($response);
?>