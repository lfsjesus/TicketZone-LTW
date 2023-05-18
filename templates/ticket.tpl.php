<?php

declare(strict_types=1);
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../utils/utils.php');

function drawTicket(Ticket $ticket, string $userType)
{
    $db = getDatabaseConnection();
    $isAdminOrAgent = ($userType === 'admin' || $userType === 'agent');
?>
    <article class="ticket-body">
        <form>
            <input type="hidden" name="id" value="<?= $ticket->id ?>">
            <div class="ticket-header">
                <h1><?= htmlspecialchars($ticket->title) ?></h1>
                <?php if ($isAdminOrAgent) { ?>
                    <span class="material-symbols-outlined">edit</span>
                <?php } ?>
            </div>
            <p class="ticket-description"><?= nl2br(htmlspecialchars($ticket->description)) ?></p>
            <ul class="ticket-meta">

                <li>Created by: <?= $ticket->ticketCreator != null ? $ticket->ticketCreator->name() : 'Unknown' ?></li>
                <li>Created at: <?= $ticket->dateCreated->format('d/m/Y H:i') ?></li>
                <li>Assigned to:
                    <select name="assignee" <?= !$isAdminOrAgent ? 'disabled' : '' ?>>
                        <option value="" disabled selected hidden></option>
                        <?php
                        $agents = User::getAgents($db);
                        foreach ($agents as $agent) {
                            echo '<option value="' . $agent->id . '" ' . ($agent->id === $ticket->ticketAssignee->id ? 'selected' : '') . '>' . $agent->name() . '</option>';
                        }
                        ?>
                    </select>
                </li>
                <li>Department:
                    <select name="department" <?= !$isAdminOrAgent ? 'disabled' : '' ?>>
                        <option value="" disabled selected hidden></option>
                        <?php
                        $departments = Department::getDepartments($db);
                        foreach ($departments as $department) {
                            echo '<option value="' . $department->id . '" ' . ($department->id === $ticket->department->id ? 'selected' : '') . '>' . $department->name . '</option>';
                        }
                        ?>
                    </select>
                </li>
                <li>
                    Status:
                    <select name="status" <?= !$isAdminOrAgent ? 'disabled' : '' ?>>
                        <?php
                        $statuses = getStatus($db);
                        foreach ($statuses as $status) {
                            echo '<option value="' . $status['name'] . '" ' . ($status['name'] === $ticket->status ? 'selected' : '') . '>' . $status['name'] . '</option>';
                        }
                        ?>
                    </select>
                </li>
                <li>
                    Priority:
                    <select name="priority" <?= !$isAdminOrAgent ? 'disabled' : '' ?>>
                        <option value="" disabled selected hidden></option>
                        <option value="low" <?= $ticket->priority === 'low' ? 'selected' : '' ?>>Low</option>
                        <option value="medium" <?= $ticket->priority === 'medium' ? 'selected' : '' ?>>Medium</option>
                        <option value="high" <?= $ticket->priority === 'high' ? 'selected' : '' ?>>High</option>
                    </select>
                </li>
                <li>
                    <input type="text" name="hashtags" placeholder="Add hashtags" autocomplete="off" list="ticket-hashtags-suggestions" <?= !$isAdminOrAgent ? 'readonly' : '' ?>>
                    <datalist id="ticket-hashtags-suggestions">
                        <?php
                        $hashtags = getHashtags($db);
                        foreach ($hashtags as $hashtag) { ?>
                            <option value="<?= htmlspecialchars($hashtag['hashtag']) ?>" id="<?= $hashtag['id'] ?>">
                            <?php }
                            ?>
                    </datalist>
                    <ul class="ticket-hashtags">
                        <?php foreach ($ticket->getHashtags($db) as $hashtag) { ?>
                            <li>
                                <a href="" id="<?= $hashtag[0] ?>">
                                    <?= $hashtag[1] ?>
                                    <?php if ($isAdminOrAgent) { ?>
                                        <span class="material-symbols-outlined">close</span>
                                    <?php } ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <li>
                    <a href="ticket_history.php?id=<?php echo $ticket->id; ?>"><span class="material-symbols-outlined">history</span>History</a>
                </li>
                <!-- attachments -->
                <?php if (count($ticket->attachments($db)) > 0) { ?>
                    <li>
                        Attachments:
                        <ul class="attachments">
                            <?php foreach ($ticket->attachments($db) as $attachment) { ?>
                                <li>
                                    <a href="../actions/action_download_file.php?id=<?= $attachment['id'] ?>"><span class="material-symbols-outlined">download</span>Attachment <?= $attachment['id'] ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </form>
    </article>
<?php
}
