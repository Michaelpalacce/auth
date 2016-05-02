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
            echo "<tr>";
            echo "<td style='padding: 5px;'><img src='$ImagePath' alt='Image' width='50' height='50' id='img' style=''></td>";
            echo "<td>".$results['Email']."</td>";
            echo "<td>".$results['Password']."</td>";
            echo "<td>".$results['Name']."</td>";
            echo "<td>".$results['Phone']."</td>";
            echo "<td>".$results['Website']."</td>";
            echo "<td>".$results['Birthday']."</td>";
            echo "<td>".$results['Admin']."</td>";
            $id=$results['ID'];
            $email=$results['Email'];
            echo "<td><a href='HijackSession.php?ID=$id&Email=$email' class='but2'>Hijack Session</a>|<a href='EditUser.php?ID=$id' class='but2' >Edit</a>|<a href='DeleteUser.php?ID=$id' class='but2del' >Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </table>

</div>
</body>
</html>

