<?php
   
        $id = $_GET["id"];

        include("classes/orders.php");

        $order = new orders;

        $order->init($id);
        
	header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json; charset=utf-8');
        

        $order->fileLog();

        $order->jsonOut();

?>