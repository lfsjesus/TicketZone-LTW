<?php 
declare (strict_types = 1);
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../database/connection.db.php'); 

function drawTicket(Ticket $ticket){
    $db = getDatabaseConnection();
    ?>
    <article class="ticket-body">
      <form method="post" action = "../actions/action_edit_ticket.php">
        <h1><input type="text" name="title" value="<?php echo $ticket->title ?>"></h1>
        <textarea name="description"><?php echo $ticket->description ?></textarea>
        <input type="hidden" name="id" value="<?php echo $ticket->id ?>">
        <ul class="ticket-meta">
          <li>Created by: <?php echo $ticket->ticketCreator->name() ?></li>
          <li>Created at: <?php echo $ticket->dateCreated->format('d/m/Y H:i') ?></li>
          <li>Assigned to: 
            <select name = "assignee">
              <?php
                $agents = User::getAgents($db);
                foreach ($agents as $agent) {
                  echo '<option value="' . $agent->id . '" ' . ($agent->id === $ticket->ticketAssignee->id ? 'selected' : '') . '>' . $agent->name() . '</option>';
                }
              ?>
            </select>
          <li>Department: 
            <select name = "department">
              <?php
                $departments = Department::getDepartments($db);
                foreach ($departments as $department) {
                  echo '<option value="' . $department->id . '">' . $department->name . '</option>';
                }
              ?>
            </select>
          </li>
          <li>
            Status:
            <select name="status">
              <option value="open" <?php echo $ticket->status === 'open' ? 'selected' : ''; ?>>Open</option>
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
        <button type = "submit" name = "submit" value = "submit">Submit</button>
      </form>
    </article>
    <?php
}
    