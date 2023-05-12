<?php 
declare (strict_types = 1);
require_once(__DIR__ . '/../database/comment.class.php');
require_once(__DIR__ . '/../database/connection.db.php');

$db = getDatabaseConnection();

function drawComment(Comment $comment) {
    $db = getDatabaseConnection();
    ?>
    <article class="comment">
        <h3><?= $comment->user->name() ?></h3>
        <p><?= $comment->comment ?></p>
        <p><?= $comment->date->format('d/m/Y H:i') ?></p>
        <!-- if comment has files -->
        <?php if (count($comment->attachments($db)) > 0) { ?>
            <h4>Attachments</h4>
            <ul class = "attachments">
                <?php foreach ($comment->attachments($db) as $attachment) { ?>
                    <li>
                        <a href="../actions/action_download_file.php?id=<?= $attachment['id'] ?>"><span class="material-symbols-outlined">download</span>Attachment <?= $attachment['id'] ?></a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </article>
    <?php
}

?>