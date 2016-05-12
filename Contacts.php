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

    </form>
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
                $records=$pdo->prepare("SELECT FirstName,LastName,Address,ImagePath,ID FROM contacts WHERE UserId=:id and FirstName like :str or UserId=:id and LastName like :str or UserId=:id and  Address like :str");

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
                echo "<td>
<button class='but1phones' id='phones' value='$id'>ViewPhones</button>
<button class='but1edit' id='edit' value='$id'>Edit</button>
<button class='but1del' value='$id'>Delete</button></td>";
                echo "</tr>";
            }
            ?>
        </table>


</div>
</body>
</html>
<script src="Assets/js/jquery.min.js"></script>
<script>
    $('.but1edit').click(function () {
        var val= $(this).val();
        window.location.href="EditContact.php?ID="+val;
    });
    $('.but1phones').click(function () {
        var val= $(this).val();
        window.location.href="Phones.php?ID="+val;
    });
    $('.but1del').click(function () {
        var me=$(this).val();
        var parent=$(this).parent().parent();
        $.ajax({
            type: 'POST',
            url: 'DeleteContact.php',
            data:{value:me},
            success: function(data) {
                parent.hide();
            }
        });

    });
</script>