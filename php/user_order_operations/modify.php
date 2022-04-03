<?php
    //Include db_orders.php
    include(dirname(__DIR__, 1) . "\db_connections\db_orders.php");

    //Get User Selections From $_POST[];
    $order_id = $_POST['order_id'];
    $change_selector = $_POST['change_sel'];

    $value = null;
    $column = null;

    //Chose And Send Selected Only
    switch ($change_selector) {
        case "Change Book":
            $value = $_POST['title'];
            $column = "bookname";
            break;
        case "Change Payment":
            $value = $_POST['payment'];
            $column = "payment";
            break;
        case "Change Delivery":
            $value = $_POST['delivery'];
            $column = "delivery";
            break;
        default:
            die;
            break;
    }

    //SetType
    settype($order_id, "int");

    //Send Info To db_orders.php
    if (order_modify($order_id, $value, $column)) 
    {
        //IF Order Cancel Was Sucessful, Head Back To index.php
        header("location: ../../index.php");
    } 
    else 
    {
        //Else Kill Process And Display Error
        echo '<script>alert("Error! Canceling the order failed!")</script>';
        die;
    }
?>
