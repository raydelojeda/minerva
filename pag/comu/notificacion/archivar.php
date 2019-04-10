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
			
			$sql_p="select persona.id_persona from persona, usuario, recibidos WHERE 1 AND persona.id_persona=usuario.id_persona 
			AND persona.id_persona=recibidos.id_persona_destinatario AND usuario.usuario='".$_SESSION['user']."' AND recibidos.id_recibidos='".$id."'";//print $sql19;
			$rs_p=$db->Execute($sql_p) or print $db->ErrorMsg();
			
			if(isset($rs_p->fields['id_persona']))
			{			
				$d_sql= "UPDATE recibidos SET archivado_dest='1' WHERE id_recibidos='".$id."'";//print $d_sql;die();
				$db->Execute($d_sql) or $db->ErrorMsg();
			}
			else
			{
				$d_sql= "UPDATE recibidos SET archivado_remit='1' WHERE id_recibidos='".$id."'";//print $d_sql;die();
				$db->Execute($d_sql) or $db->ErrorMsg();
			}
		}
	}
}
if(!$mensaje)
$mensaje='Datos archivados correctamente.';
echo ("<script language='JavaScript' type='text/javascript'> location.href='lis_notificacion.php?mensaje=".$mensaje."'</script>");
?>