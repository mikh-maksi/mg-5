<?php
        class organisation{
            var $id;
            var $name;
            var $adress;
            var $inn;
            var $bankAccount;
            var $stateReg;
            var $phone;
            var $email;
            var $dbIN;

            
        function init($inn){
            include "../config.php";
            include "../connect.php";
          
            
            $this->inn = $inn;
            $sql = 'SELECT * FROM organisation WHERE inn = "'.$this->inn.'"';
          
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_assoc() ){
                    $this->id = $row['id'];                   
                    $this->name = $row['name'];
                    $this->adress = $row['adress'];
                    $this->inn  = $row['inn'];
                    $this->bankAccount = $row['bankAccount'];
                    $this->stateReg = $row['stateReg'];
                    $this->phone = $row['phone'];
                    $this->email = $row['email']; 
                } 
                $result->close(); 
            }
    
    
    
        }


        function DBout(){
        }

            function fileLog(){
                $fp = fopen("log.txt", "a"); // Открываем файл в режиме записи 
                $mytext = $this->name." ".$this->inn. "\r\n"; // Исходная строка
                $test = fwrite($fp, $mytext); // Запись в файл
                fclose($fp); //Закрытие файла
              
            }
            function jsonOut(){
                echo json_encode($this);
            }
            function dbIn(){
                include "config.php";
                include "connnect.php";
                                
                if ($mysqli->connect_errno) {
                    //printf("Не удалось подключиться: %s\n", $mysqli->connect_error);
                    exit();
                }
                if (!$mysqli->set_charset("utf8")) {
                    //printf("Ошибка при загрузке набора символов utf8: %s\n", $mysqli->error);
                    exit();
                } else {
                    //printf("Текущий набор символов: %s\n", $mysqli->character_set_name());
                }
                $recordN = 0;
                $sql = 'SELECT COUNT(*) FROM organisation WHERE inn = "'.$this->inn.'"';
                if ($result = $mysqli->query($sql)) { 
    
                    while( $row = $result->fetch_row() ){ 
                        $recordN = $row[0]; 
                    } 
                
                    $result->close(); 
                } 
                
    
            /* Посылаем запрос серверу */ 
    
            if ($recordN == 0){
            $sql = "INSERT INTO organisation (name, adress, inn, bankAccount, stateReg, phone, email) VALUES ('$this->name', '$this->adress','$this->inn', '$this->bankAccount','$this->stateReg','$this->phone','$this->email')";
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