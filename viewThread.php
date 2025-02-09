<?php
session_start();
$threadId = $_GET['thread_id'] ?? null;

$con = mysqli_connect("localhost", "root", "", "forum");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if threadId is valid
if ($threadId === null || !is_numeric($threadId)) {
    header("Location: home.php");
    exit;
}

// Prepare and execute the query to fetch the thread
$query = "SELECT * FROM threads WHERE id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $threadId);
mysqli_stmt_execute($stmt);
$threadResult = mysqli_stmt_get_result($stmt);
$thread = mysqli_fetch_assoc($threadResult);

if (!$thread) {
    header("Location: home.php");
    exit;
}

// Prepare and execute the query to fetch posts
$query = "SELECT posts.*, users.username 
          FROM posts 
          INNER JOIN users ON posts.user_id = users.id 
          WHERE thread_id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $threadId);
mysqli_stmt_execute($stmt);
$postsResult = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE HTML>
<html>
<head>
    <title><?php echo htmlspecialchars($thread['title']); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h2><?php echo htmlspecialchars($thread['title']); ?></h2>
        <form action="addPost.php" method="POST" class="mb-4">
            <div class="form-group">
                <textarea class="form-control" name="content" rows="3" required placeholder="Add your post here..."></textarea>
            </div>
            <input type="hidden" name="thread_id" value="<?php echo $threadId; ?>">
            <button type="submit" class="btn btn-primary">Add Post</button>
        </form>

        <h3>Posts:</h3>
        <?php if (mysqli_num_rows($postsResult) > 0): ?>
            <?php while ($post = mysqli_fetch_assoc($postsResult)): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <p><?php echo htmlspecialchars($post['content']); ?></p>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Posted by: <?php echo htmlspecialchars($post['username']); ?></small>
                            <?php if ($post['user_id'] == $_SESSION['user_id'] || $_SESSION['role'] == 2): ?>
                                <div>
                                    <a href="editPost.php?post_id=<?php echo $post['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="deletePost.php?post_id=<?php echo $post['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No posts found for this thread.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
mysqli_close($con);
?>