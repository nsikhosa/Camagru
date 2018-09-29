<?php
require_once ("./config/database.php");
$passwd = $_POST['passwd'];
$passwdre = $_POST['passwdre'];
$username = $_POST['username'];
$hashed_passwd = password_hash($passwd, PASSWORD_BCRYPT);

if ($passwd != null && $passwdre != null && strcmp($passwd, $passwdre) != 0)
{
    echo "Passwords do not match.\n";
}
else if ($passwd != null && $passwdre != null && $username != null)
{
try
        {
            $db = new PDO($dsn, $Uname, $password );
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $db->prepare("UPDATE `users` SET Password = :Password WHERE Username LIKE :Username");
            $stmt->bindValue(':Password', $hashed_passwd);
            $stmt->bindValue(':Username', $username);
            $stmt->execute();

         if($stmt->rowCount() > 0)
             {
                 echo "Password successfully changed.";
             }
         else
             {
                 echo "Failed to change password.";
             }
        }
    catch(PDOException $e)
        {
            echo "Connection Failed: " . $e->message();
        }
}
?>
<html>
    <head>
        <title>Reset Password</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body class="body">
        <head>
            <h1>Reset Password</h1>    
        </head>
        <div class= "register">
        <form action="changep.php" method="post">
            <input type="text" name="username" placeholder="Enter your username" style="width: 300px;" required></br></br>
            <input type="password" name="passwd" placeholder="Enter new password" style="width: 300px;" required></br></br>
            <input type="password" name="passwdre" placeholder="Re-enter password" style="width: 300px;" required></br></br>
            <input type="submit" name="button_pressed" value="Submit">
            <div class="forgotLink">
                <span><a href="login.php">Login</a></span>
            </div>
        </form>
        </div>
    </body>
</html>