<?php
    //PHP Section
    error_reporting(0); // Dont Show Any Erros Or Warnings To User
    include("db_connections/db_users.php");
    
    //Send Login And Verify Login Info
    session_start();

    //If Login Button Was Clicked And Both Fields Are Not Null
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['username']) && isset($_POST['password']))
    {
        $username = $_POST['username']; //Username From Form
        $password = $_POST['password']; //Password From Form
        
        $exists = verity_login($username, $password); //Returns BOOL
        
        // If Login Exists, Send The Username And Go To Index Page
        if ($exists)
        {
            header("location: ../index.php");
        }
        else
        {
            echo '<script>alert("Error! Check username and password!")</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Login To Buybook</title>
</head>
<body>  
    <!-- Content Holder Div -->
    <div id="content">
        <h1>Login</h1><br/>

        <!-- Login Form -->
        <div id="login-form">
            <form action="" method="post">
                <label>Username</label><br><input type="text" name="username"/><br><br>
                <label>Password</label><br><input type="password" name="password"/><br><br>
                <input type="submit" value="Login"/><br>
            </form>
        </div><br>

        <label> Still no account? Click <a href="signup.php">here</a><br> to signup :)!</label>
    </div>
</body>
</html>