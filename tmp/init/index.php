<?php
      header('Content-Type: text/html; charset=utf-8');
      include "../config.php";
      include "../connect.php";
       
      $sql = "TRUNCATE accountsStart"; // ! Змінюємо на назву своєї таблиці
      if ($mysqli->query($sql) === TRUE) {
          
      } else {
          echo "Error: " . $sql . "<br>" . $mysqli->error;
      }
      $fp = fopen('accountsstart.csv', 'r');// ! Змінюємо на назву свого файлу
      $flag = -1; 		// ? це напевно номер поля в таблиці
      
      $yearOut = 0; 	// * Рік 
      $mounth = '';   // * Місяць
      $value = 0;     // * Значення
  
      
      // * Перебір таблиці відбувається проходом по строці а потім перехід на наступну
      if ($fp) {
          while (!feof($fp)) {
              $mytext = fgets($fp, 999);// * кількість полів які беруться з таблиці
              $flag++; // number of row
              if ($flag<0){ continue;} //Количество строчек, которые пропускаем.
              $mytext = iconv('windows-1251', 'utf-8', $mytext); // * Отримуэмо текст
              $mytext = str_replace(",", ".",$mytext ); // * переробля з 3.14  в 3,14 
              $out = split (";", $mytext); // * робить з '3,14;2.71' => ['3,14','2,71']
              //print_r ($out);
              foreach($out as $key => $value){
                  // ! $key number of column 
                  switch ($key) {
                    case 0:
                        $flatId = $value; // * update year
                    break;
                    case 1:
                        
                    break;

                      case 2:
                      $sql = "INSERT INTO `accountsStart`(`flatId`,`startValue`) VALUES ($flatId,$value)";// ! Змінюємо під всої дані таблиці
                          echo $sql."<br>";                
                          if ($mysqli->query($sql) === TRUE) { 
                              
                          } else {
                              echo "Error: " . $sql . "<br>" . $mysqli->error; 
                          };
                      break;
                      
                      default:
                         echo "not found";
                  }
              } // * go to next column
              echo "<br>";        
              echo "<br>";
          }// * go to next row
          echo "<br>";
      } else { 
          echo "Ошибка при открытии файла";
      }
      fclose($fp);// * закриваємо доступ до файлу
      $mysqli->close();
  ?>
    <b>Новые записи добавлены успешно</b>
    <br> <a href = 'select.php'>Вернуться на страницу вывода данных</a>