<?php
class osbb{
    var $id;
    var $name;
    var $adress;
    var $account1;
    var $account2;
    var $head;
    var $headTel;
    var $actualPeriod;
    var $tariffServ;
    var $tariffRefuse;
    var $tariffElektro;
  
    function init(){
        include "config.php";
        include "connect.php";
      
        
        $this->inn = $inn;
        $sql = 'SELECT * FROM generalData WHERE id = 1';
      
        if ($result = $mysqli->query($sql)) { 
            while($row = $result->fetch_assoc() ){
                $this->id = $row['id'];                   
                $this->name = $row['name'];
                $this->adress = $row['adress'];
                $this->account1  = $row['account1'];
                $this->account2 = $row['account2'];
                $this->head = $row['head'];
                $this->headTel = $row['headTel'];
                $this->actualPeriod = $row['actualPeriod']; 
                $this->tariffServ = $row['tariffServ']; 
                $this->tariffRefuse = $row['tariffRefuse']; 
                $this->tariffElektro = $row['tariffElektro']; 

            } 
            $result->close(); 
        }



    }
    function fileLog(){
        $fp = fopen("log.txt", "a"); // Открываем файл в режиме записи 
        $mytext = $this->id." ".$this->name. "\r\n"; // Исходная строка
        $test = fwrite($fp, $mytext); // Запись в файл
        fclose($fp); //Закрытие файла
      
    }

    function jsonOut(){
        echo json_encode($this);
    }

    function getTariffServ(){return $this->tariffServ;}
    function getTariffRefuse(){return $this->tariffRefuse;}
    function getTariffElektro(){return $this->tariffElektro;}
    function getActualPeriod(){return $this->actualPeriod;}

}


function kop2Grn($kop2Grn){
    $kop2Grn = (int)$kop2Grn;
    $kop2Grn = $kop2Grn / 100;
    return $kop2Grn;
}

    function flat($id,$mysqli){
            $sql = 'SELECT * FROM flats WHERE id ='.$id;
            $out = ''; 
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_row() ){
                    $out = $row[1];
                }}
            return $out;
        }

        function flatName2Id($flatName,$mysqli){
            $sql = 'SELECT * FROM flats WHERE name ="'.$flatName.'"';
            $out = ''; 
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_array() ){
                    $out = $row["id"];
                }}
            return $out;
        }

    function flatsList($mysqli){
        $sql = 'SELECT * FROM flats'; 
        //SELECT * FROM flats LEFT JOIN `elektro` ON flats.id = elektro.flat_id - получить массив и пропускать
        $out = '';
        if ($result = $mysqli->query($sql)) { 
            while($row = $result->fetch_row() ){
                //if (entrHmslf($row[0],$mysqli))
                    $out .= "<option value = ".$row[0]."> ".$row[1]."</option>";
            } 
            $result->close(); 
        }
        return $out;
    }
        function serviceName($id,$mysqli){
            $sql = 'SELECT * FROM services WHERE id ='.$id;
            $out = ''; 
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_assoc() ){
                    $out = $row["name"];
                }}
            return $out;
        }
        function serviceList($mysqli){
            $sql = 'SELECT * FROM services';
            $out = ''; 
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_row() ){
                    $out .= "<option value = ".$row[0]."> ".$row[1]."</option>";
                }}
            return $out;
        }
        function serviceColor($id,$mysqli){
            $sql = 'SELECT * FROM services WHERE id ='.$id;
            $out = ''; 
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_assoc() ){
                    $out = $row['color'];
                }}
            return $out;
        }
        function periodName($id,$mysqli){
            $sql = 'SELECT * FROM periods WHERE id ='.$id;
            $out = ''; 
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_assoc() ){
                    $out = $row["name"];
                }}
            return $out;
        }
        function periodMax($mysqli){
            $sql = 'SELECT MAX(id) FROM periods';
            $out = ''; 
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_row() ){
                    $out = $row[0];
                }}
            return $out;
        }
        function periodList($mysqli){
            $sql = 'SELECT * FROM periods ORDER BY id DESC';
            $out = ''; 
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_row() ){
                    $out .= "<option value = ".$row[0]."> ".$row[1]."</option>";
                }}
            return $out;
        }
        function periodList1($mysqli){
            $sql = 'SELECT * FROM periods ORDER BY id DESC';
            $out = ''; 
            $flag = 1;
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_row() ){ if ($flag) {$flag = 0; continue;}
                    $out .= "<option value = ".$row[0]."> ".$row[1]."</option>";
                }}
            return $out;
        }


    function moneyOut($money100){
        if (abs($money100%100) < 10)
            $headO = "0".abs($money100%100);
        else
            $headO = abs($money100%100);
        return intval($money100/100).",".$headO;
    }

    function accruals($flatId,$period,$mysqli){
        if ($period){
            $np = $period;
            $mp = $period;
        }
        else{
            $np = 1;
            $mp = periodMax($mysqli);
        }


        echo $flatId;
        
       // $p = periodMax($mysqli);




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
    }