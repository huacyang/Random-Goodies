<?php

$dbName = 'testDB';

$con = mysql_connect('127.0.0.1', 'root', 'root');
if (!$con) {
    die('Could not connect: '.mysql_error());
}

$database = mysql_select_db($dbName, $con);
if (!$database) {
    die ('Can\'t use '.$dbName.': '.mysql_error());
}

?>