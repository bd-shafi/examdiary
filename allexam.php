<?php
include_once('connection.php');

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>All Jobs | Exam Calendar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
    .fakeimg {
        height: 200px;
        background: #aaa;
    }
    </style>
</head>

<body>

    <div class="jumbotron text-center" style="margin-bottom:0">
        <h1>My First Bootstrap 4 Page</h1>
        <p>Resize this responsive page to see the effect!</p>
    </div>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top:30px">
        <div class="row">
            <div class="col-sm-4">
                <h2>About Me</h2>
                <h5>Photo of me:</h5>
                <div class="fakeimg">Fake Image</div>
                <p>Some text about me in culpa qui officia deserunt mollit anim..</p>
                <h3>Some Links</h3>
                <p>Lorem ipsum dolor sit ame.</p>
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Active</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Disabled</a>
                    </li>
                </ul>
                <hr class="d-sm-none">
            </div>
            <div class="col-sm-8">
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
    
    
  
   
      $sql = "SELECT *  FROM examdata where 
	  id='1' or
	  id='2' or
	  id='3' or
	  id='4' or
	  id='5' or
	  id='6' or
	  id='7' or
	  id='22' or
	  id='23' or
	  id='24' or
	  id='25' or
	  id='26' or
	  id='27' or
	  id='28' or
	  id='29' or
	  id='30' or
	  id='31' or
	  id='32' or
	  id='33' or
	  id='34' or
	  id='35' or
	  id='36' or
	  id='37' or
	  id='38' or
	  id='39' or
	  id='40' or
	  id='41' or
	  id='42' or
	  id='43' or
	  id='50' or
	  id='51' or
	  id='52' or
	  id='53' or
	  id='54' or
	  id='55' or
	  id='56' or
	  id='57' or
	  id='58' or
	  id='59' or
	  id='60' or
	  id='61' or
	  id='62' or
	  id='63' or
	  id='64' or
	  id='65' or
	  id='66' or
	 
	  id='939' or
	  id='940' or
	  id='941' or
	  id='943' or
	  id='945' or
	  id='949' or
	  id='953' 
	
	
	  
	  ";
     $sql = "SELECT *  FROM examdata where id='78'";
    $result = mysqli_query($conn, $sql);
    
 $string ='<div id="accordiontop"> ';
  $applyby = '';
    if (mysqli_num_rows($result) > 0) {
     $i=0;
      
        $xx=0;
        while($row = mysqli_fetch_assoc($result)) {
            $i++;
            $co = 0;
            
            
            
          $getalldesignation = $row['examdateall'];
		  
  $getalldesignationdecode = json_decode($getalldesignation, true);
  if(is_array($getalldesignationdecode)){
	  echo'okk';
  }else{
	  echo 'noo';
	  $dividedegi = explode(',',$row['designation']);
	  $jobarray = array();
	  foreach($dividedegi as $index=>$datade){
		  $uniqid=uniqid();
	  $jobarray[] = array(
                    'designations'=>$datade,
                    'date'=>'',
                    'time'=>'',
                    'examtype'=>'',
                    'datew'=>'',
                    'timew'=>'',
                    'examtypew'=>'',
                    'timep'=>'',
                    'examtypep'=>'',
                    'datev'=>'',
                    'timev'=>'',
                    'examtypev'=>'',
                    'uniqid'=>$uniqid,
                    );
	  }
					
					
  }
  
  echo'<pre>';
  print_r($jobarray);
  echo'</pre>';
  $datesorting = array_column($getalldesignationdecode, 'date');

    array_multisort($datesorting, SORT_DESC, $getalldesignationdecode);
  $examdateshow='';
  $examdateremaining = '';
  foreach($getalldesignationdecode as $index=>$ddata){
      $calldateformatting = date('d/m/Y', strtotime($calldate));
	  
	  if($ddata['uniqid'] == NULL)
	  {
		  $uniqid=$row['id'].'xx'.$index.'xx'.uniqid();
		 $getalldesignationdecode[$index]['uniqid']= $uniqid;
		 $xx = 1;
	  }
      
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
      
      if($ddata['designations'] !=' ' && $ddata['designations'] !=''){
          if ($exdatel == $calldateformatting) {
              if($ddata['time'] != NULL){
              $co++;
              }
                $examdateshow .="<li class='list-group-item'>".$ddata['designations'].": Exam Date: ".$exdate.", Time: ".$extime.", Type: ".$ddata['examtype']."
                <span class='uniqid' uniqid='".$ddata['uniqid']."'>
                <i class='fa fa-tag' aria-hidden='true'></i>Love </span>
                
                </li>";
          }else{
               $examdateremaining .="<li class='list-group-item'>".$ddata['designations'].": Exam Date: ".$exdate.", Time: ".$extime.", Type: ".$ddata['examtype']."
               
               <i class='fa fa-tag' aria-hidden='true'></i> Love: ".$ddata['uniqid']."
               
               </li>";
          }
      }
     
  }
  
  
  
  
  
  ///// new code here
  /*
  echo'<pre>';
  print_r($getalldesignationdecode);
  echo'</pre>';
  */
  $examdateall = json_encode($jobarray, JSON_UNESCAPED_UNICODE);

				echo  $sql2=" update examdata set 
				examdateall = '$examdateall'      
				where   id='$row[id]' ";
				
				$result2 = mysqli_query($conn, $sql2);
 
  
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
        
             $uldata = '<div class="card">';
             $uldata .= '
             <div class="card-header" id="headingTop'.$row['id'].'">
     <a class="card-link plusminustop " getclass="plusminustop'.$row['id'].'" data-toggle="collapse" aria-expanded="true" aria-controls="#collapseTop'.$row['id'].'"  href="#collapseTop'.$row['id'].'">
         <b>'.$row['id'].') '.$i.' .   </b> '.$row['organization'].' | '.$row['shortcode'].' '.$extext.' <span class="float-right collpseex plusminustop'.$row['id'].'">+</span>
      </a>
    </div>
             ';       
            
      $uldata .= '<div id="collapseTop'.$row['id'].'" class="collapse " aria-labelledby="headingTop'.$row['id'].'" data-parent="#accordiontop"><div class="card-body">';       
    
    
    
    
    
    $uldata .= "<ul class='list-group dividebyother'>";
  
   
  
  $designation = $row['designation'] ? $row['designation']: 'Undefined';
  
  ///$uldata .="<li class='list-group-item'>Post: ".rtrim($designation, ',')."</li>";
  
  if(strtotime($row['applystart']) != NULL){
  $uldata .="<li class='list-group-item'>Apply Start : ".date('d/m/Y', strtotime($row['applystart']))."</li>";
  }
  if(strtotime($row['applyend']) != NULL){
  $uldata .="<li class='list-group-item'>Apply End : ".date('d/m/Y', strtotime($row['applyend']))."</li>";
  }
  if(strtotime($row['applyend']) != NULL){
  $uldata .="<li class='list-group-item'>Collection Date & Time : ".date('d/m/Y h:i A', strtotime($row['time']))."</li>";
  }
  
  
  
  
  
  
  
  
  /*
  if($row['examdate'] != NULL && $row['examdate'] != 'No Published'){
  $uldata .="<li class='list-group-item'>Exam Date: ".date('d/m/Y', strtotime($row['examdate']))." ". date('h:i A', strtotime($row['examtime']))." | ".$row['examtype']."</li>";
  }else{
      $uldata .="<li class='list-group-item'>Exam Date: ".$row['examdatepublished']."</li>";
  }
 */ 
  $uldata .="<li class='list-group-item'><b><i>Designation : Exam Date & Time</i></b></li>";
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  $uldata .= $examdateshow;
  $uldata .= $examdateremaining;
  
  
  
  
  
  
    $disabledivwishlist = '';
    
		 $checktext = ','.$userid.',';
  if (strpos($row['otherusers'], $checktext) !== false) {
      $disabledivwishlist = 'disabledivwishlist';
  }else{
      $disabledivwishlist = '';
  }
  
  $uldata .="<li class='list-group-item' ><span class='".$disabledivwishlist." lovebutton reminderbutton marginleft15px eid".$row['id']."' eid='".$row['id']."'> &#128151;</span></li>";
  
  
  if($todaydate <= $row['applyend']){
      if($row['applyurl'] !=NULL){
          $uldata .="<li class='list-group-item'><a target='_blank' href='".$row['applyurl']."'>Apply Now</a></li>";
      }else if($row['applyby'] =='teletalk'){
          $uldata .="<li class='list-group-item'><a target='_blank'  href='http://".$row['shortcode'].".teletalk.com.bd/'>Apply Now</a></li>";
      }else{
          
      }
  }
 if($row['userid'] == $userid){
  $uldata .="<li class='list-group-item'><a href='".$foldername."/edit.php?jid=".$row['id']."'>Edit</a></li>";
  }
$uldata .="</ul>";

$uldata .="</div> </div>";
    
    
    
    
    

$uldata .="</div>";


      $string .=     $uldata;  
             
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
          
    jQuery( '.reminderbutton' ).click(function() {
      var error = 0;				
			 	
			var eid = jQuery(this).attr('eid');
		
			
	 
	
			if(!error){
				 
				jQuery('.eid'+eid).html('Please Wait');
				
				jQuery.ajax({
				url: '".$foldernameSlash."ajax.php?qwishlist=true',
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
      echo $string;  
    }
    
    
    
    ?>




                </div>





            </div>
        </div>
    </div>

    <div class="jumbotron text-center" style="margin-bottom:0">
        <p>Footer</p>
    </div>

</body>

</html>