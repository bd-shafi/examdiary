<?php
require_once(__DIR__.'/connection.php');
date_default_timezone_set('Asia/Dhaka');
  $checktime= date("H");
  $today = date("Y-m-d H:i:s");
 
if($checktime >= 9 && $checktime <=18){
$sql = "SELECT *  FROM cron  ";
     
    $result = mysqli_query($conn, $sql);
  $dataarray = array();
    if (mysqli_num_rows($result) > 0) {
     $i=0;
        
        while($row = mysqli_fetch_assoc($result)) {
            $i++;
           $dataarray[]=$row;
        }
    }
     
    
    if($dataarray[0]['id'] == 1 && $dataarray[0]['croncall'] ==0){
        require_once(__DIR__.'/cron.php');
          $sqlup = "update cron set 
        croncall='0',
		time='$today'
			
        where id='2'
        ";
     
    $resultup = mysqli_query($conn, $sqlup);
    
    
    $sqlup = "update cron set 
        croncall='1', 
		time='$today'
        where id='1'
        ";
     
    $resultup = mysqli_query($conn, $sqlup);
    }else if($dataarray[1]['id']  == 2 && $dataarray[1]['croncall'] ==0){
         require_once(__DIR__.'/cron2.php');
         $sqlup = "update cron set 
        croncall='0',
		time='$today' 
        where id='3'
        ";
     
    $resultup = mysqli_query($conn, $sqlup);
    
     $sqlup = "update cron set 
        croncall='1',
		time='$today' 
        where id='2'
        ";
     
    $resultup = mysqli_query($conn, $sqlup);
    }else if($dataarray[2]['id']  == 3 && $dataarray[2]['croncall'] ==0){
        require_once(__DIR__.'/cron3.php');
        $sqlup = "update cron set 
        croncall='0',
		time='$today' 
        where id='4'
        ";
     
    $resultup = mysqli_query($conn, $sqlup);
    
    $sqlup = "update cron set 
        croncall='1',
		time='$today' 
        where id='3'
        ";
     
    $resultup = mysqli_query($conn, $sqlup);
    }else {
         require_once(__DIR__.'/subtabletomaintable.php');
        $sqlup = "update cron set 
        croncall='0',
		time='$today' 
        where id='1'
        ";
          $resultup = mysqli_query($conn, $sqlup);
     $sqlup = "update cron set 
        croncall='1',
		time='$today' 
        where id='4'
        ";
     
  
    $resultup = mysqli_query($conn, $sqlup);
    }
}
    $conn -> close();