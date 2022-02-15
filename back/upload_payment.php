<?php
 
    $flatId = $_REQUEST['flat'];
    $serviceId = $_REQUEST['service'];
    $sum = $_REQUEST['sum'];
    $periodId = $_REQUEST['period'];
    $fl = $_FILES['fl']['name'];
    if (isset($_REQUEST['receiptId']))  $receiptId = $_REQUEST['receiptId']; else $receiptId = 0;

    $fp = fopen("log_payment.txt", "a"); // Открываем файл в режиме записи 
                $mytext = $flatId." ".$serviceId." ".$sum." ".$periodId." \r\n"; // Исходная строка
                $test = fwrite($fp, $mytext); // Запись в файл
                fclose($fp); //Закрытие файла
    
    
    if ( 0 < $_FILES['fl']['error'] ) {
        echo 'Error: ' . $_FILES['fl']['error'] . '<br>';
    }
    else {
        move_uploaded_file($_FILES['fl']['tmp_name'], 'uploads/' . $_FILES['fl']['name']);
    }
  
    include "config.php";
    include "connect.php";
    
    $sql = "INSERT INTO payments (receiptId, flatId, serviceId, periodId, sum, picture) 
    VALUES ($receiptId,$flatId,$serviceId,$periodId, $sum,'".$fl."')";
    echo $sql;
    if (!$result = $mysqli->query($sql)) 
{  echo $mysqli->error;/*$result->close(); */}




    
?>