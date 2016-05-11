<?php

set_include_path('D:/Coding/Xamp/htdocs/auth');
require 'Models/User.php';

class UserRepository
{
    public function Add(User $User){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="INSERT INTO users (Email,Password,Name,ImagePath,Phone,Website,Birthday,Admin,Hash,Reset) VALUES (:email,:password,:name,:imagepath,:phone,:website,:birthday,:admin,:hash,:reset)";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':email',$User->Email);
        $stmt->bindParam(':password',$User->Password);
        $stmt->bindParam(':name',$User->Name);
        $stmt->bindParam(':imagepath',$User->ImagePath);
        $stmt->bindParam(':phone',$User->Phone);
        $stmt->bindParam(':website',$User->Website);
        $stmt->bindParam(':birthday',$User->Birthday);
        $stmt->bindParam(':admin',$User->Admin);
        $stmt->bindParam(':hash',$User->Hash);
        $stmt->bindParam(':reset',$User->Reset);
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
            $User = new User();
            $User->ID=$results['ID'];
            $User->Email=$results['Email'];
            $User->Password=$results['Password'];
            $User->Name=$results['Name'];
            $User->ImagePath=$results['ImagePath'];
            $User->Phone=$results['Phone'];
            $User->Website=$results['Website'];
            $User->Birthday=$results['Birthday'];
            $User->Admin=$results['Admin'];
            $User->Hash=$results['Hash'];
            $User->Reset=$results['Reset'];
            return $User;
        }
        else{
            return null;
        }

    }
    public  function  ChangePass(User $User){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="UPDATE `users` SET `Email` = :email, `Password` = :password, `Name` = :name, `ImagePath` = :imagepath, `Phone` = :phone, `Website` = :website, `Birthday` = :birthday, `Admin` = :admin WHERE `users`.`ID` = :id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':email',$User->Email);
        $stmt->bindParam(':password',$User->Password);
        $stmt->bindParam(':name',$User->Name);
        $stmt->bindParam(':imagepath',$User->ImagePath);
        $stmt->bindParam(':phone',$User->Phone);
        $stmt->bindParam(':website',$User->Website);
        $stmt->bindParam(':birthday',$User->Birthday);
        $stmt->bindParam(':admin',$User->Admin);
        $stmt->bindParam(':id',$User->ID);
        $stmt->execute();
    }

    public function GetByEmail($email){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="SELECT * FROM users WHERE Email =:email";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':email',$email);
        $stmt->execute();
        $results=$stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($results)){
            $User = new User();
            $User->ID=$results['ID'];
            $User->Email=$results['Email'];
            $User->Password=$results['Password'];
            $User->Name=$results['Name'];
            $User->ImagePath=$results['ImagePath'];
            $User->Number=$results['Phone'];
            $User->Website=$results['Website'];
            $User->Birthday=$results['Birthday'];
            $User->IsAdmin=$results['Admin'];
            $User->Hash=$results['Hash'];
            $User->Reset=$results['Reset'];
            return $User;
        }
        else{
            return null;
        }

    }
    public function GetByHash($hash){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="SELECT * FROM users WHERE Hash = :Hash";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':Hash',$hash);
        $stmt->execute();
        $results=$stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($results)){
            $User = new User();
            $User->ID=$results['ID'];
            $User->Email=$results['Email'];
            $User->Password=$results['Password'];
            $User->Name=$results['Name'];
            $User->ImagePath=$results['ImagePath'];
            $User->Phone=$results['Phone'];
            $User->Website=$results['Website'];
            $User->Birthday=$results['Birthday'];
            $User->Admin=$results['Admin'];
            $User->Hash=$results['Hash'];
            $User->Reset=$results['Reset'];
            return $User;
        }
        else{
            return null;
        }
    }
    public function GetByReset($res){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="SELECT * FROM users WHERE Reset = :res";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':res',$res);
        $stmt->execute();
        $results=$stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($results)){
            $User = new User();
            $User->ID=$results['ID'];
            $User->Email=$results['Email'];
            $User->Password=$results['Password'];
            $User->Name=$results['Name'];
            $User->ImagePath=$results['ImagePath'];
            $User->Phone=$results['Phone'];
            $User->Website=$results['Website'];
            $User->Birthday=$results['Birthday'];
            $User->Admin=$results['Admin'];
            $User->Hash=$results['Hash'];
            $User->Reset=$results['Reset'];
            return $User;
        }
        else{
            return null;
        }
    }

    public function Reset(User $User){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="UPDATE `users` SET `Reset` = '-',`Password`=:pass WHERE `ID` = :id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$User->ID);
        $stmt->bindParam(':pass',$User->Password);
        $stmt->execute();
    }
    public function Verify(User $User){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="UPDATE `users` SET `Hash` = '-' WHERE `ID` = :id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$User->ID);
        $stmt->execute();
    }

    public function Update(User $User){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="UPDATE `users` SET `Email` = :email, `Password` = :password, `Name` = :name, `ImagePath` = :imagepath, `Phone` = :phone, `Website` = :website, `Birthday` = :birthday, `Admin` = :admin , `Reset` = :reset , `Hash` = :hash  WHERE `users`.`ID` = :id";
        $stmt=$pdo->prepare($sql);

        $stmt->bindParam(':email',$User->Email);
        $stmt->bindParam(':password',$User->Password);
        $stmt->bindParam(':name',$User->Name);
        $stmt->bindParam(':imagepath',$User->ImagePath);
        $stmt->bindParam(':phone',$User->Phone);
        $stmt->bindParam(':website',$User->Website);
        $stmt->bindParam(':birthday',$User->Birthday);
        $stmt->bindParam(':admin',$User->Admin);
        $stmt->bindParam(':hash',$User->Hash);
        $stmt->bindParam(':reset',$User->Reset);
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
        $stmt->bindParam(':phone',$User->Phone);
        $stmt->bindParam(':website',$User->Website);
        $stmt->bindParam(':birthday',$User->Birthday);
        $stmt->bindParam(':id',$User->ID);
        $stmt->execute();
    }

}