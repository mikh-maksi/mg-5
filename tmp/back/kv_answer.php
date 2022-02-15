 <?php
    include "../config.php";
    include "../connect.php";

    class flatPay{
        var $flatId;
        var $receipts;
        var $payments;
    }

    class receipt{
        var $id;
        var $flatId;
        var $periodId;
        var $picture;
        var $dateTimeIn;
    }
    class payment{
        var $id;
        var $receiptId;
        var $flatId;
        var $serviceId;
        var $peridId;
        var $sum;
        var $picture;
        var $dateTimeIn;
    }

    $rcpt = new receipt;
    $rcpts = [];
    $kvId = $_REQUEST['kvId'];

    $sql = 'SELECT * FROM receipts WHERE flatId = "'.$kvId.'"';
     if ($result = $mysqli->query($sql)) { 
         while($row = $result->fetch_row() ){
            $rcpt = new receipt; 
            $rcpt->id = $row[0];
            $rcpt->flatId = $row[1];
            $rcpt->periodId = $row[2];
            $rcpt->picture = $row[3];
            $rcpt->datetime = $row[4];
            $rcpts[]=$rcpt;
             } 
         $result->close(); 
     }
     $pmnt = new payment;
     $pmnts = [];
     
     $sql = 'SELECT * FROM payments WHERE flatId = "'.$kvId.'"';
     if ($result = $mysqli->query($sql)) { 
         while($row = $result->fetch_row() ){
            $pmnt = new receipt; 
            $pmnt->id = $row[0];
            $pmnt->receiptId = $row[1];
            $pmnt->flatId = $row[2];
            $pmnt->serviceId = $row[3];
            $pmnt->periodId = $row[4];
            $pmnt->sum = $row[5];
            $pmnt->picture= $row[6];
            $pmnt->datetime = $row[7];

            $pmnts[]=$pmnt;
             } 
         $result->close(); 
     }



    $flpy = new flatPay();
    $flpy->flatId =  $kvId;

    $flpy->receipts = $rcpts;
    $flpy->payments = $pmnts;
	header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json; charset=utf-8');
    
    echo json_encode($flpy);
?>