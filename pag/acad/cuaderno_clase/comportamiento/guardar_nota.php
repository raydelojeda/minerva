<?php
$x='../../../../';
include($x."pag/acad/actividad/variables.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['changes']) && $_POST['changes']) 
{//print $_POST['changes'];
	$change = explode(",",$_POST['changes']);//print count($change);die();	
	$i=0;
	$inicial=1;
	$out=array('result'=>'no');
	
	for($r=0;$r<count($change)-3;$r=$r+4)
	{
		$fila[$i]  = $change[$r];//print  'fila: '.$fila[$i];
		$col[$i+$inicial]  = $change[$r+1];//print  '  col: '. $col[$i+$inicial];
		$nuevo_valor[$i] = $change[$r+3];//print  '  nuevo_valor: '.$nuevo_valor;
		
	$i+=1;
	}

	$id_clase = $change[count($change)-2];
	$hdn_cadena_pos_s_comp = $change[count($change)-1];//print $hdn_cadena_pos_s_comp;die();	
	$hdn_cadena_pos_s_comp = explode("-",$hdn_cadena_pos_s_comp);
	
	$sql_est="SELECT clase_estudiante.id_clase_estudiante, concat(per_estudiante.primer_apellido,' ',per_estudiante.segundo_apellido,' ',per_estudiante.primer_nombre,' ',per_estudiante.segundo_nombre) AS estudiante
	FROM persona AS per_estudiante, estudiante, curso_grado_paralelo_est, clase_estudiante, clase, n_periodo_academico,
	empleado_academico, empleado, persona, usuario 
	WHERE 1
	AND per_estudiante.id_persona=estudiante.id_persona
	AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante
	AND curso_grado_paralelo_est.id_curso_grado_paralelo_est=clase_estudiante.id_curso_grado_paralelo_est
	AND clase_estudiante.id_clase=clase.id_clase
	AND clase.id_periodo_academico=n_periodo_academico.id_periodo_academico
	AND clase.id_empleado_academico=empleado_academico.id_empleado_academico 
	AND persona.id_persona=empleado.id_persona 
	AND persona.id_persona=usuario.id_persona
	AND empleado_academico.id_empleado=empleado.id_empleado 
	AND n_periodo_academico.activo='1' AND clase.id_clase='".$id_clase."' AND usuario='".$_SESSION['user']."'";//print $sql_est;
	$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
	
	$sql_s="SELECT id_subperiodo_evaluativo, subperiodo_evaluativo, abv_subperiodo
	FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
	WHERE 1
	AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
	AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
	AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
	AND n_conf_academica.activa='1' ORDER BY id_subperiodo_evaluativo";//print $sql_p;die();
	$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
	
	$rs_est->MoveFirst();		
	for($e=0;$e<$rs_est->RecordCount();$e++)
	{
		$ini_sub=$inicial+$rs_s->RecordCount();
		//$ini_sub_rs=$inicial+$rs_s->RecordCount()+$rs_p->RecordCount();
	
		$rs_s->MoveFirst();
		for($a=0;$a<count($hdn_cadena_pos_s_comp);$a++)
		{
			for($c=0;$c<$i;$c++)
			{
				if($e==$fila[$c] && $hdn_cadena_pos_s_comp[$a]==$col[$c+$inicial])
				{
					if($nuevo_valor[$c]!='')
					{
						//print $rs_s->fields['id_actividad'];die();
						$sql_nota="SELECT nota FROM nota_comportamental_sub WHERE id_subperiodo_evaluativo='".$rs_s->fields['id_subperiodo_evaluativo']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $sql_nota.'<br>';
						$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
						
						if($rs_nota->fields['nota']=='')
						{
							$ins_nota="INSERT INTO nota_comportamental_sub(nota, id_subperiodo_evaluativo, id_clase_estudiante) VALUES('".$nuevo_valor[$c]."','".$rs_s->fields['id_subperiodo_evaluativo']."','".$rs_est->fields['id_clase_estudiante']."')";//print $ins_nota.'<br>';
							$db->Execute($ins_nota) or die($db->ErrorMsg());
							$out = array('result'=>'ok');
						}
						else
						{	
							if($nuevo_valor[$c]!=$rs_nota->fields['nota'])
							{
								$upd_nota="UPDATE nota_comportamental_sub SET nota='".$nuevo_valor[$c]."' WHERE id_subperiodo_evaluativo='".$rs_s->fields['id_subperiodo_evaluativo']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $upd_nota.'<br>';
								$db->Execute($upd_nota) or die($db->ErrorMsg());
								$out = array('result'=>'ok');
							}
						}
					}
					else
					{
						$del_nota="DELETE FROM nota_comportamental_sub WHERE id_subperiodo_evaluativo='".$rs_s->fields['id_subperiodo_evaluativo']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $del_nota.'<br>';
						$db->Execute($del_nota) or die($db->ErrorMsg());
						$out = array('result'=>'ok');
					}
				}
			}
		
		$rs_s->MoveNext();
		}		
	$rs_est->MoveNext();
	}

echo json_encode($out);
}
?>