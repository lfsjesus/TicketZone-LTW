<?php
// delete ticket action
include_once('../utils/session.php');
include_once('../database/connection.db.php');

$ticket_id = $_POST['id'];

$db = getDatabaseConnection();

// delete ticket
$stmt = $db->prepare('DELETE FROM Tickets WHERE id = ?');
$stmt->execute([$ticket_id]);

?>