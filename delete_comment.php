<?php
// Include the database connection file
require_once "db_connection.php";

// Check if the commentid parameter is provided
if (isset($_POST["commentid"])) {
    $commentid = $_POST["commentid"];

    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM comments WHERE commentid = ?");

    // Bind the parameter
    $stmt->bind_param("i", $commentid);

    // Execute the query
    if ($stmt->execute()) {
        echo "Comment deleted successfully!";
    } else {
        echo "Failed to delete the comment. Please try again later.";
    }

    // Close the statement
    $stmt->close();

    // Redirect back to the previous page
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit();
} else {
    echo "Comment ID not provided.";
}
?>