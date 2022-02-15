<?php
        include('classes/student.php');
    
        $st = new student;
   
       
       $st->firstname = $_GET["firstname"];
       $st->lastname = $_GET["lastname"];
       $st->fathername = $_GET["fathername"];
       $st->school = $_GET["school"];
       $st->course = $_GET["course"];
       $st->studentgroup = $_GET["studentgroup"];
       $st->studentcard = $_GET["studentcard"];
       $st->phone = $_GET["phone"];
       $st->email = $_GET["email"];
      




   /**/  
        
		header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json; charset=utf-8');
        $st->fileLog();
        $st->dbIn();
        $st->jsonOut();

?>