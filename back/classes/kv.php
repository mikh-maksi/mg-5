<?php
        class kv{
            var $id;
            var $name;
            var $floor;
            var $sq;
            var $contact;
            var $owner;
            var $comments;
            var $mgbcode;
            var $dbIN;

        function init($name){
            $this->name = $name;
            include "config.php";
            include "connect.php";

            $sql = 'SELECT * FROM flats WHERE name = "'.$this->name.'"';
            //Установка кодировки.
            
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_array() ){
                    $this->id = $row[0];                   
                    $this->name = $row[1];
                    $this->floor = $row[2];
                    $this->sq  = $row[3];
                    $this->contact = $row[4];
                    $this->owner = $row["owner"];
                    $this->comments = $row["comments"];
                    $this->mgbcode = $row["code"];
                } 
                $result->close(); 
            }
        }
        function update($contact,$owner,$comments){
            $fp = fopen("log_kvupdate.txt", "a"); // Открываем файл в режиме записи 
           
           
            include "config.php";
            include "connect.php";

            $this->contact = $contact;
            $this->owner = $owner;
            $this->comments = $comments;


            $sql = 'UPDATE flats SET contact = "'.$contact.'", owner = "'.$owner.'", comments = "'.$comments.'" WHERE name = "'.$this->name.'"';
            //Установка кодировки.
            
            $result = $mysqli->query($sql);  
            $mytext = $contact." | ".$owner." | ".$comments."| \r\n";
            $test = fwrite($fp, $mytext); // Запись в файл
            $mytext = $sql."| \r\n";
            $test = fwrite($fp, $mytext); // Запись в файл

            fclose($fp); //Закрытие файла

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