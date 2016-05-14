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
        <input type="text" class="search" placeholder="Search" style="margin: 0px 0px 0px 50%; width: 20%;">
        <table>
            <th>Picture</th>
            <th>Name</th>
            <th>Address</th>
            <th></th>

            <?php
            require 'Assets/include/database.php';
            $records =$pdo->prepare("SELECT FirstName,LastName,Address,ImagePath,ID FROM contacts WHERE UserId=:id ");
            $records->bindParam(':id',$_SESSION['user_id']);
            $records->execute();
            while($results=$records->fetch(PDO::FETCH_ASSOC)){
                $ImagePath=$results['ImagePath'];
                echo "<tr class='sr'>";
                echo "<td style='padding: 5px;'><img src='$ImagePath' alt='Image' width='50' height='50' id='img' style=''></td>";
                echo "<td>".$results['FirstName']." ".$results['LastName']."</td>";
                echo "<td>".$results['Address']."</td>";
                $id=$results['ID'];
                echo "<td>
<button class='but1phones' id='phones' value='$id'><span><i class='fa fa-phone' aria-hidden='true'></i> View Phones</span></button>
<button class='but1edit' id='edit' value='$id'><span><i class='fa fa-pencil' aria-hidden='true'></i> Edit</span></button>
<button class='but1del' value='$id'><span><i class='fa fa-trash' aria-hidden='true'></i> Delete</span></button></td>";
                echo "</tr>";
            }
            ?>
        </table>
</div>
</body>
</html>
<link rel="stylesheet" href="font-awesome-4.6.2/css/font-awesome.min.css">
<script src="Assets/js/jquery.min.js"></script>
<script src="Assets/js/search.js"></script>
<script>
    $('.but1edit').click(function () {
        var val= $(this).val();
        $.ajax({
            type: 'POST',
            url: 'Assets/Cookies/EditCookie.php',
            data:{value:val},
            success: function(data) {
                window.location.href="EditContact.php";
            }
        });
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
                parent.animate({height: 'toggle'},'fast');
            }
        });

    });
</script>