<?php
if(!class_exists('MessageRepository')){
    include "Assets/Repository/MessageRepository.php";
}
if(!isset($_SESSION)){
    session_start();
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
        if($_POST['reciever']!=$_SESSION['Email']){
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
        else{
            echo 'Can not send messages to self!';
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


            <div>
                <textarea placeholder="Message" class="mess"  name="message" ></textarea>
               <div class="total">0</div> <div class="total2">(255):</div>
            </div>

            <div>
                <button type="submit" class="sendButton" id="sendButton"><span>Send</span></button>
                <div class="circle"></div>
            </div>

        </div>
    </form>
</body>
</html>
<script src="Assets/js/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        $('.mess').keyup(function() {
            $('.sendButton').prop('disabled', false);
            var value = $(this).val().length;
            if(value >= 255) {
                $('.sendButton').prop('disabled', true);
            }

            var totalChars = value;
            $('.total').html(totalChars);
        });
    });
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
    .total{
        float: right;
        margin-right: 10%;
    }
    .total2{
        float: right;

    }
    .mess{
        float: left;
        outline:none;
        padding: 10px;

        width: 90%;
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
        padding:5%;
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

        transition: 0.2s color ease;
        transition: 0.2s background ease;
    }
    .sendButton:hover{
        background: #f5f5f5;
        color: #0098cb;
        -webkit-animation:background .2s;
        -o-animation:background .2s;
        animation:background .2s;
        -webkit-animation:color .2s;
        -o-animation:color .2s;
        animation:color .2s;
        -webkit-transition: .2s ease;
        -moz-transition: .2s ease;
        -ms-transition: .2s ease;
        -o-transition: .2s ease;
        transition: .2s ease;

    }

    .sendButton span {
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: 0.5s;
    }

    .sendButton span:after {
        content: '»';
        position: absolute;
        opacity: 0;
        top: 0;
        right: -20px;
        transition: 0.5s;
    }

    .sendButton:hover span {
        padding-right: 25px;
    }

    .sendButton:hover span:after {
        opacity: 1;
        right: 0;
    }

</style>