<?php
	//session_start();
	//include ('../adodb519/adodb.inc.php');
	$server="localhost";
	$user="root";
	$pwd="130865";
	$bd="minerva";
	$db = NewADOConnection('mysqli');
	$db->Connect($server, $user, $pwd, $bd) or die($db->ErrorMsg());
	//$db->debug=true;
?>
