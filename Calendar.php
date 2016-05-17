<?php
include "Assets/include/loggedfilter.php";
?>

<html>
<head>
    <?php include "Header.php";?>
</head>
<body>
<div id="container">
    <table>
        <?php
        $date=time();
        $day=date('d',$date);
        $month=date('m',$date);
        if(isset($_GET['Month'])){
            $month=$_GET['Month'];
        }
        $year=date('Y',$date);
        if(isset($_GET['Year'])){
            $year=$_GET['Year'];
        }
        $firstday=mktime(0,0,0,$month,1,$year);
        $title=date('F',$firstday);
        $dayOfWeek=date('D',$firstday);
        switch($dayOfWeek){
            case "Sun":$blank=6;break;
            case "Mon":$blank=0;break;
            case "Tue":$blank=1;break;
            case "Wed":$blank=2;break;
            case "Thu":$blank=3;break;
            case "Fri":$blank=4;break;
            case "Sat":$blank=5;break;
        }
        $daysInMonth=cal_days_in_month(0,$month,$year);
        $monthSet=$month+1;
        $yearSet=$year;
        if($monthSet>12){
            $monthSet=1;
            $yearSet=$year+1;
        }
        $monthBack=$month-1;
        $yearBack=$year;
        if($monthBack<1){
            $monthBack=12;
            $yearBack=$year-1;
        }
        echo "<br/><a href='Calendar.php?Month=$monthBack&Year=$yearBack' style='float: left;' class='changer'><span>Previous</span></a><a href='Calendar.php?Month=$monthSet&Year=$yearSet' style='float: right;'class='changer'><span>Next</span></a>
<tr><th colspan='60'>$title $year</th></tr>";
        echo "<tr><td width='62'>Monday</td><td width='62'>Tuesday</td><td width='62'>Wednesday</td><td width='62'>Thursday</td><td width='62'>Friday</td><td width='62'>Saturday</td><td width='62'>Sunday</td></tr>";
        $dayCount=1;
        echo "<tr>";
        while($blank>0){
            echo "<td></td>";
            $blank=$blank-1;
            $dayCount++;
        }
        $dayNum=1;



        while($dayNum<=$daysInMonth){


            if(substr($dayNum, 0, 1) === '0'){
                $dayNum=substr($dayNum,1,1);
            }
            if(substr($month, 0, 1) === '0'){
                $month=substr($month,1,1);
            }
            $records =$pdo->prepare("SELECT * FROM events WHERE UserId=:id and Year = :year and Month =:month and Day=:day order by TimeCreated ASC");
            $records->bindParam(':id',$id);
            $records->bindParam(':day',$dayNum);
            $records->bindParam(':month',$month);
            $records->bindParam(':year',$year);
            $records->execute();
            $eventCount=0;


            while($results=$records->fetch(PDO::FETCH_ASSOC)) {
                $eventCount++;

            }
            if($eventCount>0){
                echo "<td class='days' id='$dayNum'>$dayNum<div class='due'></div></td>";
            }
            else{
                echo "<td class='days' id='$dayNum'>$dayNum </td>";
            }

            $dayNum++;
            $dayCount++;
            if($dayCount>7){
                echo "<tr></tr>";
                $dayCount=1;
            }
        }
        while($dayCount>1&&$dayCount<=7){
            echo "<td></td>";
            $dayCount++;
        }
        echo "</tr>";
        ?>
    </table>
</div>
</body>
</html>
<style>
    .due{
        width: 11px;
        font-weight: bold;
        height: 11px;
        -webkit-border-radius:50%;
        -moz-border-radius:50%;
        border-radius:50%;
        margin-left: 10px;
        display: inline-block;
        background: #00CCBF;
        font-size: 10px;
    }

    .days{
        cursor: pointer;
        border-left:1px dashed grey;
        border-right:1px dashed grey;
    }
    table{
        width:100%;
        margin-top: 20px;
        text-align: center;
    }
</style>
<script src="Assets/js/jquery.js"></script>
<script>
    $(document).ready(function(){
        $('.days').click(function () {
            var day=$(this).attr('id');
            var month=<?php echo "$month"; ?>;
            var year=<?php echo "$year"; ?>;
            window.location.href= "CalendarEvent.php?Day="+day+"&Month="+month+"&Year="+year;
        });
    });
</script>