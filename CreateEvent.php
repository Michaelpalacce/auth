<?php
include "Assets/Repository/EventRepository.php";
include "Assets/include/database.php";
if(!isset($_SESSION)){
    session_start();
}
if(!empty($_POST['title'])&&!empty($_POST['date'])&&!empty($_POST['time'])&&!empty($_POST['duration'])&&!empty($_POST['description'])){
    $Title=$_POST['title'];
    $Date=$_POST['date'];
    $day;
    $month;
    $year;
    list($month, $day, $year) = split('[/]', $Date);
    $zero='0';
    if(substr($day, 0, 1) === '0'){
        $day=substr($day,1,1);
    }
    if(substr($month, 0, 1) === '0'){
        $month=substr($month,1,1);
    }
    $Time=$_POST['time'];
    $Duration=$_POST['duration'];
    $description=$_POST['description'];
    $repo= new EventRepository();
    $event=new Event();
    $event->UserID=$_SESSION['user_id'];
    $event->Hour=$Time;
    $event->Day=$day;
    $event->Month=$month;
    $event->Year=$year;
    $event->Duration=$Duration;
    $event->TimeCreated= date('m/d/Y h:i', time());
    $event->Email=$_SESSION['Email'];
    $event->Description=$description;
    $event->Title=$Title;
    $repo->Add($event);
}
?>

<html>
<head>
<?php include "Header.php";?>
    <link href="Assets/CSS/jquery.timepicker.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="CreateEvent.php" method="post" enctype="multipart/form-data">
    <div class="ev">
        <input type="text" class="title" placeholder="Title:" name="title">
        <input type="text" class="datepicker" placeholder="Pick Date:" name="date">
    <div>
        <input type="text" class="choosers" id="time-start" placeholder="Time:" name="time"/>
        <input type="text" id="duration" placeholder="Duration:" name="duration"/>
    </div>
        <br/>
        <textarea placeholder="Description:" class="description" name="description" ></textarea>
        <br/>
        <input type="submit" class="sub">
    </div>
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