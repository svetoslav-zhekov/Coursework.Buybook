<?php
    //Include db_orders.php
    include(dirname(__DIR__,1)."\db_connections\db_orders.php");                        

    //Get User Selections From $_POST[];
    $order_id = $_POST['order_id'] ;

    //SetType
    settype($order_id, "int");
    
    //Send Info To db_orders.php
    if (order_remove($order_id))
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