<?php
include("variables_pasar_curso_estudiantes.php");
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)
$hoy=date('Y-m-d');

$sql_p="select id_periodo_academico as id_periodo_academico, concat(n_periodo_academico.nombre,'  -  ',fecha_ini,'/',fecha_fin) as periodo_academico 
FROM n_periodo_academico ORDER BY fecha_ini";
$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());

if(isset($_POST['sel_per_ant']) && isset($_POST['sel_per_sig']))
{
	if($_POST['sel_per_ant']!=0 && $_POST['sel_per_sig']!=0)
	{
		$sel_per_ant=$_POST['sel_per_ant'];
		$sel_per_sig=$_POST['sel_per_sig'];
		
		$sql_est_ant="SELECT curso_grado_paralelo_est.id_estudiante, id_proximo_grado, grado
		FROM curso_grado_paralelo_est, grado_paralelo_periodo, n_periodo_academico, n_grado_paralelo, n_grado
		WHERE 1
		AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
		AND n_grado_paralelo.id_grado=n_grado.id_grado AND ultimo_grado='0'
		AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
		AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico
		AND n_periodo_academico.id_periodo_academico='".$sel_per_ant."'";//print $sql_est_ant;die();
		$rs_est_ant=$db->Execute($sql_est_ant) or die($db->ErrorMsg());
		
		for($e=0;$e<$rs_est_ant->RecordCount();$e++)//
		{
			$id_estudiante=$rs_est_ant->fields['id_estudiante'];
			$id_proximo_grado=$rs_est_ant->fields['id_proximo_grado'];
			$grado=$rs_est_ant->fields['grado'];
			
			$sql_gra_par_sig="select n_grado_paralelo.id_grado_paralelo, id_tutor, id_inspector, id_psicologo FROM grado_paralelo_periodo, n_grado_paralelo, n_paralelo WHERE 1 AND n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo 
			AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
			AND id_grado='".$id_proximo_grado."' AND paralelo like 'A' AND id_periodo_academico='".$sel_per_ant."'";//print $sql_gra_par.'<br>';
			$rs_gra_par_sig=$db->Execute($sql_gra_par_sig) or die($db->ErrorMsg());
			
			if(isset($rs_gra_par_sig->fields['id_grado_paralelo']))
			{
				$id_grado_paralelo=$rs_gra_par_sig->fields['id_grado_paralelo'];
				$id_tutor=$rs_gra_par_sig->fields['id_tutor'];
				$id_inspector=$rs_gra_par_sig->fields['id_inspector'];
				$id_psicologo=$rs_gra_par_sig->fields['id_psicologo'];
				
				$sql_gra_par_per="select id_grado_paralelo_periodo FROM grado_paralelo_periodo, n_periodo_academico
				WHERE 1 AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico
				AND n_periodo_academico.id_periodo_academico='".$sel_per_sig."' AND id_grado_paralelo='".$id_grado_paralelo."'";//print $sql_gra_par.'<br>';
				$rs_gra_par_per=$db->Execute($sql_gra_par_per) or die($db->ErrorMsg());
				
				if(!isset($rs_gra_par_per->fields['id_grado_paralelo_periodo']))
				{
					$ins_curso="INSERT INTO grado_paralelo_periodo (id_grado_paralelo, id_periodo_academico, id_tutor, id_inspector, id_psicologo, orden) 
					VALUES ('".$id_grado_paralelo."','".$sel_per_sig."','".$id_tutor."','".$id_inspector."','".$id_psicologo."','1')";//print 'ins_curso: '.$ins_curso."<br>";
					$db->Execute($ins_curso) or die($db->ErrorMsg());
					
					$i_sql="SELECT LAST_INSERT_ID() AS myid";
					$rs=$db->Execute($i_sql) or die($db->ErrorMsg());
					
					$id_grado_paralelo_periodo=$rs->fields['myid'];
				}
				else
				$id_grado_paralelo_periodo=$rs_gra_par_per->fields['id_grado_paralelo_periodo'];
					
				$sql_curso="SELECT id_curso_grado_paralelo_est FROM curso_grado_paralelo_est
				WHERE 1 AND id_estudiante='".$id_estudiante."' AND id_grado_paralelo_periodo='".$id_grado_paralelo_periodo."'";//print $sql_gra_par.'<br>';
				$rs_curso=$db->Execute($sql_curso) or die($db->ErrorMsg());
				
				$upd="UPDATE n_periodo_academico SET activo='1' WHERE id_periodo_academico='".$sel_per_sig."'";//print $upd;// die();
				$db->Execute($upd) or die($db->ErrorMsg());
				
				$upd="UPDATE n_periodo_academico SET activo='0' WHERE id_periodo_academico='".$sel_per_ant."'";//print $upd;// die();
				$db->Execute($upd) or die($db->ErrorMsg());
				
				if(!isset($rs_curso->fields['id_curso_grado_paralelo_est']))
				{
					$ins_curso="INSERT INTO curso_grado_paralelo_est (fecha_admision, retirado, cumplido, id_estudiante, id_grado_paralelo_periodo) 
					VALUES ('".$hoy."','0','0','".$id_estudiante."','".$id_grado_paralelo_periodo."')";//print 'ins_curso: '.$ins_curso."<br>";
					$db->Execute($ins_curso) or die($db->ErrorMsg());
					
					$upd="UPDATE curso_grado_paralelo_est SET retirado='1', fecha_retiro='".$hoy."', cumplido='1' WHERE id_estudiante='".$id_estudiante."' AND id_grado_paralelo_periodo='".$id_grado_paralelo_periodo."'";//print $upd; die();
					$db->Execute($upd) or die($db->ErrorMsg());
				}
				else
				$mensaje=$mensaje.'<br>Ya existe el estudiante en el per&iacute;odo siguiente. Debe escoger un per&iacute;odo adecuado.';
			}
			else
			$mensaje=$mensaje.'<br>No hay paralelo A para el grado '.$grado.' para el per&iacute;odo anterior. Debe escoger un per&iacute;odo adecuado.';
			
		$rs_est_ant->MoveNext();
		}
		$obj->Imprimir_mensaje($mensaje);
		$mensaje='';
	}
	/*else
	$mensaje='Debe escoger ambos per&iacute;odos';
	$obj->Imprimir_mensaje($mensaje);
	$mensaje='';*/
}

?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

&nbsp;
<br>

<script language="JavaScript" type="text/javascript">

</script>

			
<div style='display:table;width:100%;'>

	<div style='display:table-row;'>
		<div style='display:table-cell;height:22px;width:25%;text-align:right;'>Per&iacute;odo anterior:</div>
		<div style='display:table-cell;height:22px;text-align:left;'>
			<select name="sel_per_ant" class="sel_per_ant" title="Per&iacute;odo anterior" id="sel_per_ant">
				<option value="no">-------------Escoger per&iacute;odo-------------</option>
				<?php			
				$rs_p->MoveFirst();
				for($p=0;$p<$rs_p->RecordCount();$p++)
				{ 
				?>				
					<option value="<?php print $rs_p->fields['id_periodo_academico'];?>"><?php print $rs_p->fields['periodo_academico'];?></option>
				<?php
				$rs_p->MoveNext();
				} 
				?>
			</select>
		</div>
	</div>

	<div style='display:table-row;'>
		<div style='display:table-cell;height:22px;width:25%;text-align:right;'>Per&iacute;odo siguiente:</div>
		<div style='display:table-cell;height:22px;text-align:left;'>
			<select name="sel_per_sig" class="sel_per_sig" title="Per&iacute;odo siguiente" id="sel_per_sig">
				<option value="no">-------------Escoger per&iacute;odo-------------</option>
				<?php			
				$rs_p->MoveFirst();
				for($p=0;$p<$rs_p->RecordCount();$p++)
				{ 
				?>				
					<option value="<?php print $rs_p->fields['id_periodo_academico'];?>"><?php print $rs_p->fields['periodo_academico'];?></option>
				<?php
				$rs_p->MoveNext();
				} 
				?>
			</select>
		</div>
	</div>

</div>
			


<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/new_footer.php");
?>