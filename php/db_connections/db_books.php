<?php
    session_start();
    //Get All Available Books
    function get_books()
    {
        try {  //Checks If Connection Is Established To DB, If Not, End Process

            //Data Base Handler (Connection To DB Using PDO)
            $dbh = new PDO('mysql:host=localhost; dbname=available_books', 'root', null);

            //Query Statement Using Paramameters (Binds The Validated User Inputs Before Sendimg Them To DB Server)
            $dbquery = "SELECT * FROM books";

            //Prepare Query String (Returns A Query Statement Object)
            $qstringobj = $dbh->prepare($dbquery);

            $result = null;
            //If Query Is Executed Sucessfuly
            if ($qstringobj->execute()) {
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
?>