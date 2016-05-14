<?php
$friendID="";
if(!isset($_COOKIE['friend'])) {
    echo "Cookie is not set!";
} else {
    $friendID=$_COOKIE['friend'];
}
?>


<div class="co">
    <button class='but1account' id="but1account">Show Phones</button>
    <table>
        <th>Picture</th>
        <th>Name</th>
        <th>Address</th>
        <th>Phones</th>
        <?php
        require 'Assets/include/database.php';
        $records =$pdo->prepare("SELECT FirstName,LastName,Address,ImagePath,ID FROM contacts WHERE UserId=:id and Private= 'N' ");
        $records->bindParam(':id',$friendID);
        $records->execute();
        while($results=$records->fetch(PDO::FETCH_ASSOC)){
            $ImagePath=$results['ImagePath'];
            echo "<tr>";
            echo "<td style='padding: 5px;'><img src='$ImagePath' alt='Image' width='50' height='50' id='img' style=''></td>";
            echo "<td><span>".$results['FirstName']." ".$results['LastName']."</span></td>";
            echo "<td>".$results['Address']."</td>";
            echo "<td >";
            echo "<div class='phoneHide'>";
            $records2 =$pdo->prepare("SELECT * FROM numbers WHERE ContactID=:cid");
            $records2->bindParam(':cid',$results['ID']);
            $records2->execute();
            while($results2=$records2->fetch(PDO::FETCH_ASSOC)){
                echo "<span class='numbers'>".$results2['Type'].": ".$results2['Number']."</span><br/>";
            }
            echo "</div>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
<script src="Assets/js/jquery.min.js"></script>
<script src="Assets/js/ripple.js"></script>
<script>
    $('#but1account').click(function(){
        $('.phoneHide').toggle();
    });
</script>
<style>
    .numbers{
        font-size:15px;
    }
    #but1account{
        cursor: pointer;
        margin-bottom: 20px;
        float: right;
    }
    .phoneHide{
        display: none;
    }
    .co{
        width:90%;
        margin:20px auto;
    }
</style>