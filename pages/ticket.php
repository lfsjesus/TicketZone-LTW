<?php 
declare(strict_types = 1);
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/ticket.tpl.php');
require_once(__DIR__ . '/../templates/comment.tpl.php');

$session = new Session();

$db = getDatabaseConnection();

$ticket = Ticket::getTicket($db, (int)$_GET['id']);

if ($ticket == null) {
    header('Location: ../pages/userTickets.php');
    die();
}

drawHeader($ticket->title);
?>
<section id="main-wrapper">
    <?php
    drawNavbar($session);
    ?>
    <main id="ticket">
        <?php
            drawTicket($ticket);
        ?>
        <section id="comments">
            <h2>Comments</h2>
            <form action="../actions/action_create_comment.php" class = "comment-form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="ticket_id" value="<?= $ticket->id ?>">
                <textarea name="message" id="comment" cols="30" rows="5" placeholder="Comment" required></textarea>
                <div id="file-upload-container">
                    <a href="#" id="file-upload" class="material-symbols-outlined">attach_file</a>
                    <input type="file" name="file_name[]" id="file" multiple>
                    <span id="file-name"></span>
                </div>
                <button type="submit" class="material-symbols-outlined">send</button>
            </form>
            <?php
                $comments = $ticket->getAnswers($db);
                foreach ($comments as $comment) {
                    drawComment($comment);
                }
            ?>
        </section>
    </main>
</section>
<?php 
    drawFooter();
?>