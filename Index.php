<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<title class="title" style="color: #fff;">Welcome to User Manager</title>
<head>
    <?php if(isset($_SESSION['user_id'])): ?>
    <?php include 'Header.php'?>
    <?php else:?>
    <div class="header">
        <a href="Index.php" style="color: #fff;">User Manager</a>
    </div>
        <style>
            <?php include "Assets/CSS/style.css";?>
        </style>
    <?php endif;?>
</head>
<body>

<style>
    .header{
        text-align: center;
        background: #00CCBF;
    }
</style>
<?php if(isset($_SESSION['user_id'])):?>
    <?php
    require 'Assets/include/database.php';
    if(!class_exists('UserRepository')){
        include 'Assets/Repository/UserRepository.php';
    }

    if(isset($_SESSION['user_id'])){
        $records =$pdo->prepare("SELECT id,email,password,Admin FROM users WHERE id=:id");
        $records->bindParam(':id',$_SESSION['user_id']);
        $records->execute();
        $results=$records->fetch(PDO::FETCH_ASSOC);
        $user=NULL;
        if(count($results)>0){
            $user=new User();
            $id=$results['id'];
            $user->ID=$results['id'];
            $user->Email=$results['email'];
            $user->IsAdmin=$results['Admin'];
        }
    }
    ?>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/> <span style="color: #fff; font-size: 25px">Welcome <?=$user->Email;?> !</span>
    <br/><br/><span style="color: #fff; font-size: 20px">you are successfully logged in!</span>
    <br/><br/>

    <a href="Home.php" class="but">Continue to account</a>
    <span style="color: #fff; font-size: 25px">or <a href="Logout.php" class="but">Logout</a><br/><?php if($user->IsAdmin=='Y'){echo '</br>'; echo '<a href="Admin.php" class="but">Admin</a>';};?> </span>
<?php else: ?>
<h1 style="color: #fff;">Please Login or Register</h1>
<a href="Login.php" class="but">Login</a> <span style="color: #fff; font-size: 25px;">or</span>
<a href="Register.php" class="but">Register
    <?php endif;?>
</body>
</html>

