<?php
//include("../../../../pag/acad/actividad/variables.php");
$x='../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");
if(!isset($obj))$obj = new clases();// (NO TOCAR)

include("../../clases_acad.php");
$clases_acad = new clases_acad();

if(isset($_POST['campo0']))
{
	$id_actividad=substr($_POST['campo3'], 2, strlen($_POST['campo3']));
	
	$sql_act="SELECT nota, observacion
	FROM actividad, nota_actividad_examen
	WHERE 1
	AND actividad.id_actividad=nota_actividad_examen.id_actividad
	AND actividad.id_actividad='".$id_actividad."'";//print $sql_act;//die();
	$rs_act=$db->Execute($sql_act) or die($db->ErrorMsg());
	
	if(!isset($rs_act->fields['nota']) AND !isset($rs_act->fields['observacion']))
	{			
		$sql_tarea = "select id_tarea FROM tarea WHERE 1 AND id_actividad='".$id_actividad."'";//print $sql_tarea;die();
		$rs_tarea=$db->Execute($sql_tarea) or die($db->ErrorMsg());
		
		$id_tarea=$rs_tarea->fields['id_tarea'];
		
		if(isset($id_tarea))
		{
			if($id_tarea!='')
			{
				$sql_tarea_est = "select id_tarea_estudiante FROM tarea_estudiante WHERE 1 AND id_tarea='".$id_tarea."'";
				$rs_tarea_est=$db->Execute($sql_tarea_est) or die($db->ErrorMsg());
				$rs_tarea_est->MoveFirst();
				$id_tarea_estudiante=$rs_tarea_est->fields['id_tarea_estudiante'];
				
				if(isset($id_tarea_estudiante))
				{
					if($id_tarea_estudiante!='')
					{
						for($e=0;$e<$rs_tarea_est->RecordCount();$e++)
						{
							$id_tarea_estudiante=$rs_tarea_est->fields['id_tarea_estudiante'];
							
							$del_sql='DELETE FROM tarea_estudiante WHERE id_tarea_estudiante="'.$id_tarea_estudiante.'"';//print $del_sql;
							$db->Execute($del_sql) or die($db->ErrorMsg());
							
						$rs_tarea_est->MoveNext();
						}
					}
				}
				
				$sql_tarea_adj = "select id_tarea_adjunto FROM tarea_adjunto WHERE 1 AND id_tarea='".$id_tarea."'";
				$rs_tarea_adj=$db->Execute($sql_tarea_adj) or die($db->ErrorMsg());
				$rs_tarea_adj->MoveFirst();
				$id_tarea_adjunto=$rs_tarea_adj->fields['id_tarea_adjunto'];
				
				if(isset($id_tarea_adjunto))
				{
					if($id_tarea_adjunto!='')
					{
						for($e=0;$e<$rs_tarea_adj->RecordCount();$e++)
						{
							$id_tarea_adjunto=$rs_tarea_adj->fields['id_tarea_adjunto'];
							
							$del_sql='DELETE FROM tarea_adjunto WHERE id_tarea_adjunto="'.$id_tarea_adjunto.'"';//print $del_sql;
							$db->Execute($del_sql) or die($db->ErrorMsg());
							
						$rs_tarea_adj->MoveNext();
						}
					}
				}
				
				$carpeta = "../../../../archivos/tareas/".$_SESSION['user']."/".$id_tarea;//print $target_path;
				$directorio_escaneado = scandir($carpeta);
				$archivos = array();
				foreach ($directorio_escaneado as $item)
				{
					if ($item != '.' and $item != '..')
					{
						$archivos[] = $item;
						$target_path = $carpeta."/".$item;//print $target_path;
						chown($target_path,0777);						
						if(file_exists($target_path))
						unlink($target_path);
					}
				}
				rmdir($carpeta);
				
				$del_sql='DELETE FROM tarea WHERE id_actividad="'.$id_actividad.'"';//print $del_sql;
				$db->Execute($del_sql) or die($db->ErrorMsg());
				
				$del_sql='DELETE FROM actividad WHERE id_actividad="'.$id_actividad.'"';//print $del_sql;
				$db->Execute($del_sql) or die($db->ErrorMsg());
				
				$mensaje='Datos eliminados satisfactoriamente.';
				$obj->Imprimir_mensaje($mensaje);				
			}
			else
			{		
				$del_sql='DELETE FROM actividad WHERE id_actividad="'.$id_actividad.'"';//print $del_sql;
				$db->Execute($del_sql) or die($db->ErrorMsg());
				
				$mensaje='Datos eliminados satisfactoriamente.';
				$obj->Imprimir_mensaje($mensaje);
			}
		}
		else
		{		
			$del_sql='DELETE FROM actividad WHERE id_actividad="'.$id_actividad.'"';//print $del_sql;
			$db->Execute($del_sql) or die($db->ErrorMsg());
			
			$mensaje='Datos eliminados satisfactoriamente.';
			$obj->Imprimir_mensaje($mensaje);
		}
	}
	else
	{
		$mensaje='No se puede eliminar la actividad o examen ya que contiene notas y/o comentarios.';
		$obj->Imprimir_mensaje($mensaje);
	}
	$x='../../../';
	$clases_acad->contenido_calificaciones($db, $x, $_POST['campo0'], $_POST['campo1'], $_POST['campo2'], $_POST['campo4']);
}
?>