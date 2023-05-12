<?php 
declare(strict_types = 1);
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/ticket.tpl.php');
require_once(__DIR__ . '/../templates/comment.tpl.php');
require_once(__DIR__ . '/../database/action.class.php');

$session = new Session();

$db = getDatabaseConnection();

$user = User::getUser($db, (int)$_GET['id']);

if ($user == null) {
    header('Location: ../pages/userTickets.php');
    die();
}

drawHeader($user->firstName . ' ' . $user->lastName );
?>
<section id="main-wrapper">
    <?php
    drawNavbar($session);
    ?>
    <main id="profile">
    <h2>Action History</h2>
    <ul>
        <?php
    $actions = Action::getActionsByUserId($db, $user->id);
    foreach ($actions as $action) {
        $ticket = Ticket::getTicket($db,$action->ticketId);
        echo "<li>{$action->date->format('Y-m-d H:i:s')} - {$action->action} : <a href='ticket.php?id={$ticket->id}'>{$ticket->title}</a></li>";
    }
        ?>
    </ul>
</main>
</section>
<?php 
    drawFooter();
?>


