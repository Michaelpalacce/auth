<?php
include "Assets/include/loggedfilter.php";
if(!isset($_SESSION)){
    session_start();
}
$id=$_SESSION['user_id'];
$Day=$_GET['Day'];
$Month=$_GET['Month'];
$Year=$_GET['Year'];
?>

<html>
<head>
<?php include "Header.php"?>
</head>
<body>
<div>
    <a href="Calendar.php" class="CreateButton" style="margin: 20px 20px 20px 20px; float: right;"><span>Go Back</span></a>
    <a href="CreateEvent.php?Day=<?=$Day?>&Month=<?=$Month?>&Year=<?=$Year?>" class="CreateButton" style="margin: 20px 20px 20px 20px;"><span>Create Event</span></a>
</div>


<div class="Event-container">
    <?php

    $records =$pdo->prepare("SELECT * FROM events WHERE UserId=:id and Year = :year and Month =:month and Day=:day order by TimeCreated ASC");
    $records->bindParam(':id',$id);
    $records->bindParam(':day',$Day);
    $records->bindParam(':month',$Month);
    $records->bindParam(':year',$Year);
    $records->execute();
    while($results=$records->fetch(PDO::FETCH_ASSOC)) {
        $UserID=$results['UserID'];
        $Email=$results['Email'];
        $Hour=$results['Hour'];
        $Duration=$results['Duration'];
        $Day=$results['Day'];
        $Month=$results['Month'];
        $Year=$results['Year'];
        $TimeCreated=$results['TimeCreated'];
        $Title=$results['Title'];
        $Description=$results['Description'];
        $EventID=$results['ID'];

        echo " <div class='event' style='background: #eee;'>
       <div class='title-row'>
            <div class='title'>
                <span>Title: $Title</span>
            </div>

              <div class='event-row'>
            <div class='description'>
                <span>Description: $Description</span>
            </div>

           <div class='time'>
               <span>Time: $Hour $Day/$Month/$Year</span>
           </div>
           <div class='links'>
           <button class='but1edit' value='$EventID'><span><i class='fa fa-pencil' aria-hidden='true'></i> Edit</span></button>
           <button class='but1del' value='$EventID'><i class='fa fa-trash' aria-hidden='true'></i> Delete</span></button>
           </div>
       </div>
       </div>
    </div>";
    }
    ?>
</body>
</html>
<link rel="stylesheet" href="font-awesome-4.6.2/css/font-awesome.min.css">
<script src="Assets/js/jquery.min.js"></script>
<script>
    $('.but1edit').click(function () {
        var val= $(this).val();
        $.ajax({
            type: 'POST',
            url: 'Assets/Cookies/EditCookie.php',
            data:{value:val},
            success: function(data) {
                window.location.href="EditEvent.php";
            }
        });
    });
    $('.but1del').click(function () {
        var me=$(this).val();
        var parent=$(this).parent().parent().parent().parent();
        $.ajax({
            type: 'POST',
            url: 'DeleteEvent.php',
            data:{value:me},
            success: function(data) {
                parent.animate({height: 'toggle'},'slow');
            }
        });

    });
</script>
<style>

    .Event-container {
        width:80%;
        margin:auto;
        margin-top: 80px;
        max-height:50%;
    }
/*00CBBE*/
    .event{
        width:50%;
        color: #222;
        display: block;

        padding:25px;
        margin: 20px auto;
        margin-top: 10px;
        font-family: arial,sans-serif;
        cursor: pointer;
    }
    .event-row{
        padding:10px;
        max-height:0px;
        opacity:0;

    }
    .event:hover .event-row{
        display: block;
        visibility: visible;
        max-height:500px;
        opacity:1;
        transition:1s ease-in-out;
    }
    .event-row:hover{
        display: block;
        visibility: visible;
        max-height:500px;
        opacity:1;
        transition:1s ease-in-out;
    }

</style>
