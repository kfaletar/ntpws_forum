<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "forum");

$userId = $_SESSION['user_id'];
$threadId = $_GET['thread_id'];

$query = "INSERT INTO subscriptions (user_id, thread_id) VALUES ($userId, $threadId)";
mysqli_query($con, $query);

mysqli_close($con);
header("Location: home.php");
exit;
?>