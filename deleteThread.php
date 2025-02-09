<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 2) { 
    header("Location: index.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "forum");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$threadId = $_GET['thread_id'] ?? null;

if ($threadId) {
    // Delete the thread
    $deleteQuery = "DELETE FROM threads WHERE id = $threadId";
    if (mysqli_query($con, $deleteQuery)) {
        // Redirect back to the admin dashboard
        header ("Location: adminDashboard.php");
        exit;
    } else {
        echo "Error deleting thread: " . mysqli_error($con);
    }
} else {
    echo "Invalid thread ID.";
}

mysqli_close($con);
?>