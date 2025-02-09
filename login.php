// login.php
<?php
session_start();
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$con = mysqli_connect("localhost", "root", "", "forum");
$query = "SELECT id, username, password, role FROM users WHERE username = '$username'";
$result = mysqli_query($con, $query);
$foundUser  = mysqli_fetch_row($result);

if ($foundUser  && password_verify($password, $foundUser [2])) { 
    $_SESSION['username'] = $foundUser [1];
    $_SESSION['user_id'] = $foundUser [0]; 
    $_SESSION['role'] = $foundUser [3];
    setcookie("username", $username, time() + (86400 * 30), "/"); 
    header("Location: home.php");
    exit;
} else {
    header("Location: index.php?error=1");
    exit;
}
?>