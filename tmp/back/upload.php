<?php
    $docname = $_POST['docname'];
    $nballs = $_POST['nballs'];
    $comments = $_POST['comments'];
    $userid = $_POST['userid'];
    $stmnt = $_POST['stmnt'];
    $docname = $_POST['docname'];
    $statmentId = $_POST['statmentId'];


    $docname = $_REQUEST['docname'];
    $nballs = $_REQUEST['nballs'];
    $comments = $_REQUEST['comments'];
    $userid = $_REQUEST['userid'];
    $stmnt = $_REQUEST['stmnt'];
    $docname = $_REQUEST['docname'];
    $statmentId = $_REQUEST['statmentId'];


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
    
    $sql = "INSERT INTO extraballs (userID, docname, stmnt, nballs, link, comments, blstatus) VALUES ('$userid','$docname','$statmentId','$nballs','".$_FILES['file']['name']."','$comments','0')";
    echo $sql;
    if (!$result = $mysqli->query($sql)) 
{  echo $mysqli->error;/*$result->close(); */}




    
?>