<?php

include('config.php');

$rows = array();
$sql = "SELECT avg(d.duration) as total_duration FROM (
    SELECT (o.`timestamp`-i.`timestamp`) as duration,DATE_FORMAT(i.timestamp,'%y%m%d') as date
    FROM `log` i,`log` o 
    WHERE o.`toilet_id`=i.`toilet_id`
    AND o.state=0
    AND i.toilet_id=1
    AND i.state=1
    AND o.`timestamp` > i.`timestamp`
    GROUP BY i.id) as d
GROUP BY d.date";
$result = mysql_query($sql) or trigger_error(mysql_error());
while ($row = mysql_fetch_array($result)) {
    foreach ($row AS $key => $value) {
        $row[$key] = stripslashes($value);
    }
    $rows[] = $row;
}
foreach($rows as $row){
    $men=$row['total_duration'];
}

$rows = array();
$sql = "SELECT avg(d.duration) as total_duration FROM (
    SELECT (o.`timestamp`-i.`timestamp`) as duration,DATE_FORMAT(i.timestamp,'%y%m%d') as date
    FROM `log` i,`log` o 
    WHERE o.`toilet_id`=i.`toilet_id`
    AND o.state=0
    AND i.toilet_id=0
    AND i.state=1
    AND o.`timestamp` > i.`timestamp`
    GROUP BY i.id) as d
GROUP BY d.date";
$result = mysql_query($sql) or trigger_error(mysql_error());
while ($row = mysql_fetch_array($result)) {
    foreach ($row AS $key => $value) {
        $row[$key] = stripslashes($value);
    }
    $rows[] = $row;
}
foreach($rows as $row){
    $women=$row['total_duration'];
}

echo "<h1>Estimated time to release:</h1>";
echo "Men: ".$men."s<br>";
echo "Women: ".$women."s";