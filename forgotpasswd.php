<?php
$message='';
$email = $_POST['email'];

if(isset($_POST['button_pressed'])){

    header('Location: resMsgBox.php');

    $to      = $email;
    $subject = 'Verification Email';
    $message = "Please click on the link below to reset your password.\nhttp://localhost:8080/practice/ex00/changep.php";
    $headers = 'From: noreply@camagru.com' . "\n" .
    'Reply-To: no-one@camagru.com' . "\n" .
    'X-Mailer: PHP/';
    mail($to, $subject, $message, $headers);

}
?>

<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
    <body class="body">
        <h1>Request New Password</h1>
    <div class="register">
    <?php if (isset($message)){
            echo $message;
        }; ?>
        <form action="forgotpasswd.php" method="post">
            <span> Please enter your email address.</span><br><br>
            <input type="email" name="email" placeholder="Email Address" style="width: 80%;" required></br></br>
            <input type="submit" name="button_pressed" value="Submit">
        </form>
        </div>
    </body>

</html>