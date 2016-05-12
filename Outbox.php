<?php
?>

<html>
<head>
    <?php include'Header.php'?>
</head>
<body>


<div class="Message-container">

    <?php
    require 'Assets/include/database.php';
        $records =$pdo->prepare("select DISTINCT messages.ID,Sender,Reciever,Recieved,TimeSent, Message, Reciever, users.ImagePath,users.Email,users.Name from messages inner join users on messages.Reciever = users.ID
    WHERE messages.Sender like :id and messages.DeletedBySender LIKE 'N'  ORDER BY messages.ID DESC");
    $id = $_SESSION['user_id'];
    $records->bindParam(':id',$id);

    $records->execute();
    while($results=$records->fetch(PDO::FETCH_ASSOC)) {
        $ImagePath=$results['ImagePath'];

        $Email=$results['Email'];
        $Name=$results['Name'];
        $Reciever=$results['Reciever'];
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
        $TimeSent=$results['TimeSent'];
        $messageID=$results['ID'];
        echo "<div class='message' style='background: #eee;'>
        <div class='message-row' >

        <div>
                <p class='email'>To: $Email</p>
            </div>
            <div>
                <p class='title'>Preview: $mes2</p>
                 <div class='email-row'>
            <div>
                <p class='email-text'>$Message</p>
            </div>
            <div>
            <button  class='but1send' value='$Reciever'>Send Message</button>
            <button class='but1del' value='$messageID'>Delete</button>
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
<script src="Assets/js/jquery.min.js"></script>
<script>
    $('.but1send').click(function () {
        var val= $(this).val();
        window.location.href=" SendMessage.php?ID="+val;
    });
    $('.but1del').click(function () {
        var me=$(this).val();
        var parent=$(this).parent().parent().parent().parent();
        $.ajax({
            type: 'POST',
            url: 'DeleteMessageSender.php',
            data:{value:me},
            success: function(data) {
                parent.hide();
            }
        });

    });
</script>