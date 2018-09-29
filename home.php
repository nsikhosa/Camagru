<!DOCTYPE html>
<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header('location: login.php');
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
</head>
<body class="body">
    <div class="header">
        <h1>Home Page</h1>
        <input type="button" onclick="location.href='logout.php';" value="logout"/></br>
        <input type="button" onclick="location.href='gallery.php';" value="gallery"/></br>
    </div>
    
        <?php if (isset($message)){
            echo $message;
        }; ?>
    <div class="camera">
        <video id="video" width="400" height="300"></video>
        <a href="#" name="capture" id="capture" class="capture-button">Take Photo</a>
        <canvas id="canvas" width="400" height="300"></canvas>
        <img id="photo" src="http://placekitten.com/g/400/300" alt="Photo of you">
    </div>
    <div class="file">
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="file">
            <button type="submit" name ="submit">upload</button>
        </form>
    <form method="post" action="saveImage.php" id="saveImage"> 
        <div class="home">
        <input type="radio" name="frame" value="queen" checked><img id="queen" src="frames/Princess_crown.png" alt="queen" width="70" height="50"></br>
        <input type="radio" name="frame" value="sunglasses"><img id="sunglasses" src="frames/Glasses-Transparent-PNG.png" alt="sunglasses" width="70" height="50"></br>
        <input type="radio" name="frame" value="christmas"><img id="christmas" src="frames/Santa-Hat-psd89865.png" alt="Christmas" width="70" height="50"></br>
        </div>
        <input type="hidden" name="hidden_data" id='hidden_data'/>
        <button class="SaveButton" id="SaveButton" type="submit" name="SaveButton">Save Image</button>
    </form>
    </div>
    <script src="photo.js"></script>
</body>
</html>