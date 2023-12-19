<?php
$Servername = "localhost";
$Username = "root";
$Password = "";
$dbname = "todo_list";
$conn = new mysqli($Servername, $Username, $Password, $dbname);
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Perform validation
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Fetch user from the database
    $sql = "SELECT ID, username, password FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in the prepared statement: " . $conn->error);
    }

    $stmt->bind_param("s", $username);

    if (!$stmt->execute()) {
        die("Error executing the query: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if (!$result) {
        die("Error getting result: " . $stmt->error);
    }

    $user = $result->fetch_assoc();

    $stmt->close();

    // Validate the password
    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        $_SESSION['ID'] = $user['ID'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
</head>
<body>
    <h2>User Login</h2>
    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>
