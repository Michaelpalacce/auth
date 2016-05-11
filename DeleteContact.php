<?php
set_include_path('D:/Coding/Xamp/htdocs/auth');
if(!class_exists('ContactRepository')){
    require 'Assets/Repository/ContactRepository.php';
}
$contact= new ContactsRepository();
$id = $_POST["value"];
$con=$contact->GetByID($id);
if($con->ImagePath!='Images/default.png'){
    unlink($con->ImagePath);
}
$contact->Delete($id);