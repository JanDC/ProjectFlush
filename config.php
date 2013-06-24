<?php
// Connecting, selecting database
$link = mysql_connect('localhost', 'root', 'pi')
or die('Could not connect: ' . mysql_error());
mysql_select_db('project_flush') or die('Could not select database');
?>