<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Message Board</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

        <header>
            <h2 class="logo">Message Board</h2>
            <nav class="navigation">
                <a href="index.php">Home</a>
                <a href="about.php">About</a>
                <a href="logout.php">Logout</a>
            </nav>
        </header>

    <?php if (isset($_SESSION['username'])): ?>
        <?php include 'dashboard.php'; ?>
    <?php else: ?>
        <?php header("location: login.php"); ?>
        
    <?php endif; ?>

</body>
</html>
