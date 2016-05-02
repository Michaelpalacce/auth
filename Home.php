<?php
require'Assets/include/loggedfilter.php';
?>
<html>
<head>
    <title>Contact Manager</title>
    <?php include "Header.php";?>
</head>
<body>
<br/>
<br/>
<br/>

<?php
if(!class_exists('UserRepository')){
    include 'Assets/Repository/UserRepository.php';
}
$rep = new UserRepository();
$results =$rep->GetByID($_SESSION['user_id']);
$name=$results['Name'];
$image=$results['ImagePath'];
?>
<img src="<?php echo  $image;?>" alt="Image" width="250" height="250" id="img">
<br/>
<br/>
<span style="font-size: 30px; color: #f5f5f5;">
    Welcome, <?php echo $name;?>!
</span>

</body>
</html>
<style>
    #img{
        transition: 1s ease;
        -webkit-border-radius:;
        -moz-border-radius:;
        border-radius:50%;
        box-shadow: 5px 5px 2px #888888;
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