<?php

include('config/database.php');
require_once('config/database.php');
session_start();

    if(isset($_POST['button_pressed']))
    {  
            $username = $_POST['username'];
            $passwd = $_POST['passwd'];
            $message = '';
    try{ 
            $db = new PDO($dsn, $Uname, $password );
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //??
            
            $passwdCheck = $db->prepare("SELECT Password, verified FROM `users` WHERE Username = :Username");
            $passwdCheck->bindValue (':Username', $username);
            $passwdCheck->execute();
            $row1 = $passwdCheck->fetch(PDO::FETCH_ASSOC);
           
            if($passwdCheck->rowCount() == 0){
                $message = "User does not exist";
                include("login.php");
            }
            if($passwdCheck->rowCount() > 0){
                if($row1['verified'] == 0){
                    $message = "Please verify account!";
                    include("login.php");
                }       
            else{
            $stmt = $db->prepare("SELECT *
                                 FROM `users`
                                 WHERE Username = :Username
                                 AND verified = TRUE");
            $stmt->bindValue(':Username', $username);
            $stmt->execute();   
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($stmt->rowCount() > 0)
                {
                    if(password_verify($passwd, $row['Password']))
                    {
                      $_SESSION['user_id'] = $row['id'];
                      $_SESSION['username'] = $row['Username'];                      
                      header("Location: home.php");
                    }
                    else
                    {
                        $message = "Wrong Details!";
                        include("login.php");
                    } 
                }
            }
        }
    }
catch(PDOExeption $e)
    {
        echo "Could not login: " .$e;
    }
}
?>