<?php
declare(strict_types=1);
require_once (__DIR__ . '/../database/connection.db.php');

$db = getDatabaseConnection();

$id = $_POST['id'];

$stmt = $db->prepare('DELETE FROM FAQ WHERE id = ?');
$stmt->execute(array($id));

header('Location: ../pages/faq_page.php');
?>