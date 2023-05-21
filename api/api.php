<?php
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/department.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: /login.php');
    exit();
}

$userType = $session->getUser()->type;

$authorFilter = (($userType !== 'admin' && $userType !== 'agent') ? $session->getUser()->id : $_GET['author']); // id
$assigneeFilter = $_GET['assignee']; 
$statusFilter = $_GET['status']; 
$priorityFilter = $_GET['priority']; 
$departmentFilter = $_GET['department']; 
$sortFilter = $_GET['date']; 
$searchQuery = $_GET['search']; 

$authorFilter = ($authorFilter == 'all' ? null : $authorFilter);
$assigneeFilter = ($assigneeFilter == 'all' ? null : $assigneeFilter);
$statusFilter = ($statusFilter == 'all' ? null : $statusFilter);
$priorityFilter = ($priorityFilter == 'all' ? null : $priorityFilter);
$departmentFilter = ($departmentFilter == 'all' ? null : $departmentFilter);
$searchQuery = (($searchQuery == '' || $searchQuery == null) ? null : $searchQuery);
$sortFilter = ($sortFilter == 'newest' ? 'DESC' : 'ASC');

$db = getDatabaseConnection();

$query = 'SELECT id, user_id, agent_id, department_id, title, description, status, priority, date FROM Tickets WHERE ';
$countQuery = 'SELECT COUNT(*) FROM Tickets WHERE ';
$params = array();

if ($authorFilter) {
    $query .= 'user_id = ? AND ';
    $countQuery .= 'user_id = ? AND ';
    $params[] = $authorFilter;
}

if ($assigneeFilter) {
    $query .= 'agent_id = ? AND ';
    $countQuery .= 'agent_id = ? AND ';
    $params[] = $assigneeFilter;
}

if ($statusFilter) {
    $query .= 'status = ? AND ';
    $countQuery .= 'status = ? AND ';
    $params[] = $statusFilter;
}

if ($priorityFilter) {
    $query .= 'priority = ? AND ';
    $countQuery .= 'priority = ? AND ';
    $params[] = $priorityFilter;
}

if ($departmentFilter) {
    $query .= 'department_id = ? AND ';
    $countQuery .= 'department_id = ? AND ';
    $params[] = $departmentFilter;
}

if ($searchQuery) {
    // if the search query starts with #, find tickets with hashtag 'like'
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

if ($sortFilter) {
    $query .= ' ORDER BY date ' . $sortFilter;
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$perPage = 7;

$offset = ($page - 1) * $perPage;
$query .= " LIMIT $perPage OFFSET $offset";

// Count Quert
$stmt = $db->prepare($countQuery);
$stmt->execute($params);
$count = $stmt->fetch()['COUNT(*)'];

// Tickets Query
$stmt = $db->prepare($query);
$stmt->execute($params);

$tickets = array();

while ($ticket = $stmt->fetch()) {
    $ticketCreator = User::getUser($db, $ticket['user_id']);
    $ticketAssignee = User::getUser($db, $ticket['agent_id']);
    $department = Department::getDepartment($db, $ticket['department_id']);
    $hashtags = array();

    $stmt2 = $db->prepare('SELECT th.hashtag FROM TicketHashtags th JOIN TicketTagJunction ttj ON th.id = ttj.hashtag_id WHERE ttj.ticket_id = ?');
    $stmt2->execute(array($ticket['id']));
    foreach ($stmt2->fetchAll() as $hashtag) {
        array_push($hashtags, htmlspecialchars($hashtag['hashtag']));
    }
    $tickets[] = new Ticket(
        $ticket['id'],
        htmlspecialchars($ticket['title']),
        htmlspecialchars($ticket['description']),
        $ticketCreator,
        $ticketAssignee,
        $department,
        htmlspecialchars($ticket['status']),
        htmlspecialchars($ticket['priority']),
        new DateTime($ticket['date']),
        $hashtags,
    );
}

$response = [
    'tickets' => $tickets,
    'count' => $count        
];

echo json_encode($response);
