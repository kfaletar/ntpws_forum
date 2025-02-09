<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];
$userId = $_SESSION['user_id'];

$con = mysqli_connect("localhost", "root", "", "forum");

$threadsQuery = "SELECT threads.id, threads.title 
                 FROM threads 
                 WHERE threads.user_id = $userId";
$threadsResult = mysqli_query($con, $threadsQuery);

$subscribedQuery = "SELECT threads.id, threads.title 
                    FROM subscriptions 
                    INNER JOIN threads ON subscriptions.thread_id = threads.id 
                    WHERE subscriptions.user_id = $userId";
$subscribedResult = mysqli_query($con, $subscribedQuery);
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Your Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2>Your Threads</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($thread = mysqli_fetch_assoc($threadsResult)): ?>
                    <tr>
                        <td><a href="viewThread.php?thread_id=<?php echo $thread['id']; ?>"><?php echo htmlspecialchars($thread['title']); ?></a></td>
                        <td><a href="addThread.php?thread_id=<?php echo $thread['id']; ?>" class="btn btn-warning">Edit</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2>Subscribed Threads</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($subscribedThread = mysqli_fetch_assoc($subscribedResult)): ?>
                    <tr>
                        <td><a href="viewThread.php?thread_id=<?php echo $subscribedThread['id']; ?>"><?php echo htmlspecialchars($subscribedThread['title']); ?></a></td>
                        <td><a href="viewThread.php?thread_id=<?php echo $subscribedThread['id']; ?>" class="btn btn-info">View</a></td>
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