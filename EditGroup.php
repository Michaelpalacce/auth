<?php
require'Assets/include/loggedfilter.php';
if(!class_exists('GroupRepository')){
    include 'Assets/Repository/GroupRepository.php';
}

require 'Assets/include/Random.php';
$id=$_GET['ID'];
if(!empty($_POST)){
    if(!empty($_POST['name'])||!empty($_FILES['upload'])) {
        if(!isset($_SESSION)){
            session_start();
        }
        $target_dir = "GroupImages/".$_SESSION['Email']."/";


        $renamer=$_SESSION['Email'].'GroupPhoto'.generateRandomString();
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

        $repo= new GroupRepository();
        $getter=$repo->GetByID($id);
        $group = new Group();
        if(!empty($_POST['name'])){
            $group->Name=$_POST['name'];
        }
        else{
            $group->Name=$getter['Name'];
        }

        $group->UserID=$_SESSION['user_id'];
        $group->ID=$id;

        if ($uploadOk == 0) {
            $group->ImagePath='GroupImages/default.png';
            $repo->Update($group);
        } else {
            if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
                if($getter['ImagePath']!='GroupImages/default.png'){
                    unlink($getter['ImagePath']);
                }
                $group->ImagePath=$target_file;
                $repo->Update($group);
            } else {
                $group2=$repo->GetByID($group->ID);
                if( $group2['ImagePath']!='GroupImages/default.png'){
                    $group->ImagePath=$group2['ImagePath'];
                }else{
                    $group->ImagePath='GroupImages/default.png';
                }
                $repo->Update($group);
            }
        }


    }
}
?>


<html>
<head>
    <?php include "Header.php";  ?>
</head>
<body>
<br/>
<br/>

<form action="EditGroup.php?ID=<?php echo $_GET["ID"];?>" method="POST" enctype="multipart/form-data">
    <?php
    $rep= new GroupRepository();
    $id = $_GET["ID"];
    $group=$rep->GetByID($id);

    $Name=$group['Name'];

    $ImagePath=$group['ImagePath'];
    echo " <img src='$ImagePath' alt='Image' width='250' height='250' id='img' class='img'>";

    echo "<input type='text' placeholder='Name: $Name' name='name'>";

    ?>
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
        box-shadow: 10px 10px 5px #888888;
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