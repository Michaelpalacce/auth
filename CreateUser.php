<?php
require'Assets/include/loggedfilter.php';
if(!class_exists('UserRepository')){
    include 'Assets/Repository/UserRepository.php';
}
include "Assets/include/Random.php";


if(!empty($_POST['email'])&&!empty($_POST['password'])&&!empty($_POST['admin'])){
    if(!isset($_SESSION)){
        session_start();
    }
    $target_dir = "UserPhotos/".$_POST['email']."/";
    if(!is_dir($target_dir)){
        mkdir($target_dir);
    }

    $renamer=$_SESSION['Email'].'UserPhoto'.generateRandomString();
    $target_file = $target_dir.$renamer;
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["upload"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {

            $uploadOk = 0;
        }
    }

    if ($_FILES["upload"]["size"] > 10000000) {
        echo "Sorry, your file is too large. Make sure it`s below 10MB!";
        $uploadOk = 0;
    }
    $repo= new UserRepository();
    $user= new User();
    $user->Email=$_POST['email'];
    $user->Password=$_POST['password'];
    $user->Hash="-";
    $user->Reset="-";
    $empty='';
    if(!empty($_POST['admin'])){
        $user->Admin=$_POST['admin'];
    }
    else{
        $user->Admin='N';
    }
    if(!empty($_POST['name'])){
        $user->Name=$_POST['name'];
    }
    else{
        $user->Name=$empty;
    }
    if(!empty($_POST['birthday'])){
        $user->Birthday=$_POST['birthday'];
    }
    else{
        $user->Birthday=$empty;
    }
    if(!empty($_POST['website'])){
        $user->Website=$_POST['website'];
    }
    else{
        $user->Website=$empty;
    }
    if(!empty($_POST['phone'])){
        $user->Phone=$_POST['phone'];
    }else{
        $user->Phone=$empty;
    }



    if ($uploadOk == 0) {
        $user->ImagePath='UserPhotos/default.png';

        $repo->Add($user);
    } else {
        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
            $user->ImagePath=$target_file;
            $repo->Add($user);
        } else {
            $user->ImagePath='UserPhotos/default.png';
            $repo->Add($user);
        }
    }


    header('Location: Admin.php');
}
?>
<html>
<head>

    <div id="header">
        <style>
            <?php include 'Assets/CSS/home.css'; ?>
        </style>
        <ul>
            <li><a href="Admin.php" class="but">cPanel</a> </li>
            <li><a href="Index.php" class="but">Index</a> </li>
            <li><a href="Logout.php" class="but">Logout</a> </li>

        </ul>
    </div>
</head>
<body>
<br/>
<br/>

<form action="CreateUser.php" method="POST" enctype="multipart/form-data">
    <img src="UserPhotos/default.png" alt="Image" width="250" height="250" id="img">

    <input type="text" placeholder="Email" name="email">
    <input type="text" placeholder="Password" name="password">
    <input type="text" placeholder="Name" name="name">
    <input type="text" placeholder="Phone" name="phone">
    <input type="text" placeholder="Website" name="website">
    <input type="text" placeholder="Birthday" name="birthday">
    <input type="text" placeholder="Admin N-No Y-Yes" name="admin">
    <div>
        <button type="submit" class="submit">Submit</button>
        <a href="Admin.php" class="cancel">Cancel</a>
    </div>
    <div class="wrap">
        <input type="file" id="upload" name="upload"/>
    </div>

</form>
</body>
</html>
<style>
    #img{
        transition: 1s ease;
        -webkit-border-radius:;
        -moz-border-radius:;
        border-radius:50%;
        box-shadow: 5px 5px 2px #888888;
        cursor: pointer;
    }
    #img:hover{
        -webkit-transform: scale(1.2);
        -ms-transform: scale(1.2);
        transform: scale(1.2);
        transition: 1s ease;
    }
    .wrap{
        visibility: hidden;
    }

</style>
<script src="Assets/js/jquery.min.js"></script>
<script>
    var btn = document.getElementById('img');
    var btnToCLick=document.getElementById('upload');

    btn.addEventListener('click', function() {
        btnToCLick.click();
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#upload").change(function(){
        readURL(this);
    });

</script>