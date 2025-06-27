<?php
require_once(__DIR__.'/connection.php');

date_default_timezone_set('Asia/Dhaka');
$today = date("Y-m-d H:i:s");
$checktime= date("H");
$jobdata = array();
$jobdataid = array();
$sql = "SELECT *  FROM examdatapreold where cron='1' limit 50 ";
     
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
     $i=0;
      
        
        while($row = mysqli_fetch_assoc($result)) {
                $jobdata[]= array(
                'id'=>$row['id'],
                'jobshortcode'=>$row['jobshortcode'],
                'startdate'=>$row['startdate'],
                'designation'=>$row['designation'],
                'sarokno'=>$row['sarokno'],
                'enddate'=>$row['enddate']
                );
                

 
        }
    }
    
        $result = array();
        foreach ($jobdata as $element) {
            $result[$element['jobshortcode']][$element['startdate']][] = $element;
        }

        echo '<pre>';
        print_r($jobdata);
        echo '</pre>';
        
       
         
        echo '<pre>';
        print_r($result);
        echo '</pre>';
        
       