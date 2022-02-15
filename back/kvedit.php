<?php
   
        $owner = $_GET["owner"];
        $comments = $_GET["comments"];
        $contact = $_GET["contact"];
        
        $kv = $_GET["kv"];

        $fp = fopen("log_kvedit.txt", "a"); // Открываем файл в режиме записи 
        $mytext = $owner." | ".$comments." | ".$contact." | ".$kv. " | \r\n"; // Исходная строка
        $test = fwrite($fp, $mytext); // Запись в файл
        fclose($fp); //Закрытие файла
 

        include("classes/kv.php");

        $kvart = new kv;

        $kvart->init($kv);
        $kvart->update($contact,$owner,$comments);


	header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json; charset=utf-8');
        

        $kvart->fileLog();
       // $kvart->dbIn();
        $kvart->jsonOut();

?>