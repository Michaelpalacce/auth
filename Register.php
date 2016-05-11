<?php
if(!isset($_SESSION)){
    session_start();
}

require 'Assets/include/loggedoutfilter.php';
require 'Assets/include/Random.php';
require 'Assets/Repository/UserRepository.php';
require 'Assets/Mailer/PHPMailerAutoload.php';

if(isset($_SESSION['user_id'])){
    header("Location: auth/Index.php");
}

require 'Assets/include/database.php';
if(!empty($_POST['email'])&&!empty($_POST['password'])&&!empty($_POST['confirmPassword'])){
    if($_POST['password']!=$_POST['confirmPassword']){
        echo 'Passwords Do Not Match!';
    }
    else{
        $hash=generateRandomString(52);
        $sql="Select Email from users where Email=:email";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':email',$_POST['email']);
        $stmt->execute();
        $results=$stmt->fetch(PDO::FETCH_ASSOC);
        if($results['Email']!=$_POST['email']){
            $repo=new UserRepository();
            $User= new User();

            $Email=$_POST['email'];
            $User->Email=$Email;
            $User->Reset='-';
            $Name;
            if(!empty($Name)){
                $Name='';
            }
            $User->Password= $_POST['password'];
            $User->Hash=$hash;
            $User->Admin='N';
            $empty='';
            if(!empty($_POST['name'])){
                $Name=$_POST['name'];
                $User->Name=$Name;
            }
            else{
                $User->Name=$empty;
            }
            if(!empty($_POST['birthday'])){
                $User->Birthday=$_POST['birthday'];
            }
            else{
                $User->Birthday=$empty;
            }
            if(!empty($_POST['website'])){
                $User->Website=$_POST['website'];
            }
            else{
                $User->Website=$empty;
            }

            if(!empty($_POST['phone'])){
                $User->Phone=$_POST['phone'];
            }else{
                $User->Phone=$empty;
            }
            $User->ImagePath='UserPhotos/default.png';
            $repo->Add($User);
            $target_dir = "UserPhotos/".$_POST['email']."/";
            if(!is_dir($target_dir)){
                mkdir($target_dir);
            }

            $url='localhost:63342/auth/VerifyAccount.php?Hash='.$hash;
            $body="Welcome to Contacts Manager $Email,\r\n Click the link to verify your account:\r\n $url";


            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465;
            $mail->Username = "contestuni4@gmail.com";
            $mail->Password = "stefanbg";
            $mail->AddAddress($Email);

            $mail->WordWrap = 50;
            $mail->IsHTML(true);

            $mail->Subject = "Verify";
            $mail->Body    = $body;

            if(!$mail->Send())
            {
                echo "Message could not be sent. <p>";
                echo "Mailer Error: " . $mail->ErrorInfo;
                exit;
            }



        }
        else{
            echo "Users cannot have the same email!";
        }


    }
}


?>
<!DOCTYPE html>
<html>
<head>
     <title>Register Below</title>
    <style>
        <?php include 'Assets/CSS/style.css'; ?>
    </style>
    <link href='https://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>
<div class="header">
    <a href="Index.php" style="color: #fff;">User Manager</a>
</div>
<style>
    .header{
        text-align: center;
        background: #00CCBF;
    }
</style>
<h1 style="color: #fff; font-size: 25px">Register</h1>
    <span style="color: #fff; font-size: 25px">or <a href="Login.php" class="but" style="color: #fff; font-size: 25px">login here!</a></span>

    <form action="Register.php" method="POST">
        <input type="text" placeholder="Email" name="email">
        <input type="password" placeholder="Password" name="password">
        <input type="password" placeholder="Confirm Password" name="confirmPassword">
        <input type="text" placeholder="Name" name="name">
        <input type="text" placeholder="Birthday" name="birthday">
        <input type="text" placeholder="Website" name="website">
        <input type="text" placeholder="Phone Number" name="phone">

        <input type="submit">

    </form>
</body>
</html>