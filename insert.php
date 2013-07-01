<?php
include 'config.php';

function insertLog($state,$toilet=1)
{
    $query = sprintf("INSERT INTO  `log` (`state`,`toilet_id`)VALUES ('%s','%s');",
        mysql_real_escape_string($state),$toilet);
    $result = mysql_query($query) or trigger_error(mysql_error());

}
function deleteLog($id)
{
    $query = sprintf("DELETE FROM `log` WHERE id = %s",
        $id);
    $result = mysql_query($query) or trigger_error(mysql_error());

}

?>
