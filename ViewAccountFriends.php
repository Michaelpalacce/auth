<?php
if(!isset($_SESSION)){
    session_start();
}
$friendID="";
if(!isset($_COOKIE['friend'])) {
    echo "Cookie is not set!";
} else {
    $friendID=$_COOKIE['friend'];
}
?>
<style>
    <?php include 'Assets/CSS/home.css'; ?>
</style>
    <?php
    require 'Assets/include/database.php';
    $records =$pdo->prepare("select DISTINCT ID,Name,ImagePath,Email,Birthday,Phone,Website from users INNER JOIN
(
   Select UserID_1,UserID_2
   From friends
   Where UserID_1  like :id or UserID_2 like :id
) friends
ON
   users.ID=friends.UserID_1
   or users.ID=friends.UserID_2");
    $id =  $friendID;
    $records->bindParam(':id',$id);
    $records->execute();
    while($results=$records->fetch(PDO::FETCH_ASSOC)){
        if($results['ID']!=$friendID){
            $ImagePath=$results['ImagePath'];
            $Birthday=$results['Birthday'];
            $Website=$results['Website'];
            $Phone=$results['Phone'];
            $Email=$results['Email'];
            $Name=$results['Name'];
            $thisid=$results['ID'];
            if($thisid==$_SESSION['user_id']){
                $thisid='del';
            }
            echo "<div class='friend' data-value='$thisid'><img src='$ImagePath' alt='Image' width='50' height='50' id='img' style=''>
            <div class='Names'>$Name</div>
            <div class='Email'>$Email</div></div>";
        }
    }
    ?>
<script src="Assets/js/jquery.min.js"></script>
<script>
    $('.friend').click(function () {
        var val= $(this).data('value');
        if(val!='del'){
            $.ajax({
                type: 'POST',
                url: 'SetFriendCookie.php',
                data:{value:val},
                success: function(data) {
                    window.location.href="ViewAccount.php";
                }
            });
        }

    });
</script>
<style>
   .friend{
       display: inline-block;
       margin:20px 20px 20px 20px;
       background: #00CBBE;
       border-radius:5px;
       cursor: pointer;
   }
   .friend #img{
       margin-top: 20px;
   }
    .Names{
        color: #FAFFFF;
        font-size: 25px;
        cursor: pointer;
        margin:20px 20px 20px 20px;
        margin-left: 0px;
    }
    .Email{
        color: #FAFFFF;
        font-size: 25px;
        cursor: pointer;
        margin:20px 20px 20px 20px;
    }
</style>
