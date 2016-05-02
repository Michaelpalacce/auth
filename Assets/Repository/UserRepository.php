<?php

set_include_path('D:/Coding/Xamp/htdocs/auth');
require 'Models/User.php';

class UserRepository
{
    public function Add(User $User){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="INSERT INTO users (Email,Password,Name,ImagePath,Phone,Website,Birthday,Admin) VALUES (:email,:password,:name,:imagepath,:number,:website,:birthday,:admin)";
        $stmt=$pdo->prepare($sql);

        $stmt->bindParam(':email',$User->Email);
        $stmt->bindParam(':password',$User->Password);
        $stmt->bindParam(':name',$User->Name);
        $stmt->bindParam(':imagepath',$User->ImagePath);
        $stmt->bindParam(':number',$User->Number);
        $stmt->bindParam(':website',$User->Website);
        $stmt->bindParam(':birthday',$User->Birthday);
        $stmt->bindParam(':admin',$User->IsAdmin);
        $stmt->execute();
    }

    public function Delete($id){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="DELETE FROM users WHERE ID=:id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
    }
    public function GetByID($id){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="SELECT * FROM users WHERE ID = :id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $results=$stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($results)){
            return $results;
        }
        else{
            return null;
        }

    }

    public function Update(User $User){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="UPDATE `users` SET `Email` = :email, `Password` = :password, `Name` = :name, `ImagePath` = :imagepath, `Phone` = :phone, `Website` = :website, `Birthday` = :birthday, `Admin` = :admin  WHERE `users`.`ID` = :id";
        $stmt=$pdo->prepare($sql);

        $stmt->bindParam(':email',$User->Email);
        $stmt->bindParam(':password',$User->Password);
        $stmt->bindParam(':name',$User->Name);
        $stmt->bindParam(':imagepath',$User->ImagePath);
        $stmt->bindParam(':phone',$User->Number);
        $stmt->bindParam(':website',$User->Website);
        $stmt->bindParam(':birthday',$User->Birthday);
        $stmt->bindParam(':admin',$User->IsAdmin);
        $stmt->bindParam(':id',$User->ID);
        $stmt->execute();
    }

    public function UpdateSec(User $User){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="UPDATE `users` SET `Name` = :name, `ImagePath` = :imagepath, `Phone` = :phone, `Website` = :website, `Birthday` = :birthday WHERE `ID` = :id";
        $stmt=$pdo->prepare($sql);

        $stmt->bindParam(':name',$User->Name);
        $stmt->bindParam(':imagepath',$User->ImagePath);
        $stmt->bindParam(':phone',$User->Number);
        $stmt->bindParam(':website',$User->Website);
        $stmt->bindParam(':birthday',$User->Birthday);
        $stmt->bindParam(':id',$User->ID);
        $stmt->execute();
    }

}