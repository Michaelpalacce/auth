<?php

set_include_path('D:/Coding/Xamp/htdocs/auth');
require 'Models/Phone.php';
class PhonesRepository
{
    public function Add(Phone $Phone){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="INSERT INTO numbers (ContactID, Number ,Type) VALUES (:contactID,:number,:type)";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':number',$Phone->Number);
        $stmt->bindParam(':type',$Phone->PhoneType);
        $stmt->bindParam(':contactID',$Phone->ContactID);
        $stmt->execute();
    }

    public function Delete($id){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="DELETE FROM numbers WHERE ID=:id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
    }
    public function GetByID($id){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="SELECT * FROM numbers WHERE ID = :id";
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

    public function Update(Phone $Phone){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="UPDATE numbers SET Number=:number,Type=:type Where ID = :id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':number',$Phone->Number);
        $stmt->bindParam(':type',$Phone->PhoneType);
        $stmt->bindParam(':id',$Phone->ID);
        $stmt->execute();
    }
}