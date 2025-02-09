<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg" style="background-color: #6c757d;"> 
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white" href="home.php">Home</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 2): ?>
                <li class="nav-item">
                    <a class="nav-link text-white" href="adminDashboard.php">Admin Dashboard</a>
                </li>
            <?php endif; ?> <!-- Correctly closing the if statement -->
            <?php if (isset($_SESSION['username'])): ?>
                <li class="nav-item">
                    <a class="nav-link text-white" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="logout.php">Logout</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>