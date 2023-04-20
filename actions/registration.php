<?php
$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $fullname = $_POST['fullname'];
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
            try {
                $pdo = new PDO('sqlite:' . __DIR__ . '/../database/tickets.db');
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                exit();
            }

            // Prepare SQL statement to insert user into database
            $stmt = $pdo->prepare("INSERT INTO Users (username, password, email, name, type, department_id) VALUES (:username, :password, :email, :name, :type, :department_id)");

            // Bind parameters to statement
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':name', $fullname);
            $stmt->bindValue(':type', 'client'); // default to 'client' type
            $stmt->bindValue(':department_id', NULL); // default to department NULL

            // Generate username from email address
            $username = strtok($email, '@');

            // Execute statement
            if ($stmt->execute()) {
                // Success message
                echo "User created successfully! <a href='login.php'>Login here</a>";
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

<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <label for="fullname">Full Name:</label>
    <input type="text" id="fullname" name="fullname" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <label for="repeat_password">Repeat Password:</label>
    <input type="password" id="repeat_password" name="repeat_password" required>

    <input type="submit" value="Register">
</form>

<p>Already have an account? <a href="login.php">Login here</a></p>
