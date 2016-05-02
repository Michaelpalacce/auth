<?php
session_start();
require 'Assets/include/loggedoutfilter.php';

if(isset($_SESSION['user_id'])){
    header("Location: Index.php");
}
require 'Assets/include/database.php';
if(!empty($_POST['email'])&&!empty($_POST['password'])){
    $records =$pdo->prepare("SELECT id,email,password FROM users WHERE email=:email");
    $records->bindParam(':email',$_POST['email']);
    $records->execute();
    $results=$records->fetch(PDO::FETCH_ASSOC);
    if(count($records)>0&&$_POST['password']=$results['password']){
        $_SESSION['user_id']=$results['id'];
        $_SESSION['Email']=$results['email'];
        header("Location: Index.php");
    }
    else{
       echo "Username or password not correct";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title style="color: #fff;">Login Below</title>
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

<h1 style="color: #fff;">Login</h1>
    <span style="color: #fff; font-size: 25px">or <a href="Register.php" class="but" style="color: #fff;">register here!</a></span>
    <form action="Login.php" method="POST">
        <input type="text" placeholder="Enter Your Email" name="email">
        <input type="password" placeholder="Enter Your Password" name="password">
        <input type="submit">

</form>
</body>
</html>