<?php
    //Include db_orders.php
    include(dirname(__DIR__,1)."\db_connections\db_orders.php");                        

    //Get User Selections From $_POST[];
    $user_id = $_SESSION['userLogged_userid'];
    $name = $_SESSION['userLogged_name'];
    $surname = $_SESSION['userLogged_surname'];
    $email = $_SESSION['userLogged_email'];
    $title = $_POST['title'];
    $payment = $_POST['payment'];
    $delivery = $_POST['delivery'];

    //Send Info To db_orders.php
    if (order_book($user_id, $name, $surname, $email, $title, $payment, $delivery))
    {
        //IF Order Sucessful, Head Back To index.php
        header("location: ../../index.php");
    }
    else 
    {
        //Else Kill Process And Display Error
        echo '<script>alert("Error! Order failed!")</script>';
        die;
    }
?>