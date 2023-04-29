<?php 
declare (strict_types = 1);
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/connection.db.php'); 

function drawTicket(Ticket $ticket){
    $db = getDatabaseConnection();
    ?>
    <article class="ticket-body">
      <h1><?php echo $ticket->title ?></h1>
      <p class="ticket-description"><?php echo $ticket->description ?></p>
      <form method="post">
        <ul class="ticket-meta">
          <li>Created by: <?php echo $ticket->ticketCreator->name() ?></li>
          <li>Created at: <?php echo $ticket->dateCreated->format('d/m/Y H:i') ?></li>
          <?php if ($ticket->ticketAssignee): ?>
            <li>Assigned to: <?php echo $ticket->ticketAssignee->name() ?></li>
          <?php endif; ?>
          <li>Department: <?php echo $ticket->department?></li>
          <li>
            Status:
            <select name="status">
              <option value="pending" <?php echo $ticket->status === 'pending' ? 'selected' : ''; ?>>Pending</option>
              <option value="assigned" <?php echo $ticket->status === 'assigned' ? 'selected' : ''; ?>>Assigned</option>
              <option value="resolved" <?php echo $ticket->status === 'resolved' ? 'selected' : ''; ?>>Resolved</option>
            </select>
          </li>
          <li>
            Priority:
            <select name="priority">
              <option value="low" <?php echo $ticket->priority === 'low' ? 'selected' : ''; ?>>Low</option>
              <option value="medium" <?php echo $ticket->priority === 'medium' ? 'selected' : ''; ?>>Medium</option>
              <option value="high" <?php echo $ticket->priority === 'high' ? 'selected' : ''; ?>>High</option>
            </select>
          </li>
          <li>
            Hashtags:
            <input type="text" name="hashtags" value="<?php echo ($ticket->hashtags ? implode(', ', $ticket->hashtags) : ''); ?>">
          </li>
          <!-- attachments -->
          <?php if (count($ticket->attachments($db)) > 0) { ?>
            <li>
              Attachments:
              <ul>
                <?php foreach ($ticket->attachments($db) as $attachment) { ?>
                  <li>
                    <a href="actions/action_download.php?id=<?= $attachment['id'] ?>">Attachment <?= $attachment['id'] ?></a>
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
    