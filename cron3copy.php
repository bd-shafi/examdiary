<?php
exit;
require_once(__DIR__.'/connection.php');

date_default_timezone_set('Asia/Dhaka');
$today = date("Y-m-d H:i:s");
$checktime= date("H");

$sqlrow = "SELECT * FROM examdatapre where cron='0' and errorfound !='1' order by id desc limit 1";

$result = mysqli_query($conn, $sqlrow);
$row = mysqli_fetch_array($result);

$jobid = $row['jobid'];
$id = $row['id'];
if($jobid != NULL){









		 
		 
 $links = 'https://alljobs.teletalk.com.bd/bn/jobs/organization/wis/jobs/'.$jobid;

$filePath = file_get_contents($links);
$dom = new DomDocument();
@ $dom->loadHTML($filePath);
$xcompany = new DOMXpath($dom);


 
 
 
 
 $linkarray = array();
 $otherpages = $xcompany->query('//li[contains(@class,"page-item")]');
 
        foreach ($otherpages as $xelink){
            
            $innerHtml = innerHTML($xelink);
	        $dom = new DomDocument();
	        @ $dom->loadHTML('<?xml encoding="utf-8" ?>' . $innerHtml);
	        
	         $xcompanyforlink = new DOMXpath($dom);
	        $xelemslink = $xcompanyforlink->query("//a[@class='page-link']");
	        foreach ($xelemslink as $indexxx=>$xelemlink){
	         
	            
	            $linkarray[] = $links.''.$xelemlink->getAttribute('href');
	           
                }
        	                
        	              
        }
        
        
$linkarray = array_unique($linkarray);


$alldesignation = '';

foreach($linkarray as $examlink){

$links = $examlink;

$filePath = file_get_contents($links);
$dom = new DomDocument();
@ $dom->loadHTML($filePath);
$xcompany = new DOMXpath($dom);





$xelems = $xcompany->query('//div[contains(@class,"col-lg-8 col-md-9 col-12 pr-0")]');
foreach ($xelems as $xelem){
	$innerHtml = innerHTML($xelem);
	$dom = new DomDocument();
	@ $dom->loadHTML('<?xml encoding="utf-8" ?>' . $innerHtml);
	 
	$getlabel = $dom->getElementsByTagName('a');
	$getlabelh5 = $dom->getElementsByTagName('h5');
	$getlabelh6 = $dom->getElementsByTagName('h6');


 
}

$arrayjoblis = array();

$l=0;
$h5=0;



	foreach ($getlabel as $index=>$xelem){
	   
	    if (strpos($xelem->getAttribute('href'), 'govt/details') !== false) {
            $l++;
			$arrayjoblis[$l]['link']=$xelem->getAttribute('href');
        }
	}
	//$h5=$l;
	foreach ($getlabelh5 as $xelemh5){
	    $h5++;
	    $arrayjoblis[$h5]['h5'] = $xelemh5->nodeValue;
	}
	
	
$c=0;


foreach($arrayjoblis as $index=>$data){
	$c++;
	 
	$arrayjobdetails[$c]['link'] = $data['link'];
	$arrayjobdetails[$c]['designation'] = $data['h5'];
	$alldesignation .=$data['h5'].'#';
	




	if($c==1){
	////// cron4 page data exam details start
	$links = 'https://alljobs.teletalk.com.bd'.$data['link'];


	$filePath = file_get_contents($links);
	$dom = new DomDocument();
	@ $dom->loadHTML($filePath);
	$xcompany = new DOMXpath($dom);



	

	$xelems = $xcompany->query('//div[contains(@class,"col-8 details-border")]');
	foreach ($xelems as $xelem){ 
		$arrayjobdetails[$c][]= trim(preg_replace('/\s\s+/', ' ', preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", trim($xelem->nodeValue))));
	}

	////// cron4 page data exam details end
	}
	



//$arrayjobdetails = super_unique($arrayjobdetails, 'designation');

}

/*
echo '<pre>';
print_r($arrayjobdetails);
echo '</pre>';
*/

}



$startdate = banglatoenglish($arrayjobdetails[1][2], 'Y-m-d');

$enddate = banglatoenglish($arrayjobdetails[1][3],'Y-m-d');

$sarokno= $arrayjobdetails[1][5];

$applyurl = $arrayjobdetails[1][6];

$alldesignationx = explode('#',$alldesignation);
$p=0;
foreach($alldesignationx as $desi){
    $p++;
    $desi = $conn->real_escape_string($desi);
    if($desi != NULL){
    $sql2d=" insert into designation set 
            designation =  '$desi' 
            ";
            $result2d = mysqli_query($conn, $sql2d);
    }
}

$alldesignationAray = array_unique($alldesignationx);

/*
echo '<pre>';
print_r($alldesignationAray);
echo '</pre>';
*/




 $alldesignation = implode(', ', $alldesignationAray);
 $alldesignation = $conn->real_escape_string($alldesignation);
 
 
  $jobarray = array();
            $designationd = explode(',',$alldesignation);
            foreach($designationd as $data){
               
                  
                $jobarray[] = array(
                    'designations'=>$data,
                    'date'=>'',
                    'time'=>'',
                    'examtype'=>''
                    );
                     
            }
              
              $examdateall = json_encode($jobarray, JSON_UNESCAPED_UNICODE);
 
 
 
  echo $sql2=" update examdatapre set 
            startdate =  '$startdate',
            enddate='$enddate',
			sarokno =  '$sarokno',
			applyurl =  '$applyurl',
       
            examdateall='$examdateall',
            totalpost='$p'
            where id='$id'
            ";
            $result2 = mysqli_query($conn, $sql2);
            
            if($result2){
                
                $sql2=" update examdatapre set cron =  '1' where id='$id' ";
                $result2 = mysqli_query($conn, $sql2);
                
            }else{
                 $sql2=" update examdatapre set errorfound =  '1' where id='$id' ";
                $result2 = mysqli_query($conn, $sql2);
            }









}










function super_unique($array,$key)
    {
       $temp_array = [];
       foreach ($array as &$v) {
           if (!isset($temp_array[$v[$key]]))
           $temp_array[$v[$key]] =& $v;
       }
       $array = array_values($temp_array);
       return $array;

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