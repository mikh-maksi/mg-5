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


    $out = '<table><tr><td>#</td><td>Вывоз мусора</td><td>Электричество</td>';
    $sql = 'SELECT * FROM flats';
    if ($result = $mysqli->query($sql)) { 
        while($row = $result->fetch_assoc() ){
            $i  = $row['id'];
            $arr[0][$i] = $row['sq']*1.02;
            $sql = 'SELECT * FROM generalData WHERE id = 1';
            $result1 = $mysqli->query($sql);
            while($row1 = $result1->fetch_assoc() ){$periodId = $row1['actualPeriod'];  $periodId--;   }

            $sql2 = "SELECT * FROM elektro WHERE flat_id = ".$i." and period_id = ".$periodId;                    
                    if ($result2 = $mysqli->query($sql2)) { 
                        while($row2 = $result2->fetch_row() ){
                            $arr[1][$i] = $row2[2]*1.68;
                        }
                    }
                }
            }
        $result->close(); 
    
    $n = $i;
    for ($i=0;$i<=$n;$i++){
        $kop2Grn = $arr[1][$i];
        $kop2Grn = (int)$kop2Grn;
        $kop2Grn = $kop2Grn / 100;
        $out.= "<tr><td>".flat($i,$mysqli)."</td><td>".$arr[0][$i]."</td><td>".($kop2Grn)."</td></tr>";
          }


    $out .= "</table>";
?>
<?php echo $out; ?>


