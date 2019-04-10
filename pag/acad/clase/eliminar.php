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
			
			$sql_est="select id_clase_estudiante from clase_estudiante WHERE id_clase='".$id."'";//print $sql_est;
			$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
			
			if(isset($rs_est->fields['id_clase_estudiante']))
			{
				for($l=0;$l<$rs_est->RecordCount();$l++)
				{
					$d_sql= "DELETE FROM clase_estudiante WHERE id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $d_sql;
					$db->Execute($d_sql) or $mensaje=" Existen datos que dependen de lo que se desea eliminar.<br><br>";//.$db->ErrorMsg()
					
				$rs_est->MoveNext();
				}			
			}
			$d_sql= "DELETE FROM cierre_subperiodo_evaluativo WHERE id_clase='".$id."'";//print $d_sql;
			$db->Execute($d_sql) or $mensaje=" Existen datos que dependen de lo que se desea eliminar.<br><br>";//.$db->ErrorMsg()
			
			$d_sql= "DELETE FROM cierre_periodo_evaluativo WHERE id_clase='".$id."'";//print $d_sql;
			$db->Execute($d_sql) or $mensaje=" Existen datos que dependen de lo que se desea eliminar.<br><br>";//.$db->ErrorMsg()
			
			$d_sql= "DELETE FROM cierre_periodo_lectivo WHERE id_clase='".$id."'";//print $d_sql;
			$db->Execute($d_sql) or $mensaje=" Existen datos que dependen de lo que se desea eliminar.<br><br>";//.$db->ErrorMsg()
			
		
			$d_sql= "DELETE FROM clase WHERE id_clase='".$id."'";//print $d_sql;
			$db->Execute($d_sql) or $mensaje=" Existen datos que dependen de lo que se desea eliminar.<br><br>";//.$db->ErrorMsg()

		}
	}
}
if(!$mensaje)
$mensaje=utf8_encode('Clases eliminadas correctamente.');
echo ("<script language='JavaScript' type='text/javascript'> location.href='lis_clase.php?mensaje=".$mensaje."'</script>");
?>