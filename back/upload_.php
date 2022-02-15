<?php
    $name = $_POST['text'];
    $points = $_POST['points'];
    $description = $_POST['description'];
    $userid = $_POST['userid'];
    $statmnt = $_POST['statmnt'];


    $name = $_REQUEST['text'];
    $points = $_REQUEST['points'];
    $description = $_REQUEST['description'];
    $userid = $_REQUEST['userid'];
    $statmnt = $_REQUEST['statmnt'];


    $fp = fopen("log_upload.txt", "a"); // Открываем файл в режиме записи 
                $mytext = $name." ".$points." ".$description." \r\n"; // Исходная строка
                $test = fwrite($fp, $mytext); // Запись в файл
                fclose($fp); //Закрытие файла
    
    
    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name']);
    }
    $mysqli = new mysqli("levelhst.mysql.tools", "levelhst_usmart", "&9_vC2vC1t", "levelhst_usmart");
    if (!$mysqli->set_charset("utf8")) {printf("Ошибка при загрузке набора символов utf8: %s\n", $mysqli->error);                exit();            }
    
    $sql = "INSERT INTO extraballs (userID, points, nballs, link, comments, blstatus) VALUES ('$userid','$statmnt','$points','".$_FILES['file']['name']."','$description','0')";
    echo $sql;
    if (!$result = $mysqli->query($sql)) 
{  echo $mysqli->error;/*$result->close(); */}




    
?>