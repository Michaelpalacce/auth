<?php
include "Assets/include/database.php";
$sql="select * from users where Name LIKE '%{$key}%'";
$array= array();
$stmt=$pdo->prepare($sql);
$stmt->execute();
while($results=$stmt->fetch(PDO::FETCH_ASSOC)){
   $array[]=$results['Name'];

}
echo json_encode($array);