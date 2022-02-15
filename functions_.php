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
    function flatsList($mysqli){
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
        return $out;
    }
        function serviceName($id,$mysqli){
            $sql = 'SELECT * FROM services WHERE id ='.$id;
            $out = ''; 
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_assoc() ){
                    $out = $row["name"];
                }}
            return $out;
        }
        function serviceList($mysqli){
            $sql = 'SELECT * FROM services';
            $out = ''; 
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_row() ){
                    $out .= "<option value = ".$row[0]."> ".$row[1]."</option>";
                }}
            return $out;
        }
        function serviceColor($id,$mysqli){
            $sql = 'SELECT * FROM services WHERE id ='.$id;
            $out = ''; 
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_assoc() ){
                    $out = $row['color'];
                }}
            return $out;
        }
        function periodName($id,$mysqli){
            $sql = 'SELECT * FROM periods WHERE id ='.$id;
            $out = ''; 
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_assoc() ){
                    $out = $row["name"];
                }}
            return $out;
        }
        function periodMax($mysqli){
            $sql = 'SELECT MAX(id) FROM periods';
            $out = ''; 
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_row() ){
                    $out = $row[0];
                }}
            return $out;
        }
        function periodList($mysqli){
            $sql = 'SELECT * FROM periods ORDER BY id DESC';
            $out = ''; 
            if ($result = $mysqli->query($sql)) { 
                while($row = $result->fetch_row() ){
                    $out .= "<option value = ".$row[0]."> ".$row[1]."</option>";
                }}
            return $out;
        }


    function moneyOut($money100){
        if (abs($money100%100) < 10)
            $headO = "0".abs($money100%100);
        else
            $headO = abs($money100%100);
        return intval($money100/100).",".$headO;
    }

