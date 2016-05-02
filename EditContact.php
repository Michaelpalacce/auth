<?php
require 'Assets/include/loggedfilter.php';
if(!class_exists('ContactRepository')){
    include 'Assets/Repository/ContactRepository.php';
}

require 'Assets/include/Random.php';

$id = $_GET["ID"];
if(!empty($_POST)){
    if(!empty($_POST['firstname'])||!empty($_POST['lastname'])||!empty($_POST['address'])||!empty($_FILES['upload'])){
        if(!isset($_SESSION)){
            session_start();
        }

        $target_dir = "Images/".$_SESSION['Email']."/";

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
        $getter=$repo->GetByID($id);
        $con = new Contact();
        $empty='';
        if(!empty($_POST['firstname'])){
            $con->FirstName=$_POST['firstname'];
        }
        else{
            $con->FirstName=$getter['FirstName'];
        }
        if(!empty($_POST['lastname'])){
            $con->LastName=$_POST['lastname'];
        }
        else{
            $con->LastName=$getter['LastName'];
        }

        if(!empty($_POST['address'])){
            $con->Address=$_POST['address'];
        }
        else{
            $con->Address=$getter['Address'];
        }
        $con->ID=$id;

        if ($uploadOk == 0) {
            $con->ImagePath='Images/default.png';
            $repo->Update($con);
        } else {
            if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
                if($getter['ImagePath']!='Images/default.png'){
                    unlink($getter['ImagePath']);
                }
                $con->ImagePath=$target_file;
                $repo->Update($con);
            } else {
                $con2=$repo->GetByID($con->ID);
                if( $con2['ImagePath']!='Images/default.png'){
                    $con->ImagePath=$con2['ImagePath'];
                }else{
                    $con->ImagePath='Images/default.png';
                }
                $repo->Update($con);
            }
        }

        include "Assets/Repository/GroupRepository.php";
        include "Assets/include/database.php";
        if(isset($_POST['groups'])){
            $groups=$_POST['groups'];
            if(!empty($groups)){
                $sql="Delete From contact_group where contact_id=:cid";
                $stmt=$pdo->prepare($sql);
                $stmt->bindParam(':cid',$_GET['ID']);
                $stmt->execute();
                for($i=0;$i<count($groups);$i++){
                    $GroupRepository=new GroupRepository();
                    $group=$GroupRepository->GetByName($groups[$i]);
                    $GR= new Group();
                    $GR->ID=$group['ID'];
                    $sql="INSERT INTO contact_group (contact_id,group_id) VALUES (:cid,:gid)";
                    $stmt=$pdo->prepare($sql);
                    $stmt->bindParam(':cid',$_GET['ID']);
                    $stmt->bindParam(':gid',$GR->ID);
                    $stmt->execute();
                }
            }
        }

    }
}
?>

<html>
<head>
    <?php include "Header.php"; ?>
</head>
<body>
<br/>
<br/>
<form action='EditContact.php?ID=<?php echo $_GET['ID'];?>' method="POST" enctype="multipart/form-data">

    <?php
    $rep= new ContactsRepository();
    $id = $_GET["ID"];
    $contact=$rep->GetByID($id);

    $firstname=$contact['FirstName'];
    $lastname=$contact['LastName'];
    $address=$contact['Address'];
    $userid=$contact['UserID'];
    $ImagePath=$contact['ImagePath'];

    echo " <img src='$ImagePath' alt='Image' width='250' height='250' id='img' class='img'>";

    echo "<input type='text' placeholder='First Name: $firstname' name='firstname'>";
    echo "<input type='text' placeholder='Last Name: $lastname' name='lastname'>";
    echo "<input type='text' placeholder='Address: $address' name='address'>";
    ?>
    Groups:
    <div class="groups">

        <?php
        if(!isset($_SESSION)){
            session_start();
        }

        include "Assets/include/database.php";
        $records =$pdo->prepare("SELECT * FROM groups WHERE UserID=:id");
        $usrId=$_SESSION['user_id'];
        $records->bindParam(':id',$usrId);
        $records->execute();
        while($groups=$records->fetch(PDO::FETCH_ASSOC)):
            $records2 =$pdo->prepare("SELECT * FROM contact_group WHERE group_id=:id and contact_id =:cid");
            $contactID=$_GET['ID'];
            $records2->bindParam(':id',$groups['ID']);
            $records2->bindParam(':cid',$contactID);
            $records2->execute();
            $groups2=$records2->fetch(PDO::FETCH_ASSOC);
            if($groups2['group_id']==$groups['ID']):?>
            <span><?php echo $groups['Name']; ?>:</span>
            <input type='checkbox'  name='groups[]' checked="checked" value='<?php echo $groups['Name']; ?>' />
              <?php else: ?>
                <span><?php echo $groups['Name']; ?>:</span>
                <input type='checkbox'  name='groups[]' value='<?php echo $groups['Name']; ?>' />
            <?php endif;?>
        <?php endwhile; ?>
    </div>


    <div>
        <button type="submit" class="submit">Submit</button>
        <a href="Contacts.php" class="cancel">Cancel</a>
    </div>

    <div class="wrap">
        <input type="file" id="upload" name="upload" class="upload"/>
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