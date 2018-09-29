<?php

require_once ("./config/database.php");
$message = '';
try
{
    $db = new PDO($dsn, $Uname, $password );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //??
    $email = $_POST['email'];
    $username = $_POST['username'];
    $passwd = $_POST['passwd'];
    $hashed_passwd = password_hash($passwd, PASSWORD_BCRYPT);
    $verified = FALSE;
    $code = substr(md5(mt_rand()),0,15);
   
    $emailCheck = $db->prepare("SELECT EmailAddress FROM `users` WHERE EmailAddress = :EmailAddress");
    $emailCheck->bindValue (':EmailAddress', $email);
    $emailCheck->execute();

    if($emailCheck->rowCount() > 0)
        { 
            $message = "Email address already exists";
            include("register.php");
            $emailCheck = null;
        }

    if ($emailCheck != null)
        {
            $unameCheck = $db->prepare("SELECT Username FROM `users` WHERE Username = :Username");
            $unameCheck->bindValue (':Username', $username);
            $unameCheck->execute();

        if($unameCheck->rowCount() > 0)
            { 
                $message = "Username already exists";
                include("register.php");
                $unameCheck = null;
            }
        }
    if ($emailCheck != null && $unameCheck != null)
        {
            $emailCheck = null;
            $unameCheck = null;

            $stmt = $db->prepare ("INSERT INTO `users` (EmailAddress, Username, Password, verified, Code)
                    VALUES (:EmailAddress, :Username, :Password, :verified, :Code)");

            $stmt->bindValue (':EmailAddress', $email);
            $stmt->bindValue (':Username', $username);
            $stmt->bindValue (':Password', $hashed_passwd);
            $stmt->bindValue (':verified', $verified);
            $stmt->bindValue (':Code',$code);
    
            $stmt->execute();
            header('Location: regMsgBox.php');

            $to      = $email;
            $subject = 'Verification Email';
            $message = "Your Activation Code is ".$code.". Please click on the link below to activate your account.\nhttp://localhost:8080/practice/ex00/verify.php?id=".$code;
            $headers = 'From: noreply@camagru.com' . "\n" .
            'Reply-To: no-one@camagru.com' . "\n" .
            'X-Mailer: PHP/';
            mail($to, $subject, $message, $headers);
        }
}
catch(Exeption $e)
{
    echo "Could not bind: " .$e;
}
?>