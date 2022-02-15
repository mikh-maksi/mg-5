<?php
   include "../config.php";
   include "../connect.php";

   $kv = $_REQUEST["kv"];
   $period = $_REQUEST["period"];
   $fl = $_FILES['fl']['name'];
   $flatId = $_REQUEST["flatId"];
    //if (!isset ($_FILES['fl']['name'])) $fl = ' ';
   if ( 0 < $_FILES['fl']['error'] ) {
    echo 'Error: ' . $_FILES['fl']['error'] . '<br>';
}
else {
    move_uploaded_file($_FILES['fl']['tmp_name'], 'uploads/' . $_FILES['fl']['name']);
}
$lastReceiptId ="";

   $fp = fopen("log_pay.txt", "a"); // Открываем файл в режиме записи 
   $mytext = $fl."\r\n"; // Исходная строка
   $test = fwrite($fp, $mytext); // Запись в файл

   fclose($fp); //Закрытие файла

   $sql = "INSERT INTO receipts (flatId, periodId,typeId, picture) VALUES ($flatId,$period,1,'$fl')";
    echo $sql."<br>";
   if (!$result = $mysqli->query($sql)) {
     echo $mysqli->error;
 
      //if ($lastReceiptId='') 
    //  $lastReceiptId=0;
    }      
    $lastReceiptId = $mysqli->insert_id;
   // echo $fl."<br>";     
    
        //$docname = $_REQUEST['docname'];
        
        //$lastReceiptId=0;

        for ($i=1;$i<=6;$i++){
           $str = 'service'.$i;
           $service[$i] = $_REQUEST[$str];
           $mytext = $service[$i]. " "; // Исходная строка
           $mytext .= $file;
           $test = fwrite($fp, $mytext); // Запись в файл


           if ($_REQUEST[$str]!='') {
                $sql = "INSERT INTO payments (	receiptId,flatId, serviceId, peridId, sum, picture) VALUES ($lastReceiptId,$flatId,$i,$period,'$_REQUEST[$str]','$fl')";
                ECHO $sql;
                if (!$result = $mysqli->query($sql)) {
                  echo $mysqli->error;}}
        }
        
        
        include("classes/payment.php");

        $pment = new payment;

        
	//header('Access-Control-Allow-Origin: *');
   //     header('Content-type: application/json; charset=utf-8');
        

      //  $kvart->fileLog();
       // $kvart->dbIn();
        $pment->jsonOut();

?>