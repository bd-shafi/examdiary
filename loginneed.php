<?php
include_once('userdata.php');
$locationre=$foldername.'/index.php?logintosite=fail';
if($userid == NULL){
	header("Location:$locationrel");
	exit;
}