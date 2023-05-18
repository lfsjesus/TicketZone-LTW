<?php
declare (strict_types = 1);
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();
$userType = $session->getUser()->type;

if (!$session->isLoggedIn()) {
    header('Location: ../pages/login_page.php');
    die();
}

if ($userType !== 'admin' && $userType !== 'agent') {
    header('Location: ../pages/userTicket.php');
    die();
}

$db = getDatabaseConnection();

$hashtag_name = $_GET['hashtag_name'];

if (substr($hashtag_name, 0, 1) === '#') {
  $hashtag_name = substr($hashtag_name, 1);
}

$hashtag_check = $db->prepare('SELECT id FROM TicketHashtags WHERE hashtag = ?');
$hashtag_check->execute([$hashtag_name]);
$hashtag_id = $hashtag_check->fetchColumn();

if (!$hashtag_id) {
  $hashtag_insert = $db->prepare('INSERT INTO TicketHashtags (hashtag) VALUES (?)');
  $hashtag_insert->execute([$hashtag_name]);
  $hashtag_id = $db->lastInsertId();
}

$ticket_id = $_GET['ticket_id'];

$hashtag_link = $db->prepare('INSERT INTO TicketTagJunction (ticket_id, hashtag_id) VALUES (?, ?)');
$hashtag_link->execute([$ticket_id, $hashtag_id]);

echo $hashtag_id;
