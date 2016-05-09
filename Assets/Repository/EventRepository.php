<?php

set_include_path('D:/Coding/Xamp/htdocs/auth');
require 'Models/Event.php';

class EventRepository
{
    public function Add(Event $Event){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="INSERT INTO events(UserID,Email,Hour,Day,Duration,Month,Year,TimeCreated,Title,Description) VALUES (:UserID,:Email,:Hour,:Day,:Duration,:Month,:Year,:TimeCreated,:Title,:Description)";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':UserID',$Event->UserID);
        $stmt->bindParam(':Email',$Event->Email);
        $stmt->bindParam(':Hour',$Event->Hour);
        $stmt->bindParam(':Duration',$Event->Duration);
        $stmt->bindParam(':Day',$Event->Day);
        $stmt->bindParam(':Month',$Event->Month);
        $stmt->bindParam(':Year',$Event->Year);
        $stmt->bindParam(':TimeCreated',$Event->TimeCreated);
        $stmt->bindParam(':Title',$Event->Title);
        $stmt->bindParam(':Description',$Event->Description);
        $stmt->execute();
    }

    public function Delete($id){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="DELETE FROM events WHERE ID=:id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
    }
    public function GetByID($id){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="SELECT * FROM events WHERE ID = :id";
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

    public function Update(Event $Event){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="UPDATE `events` SET `UserID` = :UserID, `Email` = :Email, `Hour` = :Hour, `TimeCreated` = :TimeCreated, `Title` = :Title, `Description` = :Description, `Duration` = :Duration, `Day` = :Day, `Month` = :Month, `Year` = :Year WHERE `events`.`ID` = :id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':UserID',$Event->UserID);
        $stmt->bindParam(':Email',$Event->Email);
        $stmt->bindParam(':Hour',$Event->Hour);
        $stmt->bindParam(':Duration',$Event->Duration);
        $stmt->bindParam(':Day',$Event->Day);
        $stmt->bindParam(':Month',$Event->Month);
        $stmt->bindParam(':Year',$Event->Year);
        $stmt->bindParam(':TimeCreated',$Event->TimeCreated);
        $stmt->bindParam(':Title',$Event->Title);
        $stmt->bindParam(':Description',$Event->Description);
        $stmt->bindParam(':id',$Event->ID);
        $stmt->execute();
    }
}