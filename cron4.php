<?php
require_once(__DIR__.'/connection.php');

date_default_timezone_set('Asia/Dhaka');
$today = date("Y-m-d H:i:s");
$checktime= date("H");

$sql = "SELECT *  FROM examdatapreold where cron='0' and errorfound !='1' limit 20 ";
     
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
     $i=0;
      
        
        while($row = mysqli_fetch_assoc($result)) {



 $links = 'https://alljobs.teletalk.com.bd'.$row['jobid'];


$filePath = file_get_contents($links);
$dom = new DomDocument();
@ $dom->loadHTML($filePath);
$xcompany = new DOMXpath($dom);



$arrayjobdetails= array();

$xelems = $xcompany->query('//div[contains(@class,"col-8 details-border")]');
$i=0;
foreach ($xelems as $xelem){ 
    if($i==2 || $i==3){
        	$arrayjobdetails[]= banglatoenglish(trim(preg_replace('/\s\s+/', ' ', preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", trim($xelem->nodeValue)))),'Y-m-d');
    }else{
        	$arrayjobdetails[]= trim(preg_replace('/\s\s+/', ' ', preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", trim($xelem->nodeValue))));
    }

	$i++;
}
/*
echo '<pre>';
print_r($arrayjobdetails);
echo '</pre>';
*/
$sql2=" update examdatapreold set 
            organization='$arrayjobdetails[0]',
            jobshortcode='$arrayjobdetails[1]',
            startdate =  '$arrayjobdetails[2]',
            enddate='$arrayjobdetails[3]',
			sarokno =  '$arrayjobdetails[5]',
			applyurl =  '$arrayjobdetails[6]'
       
            where id='$row[id]'
            ";
            $result2 = mysqli_query($conn, $sql2);
            
            
            if($arrayjobdetails[1] != NULL){
                if($result2){
                    
                    $sql2=" update examdatapreold set cron =  '1' where id='$row[id]' ";
                   $result2 = mysqli_query($conn, $sql2);
                    
                }else{
                     $sql2=" update examdatapreold set errorfound =  '1' where id='$row[id]' ";
                  $result2 = mysqli_query($conn, $sql2);
                }
            }else{
                 $sql2=" update examdatapreold set errorfound =  '1' where id='$row[id]' ";
                  $result2 = mysqli_query($conn, $sql2);
            }
sleep(1);
}
}

function banglatoenglish($banglaDate='', $format=''){
     

     $search_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "জানুয়ারি", "ফেব্রুয়ারি", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", ":", ",");

    $replace_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", ":", ","); 
// convert all bangle char to English char 
    $en_number = str_replace($search_array, $replace_array, $banglaDate);   

    // remove unwanted char       
    $end_date =  preg_replace('/[^A-Za-z0-9:\-]/', ' ', $en_number);

    // convert date
   return $bangla_date = date("$format", strtotime($end_date));
}


























function innerHTML($node) {
    return implode(array_map([$node->ownerDocument,"saveHTML"], 
                             iterator_to_array($node->childNodes)));
}