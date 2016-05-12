<?php
require 'Assets/include/adminfilter.php';

?>

<html>
<head>
    <title>cPanel</title>
    <?php include "AdminHeader.php";?>
</head>
<body>
<br/>
<div id="container">
    <a href="CreateUser.php" class="CreateButton"><span>Create New User</span></a>

    <table>
        <th>Picture</th>
        <th>Email</th>
        <th>Password</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Website</th>
        <th>Birthday</th>
        <th>Admin</th>
        <th></th>

        <?php
        require 'Assets/include/database.php';
        $records =$pdo->prepare("SELECT * FROM users");
        $records->execute();
        while($results=$records->fetch(PDO::FETCH_ASSOC)){
            $ImagePath=$results['ImagePath'];
            $Website='http://'.$results['Website'];
            echo "<tr>";
            echo "<td style='padding: 5px;'><img src='$ImagePath' alt='Image' width='50' height='50' id='img' style=''></td>";
            echo "<td>".$results['Email']."</td>";
            echo "<td>".$results['Password']."</td>";
            echo "<td>".$results['Name']."</td>";
            echo "<td>".$results['Phone']."</td>";
            echo "<td><a href='$Website'>$Website</a></td>";
            echo "<td>".$results['Birthday']."</td>";
            echo "<td>".$results['Admin']."</td>";
            $id=$results['ID'];
            $email=$results['Email'];
            echo "<td><button class='but1hijack' value='$id'>Hijack</button><button class='but1edit' value='$id'>Edit</button><button class='but1del' value='$id'>Delete</button></td>";
            echo "</tr>";
        }
        ?>
    </table>

</div>
</body>
</html>
<script src="Assets/js/jquery.min.js"></script>
<script>
    $('.but1hijack').click(function () {
        var val= $(this).val();
        window.location.href="HijackSession.php?ID="+val;
    });
    $('.but1edit').click(function () {
        var val= $(this).val();
        window.location.href="EditUser.php?ID="+val;
    });
    $('.but1del').click(function () {
        var me=$(this).val();
        var parent=$(this).parent().parent();
        $.ajax({
            type: 'POST',
            url: 'DeleteUser.php',
            data:{value:me},
            success: function(data) {
                parent.hide();
            }
        });

    });
</script>