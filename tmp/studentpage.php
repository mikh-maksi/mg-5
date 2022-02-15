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
            <div><span>Номер студентського квитку:</span> <input type="text" id = "studentcard" value = ""> 
                <button id = "btn">Send</button></div>
            <div class = "dbtn"></div>
        </div>
    </div>
    <div id="output"></div>
    
    <?php
            $mysqli = new mysqli("levelhst.mysql.tools", "levelhst_usmart", "&9_vC2vC1t", "levelhst_usmart");
            if (!$mysqli->set_charset("utf8")) {printf("Ошибка при загрузке набора символов utf8: %s\n", $mysqli->error);  exit(); }
            $sql = 'SELECT * FROM statments';
            $out = '';
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_row() ){
                    $out .= "<nobr><input type = 'radio' class = 'rdio' name = 'stmt' id='radiostmnt".$row[0]."' value = ".$row[0]."><label for = 'radiostmnt".$row[0]."'>".$row[0]." ".$row[1]."</label></nobr><br>";
                } 
                $result->close(); 
            }
        ?>
    </div>
    <div class = "hide" id = "inpt">
        <div>
        <span>Назва документу:</span> <input type = "text" id = "docname"><br>
        <span>Пункт:</span> <div class="stmts"><?php echo $out; ?></div><br>
        <span>Кількість балів</span><input type="text" id = "nballs"><br>
        <span>Коментарі:</span> <input type = "text" id = "comments"><br>
        <input id="picture" type="file" name="pic" />
        <button id="upload">Відправити дані</button><br></div>
    </div>
    <div class="hide" id = "otpt">
        <table id="res" class = "table table-bordered table-sm table-responsive table-hover">
        </table>
    </div>
    <script>
    var request = new XMLHttpRequest();   var obj;
    function reqReadyStateChange() {/*console.log(request.readyState);*/
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
                output.appendChild(input);        btn_report.addEventListener("click",clckReport); 
                console.log(btn_report);
                  btn_answer.addEventListener("click",clckAnswer);

                 
                }   }   }

                function reqReadyStateChange1() {
                if (request.readyState == 4) { 
                       var status = request.status;
            if (status == 200) {
               // console.log(request.responseText);
                obj = JSON.parse(request.responseText);
                console.log(obj);
                var div = document.createElement('tr');
                    div.innerHTML = '<th>Назва документу, що пода\'ється</th><th>Стаття положення</th><th>Статус подання</th><th>Кількість балів</th><th>Коментар перевіряючого</th>';
                    res.appendChild(div);
                
                for (i=0;i<obj.length;i++){
                    var div = document.createElement('tr');
                    div.className = 'color'+obj[i].blstatus;
                    div.innerHTML = '<td>'+obj[i].docname+'</td><td>'+obj[i].stmnt+'</td><td>'+obj[i].status+'</td><td>'+obj[i].nballs+'</td><td>'+obj[i].comments_revisor+'</td>';
                    res.appendChild(div);
                }
                }   }   }
</script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>    <script  src="https://code.jquery.com/jquery-3.4.0.min.js"  integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="  crossorigin="anonymous"></script>    
    <script>
        function clck(){
            var body = "studentcard=" + studentcard.value; 			console.log(body);             request.open("GET", "http://innovations.kh.ua/uni-smart/back/reports.php?"+body);             request.onreadystatechange = reqReadyStateChange;             request.send();
        }
        function clckReport(){   var input = document.createElement("div");                 input.innerHTML = '';                inpt.className = "inpt";                output.appendChild(input);        
            otpt.className = "hide";
            inpt.className = "";

        }
        function clckAnswer(){
            inpt.className = "hide";
            otpt.className = "";

            console.log("clckAnswer");
            var body = "studentId=" + obj.id;
            console.log(body);
            request.open("GET", "http://innovations.kh.ua/uni-smart/back/rep_answer.php?"+body);         request.onreadystatechange = reqReadyStateChange1;             request.send();
        }
        btn.addEventListener("click",clck);
    </script>

<script>
    $('#upload').on('click', function() {
    var file_data = $('#picture').prop('files')[0];
    var docname = $('#docname').val();

    // = $('#statmentId').val();
    var rds = document.getElementsByClassName('rdio');
    console.log(rds);
    var val;
    for (var i=0;i<rds.length;i++){
        if (rds[i].checked){
            val = rds[i].value;
        }
    }
    var statmentId = val;
    var nballs = $('#nballs').val();
    var comments = $('#comments').val();
    console.log(statmentId);
    userid = obj.id;
    var form_data = new FormData();
    form_data.append('userid', userid);
    form_data.append('file', file_data);
    form_data.append('docname', docname);
    form_data.append('statmentId', statmentId);
    form_data.append('nballs', nballs);
    form_data.append('comments', comments);

    console.log(form_data);
    jQuery.ajax({
                url: '/uni-smart/back/upload.php',
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
    var rds = document.getElementsByClassName('rdio');
    for (var i=0;i<rds.length;i++){rds[i].checked = false;} 
    var nballs = $('#nballs').val('');
    var comments = $('#comments').val('');

                }
     });
});
</script>


</body>
</html>