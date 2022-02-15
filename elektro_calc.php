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
    <div class="wrapper">
        <div class="inpt">
            <div class = "dbtn"></div>
        </div>
    </div>
    <div id="output"></div>
    <?php
        function flat($id,$mysqli){
            $sql = 'SELECT * FROM flats WHERE id ='.$id;
            $out = ''; 
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_row() ){
                    $out = $row[1];
                }}
            return $out;
        }

        include "config.php";
        include "connect.php";

        if (!$mysqli->set_charset("utf8")) {printf("Ошибка при загрузке набора символов utf8: %s\n", $mysqli->error);  exit(); }

        $sql = "TRUNCATE elektroRate";
        if (!$mysqli->query($sql)) {printf("Ошибка при отправке запроса: %s\n", $mysqli->error);  exit(); }

        $out = '<table>';
            $sql = 'SELECT * FROM flats';
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_row() ){
                    
                    $i=$row[0];
                    $arr[$i][0] = $i;
                    $sql1 = 'SELECT * FROM periods';                    
                    if ($result1 = $mysqli->query($sql1)) { 
                        while($row1 = $result1->fetch_row() ){
                            $j=$row1[0];
                            $sql2 = "SELECT * FROM elektro WHERE flat_id = $i AND period_id = $j";                    
                            if ($result2 = $mysqli->query($sql2)) { 
                                while($row2 = $result2->fetch_row() ){
                                    $arr[$i][$j+1] = $row2[2];
                                }
                            }
                        }
                    }
                } 
                $result->close(); 
            }
        $ni = $i;
        $nj = $j;
        echo "<table class = 'elektroCalc'>";
        for ($i=0;$i<=$ni;$i++){
            echo "<tr>";
            for ($j=1;$j<=$nj;$j++){
                if ($j==1){echo "<td>".$arr[$i][0]/*flat($arr[$i][0],$mysqli)*/."</td>"; $flatId = $arr[$i][0];}
                 else {
                     if ($j>2){
                        if ($i==0) {$period_id = $arr[$i][1];}
                        $res =   $arr[$i][$j] - $arr[$i][$j-1];
                        $resClass = "";
                        if ($res<0) $resClass = "resYellow";
                        if ($i==0) $res = $j;
                        echo "<td class = ".$resClass.">".$res."</td>";
                        $period_id = $j-1;
                        if ($flatId !=''){
                        $sql = "INSERT INTO elektroRate (flat_id,rate,period_id) VALUES ($flatId,$res,$period_id )";

                        if (!$mysqli->query($sql)) {printf("Ошибка при отправке запроса: %s\n", $mysqli->error);  exit(); }
                      
                        //echo $sql."<br>";
                        }



                     }
                }
                
            }
            echo "</tr>";
            
        }
        echo "</table>";


            $out .= "</table>";
        ?>
    <?php echo $out; ?>


</body>
</html>