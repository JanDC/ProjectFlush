<?php

include('config.php');

  $rows = array();
$totals=0;
    $sql = "SELECT sum(state) as visits, DATE_FORMAT(timestamp,'%H') as hour FROM log 
	WHERE DATE_FORMAT(timestamp,'%d%m%y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%d%m%y') and toilet_id = 1 
	GROUP BY DATE_FORMAT(timestamp,'%H')";
    $result = mysql_query($sql) or trigger_error(mysql_error());
    while ($row = mysql_fetch_array($result)) {
        foreach ($row AS $key => $value) {
            $row[$key] = stripslashes($value);
        }
        $rows[] = $row;

    }
echo "Today's stats: Gentlemen<br>";
foreach($rows as $row){
echo "hour: ".$row['hour']." => #visits: ".$row['visits']."<br>";
$totals+=$row['visits'];
}
echo "Total visits: ".$totals;
echo "<hr/>";


$totals=0;

  $rows = array();
    $sql = "SELECT sum(state) as visits, DATE_FORMAT(timestamp,'%H') as hour FROM log 
        WHERE DATE_FORMAT(timestamp,'%d%m%y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%d%m%y') and toilet_id = 0
        GROUP BY DATE_FORMAT(timestamp,'%H')";
    $result = mysql_query($sql) or trigger_error(mysql_error());
    while ($row = mysql_fetch_array($result)) {
        foreach ($row AS $key => $value) {
            $row[$key] = stripslashes($value);
        }
        $rows[] = $row;
    }
echo "Today's stats: Ladies<br>";
foreach($rows as $row){
$totals+=$row['visits'];
echo "hour: ".$row['hour']." => #visits: ".$row['visits']."<br>";
}
echo "Total visits: ".$totals;

