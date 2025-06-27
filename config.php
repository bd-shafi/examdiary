<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// Turn off error display on production
ini_set('display_errors', '1'); // Set to '0' in production

// Set your timezone
date_default_timezone_set('Asia/Dhaka');
$foldername='/examcalendar';
$foldernameSlash='/examcalendar/';