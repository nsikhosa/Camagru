<?php
    require_once ("./config/database.php");
    session_start();

    if(!isset($_SESSION['user_id'])){
        header('location: login.php');
    }
    $user = $_SESSION['username'];
    
    $db = new PDO($dsn, $Uname, $password );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/*#####################Merging the images.################################*/

    function merge_image($background, $frame, $uname, $data)
    {
        $background = imagecreatefrompng($background);
        $frame = imagecreatefrompng($frame);
        $frame_x = imagesx($frame);
        $frame_y = imagesy($frame);
        
        $imgname = "merged";
        $random = rand(0, 9999);
        $imagename = $imgname.$random.".png";
        $mergedPath = "image/merged/".$imagename;
        $mergedSize = getimagesize($mergedPath);
        $AmergedSize = $mergedSize['bits'];
        $type = "image/png";

        imagesavealpha($frame, true);
        imagealphablending($background, true);
        if (imagecopy($background, $frame, 0, 0, -5, 0, 500, 400))
        {
            include('home.php');        
            imagepng($background, $mergedPath);
            $db_name = "camagru";
            $dsn = "mysql:host=localhost;dbname=$db_name";
            $Uname = 'root';
            $password = 'ntombi';
            // Insert statement into merge table
            try{
                $db = new PDO($dsn, $Uname, $password );
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $Mstmt = $db->prepare("INSERT INTO `merge` (imageName, imageSize, imagePath, imageType, user)
                                       VALUES (:imageName, :imageSize, :imagePath, :imageType, :user)");
            
                $Mstmt->bindParam (':imageName', $imagename);
                $Mstmt->bindParam (':imageSize', 8);
                $Mstmt->bindParam (':imagePath', $mergedPath);
                $Mstmt->bindParam (':imageType', $type);
                $Mstmt->bindParam (':user', $user);

           echo "success";

            $Mstmt->execute();
            imagedestroy($frame);
            }
            catch(PDOException $e){
               echo "could not connect".$e;
            }
        }
        else
            {
                header('Content-Type: text/html');
                echo "Failed to Merge images!";
            }
    }
/*##########################Reading image from the canvas######################*/

    if(isset($_POST['hidden_data']))
    {
        $message = '';

        mkdir('./image/');

        $image = $_POST['hidden_data'];
        $rand = rand(0, 9999);
        $image_name = $_SESSION['username'].$rand.".png";
        $path = "image/".$image_name;
        $image1 = explode(',', $image);
        $imageType = "image/png";
        $decode = base64_decode($image1[1]);

        file_put_contents($path, $decode);

        $info = getimagesize($path);
        $imageSize = $info['bits'];
        
        $stmt = $db->prepare("INSERT INTO `uploads` (imageName, imageSize, imagePath, imageType, user)
        VALUES (:imageName, :imageSize, :imagePath, :imageType, :user)");

        $stmt->bindParam (':imageName', $image_name);
        $stmt->bindParam (':imageSize', $imageSize);
        $stmt->bindParam (':imagePath', $path);
        $stmt->bindParam (':imageType', $imageType);
        $stmt->bindParam (':user', $user);

        $stmt->execute();

        if (isset($_POST["frame"]))
        {
            $frame = "";
            if ($_POST["frame"] == "sunglasses")
                $frame = "sunglasses";
            else if ($_POST["frame"] == "christmas")
                $frame = "christmas";
            else
                $frame = "queen";

            $image = $db->prepare("SELECT imagePath FROM `uploads` WHERE id_no = (SELECT MAX(id_no) FROM uploads)");
            $image->execute();
            $row = $image->fetch(PDO::FETCH_ASSOC);
    
            $frame = $db->prepare("SELECT framePath FROM `frames` WHERE frameName = '$frame'");
            $frame->execute();
            $row1 = $frame->fetch(PDO::FETCH_ASSOC);
            merge_image($row['imagePath'], $row1['framePath'], $user, $db);
        }

        $message = "Image successfully uploaded";   
        include("home.php");
    }
    
?>