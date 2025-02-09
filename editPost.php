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

if ($postId === null || !is_numeric($postId)) {
    header("Location: home.php");
    exit;
}

// Fetch the post to edit
$query = "SELECT * FROM posts WHERE id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $postId);
mysqli_stmt_execute($stmt);
$postResult = mysqli_stmt_get_result($stmt);
$post = mysqli_fetch_assoc($postResult);

if (!$post) {
    header("Location: home.php");
    exit;
}

// Handle form submission for editing the post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];
    $updateQuery = "UPDATE posts SET content = ? WHERE id = ?";
    $updateStmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, "si", $content, $postId);
    mysqli_stmt_execute($updateStmt);
    
    // Redirect back to the thread after editing
    header("Location: viewThread.php?thread_id=" . $post['thread_id']);
    exit;
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Edit Post</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h2>Edit Post</h2>
        <form action="" method="POST">
            <div class="form-group">
                <textarea class="form-control" name="content" rows="5" required><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </div>
</body>
</html>

<?php
mysqli_close($con);
?>