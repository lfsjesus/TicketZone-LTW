<?php
declare(strict_types=1);
require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../utils/session.php';

// É PRECISO FAZER VERIFICAÇOES: ver se o ficheiro pertence ao ticket do utilizador, ou se ele é agente ou admin

$session = new Session();
if (!$session->isLoggedIn()) {
    header('Location: ../pages/login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: ../pages/userTicket.php');
    exit();
}

$db = getDatabaseConnection();
$id = $_GET['id'];

$stmt = $db->prepare('SELECT file_data FROM Files WHERE id = ?');
$stmt->execute(array($id));
$file = $stmt->fetch()['file_data'];

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="file"');
echo $file;
