<?php
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();

if (!$session->getUser()->isAdmin()) {
    header('Location: /');
    exit();
}

$departmentFilter = $_GET['department_id'];
$typeFilter = $_GET['type'];
$searchQuery = $_GET['search'];

if ($departmentFilter === 'all') {
    $departmentFilter = null;
}

if ($typeFilter === 'all') {
    $typeFilter = null;
}

$db = getDatabaseConnection();

$query = 'SELECT id, username, email, firstName, lastName, type, department_id FROM Users WHERE ';
$countQuery = 'SELECT COUNT(*) FROM Users WHERE ';

if ($departmentFilter) {
    $query .= 'department_id = ? AND ';
    $countQuery .= 'department_id = ? AND ';
    $params[] = $departmentFilter;
}

if ($typeFilter) {
    $query .= 'type = ? AND ';
    $countQuery .= 'type = ? AND ';
    $params[] = $typeFilter;
}

if ($searchQuery) {
    $searchQuery = explode(' ', $searchQuery);
    foreach ($searchQuery as $word) {
        $query .= '(firstName LIKE ? OR lastName LIKE ? OR username LIKE ? OR email LIKE ?) AND ';
        $countQuery .= '(firstName LIKE ? OR lastName LIKE ? OR username LIKE ? OR email LIKE ?) AND ';
        $params[] = '%' . $word . '%';
        $params[] = '%' . $word . '%';
        $params[] = '%' . $word . '%';
        $params[] = '%' . $word . '%';
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

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$perPage = 7;
$offset = ($page - 1) * $perPage;
$query .= " LIMIT $perPage OFFSET $offset";

$stmt = $db->prepare($countQuery);
$stmt->execute($params);
$count = $stmt->fetch()['COUNT(*)'];

$stmt = $db->prepare($query);
$stmt->execute($params);

$users = array();

while ($user = $stmt->fetch()) {
    $department = Department::getDepartment($db, $user['department_id']);
    $users[] = new User(
        (int) $user['id'],
        htmlspecialchars($user['username']),
        htmlspecialchars($user['email']),
        htmlspecialchars($user['firstName']),
        htmlspecialchars($user['lastName']),
        $user['type'],
        $department
    );
}

//also send departments that can be assigned to users
$departments = Department::getDepartments($db);

echo json_encode(array(
    'users' => $users,
    'departments' => $departments,
    'count' => $count
));
