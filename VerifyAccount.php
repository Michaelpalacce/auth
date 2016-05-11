<?php
include "Assets/Repository/UserRepository.php";
$repo= new UserRepository();
$verified=False;
if(isset($_GET['Hash'])){
    $hash=$_GET['Hash'];
    $user=$repo->GetByHash($hash);
    if($user->Hash!="-"){
        echo 'here'.$user->Hash;
        $verified=True;
        $repo->Verify($user);
    }
}

?>
<html>
<head>

    <style>
        <?php include "Assets/CSS/style.css";?>
    </style>
    <div class="header">
        <a href="Index.php" style="color: #fff;">User Manager</a>
    </div>
</head>
<body>
<?php if($verified==True):?>
<div class="Verifier">
    <span>Your Account has been verified</span>
</div>
<div class="Verifier">
    <span>You will be redirected in 5 seconds.</span>
</div>
<div class="Verifier">
    <a href="Index.php" class="but2">Go Back</a>
</div>
<?php else:?>
    <div class="Verifier">
        <span>That is not a valid account!</span>
    </div>
    <div class="Verifier">
        <span>Consider Registering or contact an administrator if you think something is wrong!</span>
    </div>
    <div class="Verifier">
        <a href="Register.php" class="but2" style="color: #0098cb;">Register</a>
        <a href="Index.php" class="but2" style="color: #FF0002;">Go Back</a>
    </div>
<?php endif; ?>
</body>
</html>
<script src="Assets/js/jquery.min.js"></script>
<script>
//    $(function(){
//
//        setInterval(function () {
//            $(location).attr('href', 'Index.php')
//        },5000);
//    });
</script>
<style>
    .Verifier{
        margin:20px auto;
    }
    span{
        color: white;
    }
</style>