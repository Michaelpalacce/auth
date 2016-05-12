<?php
require'Assets/include/loggedfilter.php';
?>
<html>
<head>
    <title>Contact Manager</title>
    <?php include "Header.php";?>
</head>
<body>
<br/>
<br/>
<br/>
<?php
if(!class_exists('UserRepository')){
    include 'Assets/Repository/UserRepository.php';
}
$repo= new UserRepository();
$user=new User();
$user=$repo->GetByID($_SESSION['user_id']);
$name=$user->Name;
$image=$user->ImagePath;
?>
<img src="<?php echo  $image;?>" alt="Image" width="250" height="250" id="img">
<br/>
<br/>
<span style="font-size: 30px; color: #f5f5f5;">
    Welcome, <?php echo $name;?>!
</span>
<div class="Agenda">
    <?php
    $records =$pdo->prepare("SELECT * FROM events WHERE UserId=:id and Year >= :year and Month >=:month and Day>=:day and Hour >=:hour order by Hour ASC ");
    $hour=date("H:i");
    $year=date("Y");
    $month=date("m");
    $day=date("d");

    $records->bindParam(':id',$_SESSION['user_id']);
    $records->bindParam(':hour',$hour);
    $records->bindParam(':year',$year);
    $records->bindParam(':month',$month);
    $records->bindParam(':day',$day);
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


    echo "<div class='event'>
        <div class='title'>
            <span>Title:$Title</span>
        </div>
        <div class='description' style='display: none;'>
        <span>Description:$Description</span>

        <div class='time'>
         <span>Time: $Hour $Day/$Month/$Year</span>
        </div>
        </div>
    </div>";
    }
    ?>
</div>
</body>
</html>
<script src="Assets/js/jquery.min.js"></script>
<script>
    $('.event').click(function(){
        $(this).children().next().animate({ height: 'toggle'},'slow');
    });
</script>
<style>
    .Agenda{
        overflow: visible;
    }
    .event{
        transition: .5s ease-in-out;
        width:40%;
        margin:20px auto;
        background: White;
        visibility: visible;
        display: block;
    }
    /*Optional transition!*/
    .title{
        padding:20px 20px;
        transition: .5s ease-in-out;
    }
    .description{
        padding:0px 20px;
    }
    .time{
        padding-top:20px;
    }
    #img{
        transition: 1s ease;
        -webkit-border-radius:50%;
        -moz-border-radius:50%;
        border-radius:50%;
        box-shadow: 5px 5px 2px #888888;
    }
    #img:hover{
        -webkit-transform: scale(1.2);
        -ms-transform: scale(1.2);
        transform: scale(1.2);
        transition: 1s ease;
    }

</style>