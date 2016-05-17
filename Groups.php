<?php
require'Assets/include/loggedfilter.php';
?>

<!DOCTYPE html>
<html lang="en">
<body>
<?php include "Header.php"; ?>
<br/>

<div id="container">
    <a href="CreateGroup.php" class="CreateButton"><span>Create New Group</span></a>

        <input type="text" tabindex="1" class="search" placeholder="Search" style="margin: 0px 0px 0px 50%; width: 20%;"/>

        <table>
        <th>Picture</th>
        <th>Name</th>
        <th>Contacts</th>
        <th></th>

        <?php
        if(!isset($_SESSION)){
            session_start();
        }

        require 'Assets/include/database.php';
        $records =$pdo->prepare("SELECT * FROM groups WHERE UserID=:id");
        $usrId=$_SESSION['user_id'];
        $records->bindParam(':id',$usrId);
        $records->execute();
        while($results=$records->fetch(PDO::FETCH_ASSOC)){
            $ImagePath=$results['ImagePath'];
            echo "<tr class='sr'>";
            echo "<td style='padding: 5px;'><img src='$ImagePath' alt='Image' width='50' height='50' id='img' style=''></td>";;
            echo "<td>".$results['Name']."</td>";
            $records2=$pdo->prepare("select * from contacts c join contact_group cg on c.ID=cg.contact_id WHERE cg.group_id=:id AND  cg.UserID =:UserID");
            $records2->bindParam(':id',$results['ID']);
            $records2->bindParam(':UserID',$_SESSION['user_id']);
            $records2->execute();
            echo '<td>';
            while($results2=$records2->fetch(PDO::FETCH_ASSOC)){

               echo $results2["FirstName"]." ".$results2["LastName"];
                echo '<br/>';
            }
            echo '</td>';
            $id=$results['ID'];
            echo "<td><button class='but1' value='$id'><span><i class='fa fa-pencil' aria-hidden='true'></i> Edit</span></button><button class='but1del' value='$id'><span><i class='fa fa-trash' aria-hidden='true'></i> Delete</span></button></td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</body>
<button class="but1account" >TestRipple</button>


</html>
<link rel="stylesheet" href="font-awesome-4.6.2/css/font-awesome.min.css">
<script src="Assets/js/jquery.min.js"></script>
<script src="Assets/js/search.js"></script>
<script>
    $('.but1').click(function () {
        var val= $(this).val();
        $.ajax({
            type: 'POST',
            url: 'Assets/Cookies/EditCookie.php',
            data:{value:val},
            success: function(data) {
                window.location.href="EditGroup.php";
            }
        });
    });
    $('.but1del').click(function () {
        var me=$(this).val();
        var parent=$(this).parent().parent();
        $.ajax({
            type: 'POST',
            url: 'DeleteGroup.php',
            data:{value:me},
            success: function(data) {
                parent.hide();
            }
        });

    });
</script>
<script src="Assets/js/ripple.js"></script>