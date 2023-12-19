<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['ID'])) {
    header("Location: dashboard.php"); // Redirect back to the dashboard
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

// Process the task deletion request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_task'])) {
    // Get the task ID from the form
    $task_id = $_POST['task_id'];

    // Delete the task from the database
    $sql = "DELETE FROM tasks WHERE task_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in the prepared statement: " . $conn->error);
    }

    $stmt->bind_param("i", $task_id);

    if (!$stmt->execute()) {
        die("Error executing the query: " . $stmt->error);
    }

    $stmt->close();

    // Redirect back to the dashboard after deleting the task
    header("Location: dashboard.php");
    exit();
} else {
    // If someone tries to access this page without submitting the form, redirect them to the dashboard
    header("Location: dashboard.php");
    exit();
}
?>
