<?php
require'Assets/include/loggedfilter.php';
require 'Assets/include/Random.php';
if(!class_exists('UserRepository')){
    include 'Assets/Repository/UserRepository.php';
}

$id=$_SESSION['user_id'];
if(!empty($_POST['name'])||!empty($_POST['birthday'])||!empty($_POST['website'])||!empty($_POST['phone'])||!empty($_POST['job'])||!empty($_POST['hometown'])||!empty($_POST['relationship'])||!empty($_POST['currentResidence'])||!empty($_POST['education'])||!empty($_POST['motherLanguage'])||!empty($_POST['country'])||!empty($_POST['religion'])||!empty($_POST['gender'])||!empty($_POST['favouriteQuote'])||!empty($_POST['nickname'])||!empty($_POST['description'])||!empty($_FILES['upload'])){

    $target_dir = "UserPhotos/".$_SESSION['Email']."/";
    if(!is_dir($target_dir)){
        mkdir($target_dir);
    }

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

    $repo= new UserRepository();
    $getter=$repo->GetByID($id);
    $user= new User();
    $user->ID=$id;

    $user= new User();
    $user->ID=$id;
    $empty='';


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

    if(!empty($_POST['job'])){
        $user->Job=$_POST['job'];
    }else{
        $user->Job=$getter->Job;
    }
    if(!empty($_POST['relationship'])){
        $user->Relationship=$_POST['relationship'];
    }else{
        $user->Relationship=$getter->Relationship;
    }
    if(!empty($_POST['hometown'])){
        $user->Hometown=$_POST['hometown'];
    }else{
        $user->Hometown=$getter->Hometown;
    }
    if(!empty($_POST['currentResidence'])){
        $user->CurrentResidence=$_POST['currentResidence'];
    }else{
        $user->CurrentResidence=$getter->CurrentResidence;
    }
    if(!empty($_POST['description'])){
        $user->Description=$_POST['description'];
    }else{
        $user->Description=$getter->Description;
    }
    if(!empty($_POST['education'])){
        $user->Education=$_POST['education'];
    }else{
        $user->Education=$getter->Education;
    }
    if(!empty($_POST['motherLanguage'])){
        $user->MotherLanguage=$_POST['motherLanguage'];
    }else{
        $user->MotherLanguage=$getter->MotherLanguage;
    }
    if(!empty($_POST['country'])){
        $user->Country=$_POST['country'];
    }else{
        $user->Country=$getter->Country;
    }
    if(!empty($_POST['religion'])){
        $user->Religion=$_POST['religion'];
    }else{
        $user->Religion=$getter->Religion;
    }
    if(!empty($_POST['gender'])){
        $user->Gender=$_POST['gender'];
    }else{
        $user->Gender=$getter->Gender;
    }
    if(!empty($_POST['favouriteQuote'])){
        $user->FavouriteQuote=$_POST['favouriteQuote'];
    }else{
        $user->FavouriteQuote=$getter->FavouriteQuote;
    }
    if(!empty($_POST['nickname'])){
        $user->Nickname=$_POST['nickname'];
    }else{
        $user->Nickname=$getter->Nickname;
    }

    if ($uploadOk == 0) {
        $user->ImagePath='UserPhotos/default.png';
        $repo->UpdateSec($user);
    } else {

        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
            if($getter->ImagePath!='UserPhotos/default.png'){
                unlink($getter->ImagePath);
            }
            $user->ImagePath=$target_file;
            $repo->UpdateSec($user);
        } else {
            $user2=$repo->GetByID($user->ID);
            if( $user2->ImagePath!='UserPhotos/default.png'){
                $user->ImagePath=$user2->ImagePath;
            }else{
                $user->ImagePath='UserPhotos/default.png';
            }
            $repo->UpdateSec($user);
        }
    }
}
?>
<html>
<head>
<?php include "AccountHeader.php";?>

</head>
<body>
<div class="co">
    <br/>
    <br/>
    <br/>
    <form action='EditCurrentUser.php' method="POST"  enctype="multipart/form-data">
        <?php
        $rep= new UserRepository();
        $user=$rep->GetByID($id);

        $name=$user->Name;
        $phone=$user->Phone;
        $website=$user->Website;
        $birthday=$user->Birthday;
        $job=$user->Job;
        $hometown=$user->Hometown;
        $relationship=$user->Relationship;
        $currentResidence=$user->CurrentResidence;
        $education=$user->Education;
        $motherLanguage=$user->MotherLanguage;
        $country=$user->Country;
        $religion=$user->Religion;
        $gender=$user->Gender;
        $favouriteQuote=$user->FavouriteQuote;
        $nickname=$user->Nickname;
        $description=$user->Description;
        $ImagePath=$user->ImagePath;

        echo "<img src='$ImagePath' alt='Image' width='250' height='250' id='img' class='img' >";
        echo"<br/>";

        echo "<input type='text' placeholder='Name: $name' name='name' >";
        echo "<input type='text' placeholder='Phone: $phone' name='phone' >";
        echo "<input type='text' placeholder='Website: $website' name='website' >";
        echo "<input type='text' placeholder='Birthday: $birthday' name='birthday'>";
        echo "<input type='text' placeholder='Job: $job' name='job'>";
        echo "<input type='text' placeholder='Hometown: $hometown' name='hometown'>";
        echo "<input type='text' placeholder='Relationship: $relationship' name='relationship'>";
        echo "<input type='text' placeholder='CurrentResidence: $currentResidence' name='currentResidence'>";

        echo "<input type='text' placeholder='Education: $education' name='education'>";
        echo "<input type='text' placeholder='MotherLanguage: $motherLanguage' name='motherLanguage'>";
        echo "<input type='text' placeholder='Country: $country' name='country'>";
        echo "<input type='text' placeholder='Religion: $religion' name='religion'>";
        echo "<input type='text' placeholder='Gender: $gender' name='gender'>";
        echo "<input type='text' placeholder='FavouriteQuote: $favouriteQuote' name='favouriteQuote'>";
        echo "<input type='text' placeholder='Nickname: $nickname' name='nickname'>";
        echo "<textarea placeholder='Description: $description' class='desc' name='description' ></textarea>";
        ?>
        <div>
            <button type='submit' class='submit'>Submit</button>
        </div>
        <div class="wrap">
            <input type="file" id="upload" name="upload"/>
        </div>
    </form>

</div>

<style>
    
    .submit{
        margin:20px 20px 20px 45%;
    }

    .co{
        width:80%;
        display: inline;
        text-align: center;
    }
    .desc{
        outline:none;
        width: 50%;
        height:10%;

        border-radius:3px;
        border:1px solid #eee;
        text-align: left;
        resize: none;
    }
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
</body>
</html>

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

