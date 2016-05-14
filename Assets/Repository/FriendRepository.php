<?php
include 'Assets/include/database.php';
include 'Models/Friend.php';


class FriendRepository{

    public function Add(Friend $Friend){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="INSERT INTO friends (UserID_1,UserID_2) VALUES (:usr1,:usr2)";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':usr1',$Friend->UserID_1);
        $stmt->bindParam(':usr2',$Friend->UserID_2);
        $stmt->execute();
    }

    public function Delete($id,$frID){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="DELETE FROM friends WHERE UserID_1 = :id and UserID_2=:frid or friends.UserID_1=:frid and UserID_2=:id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':frid',$frID);
        $stmt->execute();
    }
    public function DeleteByID($id){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="DELETE FROM friends WHERE ID like :id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
    }
    public function GetByID($id){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="SELECT * FROM friends WHERE ID = :id";
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

    public function Update(Friend $Friend){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="UPDATE friends SET UserID_1=:usr1,UserID_2=:usr2 Where ID = :id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':usr1',$Friend->UserID_1);
        $stmt->bindParam(':usr2',$Friend->UserID_2);
        $stmt->bindParam(':id',$Friend->ID);

        $stmt->execute();
    }
    public  function AcceptFriend($id){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="UPDATE friends SET Accepted=:acc Where ID = :id";
        $stmt=$pdo->prepare($sql);
        $yes='Y';
        $stmt->bindParam(':acc',$yes);
        $stmt->bindParam(':id',$id);

        $stmt->execute();
    }

}