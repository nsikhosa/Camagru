<?php
require_once ("config/database.php");
session_start();

if (isset($_POST['submit']))
{
    $message = '';
    $user = $_SESSION['username'];
    mkdir('./image/');
    $image = $_FILES['file'];
    $imageName = $_FILES['file']['name'];
    $imageSize = $_FILES['file']['size'];
    $imageTemp = $_FILES['file']['tmp_name'];
    $imageType = $_FILES['file']['type'];
    $imageError = $_FILES['file']['error'];
    
    try{
        $imageExt = explode('.', $imageName);
        $nImageName = $imageExt[0].rand(0, 9999);
        $actualImageExt = strtolower(end($imageExt));
        $nImageName = $nImageName.".".$actualImageExt;

        $path = "image/".$nImageName;
    
        $allowed = array('jpg','jpeg','png');

        if(in_array($allowed, $actualImageExt))
        {
            $db = new PDO($dsn, $Uname, $password );
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            $stmt = $db->prepare("INSERT INTO `uploads` (imageName, imageSize, imagePath, imageType, user)
            VALUES (:imageName, :imageSize, :imagePath, :imageType, :user)");

            $stmt->bindParam (':imageName', $nImageName);
            $stmt->bindParam (':imageSize', $imageSize);
            $stmt->bindParam (':imagePath', $path);
            $stmt->bindParam (':imageType', $imageType);
            $stmt->bindParam (':user', $user);

            $stmt->execute();
        
            if($imageError === 0)
            {
                if ($imageSize < 1000000){
                    move_uploaded_file($imageTemp , $path);
                    $message = "Image successfully uploaded";   
                    include("home.php");
                   }
                else{
                     $message = "image too big";
                     include("home.php");
                }
            }
            else{
                $message = "There was an error with your file";
                include("home.php");
            }
        }
        else{
                $message = "Not an image file";
                include("home.php");
        }
    }
    catch(Exeption $e)
    {
        echo "Could not bind: " .$e;
    }
}
?>