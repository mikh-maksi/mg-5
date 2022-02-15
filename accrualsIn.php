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
<body>

<?php
    include "config.php";
    include "connect.php";
    include "functions.php";
    //Цена электричества

    /*Очищаем начисления */
    $sql = "TRUNCATE accruals";
    if (!$mysqli->query($sql)) {printf("Ошибка при отправке запроса: %s\n", $mysqli->error);  exit(); }


    $osbb = new osbb;
    $osbb->init();

    /* Формирование стоимости */
    $serv = $osbb->getTariffServ();
    $refuse = $osbb->getTariffRefuse();
    $elektro = $osbb->getTariffElektro();

 /*   echo $osbb->getTariffServ()." | ";
    echo $osbb->getTariffRefuse()." | ";
    echo $osbb->getTariffElektro()." | ";*/

    /*Определение старта и последнего периода */

    $np = 1;
    $mp = periodMax($mysqli);

for ($p=$mp;$p>=$np;$p--){
    $out = "<h2>$p".periodName($p,$mysqli)."</h2>";
    $out .= '<table><tr><td>#</td><td>Вывоз мусора</td><td>Электричество</td>';
    $sql = 'SELECT * FROM flats';
    if ($result = $mysqli->query($sql)) { 
        while($row = $result->fetch_assoc() ){
            $i  = $row['id'];
            $arr[0][$i] = $row['sq'];

           // $periodId = $osbb->getActualPeriod();
            
            $sql2 = "SELECT * FROM elektroRate WHERE flat_id = ".$i." and period_id = ".$p;                    
                    if ($result2 = $mysqli->query($sql2)) { 
                        while($row2 = $result2->fetch_row() ){
                            $arr[1][$i] = $row2[2];
                        }
                    }
                }
            }
        $result->close(); 


    $n = $i;
    for ($i=0;$i<=$n;$i++){
        $elektroRateOut = $arr[1][$i] * $elektro;
        $refuseRateOut =  $arr[0][$i] * $refuse;
        $servRateOut =  $arr[0][$i] * $serv;
      
        $out.= "<tr><td>".flat($i,$mysqli)."</td><td>".kop2Grn($refuseRateOut)."</td><td>".kop2Grn($servRateOut)."</td><td>".kop2Grn($elektroRateOut)."</td></tr>";

        $sql = "INSERT INTO accruals (flatId, periodId,serviceId,sum) VALUES($i,$p,6,$refuseRateOut)";                    
        if (!$mysqli->query($sql)) {printf("Ошибка при отправке запроса: %s\n", $mysqli->error);  exit(); }

        $sql = "INSERT INTO accruals (flatId, periodId,serviceId,sum) VALUES($i,$p,1,$elektroRateOut)";                    
        if (!$mysqli->query($sql)) {printf("Ошибка при отправке запроса: %s\n", $mysqli->error);  exit(); }

        $sql = "INSERT INTO accruals (flatId, periodId,serviceId,sum) VALUES($i,$p,2,$servRateOut)";                    
        if (!$mysqli->query($sql)) {printf("Ошибка при отправке запроса: %s\n", $mysqli->error);  exit(); }
    
    }


    $out .= "</table>";

 echo $out; 
}
 
 ?>



