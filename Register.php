<?php

$Servername = "localhost";
$Username = "root";
$Password = "";
$dbname = "todo_list";
$conn = new mysqli($Servername, $Username, $Password, $dbname);
if ($conn->connect_error) {
    die("Connection Faild". $conn->connect_error);
}else{
    echo"Connetion Successfully";
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Perform validation
    $Username = trim($_POST['username']);
    $Password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Password confirmation
    if ($Password !== $confirm_password) {
        echo "Password and Confirm Password do not match.";
        // You might want to handle this more gracefully, like displaying an error message on the form.
    } else {
        // Hash the password before storing it
        $hashed_password = password_hash($Password, PASSWORD_DEFAULT);

        // Use prepared statements to prevent SQL injection
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ss", $Username, $hashed_password);
            $stmt->execute();
            $stmt->close();

            // Redirect to login page after successful registration
            header("Location: Index.php");
            exit();
        } else {
            echo "Registration failed. Please try again.";
            // You might want to handle this more gracefully, like displaying an error message on the form.
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" required>

        <button type="submit" name="register">Register</button>
    </form>
</body>
</html>