<?php
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($x))$x="../";// (NO TOCAR)

include($x."adodb519/adodb.inc.php");  //adodb library
include($x."coneccion/conn.php"); //conection

// declaraciones
$usuario='';
$rol='';
$mensaje ='';
$modulo ='';
$cadenacheckboxp="";
// declaraciones

if (isset($_SESSION["modulo"]))$modulo = $_SESSION["modulo"];


?>