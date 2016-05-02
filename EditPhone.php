<?php
require'Assets/include/loggedfilter.php';
if(!class_exists('PhoneRepository')){
    include 'Assets/Repository/PhoneRepository.php';
}
if(!empty($_POST['number'])&&!empty($_POST['type'])) {
    $repo= new PhonesRepository();
    $phone = new Phone();
    $phone->Number=$_POST['number'];
    $phone->PhoneType=$_POST['type'];
    $phone->ContactID=$_GET['ID'];
    $phone->ID=$_GET['NID'];
    $repo->Update($phone);
}


?>


<html>
<head>
    <?php include "Header.php";?>
</head>
<body>
<br/>
<br/>

<form action="CreatePhone.php?ID=<?php echo $_GET['ID']; ?>&NID=<?php echo $_GET['NID'];?>" method="POST">
    <?php
    $rep= new PhonesRepository();
    $id = $_GET['NID'];
    $phone=$rep->GetByID($id);

    $number=$phone['Number'];
    $type=$phone['Type'];

    echo "<input type='text' placeholder='Number: $number' name='number'>";
    ?>
    <select name="type" id ="drop">
        <option value="Work" <?php if($type=='Work'){echo " selected='selected' ";};?>>Work</option>
        <option value="Home" <?php if($type=='Home'){echo " selected='selected' ";};?>>Home</option>
        <option value="Office" <?php if($type=='Office'){echo " selected='selected' ";};?>>Office</option>
     </select>


    <div>
        <button type="submit" class="submit">Submit</button>
        <a href="Phones.php?ID=<?php echo $_GET['ID']; ?>" class="cancel">Cancel</a>
    </div>

</form>
</body>
</html>
