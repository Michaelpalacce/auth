
<span style="color:white;font-size: 20px">Agenda:</span>
<div class="Agenda">
    <?php
    if(!isset($_SESSION)){
        session_start();
    }
    include "Assets/include/database.php";
    $records =$pdo->prepare("SELECT * FROM events WHERE UserId=:id and Year >= :year and Month >=:month and Day>=:day order by Hour ASC");
    $hour=date("H:i");
    $year=date("Y");
    $month=date("m");
    $day=date("d");

    $records->bindParam(':id',$_SESSION['user_id']);
    $records->bindParam(':year',$year);
    $records->bindParam(':month',$month);
    $records->bindParam(':day',$day);
    $records->execute();
    while($results=$records->fetch(PDO::FETCH_ASSOC)) {
        $UserID=$results['UserID'];
        $Email=$results['Email'];
        $Duration=$results['Duration'];
        $Day=$results['Day'];
        $Month=$results['Month'];
        $Year=$results['Year'];
        $TimeCreated=$results['TimeCreated'];
        $Title=$results['Title'];
        $Description=$results['Description'];
        $EventID=$results['ID'];
        $Hour=$results['Hour'];

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
</style>