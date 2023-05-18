<?php

// Include the database connection file
require_once "db_connection.php";

// Query to get the 5 most recent posts
$sql = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 5";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $conn->error;
} 
function deletePost($postid, $conn){

    // echo "entered function";

    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM posts WHERE postid = ?");

    // Bind the parameter
    $stmt->bind_param("i", $postid);

    if($stmt->execute()){
        echo "POST DELETED!";
    } else {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

?>

    <h3 class="welcome">Hi, <?php echo htmlspecialchars($_SESSION["username"]); ?>. Welcome to our site.</h3>

    <div class="post" class="add-post">
            <h2>Add a Post</h2>
            <form class="" action="new_post.php" method="POST">
                    <!-- <span class="icon"><ion-icon name="text"></ion-icon></span> -->
                    <textarea class="add-post-input" name="body" placeholder="Type your text here" required></textarea>
                <button type="submit" class="btn">Post</button>
            </form>
    </div>

    <?php 
        // Output data for each row
        while($row = $result->fetch_assoc()) {
            echo "<div class='post'>";
            echo "<h5>" . htmlspecialchars($row['username']) . "</h5>";
            echo "<p>".htmlspecialchars($row['body'])."</p>";
            if ($row['username'] === $_SESSION['username']){
                echo 
                    '<form action="delete_post.php" method="POST" style="display: inline;">
                    <input type="hidden" name="postid" value="' . $row['postid'] . '">
                    <button type="submit" style="color: black; width: 60px; font-size:10px;">Delete Post</button>
                    </form>';
            }
            echo 
                "<form class='input-box' action='new_comment.php' method='POST'>
                <input type='hidden' name='postid' value='" . $row['postid'] . "'>
                <input type='hidden' name='userid' value='" . $_SESSION['id'] . "'>
                <input type='text' name='body' placeholder='Add a comment...' required>
                <button class='btn' type='submit'>Add Comment</button>
                </form><br><br>";
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
                                '<br>
                                <form action="delete_comment.php" method="POST" style="display: inline;">
                                <input type="hidden" name="commentid" value="' . $comment['commentid'] . '">
                                <button style="color: black; width: 40px; font-size:10px;" type="submit">Delete</button>
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

<?php 
// Close the connection
$conn->close();
?>