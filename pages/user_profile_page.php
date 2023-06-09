<?php

declare(strict_types=1);
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/ticket.tpl.php');
require_once(__DIR__ . '/../templates/comment.tpl.php');
require_once(__DIR__ . '/../database/action.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/login_page.php');
    die();
}

$session_user = $session->getUser();
$userType = $session_user->type;
$isAdminOrAgent = ($userType == 'admin' || $userType == 'agent');


$db = getDatabaseConnection();

$user = User::getUser($db, (int)$_GET['id']);


if (!$isAdminOrAgent && ($user->id !== $session_user->id)) {
    header('Location: ../pages/userTicket_page.php');
    die();
}
drawHeader($user->firstName . ' ' . $user->lastName);
?>
    <?php
    drawNavbar($session);
    ?>
    <main id="history">
        <h2>Action History</h2>
        <ul>
            <?php
            $actions = Action::getActionsByUserId($db, $user->id);
            foreach ($actions as $action) {
                $ticket = Ticket::getTicket($db, $action->ticketId);
                echo "<li>{$action->date->format('Y-m-d H:i:s')} - {$action->action} : <a href='ticket_page.php?id={$ticket->id}'>{$ticket->title}</a></li>";
            }
            ?>
        </ul>
    </main>
<?php
drawFooter();
?>