<?php
    include("classes/extraballs.php");
    include("classes/student.php");

    $exB = new extraBalls;
    $st =  new student;
   
        $studentcard = $_GET["studentcard"];

        $st->init($studentcard);
        
		header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json; charset=utf-8');
        
//        echo $st->studentcard;
//        echo $st->firstname;
//        echo $st->lastname;

        $st->fileLog();
        $st->dbIn();
        $st->jsonOut();

?>