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

// Process the task addition form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_task'])) {
    $user_id = $_SESSION['ID'];
    $task_name = trim($_POST['task_name']);
    $description = trim($_POST['description']);
    $due_date = $_POST['due_date'];

    // Insert the new task into the database
    $sql = "INSERT INTO tasks (user_id, task_name, description, due_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in the prepared statement: " . $conn->error);
    }

    $stmt->bind_param("isss", $user_id, $task_name, $description, $due_date);
    

    if (!$stmt->execute()) {
        die("Error executing the query: " . $stmt->error);
    }

    $stmt->close();

    // Redirect back to the dashboard after adding the task
    header("Location: dashboard.php");
    exit();
} else {
    // If someone tries to access this page without submitting the form, redirect them to the dashboard
    header("Location: dashboard.php");
    exit();
}
?>
