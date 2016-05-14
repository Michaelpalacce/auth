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
    <input type="text" tabindex="1" class="search" placeholder="Search" style="margin: 0px 0px 0px 50%; width: 20%;"/>
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
            echo "<tr class='sr'>";
            echo "<td>".$results['Number']."</td>";
            echo "<td>".$results['Type']."</td>";
            $numberID=$results['ID'];
            $id=$_GET['ID'];
            echo "<td><a href='EditPhone.php?ID=$id&NID=$numberID' class='but2' ><span><i class='fa fa-pencil' aria-hidden='true'></i> Edit</span></a>        <a href='DeletePhone.php?ID=$id?&NID=$numberID' class='but2del'><span><i class='fa fa-trash' aria-hidden='true'></i> Delete</span></a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
<link rel="stylesheet" href="font-awesome-4.6.2/css/font-awesome.min.css">
<script src="Assets/js/search.js"></script>