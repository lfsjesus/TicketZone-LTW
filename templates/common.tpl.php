<?php function drawHeader(string $pageName) { ?>
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
  </head> 
  <body>           
<?php } ?>


<!-- Maybe we do not need this function in the future! -->
<?php function drawNavbar(Session $session){ ?>
  <nav id="menu">
      <img src="../images/ticketzone_logo.png" alt="logo" class="logo">
      <ul>
        <li><a href="/../pages/dashboard.php"><span class="material-symbols-outlined">dashboard</span>Dashboard</a></li>
        <li><a href="/../pages/userTicket.php"><span class="material-symbols-outlined">feed</span>My tickets</a></li>
        <li><a href=""><span class="material-symbols-outlined">quiz</span>FAQ</a></li>
        <li><a href="/../pages/about.php"><span class="material-symbols-outlined">info</span>About us</a></li>
      </ul>  
      <?php 
          if ($session->isLoggedIn()) { ?>
          <footer>
            <!--button with href-->
            <a href="/../pages/profile.php"><span class="material-symbols-outlined">person</span>Profile</a>
            <form action="/../actions/action_logout.php" method="post">
              <!-- LOGOUT BUTTON WITH TEXT AND ICON -->
              <button type="submit" name="logout" class="logout-button">Logout<span class="material-symbols-outlined">logout</span></button>
            </form>
          </footer>
      <?php } ?>
  </nav>
<?php } ?>


<?php function drawSearchbar(){ ?>
  <header>
    <form class="search-form">
    <input type="text" placeholder="Search for tickets..." name="ticketName">
    <button type="submit"><span class="material-symbols-outlined">search</span></button>
    </form>
    <!-- button to create new ticket that redirect to page to create ticket -->
    <button class="create-ticket">
      <a href="/../pages/create_ticket.php"><span class="material-symbols-outlined">add_circle</span>Create Ticket</a></button>
  </header>
<?php } ?>

<?php function drawFooter() { ?>
  
  </body>
</html>
<?php } ?>

