<?php
header("Access-Control-Allow-Origin: *");
include_once('connection.php');
include_once('userdata.php');
date_default_timezone_set('Asia/Dhaka');
$today = date("Y-m-d H:i:s");
$todaydate = date("Y-m-d");
if($_GET['lovemef'] != NULL){
	 $advice = $conn->real_escape_string($_POST['advice']);
	 
	  $sqlrow = "insert into loveme set 
            advice='$advice', 
             
            userid='$userid',
            time='$today'
            ";
			$message = 'Thank You';
        $result = mysqli_query($conn, $sqlrow);
		$return_arr = array(
                            "message" => $message
                            
                            
                            );
        
        
        
        echo json_encode($return_arr);
		
}
if($_GET['removelist'] != NULL){
    
        $uniqid = $conn->real_escape_string($_POST['uniqid']);
        $jobid = $conn->real_escape_string($_POST['jobid']);
        
       
      
       
        $sqlrow = "SELECT * FROM examdata where id='$jobid' limit 1";
       
		$result = mysqli_query($conn, $sqlrow);
		$row = mysqli_fetch_array($result);
	 
      
        
        $getalldesignation = $row['examdateall'];
        $getalldesignationdecode = json_decode($getalldesignation, true);
        foreach($getalldesignationdecode as $index=>$ddata){
            
            if($uniqid == $ddata['uniqid']){
                $olddataofstudents =$ddata['students'];

						if (($key = array_search($userid, $olddataofstudents)) !== false) {
						unset($olddataofstudents[$key]);
						}
                $getalldesignationdecode[$index]['students'] =$olddataofstudents;
                
            }
            
           
        }
    
        $examdateall = json_encode($getalldesignationdecode, JSON_UNESCAPED_UNICODE);

			$sql2=" update examdata set 
				examdateall = '$examdateall'      
				where   id='$jobid' ";
				
				$result2 = mysqli_query($conn, $sql2);
				 $message= "<i class='fa fa-star' aria-hidden='true'></i> ";
				 
				  $return_arr = array(
                            "message" => $message,
                            "type" => 'examdate',
                            "modalbackresponse"=>''
                            
                            );
        
        
        
        echo json_encode($return_arr);
    
        
}




if (isset($_GET['addtolist']) && $_GET['addtolist'] != NULL) {

    // Safely fetch POST data
    $uniqid = isset($_POST['uniqid']) ? $conn->real_escape_string($_POST['uniqid']) : '';
    $jobid = isset($_POST['jobid']) ? $conn->real_escape_string($_POST['jobid']) : '';
    $userid = $userid ?? 0; // ensure $userid is defined

    // Validate required data
    if ($uniqid && $jobid && $userid) {
        // Fetch job row
        $sqlrow = "SELECT * FROM examdata WHERE id='$jobid' LIMIT 1";
        $result = mysqli_query($conn, $sqlrow);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $getalldesignation = $row['examdateall'];

            // Decode JSON safely
            $getalldesignationdecode = json_decode($getalldesignation, true);

            if (is_array($getalldesignationdecode)) {
                foreach ($getalldesignationdecode as $index => $ddata) {

                    // Ensure students is an array before using it
                    $olddataofstudents = isset($ddata['students']) && is_array($ddata['students']) ? $ddata['students'] : [];

                    if ($uniqid == ($ddata['uniqid'] ?? '')) {

                        // Add current user ID if not already present
                        if (!in_array($userid, $olddataofstudents)) {
                            $olddataofstudentsnew = [$userid];

                            // Merge existing students with new user ID
                            if (!empty($olddataofstudents)) {
                                $getalldesignationdecode[$index]['students'] = array_merge($olddataofstudents, $olddataofstudentsnew);
                            } else {
                                $getalldesignationdecode[$index]['students'] = $olddataofstudentsnew;
                            }
                        }
                    }
                }

                // Encode back to JSON
                $examdateall = json_encode($getalldesignationdecode, JSON_UNESCAPED_UNICODE);

                // Update the database
                $sql2 = "UPDATE examdata SET examdateall = '$examdateall' WHERE id = '$jobid'";
                $result2 = mysqli_query($conn, $sql2);

                // Prepare response message
                $message = "<i class='fa fa-star' aria-hidden='true'></i>";

                $return_arr = array(
                    "message" => $message,
                    "type" => 'examdate',
                    "modalbackresponse" => ''
                );

                echo json_encode($return_arr);
            } else {
                // JSON decode failed or returned non-array
                echo json_encode([
                    "message" => "Invalid examdateall data.",
                    "type" => 'error',
                    "modalbackresponse" => ''
                ]);
            }
        } else {
            // No row found or query failed
            echo json_encode([
                "message" => "Job not found.",
                "type" => 'error',
                "modalbackresponse" => ''
            ]);
        }
    } else {
        // Missing required POST data
        echo json_encode([
            "message" => "Missing parameters.",
            "type" => 'error',
            "modalbackresponse" => ''
        ]);
    }
}


if($_GET['notebutton'] != NULL){
    
        $jobid = $conn->real_escape_string($_POST['eid']);
        
        
        $sqlrow = "SELECT * FROM notes where jobid='$jobid' and userid='$userid' limit 1";
       
		$result = mysqli_query($conn, $sqlrow);
		$row = mysqli_fetch_array($result);
	 
      
        
        $notes = $row['notes'];
        $insert=0;
        if($notes == NULL){
            $insert=1;
        }
        
        $return_arr = array(
            
                            "message" => '',
                            "insert" => $insert,
                            "note" => $notes,
                            "jobid" => $jobid
                            
                            );
        
        
        
        echo json_encode($return_arr);
    
         
}


if($_GET['noteadd'] != NULL){
    
        $jobid = $conn->real_escape_string($_POST['jobid']);
         $notes = $conn->real_escape_string($_POST['notes']);
         $insert = $conn->real_escape_string($_POST['insert']);
        
        
       
        if($insert ==0){
        $sqlrow = "update notes set notes='$notes' where jobid='$jobid' and userid='$userid' limit 1";
        $result = mysqli_query($conn, $sqlrow);
        }else{
            $sqlrow = "insert into notes set 
            notes='$notes', 
            jobid='$jobid',
            userid='$userid',
            time='$today'
            ";
        $result = mysqli_query($conn, $sqlrow);
        }
        
        
        $return_arr = array(
            
                            "message" => 'Added.',
                            "note" => $notes
                            
                            );
        
        
        
        echo json_encode($return_arr);
    
         
}

if($_GET['qwishlist'] !=NULL){
    $eid = $conn->real_escape_string($_POST['eid']);
	$fortype = $conn->real_escape_string($_POST['fortype']);
    
    
    if($userid == NULL){
    echo'Login First Please..';
    }else{
    $sqlrow = "SELECT * FROM examdata where id='$eid' limit 1";
       
		$result = mysqli_query($conn, $sqlrow);
		$row = mysqli_fetch_array($result);
	 
		 $otherusers = $row['otherusers'];
		 $checktext = ','.$userid.',';
		 
			 if (strpos($otherusers, $checktext) !== false) {
				$otherusersnew = str_replace($checktext,'',$otherusers);
				$added= 'no';
				$message = 'Removed, Click Love plus to add';
			}else{
				$otherusersnew = $otherusers.','.$userid.',';
				$added= 'yes';
				$message = 'Added, Click Love minus to remove';
			}
		     
            $sqlrow = "update examdata set otherusers='$otherusersnew' where id='$eid' limit 1";
       
		    $result = mysqli_query($conn, $sqlrow);
			
			$return_arr = array(
            
                            "message" => $message,
                            "addedx" => $added
                            
                            );
        
        
        
        echo json_encode($return_arr);
		    
		 
		
		
		
        }
		 
		 
}

if($_GET['removefile'] != NULL){
	
	$fileid = $conn->real_escape_string($_POST['fileid']);
	$jobid = $conn->real_escape_string($_POST['jobid']);
	
	
	$sql = "SELECT * FROM circularpdfimages where incidentid='$jobid' and id='$fileid'  limit 1";
       		$resultdelete = mysqli_query($conn, $sql);
			$rowdelete = mysqli_fetch_array($resultdelete);
			$filename = $rowdelete['imageurl'];
			$jobuserid = $rowdelete['uploadedby'];
	
	$useraccess = useraccess($array=array(
		 'jobuserid' =>$jobuserid
		 ));
		 
		 
	$accessuserid = $useraccess['userid'];
	$access = $useraccess['access'];
	
	
        
		
		if($access == 1){
			
		
		
		
			$sqlrow = "delete from circularpdfimages 
			
			where incidentid='$jobid' and id='$fileid'  limit 1
			
			";
			$result = mysqli_query($conn, $sqlrow);
			
			if($result){
				unlink(substr($filename, 1));
			}
		}
        
		
		$return_arr = array(
            
                            "message" => $message,
							 
                            "addedx" => $added,
							 
                            
                            );
							
							
        echo json_encode($return_arr);
}



if (isset($_GET['clicktocall']) && $_GET['clicktocall'] != NULL) {
?>

<table class="table table-hover table-sm table-bordered table-striped">
    <thead>
        <tr>
            <th>SL</th>
            <th>Organization</th>
            <th>Post & Exam Date</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Safeguard for undefined variables
        $userid = $userid ?? 0;
        $bs = $bs ?? '';
        $calldate = $calldate ?? '';
        $co = $co ?? '';

        $usersearch = '"' . $userid . '"';

        $sql = "SELECT 
                    notes.id AS noteid, 
                    notes.userid AS noteuserid, 
                    notes.jobid AS notejobid, 
                    notes.notes AS notesdata,
                    notes.time AS notetime,
                    examdata.* 
                FROM examdata
                LEFT JOIN notes 
                    ON notes.jobid = examdata.id 
                    AND notes.userid = $userid
                WHERE 
                    1=1 AND (
                        examdata.examdateall LIKE '%$usersearch%' 
                        OR notes.userid = '$userid' 
                        OR examdata.otherusers LIKE '%,$userid,%'
                    )
                GROUP BY examdata.id";

        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $i = 0;

            while ($row = mysqli_fetch_assoc($result)) {
                $i++;
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td>
                <?php
                        echo $row['organization'];

                        $checktext = ',' . $userid . ',';
                        $disabledivwishlist = (strpos($row['otherusers'], $checktext) !== false) ? 'disabledivwishlist' : '';

                        echo '<span class="bigloveshow">';
                        echo bigLove($disabledivwishlist, $row['id'], $bs);
                        echo '</span>';
                        ?>
            </td>
            <td>
                <?php
                        $tagged = json_decode($row['examdateall'], true);

                        if (is_array($tagged)) {
                            foreach ($tagged as $keys => $tag) {
                                if (!empty($tag['students']) && is_array($tag['students']) && in_array($userid, $tag['students'])) {
                                    echo '<div class="desidata">';
                                    echo jodpost($row, $tag, $calldate, $co);
                                    echo '</div>';
                                }
                            }
                        }
                        ?>
            </td>
            <td>
                <?php
                        echo $row['notesdata'] ?? '';
                        echo noteadd($row['id'], 'li', 'div');
                        ?>
            </td>
        </tr>
        <?php
            }
        } else {
            echo '<tr><td colspan="4" class="text-center">No matching data found.</td></tr>';
        }
        ?>
    </tbody>
</table>

<?php
} // end if clicktocall


$conn -> close();