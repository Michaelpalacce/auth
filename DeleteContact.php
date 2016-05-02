<?php
set_include_path('D:/Coding/Xamp/htdocs/auth');
require 'Assets/Repository/ContactRepository.php';
$contact= new ContactsRepository();
$id = $_GET["ID"];
$con=$contact->GetByID($id);
if($con['ImagePath']!='Images/default.png'){
    unlink($con['ImagePath']);
}

$contact->Delete($id);
header('Location: Contacts.php');