<?php
set_include_path('D:/Coding/Xamp/htdocs/auth');
require 'Models/Contact.php';
class ContactsRepository
{
    public function Add(Contact $Contact){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="INSERT INTO contacts (FirstName,LastName,Address,ImagePath,UserID,Private) VALUES (:FirstName,:LastName,:Address,:ImagePath,:UserID,:Private)";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':FirstName',$Contact->FirstName);
        $stmt->bindParam(':LastName',$Contact->LastName);
        $stmt->bindParam(':Address',$Contact->Address);
        $stmt->bindParam(':ImagePath',$Contact->ImagePath);
        $stmt->bindParam(':Private',$Contact->Private);
        $stmt->bindParam(':UserID',$_SESSION['user_id']);
        $stmt->execute();
    }

    public function Delete($id){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="DELETE FROM contacts WHERE ID = :id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
    }
    public function GetByID($id){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="SELECT * FROM contacts WHERE ID = :id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $results=$stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($results)){
            $Contact= new Contact();
            $Contact->ID=$results['ID'];
            $Contact->FirstName=$results['FirstName'];
            $Contact->LastName=$results['LastName'];
            $Contact->Address=$results['Address'];
            $Contact->ImagePath=$results['ImagePath'];
            $Contact->UserID=$results['UserID'];
            $Contact->Private=$results['Private'];
            return $Contact;
        }
        else{
            return null;
        }
    }

    public function Update(Contact $Contact){
        set_include_path('D:/Coding/Xamp/htdocs/auth');
        require 'Assets/include/database.php';
        $sql="UPDATE contacts SET FirstName=:first,LastName=:last,Address=:address,ImagePath=:ImagePath, Private=:Private Where ID = :id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':first',$Contact->FirstName);
        $stmt->bindParam(':last',$Contact->LastName);
        $stmt->bindParam(':address',$Contact->Address);
        $stmt->bindParam(':ImagePath',$Contact->ImagePath);
        $stmt->bindParam(':Private',$Contact->Private);
        $stmt->bindParam(':id',$Contact->ID);
        $stmt->execute();
    }
}