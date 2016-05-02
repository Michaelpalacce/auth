<?php
if(!empty($_GET['str'])){
    $Search=$_GET['str'];
}
?>

<!DOCTYPE html>
<html lang="en">
<body>
<?php include "Header.php"; ?>
<br/>

<div id="container">
    <a href="CreateGroup.php" class="CreateButton"><span>Create New Group</span></a>

    <form name="search" id="search" method="get" action="Groups.php">
        <input type="text" tabindex="1" class="input" id="str" name="str" value="" placeholder="Search" style="margin: 0px 0px 0px 520px;"/>
        <input type="submit" tabindex="2" id="submit" value="SEARCH" style="display: none;"/>


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

        if(!empty($Search)){
            $Search='%'.$Search.'%';
            $records=$pdo->prepare("SELECT * FROM groups WHERE UserID=:id and Name like :str");

            $records->bindParam(':str',$Search);
        }
        $usrId=$_SESSION['user_id'];
        $records->bindParam(':id',$usrId);
        $records->execute();
        while($results=$records->fetch(PDO::FETCH_ASSOC)){
            $ImagePath=$results['ImagePath'];
            echo "<tr>";
            echo "<td style='padding: 5px;'><img src='$ImagePath' alt='Image' width='50' height='50' id='img' style=''></td>";;
            echo "<td>".$results['Name']."</td>";
            $records2=$pdo->prepare("select * from contacts c join contact_group cg on c.ID=cg.contact_id WHERE cg.group_id=:id");
            $records2->bindParam(':id',$results['ID']);
            $records2->execute();
            echo '<td>';
            while($results2=$records2->fetch(PDO::FETCH_ASSOC)){

               echo $results2["FirstName"]." ".$results2["LastName"];
                echo '<br/>';
            }
            echo '</td>';
            $id=$results['ID'];
            echo "<td><a href='EditGroup.php?ID=$id' class='but2' >Edit</a>|<a href='DeleteGroup.php?ID=$id' class='but2del' >Delete</a></td>";
            echo "</tr>";
        }



        ?>
    </table>
    </form>
</div>
</body>
</body>
</html>