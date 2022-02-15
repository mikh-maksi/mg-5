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
    $osbb = new osbb;
    $osbb->init();

    $serv = $osbb->getTariffServ();
    $refuse = $osbb->getTariffRefuse();
    $elektro = $osbb->getTariffElektro();

 /*   echo $osbb->getTariffServ()." | ";
    echo $osbb->getTariffRefuse()." | ";
    echo $osbb->getTariffElektro()." | ";*/


    $out = '<table><tr><td>#</td><td>Вывоз мусора</td><td>Электричество</td>';
    $sql = 'SELECT * FROM flats';
    if ($result = $mysqli->query($sql)) { 
        while($row = $result->fetch_assoc() ){
            $i  = $row['id'];
            $arr[0][$i] = $row['sq'];

            $periodId = $osbb->getActualPeriod();
            
            $sql2 = "SELECT * FROM elektroRate WHERE flat_id = ".$i." and period_id = ".$periodId;                    
                    if ($result2 = $mysqli->query($sql2)) { 
                        while($row2 = $result2->fetch_row() ){
                            $arr[1][$i] = $row2[2];
                        }
                    }
                }
            }
        $result->close(); 
       
        $sql = "TRUNCATE accruals";
        if (!$mysqli->query($sql)) {printf("Ошибка при отправке запроса: %s\n", $mysqli->error);  exit(); }

    $n = $i;
    for ($i=0;$i<=$n;$i++){
        $elektroRateOut = kop2Grn($arr[1][$i] * $elektro);
        $refuseRateOut =  kop2Grn($arr[0][$i] * $refuse);
        $servRateOut =  kop2Grn($arr[0][$i] * $serv);;
      
        $out.= "<tr><td>".flat($i,$mysqli)."</td><td>".$refuseRateOut."</td><td>".($servRateOut)."</td><td>".($elektroRateOut)."</td></tr>";
        $sql = "INSERT INTO accruals (flatId,periodId,) VALUES ($flatId,$res,$period_id )";
        if (!$mysqli->query($sql)) {printf("Ошибка при отправке запроса: %s\n", $mysqli->error);  exit(); }
        
          }


    $out .= "</table>";
?>
<?php echo $out; ?>


