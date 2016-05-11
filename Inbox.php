<?php
include "Assets/include/loggedfilter.php";
?>

<html>
<head>
    <?php include "Header.php";?>
</head>
<body>

<div id="container" style="margin-top: 16px">
    <a href="SendMessage.php" class="CreateButton"><span>Send New Message</span></a>
    <table>

        <th>Picture</th>
        <th>Sender</th>
        <th>Time Sent</th>
        <th>Message</th>
        <th></th>
        <?php

        require 'Assets/include/database.php';
        $records =$pdo->prepare("select DISTINCT messages.ID,Sender,Recieved,TimeSent, Message, users.ImagePath,users.Email,users.Name from messages inner join users on Sender = users.ID
WHERE messages.Reciever like :id And messages.DeletedByReciever like 'N'  ORDER BY messages.ID DESC");
        $id = $_SESSION['user_id'];
        $records->bindParam(':id',$id);
        $records->execute();
        while($results=$records->fetch(PDO::FETCH_ASSOC)){
            $ImagePath=$results['ImagePath'];
            $Email=$results['Email'];
            $Name=$results['Name'];
            $Sender=$results['Sender'];
            $Message=$results['Message'];
            $mes;
            $mes2;
            if(strlen($Message)<=10){
                $mes=substr($Message,0, 10);
            }
            else{
                $mes=substr($Message,0, 10).'...';
            }
            if(strlen($Message)<=30){
                $mes2=substr($Message,0, 30);
            }
            else{
                $mes2=substr($Message,0, 30).'...';
            }
            $Recieved=$results['Recieved'];
            $TimeRecieved=$results['TimeRecieved'];
            $TimeSent=$results['TimeSent'];
            $messageID=$results['ID'];
            $person="Reciever";
            echo "<tr class='ViewMessage'>";
            echo "<td style='padding: 5px;'><img src='$ImagePath' alt='Image' width='50' height='50' id='img' style=''></td>";
            echo "<td style='font-size: 20px'>".$Email."</td>";
            echo "<td style='font-size: 20px'>".$TimeSent."</td>";
            echo "<td style='font-size: 20px;'  id='tooltip'>".$mes ." <span class='tooltiptext'>$mes2</span></td>";
            echo "<td><a href='SendMessage.php?ID=$Sender' class='but2' style='color: #00CCBF;'>Reply|</a><a href='DeleteMessageReciever.php?ID=$messageID&Person=$person&Place=R' class='but2' style='color: #FF0002;;'>Delete</a></td>";
            echo "</tr>";

        }
        ?>
    </table>
    <a href="Inboxpt2.php"  class="cancel" style="background: mediumturquoise; margin-top: 10px;">Care To Try Our New Inbox</a>
</div>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script>
    var tooltipSpan = document.getElementById('tooltip-div  ');

    window.onmousemove = function (e) {
        var x = e.clientX,
            y = e.clientY;
        tooltipSpan.style.top = (y + 20) + 'px';
        tooltipSpan.style.left = (x + 20) + 'px';
    };
</script>
<style>
    td{
        cursor: pointer;
    }
    #tooltip {
        position: relative;
        display: inline-block;
        border-bottom: 1px  solid #00CCBF;
    }

    .tooltiptext {
        visibility: hidden;
        top: 100%;
        width:320px;
        margin-top:2px;
        left: 45%;
        margin-left: -160px;
        background-color: #00CCBF;
        color: black;
        text-align: center;
        padding: 5px 0;
        border-radius: 6px;
        position: absolute;
        z-index: 1;
        opacity: 0;
        transition: opacity 1s;
    }
    #tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }

</style>