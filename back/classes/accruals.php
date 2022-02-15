<?php
        class accruals{
            var $flatId;
            var $periodId;
            var $accruals;
            var $debts;
            var $payments;

        function init($flatName,$periodId){
        
            include "config.php";
            include "connect.php";
            include "../functions.php";
            
            $this->flatId = flatName2Id($flatName,$mysqli);
            $this->periodId = $periodId;


            $arrr=[];
            $debtsarrr=[];
            $paymentsarrr=[];            
            for ($k=1;$k<=7;$k++){ //Кількість типів послуг
                $sql = 'SELECT sum FROM accruals WHERE flatId = "'.$this->flatId.'" AND periodId = "'.$this->periodId.'" AND serviceId = '.$k.'';
              //  echo $sql."\r\n";
                if ($result = $mysqli->query($sql)) {while($row = $result->fetch_array() ){$arrr[$k]=$row["sum"]; } 
            }else {$arrr[$k]=0;}

            $sql = 'SELECT sum FROM debts WHERE flatId = "'.$this->flatId.'" AND periodId = "'.$this->periodId.'" AND serviceId = '.$k.'';
            //  echo $sql."\r\n";
              if ($result = $mysqli->query($sql)) {while($row = $result->fetch_array() ){$debtsarrr[$k]=$row["sum"]; } 
          }else {$debtsarrr[$k]=0;}
          
          $sql = 'SELECT sum FROM payments WHERE flatId = "'.$this->flatId.'" AND periodId = "'.$this->periodId.'" AND serviceId = '.$k.'';
          //  echo $sql."\r\n";
            if ($result = $mysqli->query($sql)) {while($row = $result->fetch_array() ){$paymentsarrr[$k]=$row["sum"]; } 
        }else {$paymentsarrr[$k]=0;}



            }
                $sql = 'SELECT sum FROM accruals WHERE flatId = "'.$this->flatId.'" AND periodId = "'.$this->flatId.'" ORDER BY serviceId';
                $result->close(); 

            //Установка кодировки.

            $this->accruals = $arrr;
            $this->debts = $debtsarrr;
            $this->payments = $paymentsarrr;
            /*
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_array() ){
                    $this->id = $row[0];                   
                    $this->name = $row[1];
                    $this->flatId = $row["flatId"];
                    $this->periodId = $row["periodId"];
                    $this->sum = $arrr;
                } 
                $result->close(); 
            }*/
        }


            function fileLog(){
                $fp = fopen("log.txt", "a"); // Открываем файл в режиме записи 
                $mytext = $this->flatId." ".$this->serviceId. "\r\n"; // Исходная строка
                $test = fwrite($fp, $mytext); // Запись в файл
                fclose($fp); //Закрытие файла
              
            }
            function jsonOut(){
                echo json_encode($this);
            }



        }
    

?>