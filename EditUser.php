<?php
require'Assets/include/loggedfilter.php';
if(!class_exists('UserRepository')){
    include 'Assets/Repository/UserRepository.php';
}
require 'Assets/include/Random.php';
$id='';
if(!isset($_COOKIE['friend'])) {
    header('Location: Error.php');
} else {
    $id=$_COOKIE['edit'];
}
if(!empty($_POST['email'])||!empty($_POST['password'])||!empty($_POST['admin'])||!empty($_POST['name'])||!empty($_POST['website'])||!empty($_POST['birthday'])||!empty($_POST['phone'])||!empty($_FILES['upload'])){
    if(!isset($_SESSION)){
        session_start();
    }
    $repo= new UserRepository();
    $getter=$repo->GetByID($id);
    $target_dir = "UserPhotos/".$getter->Email."/";

    $renamer=$_SESSION['Email'].'UserPhoto'.generateRandomString();
    $target_file = $target_dir . $renamer;
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

    $user= new User();
    $user->ID=$id;
    $empty='';
    $user->Admin=$_POST['admin'];
    if(!empty($_POST['email'])){
        $user->Email=$_POST['email'];
    }
    else{
        $user->Email=$getter->Email;
    }

    if(!empty($_POST['password'])){
        $user->Password=$_POST['password'];
    }
    else{
        $user->Password=$getter->Password;
    }

    if(!empty($_POST['name'])){
        $user->Name=$_POST['name'];
    }
    else{
        $user->Name=$getter->Name;
    }
    if(!empty($_POST['birthday'])){
        $user->Birthday=$_POST['birthday'];
    }
    else{
        $user->Birthday=$getter->Birthday;
    }
    if(!empty($_POST['website'])){
        $user->Website=$_POST['website'];
    }
    else{
        $user->Website=$getter->Website;
    }
    if(!empty($_POST['phone'])){
        $user->Phone=$_POST['phone'];
    }else{
        $user->Phone=$getter->Phone;
    }
    $user->Reset=$getter->Reset;
    $user->Hash=$getter->Hash;
    if ($uploadOk == 0) {
        $user->ImagePath='UserPhotos/default.png';
        $repo->Update($user);
    } else {
        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
            if($getter->ImagePath!='UserPhotos/default.png'){
                unlink($getter->ImagePath);
            }
            $user->ImagePath=$target_file;
            $repo->Update($user);
        } else {
            $user2=$repo->GetByID($user->ID);
            if( $user2->ImagePath!='UserPhotos/default.png'){
                $user->ImagePath=$user2->ImagePath;
            }else{
                $user->ImagePath='UserPhotos/default.png';
            }
            $repo->Update($user);
        }
    }
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

<form action='EditUser.php?ID' method="POST"  enctype="multipart/form-data">



    <?php
    $rep= new UserRepository();
    $id=$_COOKIE['edit'];
    $user=$rep->GetByID($id);

    $email=$user->Email;
    $password=$user->Password;
    $admin=$user->Admin;
    $name=$user->Name;
    $phone=$user->Phone;
    $website=$user->Website;
    $birthday=$user->Birthday;
    $ImagePath=$user->ImagePath;
    echo "<img src='$ImagePath' alt='Image' width='250' height='250' id='img' class='img'>";
    echo "<input type='text' placeholder='Email: $email' name='email'>";
    echo "<input type='text' placeholder='Password: $password' name='password'>";
    echo "<input type='text' placeholder='Name: $name' name='name'>";
    echo "<input type='text' placeholder='Phone: $phone' name='phone'>";
    echo "<input type='text' placeholder='Website: $website' name='website'>";
    echo "<input type='text' placeholder='Bithtday: $birthday' name='birthday'>";
    ?>
    <select name='admin' id ='drop'>
        <option value='Y'  <?php if($admin=="Y"){echo " selected='selected' ";};?>>Admin</option>
        <option value='N' <?php if($admin=="N"){echo " selected='selected' ";};?>>User</option>
    </select>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
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