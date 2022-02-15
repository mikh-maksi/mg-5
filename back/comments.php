<?php
    $id = $_POST['id'];
    $status = $_POST['status'];
    $comments_revisor = $_POST['comments_revisor'];
  

    $id = $_REQUEST['id'];
    $status = $_REQUEST['status'];
    $comments_revisor = $_REQUEST['comments_revisor'];
  


    $fp = fopen("log_comments.txt", "a"); // Открываем файл в режиме записи 
                $mytext = $id." ".$status." ".$comments_revisor." \r\n"; // Исходная строка
                $test = fwrite($fp, $mytext); // Запись в файл
                fclose($fp); //Закрытие файла
    
    
    $mysqli = new mysqli("levelhst.mysql.tools", "levelhst_usmart", "&9_vC2vC1t", "levelhst_usmart");
    if (!$mysqli->set_charset("utf8")) {printf("Ошибка при загрузке набора символов utf8: %s\n", $mysqli->error);                exit();            }
    
    $sql = "INSERT INTO comments ( type, text, extraballs_id) VALUES (2,'$comments_revisor','$id')";
    echo $sql;
    if (!$result = $mysqli->query($sql)) 
{  echo $mysqli->error;/*$result->close(); */}




    
?>