<?php
include_once('loginneed.php');
include_once('connection.php');
include_once('userdata.php');
$query = $conn->real_escape_string($_GET['query']);
$bs = '-bs-';
$sqlrow = "SELECT * FROM users where id='$userid' limit 1";
       
		$result = mysqli_query($conn, $sqlrow);
		$row = mysqli_fetch_array($result);
	    $name = $row['name'];
		$email = $row['email'];
		$phone = $row['phone'];
		$password = $row['password'];
		$id = $row['id'];
		
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Dahsboard | Exam Calendar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/examcalendar-website-favicon-color.svg" sizes="any" type="image/svg+xml">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="css/custom.css?v=<?php echo rand(1,100); ?>">
    <style>
    .fakeimg {
        height: 200px;
        background: #aaa;
    }

    .card-link {
        text-decoration: none;
    }
    </style>
    <?php   include_once('facebook.php');   ?>
</head>

<body>

    <div class="p-5 bg-primary text-white text-center">
        <img width="300" height="100" class="img-responsive"
            src="<?php echo $foldername; ?>/images/logo-no-background.svg" alt="ExamCalendar Logo" />

    </div>

    <nav class="navbar navbar-expand-sm bg-light justify-content-center">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $foldername; ?>/">Home</a>
            <button class="navbar-toggler" type="button" data<?php echo $bs; ?>toggle="collapse"
                data<?php echo $bs; ?>target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">



                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $foldername; ?>/?searchingfor=applystart">Apply Start</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $foldername; ?>/?searchingfor=applyend">Apply End</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $foldername; ?>/?searchingfor=examdate">Exam Day</a>
                    </li>
                    <li class="nav-item">

                        <a class="nav-link  " sendaction="examdate" href="<?php echo $foldername; ?>/search.php">
                            <i class='fa fa-search' aria-hidden='true'></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button"
                            data<?php echo $bs; ?>toggle="dropdown"><i class='fa fa-user' aria-hidden='true'></i></a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo $foldername; ?>/dashboard.php">Dashboard</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript: void(0)"><?php echo $displayname; ?></a></li>
                            <li><a class="dropdown-item" href="javascript: void(0)"><?php echo $hidephone; ?></a></li>
                            <li><a class="dropdown-item" href="javascript: void(0)"><?php echo $email; ?></a></li>

                            <li>
                                <?php
        if($_COOKIE['exid'] == NULL){
            ?>

                                <a class="dropdown-item login" href="#" data-toggle="modal" data-target="#loginform"
                                    href="#">Login</a>
                                <?php
        }else{
            ?>
                                <a class="dropdown-item" href="<?php echo $foldername; ?>/logout.php">

                                    Log out

                                </a>
                                <?php
        }
        ?>
                            </li>
                        </ul>
                    </li>



                </ul>
            </div>
        </div>
    </nav>


    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12">
                <h2>About Me</h2>


                <p>Name: <?php echo $name; ?> <span><i class=' fa fa-edit  ' aria-hidden='true' data-bs-toggle="modal"
                            data-bs-target="#updateprofile"></i></span></p>
                <p>Phone: <?php echo $hidephone; ?></p>
                <p>Email: <?php echo $email; ?></p>

                <!-- Modal -->
                <div class="modal fade" id="updateprofile" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Update Your Profile</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" class="signupforms" method="post" id="signupforms"
                                    onsubmit="return signupforms();">
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input required type="text" value="<?php echo $name; ?>" class="form-control"
                                            placeholder="Enter name" id="name" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email address:</label>
                                        <input required type="email" value="<?php echo $email; ?>" class="form-control"
                                            placeholder="Enter email" id="email" name="email" ]>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone:</label>
                                        <input required type="number" value="<?php echo $phone; ?>" class="form-control"
                                            placeholder="Enter phone" id="phone" name="phone">
                                        <input required type="hidden" value="<?php echo $id; ?>" class="form-control"
                                            placeholder="Enter phone" id="id" name="id">

                                    </div>

                                    <div class="form-group passworddiv">
                                        <label for="firstpassword">Password:</label>
                                        <input required type="password" value="<?php echo $password; ?>"
                                            class="form-control" placeholder="Enter Password" id="firstpassword"
                                            name="password">
                                        <i class="fa fa-eye eyed" onclick="showPass()"></i>
                                    </div>

                                    <div class="form-group passworddiv">
                                        <label for="repassword">Confirm Password:</label>
                                        <input required type="password" value="<?php echo $password; ?>"
                                            class="form-control" placeholder="Enter Password" id="repassword"
                                            name="repassword">
                                        <i class="fa fa-eye eyed" onclick="showPass()"></i>
                                    </div>
                                    <script>
                                    function showPass() {
                                        var x = document.getElementById("repassword");
                                        var y = document.getElementById("firstpassword");
                                        if (x.type === "password") {
                                            x.type = "text";
                                            y.type = "text";
                                        } else {
                                            x.type = "password";
                                            y.type = "password";
                                        }
                                    }
                                    </script>
                                    <button type="submit" class="btn btn-primary  btn-block"
                                        name="submit">Update</button>
                                </form>
                                <div class="signupsuccess"></div>


                                <script>
                                //createhides
                                function signupforms() {

                                    //console.log("submit event");
                                    var fd = new FormData(document.getElementById("signupforms"));
                                    var error = 0;
                                    var password = jQuery('#firstpassword').val();
                                    var repassword = jQuery('#repassword').val();
                                    if (password != repassword) {
                                        error = 1;
                                        alert('Password & Confirm Password must be same.');
                                        return false;

                                    }



                                    if (!error) {

                                        jQuery('.signupsuccess').html(
                                            '<div class="spinner-border text-info" role="status"> <span class="visually-hidden">Loading...</span></div>'
                                        );

                                        jQuery.ajax({
                                            url: "<?php echo $foldername; ?>/ajax.php?signup=true",
                                            type: "POST",
                                            data: fd,
                                            enctype: 'multipart/form-data',
                                            success: function(data) {



                                                var json = jQuery.parseJSON(data);
                                                var message = json.message;

                                                jQuery('.signupsuccess').html(message);
                                                jQuery('#spassword').val(json.password);
                                                jQuery('#sphone').val(json.phone);
                                                jQuery(".loginclick").trigger("click");
                                                jQuery("#signupforms").hide(500);

                                                document.getElementById("signupforms").reset();





                                            },
                                            processData: false, // tell jQuery not to process the data
                                            contentType: false // tell jQuery not to set contentType
                                        });
                                    }
                                    return false;
                                };
                                </script>



                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="d-sm-none">
            </div>
        </div>
        <div class="row">

            <div class="col-sm-12">
                <h2>Manage your exam</h2>
                <?php
	$query = $conn->real_escape_string($_GET['query']);
$organization = $conn->real_escape_string($_GET['organization']);

$designation = $conn->real_escape_string($_GET['designation']);

$sarokno = $conn->real_escape_string($_GET['sarokno']);
$teletalk = $conn->real_escape_string($_GET['teletalk']);
$date = $conn->real_escape_string($_GET['date']);
$searchingfor = $conn->real_escape_string($_GET['searchingfor']);
$notesearch = $conn->real_escape_string($_GET['notesearch']);
 searchform(1);
 ?>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist" typeofcall="all">
                    <li class="nav-item clicktocallxxx">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home">All Exam</a>
                    </li>
                    <!--
    <li class="nav-item clicktocall"  typeofcall="examdate">
      <a class="nav-link" data-bs-toggle="tab" href="#home">Exam Date</a>
    </li>
    <li class="nav-item  clicktocall" typeofcall="notes">
      <a class="nav-link" data-bs-toggle="tab" href="#home">Notes</a>
    </li>
	-->
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="home" class="container tab-pane active"><br>
                        <h3>Your all exam</h3>


                        <div class="table-responsive">






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
	
	$usersearch = '"'.$userid.'"';
	$queserysql ='';
	if($_GET['submit'] != NULL){ 
				   if($date<$todate){
					   $hobe= 'হয়েছেঃ';
				   }else{
						$hobe= 'হবেঃ';
				   }
				   if($searchingfor =='applystart'){
						$title = date("d-m-Y", strtotime($date)).'
					 তারিখে
					  যে পরীক্ষাগুলোতে আবেদন শুরু 
					  '.$hobe;
					  
					   $queserysql .= " and examdata.applystart like '$date'";
				   }else if($searchingfor =='applyend'){
						 $title = date("d-m-Y", strtotime($date)).'
					 তারিখে
					  যে পরীক্ষাগুলোতে আবেদন শেষ 
					  '.$hobe;
						$queserysql .= " and examdata.applyend like '$date'";
				   }else if($searchingfor =='examdate'){
						 $title = date("d-m-Y", strtotime($date)).'
					 তারিখে
					  যে পরীক্ষাগুলো অনুষ্ঠিত
					  '.$hobe;
						$queserysql .= " and examdata.examdateall like '%$date%' ";
				   }else{
						$queserysql .= " ";
				   }

					if($organization != NULL){
						$queserysql .= " and organization like '%$organization%'";
					}
					
					if($designation != NULL){
						$queserysql .= " and examdata.designation like '%$designation%'";
					}
					
					if($teletalk != NULL){
						$queserysql .= " and examdata.shortcode like '%$teletalk%'";
					}
					if($notesearch != NULL){
						$queserysql .= " and notes.notes like '%$notesearch%'";
					}
					
			}
			
			
			 
			$queserysql .= " and (examdata.examdateall like '%$usersearch%'  or notes.userid='$userid' or  examdata.otherusers like '%,$userid,%')  ";
	
	
	
	 
 echo $sql = "SELECT notes.id as noteid, notes.userid as noteuserid, notes.jobid as notejobid, notes.notes as notesdata,notes.time as notetime,examdata.*   FROM examdata
left JOIN   notes on notes.jobid=examdata.id and  notes.userid=$userid
where  1=1 $queserysql
group by examdata.id
  ";
	  echo 'data checking here';
	   
    $result = mysqli_query($conn, $sql);
    
    echo mysqli_num_rows($result) . " rows found";
echo 'checking hee';
    if (mysqli_num_rows($result) > 0) {
        $i = 0;
    
        while ($row = mysqli_fetch_assoc($result)) {
            $i++;
            ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <?php
                    echo htmlspecialchars($row['organization']);
    
                    $checktext = ',' . $userid . ',';
                    $disabledivwishlist = (strpos($row['otherusers'], $checktext) !== false) ? 'disabledivwishlist' : '';
    
                    echo '<span class="bigloveshow">';
                    echo bigLove($disabledivwishlist, $row['id'], $bs, $row);
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
                    echo htmlspecialchars($row['notesdata']);
                    echo noteadd($row['id'], 'li', 'div');
                    ?>
                                        </td>
                                    </tr>
                                    <?php
        }
    } else {
        ?>
                                    <tr>
                                        <td colspan="4" style="text-align:center;">No records found.</td>
                                    </tr>
                                    <?php
    }
    
    

	  ?>
                                </tbody>
                            </table>











                        </div>
                    </div>




                </div>






















            </div>
        </div>
    </div>
    <script>
    jQuery('.clicktocall').click(function() {



        var error = 0;

        var typeofcall = jQuery(this).attr('typeofcall');


        if (!error) {

            jQuery('.table-responsive').html('please wait');

            jQuery.ajax({
                url: '<?php echo $foldernameSlash; ?>ajaxaction.php?clicktocall=true',
                type: 'POST',
                data: {
                    typeofcall: typeofcall
                },
                success: function(data) {


                    jQuery('.table-responsive').html(data);




                },

            });
        }



    });
    </script>
    <?php
echo bringscript('plusminustop');
include_once('footer.php'); 