<?php
include("fetch.php");
include("insert.php");
$toilet=1;
$lastrow = selectLastLog($toilet);
$brightness = `cat ramcache/brightness1`;
$state = $brightness > 0 ? true : false;
$dbstate = $lastrow['state'];

if ($state != $dbstate) {
    insertLog($state,$toilet);
    $lastrow = selectLastLog($toilet);
    echo $lastrow['timestamp'];
} else {
    echo `cat ramcache/timestamp1`;
}
?>
