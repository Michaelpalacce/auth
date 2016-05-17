<?php
require 'Assets/Repository/UserRepository.php';
$res='';
if(!empty($_GET['Reset'])){
    $res=$_GET['Reset'];
}
if(!empty($_POST['password'])&&!empty($_POST['confirmPassword'])&&($_POST['password']==$_POST['confirmPassword'])){
    $repo=new UserRepository();
    $user= new User();
    $user=$repo->GetByReset($res);
    $user->Password=$_POST['password'];
    $repo->Reset($user);
    echo 'Password has been reset!';
}
?>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <div class="header">
        <a href="Index.php" style="color: #fff;">User Manager</a>
    </div>
    <style>
        <?php include "Assets/CSS/style.css";?>
    </style>
</head>
<body>
    </br>
    </br>
    </br>
    </br>
    <form enctype="multipart/form-data" method="post" action="PasswordReset.php?Reset=<?= $res  ; ?>">
    <input type="password" placeholder="New Password" name="password" autocomplete="off">
    <input type="password" placeholder="Repeat Password" name="confirmPassword" autocomplete="off">
    <input type="submit">
    </form>
</body>
</html>
