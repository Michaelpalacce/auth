<?php
set_include_path('D:/Coding/Xamp/htdocs/auth');
require 'Models/Message.php';
class MessageRepository
{
    public function Add(Message $Message){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="INSERT INTO messages (Sender,Reciever,Message,TimeSent) VALUES (:Sender,:Reciever,:Message,:TimeSent)";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':Sender',$Message->Sender);
        $stmt->bindParam(':Reciever',$Message->Reciever);
        $stmt->bindParam(':Message',$Message->Message);
        $date = date('m/d/Y h:i:s a');
        $stmt->bindParam(':TimeSent',$date);

        if($stmt->execute()){
            echo "Message Has Been Sent Successfully!";
        }
        else{
            echo "Message Could Not Be Sent!";
        }
    }

    public function Delete($id){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="DELETE FROM messages WHERE ID = :id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
    }
    public function GetByID($id){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="SELECT * FROM messages WHERE ID = :id ";
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

    public function Update(Message $Message){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="UPDATE messages SET Reciever=:Reciever, Sender=:Sender, Message=:Message,TimeRecieved=:TimeRecieved,TimeSent=:TimeSent,DeletedByReciever=:DeletedByReciever,DeletedBySender=:DeletedBySender,Recieved=:Recieved Where ID = :id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':Reciever',$Message->Reciever);
        $stmt->bindParam(':Sender',$Message->Sender);
        $stmt->bindParam(':Message',$Message->Message);
        $stmt->bindParam(':TimeRecieved',$Message->TimeRecieved);
        $stmt->bindParam(':TimeSent',$Message->TimeSent);
        $stmt->bindParam(':DeletedByReciever',$Message->DeletedByReciever);
        $stmt->bindParam(':DeletedBySender',$Message->DeletedBySender);
        $stmt->bindParam(':Recieved',$Message->Recieved);
        $stmt->bindParam(':id',$Message->ID);
        $stmt->execute();
    }

}
