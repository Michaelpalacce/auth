<?php
include "Assets/include/loggedfilter.php";
if(!empty($_POST['oldpass'])&&!empty($_POST['newpass'])&&!empty($_POST['confirmpass'])&&($_POST['confirmpass']==$_POST['newpass'])) {
    include "Assets/include/database.php";

    $records =$pdo->prepare("SELECT Email,Password FROM users WHERE id=:id");
    $records->bindParam(':id',$_SESSION['user_id']);
    $records->execute();
    $results=$records->fetch(PDO::FETCH_ASSOC);

    if($_POST['oldpass']==$results['Password']){

        $rep=new UserRepository();
        $User=$rep->GetByID($_SESSION['user_id']);
        $usr=new User();
        $usr->Email=$User['Email'];
        $usr->IsAdmin=$User['Admin'];
        $usr->Password=$_POST['newpass'];
        $usr->ID=$User['ID'];
        $rep->Update($usr);
    }
    else{
        echo "Something went wrong";
    }
}

?>
<html>
<head>
    <?php include "AccountHeader.php";?>

</head>
<body>
<br/>
<br/>
<br/>
<br/>
<div class="co">
    <form action="Account.php?Action=PassReset" method="POST" enctype="multipart/form-data">

        <input type="text" placeholder="Old Password" name="oldpass">
        <input type="text" placeholder="New Password" name="newpass">
        <input type="text" placeholder="Confirm Password" name="confirmpass">
        <button type="submit" class="submit">Change</button>
    </form>
</div>

</body>
</html>
<style>
    .co{
        display: inline-block;
        text-align: center;
    }
</style>