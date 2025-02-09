<?php
session_start();
$postId = $_POST['post_id'];
$content = $_POST['content'];

$con = mysqli_connect("localhost", "root", "", "forum");
$query = "UPDATE posts SET content = '$content' WHERE id = $postId";
mysqli_query($con, $query);
mysqli_close($con);

header("Location: viewThread.php?thread_id=" . $postId);
exit;
?>