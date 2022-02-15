<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<?php
    include "config.php";
    include "connect.php";
    include "functions.php";
   
    $serviceId = $_GET['s'];
    $periodId = $_GET['p'];

    $classes = "";
    if (isset($_GET['f']))   {$flatId = $_GET['f']; $classes.=" flat";} else $flatId = 0;
?>
<body class = "acc <?php echo $classes;?>">

<?php
if (isset($_GET['p'])){
        $np = $_GET['p'];
        $mp = $_GET['p'];
    }
    else{
        $np = 1;
        $mp = periodMax($mysqli);
    }

for ($p=$mp;$p>=$np;$p--){
    $out = "<h2>".periodName($p,$mysqli)."</h2>";
    $out .= "<div class = 'wrapperTbl'>";
/* Номера квартир */
    $out .= '<table class = "tbls tbls0" style = "border:1px solid #000";><tr><th> </th></tr><tr><th>#<br><br></th></tr>';
    if (!$flatId) $sql = 'SELECT * FROM flats'; else $sql = 'SELECT * FROM flats WHERE id = '.$flatId; 
    if ($result = $mysqli->query($sql)) { 
        while($row = $result->fetch_row() ){
            $i = $row[0];
            }
        }
        $result->close(); 
        
    if (!$flatId){
        $n = $i;
        for ($i=1;$i<=$n;$i++){
            $out.="<tr><td>".flat($i,$mysqli)."</td></tr>";
            }
        } else {
            $out.="<tr><td>".flat($i,$mysqli)."</td></tr>";
        }
    $out .= "</table>";
 echo $out; 
/* Номера квартир */
    for ($s=1;$s<=7;$s++){
    $out = '<table class = "tbls tbls'.$s.'" style = "border:1px solid #'.serviceColor($s,$mysqli).'; color:#'.serviceColor($s,$mysqli).'"><tr><th colspan = 4 class = thservice>'.serviceName($s,$mysqli).'</th></tr>
    <tr><th>Борг на<br> 1 число</th><th>Опла-<br>ты</th><th>Нараху-<br>вання</th><th>До<br> сплати</th></tr>';
    if (!$flatId) $sql = 'SELECT * FROM flats'; else $sql = 'SELECT * FROM flats WHERE id = '.$flatId; 
    if ($result = $mysqli->query($sql)) { 
        while($row = $result->fetch_row() ){
            $i = $row[0];
            $sql2 = "SELECT SUM(sum) FROM payments WHERE periodId = ".$p." AND serviceId = ".$s." AND flatId = ".$i;                    
            //echo "<div class = 'debugger'>".$sql2."</div>";
                    if ($result2 = $mysqli->query($sql2)) { 
                        while($row2 = $result2->fetch_row() ){
                            $arr[0][$i] = $row2[0];
                        }
                    }

              $sql3 = "SELECT SUM(sum) FROM accruals WHERE periodId = ".$p." AND serviceId = ".$s." AND  flatId = ".$i;                    
                    if ($result3 = $mysqli->query($sql3)) { 
                        while($row3 = $result3->fetch_row() ){
                            
                            $arr[1][$i] = $row3[0];
                        }
                    }

                $sql4 = "SELECT sum FROM debts WHERE periodId = ".($p)." AND serviceId = ".$s." AND  flatId = ".$i;                    
              //  echo $sql4."<br>";
                    if ($result4 = $mysqli->query($sql4)) { 
                        while($row4 = $result4->fetch_row() ){
                            $arr[2][$i] = $row4[0];
                        }
                    }

                }
            }
        $result->close(); 
        
    if (!$flatId){
        $n = $i;
        for ($i=1;$i<=$n;$i++){
            $out.="<tr><td>".moneyOut($arr[2][$i])."</td><td>".moneyOut($arr[0][$i])."</td><td>".moneyOut($arr[1][$i])."</td><td>".moneyOut($arr[2][$i]+$arr[1][$i]-$arr[0][$i])."</td></tr>";
            for ($j=0;$j<=2;$j++) $arr[$j][$i]="";
            }
        } else {
            $out.="<tr><td>".moneyOut($arr[2][$i])."</td><td>".moneyOut($arr[0][$i])."</td><td>".moneyOut($arr[1][$i])."</td><td>".moneyOut($arr[2][$i]+$arr[1][$i]-$arr[0][$i])."</td></tr>";
            for ($j=0;$j<=2;$j++) $arr[$j][$i]="";
        }


    $out .= "</table>";
 echo $out; 
    }
    echo "</div>";
}
 ?>

</body>
</html>
