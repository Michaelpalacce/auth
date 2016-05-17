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

    <table >

        <th>Picture</th>
        <th>Name</th>
        <th>Email</th>
        <th></th>
        <?php

        require 'Assets/include/database.php';
        $records =$pdo->prepare("select ID,Name,ImagePath,Email from users LEFT OUTER JOIN ( Select UserID_1,UserID_2 From friends Where UserID_1 like :id or UserID_2 like :id) friends ON users.ID = friends.UserID_1 or users.ID = friends.UserID_2 WHERE friends.UserID_2 IS NULL or friends.UserID_1 IS  NULL ");
        $id = $_SESSION['user_id'];
        $records->bindParam(':id',$id);
        $records->execute();
        while($results=$records->fetch(PDO::FETCH_ASSOC)){
            if($results['ID']!=$_SESSION['user_id']){
                $ImagePath=$results['ImagePath'];
                $friendID=$results['ID'];
                echo "<tr class='sr'>";
                echo "<td style='padding: 5px;'><img src='$ImagePath' alt='Image' width='50' height='50' id='img' style=''></td>";
                echo "<td style='font-size: 20px'>".$results['Name']."</td>";
                echo "<td style='font-size: 20px'>".$results['Email']."</td>";
                $id=$results['ID'];
                echo "<td><button class='but1add' value='$friendID''>Add Friend</button></td>";
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
    var $rows = $('.sr');

    $('.search').keyup(function() {
        var val = $.trim($(this).val()).toLowerCase();
        $rows.show().filter(function(index) {
            var text= $(this).text().toLowerCase();
            return (text.indexOf(val) === -1);
        }).hide();
    });

    $('.but1add').click(function () {
        var me=$(this).val();
        var parent=$(this).parent().parent();
        $.ajax({
            type: 'POST',
            url: 'AddFriend.php',
            data:{value:me},
            success: function(data) {
                parent.hide();
            }
        });

    });
</script>