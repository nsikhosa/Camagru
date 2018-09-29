<?php
require_once("database.php");
try {
//Creating users table
    $stmt = new PDO($server, $Uname, $password);
    $stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt->query("CREATE DATABASE IF NOT EXISTS $db_name");
    $stmt->query("USE $db_name");
    $stmt->query("CREATE TABLE IF NOT EXISTS `users`(
        id int(11) NOT NULL AUTO_INCREMENT,
        Username VARCHAR(30) NOT NULL UNIQUE,
        EmailAddress VARCHAR(50) NOT NULL UNIQUE,
        Password VARCHAR(250) NOT NULL,
        verified BOOLEAN NOT NULL,
        Code text NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1");

//Creating uploads table
    $stmt->query("CREATE DATABASE IF NOT EXISTS $db_name");
    $stmt->query("USE $db_name");
    $stmt->query("CREATE TABLE IF NOT EXISTS `uploads`(
          id_no int(11) NOT NULL AUTO_INCREMENT,
          imageName VARCHAR(50) NOT NULL,
          imageSize int(11) NOT NULL,
          imagePath VARCHAR(255) NOT NULL,
          imageType VARCHAR(11) NOT NULL,
          user VARCHAR(30) NOT NULL,
          PRIMARY KEY (`id_no`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1");

//Creating merge table
      $stmt->query("CREATE DATABASE IF NOT EXISTS $db_name");
      $stmt->query("USE $db_name");
      $stmt->query("CREATE TABLE IF NOT EXISTS `merge`(
            id_no int(11) NOT NULL AUTO_INCREMENT,
            imageName VARCHAR(50) NOT NULL,
            imageSize int(11) NOT NULL,
            imagePath VARCHAR(255) NOT NULL,
            imageType VARCHAR(11) NOT NULL,
            user VARCHAR(30) NOT NULL,
            PRIMARY KEY (`id_no`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1");
        header("Location: ../register.php");
    }
catch (PDOException $e) {
    echo 'Connection Failed: ' . $e->getMessage();
    die();
}

?>

