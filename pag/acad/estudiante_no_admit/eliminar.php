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
			
			$c_sql= "SELECT id_datos_clinicos FROM datos_clinicos WHERE id_estudiante='".$id."'";//print $d_sql;
			$c_rs=$db->Execute($c_sql);
			
			$id_datos_clinicos=$c_rs->fields['id_datos_clinicos'];
			
			//-----------------------------------------------------FICHA MEDICA-----------------------------------------------------
			
			$d_sql= "DELETE FROM enfermedad_est WHERE id_datos_clinicos='".$id_datos_clinicos."'";//print $d_sql;
			$db->Execute($d_sql) or $mensaje.="Existen datos que dependen de lo que se desea eliminar.<br><br>".$db->ErrorMsg();
			
			$d_sql= "DELETE FROM alergia_est WHERE id_datos_clinicos='".$id_datos_clinicos."'";//print $d_sql;
			$db->Execute($d_sql) or $mensaje.="Existen datos que dependen de lo que se desea eliminar.<br><br>".$db->ErrorMsg();
			
			$d_sql= "DELETE FROM vacuna_est WHERE id_datos_clinicos='".$id_datos_clinicos."'";//print $d_sql;
			$db->Execute($d_sql) or $mensaje.="Existen datos que dependen de lo que se desea eliminar.<br><br>".$db->ErrorMsg();
			
			$d_sql= "DELETE FROM eval_nutricional_est WHERE id_datos_clinicos='".$id_datos_clinicos."'";//print $d_sql;
			$db->Execute($d_sql) or $mensaje.="Existen datos que dependen de lo que se desea eliminar.<br><br>".$db->ErrorMsg();
			
			$d_sql= "DELETE FROM evolucion_est WHERE id_datos_clinicos='".$id_datos_clinicos."'";//print $d_sql;
			$db->Execute($d_sql) or $mensaje.="Existen datos que dependen de lo que se desea eliminar.<br><br>".$db->ErrorMsg();
			
			$d_sql= "DELETE FROM datos_clinicos WHERE id_datos_clinicos='".$id_datos_clinicos."'";//print $d_sql;
			$db->Execute($d_sql) or $mensaje.="Existen datos que dependen de lo que se desea eliminar.<br><br>".$db->ErrorMsg();
			
			//-----------------------------------------------------FICHA MEDICA-----------------------------------------------------
			
			$d_sql= "DELETE FROM familiar_estudiante WHERE id_estudiante='".$id."'";//print $d_sql;
			$db->Execute($d_sql) or $mensaje.="Existen datos que dependen de lo que se desea eliminar.<br><br>".$db->ErrorMsg();
			
			$d_sql= "DELETE FROM direccion_estudiante WHERE id_estudiante='".$id."'";//print $d_sql;
			$db->Execute($d_sql) or $mensaje.="Existen datos que dependen de lo que se desea eliminar.<br><br>".$db->ErrorMsg();
						
			$d_sql= "DELETE FROM ".$tabla." WHERE ".$field[0]."='".$id."'";//print $d_sql;
			$d_rs = $db->Execute($d_sql) or $mensaje.=" Existen datos que dependen de lo que se desea eliminar.<br><br>".$db->ErrorMsg();
		}
	}
}
if(!$mensaje)
$mensaje='Datos eliminados correctamente.';
echo ("<script language='JavaScript' type='text/javascript'> location.href='lis_estudiante_no_admit.php?mensaje=".$mensaje."'</script>");
?>