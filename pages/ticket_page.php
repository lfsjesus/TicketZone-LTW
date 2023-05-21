<?php

declare(strict_types=1);
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/ticket.tpl.php');
require_once(__DIR__ . '/../templates/comment.tpl.php');
require_once(__DIR__ . '/../utils/utils.php');

$session = new Session();
if (!$session->isLoggedIn()) {
    header('Location: ../pages/login.php');
    die();
}

$db = getDatabaseConnection();
$user = $session->getUser();
$userType = $user->type;
$isAdminOrAgent = ($userType == 'admin' || $userType == 'agent');


$ticket = Ticket::getTicket($db, (int)$_GET['id']);

if(!$isAdminOrAgent && ($user->id !== $ticket->ticketCreator->id)){
    header('Location: ../pages/userTicket_page.php');
    die();
}

if ($ticket == null) {
    header('Location: ../pages/userTicket_page.php');
    die();
}

drawHeader($ticket->title);
?>
    <?php
    drawNavbar($session);
    ?>
    <main id="ticket">
        <?php
        drawTicket($ticket, $userType);
        ?>
        <section id="comments">
            <h2>Comments</h2>
            <section id="faq-select" style="display: none;">
                <h3>Select FAQ as answer: </h3>
                <select name="faq" id="faq">
                    <option value="">None</option>
                    <?php
                    $faqs = getFAQ($db);
                    foreach ($faqs as $faq) {
                        echo '<option value="' . htmlspecialchars($faq['answer']) . '">' . htmlspecialchars($faq['question']) . '</option>';
                    }
                    ?>
                </select>
            </section>
            <form action="../actions/add/action_add_comment.php" class="comment-form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="ticket_id" value="<?= $ticket->id ?>">
                <textarea name="message" id="comment" cols="30" rows="5" placeholder="Comment" required></textarea>
                <div id="comment-extras">
                    <?php if ($isAdminOrAgent){
                     echo '<span id="faq-answer" class="material-symbols-outlined">quiz</span>';
                    }?>
                    <a href="#" id="file-upload" class="material-symbols-outlined">attach_file</a>
                    <input type="file" name="file_name[]" id="file" multiple>
                    <span id="file-name"></span>
                </div>
                <button type="submit" class="material-symbols-outlined">send</button>
            </form>

            <?php
            $comments = $ticket->getAnswers($db);
            foreach (array_reverse($comments) as $comment) {
                drawComment($comment);
            }
            ?>
        </section>
    </main>
<?php
drawFooter();
?>