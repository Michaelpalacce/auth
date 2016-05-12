<?php
$friendID="";
if(!isset($_COOKIE['friend'])) {
    echo "Cookie is not set!";
} else {
    $friendID=$_COOKIE['friend'];
}
?>
<html>
<head>
<?php include "Header.php";?>
</head>
<body>
<?php
if(!class_exists('UserRepository')){
    include 'Assets/Repository/UserRepository.php';
}
$repo= new UserRepository();
$user=new User();
$user=$repo->GetByID($friendID);
$name=$user->Name;
$image=$user->ImagePath;
?>

<div class="topbar">
    <img src="<?php echo  $image;?>" alt="Image" width="250" height="250" class="small">
    <span class="name"><?=$name?></span>
    <div class="content">
        <button class="but1account" id="posts">Posts</button>
        <button class="but1account" id="friends">Friends</button>
        <button class="but1account" id="contacts">Contacts</button>
        <button class="but1account" id="messages">Messages</button>
        <button class="but1account" id="about">About</button>
    </div>
</div>
<div class="bottombar">
    <div class="bottomcontent">

    </div>
</div>
</br>

</body>
</html>
<script src="Assets/js/jquery.min.js"></script>
<script>

$(document).ready(function () {
    var count=1;
    $(".small").click(function() {
        var $this = $(this);
        $this.removeClass('small, large');
        $this.addClass((count==1)?'large':'small');
        count = 1-count;
        if(count==0){
            $('.name').hide();
            $('.bottombar').hide();
            $('.content').hide();
        }
        else {
            setTimeout(function () {
               $('.name').show();
                $('.bottombar').show();
                $('.content').show();
            },1000);
        }
    });
    $('#friends').click(function () {

        $('.bottomcontent').innerHTML="";
        $('.bottomcontent').load('ViewAccountFriends.php');
    });
    $('#contacts').click(function () {

        $('.bottomcontent').innerHTML="";
        $('.bottomcontent').load('ViewAccountContacts.php');
    });
    $('#messages').click(function () {

        $('.bottomcontent').innerHTML="";
        $('.bottomcontent').load('ViewAccountMessages.php');
    });
    $('#posts').click(function () {

        $('.bottomcontent').innerHTML="";
        $('.bottomcontent').load('ViewAccountPosts.php');
    });
    $('#about').click(function () {

        $('.bottomcontent').innerHTML="";
        $('.bottomcontent').load('ViewAccountAbout.php');
    });
});
</script>
<style>
    .content{
        margin-left:50%;
    }
    .bottombar{
        margin:20px 20px 20px 20px;

        min-height:550px;
        min-width:400px;
        background: transparent;
        text-align: center;

    }
    .topbar{
        margin:20px 20px 20px 20px;
        min-height:350px;
        min-width:400px;
        background: #01A197;
        text-align: left;
        cursor: pointer;
    }
    .name{
        font-weight: bold;
        color: #FAFFFF;
        font-size: 25px;
        cursor: pointer;
    }
    .small{
        margin-top:1%;
        margin-left: 1%;
        animation:1s ease;
        transition: 1s ease;
        -webkit-border-radius:50%;
        -moz-border-radius:50%;
        border-radius:50%;
        box-shadow: 5px 5px 2px #888888;
    }
    .large{
        width:50%;
        height:75%;
        -webkit-border-radius:0%;
        -moz-border-radius:0%;
        border-radius:0%;
        box-shadow: 0px 0px 0px #888888;
        z-index: 500;
        margin:20px 20px 20px 20px;
        margin-left:25%;
    }


</style>
