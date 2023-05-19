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

$ticket = Ticket::getTicket($db, (int)$_GET['id']);

if (!$isAdminOrAgent && ($ticket->ticketCreator->id !== $session_user->id)) {
    header('Location: ../pages/userTicket_page.php');
    die();
}
if ($ticket == null) {
    header('Location: ../pages/userTicket_page.php');
    die();
}

drawHeader($ticket->title);
?>
<div id="main-wrapper">
    <?php
    drawNavbar($session);
    ?>
    <main id="history">
        <h2>Action History</h2>
        <ul>
            <?php
            $actions = Action::getActionsByTicketId($db, $ticket->id);
            foreach ($actions as $action) {
                $ticket = Ticket::getTicket($db, $action->ticketId);
                $action_user = User::getUser($db, $action->userId);
                echo "<li>{$action->date->format('Y-m-d H:i:s')} - {$action_user->firstName} {$action_user->lastName} {$action->action} </li>";
            }
            ?>
        </ul>
    </main>
</div>
<?php
drawFooter();
?>