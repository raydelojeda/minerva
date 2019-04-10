<?php
$x='../../../../';
//include($x."pag/acad/actividad/variables.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

include("../../clases_acad.php");
$clases_acad = new clases_acad();

if(isset($_POST['campo0']))
{
$id_clase=$_POST['campo0'];
$sel_filtro_cal=$_POST['campo1'];//
$id_asignatura=$_POST['campo2'];
$filas=$_POST['filas'];

$fila = explode(",",$filas);//print $filas;die();
$sel_filtro_cal=substr($sel_filtro_cal, 2, strlen($sel_filtro_cal));

$prom='';$inicial=2;

$sql_p="SELECT id_examen_periodo_eval, examen_eval, abv_tipo_examen_eval, peso
FROM n_examen_periodo_eval, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
WHERE 1
AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
AND n_examen_periodo_eval.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
AND n_periodo_evaluativo.id_periodo_evaluativo='".$sel_filtro_cal."'
AND n_examen_periodo_eval.id_asignatura='".$id_asignatura."'
AND n_conf_academica.activa='1'";//print $sql_p;die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());

$sql_p_adic="SELECT id_exa_adicional_periodo, examen_adicional, abv_examen, tipo_examen, opcional
FROM n_examen_adicional, n_tipo_examen, n_exa_adicional_periodo, n_examen_periodo_eval, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
WHERE 1
AND n_examen_adicional.id_examen_adicional=n_exa_adicional_periodo.id_examen_adicional
AND n_tipo_examen.id_tipo_examen=n_exa_adicional_periodo.id_tipo_examen
AND n_exa_adicional_periodo.id_examen_periodo_eval=n_examen_periodo_eval.id_examen_periodo_eval
AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
AND n_examen_periodo_eval.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
AND n_periodo_evaluativo.id_periodo_evaluativo='".$sel_filtro_cal."'
AND n_examen_periodo_eval.id_asignatura='".$id_asignatura."'
AND n_conf_academica.activa='1' ORDER BY n_exa_adicional_periodo.orden";//print $sql_p_adic;die();//, actividad.fecha
$rs_p_adic=$db->Execute($sql_p_adic) or die($db->ErrorMsg());

$sql_est="SELECT clase_estudiante.id_clase_estudiante
FROM persona AS per_estudiante, estudiante, curso_grado_paralelo_est, clase_estudiante, clase, n_periodo_academico,
empleado_academico, empleado
WHERE 1
AND per_estudiante.id_persona=estudiante.id_persona
AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante
AND curso_grado_paralelo_est.id_curso_grado_paralelo_est=clase_estudiante.id_curso_grado_paralelo_est
AND clase_estudiante.id_clase=clase.id_clase
AND clase.id_periodo_academico=n_periodo_academico.id_periodo_academico
AND clase.id_empleado_academico=empleado_academico.id_empleado_academico 
AND empleado_academico.id_empleado=empleado.id_empleado 
AND n_periodo_academico.activo='1' AND clase.id_clase='".$id_clase."'";//print $sql_est;
$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
}

for($e=0;$e<$rs_est->RecordCount();$e++)
{
	for($c=0;$c<count($fila);$c++)
	{
		if($e==$fila[$c])
		{
			$c=count($fila);
			$id_clase_estudiante=$rs_est->fields['id_clase_estudiante'];	
			
			$promedio_s=$clases_acad->calcular_prom_subperiodos($db, $id_clase_estudiante, $sel_filtro_cal);//die();
			
			//-----------------NOTAS-----------------
			$ini_sub=count($promedio_s['subperiodo_evaluativo'])+$inicial;
			$ini_sub_per=$rs_p->RecordCount()+count($promedio_s['subperiodo_evaluativo'])+$inicial;
			$ini_sub_per_adic=$rs_p_adic->RecordCount()+$rs_p->RecordCount()+count($promedio_s['subperiodo_evaluativo'])+$inicial;
			$rs_p->MoveFirst();			
			
			$suma_peso_p='';$suma_nota_peso_p='';
			
			for($p=$ini_sub;$p<$ini_sub_per;$p++)
			{				
				$sql_nota="SELECT nota, peso FROM nota_examen_periodo_eval, n_examen_periodo_eval
				WHERE nota_examen_periodo_eval.id_examen_periodo_eval=n_examen_periodo_eval.id_examen_periodo_eval 
				AND n_examen_periodo_eval.id_examen_periodo_eval='".$rs_p->fields['id_examen_periodo_eval']."' 
				AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_nota.'<br>';
				$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
				
				if(isset($rs_nota->fields['nota']))
				{
					if($rs_nota->fields['nota']!='')
					{
						$peso=$rs_nota->fields['peso'];					
						$suma_peso_p=bcadd($suma_peso_p, $peso, 14);
						$nota_peso_p=bcmul($rs_nota->fields['nota'], $peso/100, 14);
						$suma_nota_peso_p=bcadd($suma_nota_peso_p, $nota_peso_p, 14);
					}
				}
				
			$rs_p->MoveNext();
			}
			//-----------------NOTAS-----------------
			
			//-----------------PROMEDIO-----------------
			$promedio_p=$clases_acad->calcular_prom_periodo_aux($suma_peso_p, $promedio_s['promedio_p'][0], $suma_nota_peso_p);//die();
			$promedio_periodo=$promedio_p;
			//-----------------PROMEDIO-----------------
			
			//-----------------ADICIONAL-----------------
			//$promedio_periodo=0;
			$rs_p_adic->MoveFirst();
			for($d=$ini_sub_per;$d<$ini_sub_per_adic;$d++)
			{				
				$sql_p_nota_adic="SELECT nota, opcional, publica_nota
				FROM nota_exa_adicional_periodo, n_examen_adicional, n_tipo_examen, n_exa_adicional_periodo, n_examen_periodo_eval, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
				WHERE 1
				AND nota_exa_adicional_periodo.id_exa_adicional_periodo=n_exa_adicional_periodo.id_exa_adicional_periodo
				AND n_examen_adicional.id_examen_adicional=n_exa_adicional_periodo.id_examen_adicional
				AND n_tipo_examen.id_tipo_examen=n_exa_adicional_periodo.id_tipo_examen
				AND n_exa_adicional_periodo.id_examen_periodo_eval=n_examen_periodo_eval.id_examen_periodo_eval
				AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
				AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
				AND n_examen_periodo_eval.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
				AND n_periodo_evaluativo.id_periodo_evaluativo='".$sel_filtro_cal."'
				AND n_examen_periodo_eval.id_asignatura='".$id_asignatura."'
				AND n_exa_adicional_periodo.id_exa_adicional_periodo='".$rs_p_adic->fields['id_exa_adicional_periodo']."'
				AND n_conf_academica.activa='1' 
				AND id_clase_estudiante='".$id_clase_estudiante."'
				ORDER BY n_exa_adicional_periodo.orden";//print $sql_p_adic;die();//, actividad.fecha
				$rs_p_nota_adic=$db->Execute($sql_p_nota_adic) or die($db->ErrorMsg());
				
				if(isset($rs_p_nota_adic->fields['nota']))
				{
					$datos[$e][$d]=number_format(round($rs_p_nota_adic->fields['nota'], 2), 2, ".", "");//print $e.' - '.$a;
					if($rs_p_nota_adic->fields['opcional']==1)
					{
						if($promedio_p>$rs_p_nota_adic->fields['nota'])
						$promedio_periodo=$promedio_p;
						else
						$promedio_periodo=$rs_p_nota_adic->fields['nota'];
					}
					else 
					{
						if($rs_p_nota_adic->fields['publica_nota']==0)
						$promedio_periodo=7;//7 es el aprobado
						else
						$promedio_periodo=$rs_p_nota_adic->fields['nota'];
					}
				}
				else
				$datos[$e][$d]='';
				
			$rs_p_adic->MoveNext();
			}// tipo_examen, opcional
			//-----------------ADICIONAL-----------------
			
			//-----------------PROMEDIO-----------------
			if($promedio_periodo!=0)
			$prom=$promedio_periodo;
			else
			$prom='';
			//-----------------PROMEDIO-----------------
		}	
	}
	
$rs_est->MoveNext();
}
print $prom;
?>