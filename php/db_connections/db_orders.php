<?php
    session_start();
    //Get All Orders Of User
    function get_orders($user_id)
    {
        //Check If LongInt
       if (is_long($user_id)) 
       {
           try {  //Checks If Connection Is Established To DB, If Not, End Process

                //Data Base Handler (Connection To DB Using PDO)
                $dbh = new PDO('mysql:host=localhost; dbname=user_orders', 'root', null);
               
                //Query Statement Using Paramameters (Binds The Validated User Inputs Before Sendimg Them To DB Server)
                $dbquery = "SELECT * FROM orders WHERE user_id = :user_id"; 

                //Prepare Query String (Returns A Query Statement Object)
                $qstringobj = $dbh->prepare($dbquery);

                //Bind The Parameters
                $qstringobj->bindParam(':user_id', $user_id);

                $result = null;
                //If Query Is Executed Sucessfuly
                if ($qstringobj->execute())
                { 
                   $result = $qstringobj->fetchAll();    
                }
                
                //Close DB Connection
                $dbh = null;

                //Return Results
                return $result;
            }
            catch (PDOException $e) {
                die($e);
            }
       }
       else
       {
           //If The Inputs Are Not The Requier Var Type
           http_response_code(400);
           die('Error processing! Bad or malformed request!');
       }
    }

    //Order A Book
    function order_book($user_id, $name, $surname, $email, $bookname, $payment, $delivery)
    {
        //Check If Fields Are LongInt/Strings
       if (is_long($user_id) && is_string($name) && is_string($surname) && 
            is_string($email) && is_string($bookname) && is_string($payment) && is_string($delivery)) 
       {
           try {  //Checks If Connection Is Established To DB, If Not, End Process

                //Data Base Handler (Connection To DB Using PDO)
                $dbh = new PDO('mysql:host=localhost; dbname=user_orders', 'root', null);
               
                //Query Statement Using Paramameters (Binds The Validated User Inputs Before Sendimg Them To DB Server)
                $dbquery = "INSERT INTO orders (user_id, name, surname, email, bookname, payment, delivery) 
                            VALUES (:user_id, :name, :surname, :email, :bookname, :payment, :delivery)"; 

                //Prepare Query String (Returns A Query Statement Object)
                $qstringobj = $dbh->prepare($dbquery);

                //Bind The Parameters
                $qstringobj->bindParam(':user_id', $user_id);
                $qstringobj->bindParam(':name', $name);
                $qstringobj->bindParam(':surname', $surname);
                $qstringobj->bindParam(':email', $email);
                $qstringobj->bindParam(':bookname', $bookname);
                $qstringobj->bindParam(':payment', $payment);
                $qstringobj->bindParam(':delivery', $delivery);

                //If Query Is Execute Sucessfuly Return True
                if ($qstringobj->execute())
                {
                   //Close DB Connection
                   $dbh = null; 
                   return true;     
                }
                else 
                {
                    //Close DB Connection
                    $dbh = null;
                    return false;
                }  
            }
            catch (PDOException $e) {
                die($e);
            }
       }
       else
       {
           //If The Inputs Are Not The Requier Var Type
           http_response_code(400);
           die('Error processing! Bad or malformed request!');
       }
    }

    //Modify Order
    function order_modify($order_id, $value, $column)
    {
        //Check If Fields Are LongInt/Strings
       if (is_long($order_id) && is_string($value) && is_string($column)) 
       {
           try {  //Checks If Connection Is Established To DB, If Not, End Process

                //Data Base Handler (Connection To DB Using PDO)
                $dbh = new PDO('mysql:host=localhost; dbname=user_orders', 'root', null);

                $dbquery = null; 
                //Set Query Statement Depending On Column Name
                switch($column) 
                {
                    case "bookname":
                        $dbquery = "UPDATE orders SET bookname = :changed_value WHERE id = :order_id"; 
                        break;
                    case "payment":
                        $dbquery = "UPDATE orders SET payment = :changed_value WHERE id = :order_id";
                        break;
                    case "delivery":
                        $dbquery = "UPDATE orders SET delivery = :changed_value WHERE id = :order_id";  
                        break;
                }               

                //Prepare Query String (Returns A Query Statement Object)
                $qstringobj = $dbh->prepare($dbquery);

                //Bind The Parameters
                $qstringobj->bindParam(':order_id', $order_id);
                $qstringobj->bindParam(':changed_value', $value);

                //If Query Is Execute Sucessfuly Return True
                if ($qstringobj->execute())
                {
                   //Close DB Connection
                   $dbh = null; 
                   return true;
                }
                else 
                {
                    //Close DB Connection
                    $dbh = null;
                    return false;
                }  
            }
            catch (PDOException $e) {
                die($e);
            }
       }
       else
       {
           //If The Inputs Are Not The Requier Var Type
           http_response_code(400);
           die('Error processing! Bad or malformed request!');
       }        
    }

    //Remove Order
    function order_remove($order_id)
    {
       //Check If Fields Are LongInt/Strings
       if (is_long($order_id)) 
       {
           try {  //Checks If Connection Is Established To DB, If Not, End Process

                //Data Base Handler (Connection To DB Using PDO)
                $dbh = new PDO('mysql:host=localhost; dbname=user_orders', 'root', null);
               
                //Query Statement Using Paramameters (Binds The Validated User Inputs Before Sendimg Them To DB Server)
                $dbquery = "DELETE FROM orders WHERE id = :order_id"; 

                //Prepare Query String (Returns A Query Statement Object)
                $qstringobj = $dbh->prepare($dbquery);

                //Bind The Parameters
                $qstringobj->bindParam(':order_id', $order_id);
            
                //If Query Is Execute Sucessfuly Return True
                if ($qstringobj->execute())
                {
                   //Close DB Connection
                   $dbh = null; 
                   return true;     
                }
                else 
                {
                    //Close DB Connection
                    $dbh = null;
                    return false;
                }  
            }
            catch (PDOException $e) {
                die($e);
            }
       }
       else
       {
           //If The Inputs Are Not The Requier Var Type
           http_response_code(400);
           die('Error processing! Bad or malformed request!');
       }        
    }
?>