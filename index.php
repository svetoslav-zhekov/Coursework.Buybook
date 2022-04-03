<?php
    //PHP Section
    error_reporting(0); // Dont Show Any Erros Or Warnings To User
    include("php/db_connections/db_users.php");

    //Check If User Is Logged In, Otherwise Redirect To Login Page (Getting Session Var).
    session_start();

    if (empty($_SESSION['userLogged_userid'])) {
        header("location: php/login.php");
        die;
    } else {
        $user_id = $_SESSION['userLogged_userid'];
        $username = $_SESSION['userLogged_username'];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Welcome!</title>
</head>

<body>
    <!-- Left Side Menu -->
    <div id="menu">
        <!-- Logo Header -->
        <h1>Buybook</h1>
        <hr>

        <!-- Buttons To Switch Tabs -->
        <button id="menu-home" class="menu-buttons">Home</button>
        <hr>
        <button id="menu-orders" class="menu-buttons">My Orders</button>
        <hr>
        <button id="menu-books" class="menu-buttons">Available Books</button>
        <hr><br>

        <!-- Logout -->
        <form action="php/logout.php">
            <input id="logout-button" type="submit" value="Logout" />
        </form>
    </div>

    <!-- Content To Appear On Home Button Click -->
    <div id="home-content">
        <h2 class="content-headers" id="home-header">Welcome! User: <?php echo $username; ?></h2>
    </div>

    <!-- Content To Appear On My Orders Button Click -->
    <div id="orders-content" style="display: none;">
        <h2 class="content-headers" id="orders-header">Your Orders!</h2>
        <hr>
        <div class="info-tables-divs">
            <table class="info-tables" id="orders-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Bookname</th>
                        <th>Payment</th>
                        <th>Delivery</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //Display User Orders
                        //Include
                        include("php/db_connections/db_orders.php");

                        //Get Orders
                        $orders = get_orders($user_id);

                        foreach ($orders as $order) //Go Through Every Row/Order In DB (From Result Query)
                        {
                            echo "<tr>";
                            echo "<td>" . $order['id'] . "</td>";
                            echo "<td>" . $order['name'] . "</td>";
                            echo "<td>" . $order['surname'] . "</td>";
                            echo "<td>" . $order['email'] . "</td>";
                            echo "<td>" . $order['bookname'] . "</td>";
                            echo "<td>" . $order['payment'] . "</td>";
                            echo "<td>" . $order['delivery'] . "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <hr><br>
        <button class="user-operations" id="orders-cancel">Cancel Order</button>
        <button class="user-operations" id="orders-change">Change Order</button>
    </div>

    <!-- Content To Appear On Available Books Button Click -->
    <div id="books-content" style="display: none;">
        <h2 class="content-headers" id="books-header">Available Books For Purchase!</h2>
        <hr>
        <div class="info-tables-divs">
            <table class="info-tables" id="books-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Price</th>
                        <th>Publisher</th>
                        <th>Year Of Publish</th>
                        <th>Book Cover</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //Display Available Books In Table
                        //Include
                        include("php/db_connections/db_books.php");

                        //Get Books
                        $books = get_books();

                        foreach ($books as $book) //Go Through Every Row/Book In DB (From Result Query)
                        {
                            echo "<tr>";
                            echo "<td>" . $book['title'] . "</td>";
                            echo "<td>" . $book['author'] . "</td>";
                            echo "<td>" . $book['price'] . "</td>";
                            echo "<td>" . $book['publisher'] . "</td>";
                            echo "<td>" . $book['year_of_publish'] . "</td>";
                            echo "<td>" . $book['book_cover'] . "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <hr><br>
        <button class="user-operations" id="books-order">Order A Book</button>
    </div>

    <!-- User Operations Divs -->
    <!-- User Operation Delete -->
    <div class="user-operations-divs" id="orders-operations-delete">
        <h2 class="uo-headers" id="uo-delete-header">Cancel Order</h2>
        <hr>
        <form action="php/user_order_operations/cancel.php" method="post">
            <label class="uo-labels">Order ID: </label><select name="order_id">
                <?php
                    //include("php/db_connections/db_orders.php"); //Already Included In Above Code                           

                    //Get Orders
                    $orders = get_orders($user_id);

                    foreach ($orders as $order) //Go Through Every Row/Order In DB (From Result Query)
                    {
                        echo "<option>" . $order['id'] . "</option>";
                    }
                ?>
            </select>
            <hr><br>

            <input class="uo-inputs" type="submit" value="Proceed" />
        </form><br>
        <button class="user-operations-close" id="orders-cancel-close">Close</button>
    </div>
    
    <!-- User Operation Change -->
    <div class="user-operations-divs" id="orders-operations-change">
        <h2 class="uo-headers" id="uo-change-header">Change Order</h2>
        <hr>

        <form action="php/user_order_operations/modify.php" method="post">
                <label class="uo-labels">Order ID: </label><select name="order_id">
                    <?php
                        //include("php/db_connections/db_orders.php"); //Already Included In Above Code 

                        //Get Orders
                        $orders = get_orders($user_id);

                        foreach ($orders as $order) //Go Through Every Row/Order In DB (From Result Query)
                        {
                            echo "<option>" . $order['id'] . "</option>";
                        }
                    ?>
                </select><hr>
                <label class="uo-labels">Select what to change: </label><select id="change_selector" name="change_sel">
                    <option>Change Book</option>
                    <option>Change Payment</option>
                    <option>Change Delivery</option>
                </select><hr>
                <!-- Options Which Will Appear Depending On Selector -->
                <div id="uo-change-book">
                    <label class="uo-labels">Choose Book: </label><select name="title">
                        <?php
                            //Display Available Books In Table
                            //include("php/db_connections/db_books.php");  //Already Included In Above Code              

                            //Get Books
                            $books = get_books();

                            foreach ($books as $book) //Go Through Every Row/Book In DB (From Result Query)
                            {
                                echo "<option>" . $book['title'] . "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div id="uo-change-payment" style="display: none;">
                    <label class="uo-labels">Payment: </label><select name="payment">
                        <option>Mastercard</option>
                        <option>Paypal</option>
                        <option>Cash</option>
                    </select>
                </div>
                <div id="uo-change-delivery" style="display: none;">
                    <label class="uo-labels">Delivery: </label><select name="delivery">
                        <option>Fast Delivery</option>
                        <option>Normal Delivery</option>
                    </select>
                </div><hr><br>

                <input class="uo-inputs" type="submit" value="Proceed" />
        </form><br>
        <button class="user-operations-close" id="orders-change-close">Close</button>
    </div>

    <!-- User Operation Order -->
    <div class="user-operations-divs" id="books-operations-order">
        <h2 class="uo-headers" id="uo-order-header">Order A Book</h2>
        <hr>
        
        <form action="php/user_order_operations/order.php" method="post">
                <label class="uo-labels">Choose Book: </label><select name="title">
                    <?php
                        //include("php/db_connections/db_books.php"); //Already Included In Above Code   

                        //Get Books
                        $books = get_books();

                        foreach ($books as $book) //Go Through Every Row/Book In DB (From Result Query)
                        {
                            echo "<option>" . $book['title'] . "</option>";
                        }
                    ?>
                </select><hr>
                <label class="uo-labels">Payment: </label><select name="payment">
                    <option>Mastercard</option>
                    <option>Paypal</option>
                    <option>Cash</option>
                </select><hr>
                <label class="uo-labels">Delivery: </label><select name="delivery">
                    <option>Fast Delivery</option>
                    <option>Normal Delivery</option>
                </select><hr><br>

                <input class="uo-inputs" type="submit" value="Proceed"/>
        </form><br>
        <button class="user-operations-close" id="books-order-close">Close</button>
    </div>

    <!-- Java Script Include -->
    <script src="javascript/index.js"></script>
</body>

</html>