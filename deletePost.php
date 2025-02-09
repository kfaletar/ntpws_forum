<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "forum");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$postId = $_GET['post_id'] ?? null;

if ($postId) {
    $postQuery = "SELECT thread_id FROM posts WHERE id = $postId";
    $postResult = mysqli_query($con, $postQuery);
    $post = mysqli_fetch_assoc($postResult);

    if ($post) {
        $threadId = $post['thread_id'];

        $deleteQuery = "DELETE FROM posts WHERE id = $postId";
        if (mysqli_query($con, $deleteQuery)) {
            header("Location: viewThread.php?thread_id=" . $threadId);
            exit;
        } else {
            echo "Error deleting post: " . mysqli_error($con);
        }
    } else {
        header("Location: home.php");
        exit;
    }
} else {
    header("Location: home.php");
    exit;
}

mysqli_close($con);
?>