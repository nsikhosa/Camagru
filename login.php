<?php
session_start();
if(isset($_SESSION['user_id'])){
    header('location: home.php');
}
?>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body class="body">
        <head>
            <h1>Please login</h1>    
        </head>
        <div class= "register">
        <?php if (isset($message)){
            echo $message;
        }; ?>
        <form action="bindlogin.php" method="post">
            <input type="text" name="username" placeholder="Username" style="width: 80%;" required></br></br>
            <input type="password" name="passwd" placeholder="Password" style="width: 80%;" required></br></br>
            <input type="submit" name="button_pressed" value="Submit">
            <div class="forgotLink">
                <span><a href="forgotpasswd.php">Forgot Password?</a></span>
            </div>
            <div class="forgotLink">
                <span><a href="register.php">Not a member? Sign up.</a></span>
            </div>
        </form>
        </div>
    </body>
</html>