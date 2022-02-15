<?php
    include("classes/extraballs.php");
    include("classes/organisation.php");

        $org =  new organisation;
   
        $inn = $_GET["inn"];

        $org->init($inn);
        
		header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json; charset=utf-8');
        
//        echo $st->studentcard;
//        echo $st->firstname;
//        echo $st->lastname;

        $org->fileLog();
    //    $org->dbIn();
        $org->jsonOut();

?>