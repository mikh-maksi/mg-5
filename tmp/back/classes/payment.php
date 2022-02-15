<?php
        class payment{
            var $id;
            var $service1;
            var $service2;
            var $service3;
            var $service4;
            var $service5;
            var $service6;
            var $service=array();

            var $comments;

        function init($name){
            $this->name = $name;
            include "config.php";
            include "connect.php";

            $sql = 'SELECT * FROM flats WHERE name = "'.$this->name.'"';
            //Установка кодировки.
            
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_row() ){
                    $this->id = $row[0];                   
                    $this->name = $row[1];
                    $this->floor = $row[2];
                    $this->sq  = $row[3];
                    $this->contact = $row[4];
                    $this->owner = $row[5];
                    $this->mgbcode = $row[6];
                } 
                $result->close(); 
            }
        }
        function DBout(){
        }

            function fileLog(){
                $fp = fopen("log.txt", "a"); // Открываем файл в режиме записи 
                $mytext = $this->lastname." ".$this->firstname. "\r\n"; // Исходная строка
                $test = fwrite($fp, $mytext); // Запись в файл
                fclose($fp); //Закрытие файла
              
            }
            function jsonOut(){
                echo json_encode($this);
            }
            function dbIn(){
                include "config.php";
                include "connect.php";
                // $mysqli = new mysqli("levelhst.mysql.tools", "levelhst_usmart", "&9_vC2vC1t", "levelhst_usmart");
                
                $recordN = 0;
                $sql = 'SELECT COUNT(*) FROM flats WHERE kv = "'.$this->kv.'"';
                if ($result = $mysqli->query($sql)) { 
    
                    while( $row = $result->fetch_row() ){ 
                        $recordN = $row[0]; 
                    } 
                
                    $result->close(); 
                } 
                
    
            /* Посылаем запрос серверу */ 
    
            if ($recordN ==0){
            $sql = "INSERT INTO students (lastname, firstname, fathername, school, course, studentgroup, studentcard, phone, email) VALUES ('$this->firstname', '$this->lastname','$this->fathername', '$this->school','$this->course','$this->studentgroup','$this->studentcard','$this->phone','$this->email')";
          //  echo $sql;
            if(!$mysqli->query($sql)){
                echo $mysqli->error;
         }
        }   
            /* Закрываем соединение */ 
            $mysqli->close();    
            
            //echo $this->dbIN;
            $this->dbIN=1-$recordN;
            }
        }
    

?>