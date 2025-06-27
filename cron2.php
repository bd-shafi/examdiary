<?php
require_once(__DIR__.'/connection.php');

date_default_timezone_set('Asia/Dhaka');
$today = date("Y-m-d H:i:s");
$checktime= date("H");

 $links = 'https://alljobs.teletalk.com.bd/bn/jobs/organization/list/jobs';

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
	         
	            
	            $linkarray[] = 'https://alljobs.teletalk.com.bd/bn/jobs/organization/list/jobs/'.$xelemlink->getAttribute('href');
	           
                }
        	                
        	              
        }
        
        
$linkarray = array_unique($linkarray);
 
 
 



foreach($linkarray as $examlink){

$links = $examlink;

$filePath = file_get_contents($links);
$dom = new DomDocument();
@ $dom->loadHTML($filePath);
$xcompany = new DOMXpath($dom);





$xelems = $xcompany->query('//table[contains(@class,"w-100")]');
foreach ($xelems as $xelem){
	$innerHtml = innerHTML($xelem);
	$dom = new DomDocument();
	@ $dom->loadHTML('<?xml encoding="utf-8" ?>' . $innerHtml);
	 
	$getlabel = $dom->getElementsByTagName('tr');

 
}
 

$arrayjoblis = array();
$arraylink = array();
$x=0;
$l=0;
$details = '';
	foreach ($getlabel as $index=>$xelem){
	    	$innerHtml = innerHTML($xelem);
	        $dom = new DomDocument();
	        @ $dom->loadHTML('<?xml encoding="utf-8" ?>' . $innerHtml);
	 
	         $getlabelx = $dom->getElementsByTagName('td');
	         $xcompanyforlink = new DOMXpath($dom);
	        $xelemslink = $xcompanyforlink->query("//a[@class='btn btn-outline-success btn-sm']");

            
	            foreach ($getlabelx as $indexx=>$xelemx){
					
					
					
					
					
	              
				if($indexx == 0){
					$x++;
				}
				
				if($indexx != 0 && $indexx != 3){
					
					
				$org = trim(preg_replace('/\s\s+/', ' ', preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", trim($xelemx->nodeValue))));
	            if($indexx == 1){
					
					preg_match('#\((.*?)\)#', $org, $match);
					
					$getshortcode = explode('(', $org);
					
				$arrayjoblis[$x]['jobnumber'] = $match[1];
				$arrayjoblis[$x]['shortcode'] = trim(preg_replace('/\s\s+/', ' ', preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", trim($getshortcode[0]))));
	            }else if($indexx == 2){
					$getorg = explode('(', $org);
				$arrayjoblis[$x]['org']  = trim(preg_replace('/\s\s+/', ' ', preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", trim($getorg[0]))));;
	            }else{
					$arrayjoblis[$x][$indexx]  = $org ;
				}
				
				foreach ($xelemslink as $indexxx=>$xelemlink){
				$getjoburlid = explode('/',$xelemlink->getAttribute('href'));
	            
	            $arrayjoblis[$x]['link']= $getjoburlid[6];
				
	           
                }
				
				}
				
				
				
				
				
				
				
				
	    
            }
            
	}
	
 
 
 
$k=0;
foreach($arrayjoblis as $data){
	$k++;
 
	$jobshortcode =$conn->real_escape_string($data['shortcode']);
	$organization =$conn->real_escape_string($data['org']);
	
	     $sql2=" insert into examdatapre set 
            jobid =  '$data[link]',
            jobshortcode='$jobshortcode',
			totalpost =  '$data[jobnumber]',
			organization =  '$organization',
            time = '$today',
            status = '1'
            ";
             $result2 = mysqli_query($conn, $sql2);
			 
            sleep(1);
            
            
            
            
}
}

 






















function innerHTML($node) {
    return implode(array_map([$node->ownerDocument,"saveHTML"], 
                             iterator_to_array($node->childNodes)));
}
$conn -> close();