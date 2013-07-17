<?php
include("fetch.php");
include("insert.php");
$toilet=0;
$lastrow = selectLastLog($toilet);
$brightness = `cat ramcache/brightness0`;
$state = $brightness > 20 ? true : false;
$dbstate = $lastrow['state'];
$timestamp_c= `cat ramcache/timestamp0`;
$timestamp_l=$lastrow['timestamp'];


if ($state != $dbstate) {
	insertLog($state,$toilet);
	$lastrow = selectLastLog($toilet);
	echo $lastrow['timestamp'];
} else {
	echo $timestamp_c;
}
?>
