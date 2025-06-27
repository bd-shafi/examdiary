<?php
require_once(__DIR__.'/config.php');
// Safe cookie access with default fallback values
$useremail   = isset($_COOKIE['exemail']) ? $_COOKIE['exemail'] : '';
$userphone   = isset($_COOKIE['exphone']) ? $_COOKIE['exphone'] : '';
$userid      = isset($_COOKIE['exid']) ? $_COOKIE['exid'] : '';
$displayname = isset($_COOKIE['name']) ? $_COOKIE['name'] : 'Guest';

// Mask phone number (only if valid length)
$hidephone = strlen($userphone) >= 8 ? substr_replace($userphone, "****", 4, 4) : $userphone;

// Mask email (only if valid length)
$hideemail = strlen($useremail) >= 4 ? substr_replace($useremail, "****", 0, 4) : $useremail;

// Example display
// echo "User ID: $userid<br>";
// echo "Name: $displayname<br>";
// echo "Masked Phone: $hidephone<br>";
// echo "Masked Email: $hideemail<br>";