<?php
require'Assets/include/loggedfilter.php';
?>
<html>
<head>
    <?php include "Header.php";?>
</head>
<body>


<div id="container" style="margin-top: 16px">
    <a href="Friends.php" class="CreateButton"><span>Friends</span></a>
    <input type="text" class="search" placeholder="Search" style="margin: 0px 0px 0px 50%; width: 20%;">

    <table>

        <th>Picture</th>
        <th>Name</th>
        <th>Email</th>
        <th></th>
        <?php
        require 'Assets/include/database.php';
        $records =$pdo->prepare("select DISTINCT friends.id As ID,Name,ImagePath,Email,Birthday,Phone,Website from users INNER JOIN
(
   Select UserID_1,UserID_2, ID
   From friends
   WHERE UserID_2 like :id and Accepted like 'N' and friends.Declined like 'N'
) friends
ON
   users.ID=friends.UserID_1");
        $id = $_SESSION['user_id'];
        $records->bindParam(':id',$id);
        $records->execute();
        while($results=$records->fetch(PDO::FETCH_ASSOC)){

            $ImagePath=$results['ImagePath'];
            $Birthday=$results['Birthday'];
            $Website=$results['Website'];
            $Phone=$results['Phone'];
            echo "<tr class='sr'>";
            echo "<td style='padding: 5px;'><img src='$ImagePath' alt='Image' width='50' height='50' id='img' style=''></td>";
            echo "<td style='font-size: 20px'>".$results['Name']."</td>";
            echo "<td style='font-size: 20px'>".$results['Email']."</td>";
            $id=$results['ID'];
            echo "<td><button class='but1view' value='$id'><span><i class='fa fa-user' aria-hidden='true'></i> Accept</span></button><button class='but1del' value='$id''><span><i class='fa fa-times' aria-hidden='true'></i> Decline</span></button></td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
<script>

    $('.but1view').click(function () {
        var val= $(this).val();
        var parent=$(this).parent().parent();
        $.ajax({
            type: 'POST',
            url: 'Assets/AcceptFriend.php',
            data:{value:val},
            success: function(data) {
                parent.hide();
            }
        });

    });
    $('.but1del').click(function () {
        var me=$(this).val();
        var parent=$(this).parent().parent();
        $.ajax({
            type: 'POST',
            url: 'Assets/DeclineFriend.php',
            data:{value:me},
            success: function(data) {
                parent.hide();
            }
        });
    });
</script>