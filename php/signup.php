<?php
    //PHP Section
    error_reporting(0); // Dont Show Any Erros Or Warnings To User
    include("db_connections/db_users.php");

    //Send Login And Verify Login Info
    session_start();

    //Signup Credentials Validation
    function username_valid($username)
    {
        //Check If Username Has Invalid Characters
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $username)) {
            echo '<script>alert("Error! Invalid characters in username, it can only contain, numbers, letters and underscore!")</script>';
            return false;
        } else {
            //Check If Username Alreadu Exists
            if (username_exists($username)) {
                echo '<script>alert("Error! Username already exists!")</script>';
                return false;
            } else {
                return true;
            }
        }
    }

    //If Signup Button Was Clicked
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $username = $_POST['username']; //Username From Form
        $name = $_POST['name']; //Name From Form
        $surname = $_POST['surname']; //Surname From Form
        $password = $_POST['password']; //Password From Form
        $email = $_POST['email']; //Email From Form

        //If Any Of The Fields Is Empty
        if (empty($username) || empty($password) || empty($email) || empty($name) || empty($surname)) {
            echo '<script>alert("Error! One of the fields is empty! Make sure to input all of the required fields!")</script>';
        } else {
            if (username_valid($username)) {
                //Sign Up User And Continue To Login
                if (signup_user($username, $name, $surname, $password, $email)) {
                    header("location: login.php");
                    echo '<script>alert("Signup completed!")</script>';
                } else {
                    echo '<script>alert("Error! Signup failed!")</script>';
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/signup.css">
    <title>Signup For Free</title>
</head>

<body>
    <!-- Content Holder Div -->
    <div id="content">
        <h1>Signup</h1><br />

        <!-- Signup Form -->
        <div id="signup-form">
            <form action="" method="post">
                <label>Username</label><br><input type="text" name="username" /><br><br>
                <label>Name</label><br><input type="text" name="name" /><br><br>
                <label>Surname</label><br><input type="text" name="surname" /><br><br>
                <label>Password</label><br><input type="password" name="password" /><br><br>
                <label>Email</label><br><input type="email" name="email" /><br><br>
                <input type="submit" value="Signup" /><br>
            </form>
        </div><br>

        <label>Already have an account? Click <a href="login.php">here</a><br> to login :)!</label>
    </div>
</body>
</html>