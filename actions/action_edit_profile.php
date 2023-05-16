<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

$session = new Session();

$db = getDatabaseConnection();

$user = User::getUser($db, $session->getId());

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    if ((strlen($new_password) >= 1) && (strlen($new_password) < 8)) {
        $error = 'Password must be at least 8 characters long';
    } elseif ((strlen($new_password) >= 8) && ($new_password !== $repeat_password)) {
        $error = "Passwords do not match!";
    } else {
        // Check if password is not empty before hashing
        if (strlen($new_password) > 0) {
            // Validate input
            if (!preg_match('/^[a-zA-Z0-9]+$/', $new_password)) {
                $error = 'Password must contain only letters and numbers';
            } else {
                // Hash password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Prepare SQL statement to update user's password in database
                $stmt = $db->prepare("UPDATE Users SET password = :password WHERE id = :id");

                // Bind parameters to statement
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':id', $session->getId());

                // Execute statement
                if ($stmt->execute()) {
                    // Success message
                    header('Location: ../pages/userTicket.php');
                    exit();
                } else {
                    $error = "Error updating password!";
                }
            }
        }
    }

    $username = $_POST['username'];
    $email = $_POST['email'];

    // Check if username or email already exist
    $checkStmt = $db->prepare("SELECT COUNT(*) FROM Users WHERE (username = :username OR email = :email) AND id != :id");
    $checkStmt->bindParam(':username', $username);
    $checkStmt->bindParam(':email', $email);
    $checkStmt->bindParam(':id', $session->getId());
    $checkStmt->execute();
    $count = $checkStmt->fetchColumn();

    if ($count > 0) {
        $error = "Username or email already in use";
    }

    if ($error) {
        header('Location: ../pages/edit_profile.php?error=' . urlencode($error));
        exit();
    }

    if ($user) {
        $user->firstName = $_POST['first_name'];
        $user->lastName = $_POST['last_name'];
        $user->username = $username;
        $user->email = $email;

        $user->save($db);

        header('Location: ../pages/userTicket.php');
        exit();
    }
}
?>
