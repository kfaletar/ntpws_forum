<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h2 class="text-center">Login</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
                Invalid username or password.
            </div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        <p class="text-center mt-3">Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>