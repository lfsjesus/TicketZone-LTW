<?php 
declare (strict_types = 1);
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/connection.db.php');

function drawHeader(string $pageName) { ?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title><?=$pageName . " - TicketZone"?></title>
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <script src="../javascript/script.js" defer></script>
  <?php if ($_SERVER['REQUEST_URI'] == '/pages/userTicket.php') { ?>
  <script src="../javascript/table_tickets.js" defer></script>
  <?php } 
  // if inside ticket page
  if (strpos($_SERVER['REQUEST_URI'], 'ticket.php') !== false) { ?>
  <script src="../javascript/ticket_edit.js" defer></script>
  <?php }
  ?>
  </head> 
  <body>           
<?php } 


function drawNavbar(Session $session){ ?>
  <nav id="menu">
      <img src="../images/ticketzone_logo.png" alt="logo" class="logo">
      <ul>
        <li><a href="/../pages/dashboard.php"><span class="material-symbols-outlined">dashboard</span>Dashboard</a></li>
        <li><a href="/../pages/userTicket.php"><span class="material-symbols-outlined">feed</span>My tickets</a></li>
        <li><a href="/../pages/faq_page.php"><span class="material-symbols-outlined">quiz</span>FAQ</a></li>
        <li><a href="/../pages/about.php"><span class="material-symbols-outlined">info</span>About us</a></li>
      </ul>  
      <?php 
          if ($session->isLoggedIn()) { ?>
          <footer>
            <!--button with href-->
            <a href="/../pages/edit_profile.php"><span class="material-symbols-outlined">person</span>Profile</a>
            <form action="/../actions/action_logout.php" method="post">
              <!-- LOGOUT BUTTON WITH TEXT AND ICON -->
              <button type="submit" name="logout" class="logout-button">Logout<span class="material-symbols-outlined">logout</span></button>
            </form>
          </footer>
      <?php } ?>
  </nav>
<?php } 


function drawSearchbar(){
  $db = getDatabaseConnection();
?>
  <header>
    <form class="search-form">
    <input type="text" placeholder="Search for tickets... Use # for hashtags" name="ticketName">
    <button type="submit"><span class="material-symbols-outlined">search</span></button>
    </form>

    <!-- options for tickets when selected like delete, change status, etc-->
    <form class="ticket-options" style="display: none">
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
                      <option value="<?=$department->id?>"><?=$department->name?></option>
              <?php }
              ?>
      </select>
      <select name="assignee">
              <option value="" disabled selected hidden>Assignee</option>
              <?php
                  $assignes = User::getAgents($db);
                  foreach ($assignes as $assignee) { ?>
                      <option value="<?=$assignee->id?>"><?=$assignee->name()?></option>
              <?php }
              ?>
      </select>
      <button class="delete-ticket"><span class="material-symbols-outlined">delete</span></button>
    </form>

    <!-- button to create new ticket that redirect to page to create ticket -->
    <button class="create-ticket">
      <a href="/../pages/create_ticket.php"><span class="material-symbols-outlined">add_circle</span>Create Ticket</a>
    </button>
  </header>
<?php } 

function drawFooter() { ?>
  
  </body>
</html>
<?php } ?>

