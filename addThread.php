<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "forum");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $userId = $_SESSION['user_id'];

    if (isset($_POST['thread_id'])) {
        $threadId = $_POST['thread_id'];

        // Update existing thread
        $query = "UPDATE threads SET title = '$title' WHERE id = $threadId";
        mysqli_query($con, $query);
        
        // Redirect to the updated thread
        header("Location: viewThread.php?thread_id=" . $threadId);
        exit;
    } else {
        // Insert new thread
        $query = "INSERT INTO threads (title, user_id) VALUES ('$title', $userId)";
        mysqli_query($con, $query);
        
        // Get the ID of the newly created thread
        $newThreadId = mysqli_insert_id($con);
        
        // Redirect to the new thread
        header("Location: viewThread.php?thread_id=" . $newThreadId);
        exit;
    }
} else {
    $threadId = $_GET['thread_id'] ?? null;
    $title = '';

    if ($threadId) {
        $query = "SELECT title FROM threads WHERE id = $threadId";
        $result = mysqli_query($con, $query);
        if ($row = mysqli_fetch_assoc($result)) {
            $title = $row['title'];
        } else {
            header("Location: home.php");
            exit;
        }
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title><?php echo $threadId ? 'Edit Thread' : 'Create Thread'; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2><?php echo $threadId ? 'Edit Thread' : 'Create New Thread'; ?></h2>
        <form action="addThread.php" method="POST">
            <div class="form-group">
                <label for="title">Thread Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
            </div>
            <?php if ($threadId): ?>
                <input type="hidden" name="thread_id" value="<?php echo $threadId; ?>">
            <?php endif; ?>
            <button type="submit" class="btn btn-primary"><?php echo $threadId ? 'Update Thread' : 'Create Thread'; ?></button>
        </form>
    </div>
</body>
</html>

<?php
mysqli_close($con);
?>