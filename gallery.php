<!DOCTYPE html>
<?php
require_once ("./config/database.php");  
session_start();

if(!isset($_SESSION['user_id'])){
    header('location: login.php');
}

$db = new PDO($dsn, $Uname, $password );
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->prepare("SELECT * FROM `uploads`");

$stmt->execute();

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gallery</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="body">
    <div class="header">
        <h1>Gallery</h1>
        <input type="button" onclick="location.href='logout.php';" value="logout"/></br>
        <input type="button" onclick="location.href='home.php';" value="home"/></br>
    </div>
    <div class="gallery">
    <?PHP
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo "<img src='image/".$row['imageName']."'>";
        }
    ?>
    </div>
        <?php if (isset($message)){
            echo $message;
        }; ?>
        
</body>
</html>
