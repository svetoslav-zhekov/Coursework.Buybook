<?php
    session_start();

    //Destroy Login Session
    if(session_destroy())
    {
        header("location: login.php");
    }
?>