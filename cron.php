<?php
require_once(__DIR__.'/connection.php');

date_default_timezone_set('Asia/Dhaka');
$today = date("Y-m-d H:i:s");
echo $checktime= date("H");
//&& $checktime<=18
if($checktime >= 9 && $checktime <=20){

$remoteurl = 'http://vas.teletalk.com.bd/clientLivejobs.php';
$dom = new DOMDocument();  

//load the html  
$html = $dom->loadHTMLFile($remoteurl);  

  //discard white space   
$dom->preserveWhiteSpace = false;   

  //the table by its tag name  
$tables = $dom->getElementsByTagName('table');   


    //get all rows from the table  
$rows = $tables->item(0)->getElementsByTagName('tr');   
  // get each column by tag name  
$cols = $rows->item(0)->getElementsByTagName('th');   
$row_headers = NULL;

$i=0;
foreach ($cols as $node) {
  
    //print $node->nodeValue."\n";   
    $row_headers[] = $node->nodeValue;
}   

$table = array();
  //get all rows from the table  
//$rows = $tables->item(0)->getElementsByTagName('tr');   

foreach ($rows as $row)   
{   
   // get each column by tag name  
    $cols = $row->getElementsByTagName('td');   
    $row = array();
    $i=0;
    foreach ($cols as $node) {
        # code...
    
        //print $node->nodeValue."\n";   
        if($row_headers==NULL)
            $row[] = $node->nodeValue;
        else
            $row[$row_headers[$i]] = $node->nodeValue;
        $i++;
    }   
    $table[] = $row;
}   


$part = array_splice($table, 0,12);

$arrryofjob = array();

$e=0;
foreach($table as $index=>$data){
    //echo $data[0].'</br>';
    if($data[1] != NULL){
        $e++;
        $organization = $data[1];
        $arrryofjob[$index]['organization'] = $organization;
        
        $teletalkcode = strtoupper(preg_replace('/\s+/', '', $data[2]));
        $arrryofjob[$index]['teletalkcode'] = $teletalkcode;
        
        $applystart = date('Y-m-d', strtotime($data[3]));
        $arrryofjob[$index]['applystart'] = $applystart;
        
        $applyend = date('Y-m-d', strtotime($data[4]));
        $arrryofjob[$index]['applyend'] = $applyend;
        
        $applyurl = $data[6];
        $arrryofjob[$index]['url'] = $data[6];
        
        
        // check exits data from database
        
        $sqlrow = "SELECT * FROM examdata where shortcode='$teletalkcode' and    applystart='$applystart' and    applyend='$applyend' limit 1";
       
		$result = mysqli_query($conn, $sqlrow);
		$row = mysqli_fetch_array($result);
	 
		 $examid = $row['id'];
		 
		 
		 if($row['id'] == NULL){
		     
		     $organization = $conn->real_escape_string($organization);
		    echo  $sql2=" insert into examdata set 
            userid =  '1',
            otherusers='',
			phone =  '01810982876',
			email =  'upwork.shafi@gmail.com',
            organization = '$organization', 
            designation='Many',
            examtype='Unknown',
            applyby='teletalk',
            shortcode = '$teletalkcode',
            examdate = 'No Published',
            examtime = '$examtime',
            applystart = '$applystart',
            applyend = '$applyend',
            applyurl='$applyurl',
            examlocation = '',
            details='',
            notifyme='0',
            cronadd='1',
            time = '$today'
            ";
            $result2 = mysqli_query($conn, $sql2);
            sleep(1);
           
		 }
		 
		 
		 
    }
    
    if (strpos($data[0], 'vas.query@teletalk.com.bd') !== false) {
     break;
    }
    
}
}else{
    echo 'Time Up';
}
/*
echo'<pre>';
print_r($arrryofjob);
echo'</pre>';
*/
$conn -> close();