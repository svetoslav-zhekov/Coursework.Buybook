<?php
    session_start();

    //Check If Login Info Exists In DB Users (With SQL Injections Prevention Using PDO)
    function verity_login($username, $password)
    {
        //Check If Both Fields Are Strings
        if (is_string($username) && is_string($password)) 
        {
            try {  //Checks If Connection Is Established To DB, If Not, End Process
                
                //Data Base Handler (Connection To DB Using PDO)
                $dbh = new PDO('mysql:host=localhost; dbname=user_clients', 'root', null);
            
                //Query Statement Using Paramameters (Binds The Validated User Inputs Before Sendimg Them To DB Server)
                $dbquery = "SELECT user_id, username, name, surname, email FROM users WHERE username = :username AND password = :password";

                //Prepare Query String (Returns A Query Statement Object)
                $qstringobj = $dbh->prepare($dbquery);

                //Bind The Parameters
                $qstringobj->bindParam(':username', $username);
                $qstringobj->bindParam(':password', $password);

                //If Query Is Executed Sucessfuly Continue
                if ($qstringobj->execute())
                {
                    //Set To Use Fetch Assoc
                    $qstringobj->setFetchMode(PDO::FETCH_ASSOC);

                    //Get Result From Query
                    $result = $qstringobj->fetchAll();

                    //Get Row Count (Needs To Equal 1 Result)
                    $resultscount = $qstringobj->rowCount();

                    //Close DB Connection
                    $dbh = null;
                    
                    //If Result Is Not Empty
                    if ($resultscount == 1)
                    {
                        //Global Session Params (Used In Other PHP Operations)
                        $_SESSION['userLogged_userid'] = $result[0]['user_id'];
                        $_SESSION['userLogged_username'] = $result[0]['username'];
                        $_SESSION['userLogged_name'] = $result[0]['name'];
                        $_SESSION['userLogged_surname'] = $result[0]['surname'];
                        $_SESSION['userLogged_email'] = $result[0]['email'];
                        return true; 
                    }
                    else
                    {
                        return false;
                    }
                }
                else 
                {
                    return false;
                }
                
            }
            catch (PDOException $e) {
                die($e);
            }
        }
        else
        {
            //If The Inputs Are Not Strings
            http_response_code(400);
            die('Error processing! Bad or malformed request!');
        }
    }

    //Enter New User In DB
    function generate_userid()
    {
        return random_int(1, 100000000);
    }

    function signup_user($username, $name, $surname, $password, $email)
    {
       //Get Generated User_id
       $user_id = generate_userid();

       //Check If Fields Are LongInt/Strings
       if (is_long($user_id) && is_string($username) && is_string($name) && is_string($surname) && is_string($password) && is_string($email)) 
       {
           try {  //Checks If Connection Is Established To DB, If Not, End Process

                //Data Base Handler (Connection To DB Using PDO)
                $dbh = new PDO('mysql:host=localhost; dbname=user_clients', 'root', null);
               
                //Query Statement Using Paramameters (Binds The Validated User Inputs Before Sendimg Them To DB Server)
                $dbquery = "INSERT INTO users (user_id, username, name, surname, password, email) 
                            VALUES (:user_id, :username, :name, :surname, :password, :email)"; 

                //Prepare Query String (Returns A Query Statement Object)
                $qstringobj = $dbh->prepare($dbquery);

                //Bind The Parameters
                $qstringobj->bindParam(':user_id', $user_id);
                $qstringobj->bindParam(':username', $username);
                $qstringobj->bindParam(':name', $name);
                $qstringobj->bindParam(':surname', $surname);
                $qstringobj->bindParam(':password', $password);
                $qstringobj->bindParam(':email', $email);

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

    //Check If Username Exists In DB
    function username_exists($username) 
    {
        //Check If String
        if (is_string($username)) 
        {
            try {  //Checks If Connection Is Established To DB, If Not, End Process
                
                //Data Base Handler (Connection To DB Using PDO)
                $dbh = new PDO('mysql:host=localhost; dbname=user_clients', 'root', null);
            
                //Query Statement Using Paramameters (Binds The Validated User Inputs Before Sendimg Them To DB Server)
                $dbquery = "SELECT username FROM users WHERE username = :username";

                //Prepare Query String (Returns A Query Statement Object)
                $qstringobj = $dbh->prepare($dbquery);

                //Bind The Parameters
                $qstringobj->bindParam(':username', $username);

                //If Query Is Executed Sucessfuly Continue
                if ($qstringobj->execute())
                {
                    //Get Row Count (Needs To Equal 1 Result)
                    $resultscount = $qstringobj->rowCount();

                    //Close DB Connection
                    $dbh = null;
                    
                    //If Result Is Not Empty, Username Exists In DB
                    if ($resultscount == 1)
                    {
                        return true; 
                    }
                    else
                    {
                        return false;
                    }
                }
                else 
                {
                    return false;
                } 
            }
            catch (PDOException $e) {
                die($e);
            }
        }
        else
        {
            //If The Inputs Are Not Strings
            http_response_code(400);
            die('Error processing! Bad or malformed request!');
        }
    }
