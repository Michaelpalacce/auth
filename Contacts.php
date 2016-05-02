<?php
require'Assets/include/loggedfilter.php';
if(!empty($_GET['str'])){
    $Search=$_GET['str'];
}
?>
<html>
<body>
<?php include "Header.php"; ?>
<br/>

<div id="container">
    <a href="CreateContact.php" class="CreateButton"><span>Create New Contact</span></a>

    <form name="search" id="search" method="get" action="Contacts.php">
        <input type="text" tabindex="1" class="input" id="str" name="str" value="" placeholder="Search" style="margin: 0px 0px 0px 520px; width: 321px;" />
        <input type="submit" tabindex="2" id="submit" value="SEARCH" style="display: none;"/>


        <table>
            <th>Picture</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Address</th>
            <th></th>

            <?php
            require 'Assets/include/database.php';
            $records =$pdo->prepare("SELECT FirstName,LastName,Address,ImagePath,ID FROM contacts WHERE UserId=:id ");

            if(!empty($Search)){
                $Search='%'.$Search.'%';
                $records=$pdo->prepare("SELECT FirstName,LastName,Address,ImagePath,ID FROM contacts WHERE UserId=:id and FirstName like :str or LastName like :str or Address like :str");

                $records->bindParam(':str',$Search);
            }
            $records->bindParam(':id',$_SESSION['user_id']);
            $records->execute();
            while($results=$records->fetch(PDO::FETCH_ASSOC)){
                $ImagePath=$results['ImagePath'];
                echo "<tr>";
                echo "<td style='padding: 5px;'><img src='$ImagePath' alt='Image' width='50' height='50' id='img' style=''></td>";
                echo "<td>".$results['FirstName']."</td>";
                echo "<td>".$results['LastName']."</td>";
                echo "<td>".$results['Address']."</td>";
                $id=$results['ID'];
                echo "<td><a href='Phones.php?ID=$id' class='but2' >ViewPhones</a>|<a href='EditContact.php?ID=$id' class='but2' >Edit</a>|<a href='DeleteContact.php?ID=$id' class='but2del' >Delete</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </form>

</div>
</body>
</html>
