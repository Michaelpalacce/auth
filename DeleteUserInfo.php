<?php
function DeleteLeft($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            unlink($dir."/".$object);
        }
        reset($objects);
        rmdir($dir);
    }
}
include "Assets/include/loggedfilter.php";
set_include_path('D:/Coding/Xamp/htdocs/auth');
require 'Assets/Repository/UserRepository.php';
$user= new UserRepository();
$id = $_GET["ID"];
$us=$user->GetByID($id);

$imageDir='UserPhotos/'.$us->Email;
$GroupImages='GroupImages/'.$us->Email;
$ContactImages='Images/'.$us->Email;
$ContactImages='Images/'.$us->Email;

if(is_dir($imageDir)){
    DeleteLeft($imageDir);
}
if(is_dir($GroupImages)){
    DeleteLeft($GroupImages);
}
if(is_dir($ContactImages)){
    DeleteLeft($ContactImages);
}

$user->Delete($id);
require 'Logout.php';