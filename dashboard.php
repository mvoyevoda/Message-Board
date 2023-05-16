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

    <!-- <br><br><br><br> -->
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
            echo "<h5>" . htmlspecialchars($row['username']) . "</h5>";
            echo "<p>".htmlspecialchars($row['body'])."</p>";
            //insert add comment form here
            if ($row['username'] === $_SESSION['username']){
                echo 
                    '<form action="delete_post.php" method="POST" style="display: inline;">
                    <input type="hidden" name="postid" value="' . $row['postid'] . '">
                    <button class="action-btn" type="submit" style="color: black;">Delete Post</button>
                    </form>';
            }
            echo 
                "<form class='input-box' action='new_comment.php' method='POST'>
                <input type='hidden' name='postid' value='" . $row['postid'] . "'>
                <input type='hidden' name='userid' value='" . $_SESSION['id'] . "'>
                <textarea name='body' placeholder='Add a comment...' required></textarea>
                <button class='btn' type='submit' style='color: black';>Add Comment</button>
                </form>";
            //display comments from comments table which have the same postid as $row[postid], each as a seperate card, as a column
            echo "<div class='comments'>";
    
            // Get and display comments
            if ($comments_sql = "SELECT * FROM comments WHERE postid = " . $row['postid'] . " ORDER BY created_at DESC"){
                $comments_result = $conn->query($comments_sql);
    
                if ($comments_result->num_rows > 0) {
                    while($comment = $comments_result->fetch_assoc()) {
                        echo "<div class='comment'>";
                        echo "<h5>" . htmlspecialchars($comment['username']) . "</h5>";
                        echo "<p>" . htmlspecialchars($comment['body']) . "</p>";
                        if ($comment['username'] === $_SESSION['username']){
                            echo 
                                '<form action="delete_comment.php" method="POST" style="display: inline;">
                                <input type="hidden" name="commentid" value="' . $comment['commentid'] . '">
                                <button class="btn" type="submit" style="color: black;"><ion-icon name="trash"></ion-icon>Delete Comment</button>
                                </form>'; 
                        }
                        echo "</div>";
                    }
                }
            }  
    
                echo "</div>";
            echo "</div>";
        
            
        }
    ?>

<!-- </body>
</html> -->

<?php 
// Close the connection
$conn->close();
?>