<?php

$Servername = "localhost";
$Username = "root";
$Password = "";
$dbname = "todo_list";
$conn = new mysqli($Servername, $Username, $Password, $dbname);
if ($conn->connect_error) {
    die("Connection Faild". $conn->connect_error);
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
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="username">Username:</label></br>
        <input type="text" name="username" required></br>

        <label for="password">Password:</label></br>
        <input type="password" name="password" required></br>

        <label for="confirm_password">Confirm Password:</label></br>
        <input type="password" name="confirm_password" required></br>

        <button type="submit" name="register">Register</button>
    </form>
</body>
</html>