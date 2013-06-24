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
