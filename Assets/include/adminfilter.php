<?php
session_start();
if(!isset($_SESSION['user_id'])){
    set_include_path("D:/Coding/Xamp/htdocs/auth");
    $rep = new UserRepository();
    $user= new User();
    if(($user=$rep->GetByID($_SESSION['user_id']))!=null){
        if($user['Admin']=='Y'){
            header("Location: Admin.php");
        }
        else{
            header("Location: Index.php");
        }
    }
    else{
        header("Location: Index.php");
    }

}