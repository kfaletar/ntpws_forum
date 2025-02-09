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

$query = "SELECT threads.id, threads.title, users.username AS author, threads.created_at 
          FROM threads 
          INNER JOIN users ON threads.user_id = users.id 
          ORDER BY threads.created_at DESC";
$result = mysqli_query($con, $query);

$userId = $_SESSION['user_id'];
$subscribedThreadsQuery = "SELECT thread_id FROM subscriptions WHERE user_id = $userId";
$subscribedThreadsResult = mysqli_query($con, $subscribedThreadsQuery);

$subscribedThreadIds = [];
while ($row = mysqli_fetch_assoc($subscribedThreadsResult)) {
    $subscribedThreadIds[] = $row['thread_id'];
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Forum Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2>All Threads</h2>
        <a href="addThread.php" class="btn btn-primary">Start New Thread</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($thread = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><a href="viewThread.php?thread_id=<?php echo $thread['id']; ?>"><?php echo htmlspecialchars($thread['title']); ?></a></td>
                        <td><?php echo htmlspecialchars($thread['author']); ?></td>
                        <td><?php echo htmlspecialchars($thread['created_at']); ?></td>
                        <td>
                            <a href="viewThread.php?thread_id=<?php echo $thread['id']; ?>" class="btn btn-info">View</a>
                            <?php if (in_array($thread['id'], $subscribedThreadIds)): ?>
                                <span class="text-success">Subscribed</span>
                            <?php else: ?>
                                <a href="subscribe.php?thread_id=<?php echo $thread['id']; ?>" class="btn btn-success">Subscribe</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
mysqli_close($con);
?>