<?php
// Connecting, selecting database
$link = mysql_connect('192.168.1.14', 'pi', 'raspberry')
or die('Could not connect: ' . mysql_error());
mysql_select_db('project_flush') or die('Could not select database');
?>
