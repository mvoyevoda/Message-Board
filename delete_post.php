<?php
// Include the database connection file
require_once "db_connection.php";

// Check if the postid parameter is provided
if (isset($_POST["postid"])) {
    $postid = $_POST["postid"];

    //First delete all comments from post

    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM comments WHERE postid = ?");

    // Bind the parameter
    $stmt->bind_param("i", $postid);

    // Execute the query
    if ($stmt->execute()) {
        echo "Comments deleted successfully!";
    } else {
        echo "Failed to delete comments. Please try again.";
    }

    // Close the statement
    $stmt->close();    

    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM posts WHERE postid = ?");

    // Bind the parameter
    $stmt->bind_param("i", $postid);

    // Execute the query
    if ($stmt->execute()) {
        echo "Post deleted successfully!";
    } else {
        echo "Failed to delete the post. Please try again later.";
    }

    // Close the statement
    $stmt->close();

    // Redirect back to the previous page
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit();
} else {
    echo "Post ID not provided.";
}
?>
