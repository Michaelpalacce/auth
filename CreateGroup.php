<?php
require'Assets/include/loggedfilter.php';
if(!class_exists('GroupRepository')){
    include 'Assets/Repository/GroupRepository.php';
}
include "Assets/include/Random.php";


if(!empty($_POST['name'])) {
    $target_dir = "GroupImages/".$_SESSION['Email']."/";
    if(!is_dir($target_dir)){
        mkdir($target_dir);
    }


    $renamer=$_SESSION['Email'].'GroupPhoto'.generateRandomString();
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
    $repo= new GroupRepository();
    $group = new Group();
    $group->Name=$_POST['name'];
    $group->UserID=$_SESSION['user_id'];

    if ($uploadOk == 0) {
        $group->ImagePath='GroupImages/default.png';
        $repo->Add($group);
    } else {

        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {

            $group->ImagePath=$target_file;
            $repo->Add($group);
        } else {
            $group->ImagePath='GroupImages/default.png';
            $repo->Add($group);
        }
    }


}


?>


<html>
<head>

</head>
<body>
<?php include "Header.php"; ?>
<br/>
<br/>
<form action="CreateGroup.php" method="POST" enctype="multipart/form-data">


    <img src="GroupImages/default.png" alt="Image" width="250" height="250" id="img">

    <input type="text" placeholder="Group Name" name="name">
    <div>
        <button type="submit" class="submit">Submit</button>
        <a href="Groups.php" class="cancel">Cancel</a>

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