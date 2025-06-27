<?php
require_once(__DIR__.'/config.php');
date_default_timezone_set('Asia/Dhaka');
$today = date("Y-m-d H:i:s");
$todaydate = date("Y-m-d");
$todate = date("Y-m-d");
///pdfseller db start
///////### for localhost
if($liverSefer){//// #### for server
    $servername = "localhost";
    $username = "examcalenderuser";
    $password = "6&qaialCI=";
    $dbname = "dbeaver_db";
}else{
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "examcalendar";
    }




// pdfseller db end
 
$persmscharge = .40;


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//$mysqli->set_charset("utf8");
// Check connection
if ($conn->connect_error) {
    $showtext = 'We are sorry, We are updating our site, We will back within a few minutes. Please Wait';
    die($showtext);
}else{
   // echo'okkx';
}
$conn->set_charset("utf8");
function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}


date_default_timezone_set('Asia/Dhaka');

$urltype = $_SERVER['REQUEST_URI'];
$today = date("Y-m-d H:i:s");

// Safely get cookie value
$userroll = isset($_COOKIE['user']) ? $_COOKIE['user'] : 'unknown_user';

// Get user IP address safely
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Handle proxies
        return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}
$user_ip = getUserIP();

include_once('functions.php');

// Now the array should work fine
$arraydata = array(
    'link' => $urltype,
    'time' => $today,
    'ip' => $user_ip,
    'roll' => $userroll
);

///wp_visitor_count($arraydata);