<?php
header("Access-Control-Allow-Origin: *");
include_once('connection.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);
ob_implicit_flush(true);
include_once('userdata.php');
date_default_timezone_set('Asia/Dhaka');
$today = date("Y-m-d H:i:s");
$todaydate = date("Y-m-d");
$bs = '-';
if(!empty($_GET['editexam'])){
    
        $phone = $conn->real_escape_string($_POST['phone']);
        $email = $conn->real_escape_string($_POST['email']);
        $organization = $conn->real_escape_string($_POST['organization']);
		
		$university = $conn->real_escape_string($_POST['university']);
       
       
        $examtype = $conn->real_escape_string($_POST['examtype']);
        $applyby = $conn->real_escape_string($_POST['applyby']);
        
        if($applyby !='other'){
         $codeorlink = strtoupper($conn->real_escape_string($_POST['codeorlink']));
        }else{
            $codeorlink = strtolower($conn->real_escape_string($_POST['codeorlink']));
        }
        
       
        ////$examdate = $conn->real_escape_string($_POST['examdate']);
        ////$examtime = $conn->real_escape_string($_POST['examtime']);
        
        
        $examlocation = $conn->real_escape_string($_POST['examlocation']);
        $details = $conn->real_escape_string($_POST['details']);
        
        
        $applystart = $conn->real_escape_string($_POST['applystart']);
        $applyend = $conn->real_escape_string($_POST['applyend']);
        
        $notifyme = $conn->real_escape_string($_POST['notifyme']);
        $jid = $conn->real_escape_string($_POST['jid']);
		$status = $conn->real_escape_string($_POST['status']);
		$whycorrectiontext = $conn->real_escape_string($_POST['whycorrectiontext']);
		
		$whycorrection =  $_POST['whycorrection'] ;
		
        
        $examdatepublished = $conn->real_escape_string($_POST['examdatepublished']);
        
         $notifyme =$notifyme ? $notifyme:0;
        if($notifyme =='1'){
         $otherusers = ','.$userid.',';   
        }
        
		/// power check start
		$power = 0;
		if($userid !=0){
			$sqluser = "SELECT * FROM users where id='$userid' limit 1";
			$resultuser = mysqli_query($conn, $sqluser);
			$rowuser = mysqli_fetch_array($resultuser);     
			$power = $rowuser['power'];
		}
        /// power check end
        // examdateall
        
     
    
           // return $return_arr;
            $i=0;
            $jobarray = array();
            $designationsdata = '';
            foreach($_POST['examdateset']['designations'] as $data){
               
                 $designationsdata .=$data.',';
                 if($_POST['examdateset']['uniqid'][$i] == NULL){
                     $uniqid=uniqid();
                 }else{
                     $uniqid = $_POST['examdateset']['uniqid'][$i];
                 }
                 
                $examdates = '';
                $examtimes = '';
                if($_POST['examdateset']['examdates'][$i] != NULL){
                    $examdates = date("Y-m-d", strtotime($_POST['examdateset']['examdates'][$i]));
                    $examtimes = date("H:i", strtotime($_POST['examdateset']['examdates'][$i]));
                }
                
                $datew = '';
                $timew='';
                if($_POST['examdateset']['examdatesw'][$i] != NULL){
                    $datew = date("Y-m-d", strtotime($_POST['examdateset']['examdatesw'][$i]));
                    $timew = date("H:i", strtotime($_POST['examdateset']['examdatesw'][$i]));
                }
                
                
                 $datep = '';
                $timep='';
                if($_POST['examdateset']['examdatesp'][$i] != NULL){
                    $datep = date("Y-m-d", strtotime($_POST['examdateset']['examdatesp'][$i]));
                    $timep = date("H:i", strtotime($_POST['examdateset']['examdatesp'][$i]));
                }
                
                
                 $datev = '';
                $timev='';
                if($_POST['examdateset']['examdatesv'][$i] != NULL){
                    $datev = date("Y-m-d", strtotime($_POST['examdateset']['examdatesv'][$i]));
                    $timev = date("H:i", strtotime($_POST['examdateset']['examdatesv'][$i]));
                }
                
                
                
                
                if($data != NULL){
                $jobarray[] = array(
                    'designations'=>$data,
                    'date'=>$examdates,
                    'time'=>$examtimes,
                    'examtype'=>$_POST['examdateset']['examtypes'][$i],
                    'datew'=>$datew,
                    'timew'=>$timew,
                    'examtypew'=>$_POST['examdateset']['examtypesw'][$i],
                    'datep'=>$datep,
                    'timep'=>$timep,
                    'examtypep'=>$_POST['examdateset']['examtypesp'][$i],
                    'datev'=>$datev,
                    'timev'=>$timev,
                    'examtypev'=>$_POST['examdateset']['examtypesv'][$i],
                    'uniqid'=>$uniqid,
                    );
                     $i++;
				}
					 
					 
            }
              
              $examdateall = json_encode($jobarray, JSON_UNESCAPED_UNICODE);
			  $whycorrection = json_encode($whycorrection, JSON_UNESCAPED_UNICODE);
			  
			  $whycorrection = $conn->real_escape_string($whycorrection);
            
             
             
             
			 if($power ==0){
				 $statuscheck = " status = '0', ";
			 }else{
				 
				 $statuscheck = " status = '$status', ";
			 }
			 if($status == NULL){
				 $statuscheck = '';
			 }
             
			$allstring = "
			phone =  '$phone',
			email =  '$email',
            organization = '$organization', 
            designation='$designationsdata',
            examtype='$examtype',
            applyby='$applyby',
            shortcode = '$codeorlink',
            applystart = '$applystart',
            applyend = '$applyend',
            examlocation = '$examlocation',
            details='$details',
			university='$university',
            examdateall = '$examdateall',          
            examdatepublished='$examdatepublished',
			whycorrectiontext='$whycorrectiontext',
			whycorrection='$whycorrection',
            $statuscheck
			time = '$today'
			"; 
			
			
			if($jid != NULL){
				
				 
				
			if($power ==0){	
			
				$allstring .="
				,
				editor =  '$userid',
				mainid =  '$jid',
				userid =  '$userid',
				otherusers =  '$otherusers'
				
				";
				
				$sql2=" insert into examdata set $allstring ";
				$messageshow = 'Updated Successfully & waiting for public view
				approval. Before approval it can be seen only by you.
				';
			}else{
				
				$sql2=" update examdata set $allstring
				where    id='$jid' ";
				$messageshow = 'Updated Successfully..';
				
			}
			
			
			
			}else{
				
				$allstring .="
				,
				userid =  '$userid',
				otherusers =  '$otherusers'
				
				";
				
				$sql2=" insert into examdata set $allstring ";
				$messageshow = 'Added Successfully..';
			}



        $result2 = mysqli_query($conn, $sql2);
		if($jid == NULL){
		$last_id = $conn->insert_id;
		}
		$imageid = $jid ? $jid: $last_id;
		
		///// image upload Start
		
		
		
	
     $countfiles = count($_FILES['files']['name']);

    $upload_location = "circularpdfimages/";
    
    $files_array = array();

    for($i = 0;$i < $countfiles; $i++){
        
         $filename = $_FILES['files']['name'][$i];
        
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        $valid_ext = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg');
        
        if(in_array($ext, $valid_ext)){
            
        $path = $upload_location.date("dmYHis").$filename;
        $imageupload = 0;
            if(move_uploaded_file($_FILES['files']['tmp_name'][$i],$path)){
                $urls ='';
          
              $urls = $surls.'/'.$path;
             
            $imageupload = 1;
           
			
			  $filequery = "insert into circularpdfimages set
             
                incidentid='$imageid',
                imageurl='$urls',
                time='$today',
				uploadedby='$userid',
                status='1'
                
             ";
             $conn->query($filequery);
			 
			 $sqlimg=" update examdata set file='1'
				where    id='$imageid' ";
			 $resultimg = mysqli_query($conn, $sqlimg);
            }else{
				//print_r($_FILES);
			}
        }
    }
    if($imageupload == '0'){
    $imgupload = 'Update success without any new images ';
    }else{
          $imgupload = 'Update success with new images ';
    }


		
		////// image upload end
		
		
		$return_arr = array(
                'message' => $messageshow,
                'phone' => $phone,
                'email' => $email,
				'imgupload' => $imgupload,
                'last_id' => $last_id
                    );
          echo json_encode($return_arr);
		
		 




            
}
            
if (isset($_GET['signup']) && $_GET['signup'] != NULL) {
    $phone = $conn->real_escape_string($_POST['phone']);
        $email = $conn->real_escape_string($_POST['email']);
        $name = $conn->real_escape_string($_POST['name']);
		$password = $conn->real_escape_string($_POST['password']);
		$repassword = $conn->real_escape_string($_POST['repassword']);
		$id = $conn->real_escape_string($_POST['id']);
        
        
			$action  = "
			name =  '$name',
			email =  '$email',
			phone =  '$phone',
			password =  '$password'
			";
    if($id == NULL){
		$action .=", time = '$today'";
    $sql2=" insert into users set 
            
			$action
		";
	}else{
		$action .=", uptime = '$today'";
		$sql2=" update users set 
            
			$action
			where id='$userid' 
		";
	}



$result2 = mysqli_query($conn, $sql2);
if ($result2 === TRUE) {
    $last_id = $conn->insert_id;
	if($id == NULL){
    $message= 'Registration Success.';
	}else{
		$message= 'Update Success.';
		
		setcookie('exemail', $email, $expiry,'/');
		setcookie('exphone', $phone, $expiry,'/'); 
		setcookie('name', $name, $expiry,'/');
	}
	
	$sqlupe=" update examdata set           
			userid =  '$last_id'
			where phone='$phone'
			";
			$resultup = mysqli_query($conn, $sqlupe);


}else{
	if($id == NULL){
		$message= 'Registration Failed. You can not use same email or phone again & again.';
	}else{
		$message= 'Update Failed. We do not support duplicate phone..';
	}
}
    $return_arr = array(
                'message' => $message,
                'phone' => $phone,
				'password' => $password,
                'email' => $email,
                'last_id' => $last_id
                    );
            echo json_encode($return_arr);
            
            
            
}
if (isset($_GET['addexam']) && $_GET['addexam'] != NULL) {
    
        $phone = $conn->real_escape_string($_POST['phone']);
        $email = $conn->real_escape_string($_POST['email']);
        $organization = $conn->real_escape_string($_POST['organization']);
        $designation = $conn->real_escape_string($_POST['designation']);
        $examtype = $conn->real_escape_string($_POST['examtype']);
        
        
        $applyby = $conn->real_escape_string($_POST['applyby']);
        
        if($applyby !='other'){
         $codeorlink = strtoupper($conn->real_escape_string($_POST['codeorlink']));
        }else{
            $codeorlink = strtolower($conn->real_escape_string($_POST['codeorlink']));
        }
        
        
        $examdate = $conn->real_escape_string($_POST['examdate']);
        $examtime = $conn->real_escape_string($_POST['examtime']);
        
        
        $examlocation = $conn->real_escape_string($_POST['examlocation']);
        $details = $conn->real_escape_string($_POST['details']);
        
        
         $applystart = $conn->real_escape_string($_POST['applystart']);
        $applyend = $conn->real_escape_string($_POST['applyend']);
        
        $notifyme = $conn->real_escape_string($_POST['notifyme']);
        
        $examdatepublished = $conn->real_escape_string($_POST['examdatepublished']);
         $notifyme =$notifyme ? $notifyme:0;
        if($notifyme =='1'){
         $otherusers = ','.$userid.',';   
        }
        
        
        
        
        $jobarray = array();
            $designationd = explode(',',$designation);
            foreach($designationd as $data){
               
                  
                $jobarray[] = array(
                    'designations'=>$data,
                    'date'=>'',
                    'time'=>'',
                    'examtype'=>''
                    );
                     
            }
              
              $examdateall = json_encode($jobarray, JSON_UNESCAPED_UNICODE);
        
    
    
    $sql2=" insert into examdata set 
            userid =  '$userid',
            otherusers='$otherusers',
			phone =  '$phone',
			email =  '$email',
            organization = '$organization', 
            examtype='$examtype',
            applyby='$applyby',
            shortcode = '$codeorlink',
            examdate = '$examdate',
            examtime = '$examtime',
            applystart = '$applystart',
            applyend = '$applyend',
            examlocation = '$examlocation',
            details='$details',
            notifyme='$notifyme',
            examdatepublished='$examdatepublished',
            time = '$today',
            examdateall='$examdateall'
";



$result2 = mysqli_query($conn, $sql2);
if ($result2 === TRUE) {
    $last_id = $conn->insert_id;
    $message ='
    </br>
    <div class="alert alert-success configreset">
  <strong>Successfully Added</strong> Add more and help other.
  <a href="'.$foldername.'/edit.php?jid='.$last_id.'" class="btn btn-warning">Add Exam Date</a>
  
  
  <button type="button" class="btn btn-success">Add More</button>
</div>
    
    ';
    
}else{
    $message ='
    </br>
    <div class="alert alert-success configreset">
  <strong>Failed to Add</strong>
</div>
    
    ';
    
}
    $return_arr = array(
                'message' => $message,
                 
                 
                    );
            echo json_encode($return_arr);
}
if (isset($_GET['bringexamlist']) && $_GET['bringexamlist'] != NULL) {
    ?>
<div class="table-responsive">




    <?php
    
   $calldate = $conn->real_escape_string($_POST['calldate']);
   $searchingfor = $conn->real_escape_string($_POST['searchingfor']);
   
   $calldate = date("Y-m-d", strtotime($calldate));
   
     $sqlstring = " ";
    $searchkey='';
    if($searchingfor == 'applystart'){
        $sqlstring .= " and applystart ='$calldate' ";
        $searchkey='applystart';
    }else if($searchingfor == 'applyend'){
        $sqlstring .= " and applyend ='$calldate' ";
        $searchkey='applyend';
    }else{
         $sqlstring .= " and examdateall  like '%$calldate%' ";
         $searchkey='examdateall';
    }
    
    
  
   
     $sql = "SELECT *  FROM examdata where 1=1 $sqlstring and status='1' order by time desc ";
     
    $result = mysqli_query($conn, $sql);
    
 $string ='<div id="accordiontop"> ';
  $applyby = '';
    if (mysqli_num_rows($result) > 0) {
     $i=0;
      
        
        while($row = mysqli_fetch_assoc($result)) {
            $i++;
            $co = 0;
            
            
            
            
            
            
            
            
            
            
            
            
            
            
           $getalldesignation = $row['examdateall'];
  $getalldesignationdecode = json_decode($getalldesignation, true);
  
  $datesorting = array_column($getalldesignationdecode, 'date');

    array_multisort($datesorting, SORT_DESC, $getalldesignationdecode);
  $examdateshow='';
  $examdateremaining = '';
  $examdateshow = '';
  foreach($getalldesignationdecode as $index=>$ddata){
      
	  
	  
	  $examdateshow .= jodpost($row, $ddata, $calldate, $co);




	 
  }
  
  
  
  
  
  
  
  if($co >0){
      $extext = '<span class="numbercolor" style="color:red;">('.$co.')</span>';
  }
  
  
  
            
             if($row['applyby']=='teletalk'){
            $applyby= '<span class="shortcodedata">Teletalk Code: '.strtoupper($row['shortcode']).'</span>';
            
        }else if($row['bank']=='teletalk'){
             $applyby= '<span class="shortcodedata">Job ID: '.$row['shortcode'].'</span>';
        }else{
            $applyby= '<span class="shortcodedata"></span>';
        }
        $showshortcode = '';
        if($row['applyby']=='other'){
            $showshortcode ='
            <a style="color:blue;" target="_blank" href="'.strtolower(addingTheHTTPValue($row['shortcode'])).'">Details <i class=" fa fa-external-link" aria-hidden="true"  ></i> </a>
            
            ';
        }else{
             $showshortcode =$row['shortcode'];
        }
        
             $uldata = '<div class="card">';
             $uldata .= '
             <div class="card-header" id="headingTop'.$row['id'].'">
     <a class="card-link plusminustop " getclass="plusminustop'.$row['id'].'" data-toggle="collapse" aria-expanded="true" aria-controls="#collapseTop'.$row['id'].'"  href="#collapseTop'.$row['id'].'">
         <b> '.$i.' .   </b> '.$row['organization'].' | 
         
         '.$showshortcode.' 
         
         
         '.$extext.' <span class="float-right collpseex plusminustop'.$row['id'].'">+</span>
      </a>
    </div>
             ';       
            
      $uldata .= '<div id="collapseTop'.$row['id'].'" class="collapse " aria-labelledby="headingTop'.$row['id'].'" data-parent="#accordiontop"><div class="card-body">';       
    
    
    
    
    
    $uldata .= "<ul class='list-group dividebyother'>";
  
   
  
  $designation = $row['designation'] ? $row['designation']: 'Undefined';
  
  //#$uldata .="<li class='list-group-item'>Post: ".rtrim($designation, ',')."</li>";
  
  if(strtotime($row['applystart']) != NULL){
  $uldata .="<li class='list-group-item'>Apply Start : ".date('d/m/Y', strtotime($row['applystart']))."</li>";
  }
  if(strtotime($row['applyend']) != NULL){
  $uldata .="<li class='list-group-item'>Apply End : ".date('d/m/Y', strtotime($row['applyend']))."</li>";
  }
  
  
  
  
  
  

  $uldata .="<li class='list-group-item'><b><i>Exam Date</i></b></li>";
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  $uldata .= $examdateshow;
  $uldata .= $examdateremaining;
  
  
  
  
  
  
    $disabledivwishlist = '';
    
		 $checktext = ','.$userid.',';
  if (strpos($row['otherusers'], $checktext) !== false) {
      $disabledivwishlist = 'disabledivwishlist';
  }else{
      $disabledivwishlist = '';
  }
  
  
  
  if($searchkey !='examdateall'){
  $uldata .= bigLove($disabledivwishlist, $row['id'], $bs, $row);
  
  }
  
     $uldata .=noteadd($row['id'], $class='li', $class='div');
     
    
 
 
  
  
  if($todaydate <= $row['applyend']){
      if($row['applyurl'] !=NULL){
          $uldata .="<li class='list-group-item'><a target='_blank' href='".$row['applyurl']."'>Apply Now</a></li>";
      }else if($row['applyby'] =='teletalk'){
          $uldata .="<li class='list-group-item'><a target='_blank'  href='http://".$row['shortcode'].".teletalk.com.bd/'>Apply Now</a></li>";
      }else{
          
      }
  }
  
  	$useraccess = useraccess($array=array(
		 'jobuserid' =>$row['userid']
		 ));
		 
	$access = $useraccess['access'];
	
	$uldata .=filedata($row['id'],$row['file']);
 if($access==1){
  $uldata .="<li class='list-group-item'><a href='".$foldername."/edit.php?jid=".$row['id']."'>Edit</a></li>";
  }
$uldata .="</ul>";

$uldata .="</div> </div>";
    
    
    
    
    

$uldata .="</div>";


      $string .=     $uldata;  
             
        }
        $string .='</div>';
        
        
        
        
        
        
        
        
        $jscript = bringscript('plusminustop');
       






$string .=$jscript;
      echo $string;  
    }
    
    ?>




</div>
<?php
     
}

if($_GET['brigmonth'] !=NULL){
    $month = $conn->real_escape_string($_POST['month']);
    $year = $conn->real_escape_string($_POST['year']);
    $nDays = $conn->real_escape_string($_POST['nDays']);
    $searchingfor = $conn->real_escape_string($_POST['searchingfor']);
    $searchKey = $year.'-'.sprintf("%02d", $month);
    $sqlstring = " ";
    $searchkey='';
    if($searchingfor == 'applystart'){
        $sqlstring .= " and applystart like  '$searchKey%' ";
        $searchkey='applystart';
    }else if($searchingfor == 'applyend'){
        $sqlstring .= " and applyend like  '$searchKey%' ";
        $searchkey='applyend';
    }else{
         $sqlstring .= " and examdateall like  '%$searchKey%' ";
         $searchkey='examdateall';
    }
 
    $sql = "SELECT *  FROM examdata where 1=1 $sqlstring and status='1' order by time desc";
     
    $result = mysqli_query($conn, $sql);
    $evenArray = array();
    $evenArrayCount = array();
    $starview = array();
    $evenArrayCountAll = array();
    $send = 0;
    $passuldata = '<div id="accordion">';

     // echo  $conn -> error;
    if (mysqli_num_rows($result) > 0) {
     $i=0;
    $j=0;
       
        while($row = mysqli_fetch_assoc($result)) {
             $i++;
            $co = 0;
           $getalldesignation = $row['examdateall'];
  $getalldesignationdecode = json_decode($getalldesignation, true);
 
  $datesorting = is_array($getalldesignationdecode) ? array_column($getalldesignationdecode, 'date') : [];
  if (!empty($datesorting) && is_array($getalldesignationdecode)) {
      array_multisort($datesorting, SORT_DESC, $getalldesignationdecode);
  }
  
    $examdateshow='';
  $examdateremaining = '';
  $examdateshow = '';
  foreach($getalldesignationdecode as $index=>$ddata){	  
	  $examdateshow .= jodpost($row, $ddata, $calldate, $co);
  }
  
  
  if($co >0){
      $extext = '<span class="numbercolor" style="color:red;">('.$co.')</span>';
  }
              
            // echo $searchkey;
            
            if($searchkey !='examdateall'){
                $getdate = explode('-',$row[$searchkey]);
                
                  if($userid != NULL){
                        if (strpos($row['otherusers'], ','.$userid.',') !== false) {
             
                         $starview['starview'.ltrim($getdate[2], "0")]['n'.$i] = $row['otherusers'];
                        }
                    }
            }else{
                $getalldesignation = $row['examdateall'];
                $getalldesignationdecode = json_decode($getalldesignation, true);
                
                foreach($getalldesignationdecode as $indexx=>$ddatax){                   
                    if($ddatax['date'] != NULL || $ddatax['datew'] != NULL || $ddatax['datep'] != NULL || $ddatax['datev'] != NULL){
						$getdate = explode('-',$ddatax['date']);
                        if (strpos($ddatax['date'], $searchKey) !== false) {
                            $j++;
                            $evenArrayCountAll['n'.$j] = $ddatax['date'];
                        
                            if ($userid != NULL) {
                                // Safe check before using in_array
                                if (!empty($ddatax['students']) && is_array($ddatax['students'])) {
                                    if (in_array($userid, $ddatax['students'])) {
                                        $starview['starview'.ltrim($getdate[2], "0")]['n'.$j] = 1;
                                    }
                                }
                            }
                        }
						
						$getdate = explode('-',$ddatax['datew']);
                        if (strpos($ddatax['datew'], $searchKey) !== false) {
                            $j++;
                            $evenArrayCountAll['n' . $j] = $ddatax['datew'];
                        
                            if ($userid != NULL) {
                                // ✅ Check that students is a non-empty array
                                if (!empty($ddatax['students']) && is_array($ddatax['students'])) {
                                    if (in_array($userid, $ddatax['students'])) {
                                        $starview['starview' . ltrim($getdate[2], "0")]['n' . $j] = 1;
                                    }
                                }
                            }
                        }
                        $getdate = explode('-',$ddatax['datep']);
                        if (strpos($ddatax['datep'], $searchKey) !== false) {
                            $j++;
                            $evenArrayCountAll['n'.$j] = $ddatax['datep'];
                              if($userid != NULL){
                       
								if( in_array( $userid ,$ddatax['students'] ) ){
             
								$starview['starview'.ltrim($getdate[2], "0")]['n'.$j] = 1;
								}
							}
                        }
						
						$getdate = explode('-',$ddatax['datev']);
                        if (strpos($ddatax['datev'], $searchKey) !== false) {
                            $j++;
                            $evenArrayCountAll['n'.$j] = $ddatax['datev'];
                              if($userid != NULL){
                       
								if( in_array( $userid ,$ddatax['students'] ) ){
             
								$starview['starview'.ltrim($getdate[2], "0")]['n'.$j] = 1;
								}
							}
                        }
                       
                    }
                    
                }
        
                
            }
            /*
            echo '<pre>';
            print_r($starview);
            echo '</pre>';
            */
            $evenArray['eventview'.ltrim($getdate[2], "0")]['n'.$i] = $row['shortcode'];
            $evenArrayCount['eventview'.ltrim($getdate[2], "0")]['n'.$i] = $row['shortcode'];
            $uldata = '<div class="card">';
               
             
              $uldata .= '
             <div class="card-header" id="headingOne'.$row['id'].'"><a class="card-link plusminus " getclass="plusminus'.$row['id'].'" data-toggle="collapse" aria-expanded="true" aria-controls="#collapseOne'.$row['id'].'" href="#collapseOne'.$row['id'].'"><b> '.$i.' .   </b> '.$row['organization'].' | '.$row['shortcode'].' <span class="collpseex float-right plusminus'.$row['id'].'">+</span></a> </div>';  
            
      $uldata .= '<div id="collapseOne'.$row['id'].'" class="collapse "  aria-labelledby="headingOne'.$row['id'].'" data-parent="#accordion"><div class="card-body">'; 
            
            
            
            $uldata .= "<ul class='list-group dividebyother'>";
            
             
            
            $designation = $row['designation'] ? $row['designation']: 'Undefined';
            
            //#$uldata .="<li class='list-group-item'>Post: ".rtrim($designation, ',')."</li>";
            
           
             if(strtotime($row['applystart']) != NULL){
  $uldata .="<li class='list-group-item'>Apply Start : ".date('d/m/Y', strtotime($row['applystart']))."</li>";
  }
  if(strtotime($row['applyend']) != NULL){
  $uldata .="<li class='list-group-item'>Apply End : ".date('d/m/Y', strtotime($row['applyend']))."</li>";
  }
  /*
  if($row['examdate'] != NULL && $row['examdate'] != 'No Published'){
  $uldata .="<li class='list-group-item'>Exam Date: ".date('d/m/Y', strtotime($row['examdate']))." ". date('h:i A', strtotime($row['examtime']))." | ".$row['examtype']."</li>";
  }else{
      $uldata .="<li class='list-group-item'>Exam Date: ".$row['examdatepublished']."</li>";
  }
  
  */
  
    $uldata .="<li class='list-group-item'><b><i>Exam Date</i></b></li>";
  
  $uldata .= $examdateshow;
  $uldata .= $examdateremaining;
  
    $disabledivwishlist = '';
    
		 $checktext = ','.$userid.',';
  if (strpos($row['otherusers'], $checktext) !== false) {
      $disabledivwishlist = 'disabledivwishlist';
  }else{
      $disabledivwishlist = '';
  }
  if($searchkey !='examdateall'){
  
   $uldata .= bigLove($disabledivwishlist, $row['id'], $bs, $row);
  
  }
     $uldata .=noteadd($row['id'], $class='li', $class='div');
   
  
  
  if($todaydate <=$row['applyend']){
        if($row['applyurl'] !=NULL){
          $uldata .="<li class='list-group-item'><a target='_blank' href='".$row['applyurl']."'>Apply Now</a></li>";
      }else if($row['applyby'] =='teletalk'){
          $uldata .="<li class='list-group-item'><a target='_blank'  href='http://".$row['shortcode'].".teletalk.com.bd/'>Apply Now</a></li>";
      }else{
          
      }
  }
  
  	$useraccess = useraccess($array=array(
		 'jobuserid' =>$row['userid']
		 ));
		 
	$access = $useraccess['access'];
 
  $uldata .=filedata($row['id'],$row['file']);
   	
 if($access==1){
  $uldata .="<li class='list-group-item'><a href='".$foldername."/edit.php?jid=".$row['id']."'>Edit</a></li>";
  }
            
            
            $uldata .="</ul>";
            $uldata .="</div> </div>";

$uldata .="</div>";
          
             
            $passuldata .=$uldata;
        }
        $send = 1;
    }else{
        $send = 2;
    }
     
     
     
     
     
     
     
     $jscript = bringscript('plusminus');
      
      
       






 $passuldata .=$jscript;
 /*
echo '<pre>';
 print_r($starview);
 echo '</pre>';
 */
foreach($starview as $keyx=>$innerarrayc)
{
$starview[$keyx]=count($innerarrayc);
}
/*
echo '<pre>';
print_r($evenArrayCountAll);
echo '</pre>';
*/

if($searchkey =='examdateall'){
     
    $counTingNow = array_count_values($evenArrayCountAll);
   
    $finalCountArray = array();
    $e=0;
    foreach($counTingNow as $indexdate=>$datedata){
        
        $getdate = explode('-',$indexdate);
        $finalCountArray['eventview'.ltrim($getdate[2], "0")]=$datedata;
        $e +=$datedata;
    }
    
    $evenArrayCount=$finalCountArray;
    
}else{
    foreach($evenArray as $key=>$innerarray)
    {
        $evenArrayCount[$key]=count($innerarray);
    }
}

$passuldata .= '</div>';

$months = $searchKey;
$months = date("M Y", strtotime($months));
$i = isset($i) ? $i : 0; // Set to 0 if not defined
$e = isset($e) ? $e : 0;

if ($searchkey == 'examdateall') {
    $numbers = $e;
} else {
    $numbers = $i;
}

$monthstring = '<span class="badge badge-danger">'.$months.'</span> exam found: <span class="badge badge-danger">'.$numbers.'</span>' ;
//$size = sizeof($evenArray[1]);
        $return_arr = array("eventarray" => $evenArray,
                            "message" => $send,
                            "monthexam" => $monthstring,
                            "evenArrayCount" => $evenArrayCount,
                            "starview" =>$starview,
                            "uldata"=>$passuldata
                            
                            );
        
        
        // Encoding array in JSON format
        echo json_encode($return_arr);

    
    
    $originalDate = "$year-$month-01";
    $newDate = date("F-Y", strtotime($originalDate));
    
    
  //  echo '<div class="" style="color:black; font-wight:bold;">'.$newDate.' (No exam found) '.$nDays.'</div>';
}
//
$conn -> close();