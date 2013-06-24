<?php
include("fetch.php");
include("insert.php");
$toilet=1;
$lastrow = selectLastLog($toilet);
$brightness = `cat brightness`;
$state = $brightness > 0 ? true : false;
$dbstate = $lastrow['state'];

if ($state != $dbstate) {
    insertLog($state,$toilet);
    $lastrow = selectLastLog($toilet);
    echo $lastrow['timestamp'];
} else {
    echo `cat timestamp`;
}
?>
