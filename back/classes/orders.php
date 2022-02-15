<?php
        class orders{
            var $id;
            var $name;
            var $date;
            var $about;
            var $text;
            var $signMan;

        function init($id){
        
            include "config.php";
            include "connect.php";
            include "../functions.php";
            

            if(!isset($id)) $id = 0;

            if ($id == 0){
                $sql = 'SELECT MAX(id) FROM orders';   
                if ($result = $mysqli->query($sql)) {
                    while($row = $result->fetch_array() ){$id = $row['id'];}                
              }
            }


            $sql = 'SELECT * FROM orders WHERE id = '.$id;   

              if ($result = $mysqli->query($sql)) {
                while($row = $result->fetch_array() ){
                  $this->id=$row["id"];
                  $this->name=$row["name"];
                  $this->date=$row["date"];
                  $this->about=$row["about"];
                  $this->text=$row["text"];
                  $this->signMan=$row["signMan"];                    
                  }}
        }


            function fileLog(){
                $fp = fopen("log_orders.txt", "a"); // Открываем файл в режиме записи 
                $mytext = $this->name." ".$this->text. "\r\n"; // Исходная строка
                $test = fwrite($fp, $mytext); // Запись в файл
                fclose($fp); //Закрытие файла
              
            }
            function jsonOut(){
                echo json_encode($this);
            }



        }
    

?>