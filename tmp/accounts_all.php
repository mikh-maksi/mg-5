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
   
    $out = '<table><tr><th>#</th><th>Оплаты</th><th>Начисления</th><th>Разница</th></tr>';
    $sql = 'SELECT * FROM flats';
    if ($result = $mysqli->query($sql)) { 
        while($row = $result->fetch_row() ){
            $i = $row[0];
            $sql2 = "SELECT * FROM accountsStart WHERE flatId = ".$i;                    
                    if ($result2 = $mysqli->query($sql2)) { 
                        while($row2 = $result2->fetch_row() ){
                            $arr[0][$i] = $row2[2];
                        }
                    }

              $sql3 = "SELECT SUM(sum) FROM accruals WHERE serviceId = 1 AND  flatId = ".$i;                    
                    if ($result3 = $mysqli->query($sql3)) { 
                        while($row3 = $result3->fetch_row() ){
                            
                            $arr[1][$i] = $row3[0];
                        }
                    }

                }
            }
        $result->close(); 
    
    $n = $i;
    for ($i=0;$i<=$n;$i++){
        $out.="<tr><td>".flat($i,$mysqli)."</td><td>".moneyOut($arr[0][$i])."</td><td>".moneyOut($arr[1][$i])."</td><td>".moneyOut($arr[1][$i]-$arr[0][$i])."</td></tr>";
          }


    $out .= "</table>";
?>
<?php echo $out; ?>
</body>
</html>
