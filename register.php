<?php
session_start();
if(isset($_SESSION['user_id'])){
    header('location: home.php');
}
?>
<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body class="body">
        <head>
            <h1>Please register</h1>    
        </head>
        <div class= "register">
        <?php if (isset($message)){
            echo $message;
        }; ?>
        <form action="binding.php" method="post">
            <input type="email" name="email" placeholder="Email Address"style="width: 80%;" required></br></br>
            <input type="text" name="username" placeholder="Username" style="width: 80%;" required></br></br>
            <input type="password" name="passwd" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 6 or more characters" placeholder="Password" style="width: 80%;" required></br></br>
            <input type="submit" name="button_pressed" value="Submit">
            <div class="forgotLink">
                <span><a href="login.php">Already registered? Login here.</a></span>
            </div>
        </form>
        </div>
    </body>
</html>