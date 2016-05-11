<?php
if(!isset($_SESSION)){
    session_start();
}

require 'Assets/include/loggedoutfilter.php';
require 'Assets/include/Random.php';
require 'Assets/Repository/UserRepository.php';
require 'Assets/Mailer/PHPMailerAutoload.php';

if(!empty($_POST['email'])){
    $email=$_POST['email'];
    $repo=new UserRepository();

    $user=$repo->GetByEmail($email);
    if($user!=null){
        $reset=generateRandomString(52);
        $url='localhost:63342/auth/PasswordReset.php?Reset='.$reset;
        $body="Hello $email,\r\n Click the link to reset your password:\r\n $url \r\n \r\nIf you didn`t request this password reset we encourage you to ignore it and report this to the administrators!";
        $user->Reset=$reset;
        $repo->Update($user);

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->Username = "contestuni4@gmail.com";
        $mail->Password = "stefanbg";

        $mail->AddAddress($email);
        $mail->WordWrap = 50;
        $mail->IsHTML(true);

        $mail->Subject = "Reset";
        $mail->Body    = $body;

        if(!$mail->Send())
        {
            echo "Message could not be sent. <p>";
            echo "Mailer Error: " . $mail->ErrorInfo;
            exit;
        }
    }
    else{
        echo 'That is an invalid Email!';
    }

}


?>

<html>
<head>
    <div class="header">
        <a href="Index.php" style="color: #fff;">User Manager</a>
    </div>
    <style>
        <?php include "Assets/CSS/style.css";?>
    </style>
</head>
<body>
    <form enctype="multipart/form-data" method="post" action="#">
        <input type="text" placeholder="Email" name="email">
        <input type="submit">
    </form>


</body>
</html>
