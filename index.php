<?php
session_start();
$_SESSION['errors'] = "";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Message Board</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

        <header>
            <h2 class="logo">Message Board</h2>
            <nav class="navigation">
                <a href="index.php">Home</a>
                <a href="about.php">About</a>
                <a href="logout.php">Logout</a>
            </nav>
        </header>
<body>

    <?php if (isset($_SESSION['username'])): ?>
        <?php include 'dashboard.php'; ?>
    <?php else: ?>
        <?php header("location: login.php"); ?>
        
    <?php endif; ?>

</body>
</html>
<!--  -->