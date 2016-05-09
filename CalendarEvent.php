<?php
if(!isset($_SESSION)){
    session_start();
}
$id=$_SESSION['user_id'];
?>

<html>
<head>
<?php include "Header.php"?>
</head>
<body>
<a href="Calendar.php" class="CreateButton" style="margin: 20px 20px 20px 20px;"><span>Go Back</span></a>

<div class="Event-container">
    <?php
    $Day=$_GET['Day'];
    $Month=$_GET['Month'];
    $Year=$_GET['Year'];
    $records =$pdo->prepare("Select * from events where UserID like :id and Day like :Day and Month like :Month and Year like :Year ORDER BY TimeCreated DESC");
    $records->bindParam(':id',$id);
    $records->bindParam(':Day',$Day);
    $records->bindParam(':Month',$Month);
    $records->bindParam(':Year',$Year);
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
       </div>
       <div class='event-row'>

            <div class='description'>
                <span>Description: $Description</span>
            </div>

           <div class='time'>
               <span>Time: $Hour $Day/$Month/$Year</span>
           </div>

           <div class='links'>
           <a href='EditEvent.php?ID=$EventID' class='but2'>Edit</a><a href='DeleteEvent.php?ID=$EventID' class='but2' style='color: #FF0002;'>Delete</a>
           </div>
       </div>
    </div>";

    }
    ?>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script>
    $('.event').click(function() {
        var $this = $(this);

        if ($this.hasClass("hidden")) {
            $(this).removeClass("hidden").addClass("visible");

        } else {
            $(this).removeClass("visible").addClass("hidden");
        }
    });
</script>
<style>

    .Event-container {
        width:80%;
        margin:auto;
        margin-top: 10px;
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
        transition:.4s ease-in-out;
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
