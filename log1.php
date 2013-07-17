<?php
include("fetch.php");
include("insert.php");
$toilet=1;
$lastrow = selectLastLog($toilet);
$brightness = `cat ramcache/brightness1`;
$state = $brightness > 20 ? true : false;
$dbstate = $lastrow['state'];
$timestamp_c= `cat ramcache/timestamp1`;
$timestamp_l=$lastrow['timestamp'];
$t_c=new DateTime($timestamp_c)->getTimestamp();
$t_l=new DateTime($timestamp_l)->getTimestamp();



if ($state != $dbstate) {
	if (($t_c- $t_l) > 5) {
		insertLog($state,$toilet);
	}else{
		//remove last row
		deleteLog($lastrow['id']);
	}
	$lastrow = selectLastLog($toilet);
	echo $lastrow['timestamp'];
} else {
	echo `cat ramcache/timestamp1`;
}
?>
