<?php
set_time_limit(500);
header("Content-Type: text/html; charset=utf-8");
require_once(__DIR__.'/connection.php');

date_default_timezone_set('Asia/Dhaka');
$today = date("Y-m-d H:i:s");
 $sql = "SELECT id, oldjobid,shortcode, applystart FROM examdata where file='0' and filecron='0' and oldjobid!='0' limit 1 ";
     
    $result = mysqli_query($conn, $sql);
    
 $string ='<div id="accordiontop"> ';
  $applyby = '';
    if (mysqli_num_rows($result) > 0) {
     $i=0;
      
        
        while($row = mysqli_fetch_assoc($result)) {
			
			
			
			 $sqlf = "update examdata set filecron='1' where id = '$row[id]' limit 1 ";
     
			$resultf = mysqli_query($conn, $sqlf);
			
            $i++;


  $links = 'https://alljobs.teletalk.com.bd/bn/jobs/govt/details/'.$row['oldjobid'].'/';

$filePath = file_get_contents($links);
$dom = new DomDocument();
@ $dom->loadHTML($filePath);


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
			  $sqlf = "update examdata set file='1' where id = '$row[id]' limit 1 ";
     
			$resultf = mysqli_query($conn, $sqlf);
			}else{
			 //echo 'Error downloading file!';
			  
			}
			$filex = 'circularpdfimages/'.$filename;
			//circularpdfimages/25072023155807dmtcl_Page_1.png
			
		 	$filequery = "insert into circularpdfimages set
             
                incidentid='$row[id]',
                imageurl='/$filex',
                time='$today',
				uploadedby='1',
                status='1'
                
             ";
			$conn->query($filequery);
         
	
	
	
	}
 
	 
	  
	 
	
	
	
	
	
	
	
	
	}
}
exit;


