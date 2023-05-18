<?php
// Include config file
require_once "db_connection.php";

//Resume session
session_start();

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
        $_SESSION['errors'] .= $username_err . "<br>";
    } else {
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
        $_SESSION['errors'] .= $password_err . "<br>";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT userid, username, password FROM users WHERE username = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $username);
            
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {                    
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to dashboard
                            header("location: index.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                            $_SESSION['errors'] .= $password_err . "<br>";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $_SESSION['errors'] ="No account found with that username.";
                }
            } else {
                $_SESSION['errors'] = "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-euiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Message Board</title>
        <link rel="stylesheet" href="styles.css">
    </head>

        <header>
            <h2 class="logo">Message Board</h2>
            <nav class="navigation">
                <a href="index.php">Home</a>
                <a href="about.php">About</a>
            </nav>
        </header>

    <body>

        <div class="login-register">
            <h2>Login</h2>
            <form action="login.php" method="POST">
                <div class="input-box">
                    <span class="icon"><ion-icon name="person"></ion-icon></span>
                    <input type="text" name="username" required>
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <button type="submit" class="btn">Login</button>
                <div class="login-register">
                    <p>Don't have an account? <a href="register.php" class="register-link">Register</a></p>
                </div>
            </form>
        </div>

        <?php 
        echo $_SESSION['errors']; 
        $_SESSION['errors'] = "";
        ?>

        <script src="script.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>
</html>