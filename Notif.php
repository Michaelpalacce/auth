<?php
include "Assets/include/database.php";
if(!isset($_SESSION)){
    session_start();
}
$records =$pdo->prepare("select DISTINCT messages.ID,Notified,Sender,Recieved,TimeRecieved,TimeSent, Message, users.ImagePath,users.Email,users.Name from messages inner join users on Sender = users.ID
WHERE messages.Reciever like :id And messages.Notified like 'N' ORDER BY messages.ID DESC limit 1");
$id = $_SESSION['user_id'];
$records->bindParam(':id',$id);
$records->execute();
$count=0;
$go=0;
while($results=$records->fetch(PDO::FETCH_ASSOC)) {
    $go=1;
    $ImagePath=$results['ImagePath'];
    $Sender=$results['Sender'];
    $Message=$results['Message'];
    $ID=$results['ID'];
    $records2 =$pdo->prepare("UPDATE messages set Notified='Y' where ID like :id");
    $records2->bindParam(':id',$ID);
    $records2->execute();
    $mes2="";
    if (strlen($Message) <= 30) {
        $mes2 = substr($Message, 0, 30);
    } else {
        $mes2 = substr($Message, 0, 30) . '...';
    }
    echo "<div class='cont'>
    <button class='closeForNotif'>X</button>
    <div class='notification'>
        <img src='$ImagePath'; class='picture'>

        <div>
        <span  class='notification-message'>$mes2</span>
        </div>

    </div>
    </div>";
}
?>