<?php 
include_once("variables.php");
include_once($x."adodb519/adodb.inc.php");  //adodb library
include_once($x."coneccion/conn.php"); //conection
include_once($x."config/clases.inc.php");
include_once($x.$_POST['camino']."/variables.php");

$obj = new clases();

//$reglas_ok=$obj->Validar_reglas($db,$tabla,$field,$_POST['var_aux']);

//if($reglas_ok=='ok')
$mensaje=$obj->Consulta_eliminar($db,$tabla,$field,$_POST['var_aux']);



include_once("variables.php");
header("Location:".$x.$_POST['camino']."/lis_".$elemento.".php?mensaje=".$mensaje);/**/
?>
