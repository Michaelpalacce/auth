<?php
require'Assets/include/loggedfilter.php';
if(!class_exists('GroupRepository')){
    include 'Assets/Repository/GroupRepository.php';
}
if(!class_exists('ContactRepository')){
    include 'Assets/Repository/ContactRepository.php';
}
include "Assets/include/database.php";
include "Assets/include/Random.php";

if(!empty($_POST['firstname'])&&!empty($_POST['lastname'])&&!empty($_POST['address'])) {
    if(!isset($_SESSION)){
        session_start();
    }
    $target_dir = "Images/".$_SESSION['Email']."/";
    if(!is_dir($target_dir)){
        mkdir($target_dir);
    }


    $renamer=$_SESSION['Email'].'ContactPhoto'.generateRandomString();
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
    $repo= new ContactsRepository();
    $con = new Contact();

    $empty='';
    $con->FirstName=$_POST['firstname'];
    if(!empty($_POST['lastname'])){
        $con->LastName=$_POST['lastname'];
    }
    else{
        $con->LastName=$empty;
    }

    if(!empty($_POST['address'])){
        $con->Address=$_POST['address'];
    }
    else{
        $con->Address=$empty;
    }

    if ($uploadOk == 0) {
        $con->ImagePath='Images/default.png';
        $repo->Add($con);
    } else {
        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
            $con->ImagePath=$target_file;
            $repo->Add($con);
        } else {
            $con->ImagePath='Images/default.png';
            $repo->Add($con);
        }
    }

    $sql="SELECT * FROM contacts ORDER BY ID DESC LIMIT 1";
    $stmt=$pdo->prepare($sql);
    $stmt->execute();
    $results=$stmt->fetch(PDO::FETCH_ASSOC);
    $MaxID=intval($results['ID']);
    $NextID=$MaxID+1;
    if(!empty($_POST['groups'])){
        $groups=$_POST['groups'];
        for($i=0;$i<count($groups);$i++){
            $GroupRepository=new GroupRepository();
            $group=$GroupRepository->GetByName($groups[$i]);
            $sql="INSERT INTO contact_group (contact_id,group_id) VALUES (:cid,:gid)";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(':cid',$MaxID);
            $stmt->bindParam(':gid',$group->ID);
            $stmt->execute();
        }
    }
    header('Location: Contacts.php');
}


?>


<html>
<head>

</head>
<body>
<?php include "Header.php"; ?>

<form action="CreateContact.php" method="POST" enctype="multipart/form-data">
    <br/>
    <br/>

    <img src="Images/default.png" alt="Image" width="250" height="250" id="img">

    <input type="text" placeholder="First name" name="firstname" class="text">
    <input type="text" placeholder="Last name" name="lastname" class="text">
    <input type="text" placeholder="Address" name="address" class="text">
    Groups:
    <div class="groups">

        <?php
        include "Assets/include/database.php";
        $records =$pdo->prepare("SELECT * FROM groups WHERE UserID=:id");
        $usrId=$_SESSION['user_id'];
        $records->bindParam(':id',$usrId);
        $records->execute();
        while($groups=$records->fetch(PDO::FETCH_ASSOC)):
        ?>

        <span><?php echo $groups['Name']; ?>:</span>
        <input type='checkbox' name='groups[]' value='<?php echo $groups['Name']; ?>' />
        <?php endwhile; ?>
    </div>


    <br/>
    <div>
        <button type="submit" class="submit">Submit</button>
        <a href="Contacts.php" class="cancel">Cancel</a>

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