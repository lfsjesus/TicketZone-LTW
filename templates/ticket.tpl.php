<?php 
declare (strict_types = 1);
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../database/connection.db.php'); 

function drawTicket(Ticket $ticket){
    $db = getDatabaseConnection();
    ?>
    <article class="ticket-body">
      <form>
        <input type="hidden" name="id" value="<?= $ticket->id ?>">
        <div class="ticket-header">
          <h1><?=$ticket->title?></h1>
          <span class="material-symbols-outlined">edit</span>
        </div>
        <p class="ticket-description"><?=$ticket->description?></p>
        <ul class="ticket-meta">
          <li>Created by: <?php echo $ticket->ticketCreator->name() ?></li>
          <li>Created at: <?php echo $ticket->dateCreated->format('d/m/Y H:i') ?></li>
          <li>Assigned to: 
            <select name = "assignee">
            <option value="" disabled selected hidden></option>
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
                  echo '<option value="' . $department->id . '" ' . ($department->id === $ticket->department->id ? 'selected' : '') . '>' . $department->name . '</option>';
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
              <!-- dummy option -->
              <option value="" disabled selected hidden></option>
              <option value="low" <?php echo $ticket->priority === 'low' ? 'selected' : ''; ?>>Low</option>
              <option value="medium" <?php echo $ticket->priority === 'medium' ? 'selected' : ''; ?>>Medium</option>
              <option value="high" <?php echo $ticket->priority === 'high' ? 'selected' : ''; ?>>High</option>
            </select>
          </li>
          <li>
            <input type="text" name="hashtags" placeholder="Add hashtags" autocomplete="off" list="ticket-hashtags-suggestions">
            <datalist id="ticket-hashtags-suggestions">
              <?php 
              $stmt = $db->prepare('SELECT id, hashtag FROM TicketHashtags');
              $stmt->execute();
              $hashtags = $stmt->fetchAll();
              foreach ($hashtags as $hashtag) { ?>
                <option value="<?= $hashtag['hashtag'] ?>" id="<?= $hashtag['id'] ?>">
              <?php }
              ?>
            </datalist>
            <ul class="ticket-hashtags">
              <?php foreach ($ticket->getHashtags($db) as $hashtag) { ?>
                <li>
                  <a href="" id="<?= $hashtag[0] ?>">
                    <?= $hashtag[1] ?>
                    <span class="material-symbols-outlined">close</span>
                  </a>
                </li>
              <?php } ?>
            </ul>
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
    