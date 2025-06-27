<?php
include_once('connection.php');
include_once('userdata.php');
if(isset($_POST['submit'])){
    $phone = $conn->real_escape_string($_POST['phone']);
        $password = $conn->real_escape_string($_POST['password']);
    $sqlrow = "SELECT * FROM users where password='$password' and    phone='$phone'"; 
		$result = mysqli_query($conn, $sqlrow);
		$row = mysqli_fetch_array($result);
	 
		 $userID = $row['id'];
		 $dbphone = $row['phone'];
		 $dbemail = $row['email'];
		 $dbname = $row['name'];
	 
		if($userID  != NULL){
		$expiry = strtotime('+36 month');
		setcookie('exemail', $dbemail, $expiry,'/');
		setcookie('exphone', $dbphone, $expiry,'/');
		setcookie('exid', $userID, $expiry,'/');
		setcookie('name', $dbname, $expiry,'/');
		header('Location: /');
		exit;
		}else{
		    header('Location: /?logintosite=fail');
		exit;
		}
}