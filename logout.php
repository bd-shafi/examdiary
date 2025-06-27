<?php
require_once(__DIR__.'/config.php');
setcookie("exemail", '', time() + 3600,'/');
setcookie("exphone", '', time() + 3600,'/');
setcookie("exid", '', time() + 3600,'/');
$locationr=$foldername;

header("Location: $locationr/");

exit;