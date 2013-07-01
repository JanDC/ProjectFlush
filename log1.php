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
$t_c=strtotime($timestamp_c);
$t_l=strtotime($timestamp_l);

if ($state != $dbstate) {
	if ($t_c- $t_l > 5) {
	insertLog($state,$toilet);
	$lastrow = selectLastLog($toilet);
	echo $lastrow['timestamp'];
	}else{
		//remove last row
		deleteLog($lastrow['id']);
	}
} else {
    echo `cat ramcache/timestamp1`;
}
?>
