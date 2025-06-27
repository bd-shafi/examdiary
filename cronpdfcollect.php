<?php
exit;
require_once(__DIR__.'/connection.php');

date_default_timezone_set('Asia/Dhaka');
$today = date("Y-m-d H:i:s");
$checktime= date("H");

    $sql = "SELECT examdatapreold.*, examdata.id as eid  FROM examdata
   left join examdatapreold on examdatapreold.jobshortcode=examdata.shortcode and examdatapreold.startdate=examdata.applystart and examdatapreold.enddate=examdata.applyend  
   group by examdata.id
   ";
     
    $result = mysqli_query($conn, $sql);
  
    if (mysqli_num_rows($result) > 0) {
     $i=0;
        
        while($row = mysqli_fetch_assoc($result)) {
            $i++;
            
            $getjobid = explode('/',$row['jobid']);
           echo $i.') ';
            echo  $sqlup = "update examdata set
                 
                    oldjobid='$getjobid[5]'
                    
                    where id='$row[eid]'
                    ";
                   $resultup = mysqli_query($conn, $sqlup);
        echo '</br>';
          
          $getjobid = '';
		  
		 
        }
    }