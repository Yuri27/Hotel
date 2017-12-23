<?php
//$db=mysql_connect('sql7.freesqldatabase.com','sql7147759','Va5WQSjBCE') 
$db=mysql_connect('localhost','root','0202') or die('Не подключено к серверу');
mysql_select_db('sql7147759');
mysql_query("SET NAMES 'utf8'");
session_start();
?>