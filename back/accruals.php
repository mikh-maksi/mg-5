<?php
   
        $kv = $_GET["kv"];
        $per = $_GET["per"];

        include("classes/accruals.php");

        $acc = new accruals;

        $acc->init($kv,$per);
        
	header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json; charset=utf-8');
        

        $acc->fileLog();
       // $kvart->dbIn();
        $acc->jsonOut();

?>