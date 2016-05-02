<?php
include "Assets/include/loggedfilter.php";
?>

<html>
<head>
    <?php include "Header.php";?>
</head>
<body>

<div id="container" style="margin-top: 16px">
    <a href="Friends.php" class="CreateButton"><span>Friends</span></a>

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
                echo "<tr>";
                echo "<td style='padding: 5px;'><img src='$ImagePath' alt='Image' width='50' height='50' id='img' style=''></td>";
                echo "<td style='font-size: 20px'>".$results['Name']."</td>";
                echo "<td style='font-size: 20px'>".$results['Email']."</td>";
                $id=$results['ID'];
                echo "<td><a href='AddFriend.php?ID=$id' class='but2'>Add Friend</a></td>";
                echo "</tr>";

            }

        }
        ?>
    </table>

</div>

</body>
</html>
