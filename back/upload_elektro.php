<?php
 
    $flat = $_REQUEST['flat'];
    $counter = $_REQUEST['counter'];
    $comments = $_REQUEST['comments'];
    $period_id = $_REQUEST['period'];


    $fp = fopen("log_upload.txt", "a"); // Открываем файл в режиме записи 
                $mytext = $flat." ".$counter." ".$comments." \r\n"; // Исходная строка
                $test = fwrite($fp, $mytext); // Запись в файл
                fclose($fp); //Закрытие файла
    
    
    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name']);
    }
  
    include "config.php";
    include "connect.php";
    
    $sql = "INSERT INTO elektro (flat_id, counter, picture, comments, period_id) VALUES ($flat,$counter,'".$_FILES['file']['name']."','$comments','$period_id')";
    echo $sql;
    if (!$result = $mysqli->query($sql)) 
{  echo $mysqli->error;/*$result->close(); */}




    
?>