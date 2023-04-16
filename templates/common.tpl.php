<?php function drawHeader() { ?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Name</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../javascript/script.js" defer></script>
  </head> 
  <body>           
<?php } ?>


<!-- Maybe we do not need this function in the future! -->
<?php function drawNavbar(){ ?>
  <nav id="menu">
      <h2 id = "logo"><a href= "/../pages/index.php">Name</a></h2>
      <ul>
        <li><a href="">Create a ticket</a></li>
        <li><a href="/../pages/userTicket.php">My tickets</a></li>
        <li><a href="">FAQ</a></li>
        <li><a href="/../pages/about.php">About us</a></li>
      </ul>  
  </nav>
<?php } ?>

<?php function drawSearchbar(){ ?>
  <header>
    <form class="search-form">
    <input type="text" placeholder="Search for tickets..." name="ticketName">
    <button type="submit"><img src ="/../images/searchIcon.png" alt="Search icon image"></i></button>
  </header>
<?php } ?>

<?php function drawFooter() { ?>
  
  </body>
</html>
<?php } ?>

