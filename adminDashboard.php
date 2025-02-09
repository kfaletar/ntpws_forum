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

$threadsQuery = "SELECT threads.id, threads.title, users.username AS author 
                 FROM threads 
                 INNER JOIN users ON threads.user_id = users.id 
                 ORDER BY threads.created_at DESC";
$threadsResult = mysqli_query($con, $threadsQuery);
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Admin Dashboard - Manage Threads</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h2>Admin Dashboard - Manage All Threads</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($threadsResult) > 0): ?>
                    <?php while ($thread = mysqli_fetch_assoc($threadsResult)): ?>
                        <tr>
                            <td><a href="viewThread.php?thread_id=<?php echo $thread['id']; ?>"><?php echo htmlspecialchars($thread['title']); ?></a></td>
                            <td><?php echo htmlspecialchars($thread['author']); ?></td>
                            <td>
                                <a href="addThread.php?thread_id=<?php echo $thread['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="deleteThread.php?thread_id=<?php echo $thread['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this thread?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No threads found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
mysqli_close($con);
?>