<?php
set_include_path('D:/Coding/Xamp/htdocs/auth');
require 'Models/Group.php';
class GroupRepository
{
    public function Add(Group $Group){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="INSERT INTO groups (Name,UserID,ImagePath) VALUES (:Name,:UserID,:ImagePath)";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':Name',$Group->Name);
        $stmt->bindParam(':ImagePath',$Group->ImagePath);
        $stmt->bindParam(':UserID',$_SESSION['user_id']);
        if($stmt->execute()){
            echo "Group Has Been Added Successfully!";
        }
        else{
            echo "Group Could Not Be Added!";
        }
    }

    public function Delete($id){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="DELETE FROM groups WHERE ID = :id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
    }
    public function GetByID($id){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="SELECT * FROM groups WHERE ID = :id ";
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
    public function GetByName($Name){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="SELECT * FROM groups WHERE Name = :name ";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':name',$Name);
        $stmt->execute();
        $results=$stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($results)){
            return $results;
        }
        else{
            return null;
        }
    }

    public function Update(Group $Group){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="UPDATE groups SET Name=:name, UserID=:userID, ImagePath=:imagePath Where ID = :id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':name',$Group->Name);
        $stmt->bindParam(':userID',$Group->UserID);
        $stmt->bindParam(':imagePath',$Group->ImagePath);
        $stmt->bindParam(':id',$Group->ID);
        $stmt->execute();
    }

}
