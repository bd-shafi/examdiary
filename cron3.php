<?php
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
$h6=0;



	foreach ($getlabel as $index=>$xelem){
	   
	    if (strpos($xelem->getAttribute('href'), 'govt/details') !== false) {
            $l++;
			$arrayjoblis[$l]['link']=$xelem->getAttribute('href');
			
            $getjobidsingle = explode('/details/',$xelem->getAttribute('href'));
            $getjobidsingle1 = explode('/',$getjobidsingle[1]);
            $singlejobid = $getjobidsingle1[0];
        }
	}
	//$h5=$l;
	foreach ($getlabelh5 as $xelemh5){
	    $h5++;
	    $arrayjoblis[$h5]['h5'] = $xelemh5->nodeValue;
	}
	foreach ($getlabelh6 as $xelemh6){
	    $h6++;
		if(strpos($xelemh6->nodeValue, 'শেষ তারিখ:') !== false){
			$arrayjobdetails['append'] = $xelemh6->nodeValue;
		}
		if(strpos($xelemh6->nodeValue, 'প্রকাশিত:') !== false){
			$arrayjobdetails['appst'] = $xelemh6->nodeValue;
		}
	     
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
	
	
	// for file/
	/* disabled for high load....
	$getlabelh5 = $dom->getElementsByTagName('iframe');

 
foreach ($getlabelh5 as $index=>$xelem){
	   
	      
		 $file_url = "https://alljobs.teletalk.com.bd/".$xelem->getAttribute('src');

			$filenameck = parse_url($file_url, PHP_URL_PATH);
			$ext = pathinfo($filenameck, PATHINFO_EXTENSION);

			// extracted basename
			$filename= $row['shortcode'].'_'.$row['applystart'].'_'.$row[id].'_'.$row['oldjobid'].'_'.time().'.'.$ext;
			

			$destination_path = __DIR__ ."/circularpdfimages/".$filename;

			$fp = fopen($destination_path, "w+");

			$ch = curl_init($file_url);
			curl_setopt($ch, CURLOPT_FILE, $fp);
			 utf8_decode(curl_exec($ch));
			$st_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			fclose($fp);

			if($st_code == 200){
			 //echo 'File downloaded successfully!';
			////////  $sqlf = "update examdata set file='1' where id = '$row[id]' limit 1 ";
     
			///////$resultf = mysqli_query($conn, $sqlf);
			}else{
			 //echo 'Error downloading file!';
			  
			}
			$filex = 'circularpdfimages/'.$filename;
			//circularpdfimages/25072023155807dmtcl_Page_1.png
			
		 	$filequery = "insert into circularpdfimages set
             
                oldjobid='$singlejobid',
                imageurl='/$filex',
                time='$today',
				uploadedby='1',
                status='1'
                
             ";
			$conn->query($filequery);
         
	
	
	
	}
	*/
    // for file end


//$arrayjobdetails = super_unique($arrayjobdetails, 'designation');

}

 /*
echo '<pre>';
print_r($arrayjobdetails);
echo '</pre>';
 */

}




















































$appst = explode('প্রকাশিত: ', $arrayjobdetails['appst']);
$append = explode('শেষ তারিখ: ', $arrayjobdetails['append']);

$appstenglish = banglatoenglish($appst[1], 'Y-m-d');
$appendenglish = banglatoenglish($append[1], 'Y-m-d');

if($appstenglish !='1970-01-01'){
	$startdate = $appstenglish;
}else{
	$startdate = banglatoenglish($arrayjobdetails[1][2], 'Y-m-d');
}

if($appendenglish !='1970-01-01'){
	$enddate = $appendenglish;
}else{
	$enddate = banglatoenglish($arrayjobdetails[1][3],'Y-m-d');
}







$sarokno= $arrayjobdetails[1][5];

$applyurl = $arrayjobdetails[1][6];
//$data['link']

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
               
                  if($data !=' '){
                $jobarray[] = array(
                    'designations'=>$data,
                    'date'=>'',
                    'time'=>'',
                    'examtype'=>''
                    );
				  }
                     
            }
              
              $examdateall = json_encode($jobarray, JSON_UNESCAPED_UNICODE);
 
 
 
    $sql2=" update examdatapre set 
            startdate =  '$startdate',
            enddate='$enddate',
			sarokno =  '$sarokno',
			applyurl =  '$applyurl',
			singlejobid='$singlejobid',
			
       
            examdateall='$examdateall',
            totalpost='$p'
            where id='$id'
            ";
              $result2 = mysqli_query($conn, $sql2);
            
            if($result2){
                
                $sql2=" update examdatapre set cron =  '1',addedtomaintable ='0' where id='$id' ";
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
$conn -> close();