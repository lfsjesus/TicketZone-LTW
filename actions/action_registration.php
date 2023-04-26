<?php

require_once(__DIR__ . '/../database/connection.db.php');
$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    // Check if passwords match
    if($password !== $repeat_password) {
        $error = "Passwords do not match!";
    } else {
        // Validate input
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = 'Invalid email address';
        } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $password)) {
            $error = 'Password must contain only letters and numbers';
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Open connection to database
            $pdo = getDatabaseConnection();

            // Prepare SQL statement to insert user into database
            $stmt = $pdo->prepare("INSERT INTO Users (username, password, email, firstName, lastName,type, department_id) VALUES (:username, :password, :email, :firstName, :lastName, :type, :department_id)");

            // Bind parameters to statement
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindValue(':type', 'client'); // default to 'client' type
            $stmt->bindValue(':department_id', 1); // default to department 1

            // Execute statement
            if ($stmt->execute()) {
                // Success message
                echo "User created successfully! <a href='../pages/login_page.php'>Login here</a>";
            } else {
                // Error message
                echo "Error creating user!";
            }   
        }
    }
}
?>

<?php if($error): ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>

