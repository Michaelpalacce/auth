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
            $rep = new UserRepository();
            $user= new User();
            if(($user=$rep->GetByID($_SESSION['user_id']))!=null){
                if($user['Admin']=='Y'){
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
        <li><a href="Groups.php" class="dropbtn">Groups</a> </li>
        <div class="dropdown-content">
            <a href="CreateGroup.php">Create Group</a>
        </div>
    </div>
    <div class="dropdown2">
        <li><a href="Contacts.php" class="dropbtn">Contacts</a> </li>
        <div class="dropdown-content">
            <a href="CreateContact.php">Create Contact</a>
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
    $records =$pdo->prepare("select DISTINCT messages.ID,Sender,Recieved,TimeRecieved,TimeSent, Message, users.ImagePath,users.Email,users.Name from messages inner join users on Sender = users.ID
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
        <li style="color: white; cursor:default;">Mail <div style="width: 11px; height: 11px; color: red; float: right; margin-left: 2px; font-size: 11px;"><?=$count?></div></li>
        <div class="dropdown-content">
            <a href="Inboxpt2.php" class="dropbtn">Inbox</a>
            <a href="SentMessagept2.php">Outbox</a>
            <a href="SendMessage.php">New Message</a>
<!--            <a href="Inbox.php">Inbox(old)</a>-->
<!--            <a href="SentMessage.php">Messages Sent(old)</a>-->

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

