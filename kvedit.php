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
    <div class="deactive">
        <button id = 'sndUpd' style = "">Змінити</button>
        <button id='uploadInvoice'>Відправити</button>
    </div>
    <div id="output"></div>
    
    <?php
    include "config.php";
    include "connect.php";
    include "functions.php";

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

    <div class = "acc">
    <div class="wrapperTbl" >
        <div id = "Accruals">
        </div>
        </div>
    </div>
<!--
    <div class="" id = "ElektroOut">
<?php
      /*  function flat($id,$mysqli){
            $sql = 'SELECT * FROM flats WHERE id ='.$id;
            $out = ''; 
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_row() ){
                    $out = $row[1];
                }}
            return $out;
        }
*/


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
    var elektroFlag = 0;    var kvUpdFlag = 0;  var invoiceFlag = 0; var accrualsFlag = 0;

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
                info.innerHTML = '<div class="alert alert-success" role="alert"> <h4 class="alert-heading">Інформация про квартиру</h4>  <p>№: <b>'+obj.name+'</b> Етаж: <b>'+obj.floor+'</b> Площа: <b>'+obj.sq+'</b><br> Контакт: <b>'+obj.contact+'</b> Власник: <b>'+obj.owner+'</b> <br>Код Мегабанку: <b>'+obj.mgbcode+'</b>Коментар: <b>'+obj.comments+'</b> id: <b>'+obj.id+'</b>  </p>  <hr>  <p class="mb-0"></p></div>';            
                output.appendChild(info);  
                
                var d = document.createElement("div");
                d.setAttribute("role","alert");
                d.setAttribute("id","usrUpd");
                
                d.className ="hide";

                
                d.insertAdjacentHTML('beforeend', "<span>Контакт:</span><input id = 'contact' value = "+obj.contact+"><br>");
                d.insertAdjacentHTML('beforeend', "<span>Власник:</span><input id = 'owner' class = 'inptOwner' value = '"+obj.owner+"'><br>");
                d.insertAdjacentHTML('beforeend', "<span>Коментар:</span><input id = 'comments' value = "+obj.comments+"><div id = 'beforebutton'></div>" );



                var invoice = document.createElement("div");
                invoice.innerHTML = '<div class = "inpt hide" id = "invoice"><div><input id = "kvid" type = hidden value ='+obj.id+'><!--<select id = "invoiceflat"><?php echo flatsList($mysqli); ?></select>--><span>Сума:</span><input type="input" id = "invoicesumg" min = 0>грн. <input type="input" id = "invoicesumk" maxlength=2 >к.<br><span>Послуга:</span> <select id = "invoiceservice"><?php echo serviceList($mysqli); ?></select><br><span>Період:</span> <select id = "invoiceperiod"><?php echo periodList($mysqli); ?></select><br><span>Коментарі:</span> <input type = "text" id = "invoiceComments"><br><span>Фото/скан платіжки:</span><input id="invoicepicture" type="file" name="pic" /><br> <div id = "beforebuttoninvoice"></div></div></div>';
                //d.remove();
                var input = document.createElement("div");

                input.innerHTML = '<div class = "inpt"><div><button class = "act" id = "btnElektro">Ввести показники<br> електролічільника</button><button class = "deact" id = "btnElektroOut">Показники<br> електролічільника</button><button class = "act" id = "btnInvoice">Внести<br> квітанцію</button><button class = "act" id = "btnAccruals">Показати<br> нарахування</button><button class = "act" id = "btnKvUpd">Змінити<br> данні</button></div></div>';
                
               
                output.appendChild(input); 
                output.appendChild(invoice); 
                output.appendChild(d);   
              

               
                btnElektro.addEventListener("click",fncElektro);
                btnKvUpd.addEventListener("click",fncKvUpd);
                btnInvoice.addEventListener("click",fncInvoice); 
                btnAccruals.addEventListener("click",fncAccruals); 
               // uploadInvoice.addEventListener("click",fncUploadInvoice);               
                }   }   }


                function moneyOut(money100){
        if (Math.abs(money100%100) < 10)
            headO = "0"+Math.abs(money100%100);
        else
            headO = Math.abs(money100%100);
        return Math.trunc(money100/100)+","+headO;
    }


/* */
var request = new XMLHttpRequest();   var obj;
    function reqAccruals() {/*console.log(request.readyState);*/
        if (request.readyState == 4) {    
            var status = request.status;
            if (status == 200) { 
                obj = JSON.parse(request.responseText);
                console.log(obj);
                var a = obj.accruals;

                
             /*   document.getElementById("Accruals").innerHTML=
                "<table><tr><td colspan = 4>Електрика</td><td  colspan = 4>Квартплата</td><td  colspan = 4>Опалення</td><td  colspan = 4>Холодна вода</td><td  colspan = 4>Каналізація</td><td  colspan = 4>Вивезення мусору</td><td  colspan = 4>Інтернет</td></tr>"+
                "<tr><td>Борг на 01</td><td>Сплачено</td><td>Нарахування</td><td>До сплати</td><td>Квартплата</td><td>Опалення</td><td>Холодна вода</td><td>Каналізація</td><td>Вивезення мусору</td><td>Інтернет</td>"+
                "<tr><td>"+obj.accruals[1]+"</td><td>Квартплата</td><td>Опалення</td><td>Холодна вода</td><td>Каналізація</td><td>Вивезення мусору</td><td>Інтернет</td>"+
                "</table>";  */
                var out = "";
                var serviceName = ["Електрика","Квартплата","Опалення","Холодна вода","Каналізація","Вивезення мусору","Інтернет"];
                for(i=1;i<=6;i++){
                console.log(isNaN(obj.debts[i]));
                console.log(isNaN(obj.accruals[i]));
                console.log(isNaN(obj.payments[i]));

                console.log(obj.debts[i] === undefined);
                console.log(obj.accruals[i] === undefined);
                console.log(obj.payments[i] === undefined);

                dbts = obj.debts[i];
                accruals = obj.accruals[i];
                payments = obj.payments[i];

                if (isNaN(dbts) || dbts === undefined) {dbts = 0;}
                if (isNaN(accruals) || accruals === undefined) {accruals = 0;}
                if (isNaN(payments) || payments === undefined) {payments = 0;}                
              
                console.log(serviceName[i-1]);
                console.log(dbts,accruals,payments);                

                out +=  "<table><tr><td colspan = 4>"+serviceName[i-1]+"</td>"+
                "<tr><td>Борг на 01</td><td>Нара-<br>хування</td><td>Сплачено</td><td>До сплати</td>"+
                "<tr><td>"+moneyOut(dbts)+"</td><td>"+moneyOut(accruals)+"</td><td>"+moneyOut(payments)+"</td><td>"+moneyOut(Number(dbts)+Number(accruals)-Number(payments)) +" </td>"+
                "</table>";
                }
            
                document.getElementById("Accruals").innerHTML=out;
                    
                }   }   }


/* */

                function reqReadyStateChangeUpd() {/*console.log(request.readyState);*/
        if (request.readyState == 4) {    
            var status = request.status;
            if (status == 200) { 
                obj = JSON.parse(request.responseText);
                console.log(request.responseText);
                console.log(obj);

                 
                }   }   }




                function flatReg(){
                    console.log("flatReg");
                }

                function fncAccruals(){
                    console.log('fncAccruals');

                    var body = "kv=" + kv.value+"&per=10";
                    request.open("GET", "http://innovations.kh.ua/mg-5/back/accruals.php?"+body);
                    console.log('fncAccruals');
                    console.log(body);
                    request.onreadystatechange = reqAccruals;             request.send();
                   
                    if (accrualsFlag) {Accruals.className = "hide"; elektroField.className = "hide";  usrUpd.className = "hide"; invoice.className = "hide";
                        kvUpdFlag = 0; invoiceFlag = 0;}
                        else         {Accruals.className = "";  elektroField.className = "hide"; usrUpd.className = "hide"; invoice.className = "hide";}

                        accrualsFlag = 1 - accrualsFlag;

                }

                function fncElektro(){
                    console.log('elektro'); 
                    console.log(elektroFlag);
                    if (elektroFlag) {elektroField.className = "hide"; usrUpd.className = "hide"; invoice.className = "hide"; Accruals.className = "hide";
                        kvUpdFlag = 0; invoiceFlag = 0; accrualsFlag = 0;}
                        else         {elektroField.className = ""; usrUpd.className = "hide"; invoice.className = "hide"; Accruals.className = "hide";}

                        elektroFlag = 1 - elektroFlag;
                }
                function fncKvUpd(){
                    console.log('kvUpd'); 
                    console.log(kvUpdFlag);
                    if (kvUpdFlag) {usrUpd.className = "hide"; elektroField.className = "hide"; invoice.className = "hide"; Accruals.className = "hide";
                        elektroFlag = 0; invoiceFlag = 0; accrualsFlag = 0;
                    }
                        else       {  usrUpd.className = ""; elektroField.className = "hide"; invoice.className = "hide"; Accruals.className = "hide";}

                        kvUpdFlag = 1 - kvUpdFlag;
                        beforebutton.after(sndUpd);         
                }
                function fncInvoice(){
                    console.log('Invoice'); 
                    if (invoiceFlag) {invoice.className = "hide"; usrUpd.className = "hide"; elektroField.className = "hide"; Accruals.className = "hide";
                        elektroFlag = 0;  kvUpdFlag = 0; accrualsFlag = 0;
                    }
                        else         {invoice.className = ""; usrUpd.className = "hide"; elektroField.className = "hide"; Accruals.className = "hide";}

                        invoiceFlag = 1 - invoiceFlag;
                       
                        beforebuttoninvoice.after(uploadInvoice);         
                        //fncInvoice
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

        function sndUpdFnc(){
            console.log('sndUpd');
            var body = "kv="+kv.value+"&contact=" + contact.value+"&owner="+owner.value+"&comments="+comments.value;
            request.open("GET", "http://innovations.kh.ua/mg-5/back/kvedit.php?"+body);
            request.onreadystatechange = reqReadyStateChangeUpd;        
            request.send();
        }
       
       /* $('#uploadInvoice').on('click', function() {
            console.log('Invoice');
        });*/

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

        function fncUploadInvoice(){
            console.log(invoiceflat.value);
            console.log(invoicesumg.value);
            console.log(invoicesumk.value);
            console.log(invoiceservice.value); 
            console.log(invoiceperiod.value); 
            console.log(invoiceComments.value); 
            console.log(invoiceComments.value); 
            /*
            var body = "kv="+kv.value+"&contact=" + contact.value+"&owner="+owner.value+"&comments="+comments.value;
            request.open("GET", "http://innovations.kh.ua/mg-5/back/kvedit.php?"+body);
            request.onreadystatechange = reqReadyStateChangeUpd;        
            request.send();       */     
        }


        btn.addEventListener("click",clck);
        sndUpd.addEventListener("click",sndUpdFnc);
    </script>

<script>

    $('#uploadInvoice').on('click', function() {
        
        console.log('uploadInvoice');
    var file_data = $('#invoicepicture').prop('files')[0];
    console.log(file_data);
    var invoiceflatv = $('#invoiceflat').val();
    var invoicesumgv = $('#invoicesumg').val();
    var invoicesumkv = $('#invoicesumk').val();
    var invoiceservicev = $('#invoiceservice').val();
    var invoiceperiodv = $('#invoiceperiod').val();
    var invoiceCommentsv = $('#invoiceComments').val();
    

    invoicesumkv = Number(invoicesumkv);
    if (invoicesumkv<10) {invoicesumkv= '0'+ invoicesumkv;}
    if (invoicesumkv=='0') {invoicesumkv= '00'}

    var sum =  invoicesumgv + invoicesumkv;
    
    userid = obj.id;
    var form_data = new FormData();

    form_data.append('fl', file_data);
  //  form_data.append('flat', invoiceflatv);
    form_data.append('flat', kvid.value);
    form_data.append('service', invoiceservice.value);
    form_data.append('sum', sum);
    form_data.append('period', invoiceperiodv);
    console.log("invoiceservice.value",invoiceservice.value);
    console.log("kvid ",kvid.value);
    console.log("obj.id ",obj.id);
    console.log("sum ",sum);
    console.log("invoiceperiodv ",invoiceperiodv);    

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
                    alert("Дані відправлено");
                    $('#invoicesumg').val('');
                    $('#invoicesumk').val('');
                    $('#invoicepicture').val('');
                   // $('#elektroLink').html('<a href =  http://innovations.kh.ua/mg-5/elektro_out.php target = _blank>Перевірити введені дані</a>');
                    console.log('ok');
                }
     });
});



</script>


</body>
</html>