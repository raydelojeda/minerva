<?php 
//session_save_path($x."temp" );
//session_start();
include_once("variables.php");
include_once($x."config/variables.php");
include_once($x."config/clases.inc.php");
if(isset($_SESSION["id_user"]))
{
	$sql="DELETE FROM sesion WHERE id_usuario='".$_SESSION["id_user"]."'";
	$db->Execute($sql) or die($db->ErrorMsg());
}

$_SESSION["rol"] = '';
$_SESSION["user"] = '';
$_SESSION[] = array();
session_destroy();
$mensaje='';
if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];
//print $mensaje;
//die();
if(isset($mensaje))
{
	if($mensaje!='')echo ("<script language='JavaScript' type='text/javascript'> location.href='autenticacion.php?mensaje=".$mensaje."' </script>");
	else echo ("<script language='JavaScript' type='text/javascript'> location.href='autenticacion.php?mensaje=Ha salido correctamente.' </script>");
}
else
echo ("<script language='JavaScript' type='text/javascript'> location.href='autenticacion.php?mensaje=Ha salido correctamente.' </script>");
?>