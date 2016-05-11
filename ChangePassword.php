<?php
include "Assets/include/loggedfilter.php";
if(!class_exists('UserRepository')){
    include 'Assets/Repository/UserRepository.php';
}

if(!empty($_POST['oldpass'])&&!empty($_POST['newpass'])&&!empty($_POST['confirmpass'])&&($_POST['confirmpass']==$_POST['newpass'])) {
    include "Assets/include/database.php";

    $records =$pdo->prepare("SELECT Email,Password FROM users WHERE id=:id");
    $records->bindParam(':id',$_SESSION['user_id']);
    $records->execute();
    $results=$records->fetch(PDO::FETCH_ASSOC);

    if($_POST['oldpass']==$results['Password']){
        $id=$_SESSION['user_id'];
        $rep=new UserRepository();
        $User=new User();
        $User=$rep->GetByID($id);
        $User->Password=$_POST['newpass'];

        $rep->Update($User);
        header('Location: Home.php');
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
    <form action="ChangePassword.php" method="POST" enctype="multipart/form-data">

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