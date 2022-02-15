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
            <div class = "dbtn"></div>
        </div>
    </div>
    <div id="output"></div>
    <?php
        include "config.php";
        include "connect.php";
        include "functions.php";

        if (!$mysqli->set_charset("utf8")) {printf("Ошибка при загрузке набора символов utf8: %s\n", $mysqli->error);  exit(); }
        function entrHmslf($id,$mysqli){
        //$enterHimself[];
        $sql = 'SELECT flat_id FROM elektro WHERE period_id = 8'; 
        //SELECT * FROM flats LEFT JOIN `elektro` ON flats.id = elektro.flat_id - получить массив и пропускать
        $out = 1;
        //echo $sql;
        if ($result = $mysqli->query($sql)) { 
            while($row = $result->fetch_assoc() ){
                if ($id == $row['flat_id']){$out = 0; break;}
            }
            $result->close(); 
        }
        return $out;
        }

        function actlPrd($mysqli){
            $sql = 'SELECT actualPeriod FROM generalData WHERE id = 1'; 
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_assoc() ){$out = $row['actualPeriod'];}
                }
                $result->close(); 
            
            return $out;
        }


            $sql = 'SELECT * FROM flats'; 
            //SELECT * FROM flats LEFT JOIN `elektro` ON flats.id = elektro.flat_id - получить массив и пропускать
            $out = '';
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_row() ){
                    //if (entrHmslf($row[0],$mysqli))
                        $out .= "<option value = ".$row[0]."> ".$row[1]."</option>";
                } 
                $result->close(); 
            }
        ?>

    <div class = "inpt " id = "inpt">
        <div>
        <span>Квартира:</span> <select id = "flat"><?php echo $out; ?></select><br>
        <span>Сума:</span><input type="input" id = "sumg" min = 0>грн. <input type="input" id = "sumk" maxlength=2 >к.<br>
        <span>Послуга:</span> <select id = "service"><?php echo serviceList($mysqli); ?></select><br>
        <span>Період:</span> <select id = "period"><?php echo periodList($mysqli); ?></select><br>
        <span>Коментарі:</span> <input type = "text" id = "comments"><br>
        <span>Фото/скан платіжки:</span><input id="picture" type="file" name="pic" /><br>
        <button id="upload">Відправити</button><br></div>
    </div>
    <script>
    var request = new XMLHttpRequest();   var obj;
    function reqReadyStateChange() {console.log(request.readyState);
        if (request.readyState == 4) {    var status = request.status;
            if (status == 200) {
                console.log(request.responseText);       obj = JSON.parse(request.responseText);
                document.getElementById("output").innerHTML="";     var res = document.createElement("div");     res.setAttribute('role', 'alert');
                if (obj.dbIN==1){  var str = "Пользователь с ИНН "+obj.inn+" успешно зарегистрирован успешно!";      res.className = "alert alert-success";  }else{
                    var str = "Пользователь с ИНН "+obj.inn+" уже существует!";          res.className = "alert alert-warning";     }
                var node = document.createTextNode(str);      var info = document.createElement("div");
                info.innerHTML = '<div class="alert alert-success" role="alert"> <h4 class="alert-heading">Информация о студенте!</h4>  <p>Прізвище: <b>'+obj.lastname+'</b> Ім\'я: <b>'+obj.firstname+'</b> По-батькові: <b>'+obj.fathername+'</b><br> Телефон: <b>'+obj.phone+'</b> email: <b>'+obj.email+'</b> </p>  <hr>  <p class="mb-0">В указанном разделе Вы сможете ввести данные и просмотреть уже введенные данные</p></div>';            
                output.appendChild(info);   var input = document.createElement("div");
                input.innerHTML = '<div class = "inpt"><div><button id = "btn_answer">Подивитись відповідь</button><button id = "btn_report">Відправити документи</button></div></div>';
                output.appendChild(input);       
                // btn_report.addEventListener("click",clckReport);   btn_answer.addEventListener("click",clckAnswer);
                }   }   }
</script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>    <script  src="https://code.jquery.com/jquery-3.4.0.min.js"  integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="  crossorigin="anonymous"></script>    
    <script>
        function clck(){
            var body = "studentcard=" + studentcard.value; 			console.log(body);             request.open("GET", "http://innovations.kh.ua/uni-smart/back/reports.php?"+body);             request.onreadystatechange = reqReadyStateChange;             request.send();
        }
        function clckReport(){   var input = document.createElement("div");                 input.innerHTML = '';                inpt.className = "inpt";                output.appendChild(input);        }
        function clckAnswer(){
            var body = "studentId=" + obj.id + "&docname"+docname.value+"&statmentId="+statmentId.value+ "&nballs="+nballs.value+ "&link="+sortpicture.value+ "&comments="+comments.value;
            request.open("GET", "http://innovations.kh.ua/uni-smart/back/report_send.php?"+body);         request.onreadystatechange = reqReadyStateChange;             request.send();
        }
       // btn.addEventListener("click",clck);
    </script>

<script>
    $('#upload').on('click', function() {
    var file_data = $('#picture').prop('files')[0];
    var flat = $('#flat').val();
    console.log(flat);
    var service = $('#service').val();
    var sumg = $('#sumg').val();
    var sumk = $('#sumk').val();
    var sum = sumg + sumk ;
    console.log(sum);

    var comments = $('#comments').val();
    var period = $('#period').val();
    console.log(sum);
    var form_data = new FormData();
    form_data.append('flat', flat);
    form_data.append('file', file_data);
    form_data.append('sum', sum);
    form_data.append('service', service);    
    form_data.append('comments', comments);    
    form_data.append('period', period);

    console.log(form_data);
    jQuery.ajax({
                url: '/mg-5/back/upload_payment.php',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(php_script_response){
                    //alert(php_script_response);
                    $('#comments').val('');
                    $('#sum').val('');
                    $('#picture').val('');
                }
     });
});
</script>


</body>
</html>