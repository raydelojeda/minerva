<?php
include("variables.php");
include($x."adodb519/adodb.inc.php");  //adodb library
include($x."coneccion/conn.php"); //conection
include($x."config/clases.inc.php");
include($x.$_POST['camino']."/variables.php");

if(!empty($_POST['var_aux']))// con esto evito el intento de acceder directamente a esta pagina escribiendo su URL en el browser
{
	$mensaje='';
	$var = explode(",",$_POST['var_aux']);		
	
	if(count($var) != 0)
	{
		for ($i = 0; $i < count($var); next($var), $i++) 
		{		
			$id = current($var);//print $id;die();
			
			$d_sql= "DELETE FROM familiar_estudiante WHERE id_estudiante='".$id."'";//print $d_sql;
			$db->Execute($d_sql) or $mensaje.="Existen datos que dependen de lo que se desea eliminar.<br><br>".$db->ErrorMsg();
						
			$d_sql= "DELETE FROM ".$tabla." WHERE ".$field[0]."='".$id."'";//print $d_sql;
			$d_rs = $db->Execute($d_sql) or $mensaje.=" Existen datos que dependen de lo que se desea eliminar.<br><br>".$db->ErrorMsg();
		}
	}
}
if(!$mensaje)
$mensaje='Datos eliminados correctamente.';
echo ("<script language='JavaScript' type='text/javascript'> location.href='lis_familiar.php?mensaje=".$mensaje."'</script>");
?>