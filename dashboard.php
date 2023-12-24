<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['ID'])) {
    header("Location: login.php");
    exit();
}

$Servername = "localhost";
$Username = "root";
$Password = "";
$dbname = "todo_list";
$conn = new mysqli($Servername, $Username, $Password, $dbname);
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Fetch tasks for the logged-in user
$user_id = $_SESSION['ID'];
$sql = "SELECT * FROM tasks WHERE user_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error in the prepared statement: " . $conn->error);
}

$stmt->bind_param("i", $user_id);

if (!$stmt->execute()) {
    die("Error executing the query: " . $stmt->error);
}

$result = $stmt->get_result();
$stmt->close();
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
            
            background: linear-gradient( #FF0000, #FF4500); /* Red to Orange gradient */
            height: auto; /* Ensure the gradient covers the entire viewport height */
            margin: 0; /* Remove default margin */
        
        }

        .new, h2{
            text-align: center;
        }

        input,textarea{
            background-color: #fff;
            padding: 10px 20px;
            border: 15px;
            border-radius: 20px;
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.8);
            margin-bottom: 25px;
            margin-top: 10px;
        }

        li{
            padding-bottom: 15px;
        }

        button {
            background-color: #fff; /* Button background color */
            padding: 10px 20px; /* Adjust padding as needed */
            border: none;
            border-radius: 20px; /* Rounded corners */
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.8); /* Shadow */
            cursor: pointer;
        }

        h2,label,h3 {
            color: #fff; /* Set text color to white for better contrast */
        }

        label{
            font-weight: bold;
        }

        .topnav {
            background-color: #FF4500;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Shadow */
            }

            /* Style the links inside the navigation bar */
           
        .topnav a {
            float: right;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
            }

            /* Change the color of links on hover */
        .topnav a:hover {
            background-color: #000;
            color: white;
            }

            /* Add a color to the active/current link */
        .topnav a.active {
            background-color: #04AA6D;
            color: white;
            }

        h2 {
            text-align: center;
        }

        h3 {
            text-align: center;
            color: #fff; /* Set text color to white for better contrast */
            margin-bottom: 20px; /* Add margin for spacing */
        }

        li {
        border: 2px solid #fff; /* Add a border with 2px thickness and white color */
        padding: 10px; /* Add padding for better visual appeal */
        border-radius: 10px; /* Optional: Add rounded corners for a softer look */
    }
    </style>
    <title>Todo List Dashboard</title>
</head>
<body>
    <div class="topnav">
        <a href="logout.php">Logout</a>
    </div>
            
    <h2>Welcome to Your Todo List</h2>

    <h3>Your Tasks:</h3>
<ul>
    <?php while ($task = $result->fetch_assoc()) : ?>
        <li>
            <strong><?php echo $task['task_name']; ?></strong>
            <p><?php echo $task['description']; ?></p>
            <p>Due Date: <?php echo $task['due_date']; ?></p>
            <p>Status: <?php echo $task['status']; ?></p>

            <!-- Form for deleting the task -->
            <form method="POST" action="delete_task.php">
                <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
                <button type="submit" name="delete_task">Delete Task</button>
            </form>
        </li>
    <?php endwhile; ?>
</ul>

    <!-- Task Form -->
    <h3>Add a New Task:</h3>
    <form method="POST" action="add_task.php" class="new">
        <label for="task_name">Task Name:</label></br>
        <input type="text" name="task_name" required></br>

        <label for="description">Description:</label></br>
        <textarea name="description" rows="4" required></textarea></br>

        <label for="due_date">Due Date:</label></br>
        <input type="date" name="due_date" required></br>

        <button type="submit" name="add_task">Add Task</button>
    </form>    
</body>
</html>
