<?php
// Initialize the session
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

    // Validate title
    // $input_title = trim($_POST["title"]);
    // echo "body: " . $input_title;
    // if (empty($input_title)){
    //     $title_err = "Please enter a title.";
    // } else { 
    //     $title = $input_title;
    // }
    
    // Validate body
    $input_body = trim($_POST["body"]);
    // echo "<br>";
    // echo "body: " . $input_body;
    if(empty($input_body)){
        $body_err = "Please enter text...";  
        echo $body_err;   
    } else{
        $body = $input_body;
    }

    // echo "<br>";
    // echo $body_err;
    // echo "<br>";
    // echo $title_err;
    
    // Check input errors before inserting in database
    if(empty($body_err)){
        // echo "test...........";
        // Prepare an insert statement
        $sql = "INSERT INTO posts (body, userid, username) VALUES (?, ?, ?)";
         
        // $stmt = $conn->prepare($sql);

        // if($stmt === false) {
        //     trigger error($conn->error, E_USER_ERROR);
        //     return;
        // }

        // if (!($stmt = $conn->prepare($sql)))
        // echo "Error: " . $conn->error;
        
        if($stmt = $conn->prepare($sql)){
            // echo "testing";
            // Bind variables to the prepared statement as parameters

            if (!($stmt = $conn->prepare($sql))){
                echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
                // echo "PREP SUCESSFUL";
            }
            

            $stmt->bind_param("sis", $body, $_SESSION["id"], $_SESSION["username"]);

            // echo "entered <br>";
            
            // Attempt to execute the prepared statement

            // if(!$stmt->execute()){
            //     echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            // }
            
            
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