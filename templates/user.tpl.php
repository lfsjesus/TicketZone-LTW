<?php declare(strict_types = 1); ?>

<?php function drawProfileForm(User $user) { 
  $error = $_GET['error'];
  ?>
<form action="../actions/action_edit_profile.php" method="post" class="profile">

    <label for="first_name">First Name:</label>
    <input id="first_name" type="text" name="first_name" value="<?=$user->firstName?>">
    
    <label for="last_name">Last Name:</label>
    <input id="last_name" type="text" name="last_name" value="<?=$user->lastName?>">  
    
    <label for="username">Username:</label>
    <input id="username" type="text" name="username" value="<?=$user->username?>"> 

    <label for="email">Email:</label>
    <input id="email" type="text" name="email" value="<?=$user->email?>"> 

    <label for="password">Password:</label>
    <input id="password" type="password" name="password" placeholder="New password">
  
    <label for="repeat_password">Repeat Password:</label>
    <input id="repeat_password" type="password" name="repeat_password" placeholder="Repeat new password">

  <button type="submit">Save</button>
  <span><?php echo $error ?></span>

</form>
<?php } ?>