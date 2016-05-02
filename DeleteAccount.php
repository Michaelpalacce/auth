<?php

?>
<html>
<head>
    <?php include "AccountHeader.php";?>

</head>
<body>

<form action="DeleteUserInfo.php?ID=<?php echo $_SESSION['user_id'];?>" method="POST" enctype="multipart/form-data">
    <div class="co">
        <br/>
        <br/>
        <br/>
        <br/>

        <div class="terms" style="font-size: 20px; color: #f5f5f5;">
            Do you want to delete your account?
            <br/>
            This will delete all your data.
            <br/>
            This action cannot be reversed!
        </div>
        <button type="submit" class="submit">Delete</button>
    </div>


</form>
</body>
</html>
<style>
    .co{
        display: inline-block;
        text-align: center;
    }
    .terms{
        outline: none;
        padding: 0px;
        display: block;
        width: 300px;
        border-radius: 3px;
        margin-top: 20px;
        margin-left: 60px;
    }
    .container2{
        width:1030px;
        min-height:482px;
        border-left:2px solid #dddddd;
        text-align: center;
    }
    input[type="text"],input[type="password"] {
        outline: none;
        padding: 10px;
        display: block;
        width: 300px;
        border-radius: 3px;
        border: 1px solid #eee;
        margin: 20px 20px 20px 20px;
        display: block;
    }
    .submit{
        background:#FF0002;
        padding:10px;
        color:#fff;
        float: left;
        width:160px;
        margin:20px 135px;
        margin-top:40px;
        border:0px;
        border-radius:0px;
        cursor: pointer;
        text-decoration: none;
    }
</style>