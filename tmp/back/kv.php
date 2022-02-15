<?php
   
        $kv = $_GET["kv"];

        include("classes/kv.php");

        $kvart = new kv;

        $kvart->init($kv);
        
	header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json; charset=utf-8');
        

        $kvart->fileLog();
       // $kvart->dbIn();
        $kvart->jsonOut();

?>