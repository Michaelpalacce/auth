<?php
if(!isset($_SESSION)){
    session_start();
}
$id=$_SESSION['user_id'];
if(!class_exists('UserRepository')){
    include "Assets/Repository/UserRepository.php";
}
$friendID="";
if(!isset($_COOKIE['friend'])) {
    echo "Cookie is not set!";
} else {
    $friendID=$_COOKIE['friend'];
}
include "Assets/include/database.php";
?>
<div>
    <?php

    $records =$pdo->prepare("select DISTINCT messages.ID,Sender,Recieved,TimeSent, Message from messages WHERE messages.Reciever like :id AND messages.Sender like :frid And messages.DeletedByReciever like 'N' or messages.Reciever like :frid AND messages.Sender like :id And messages.DeletedByReciever like 'N' ORDER BY messages.ID DESC");
    $count=0;
    $records->bindParam(':id',$id);
    $records->bindParam(':frid',$friendID);
    $records->execute();
    while($results=$records->fetch(PDO::FETCH_ASSOC)) {
        $count++;
        $Sender = $results['Sender'];
        $Message = $results['Message'];
        $mes2;
        if (strlen($Message) <= 30) {
            $mes2 = substr($Message, 0, 30);
        } else {
            $mes2 = substr($Message, 0, 30) . '...';
        }
        $Recieved = $results['Recieved'];

        $TimeSent = $results['TimeSent'];
        $messageID = $results['ID'];
        echo "<div class='message' style='background: #eee;'>
        <div class='message-row' >

            <div>
                <p class='title'>Preview: $mes2</p>
                 <div class='email-row'>
            <div>
                <p class='email-text'>$Message</p>
            </div>
            <div>
            <button class='but1send' value='$Sender'><span><i class='fa fa-reply' aria-hidden='true'></i> Reply</span></button>
            <button class='but1del' value='$messageID'><span><i class='fa fa-trash' aria-hidden='true'></i> Delete</span></button>
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
    if($count==0){
        echo" <br/>
    <br/>
    <br/>
    <br/>
    <div>
        <span style=\"font-size: 40px; font-weight: bold; color:white;\">You have no mail currently.</span>
    </div>";
    }
    ?>
</div>
<link rel="stylesheet" href="font-awesome-4.6.2/css/font-awesome.min.css">
<script src="Assets/js/jquery.min.js"></script>
<script>
    var $rows = $('.message');

    $('.search').keyup(function() {
        var val = $.trim($(this).val()).toLowerCase();
        $rows.show().filter(function(index) {
            var text= $(this).text().toLowerCase();
            return (text.indexOf(val) === -1);
        }).hide();
    });

    $('.but1send').click(function () {
        var val= $(this).val();
        window.location.href="  SendMessage.php?ID="+val;
    });

    $('.but1del').click(function () {
        var me=$(this).val();
        var parent=$(this).parent().parent().parent().parent();
        $.ajax({
            type: 'POST',
            url: 'DeleteMessageReciever.php',
            data:{value:me},
            success: function(data) {
                parent.animate({height: 'toggle'},'slow');
            }
        });
    });
</script>
<style>
    .message{
        width:40%;
        margin:20px auto;
    }
    .title{
        margin:20px 20px 20px 20px
    }
</style>