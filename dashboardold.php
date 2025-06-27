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
            src="<?php echo $foldername; ?><?php echo $foldername; ?>/images/logo-no-background.svg" alt="ExamCalendar Logo" />

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
                        <a class="nav-link" href="/?searchingfor=applystart">Apply Start</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/?searchingfor=applyend">Apply End</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/?searchingfor=examdate">Exam Day</a>
                    </li>
                    <li class="nav-item">

                        <a class="nav-link  " sendaction="examdate" href="/search.php">
                            <i class='fa fa-search' aria-hidden='true'></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button"
                            data<?php echo $bs; ?>toggle="dropdown"><i class='fa fa-user' aria-hidden='true'></i></a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/dashboard.php">Dashboard</a></li>
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
                                <a class="dropdown-item" href="/logout.php">

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
            <div class="col-sm-4">
                <h2>About Me</h2>


                <p>Name: <?php echo $name; ?></p>
                <p>Phone: <?php echo $hidephone; ?></p>
                <p>Email: <?php echo $email; ?></p>
                <h3 class="mt-4 badge bg-primary">Important Links</h3>

                <ul class="nav nav-pills flex-column">

                    <li class="nav-item">
                        <a class="nav-link" href="?query=my_exams">My Exams</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?query=my_applications">My Application Start/End</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="?query=my_notess">My Notes</a>
                    </li>
                </ul>
                <hr class="d-sm-none">
            </div>
            <div class="col-sm-8">

                <h2>Hover Rows</h2>
                <p>The .table-hover class enables a hover state (grey background on mouse over) on table rows:</p>
                <div class="table-responsive">
                    <table class="table table-hover table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Organization</th>
                                <th>Post</th>
                                <th>Date</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John</td>
                                <td>Post</td>
                                <td>Date</td>
                                <td>Notes</td>

                            </tr>
                            <tr>
                                <td>John</td>
                                <td>Post</td>
                                <td>Date</td>
                                <td>Notes</td>
                            </tr>
                            <tr>
                                <td>John</td>
                                <td>Post</td>
                                <td>Date</td>
                                <td>Notes</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <?php
	 
	$queserysql = '';
	$usersearch = '"'.$userid.'"';
	if($query == 'my_exams'){
		  $title = '
		  যে পরীক্ষাগুলোর তারিখ নির্ধারিত হয়েছেঃ
		  ';
		  $queserysql = " and examdateall like '%$usersearch%'  ";
	  }else if($query == 'my_applications'){
		  $queserysql = " and otherusers like '%,$userid,%'";
		  $title = '
		  যে পরীক্ষাগুলোতে আবেদন করার জন্য চিহ্নিত করেছেনঃ
		  ';
	  }else if($query == 'my_notess'){
		  $queserysql = " and otherusers like '%,$userid,%'";
		  $title = '
		  যে পরীক্ষাগুলোর জন্য আপনি নোট যুক্ত করেছেনঃ
		  ';
	  }
	  else{
		     $title = '
		  যে পরীক্ষাগুলোর তারিখ নির্ধারিত হয়েছেঃ
		  ';
			$queserysql = " and examdateall like '%$usersearch%'  ";
	  }	
	  ?>
                <h2 class="topheader">
                    <?php
	  	echo $title; ?>

                </h2>


                <?php
	  if($query != 'my_notess'){
	   $sql = "SELECT *  FROM examdata where 1=1 $queserysql ";
	  }else{
	   $sql = "SELECT notes.id as jid, notes.userid, notes.jobid, notes.notes,notes.time,examdata.*   FROM notes
LEFT JOIN  examdata on examdata.id=notes.jobid
where 1=1 and notes.userid='$userid' 
  ";
	  }
	   
    $result = mysqli_query($conn, $sql);
    
 include_once('collapse.php');


	  ?>

            </div>
        </div>
    </div>
    <?php
include_once('footer.php'); ?>
    <div class="mt-5 p-4 bg-dark text-white text-center">
        <p>© 2023 Exam Calendar </p>
    </div>

</body>

</html>