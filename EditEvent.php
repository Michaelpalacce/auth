<?php
require 'Assets/include/loggedfilter.php';
if(!class_exists('EventRepository')){
    include 'Assets/Repository/EventRepository.php';
}
$id='';
if(!isset($_COOKIE['friend'])) {
    header('Location: Error.php');
} else {
    $id=$_COOKIE['edit'];
}
if(!empty($_POST)){
    if(!empty($_POST['title'])||!empty($_POST['date'])||!empty($_POST['time'])||!empty($_POST['duration'])||!empty($_POST['description'])){
        if(!isset($_SESSION)){
            session_start();
        }
        $day;
        $month;
        $year;
        $Date=$_POST['date'];
        list($month, $day, $year) = split('[/]', $Date);
        if(!empty($_POST['Date'])){
            $zero='0';
            if(substr($day, 0, 1) === '0'){
                $day=substr($day,1,1);
            }
            if(substr($month, 0, 1) === '0'){
                $month=substr($month,1,1);
            }
        }
        $repo= new EventRepository();
        $getter=$repo->GetByID($id);
        $event = new Event();
        $empty='';
        if(!empty($_POST['title'])){
            $event ->Title=$_POST['title'];
        }
        else{
            $event ->Title=$getter['Title'];
        }
        if(!empty($_POST['date'])){
            $event ->Day=$day;
            $event ->Month=$month;
            $event ->Year=$year;
        }
        else{
            $event ->Day=$getter['Day'];
            $event ->Month=$getter['Month'];
            $event ->Year=$getter['Year'];
        }
        if(!empty($_POST['time'])){
            $event ->Hour=$_POST['time'];
        }
        else{
            $event ->Hour=$getter['Hour'];
        }

        if(!empty($_POST['duration'])){
            $event ->Duration=$_POST['duration'];
        }
        else{
            $event ->Duration=$getter['Duration'];
        }

        if(!empty($_POST['description'])){
            $event ->Description=$_POST['description'];
        }
        else{
            $event ->Description=$getter['Description'];
        }
        $event->Email=$getter['Email'];
        $event->TimeCreated=$getter['TimeCreated'];
        $event->UserID=$getter['UserID'];
        $event ->ID=$id;
        $repo->Update($event);
    }
}
?>
<html>
<head>
    <?php include "Header.php"; ?>
</head>
<body>
<br/>
<form action='EditEvent.php' method="POST" enctype="multipart/form-data">

    <?php
    $rep= new EventRepository();
    $id=$_COOKIE['edit'];
    $event=$rep->GetByID($id);

    $Hour=$event['Hour'];
    $Duration=$event['Duration'];
    $Day=$event['Day'];
    $Month=$event['Month'];
    $Year=$event['Year'];
    $Title=$event['Title'];
    $Description=$event['Description'];

    echo "<div class='ev'>
        <input type='text' class='title' placeholder='Title: $Title' name='title'>
        <input type='text' class='datepicker' placeholder='Pick Date:' value='$Month/$Day/$Year' name='date'>
    <div>
        <input type='text' class='choosers' id='time-start' placeholder='Time: $Hour' name='time' autocomplete='on'/>
        <input type='text' id='duration' placeholder='Duration: $Duration' name='duration'/>
    </div>
        <br/>
        <textarea placeholder='Description: $Description' class='description' name='description' ></textarea>
        <br/>
        <div>
        <button type='submit' class='submit'>Submit</button>
        <a href='Calendar.php' class='cancel'>Cancel</a>
    </div>
    </div>";
    ?>


</form>
</body>
</html>
<style>
    .sub{
        margin:20px auto;
    }
    .ev{
        display: block;
        margin:20px auto;
        margin-top: 80px;
        width:90%;
    }
    .allDay{
        margin-top: 15px;
        border-radius:5px;
    }

    .description{
        outline:none;
        padding: 10px;
        width: 25%;
        height:15%;
        border-radius:3px;
        border:1px solid #eee;
        margin:20px auto;
        text-align: left;
        resize: none;
    }
</style>

<link rel="stylesheet" href="Assets/CSS/jquery-ui.css">
<script src="Assets/js/jquery-ui.js"></script>
<script src="Assets/js/jquery.timepicker.min.js"></script>
<script>
    $('.choosers').timepicker({ 'timeFormat': 'H:i','step': 15 });
    $('.datepicker').datepicker();
</script>
<style>
    td{
        background: white;
    }
</style>