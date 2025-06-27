<?php
// ✅ Error reporting: hide notices, warnings, deprecated
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
ini_set('display_errors', '0'); // Set to '1' only for development

// Set your timezone
date_default_timezone_set('Asia/Dhaka');
$liverSefer=true;


if($liverSefer){//// #### for server
    $foldername='';
$foldernameSlash='';
//### read me: also update in js/main.js to examcalendar from there also
}else{
    $foldername='/examcalendar';
    $foldernameSlash='/examcalendar/';
    }