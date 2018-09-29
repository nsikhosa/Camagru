<?php
    require_once ("./config/database.php");
    try{
        $verified = TRUE;

        $db = new PDO($dsn, $Uname, $password );
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //still need to understand this.
        $stmt = $db->prepare("UPDATE `users` SET verified = :verified WHERE Code LIKE :Code");
        $stmt->bindValue(':verified', $verified);
        $stmt->bindValue(':Code', $_GET['id']);
        $stmt->execute();
    }catch(PDOException $e){
        echo "Connection Failed: " . $e->message();
    }
    include("login.php");
?>

