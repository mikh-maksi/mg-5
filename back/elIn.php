<?php
   include "../config.php";
   include "../connect.php";

   $kv = $_REQUEST["kv"];
   $period = $_REQUEST["period"];
   $fl = $_FILES['fl']['name'];
   $flatId = $_REQUEST["flatId"];
   $elIn = $_REQUEST["elIn"];
   
    //if (!isset ($_FILES['fl']['name'])) $fl = ' ';
   if ( 0 < $_FILES['fl']['error'] ) {
    echo 'Error: ' . $_FILES['fl']['error'] . '<br>';
}
else {
    move_uploaded_file($_FILES['fl']['tmp_name'], 'uploads/' . $_FILES['fl']['name']);
}
$lastReceiptId ="";

   $fp = fopen("log_elIn.txt", "a"); // Открываем файл в режиме записи 
   $mytext = $elIn."\r\n"; // Исходная строка
   $test = fwrite($fp, $mytext); // Запись в файл

   fclose($fp); //Закрытие файла

   $sql = "INSERT INTO elektro (flat_id, counter,period_id, picture,sendType) VALUES ($flatId,$elIn,$period,'$fl',2)";
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


        
        
    

        
	//header('Access-Control-Allow-Origin: *');
   //     header('Content-type: application/json; charset=utf-8');
        

      //  $kvart->fileLog();
       // $kvart->dbIn();
        

?>