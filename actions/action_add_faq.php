<?php
declare(strict_types=1);
require_once __DIR__ . '/../database/connection.db.php';

$db = getDatabaseConnection();

$question = $_POST['question'];
$answer = $_POST['answer'];

$stmt = $db->prepare('INSERT INTO FAQ (question, answer) VALUES (?, ?)');
$stmt->execute(array($question, $answer));

header('Location: ../pages/faq_page.php');
