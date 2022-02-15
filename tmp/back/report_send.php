<?php
      
      class extraPoint{
        var $studentId;
        var $statmentId;
        var $ballsAmont;
        var $link;
        var $comments;
        var $status;

        function fileLog(){
            $fp = fopen("log_report.txt", "a"); // Открываем файл в режиме записи 
            $mytext = $this->studentId." ".$this->ballsAmont. "\r\n"; // Исходная строка
            $test = fwrite($fp, $mytext); // Запись в файл
            fclose($fp); //Закрытие файла
          
        }
        function jsonOut(){
            echo json_encode($this);
        }
        function dbIn(){

            
            $mysqli = new mysqli("levelhst.mysql.tools", "levelhst_usmart", "&9_vC2vC1t", "levelhst_usmart");
            
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
          
            $sql = 'INSERT INTO extraballs (userID,stmnt,nballs,link, comments, blstatus) VALUES ('.$this->studentId.','.$this->statmentId.','.$this->nballs.','.$this->link.','.$this->comments.','.$this->status.')';
            //echo $sql;
            if ($mysqli->query($sql)) { 

            } else{
                echo $mysqli->error;
            }
            

        /* Посылаем запрос серверу */ 
  
        /* Закрываем соединение */ 
        $mysqli->close();    
        
        //echo $this->dbIN;
        $this->dbIN=1-$recordN;
        }
    }

    
        $ep = new extraPoint;
        $ep->studentId = $_GET["id"];
        $ep->statmentId= $_GET["turnover"];
        $ep->ballsAmont = $_GET["nstaf"];
        $ep->link = $_GET["kved"];
        $ep->comments = $_GET["kvartal"];
        $ep->status = 0;
      




   /**/  
        
		header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json; charset=utf-8');
        $tpr->fileLog();
        $tpr->dbIn();
        $tpr->jsonOut();

?>