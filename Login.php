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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&family=Rubik+Scribble&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            text-align: center;
            background: linear-gradient( #FF0000, #FF4500); /* Red to Orange gradient */
            height: 100vh; /* Ensure the gradient covers the entire viewport height */
            margin: 0; /* Remove default margin */
        
        }

        input{
            background-color: #fff;
            padding: 10px 20px;
            border: 15px;
            border-radius: 20px;
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.8);
            margin-bottom: 25px;
            margin-top: 10px;
        }

        button {
            background-color: #fff; /* Button background color */
            padding: 10px 20px; /* Adjust padding as needed */
            border: none;
            border-radius: 20px; /* Rounded corners */
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.8); /* Shadow */
            cursor: pointer;
        }

        h2,label {
            color: #fff; /* Set text color to white for better contrast */
        }

        label{
            font-weight: bold;
        }
    </style>

    <title>User Login</title>
</head>
<body>
    <h2>User Login</h2>
    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="username">Username:</label></br>
        <input type="text" name="username" required></br>

        <label for="password">Password:</label></br>
        <input type="password" name="password" required></br>

        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>
