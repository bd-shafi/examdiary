<?php
function filedata($jobid='', $fileyes=''){
	 if($fileyes != 0){
   return "<li class='list-group-item'><a href='".$foldername."/fileview.php?jid=".$jobid."'>
   View Full Circular:  <i style='font-size:2.4em;' class=' fa fa-file-pdf-o ' aria-hidden='true'></i>
   </a></li>";
	 }else{
		 return "<li class='list-group-item'><a href='".$foldername."/edit.php?jid=".$jobid."'>
   No File Found. <i style='font-size:2.4em;' class=' fa fa-file-o  ' aria-hidden='true'></i> Please add if you have.
   </a></li>";
	 }
   
}

function editaccess($access=array()){
	global $userid;
	$jobuser = $access['jobuser'];
	$jobid = $access['jobid'];
	if($jobuser==$userid){
		return "<li class='list-group-item'><a href='".$foldername."/edit.php?jid=".$jobid."'>Edit</a></li>";
	}
}


function alttext($array=array()){
    $type= $array['type'];
    if($type =='examdate'){
        /*
        return '
       data-bs-toggle="tooltip" data-bs-html="true" title="
	   যদি আপনি লাভ বাটনে ক্লিক করেন তবে আপনি এই পরীক্ষাটি দিতে চান এমন হিসাবে আপনার প্রোফাইলে যুক্ত করা হবে, যা আপনি পরবর্তীতে চেক করতে পারবেন।	   
	   "
        ';
        */
        return '';
    }
}
function alttextmodal($array=array()){
    $type= $array['type'];
    if($type =='examdate'){
        return '
      
	   যদি আপনি লাভ বাটনে ক্লিক করেন তবে আপনি এই পরীক্ষাটি দিতে চান এমন হিসাবে আপনার প্রোফাইলে যুক্ত করা হবে, যা আপনি পরবর্তীতে চেক করতে পারবেন।	 
যা স্টার হিসাবে দেখাবে, 	   
প্রোফাইলের ড্যাসবোর্ডে চেক করলে আপনার স্টার করা সকল পরীক্ষার তালিকা দেখতে পাবেন।	   
	   
        ';
    }
}

function tagstart($array=array()){
    global $userid, $bs;
    $students = $array['students'];
    $uniqid = $array['uniqid'];
    $type= $array['type'];
    $jobid = $array['jobid'];
    $examdateshowdata ='';
    if (!is_array($students)) {
        $students = []; // Default to empty array if null or not an array
    }
    
    if (!in_array($userid, $students)) {
        $stylelove = 'style="display:unset;"';
        $stylestar = 'style="display:none;"';
    } else {
        $stylestar = 'style="display:unset;"';
        $stylelove = 'style="display:none;"';
    }
        $examdateshowdata .="<span class='lovediv".$uniqid."' $stylelove><span  class='uniqid addtolist addtolisthide".$uniqid."'  uniqid='".$uniqid."' jobid='".$jobid."'>
         <i class='fa fa-heart taskremaining' aria-hidden='true'  ></i>
         <i class='fa fa-plus signtop' aria-hidden='true'  ></i>
		 </span>
		
		 
		 <i data".$bs."toggle='modal' data".$bs."target='#modal".$type."' class='fa fa-question what taskremaining' ".alttext($array=array('type'=>$type))."  aria-hidden='true'></i>
		</span> ";
        
           
        $examdateshowdata .="<span  class='stardiv".$uniqid."'  $stylestar><span class='starshow taskdone responsedone".$uniqid."'  uniqid='".$uniqid."' jobid='".$jobid."'> 
		<i class='fa fa-star '   aria-hidden='true'></i>
		<i class='fa fa-minus signtopminus' aria-hidden='true'  ></i>
		</span>
		
		<i data".$bs."toggle='modal'   data".$bs."target='#star".$type."' class='fa fa-question what taskremaining' ".alttext($array=array('type'=>$type))."  aria-hidden='true'></i>
		</span>
		";
        $examdateshowdata .="<span class='response$uniqid'></span>";
        return $examdateshowdata;
        
        /*
         $examdateshow .= tagstart($array=array(
                        'students'=>$ddata['students'],
                         'uniqid'=>$ddata['uniqid'],
                          'type'=>$ddata['examdate'],
                           'jobid'=>$ddata['id']
                        ));
                        */
    
}

function bigLove($disabledivwishlist='', $id='', $bbs='',$row=array()){
	global $bs, $todate;
	if($bbs != NULL){
		$bs = $bbs ;
	}
	$disable='';
	if($disabledivwishlist != NULL){
		$disable = $disabledivwishlist;
			$loveminus= 'style="display:unset;"';
		$loveplus = 'style="display:none;"';
	}else{
	    $loveminus= 'style="display:none;"';
		$loveplus = 'style="display:unset;"';
	    
	}
	$uldataback = '';
	
	
	
	

 if($row['applyend'] >=$todate){
	$uldataback .="<li class='list-group-item bigLove bigloveplus".$id."' $loveplus>
	<span class=' lovebutton reminderbutton marginleft15px ' eid='".$id."' doneornot=''> 
  <i class='bigLove2 fa fa-heartbeat ' aria-hidden='true'  ></i>";
  
  
	  $uldataback .="<i class=' fa fa-plus signtopminusbig' aria-hidden='true'  ></i>";
   
  $uldataback .="</span>";
  
   
	  $uldataback .="
  <i data".$bs."toggle='modal'   data".$bs."target='#starapplystartendloveplus' class='bigLove2 fa fa-question what taskremaining' ".alttext($array=array('type'=>$type))."  aria-hidden='true'></i>
		";
  
  $uldataback .="<span class='resulttext eidlove".$id."'></span>";
  $uldataback .="</li>";
 
 }else{

  
  
  
  
  
  
  $uldataback .="<li class='list-group-item bigLove  bigloveminus".$id."' $loveminus >
	<span class=' lovebutton reminderbutton marginleft15px ' eid='".$id."' doneornot='".$disable."'> 
  <i class='bigLove2 fa fa-heartbeat ' aria-hidden='true'  ></i>";
  
   
  $uldataback .="<i class=' fa fa-minus signtopminusbig' aria-hidden='true'  ></i>";
  
  $uldataback .="</span>";
   
  $uldataback .="
  <i data".$bs."toggle='modal'   data".$bs."target='#starapplystartendloveminus' class='bigLove2 fa fa-question what taskremaining' ".alttext($array=array('type'=>$type))."  aria-hidden='true'></i>
		";
  
  
  $uldataback .="<span class='resulttext eidlove".$id."'></span>";
  $uldataback .="</li>";
 }
  
  
  
  
  
  
  
  
  
  return $uldataback;
}

function bringscript($plusminus =''){
    $jscript = "<script>
	jQuery( '.".$plusminus."' ).click(function() {           
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
      if (confirm(\"Are you sure you want to add to your exam list?\")){
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
					 jQuery('.response'+uniqid).html('');
					  jQuery('.lovediv'+uniqid).hide(500);
					  jQuery('.stardiv'+uniqid).show(500);
					  //jQuery( '.modaladdnote' ).trigger( 'click' );
					  
					  //jQuery('.modalbackresponse').html(modalbackresponse); 
				},
			 
            	});
			}
      }		
});



 jQuery( '.taskdone' ).click(function() {
      if (confirm(\"Are you sure you want to remove from your exam list?\")){
      var error = 0;				
			 	
			var uniqid = jQuery(this).attr('uniqid');
			var jobid = jQuery(this).attr('jobid');
			if(!error){
				 
				jQuery('.response'+uniqid).html('....');
				
				jQuery.ajax({
				url: '".$foldernameSlash."ajaxaction.php?removelist=true',
				type: 'POST',
				data: {uniqid:uniqid, jobid:jobid},
				success: function (data) {
				 
					var json = jQuery.parseJSON(data);
                    var message = json.message;
                    var modalbackresponse = json.modalbackresponse;
                 
					 jQuery('.response'+uniqid).html('');
					  jQuery('.lovediv'+uniqid).show(500);
					  jQuery('.stardiv'+uniqid).hide(500);
					  
					  //jQuery( '.modaladdnote' ).trigger( 'click' );
					  
					  //jQuery('.modalbackresponse').html(modalbackresponse);	 
				},
			 
            	});
			}  
      }		
});


    jQuery( '.notebutton' ).click(function() {
      var error = 0;				
			 	
			var eid = jQuery(this).attr('eid');
		
			
	 
	
			if(!error){
				 
				jQuery('.notupdate'+eid).html('Please Wait');
				
				jQuery.ajax({
				url: '".$foldernameSlash."ajaxaction.php?notebutton=true',
				type: 'POST',
				data: {eid:eid},
				success: function (data) {
				 
						var json = jQuery.parseJSON(data);
                        var note = json.note;
                        var jobid = json.jobid;
                         var insert = json.insert;
                        
					 jQuery('.modalnotestext').val(note);
					 if(note !='' && note !=null){
						 jQuery('.noteyesno').html('Update Note');
						 
					 }else if(note ==null){
						  jQuery('.noteyesno').html('Add Note');
					 }else{
						 jQuery('.noteyesno').html('Add Note');
					 }
					  jQuery('.jobid').val(jobid);
					  jQuery('.insert').val(insert);
					 jQuery('.notupdate'+eid).html('');
					 
				},
			 
            	});
			}
});


    jQuery( '.reminderbutton' ).click(function() {
		var doneornot = jQuery(this).attr('doneornot');
		var eid = jQuery(this).attr('eid');
		if(doneornot==''){
			var alertx = 'আপনি এই পরীক্ষাটিতে আবেদন করার জন্য মনস্থির করেছেন? ';
		}else{
			var alertx = 'আপনি এই পরীক্ষাটিতে আবেদন করার লিস্ট থেকে ডিলিট করতে চাচ্ছেন?';           
		}
		if (confirm(alertx)){
      var error = 0;				
			 	
			
			

			if(!error){
				 
				jQuery('.eidlove'+eid).html('Please Wait');
				
				jQuery.ajax({
				url: '".$foldernameSlash."ajaxaction.php?qwishlist=true',
				type: 'POST',
				data: {eid:eid,doneornot:doneornot},
				success: function (data) {
				 var json = jQuery.parseJSON(data);
                  
				  var addedx = json.addedx;
				  var message = json.message;
					  
					 jQuery('.eidlove'+eid).html(message);
					 
					 if(addedx=='yes'){
						 
					 jQuery('.bigloveplus'+eid).hide(500);
					 jQuery('.bigloveminus'+eid).show(500);
					 }
					 if(addedx=='no'){
					    jQuery('.bigloveplus'+eid).show(500);
					    jQuery('.bigloveminus'+eid).hide(500);
					 }
				},
			 
            	});
			}
			
		}	
			
			
			
});
</script>";
return $jscript;
}
function examdatetime($date='', $time='', $type=''){
	
	 if($date == NULL){
          $exdate = 'dd.mm.yyyy';
      }else{
          $exdate = date('d/m/Y', strtotime($date));
          $exdatel = date('d/m/Y', strtotime($date));
          if ($exdate == $calldateformatting) {
           $exdate = '<span class="datecolor" style="color:red; background-color:#ff0;">'.$exdate.'</span>';
          }  
      }
      
      if($time == NULL){
          $extime = 'hh.ss';
      }else{
          $extime = date('h:i A', strtotime($time));
      }
      if($date != NULL){
			$examdatetime = "</br>$type :: $extime $exdate";
	  }
	  
	  
	  return $examdatetime;
	  
	  
}
function jodpost($row=array(), $ddata=array(), $calldate='', $co='' ){
	
	 
      $calldateformatting = date('d/m/Y', strtotime($calldate));
	  $examdatetime = '';
      
	  
	  
	  $examdatetime .= examdatetime($ddata['date'], $ddata['time'], $ddata['examtype']);
	  $examdatetime .= examdatetime($ddata['datew'], $ddata['timew'], $ddata['examtypew']);
	  $examdatetime .= examdatetime($ddata['datep'], $ddata['timep'], $ddata['examtypep']);
	  $examdatetime .= examdatetime($ddata['datev'], $ddata['timev'], $ddata['examtypev']);
	   
	  
	  
	  
     
      if($ddata['designations'] !='' && $ddata['designations'] !=' '){
         
          if ($exdatel == $calldateformatting) {
              if($ddata['time'] != NULL){
              $co++;
              }
                $examdateshow .="<li class='list-group-item'>".$ddata['designations'].' ';

                    $examdateshow .= tagstart($array=array(
                        'students'=>$ddata['students'],
                         'uniqid'=>$ddata['uniqid'],
                          'type'=>'examdate',
                           'jobid'=>$row['id']
                        ));
						$examdateshow .=$examdatetime;
                $examdateshow .="</li>";
				$returndata .=$examdateshow;
          }else{
               $examdateremaining .="<li class='list-group-item'>".$ddata['designations'].' ';
                   $examdateremaining .= tagstart($array=array(
                        'students'=>$ddata['students'],
                         'uniqid'=>$ddata['uniqid'],
                          'type'=>'examdate',
                           'jobid'=>$row['id']
                        ));
						$examdateremaining .=$examdatetime;
               $examdateremaining .="</li>";
			   $returndata .=$examdateremaining;
          }
     }
      
      return $returndata;
}

function useraccess($array=array()){
	global $userid;
	$jobuserid = $array['jobuserid'];
	$access = 1;
	
	/*
	if($userid !=11 && $userid !=1 && $userid !=12)	{
	
    	if($jobuserid !=$userid){
    		$access = 0;
    	}
	}
	*/
	 
	return array(
	'userid'=>$jobuserid,
	'access'=>$access
	);
}
function noteadd($id='', $class='', $class2=''){
	global $bs;
	 $uldatanote ="<$class class='list-group-item' data".$bs."toggle='modal' data".$bs."target='#modaladdnote'>
     <span class='  notebutton marginleft15px eid$id' eid='$id'> 
     <i class='fa fa-edit' aria-hidden='true'></i> 
      পরীক্ষা সম্পর্কিত নোট 
     </span>
     <$class2 class='notupdate$id'></$class2>
     </$class>";
	 
	 return $uldatanote;
}

function searchform($notes=''){
	global $conn,$query, $organization, $designation, $sarokno, $teletalk, $date, $searchingfor, $notesearch;
	?>

<form action="" method="get" class="form-inline">
    <?php

?>


    <div class="row">

        <div class="form-group">

            <select class="form-control" id="searchingfor" name="searchingfor" onchange="changeOrgaFunc(this);">
                <option value="">Searching For</option>
                <option <?php echo $searchingfor=='applystart'?'selected':''; ?> value="applystart">Apply Start</option>
                <option <?php echo $searchingfor=='applyend'?'selected':''; ?> value="applyend">Apply End</option>
                <option <?php echo $searchingfor=='examdate'?'selected':''; ?> value="examdate">Exam Day</option>
            </select>
        </div>

        <div class="form-group">

            <input type="date" class="form-control" placeholder="Date" id="date" name="date"
                value="<?php echo $date; ?>">
            <script>
            function changeOrgaFunc(obj)

            {

                var assistto = obj.options[obj.selectedIndex].value;
                if (assistto != '') {
                    jQuery('#date').prop('required', true);
                } else {
                    jQuery('#date').prop('required', false);
                }
            }
            </script>

        </div>


        <div class="form-group">

            <input type="text" class="form-control" placeholder="Organization" name="organization"
                value="<?php echo $organization; ?>">

        </div>

        <div class="form-group">

            <input type="text" class="form-control" placeholder="Designation" name="designation"
                value="<?php echo $designation; ?>">

        </div>

        <div class="form-group" style="display:none;">

            <input type="text" class="form-control" placeholder="Sarok No" name="sarokno"
                value="<?php echo $sarokno; ?>">

        </div>



        <div class="form-group">

            <input type="text" class="form-control" placeholder="Job Code teletalk/bank" name="teletalk"
                value="<?php echo $teletalk; ?>">

        </div>

        <?php
	if($notes ==1){?>
        <div class="form-group">

            <input type="text" class="form-control" placeholder="Yournote" name="notesearch"
                value="<?php echo $notesearch; ?>">

        </div>
        <?php } ?>



    </div>

    <div class="row mt-3">



        <button type="submit" class="btn btn-primary " name="submit" value="search">Search</button>



    </div>

</form>

<?php
}

function examdaycount($ddatax=array(), $searchKey='', $j=''){
	global $userid;
	 
}
function addingTheHTTPValue($stringValue) {
   if (!preg_match("~^(?:f|ht)tps?://~i", $stringValue)) {
      $stringValue = "http://" . $stringValue;
   }
   return $stringValue;
}