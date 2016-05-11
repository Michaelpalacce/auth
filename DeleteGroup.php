<?php
set_include_path('D:/Coding/Xamp/htdocs/auth');
require 'Assets/Repository/GroupRepository.php';
$group= new GroupRepository();
$id = $_POST["value"];
$gr=$group->GetByID($id);
if($gr->ImagePath!='GroupImages/default.png'){
    unlink($gr->ImagePath);
}
$group->Delete($id);