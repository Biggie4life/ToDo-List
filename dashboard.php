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
    <title>Todo List Dashboard</title>
</head>
<body>
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
    <form method="POST" action="add_task.php">
        <label for="task_name">Task Name:</label>
        <input type="text" name="task_name" required>

        <label for="description">Description:</label>
        <textarea name="description" rows="4" required></textarea>

        <label for="due_date">Due Date:</label>
        <input type="date" name="due_date" required>

        <button type="submit" name="add_task">Add Task</button>
    </form>

    <br>
    <a href="logout.php">Logout</a>
</body>
</html>
