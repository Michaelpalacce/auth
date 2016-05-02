<?php
require'Assets/include/loggedfilter.php';
?>
<html>
<head>
    <title>Phones</title>
</head>
<body>
<?php include "Header.php"; ?>

<br/>

<div id="container">
    <a href="CreatePhone.php?ID=<?php echo $_GET['ID']; ?>" class="CreateButton"><span>Create New Phone</span></a>

    <table>
        <th>Number</th>
        <th>Type</th>
        <th></th>

        <?php
        require 'Assets/include/database.php';
        $records =$pdo->prepare("SELECT * FROM numbers WHERE ContactID=:cid");
        $records->bindParam(':cid',$_GET['ID']);
        $records->execute();
        while($results=$records->fetch(PDO::FETCH_ASSOC)){
            echo "<tr>";
            echo "<td>".$results['Number']."</td>";
            echo "<td>".$results['Type']."</td>";
            $numberID=$results['ID'];
            $id=$_GET['ID'];
            echo "<td><a href='EditPhone.php?ID=$id&NID=$numberID' class='but2' >Edit</a>|<a href='DeletePhone.php?ID=$id?&NID=$numberID' class='but2del'>Delete</a></td>";
            echo "</tr>";
        }



        ?>
    </table>
</div>
</body>
</html>
