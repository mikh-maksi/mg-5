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
<?php
    include "config.php";
    include "connect.php";
    include "functions.php";
   
    $serviceId = $_GET['s'];
    $periodId = $_GET['p'];

    $classes = "";
    if (isset($_GET['f']))   {$flatId = $_GET['f']; $classes.=" flat";} else $flatId = 0;
?>
<body class = "acc <?php echo $classes;?>">

<?php
if (isset($_GET['p'])){
        $np = $_GET['p'];
        $mp = $_GET['p'];
    }
    else{
        $np = 1;
        $mp = periodMax($mysqli);
    }

//for ($p=$mp;$p>=$np;$p--){
    accruals(2,10,$mysqli);
//}
 ?>

</body>
</html>
