<?php
session_start();
$content = $_POST['content'] ?? '';
$threadId = $_POST['thread_id'];
$userId = $_SESSION['user_id'];

$con = mysqli_connect("localhost", "root", "", "forum");
$query = "INSERT INTO posts (thread_id, user_id, content) VALUES ($threadId, $userId, '$content')";
mysqli_query($con, $query);
mysqli_close($con);

header("Location: viewThread.php?thread_id=$threadId");
exit;
?>