<?php
	//session_start();
	//include ('../adodb519/adodb.inc.php');
	$server="localhost";
	$user="";
	$pwd="";
	$bd="minerva";
	$db = NewADOConnection('mysqli');
	$db->Connect($server, $user, $pwd, $bd) or die($db->ErrorMsg());
	//$db->debug=true;
?>
