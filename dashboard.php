<?php

// Include the database connection file
require_once "db_connection.php";

// Query to get the 5 most recent posts
$sql = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 5";
$result = $conn->query($sql);

if ($result === false) {
    // Handle error - inform administrator, log to a file, show an error screen, etc.
    echo "Error: " . $conn->error;
} 
function deletePost($postid, $conn){

    echo "entered function";

    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM posts WHERE postid = ?");

    // Bind the parameter
    $stmt->bind_param("i", $postid);

    if($stmt->execute()){
        echo "POST DELETED!";
    } else {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    // Execute the query
    // $stmt->execute();

    // Close the statement
    $stmt->close();

    // Close the connection
    // $conn->close();
}

?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body> -->
    <h3 class="welcome">Hi, <?php echo htmlspecialchars($_SESSION["username"]); ?>. Welcome to our site.</h3>

    <div class="wrapper">
        <div class="add-post-box">
            <h2>Add a Post</h2>
            <form action="new_post.php" method="POST">
                <div class="input-box">
                    <span class="icon"><ion-icon name="text"></ion-icon></span>
                    <input type="text" name="body" placeholder="Type your text here" required>
                </div>
            
                <button type="submit" class="btn">Post</button>
            </form>
        </div>
    </div>

    <?php 
        // Output data for each row
        while($row = $result->fetch_assoc()) {
            echo "<div class='post'>";
            // echo "<h2>".htmlspecialchars($row['title'])."</h2>";
            echo "<p>".htmlspecialchars($row['body'])."</p>";
            echo "<p>Posted by: ".htmlspecialchars($row['username'])." at ".htmlspecialchars($row['created_at'])."</p>";
            if ($row['username'] === $_SESSION['username']){
                echo 
                    '<form action="delete_post.php" method="POST" style="display: inline;">
                    <input type="hidden" name="postid" value="' . $row['postid'] . '">
                    <button class="delete-btn" type="submit" style="color: black;">Delete</button>
                    </form>';
            }
        
            echo "</div>";
        }
    ?>

<!-- </body>
</html> -->

<?php 
// Close the connection
$conn->close();
?>