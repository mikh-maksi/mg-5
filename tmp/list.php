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
    <div id="output"></div>
    <div>
    <?php
    include "config.php";
    include "connect.php";

    $periodId = 3;
    $periodIdPrev = $periodId - 1;
    $elektroPrice = 1.68;
    $kvartPrice = 10;
    $wastePrice = 1.02;

    $sql = 'SELECT * FROM flats';
    $out = "<table><tr><td>#</td><td>Площа</td><td>Эл. счетчик</td><td>Электричество</td><td>Кварт</td><td>Мусор</td><td>Хол.В.</td><td>Отопл.</td><td>Долг.</td></tr>";
    if ($result = $mysqli->query($sql)) { 
        while($row = $result->fetch_assoc() ){
            $flatId = $row['id'];
            $sq = $row['sq'];
            
            $sql1 = "SELECT * FROM elektro WHERE flat_id = $flatId AND period_id = $periodIdPrev";                    
  
            if ($result1 = $mysqli->query($sql1)) { 
                while($row1 = $result1->fetch_assoc() ){
                    $elektro1 = $row1["counter"];
                }
            }
        
            $sql2 = "SELECT * FROM elektro WHERE flat_id = $flatId AND period_id = $periodId";                    
  
            if ($result1 = $mysqli->query($sql2)) { 
                while($row1 = $result1->fetch_assoc() ){
                    $elektro2 = $row1["counter"];
                }
            }
              $elektro = $elektro2 - $elektro1;
              $elektroSum = $elektro * $elektroPrice ;
              $kvSum = $sq * $kvartPrice;
              $wasteSum = $sq * $wastePrice;
            
            $coldWaterSum = '-';
            $heatingSum = '-';
            $debtSum = '-';
              $out .= "<tr><td>".$row['name']."</td>"."<td>".$row['sq']."</td>"."<td>".$elektro."</td>"."<td>".$elektroSum."</td>"."<td>".$kvSum."</td>"."<td>".$wasteSum."</td>"."<td>".$coldWaterSum."</td>"."<td>".$heatingSum."</td>"."<td>".$debtSum."</td>"."</tr>";


        } 
        $result->close(); 
    }
    $out .= "</table>";
    echo $out;

    $flatId = 1;

    $elektro1;
    $sql1 = "SELECT * FROM elektro WHERE flat_id = $flatId AND period_id = ($periodId-1)";                    
    if ($result1 = $mysqli->query($sql1)) { 
        while($row1 = $result1->fetch_assoc() ){
            $elektro1 = $row1["counter"];
        }
    }
    $elektro2;

    $sql2 = "SELECT * FROM elektro WHERE flat_id = $flatId AND period_id = $periodId";                    
    if ($result2 = $mysqli->query($sql2)) { 
        while($row2 = $result->fetch_assoc() ){
            $elektro2 = $row2["counter"];
        }
    }
    $elektro = $elektro2 - $elektro1;

    echo $elektro;

    ?>
    </div>


</body>
</html>