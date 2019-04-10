<?php
$x="../";
$ok='';

//session_start();

if(isset($_GET["modulo"])) $modulo = $_GET["modulo"];else $modulo = $_SESSION["modulo"];
$_SESSION["modulo"]=$modulo;//print $modulo;

//if(isset($_SESSION["ok"]) $ok = $_SESSION["ok"];
?>