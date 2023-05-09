<?php 
declare (strict_types = 1);
require_once(__DIR__ . '/../database/connection.db.php');

$db = getDatabaseConnection();

$hashtag_remove = $db->prepare('DELETE FROM TicketTagJunction WHERE ticket_id = ? AND hashtag_id = ?');
$hashtag_remove->execute([$_GET['ticket_id'], $_GET['hashtag_id']]);

?>