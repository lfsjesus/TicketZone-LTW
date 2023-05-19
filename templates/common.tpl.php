<?php

declare(strict_types=1);
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/connection.db.php');

function drawHeader(string $pageName)
{ ?>
  <!DOCTYPE html>
  <html lang="en-US">

  <head>
    <title><?= $pageName . " - TicketZone" ?></title>
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <script src="../javascript/script.js" defer></script>
    <?php if ($_SERVER['REQUEST_URI'] == '/pages/userTicket_page.php') { ?>
    <script src="../javascript/table_tickets.js" defer></script>
    <?php }
    // if inside ticket page
    if (strpos($_SERVER['REQUEST_URI'], 'ticket_page.php') !== false) { ?>
    <script src="../javascript/ticket_edit.js" defer></script>
    <?php }

    if (strpos($_SERVER['REQUEST_URI'], 'management_page.php') !== false) { ?>
    <script src="../javascript/management.js" defer></script>
    <?php }
    ?>
  </head>

  <body>
  <?php }


function drawNavbar(Session $session)
{ ?>
    <nav id="menu">
      <img src="../images/ticketzone_logo.png" alt="logo" class="logo">
      <ul>
        <?php if ($session->getUser()->type == 'admin') { ?>
          <li><a href="/../pages/management_page.php"><span class="material-symbols-outlined">people</span>Management</a></li>
        <?php } ?>
        <li><a href="/../pages/userTicket_page.php"><span class="material-symbols-outlined">feed</span>Tickets</a></li>
        <li><a href="/../pages/faq_page.php"><span class="material-symbols-outlined">quiz</span>FAQ</a></li>
        <li><a href="/../pages/about_page.php"><span class="material-symbols-outlined">info</span>About us</a></li>
      </ul>
      <?php
      if ($session->isLoggedIn()) { ?>
        <footer>
          <a href="/../pages/edit_profile_page.php"><span class="material-symbols-outlined">person</span>Profile</a>
          <form action="/../actions/action_logout.php" method="post">
            <button type="submit" name="logout" class="logout-button">Logout<span class="material-symbols-outlined">logout</span></button>
          </form>
        </footer>
      <?php } ?>
    </nav>
  <?php }


function drawUserTicketHeader(Session $session)
{
  $db = getDatabaseConnection();
  ?>
    <header>
      <form class="search-form">
        <input type="text" placeholder="Search for tickets... Use # for hashtags" name="ticketName">
        <button type="submit"><span class="material-symbols-outlined">search</span></button>
      </form>

      <form class="ticket-options" style="display: none">
        <?php
        $userType = $session->getUser()->type;
        if ($userType === 'admin' || $userType === 'agent') {
        ?>
          <select name="status">
            <option value="" disabled selected hidden>Status</option>
            <option value="open">Open</option>
            <option value="assigned">Assigned</option>
            <option value="resolved">Resolved</option>
          </select>
          <select name="priority">
            <option value="" disabled selected hidden>Priority</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
          </select>
          <select name="department">
            <option value="" disabled selected hidden>Department</option>
            <?php
            $departments = Department::getDepartments($db);
            foreach ($departments as $department) { ?>
              <option value="<?= $department->id ?>"><?= $department->name ?></option>
            <?php }
            ?>
          </select>
          <select name="assignee">
            <option value="" disabled selected hidden>Assignee</option>
            <?php
            $assignes = User::getAgents($db);
            foreach ($assignes as $assignee) { ?>
              <option value="<?= $assignee->id ?>"><?= $assignee->name() ?></option>
            <?php }
            ?>
          </select>
        <?php } ?>
        <button class="delete"><span class="material-symbols-outlined">delete</span></button>
      </form>

      <a class="create-button" href="/../pages/create_ticket_page.php"><span class="material-symbols-outlined">add_circle</span>Create Ticket</a>

    </header>
  <?php }

function drawFooter()
{ ?>

  </body>

  </html>
<?php } ?>