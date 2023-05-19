<?php 
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../database/user.class.php');

$session = new Session();
$userType = $session->getUser()->type;

if (!$session->isLoggedIn()) {
    header('Location: ../pages/login_page.php');
    die();
}
  
if (!$session->getUser()->isAdmin()) {
    header('Location: ../pages/userTicket.php');
    die();
}

$db = getDatabaseConnection();

$user = User::getUser($db, (int)$_POST['user_id']);
$department = Department::getDepartment($db, (int)$_POST['department_id']);
$type = isset($_POST['type']) ? $_POST['type'] : $user->type;
$types = ['client', 'agent', 'admin'];

if ($user) {
    if ($department) {
        $user->department = $department;
    }
    if (in_array($type, $types)) {
        $user->type = $type;
    }
    $user->save($db);
    header('Location: ../pages/management.php');
}
