<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
    include "config.php";
    include "connect.php";

    function user_out($id,$mysqli){
        $sql = 'SELECT * FROM students WHERE id ='.$id;
        if ($result = $mysqli->query($sql)) { 
            while($row = $result->fetch_row() ){

                $out =  $row[1]." ".$row[2]." ".$row[3]." <br> ".$row[6]." <br> ".$row[8]."";
            } 
            $result->close(); 
        }
        return $out;
    }
    function article_out($id,$mysqli){
        $sql = 'SELECT * FROM statments WHERE id ='.$id;
        if ($result = $mysqli->query($sql)) { 
            while($row = $result->fetch_row() ){
                $out = "<b>За що:</b> ".$row[0].". ". $row[1]."<br><b>Документ</b> ".$row[2]."<br><b>Кількість балів:</b> ".$row[3];
            } 
            $result->close(); 
        }
        return $out;
    }


    $sql = 'SELECT * FROM extraballs';
    $out = '';
    echo "<table border = 1>";
    echo "<tr><td>Користувач</td><td>Документ</td><td>Номер статті</td><td>Кількість балів</td><td>Скріншот документа</td><td>Коментарі студента</td><td>Коментарі перевіряючого</td><td>Дія</td></tr>";
    if ($result = $mysqli->query($sql)) { 
        while($row = $result->fetch_row() ){

            $out =  "<input type = 'hidden' id = 'pointID' value = ".$row[0]."><tr><td>".user_out($row[1],$mysqli)."</td><td>".$row[2]."</td><td>".article_out($row[3],$mysqli)."</td><td>".$row[4]."</td><td>
            <a href='uploads/".$row[5]."' class='highslide' onclick='return hs.expand(this)'>
    <img src='uploads/".$row[5]."' alt='Highslide JS'  title='Click to enlarge' height='100' width='100' />
</a>
            </td><td>".$row[6]."</td>
            <td>".$row[7]."</td>
            <td>
            <b>Рішення та комнтар:</b><br>
            <select id = '".$row[0]."status'><option value = 1>Відхилити</option><option value = 2>Відправити на доопрацювання</option><option value = 3>Прийняти</option></select><br>
            <input type = 'text' id = '".$row[0]."comments_revisor'><br>
            <button id = '".$row[0]."send' class = 'send'>Відправити</button></td></tr>";
            echo $out;
        } 
        echo "</table>";
        $result->close(); 
    }





?>
<script>
  function reqReadyStateChange() {console.log(request.readyState);
        if (request.readyState == 4) {    var status = request.status;
            if (status == 200) {
                console.log(request.responseText);      
                obj = JSON.parse(request.responseText);
               
                }   }   }

    var request = new XMLHttpRequest();   var obj;
    function send_revisor(sid){
        
        st = document.getElementById(sid+"status");
        cr = document.getElementById(sid+"comments_revisor");
        console.log(sid);
        console.log(st.value);
        console.log(cr.value);
       // console.log(comments_revisor.value);


            var body = "id="+sid+"&status=" + st.value+"&comments_revisor="+cr.value; 			
            console.log(body);           
              request.open("GET", "http://innovations.kh.ua/uni-smart/back/comments.php?"+body);      
                     request.onreadystatechange = reqReadyStateChange;         
                         request.send();

    }
    s = document.getElementsByClassName("send");
    console.log(s);
    
    console.log(s.length);
    for(var i=0;i<s.length;i++){
        var sid=parseInt(s[i].id);
       s[i].addEventListener("click",function(item){
           console.log();
          
           send_revisor(parseInt(item.target.id))}, false );
    }
   
   // s.addEventListener("click",send_revisor);
</script>
    <script type="text/javascript" src="../highslide/highslide.js"></script>
<script type="text/javascript">
    hs.graphicsDir = '../highslide/graphics/';
    hs.outlineType = 'outer-glow';
</script>
    </body>
</html>
