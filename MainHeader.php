<?php
if(!isset($_SESSION)){
    session_start();
}
$email=$_SESSION['Email'];
?>
<ul>
    <div class="dropdown2">
        <li><a href="Home.php" class="dropbtn">Home</a> </li>
        <div class="dropdown-content">
            <a href="Index.php" class="dropbtn">Index</a>
            <?php
            set_include_path("D:/Coding/Xamp/htdocs/auth");
            if(!class_exists('UserRepository')){
                include "Assets/Repository/UserRepository.php";
            }
            $repo= new UserRepository();
            $user=new User();
            $user=$repo->GetByID($_SESSION['user_id']);
            if($user!=null){
                if($user->Admin=='Y'){
                    echo '<a href="Admin.php" class="dropbtn">Admin</a>';
                }
            }
            else{
                header("Location: Index.php");
            }
            ?>
        </div>
    </div>
    <div class="dropdown2">
        <li><a href="Contacts.php" class="dropbtn">Contacts</a> </li>
        <div class="dropdown-content">
            <a href="CreateContact.php">Create Contact</a>
            <a href="Groups.php" class="dropbtn">Groups</a>
            <a href="CreateGroup.php">Create Group</a>
        </div>
    </div>
    <div class="dropdown2">
        <li><a href="Friends.php" class="dropbtn">Friends</a> </li>
        <div class="dropdown-content">
            <a href="FindFriends.php">Find Friend</a>
        </div>
    </div>
    <?php
    include "Assets/include/database.php";
    $records =$pdo->prepare("select DISTINCT messages.ID,Sender,Recieved,TimeSent, Message, users.ImagePath,users.Email,users.Name from messages inner join users on Sender = users.ID
WHERE messages.Reciever like :id And messages.DeletedByReciever like 'N' AND messages.Recieved like 'N' ORDER BY messages.ID DESC ");
    $id = $_SESSION['user_id'];
    $records->bindParam(':id',$id);
    $records->execute();
    $count=0;
    while($results=$records->fetch(PDO::FETCH_ASSOC)) {
        $count++;
    }
    ?>
    <div class="dropdown2">
        <li style="color: white; cursor:default;">Mail<div style="width: 11px;font-weight: bold; height: 11px; color: red; float: right; margin-left: 2px; font-size: 11px;"><?=$count?></div></li>
        <div class="dropdown-content">
            <a href="Inboxpt2.php" class="dropbtn">Inbox</a>
            <a href="Outbox.php">Outbox</a>
            <a href="SendMessage.php">New Message</a>

        </div>
    </div>
    <div class="dropdown2">
        <li><a href="Calendar.php" class="dropbtn">Calendar</a> </li>
        <div class="dropdown-content">
            <a href="CreateEvent.php">Add Event</a>
        </div>
    </div>
    <div class="dropdown2">
        <span class="dropbtn"><?php echo 'Hello, '.$email.'!'?></span>
        <div class="dropdown-content">
            <a href="EditCurrentUser.php">Account</a>
            <a href="ChangePassword.php">Change Password</a>
            <a href="DeleteAccount.php">Delete Account</a>
            <a href="Logout.php">Logout</a>
        </div>
    </div>
</ul>
<div class="load"">

</div>
<script type="text/javascript" src="Assets/js/jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setInterval(function(){
            $('.load').load('Notif.php');
        },10000);
        $('.closeForNotif').click(function(){
            $('.load').hide();
        });
    });

</script>
<style>
    .active{
        visibility: visible;
    }
    .closeForNotif{
        float:right;
        border:0px;
        border-radius:4px;
        z-index: 11 ;
        background: #00b8eb;
    }
    .cont{
        opacity:0.8;
        margin-top:32%;
        margin-left:30%;
        padding:2%;
        position:absolute;
        z-index: 10;
        background: turquoise;
        border: 1px solid #eee ;
        -webkit-border-radius:5px;
        -moz-border-radius:5px;
        border-radius:5px;
        width:15%;
        display: inline-block;
        height:10%;
    }
    .cont .picture{
        margin-left:18px;
        margin-bottom:10px;
        width: 40px;
        height: 40px;
        border-radius:50%;
        box-shadow: 2px 2px 1px #888888;
    }
    .cont .notification-message{
        text-align: center;
        margin: 20px auto;
        color: #eee;

    }
</style>
