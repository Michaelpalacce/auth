<?php
if(!isset($_SESSION)){
    session_start();
}
require 'Assets/include/database.php';
$id = $_SESSION['user_id'];
$records2 =$pdo->prepare("UPDATE messages set Recieved='Y' where Reciever like :id");
$records2->bindParam(':id',$id);
$records2->execute();
?>

<html>
<head>
    <?php include'Header.php'?>
</head>
<body>


<div class="Message-container">

    <?php

    $records =$pdo->prepare("select DISTINCT messages.ID,Sender,Recieved,TimeRecieved,TimeSent, Message, users.ImagePath,users.Email,users.Name from messages inner join users on Sender = users.ID
WHERE messages.Reciever like :id And messages.DeletedByReciever like 'N' ORDER BY messages.ID DESC");
    $records->bindParam(':id',$id);
    $records->execute();
    while($results=$records->fetch(PDO::FETCH_ASSOC)) {
        $ImagePath = $results['ImagePath'];
        $Email = $results['Email'];
        $Name = $results['Name'];
        $Sender = $results['Sender'];
        $Message = $results['Message'];
        $mes2;
        if (strlen($Message) <= 30) {
            $mes2 = substr($Message, 0, 30);
        } else {
            $mes2 = substr($Message, 0, 30) . '...';
        }
        $Recieved = $results['Recieved'];
        $TimeRecieved = $results['TimeRecieved'];
        $TimeSent = $results['TimeSent'];
        $messageID = $results['ID'];
        $person="Reciever";
//  <img src='$ImagePath' alt='Image' width='50' height='50' id='img' class='imag'  style='float: left; margin: 15px 0px 0px 20px;' >
        echo "<div class='message' style='background: #eee;'>
        <div class='message-row' >
        <div>
                <p class='email'>From: $Email</p>
            </div>
            <div>
                <p class='title'>Preview: $mes2</p>
                 <div class='email-row'>
            <div>
                <p class='email-text'>$Message</p>
            </div>
            <div>
            <a href='SendMessage.php?ID=$Sender' class='but2' style='color: #0098cb;'>Reply |</a><a href='DeleteMessage.php?ID=$messageID&Person=$person&Place=R' class='but2' style='color: #FF0002;;'>Delete</a>
</div>
<br/>
        </div>
            </div>

            <div >
                <p class='time'>Time Sent: $TimeSent</p>
            </div>
        </div>



    </div>";
    }
    ?>


</div>

</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script>
    var main = function() {
        $('.message').click(function() {
            $(this).children('.imag').toggleClass('show');
            $(this).children('.email-row').toggleClass('show');


        });
    }
    $(document).ready(main);

</script>