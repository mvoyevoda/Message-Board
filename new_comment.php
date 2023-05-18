<?php
// Start the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["username"])){
    header("location: login.php");
    exit;
}

// Include the database connection file
require_once "db_connection.php";

// Define variables and initialize with empty values
$body = "";
$body_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate body
    $input_body = trim($_POST["body"]);
    if(empty($input_body)){
        $body_err = "Please enter a comment.";     
    } else{
        $body = $input_body;
    }
    
    // Check input errors before inserting in database
    if(empty($body_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO comments (body, userid, username, postid) VALUES (?, ?, ?, ?)";
        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sisi", $body, $_SESSION["id"], $_SESSION["username"], $_POST["postid"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Comment created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $conn->close();
}
?>
<!--  -->