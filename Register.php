<?php
session_start();
require 'Assets/include/loggedoutfilter.php';

if(isset($_SESSION['user_id'])){
    header("Location: auth/Index.php");
}

require 'Assets/include/database.php';
if(!empty($_POST['email'])&&!empty($_POST['password'])&&!empty($_POST['confirmPassword'])){
    if($_POST['password']!=$_POST['confirmPassword']){
        echo 'Passwords Do Not Match!';
    }
    else{

        $sql="Select Email from users where Email=:email";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':email',$_POST['email']);
        $stmt->execute();
        $results=$stmt->fetch(PDO::FETCH_ASSOC);
        if($results['Email']!=$_POST['email']){

            $sql="INSERT INTO users (email,password,Name,Birthday,Website,Phone) VALUES (:email,:password,:name,:birthday,:website,:phone)";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(':email',$_POST['email']);
            $stmt->bindParam(':password',$_POST['password']);
            $empty='';
            if(!empty($_POST['name'])){
                $stmt->bindParam(':name',$_POST['name']);
            }
            else{
                $stmt->bindParam(':name',$empty);
            }
            if(!empty($_POST['birthday'])){
                $stmt->bindParam(':birthday',$_POST['birthday']);
            }
            else{
                $stmt->bindParam(':birthday',$empty);
            }
            if(!empty($_POST['website'])){
                $stmt->bindParam(':website',$_POST['website']);
            }
            else{
                $stmt->bindParam(':website',$empty);
            }

            if(!empty($_POST['phone'])){
                $stmt->bindParam(':phone',$_POST['phone']);
            }else{
                $stmt->bindParam(':phone',$empty);
            }


            if($stmt->execute()){
                echo "User has been successfully created!";
            }
            else{
                echo "User could not be created! Please try again!";
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