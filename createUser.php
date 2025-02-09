<?php
session_start();
$username = $_POST['username'] ?? '';
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = 1;

$con = mysqli_connect("localhost", "root", "", "forum");
$query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', $role)";
mysqli_query($con, $query);
mysqli_close($con);

header("Location: index.php");
exit;
?>