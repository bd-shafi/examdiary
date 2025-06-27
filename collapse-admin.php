<?php
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
  foreach($getalldesignationdecode as $index=>$ddata){
      $calldateformatting = date('d/m/Y', strtotime($calldate));
      
      if($ddata['date'] == NULL){
          $exdate = 'dd.mm.yyyy';
      }else{
          $exdate = date('d/m/Y', strtotime($ddata['date']));
          $exdatel = date('d/m/Y', strtotime($ddata['date']));
          
          
          
          if ($exdate == $calldateformatting) {
           $exdate = '<span class="datecolor" style="color:red;">'.$exdate.'</span>';
          }
          
          
      }
      
      if($ddata['time'] == NULL){
          $extime = 'hh.ss';
      }else{
          $extime = date('h:i A', strtotime($ddata['time']));
      }
      
     
     
     
     if($ddata['designations'] !=''){
         
         
          if ($exdatel == $calldateformatting) {
              if($ddata['time'] != NULL){
              $co++;
              }
                $examdateshow .="<li class='list-group-item'>".$ddata['designations'].": Exam Date: ".$exdate.", Time: ".$extime.", Type: ".$ddata['examtype'];
               
               
               
                if($ddata['date'] != NULL){
                    if( !in_array( $userid ,$ddata['students'] ) ){
                    $examdateshow .="<span class='uniqid addtolist addtolisthide".$ddata['uniqid']."' uniqid='".$ddata['uniqid']."' jobid='".$row['id']."'>
                     <i class='fa fa-tag taskremaining' aria-hidden='true'></i>
                    </span>";
                     $examdateshow .="<span class='response".$ddata['uniqid']."'>  </span>";
                    }else{
                    $examdateshow .="<span class='responsedone".$ddata['uniqid']."'> <i class='fa fa-star taskdone' aria-hidden='true'></i> </span>";
                    }
                }
                
                
                
                
                $examdateshow .="</li>";
          }else{
               $examdateremaining .="<li class='list-group-item'>".$ddata['designations'].": Exam Date: ".$exdate.", Time: ".$extime.", Type: ".$ddata['examtype'];
               
               
               
               
               
               if($ddata['date'] != NULL){
                   if( !in_array( $userid ,$ddata['students'] ) ){
                    $examdateremaining .="<span class='uniqid addtolist addtolisthide".$ddata['uniqid']."' uniqid='".$ddata['uniqid']."' jobid='".$row['id']."'>
                    <i class='fa fa-tag taskremaining' aria-hidden='true'></i>  </span>";
                     $examdateremaining .="<span class='response".$ddata['uniqid']."'>  </span>";
                   }else{
                    $examdateremaining .="<span class='responsedone".$ddata['uniqid']."'> <i class='fa fa-star taskdone' aria-hidden='true'></i> </span>";
                   }
               }
               
               
               
               $examdateremaining .="</li>";
     
          }
     
         
         
         
     }
      
      
      
      
      
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
     <a class="card-link plusminustop " getclass="plusminustop'.$row['id'].'" data'.$bs.'toggle="collapse" aria-expanded="true" aria-controls="#collapseTop'.$row['id'].'"  href="#collapseTop'.$row['id'].'">
         <b> '.$i.' .   </b> '.$row['organization'].' | '.$showshortcode.' | '.date('d/m/Y h:i:s A', strtotime($row['time'])).' (S-'.$row['status'].') (M-'.$row['mainid'].') (AS-'.$row['applystart'].') <span class="float-right collpseex plusminustop'.$row['id'].'">+</span>
      </a>
    </div>
             ';       
            
      $uldata .= '<div id="collapseTop'.$row['id'].'" class="collapse " aria-labelledby="headingTop'.$row['id'].'" data'.$bs.'parent="#accordiontop"><div class="card-body">';       
    
    
    
    
    
    $uldata .= "<ul class='list-group dividebyother'>";
  
   
  
  $designation = $row['designation'] ? $row['designation']: 'Undefined';
  
  $uldata .="<li class='list-group-item'>Post: ".rtrim($designation, ',')."</li>";
  $uldata .="<li class='list-group-item'>In Site Time: ".date('d/m/Y h:i:s A', strtotime($row['time']))."</li>";
  $uldata .="<li class='list-group-item'>Status: ". $row['status']." Job ID:". $row['id']."</li>";
  
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
  $uldata .="<li class='list-group-item' ><span class='".$disabledivwishlist." lovebutton reminderbutton marginleft15px eid".$row['id']."' eid='".$row['id']."'> &#128151;</span></li>";
  
  }
  if($row['notes'] !=''){
	  $uldata .="<li class='list-group-item'>
	  <b>
	  নোটঃ
	  </b>
	  ".$row['notes']."</li>";
  }
     $uldata .="<li class='list-group-item' data".$bs."toggle='modal' data".$bs."target='#modaladdnote'>
     <span class='  notebutton marginleft15px eid".$row['id']."' eid='".$row['id']."'> 
     <i class='fa fa-edit' aria-hidden='true'></i> 
      নোট 
	  ( নোট পরবর্তীতে অনেক সহায়তা করবে)
	  </span>
     <div class='notupdate".$row['id']."'></div>
     </li>";
     
    
 
 
  
  
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
  $uldata .="<li class='list-group-item'><a target='_blank' href='".$foldername."/edit.php?jid=".$row['id']."'>Edit</a></li>";
  }
  $uldata .="<li class='list-group-item'><a target='_blank' href='//alljobs.teletalk.com.bd/bn/jobs/govt/details/".$row['oldjobid']."'>Check</a></li>";
$uldata .="</ul>";

$uldata .="</div> </div>";
    
    
    
    
    

$uldata .="</div>";


      $string .=     $uldata;  
		}
	}



$string .='</div>';
        $jscript = "
        
          <script>
   jQuery( '.plusminustop' ).click(function() {
            
          var getclass = jQuery(this).attr('getclass');
          var getsign = jQuery( '.'+getclass ).text();
          
           
          
          if(getsign =='+'){
             jQuery( '.'+getclass ).text('-');
          }
          
          if(getsign =='-'){
             jQuery( '.'+getclass ).text('+');
          }
          });
          
          
          jQuery( '.addtolist' ).click(function() {
      var error = 0;				
			 	
			var uniqid = jQuery(this).attr('uniqid');
			var jobid = jQuery(this).attr('jobid');
		
			
	 
	
			if(!error){
				 
				jQuery('.response'+uniqid).html('....');
				
				jQuery.ajax({
				url: '".$foldernameSlash."ajaxaction.php?addtolist=true',
				type: 'POST',
				data: {uniqid:uniqid, jobid:jobid},
				success: function (data) {
				 
					var json = jQuery.parseJSON(data);
                    var message = json.message;
                    var modalbackresponse = json.modalbackresponse;
                 
					 jQuery('.response'+uniqid).html(message);
					  jQuery('.addtolisthide'+uniqid).hide(500);
					  
					  //jQuery( '.modaladdnote' ).trigger( 'click' );
					  
					  //jQuery('.modalbackresponse').html(modalbackresponse);
					  
					 
				},
			 
            	});
			}
});



    jQuery( '.notebutton' ).click(function() {
      var error = 0;				
			 	
			var eid = jQuery(this).attr('eid');
		
			
	 
	
			if(!error){
				 
				jQuery('.notupdate'+eid).html('Please Wait');
				
				jQuery.ajax({
				url: 'ajaxaction.php?notebutton=true',
				type: 'POST',
				data: {eid:eid},
				success: function (data) {
				 
						var json = jQuery.parseJSON(data);
                        var note = json.note;
                        var jobid = json.jobid;
                         var insert = json.insert;
                        
					 jQuery('.modalnotestext').val(note);
					  jQuery('.jobid').val(jobid);
					  jQuery('.insert').val(insert);
					 jQuery('.notupdate'+eid).html('');
					 
				},
			 
            	});
			}
});


    jQuery( '.reminderbutton' ).click(function() {
      var error = 0;				
			 	
			var eid = jQuery(this).attr('eid');
		
			
	 
	
			if(!error){
				 
				jQuery('.eid'+eid).html('Please Wait');
				
				jQuery.ajax({
				url: 'ajax.php?qwishlist=true',
				type: 'POST',
				data: {eid:eid},
				success: function (data) {
				 
					 jQuery('.eid'+eid).html(data);
				},
			 
            	});
			}
});
</script>";
$string .=$jscript;
if($i ==0){
    if($_GET['submit'] == NULL){
    $string =  'দুঃখিত, কোন তথ্য পাওয়া যায় নি, সঠিক ফোন নম্বর দিয়ে লগিন করেছেন কি না তা যাচাই করুন। ';
    }else{
       $string =  'দুঃখিত, কোন তথ্য পাওয়া যায় নি। '; 
	   $string .=  '<p>
	   <a target="_blank" href="/jobinput.php" class="addexambutton btn btn-success btn-sm" calldate="" addexam="yes">
					 <i class="fa fa-plus" aria-hidden="true"></i> Add this circular for you and other
					</a></p>
	   '; 
    }
}
      echo $string; 