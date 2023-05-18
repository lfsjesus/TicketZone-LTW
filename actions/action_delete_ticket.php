<?php
include_once('../utils/session.php');
include_once('../database/connection.db.php');

// ver se user está logged, se o ticket é dele ou se é agente ou admin
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $ticket_id = $_POST['id'];

    $db = getDatabaseConnection();

    $stmt = $db->prepare('DELETE FROM Tickets WHERE id = ?');
    $stmt->execute([$ticket_id]);

}