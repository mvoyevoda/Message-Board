<?php
//Resume the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["username"])){
    header("location: login.php");
    exit;
}

// Include db connection file
require_once "db_connection.php";

// Define variables and initialize with empty values
$title = $body = "";
$title_err; $body_err;

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validate body
    $input_body = trim($_POST["body"]);

    if(empty($input_body)){
        $body_err = "Please enter text...";  
        echo $body_err;   
    } else{
        $body = $input_body;
    }
    
    // Check input errors before inserting in database
    if(empty($body_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO posts (body, userid, username) VALUES (?, ?, ?)";

        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            if (!($stmt = $conn->prepare($sql))){
                echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            }
            
            //Bind parameters
            $stmt->bind_param("sis", $body, $_SESSION["id"], $_SESSION["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
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