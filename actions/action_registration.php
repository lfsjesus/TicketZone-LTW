<?php

require_once(__DIR__ . '/../database/connection.db.php');
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    // Check if passwords match
    if ($password !== $repeat_password) {
        $error = "Passwords do not match!";
    } else {
        // Validate input
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Invalid email address';
        } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $password)) {
            $error = 'Password must contain only letters and numbers';
        } elseif ((strlen($password) >= 1) && (strlen($password) < 8)) {
            $error = 'Password must be at least 8 characters long';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $pdo = getDatabaseConnection();

            $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM Users WHERE username = :username OR email = :email");
            $checkStmt->bindParam(':username', $username);
            $checkStmt->bindParam(':email', $email);
            $checkStmt->execute();
            $count = $checkStmt->fetchColumn();

            if ($count > 0) {
                $error = "Username or email already in use";
            } else {
                $stmt = $pdo->prepare("INSERT INTO Users (username, password, email, firstName, lastName, type) VALUES (:username, :password, :email, :firstName, :lastName, :type)");

                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':firstName', $firstName);
                $stmt->bindParam(':lastName', $lastName);
                $stmt->bindValue(':type', 'client'); // default to 'client' type

                if ($stmt->execute()) {
                    header('Location: ../pages/login_page.php');
                    exit();
                } else {
                    $error = "Error creating account!";
                }
            }
        }
    }
}

if ($error) {
    header('Location: ../pages/registration_page.php?error=' . urlencode($error));
    exit();
}
?>
