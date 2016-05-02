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
    $repo->Add($phone);
}


?>


<html>
<head>
    <?php include"Header.php"?>
</head>
<body>
<br/>
<br/>

<form action="CreatePhone.php?ID=<?php echo $_GET['ID']?>" method="POST">
    <input type="text" placeholder="Number" name="number">
    <select name="type" id ="drop">
        <option value="Work">Work</option>
        <option value="Home">Home</option>
        <option value="Office">Office</option>
    </select>
    <div>
        <button type="submit" class="submit">Submit</button>
        <a href="Phones.php?ID=<?php echo $_GET['ID']; ?>" class="cancel">Cancel</a>
    </div>

</form>
</body>
</html>
