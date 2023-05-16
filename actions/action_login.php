<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../utils/session.php');
    $error = '';
    $session = new Session();

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $db = getDatabaseConnection();
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = User::getUserWithEmail($db, $email);
    
    $hash = $db->prepare('SELECT password FROM Users WHERE email = ?');
    $hash->execute(array($email));
    $hash = $hash->fetch();
    $hash = $hash['password'];
    
    if ($user && password_verify($password, $hash)) {
        $session->setId($user->id);
        $session->setUser($user);
        header('Location: ../pages/userTicket.php');
        
    } else {
        $error = 'Wrong email or password!';
        header('Location: ../pages/login_page.php?error=' . urlencode($error));
    }

?> 