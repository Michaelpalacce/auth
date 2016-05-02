<?php
if(!class_exists('MessageRepository')){
    include "Assets/Repository/MessageRepository.php";
}
set_include_path('D:/Coding/Xamp/htdocs/auth');
require 'Assets/include/database.php';
$reciever;
$messageID;
if(!empty($_GET['ID'])){
    $messageID=$_GET['ID'];
    $sql="SELECT * FROM users where ID like :id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(":id",$_GET['ID']);
    $stmt->execute();
    while($results=$stmt->fetch(PDO::FETCH_ASSOC)){
        $reciever=$results['Email'];
    }
}

if(!empty($_POST)){
    if(!empty($_POST['reciever']&&!empty($_POST['message']))){

        $found='no';
        $id;
        $sql="SELECT * FROM users where Email like :email";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(":email",$_POST['reciever']);
        $stmt->execute();
        while($results=$stmt->fetch(PDO::FETCH_ASSOC)){
            $id=$results['ID'];
            $found='yes';
        }

        if($found=='yes'){
            if(!isset($_SESSION)){
                session_start();
            }

            $repo= new MessageRepository();
            $mes = new Message;
            $mes->Message=$_POST['message'];
            $mes->Reciever=$id;
            $mes->Sender=$_SESSION['user_id'];
            $repo->Add($mes);
        }

    }
}

?>

<html>
<head>
    <?php include "Header.php"; ?>
</head>
<body>

    <form action="SendMessage.php<?php if(!empty($reciever)){echo "?ID=$messageID";}?>" method="POST" enctype="multipart/form-data">
        <div class="message">

            <input placeholder="<?php if(!empty($_GET['ID'])){echo $reciever;}else{echo 'To:';} ?>" class="sendTo" name="reciever"  <?php if(!empty($_GET['ID'])){echo "value='$reciever'";} ?>">

            <textarea placeholder="Message" class="mess" name="message" ></textarea>

            <div>
                <button type="submit" class="sendButton">Send</button>
                <div class="circle"></div>
            </div>

        </div>
    </form>
</body>
</html>
<script>
    (function() {
        document.getElementsByClassName('sendTo').value=<?=$reciever;?>;
    })();

</script>
<style>
    .message{
        margin:20px 20px 20px 20px;
        width:auto;
        min-height:500px;
        background: paleturquoise;
    }
    .sendTo{
        float: left;
        outline:none;
        padding: 10px;
        display: ruby;
        width:25%;
        border-radius:3px;
        border:1px solid #eee;
        margin:20px 0px 20px 20px;
        margin-right: 1000px;
    }
    .mess{
        float: left;
        outline:none;
        padding: 10px;

        width: 60%;
        height:30%;
        border-radius:3px;
        border:1px solid #eee;
        margin:20px 0px 20px 20px;
        margin-right: 700px;
        text-align: left;
        resize: none;
    }
    .circle{
        width:15px;
        height:15px;

        border-radius:5px;
        background: #0098cb;
        float: left;
        margin:30px 20px 20px 0px;
        display: block;
        -webkit-animation:stf 3s linear infinite;
        -moz-animation:stf 3s linear infinite;
        -o-animation:stf 3s linear infinite;
        animation:stf 3s linear infinite;
    }
    @-webkit-keyframes stf {
        0%{-webkit-transform: rotate(0deg);
            background: #0098cb;}
        50%{-webkit-transform: rotate(180deg);
            background: #f5f5f5;
        }
        100%{-webkit-transform: rotate(360deg);
            background: #0098cb;}
    }
    @-moz-keyframes stf {
        0%{-moz-transform: rotate(0deg);
            background: #0098cb;}
        50%{-moz-transform: rotate(180deg);
            background: #f5f5f5;
        }
        100%{-moz-transform: rotate(360deg);
            background: #0098cb;}
    }

    @-o-keyframes stf {
        0%{-o-transform: rotate(0deg);
            background: #0098cb;}
        50%{-o-transform: rotate(180deg);
            background: #f5f5f5;
        }
        100%{-o-transform: rotate(360deg);
            background: #0098cb;}
    }

    @keyframes stf {
        0%{transform: rotate(0deg);
            background: #0098cb;}
        50%{transform: rotate(180deg);
            background: #f5f5f5;
        }
        100%{transform: rotate(360deg);
            background: #0098cb;}
    }




    .sendButton{
        float: left;
        outline:none;
        padding:10%;
        padding-top: 10px;
        padding-bottom: 10px;
        background: #0098cb;
        color: #f5f5f5;

        border-radius:3px;
        border:0px;
        margin:20px 20px 20px 20px;
        text-align: center;
        resize: none;
        cursor: pointer;

        transition: 0.5s color ease;
        transition: 0.5s background ease;
    }
    .sendButton:hover{
        background: #f5f5f5;
        color: #0098cb;
        -webkit-animation:background 1s;
        -o-animation:background 1s;
        animation:background 1s;
        -webkit-animation:color 1s;
        -o-animation:color 1s;
        animation:color 1s;
        -webkit-transition: 1s ease;
        -moz-transition: 1s ease;
        -ms-transition: 1s ease;
        -o-transition: 1s ease;
        transition: 1s ease;

    }


</style>