<?php
  include "config.php";
  include "connect.php";


  function actualPeriod($type,$mysqli){
    $actualPeriod = '';
    $sql = 'SELECT actualPeriod FROM generalData WHERE id = 1';
    echo $sql;
    if ($result = $mysqli->query($sql)) { 
        while($row = $result->fetch_row() ){
            $actualPeriod = $row[0];
        } 
        $result->close(); 
    }
    echo $actualPeriod ;
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
    echo actualPeriod(2,$mysqli);

?>