<?php
include 'config.php';

function selectLogById($id)
{
    $rows = array();
    $query = sprintf("SELECT * FROM `log` WHERE `ID` ='%s' LIMIT 1",
        mysql_real_escape_string($id));
    $result = mysql_query($query) or trigger_error(mysql_error());
    while ($row = mysql_fetch_array($result)) {
        foreach ($row AS $key => $value) {
            $row[$key] = stripslashes($value);
        }
        $rows[] = $row;
    }
    return end($rows);
}
function selectAverageDurationByToilet($toilet_id=1)
{
    $rows = array();
    $sql = "SELECT avg(d.duration) as total_duration FROM (
        SELECT (o.`timestamp`-i.`timestamp`) as duration,DATE_FORMAT(i.timestamp,'%y%m%d') as date
        FROM `log` i,`log` o 
        WHERE o.`toilet_id`=i.`toilet_id`
        AND o.state=0
        AND i.toilet_id=".$toilet_id."
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
    return round(end($rows)['total_duration'],0);
}
function selectLastLog($toilet)
{
    $rows = array();

    $sql = sprintf("SELECT * FROM `log` WHERE `toilet_id` = '%s' ",
        mysql_real_escape_string($toilet));
    $result = mysql_query($sql) or trigger_error(mysql_error());
    if (!$result) {
        return $rows;
    }
    while ($row = mysql_fetch_array($result)) {
        foreach ($row AS $key => $value) {
            $row[$key] = stripslashes($value);
        }
        $rows[] = $row;
    }

    return end($rows);
}

function selectAllLogsByState($state)
{
    $rows = array();
    $sql = sprintf("SELECT * FROM `log` WHERE `state` ='%s'",
        mysql_real_escape_string($state));
    $result = mysql_query($sql) or trigger_error(mysql_error());
    while ($row = mysql_fetch_array($result)) {
        foreach ($row AS $key => $value) {
            $row[$key] = stripslashes($value);
        }
        $rows[] = $row;
    }
    return $rows;
}

function selectAllLogs($toilet = null)
{
    $rows = array();
    if($toilet != null){
        $sql = sprintf("SELECT * FROM `log` WHERE `toilet_id` = '%s' ",
            mysql_real_escape_string($toilet));
    }else{
        $sql = sprintf("SELECT * FROM `log` ");
    }   
    $result = mysql_query($sql) or trigger_error(mysql_error());
    if (!$result) {
        return $rows;
    }
    while ($row = mysql_fetch_array($result)) {
        foreach ($row AS $key => $value) {
            $row[$key] = stripslashes($value);
        }
        $rows[] = $row;
    }
    return $rows;
}

?>
