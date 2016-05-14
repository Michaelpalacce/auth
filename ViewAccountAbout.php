<?php
if(!class_exists('UserRepository')){
    include "Assets/Repository/UserRepository.php";
}
$friendID="";
if(!isset($_COOKIE['friend'])) {
    echo "Cookie is not set!";
} else {
    $friendID=$_COOKIE['friend'];
}
$repo= new UserRepository();
$user=new User();
$user= $repo->GetByID($friendID);
$CurrentResidence=$user->CurrentResidence;
$Country=$user->Country;
$MotherLanguage=$user->MotherLanguage;
$Hometown=$user->Hometown;
$Birthday=$user->Birthday;
$Education=$user->Education;
$Religion= $user->Religion;
$FavouriteQuote=$user->FavouriteQuote;
$Email=$user->Email;
$Phone=$user->Phone;
$Website= $user->Website;
$Job=$user->Job;
$Relationship= $user->Relationship;
$Gender=$user->Gender;
$Nickname=$user->Nickname;
echo "<div class='about'>
    <div class='title'>
    <span class='Description'>$user->Description</span>
</div>
<div class='line'></div>
    <div class='title'>
        <div class='show'>
         <span class='Description'>Location</span>
        </div>
        <div class='hide'>
        <span class='inf'>Current Location: $CurrentResidence</span>
                <span class='inf'>Country: $Country</span>
                <span class='inf'>Language: $MotherLanguage</span>
        </div>
    </div>
<div class='line'></div>
    <div class='title'>
    <div class='show'>
          <span class='Description'>History</span>
        </div>
        <div class='hide'>
          <span class='inf'>Hometown: $Hometown</span>
               <span class='inf'>Birthday: $Birthday</span>
               <span class='inf'>Education: $Education</span>
        </div>

    </div>
<div class='line'></div>
    <div class='title'>
     <div class='show'>
          <span class='Description'>Likes</span>
        </div>
        <div class='hide'>
         <span class='inf'>Religion: $Religion</span>
          <span class='inf'>Favourite Quote: $FavouriteQuote</span>
        </div>

    </div>
<div class='line'></div>
    <div class='title'>
     <div class='show'>
      <span class='Description'>Status</span>
    </div>
    <div class='hide'>
    <span class='inf'>Email: $Email</span>
        <span class='inf'>Phone: $Phone</span>
        <span class='inf'>Website: $Website</span>
        <span class='inf'>Job: $Job</span>
        <span class='inf'>Relationship: $Relationship</span>
        <span class='inf'>Gender: $Gender</span>
        <span class='inf'>Nickname: $Nickname</span>
    </div>

    </div>
    <div class='line'></div>
</div>";
?>
<script src="Assets/js/jquery.min.js"></script>
<script>
    $('.title').click(function(){
        $(this).children().next().animate({ height: 'toggle'},'slow');
    });
</script>
<style>
    .line{
        padding:1px;
        width:60%;
        margin:0px auto;
        border-bottom: 1px solid #01A096;
    }
    .about{

        width:60%;
        margin:20px auto;
    }
    .title{
        background: #01A096;
        width:50%;
        margin:20px auto;
        border-bottom:1px solid #95D3D7;
        padding:20px 20px 20px 20px;
    }

    .inf{
        display: block;
        margin:20px 20px 20px 20px;
        color: whitesmoke;
    }
    .Description{
        color: white;
        border:none;
        font-size:25px;
        margin:0px 0px 0px 0px;
    }
    .hide{
        display: none;
    }
</style>