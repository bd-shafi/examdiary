<?php
include_once('connection.php');
include_once('userdata.php');

$bs = '-bs-';
$sqlrow = "SELECT * FROM users where id='$userid' limit 1";
       
		$result = mysqli_query($conn, $sqlrow);
		$row = mysqli_fetch_array($result);
	    $name = $row['name'];
		$email = $row['email'];
		$phone = $row['phone'];
		
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Search Admin | Exam Calendar</title>
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
</head>

<body>

    <div class="p-5 bg-warning text-white text-center">
        <?php
 $query = $conn->real_escape_string($_GET['query']);
$organization = $conn->real_escape_string($_GET['organization']);

$designation = $conn->real_escape_string($_GET['designation']);

$sarokno = $conn->real_escape_string($_GET['sarokno']);
$teletalk = $conn->real_escape_string($_GET['teletalk']);
$date = $conn->real_escape_string($_GET['date']);
$searchingfor = $conn->real_escape_string($_GET['searchingfor']);
 searchform();
 ?>

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
                            <li><a class="dropdown-item" href="<?php echo $foldername; ?>/dashboard.php">Dashboard</a></li>
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
                <?php
	 
	 
	 
	 
	 
	 
	if($_GET['submit'] != NULL){ 
    	 
	    
	       $queserysql ='';
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
    		  
	           $queserysql .= " and applystart like '$date'";
	       }else if($searchingfor =='applyend'){
	             $title = date("d-m-Y", strtotime($date)).'
    		 তারিখে
    		  যে পরীক্ষাগুলোতে আবেদন শেষ 
    		  '.$hobe;
	            $queserysql .= " and applyend like '$date'";
	       }else if($searchingfor =='examdate'){
	             $title = date("d-m-Y", strtotime($date)).'
    		 তারিখে
    		  যে পরীক্ষাগুলো অনুষ্ঠিত
    		  '.$hobe;
	            $queserysql .= " and examdateall like '%$date%'  ";
	       }else{
	            $queserysql .= " ";
	       }

            if($organization != NULL){
                $queserysql .= " and organization like '%$organization%'";
            }
            
            if($designation != NULL){
                $queserysql .= " and designation like '%$designation%'";
            }
            
            if($teletalk != NULL){
                $queserysql .= " and shortcode like '%$teletalk%'";
            }
	}
	  
	  
	  
	  
	  
	  
	  ?>
                <h2 class="topheader">
                    <?php
	  	echo $title; ?>

                </h2>


                <?php
	  if($query != 'my_notess'){
	        $sql = "SELECT *  FROM examdata where 1=1 $queserysql order by time desc limit 100";
	  }else{
	      $sql = "SELECT notes.id as jid, notes.userid, notes.jobid, notes.notes,notes.time,examdata.*   FROM notes
LEFT JOIN  examdata on examdata.id=notes.jobid
where 1=1 and notes.userid='$userid' order by examdata.time desc limit 100
  ";
	  }
	   
    $result = mysqli_query($conn, $sql);
    
 include_once('collapse-admin.php');


	  ?>

            </div>
        </div>
    </div>
    <?php
include_once('footer.php');
$conn -> close();