<?php
include "Assets/include/loggedfilter.php";
?>

<html>
<head>
    <?php include "Header.php";?>
</head>
<body>

<div id="container" style="margin-top: 16px">
    <a href="FindFriends.php" class="CreateButton"><span>Find Friends</span></a>
        <table>

        <th>Picture</th>
        <th>Name</th>
        <th>Email</th>
        <th></th>
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
        $id = $_SESSION['user_id'];
        $records->bindParam(':id',$id);
        $records->execute();
        while($results=$records->fetch(PDO::FETCH_ASSOC)){
            if($results['ID']!=$_SESSION['user_id']){
                $ImagePath=$results['ImagePath'];
                $Birthday=$results['Birthday'];
                $Website=$results['Website'];
                $Phone=$results['Phone'];
                echo "<tr>";
                echo "<td style='padding: 5px;'><img src='$ImagePath' alt='Image' width='50' height='50' id='img' style=''></td>";
                echo "<td style='font-size: 20px'>".$results['Name']."</td>";
                echo "<td style='font-size: 20px'>".$results['Email']."</td>";
                $id=$results['ID'];
                echo "<td><a href='SendMessage.php?ID=$id' class='but2send'style='padding: 10px;'>Send Message</a><button class='but1del' value='$id''>Remove Friend</button></td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
</div>
</body>
</html>
<script src="Assets/js/jquery.min.js"></script>
<script>
    $('.but1del').click(function () {
        var me=$(this).val();
        var parent=$(this).parent().parent();
        $.ajax({
            type: 'POST',
            url: 'DeleteFriend.php',
            data:{value:me},
            success: function(data) {
                parent.hide();
            }
        });

    });
</script>