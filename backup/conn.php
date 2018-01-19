<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

if ($_SERVER['REMOTE_ADDR'] == "127.0.0.1"){
	
$usite = "http://www.sspet.com.br/";
	$cfgServerPort 		= "";           // MySQL port - leave blank for default port
	$hostname_conn = "localhost";    // MySQL hostname
	$username_conn = "root";      // MySQL user
	$password_conn = "";   	// MySQL password
	$database_conn = "jbm";     // MySQL database name containing phpSecurePages 
	} else {
	
	$cfgServerPort 		= "";           // MySQL port - leave blank for default port
	$hostname_conn = "localhost";    // MySQL hostname
	$username_conn = "eticus_erp";      // MySQL user
	$password_conn = "129147";   	// MySQL password
	$database_conn = "eticus_erp";     // MySQL database name containing phpSecurePages 
	}

$conn = mysql_pconnect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(),E_USER_ERROR); 


$db = mysql_select_db($database_conn) or trigger_error(mysql_error(),E_USER_ERROR);
?>