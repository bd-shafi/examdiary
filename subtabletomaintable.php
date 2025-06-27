<?php
require_once(__DIR__.'/connection.php');

date_default_timezone_set('Asia/Dhaka');
$today = date("Y-m-d H:i:s");
$checktime= date("H");

   $sql = "SELECT *  FROM examdatapre where addedtomaintable ='0' and cron='1' ";
     
    $result = mysqli_query($conn, $sql);
  
    if (mysqli_num_rows($result) > 0) {
     $i=0;
        
        while($row = mysqli_fetch_assoc($result)) {
            $i++;
            
            
            echo '</br>';
           echo $sqlrow = "SELECT * FROM examdata where shortcode='$row[jobshortcode]' and applystart='$row[startdate]' and applyend='$row[enddate]' and addedfromsubtable='0' ";
           echo '</br>';
            
            $results = mysqli_query($conn, $sqlrow);
            $rows = mysqli_fetch_array($results);
            
           $mainid = $rows['id'];
           $shortcode = $rows['shortcode'];
           
          echo $mainid.'='.$shortcode.' / '.$row['jobid'].'='.$row['jobshortcode'].'</br></br>';
          if($mainid != NULL){
              
              $sqlup = "
                    update examdata set
                    examdateall='$row[examdateall]',
                    sarokno='$row[sarokno]',
                    addedfromsubtable='1',
					examdataprejobid='$row[jobid]',
                    oldjobid='$row[singlejobid]',
                    typeofpost='$row[totalpost]',
					 time = '$today'
                    where id='$mainid'
                    ";
                    $resultup = mysqli_query($conn, $sqlup);
                    
                if($resultup){
					$getalldesignationdecode = json_decode($row['examdateall'], true);
					if(!empty($getalldesignationdecode)){
                    $sqluppre = "
                    update examdatapre set
                    addedtomaintable='1',
                    full='0' 
                    where id='$row[id]'
                    ";
					$resultuppre = mysqli_query($conn, $sqluppre);
					}
                }
          
         
          }else{
              /// insert into examdata = designation //sarokno  addedfromsubtable demojobid
              /// update examdatapre = addedtomaintable=1 full=1
              
              
         echo   $sql2=" insert into examdata set 
            userid =  '1',
            otherusers='',
			phone =  '01810982876',
			email =  'upwork.shafi@gmail.com',
            organization = '$row[organization]', 
            examdateall='$row[examdateall]',
            examtype='Unknown',
            applyby='teletalk',
            shortcode = '$row[jobshortcode]',
            examdate = 'No Published',
            examtime = '',
            applystart = '$row[startdate]',
            applyend = '$row[enddate]',
            applyurl='$row[applyurl]',
            sarokno='$row[sarokno]',
            addedfromsubtable='1',
            typeofpost='$row[totalpost]',
			examdataprejobid='$row[jobid]',
            oldjobid='$row[singlejobid]',
            examlocation = '',
            details='',
            notifyme='0',
            cronadd='1',
            time = '$today'
            ";
            $result2 = mysqli_query($conn, $sql2);
            
            if($result2){
                $sqluppre = "
                    update examdatapre set
                    addedtomaintable='1',
                    full='1' 
                    where id='$row[id]'
                    ";
                $resultuppre = mysqli_query($conn, $sqluppre);
            }
            
            
            
          }
          
          
          
		  
		 
        }
    }
    $conn -> close();