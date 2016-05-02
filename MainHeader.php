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
    <div class="dropdown2">
        <li><a href="Inbox.php" class="dropbtn">Inbox</a> </li>
        <div class="dropdown-content">
            <a href="Inboxpt2.php">Inbox V2</a>
            <a href="SentMessage.php">Messages Sent</a>
            <a href="SendMessage.php">Send Message</a>
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

