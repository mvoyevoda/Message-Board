<?php

// Include the database connection file
require_once "db_connection.php";

// Get the post ID from the URL
$postid = $_GET['postid'];

// Check if the user is logged in
if (empty($_SESSION['username'])) {
    // Redirect the user to the login page
    header("Location: login.php");
    exit;
}

// Get the likes and dislikes for the post
$sql = "SELECT likes, dislikes FROM posts WHERE postid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $postid);
$stmt->execute();
$stmt->bind_result($likes, $dislikes);
$stmt->fetch();
$stmt->close();

// Get the user's likes and dislikes for the post
$sql = "SELECT likes, dislikes FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$stmt->bind_result($user_likes, $user_dislikes);
$stmt->fetch();
$stmt->close();

// Create the like and dislike buttons
$like_button = '<button class="btn like" data-postid="' . $postid . '">Like</button>';
$dislike_button = '<button class="btn dislike" data-postid="' . $postid . '">Dislike</button>';

// Check if the user has already liked or disliked the post
if ($user_likes == 1) {
    $like_button = '<button class="btn liked" data-postid="' . $postid . '">Liked</button>';
} else if ($user_dislikes == 1) {
    $dislike_button = '<button class="btn disliked" data-postid="' . $postid . '">Disliked</button>';
}

// Display the like and dislike buttons
echo '<div class="like-dislike">';
echo $like_button . ' ' . $dislike_button;
echo '</div>';

// Update the likes and dislikes in the database
if (isset($_POST['like'])) {
    $sql = "UPDATE posts SET likes = likes + 1 WHERE postid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $postid);
    $stmt->execute();
    $stmt->close();
} else if (isset($_POST['dislike'])) {
    $sql = "UPDATE posts SET dislikes = dislikes + 1 WHERE postid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $postid);
    $stmt->execute();
    $stmt->close();
}

// Close the connection
$conn->close();

?>