<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wrapper">
        <div class="inpt">
            <div><span>Номер квартири:</span> <input type="text" id = "kv" value = ""> 
                <button id = "btn">Send</button></div>
            <div class = "dbtn"></div>
        </div>
    </div>
    <div id="output"></div>
    
    <?php
    include "config.php";
    include "connect.php";
    
    $sql = 'SELECT * FROM services';
    $out = '';
    if ($result = $mysqli->query($sql)) { 
        while($row = $result->fetch_row() ){
            $out .= "<nobr><label for = 'radiostmnt".$row[0]."'>".$row[0]." ".$row[1]."</label><input type = 'text' class = 'inptService' name = 'stmt' id='service".$row[0]."' value = ''></nobr><br>";
        } 
        $result->close(); 
    }

    $sql = 'SELECT * FROM periods ORDER BY id DESC';
    $out1 = '';
    if ($result = $mysqli->query($sql)) { 
        while($row = $result->fetch_row() ){
            $out1 .= "<option type = 'text' class = 'inptService' value = '".$row[0]."' >".$row[1]."</option>";
        } 
        $result->close(); 
    }    

    function actualPeriod($type,$mysqli){
    $actualPeriod = '';
    $sql = 'SELECT actualPeriod FROM generalData WHERE id = 1';

    if ($result = $mysqli->query($sql)) { 
        while($row = $result->fetch_row() ){
            $actualPeriod = $row[0];
        } 
        $result->close(); 
    }

    if ($type == 1) $out =   $actualPeriod;
    if ($type == 2) {  
        $sql = "SELECT name FROM periods WHERE id = $actualPeriod";
        $out1 = '';
        if ($result = $mysqli->query($sql)) { 
            while($row = $result->fetch_row() ){
                $out = $row[0];
            } 
            $result->close(); 
        }    

    }
      return $out;
    }

        ?>
    </div>

    <div>
        <div class="hide" id = "elektroField">
            <span>Показник:</span> <div class="sums"><input type = "text" id = "elektroIn"><br>
            <span>Фото Лічільника:</span> <input id="pictureCounter" type="file" name="pic" /><br>
            <span>Період:</span> <b><?php echo actualPeriod(2,$mysqli);?> <br>
            <input id="perElektro" type="hidden" value = <?php echo actualPeriod(1,$mysqli);?> > 
        </div>
            <button id="uploadElektro">Відправити дані</button>
            <div id="elektroLink"></div>
    </div>
<!--
    <div class="" id = "ElektroOut">
<?php
        function flat($id,$mysqli){
            $sql = 'SELECT * FROM flats WHERE id ='.$id;
            $out = ''; 
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_row() ){
                    $out = $row[1];
                }}
            return $out;
        }



        if (!$mysqli->set_charset("utf8")) {printf("Ошибка при загрузке набора символов utf8: %s\n", $mysqli->error);  exit(); }
        $titles[0] = 'квартира';
        $out = '<table>';
            $sql = 'SELECT * FROM flats';
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_row() ){
                    $i=$row[0];
                    $arr[$i][0] = $i;
                    $sql1 = 'SELECT * FROM periods';                    
                    if ($result1 = $mysqli->query($sql1)) { 
                        while($row1 = $result1->fetch_row() ){       
                            $j=$row1[0];
                            $sql2 = "SELECT * FROM elektro WHERE flat_id = $i AND period_id = $j";                    
                            if ($result2 = $mysqli->query($sql2)) { 
                                while($row2 = $result2->fetch_row() ){
                                    $arr[$i][$j] = $row2[2];
                                    $arrType[$i][$j] = $row2[5];
                                }
                            }
                        }
                    }
                } 
                $result->close(); 
            }
        $ni = $i;
        $nj = $j;
        $sql = 'SELECT * FROM periods';                    
        if ($result = $mysqli->query($sql)) { 
            while($row = $result->fetch_row() ){
                $titles[] = $row[1];
            }}



        echo "<table><tr>";
        for ($k=0;$k<count($titles);$k++){
            echo "<td>".$titles[$k]."</td>";
        }
        echo "</tr>";
        for ($i=0;$i<=$ni;$i++){
            echo "<tr>";
            for ($j=0;$j<=$nj;$j++){
                if ($j==0){echo "<td>".flat($arr[$i][$j],$mysqli)."</td>";}
                else {
                    if ($arrType[$i][$j] == 1 or $arrType[$i][$j] == 0)  echo "<td>".$arr[$i][$j]."</td>";
                    if ($arrType[$i][$j] == 2)  echo "<td><u>".$arr[$i][$j]."</u></td>";
                
                }
            }
            echo "</tr>";
        }

            $out .= "</table>";
        ?>
    <?php echo $out; ?>


?>
-->

    
    </div>


    
    <script>
    var request = new XMLHttpRequest();   var obj;
    function reqReadyStateChange() {/*console.log(request.readyState);*/
        if (request.readyState == 4) {    
            var status = request.status;
            if (status == 200) { 
                obj = JSON.parse(request.responseText);
                console.log(request.responseText);
                console.log(obj);
                document.getElementById("output").innerHTML="";     
                var res = document.createElement("div");     
                res.setAttribute('role', 'alert');
               
                var info = document.createElement("div");
                info.innerHTML = '<div class="alert alert-success" role="alert"> <h4 class="alert-heading">Інформация про квартиру</h4>  <p>№: <b>'+obj.name+'</b> Етаж: <b>'+obj.floor+'</b> Площа: <b>'+obj.sq+'</b><br> Контакт: <b>'+obj.contact+'</b> Власник: <b>'+obj.owner+'</b> <br>Код Мегабанку: <b>'+obj.mgbcode+'</b> id: <b>'+obj.id+'</b>  </p>  <hr>  <p class="mb-0"></p></div>';            
                output.appendChild(info);   var input = document.createElement("div");

                input.innerHTML = '<div class = "inpt"><div><button class = "act" id = "btnElektro">Ввести показники електролічільника</button><button class = "deact" id = "btnElektroOut">Показники електролічільника</button><button class = "deact" id = "btnElektroOut">Данні за квартирою</button></div></div>';
                output.appendChild(input);       
                btnElektro.addEventListener("click",fncElektro);
                 
                }   }   }

                function flatReg(){
                    console.log("flatReg");
                }

                function fncElektro(){
                    console.log('elektro');
                    elektroField.className = "";
                }

</script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>    <script  src="https://code.jquery.com/jquery-3.4.0.min.js"  integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="  crossorigin="anonymous"></script>    
    <script>
        function clck(){
            var body = "kv=" + kv.value;
            request.open("GET", "http://innovations.kh.ua/mg-5/back/kv.php?"+body);
            request.onreadystatechange = reqReadyStateChange;             request.send();
        }

        function clckReport(){   var input = document.createElement("div");                 input.innerHTML = '';                inpt.className = "inpt";                output.appendChild(input);        
            otpt.className = "hide";
            inpt.className = "";

        }
        function clckAnswer(){
            inpt.className = "hide";
            otpt.className = "";

            console.log("clckAnswer");
            var body = "kvId=" + obj.id;
            console.log(body);
            request.open("GET", "http://innovations.kh.ua/mg-5/back/kv_answer.php?"+body);         request.onreadystatechange = reqReadyStateChange1;             request.send();
        }
        btn.addEventListener("click",clck);
    </script>

<script>
    $('#uploadElektro').on('click', function() {
    var file_data = $('#pictureCounter').prop('files')[0];
    var elIn = $('#elektroIn').val();
    console.log(file_data);

    var period = $('#perElektro').val();

    userid = obj.id;
    var form_data = new FormData();

    form_data.append('fl', file_data);
    form_data.append('elIn', elIn);
    form_data.append('period', period);
    form_data.append('flatId', obj.id);
    
    console.log(form_data);
    jQuery.ajax({
                url: '/mg-5/back/elIn.php',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(php_script_response){
                    //alert(php_script_response);
                    alert("Дані відправлено");
                    $('#picture').val('');
                    $('#docname').val('');
                    $('#elektroIn').val('');
                    $('#elektroLink').html('<a href =  http://innovations.kh.ua/mg-5/elektro_out.php target = _blank>Перевірити введені дані</a>');
                    console.log(elektroIn);
                }
     });
});



</script>


</body>
</html>