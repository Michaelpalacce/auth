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
    public function DeleteForSender($id){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="SELECT * FROM messages WHERE ID= :id ";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();

        while($results=$stmt->fetch(PDO::FETCH_ASSOC)){

            if($results['DeletedByReciever']=="Y"){

                $this->Delete($id);
            }
            else{
                $mes=$this->GetByID($id);
                $Message=new Message();
                $Message->Reciever=$mes['Reciever'];
                $Message->Sender=$mes['Sender'];
                $Message->Message=$mes['Message'];
                $Message->TimeSent=$mes['TimeSent'];
                $Message->DeletedByReciever=$mes['DeletedByReciever'];
                $Message->DeletedBySender='Y';
                $Message->Recieved=$mes['Recieved'];
                $Message->ID=$mes['ID'];
                $this->Update($Message);
            }
        }
    }
    public function DeleteForReciever($id){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="SELECT * FROM messages WHERE ID= :id ";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        while($results=$stmt->fetch(PDO::FETCH_ASSOC)){
            if($results['DeletedBySender']=="Y"){
                $this->Delete($id);
            }
            else{
                $mes=$this->GetByID($id);
                $Message=new Message();
                $Message->Reciever=$mes['Reciever'];
                $Message->Sender=$mes['Sender'];
                $Message->Message=$mes['Message'];
                $Message->TimeSent=$mes['TimeSent'];
                $Message->DeletedByReciever='Y';
                $Message->DeletedBySender=$mes['DeletedBySender'];
                $Message->Recieved=$mes['Recieved'];
                $Message->ID=$mes['ID'];
                $this->Update($Message);
            }
        }
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
        $sql="UPDATE messages SET Reciever=:Reciever, Sender=:Sender, Message=:Message,TimeSent=:TimeSent,DeletedByReciever=:DeletedByReciever,DeletedBySender=:DeletedBySender,Recieved=:Recieved Where ID = :id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':Reciever',$Message->Reciever);
        $stmt->bindParam(':Sender',$Message->Sender);
        $stmt->bindParam(':Message',$Message->Message);
        $stmt->bindParam(':TimeSent',$Message->TimeSent);
        $stmt->bindParam(':DeletedByReciever',$Message->DeletedByReciever);
        $stmt->bindParam(':DeletedBySender',$Message->DeletedBySender);
        $stmt->bindParam(':Recieved',$Message->Recieved);
        $stmt->bindParam(':id',$Message->ID);
        $stmt->execute();
    }
}