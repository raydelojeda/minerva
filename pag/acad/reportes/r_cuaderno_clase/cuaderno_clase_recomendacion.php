<?php
class cuaderno_clase_recomendacion
{
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function pestana_recomendacion($db)
	{
?>
		<div class="tab-page">
			<h2 class="tab">Observaciones</h2>
			<div class="tab-pane" id="tabPane1">		
				<?php				
					$this->filtro_recomendacion($db);
				?>				
				<div style='display:table;width:100%;margin-left:auto;margin-right:auto;' id='div_recomendaciones'>				
					<?php
						//$tihs->contenido_recomendacion($db, '');
					?>
				</div>
			</div>
		</div>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function filtro_recomendacion($db)
	{
		$sql_est="SELECT estudiante.id_estudiante as id_estudiante, 
		concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre,' - ',persona.identificacion) as estudiante, 
		persona.identificacion as ide, persona.fecha_nacimiento as fec, persona.camino_foto as foto 
		FROM estudiante, persona, familiar_estudiante, familiar, persona AS per_fam, usuario 
		WHERE 1 AND estudiante.id_persona=persona.id_persona AND estudiante.id_estudiante=familiar_estudiante.id_estudiante 
		AND familiar.id_familiar=familiar_estudiante.id_familiar AND familiar.id_persona=per_fam.id_persona AND per_fam.id_persona=usuario.id_persona AND usuario='".$_SESSION['user']."'";
		$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
		$rs_est->MoveFirst();
		
		$sql_sub="SELECT n_periodo_lectivo.id_periodo_lectivo AS id_periodo_lectivo, periodo_lectivo,
		n_periodo_evaluativo.id_periodo_evaluativo AS id_periodo_evaluativo, periodo_evaluativo,
		n_subperiodo_evaluativo.id_subperiodo_evaluativo AS id_subperiodo_evaluativo, concat(subperiodo_evaluativo,' (',abv_subperiodo,')') as subperiodo_evaluativo 
		FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica 
		WHERE 1 
		AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo 
		AND n_periodo_lectivo.id_periodo_lectivo=n_periodo_evaluativo.id_periodo_lectivo 
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica 
		AND n_conf_academica.activa='1'";//print $sql_sub;
		$rs_sub=$db->Execute($sql_sub) or die($db->ErrorMsg());
?>
		<div style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
			<div  style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
					
					<div class='tabla_filtro' style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
						<div class='tabla_filtro' style='display:table-row;'>
							<div style='display:table-cell;width:40%;text-align:left;padding:1%;'>
								<?php
									$parametros_extras="onChange=\"ejecutar_ajax('recomendacion/actualizar_datos.php','sel_filtro_recom, sel_filtro_est', 'div_recomendaciones');\"";
									$this->select_filtro_periodos($rs_sub, '', $parametros_extras);
								?>	
							</div>
							<div style='display:table-cell;width:60%;text-align:left;padding:1%;'>
								<?php
									$parametros_extras="onChange=\"ejecutar_ajax('recomendacion/actualizar_datos.php','sel_filtro_recom, sel_filtro_est', 'div_recomendaciones');\"";
									$this->select_filtro_est($rs_est, $parametros_extras);
								?>	
							</div>
							
						</div>
					</div>
					
				</div>
			</div>
		</div>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function select_filtro_periodos($rs_sub, $sel_filtro_recom, $parametros_extras)
	{
		$id_seleccionado=substr($sel_filtro_recom, 2, strlen($sel_filtro_recom));
		$tipo=substr($sel_filtro_recom, 0, 2);
?>
		Observaciones del tutor para el per&iacute;odo: <select name="sel_filtro_recom" class="sel_filtro_recom" title="Filtro" id="sel_filtro_recom" <?php print $parametros_extras;?>>
			<?php
			$id_periodo_lectivo='';
			$id_periodo_evaluativo='';
			$id_subperiodo_evaluativo='';
			
			$rs_sub->MoveFirst();
			for($m=0;$m<$rs_sub->RecordCount();$m++)
			{ 
			?>
				<?php if($id_periodo_lectivo!=$rs_sub->fields['id_periodo_lectivo']){$id_periodo_lectivo=$rs_sub->fields['id_periodo_lectivo'];?>
				<option value="l_<?php print $rs_sub->fields['id_periodo_lectivo']; ?>" <?php if($id_seleccionado!='' AND $tipo=='l_'){if($rs_sub->fields['id_periodo_lectivo']==$id_seleccionado){; ?> selected="selected"<?php }} ?> ><?php print $rs_sub->fields['periodo_lectivo'];?></option>
				<?php }if($id_periodo_evaluativo!=$rs_sub->fields['id_periodo_evaluativo']){$id_periodo_evaluativo=$rs_sub->fields['id_periodo_evaluativo'];?>
				<option value="p_<?php print $rs_sub->fields['id_periodo_evaluativo']; ?>" <?php if($id_seleccionado!='' AND $tipo=='p_'){if($rs_sub->fields['id_periodo_evaluativo']==$id_seleccionado){; ?> selected="selected"<?php }} ?>>&nbsp;&nbsp;&nbsp;<?php print $rs_sub->fields['periodo_evaluativo'];?></option>
				<?php }if($id_subperiodo_evaluativo!=$rs_sub->fields['id_subperiodo_evaluativo']){$id_subperiodo_evaluativo=$rs_sub->fields['id_subperiodo_evaluativo'];?>
				<option value="s_<?php print $rs_sub->fields['id_subperiodo_evaluativo']; ?>" <?php if($id_seleccionado!='' AND $tipo=='s_'){if($rs_sub->fields['id_subperiodo_evaluativo']==$id_seleccionado){; ?> selected="selected"<?php }} ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php print $rs_sub->fields['subperiodo_evaluativo'];?> </option>
				<?php }?>
			<?php 
			$rs_sub->MoveNext();
			} 
			?>
		</select>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function select_filtro_est($rs_est, $parametros_extras)
	{
?>
		<select name="sel_filtro_est" class="sel_filtro_est" title="Filtro" id="sel_filtro_est" <?php print $parametros_extras;?>>
			<?php
			$id_clase_estudiante='';
			?>
			<option value="" >--------------------------------Seleccionar Estudiante------------------------</option>
			<?php
			$rs_est->MoveFirst();
			for($m=0;$m<$rs_est->RecordCount();$m++)
			{ 
			?>
				<option value="<?php print $rs_est->fields['id_estudiante'];?>" <?php if(isset($sel_filtro_est)){if($rs_est->fields['id_estudiante']==$sel_filtro_est){; ?> selected="selected"<?php }} ?> ><?php print $rs_est->fields['estudiante'];?></option>
			<?php 
			$rs_est->MoveNext();
			} 
			?>
		</select>
		<script type="text/javascript" class="js-code-basic">
			$(".sel_filtro_est").select2();
		</script>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function contenido_recomendaciones($db, $x, $sel_filtro_recom, $sel_filtro_est)
	{
		$recomendaciones='';
		$mejoras='';
		
		$tipo=substr($sel_filtro_recom, 0, 2);
		$sel_filtro_recom=substr($sel_filtro_recom, 2, strlen($sel_filtro_recom));
		if($tipo=='l_' AND $sel_filtro_est!='')
		{
			$sql_r="SELECT recomendaciones, mejoras
			FROM recomendaciones_mejoras_lec_tut
			WHERE 1
			AND recomendaciones_mejoras_lec_tut.id_periodo_lectivo='".$sel_filtro_recom."'
			AND recomendaciones_mejoras_lec_tut.id_curso_grado_paralelo_est='".$sel_filtro_est."'";
			$rs_r=$db->Execute($sql_r) or die($db->ErrorMsg());
			
			$sql_lec="SELECT cerrado FROM cierre_periodo_lectivo WHERE 1 AND id_periodo_lectivo='".$sel_filtro_recom."'";//print $sql_nota.'<br>';
			$rs_lec=$db->Execute($sql_lec) or die($db->ErrorMsg());
			$cerrado=$rs_lec->fields['cerrado'];
			
			if(isset($rs_r->fields['recomendaciones']))
			{
				$recomendaciones=$rs_r->fields['recomendaciones'];
				$mejoras=$rs_r->fields['mejoras'];
			}
		}		
		elseif($tipo=='p_' AND $sel_filtro_est!='')
		{
			$sql_r="SELECT recomendaciones, mejoras
			FROM recomendaciones_mejoras_per_tut
			WHERE 1
			AND recomendaciones_mejoras_per_tut.id_periodo_evaluativo='".$sel_filtro_recom."'
			AND recomendaciones_mejoras_per_tut.id_curso_grado_paralelo_est='".$sel_filtro_est."'";
			$rs_r=$db->Execute($sql_r) or die($db->ErrorMsg());
			
			$sql_per="SELECT cerrado FROM cierre_periodo_evaluativo WHERE 1 AND id_periodo_evaluativo='".$sel_filtro_recom."'";//print $sql_nota.'<br>';
			$rs_per=$db->Execute($sql_per) or die($db->ErrorMsg());
			$cerrado=$rs_per->fields['cerrado'];
			
			if(isset($rs_r->fields['recomendaciones']))
			{
				$recomendaciones=$rs_r->fields['recomendaciones'];
				$mejoras=$rs_r->fields['mejoras'];
			}
		}		
		elseif($tipo=='s_' AND $sel_filtro_est!='')
		{
			$sql_r="SELECT recomendaciones, mejoras
			FROM recomendaciones_mejoras_sub_tut
			WHERE 1
			AND recomendaciones_mejoras_sub_tut.id_subperiodo_evaluativo='".$sel_filtro_recom."'
			AND recomendaciones_mejoras_sub_tut.id_curso_grado_paralelo_est='".$sel_filtro_est."'";//print $sql_r.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
			$rs_r=$db->Execute($sql_r) or die($db->ErrorMsg());
			
			$sql_sub="SELECT cerrado FROM cierre_subperiodo_evaluativo WHERE 1 AND id_subperiodo_evaluativo='".$sel_filtro_recom."'";//print $sql_sub.'<br><br>';
			$rs_sub=$db->Execute($sql_sub) or die($db->ErrorMsg());
			$cerrado=$rs_sub->fields['cerrado'];
			
			if(isset($rs_r->fields['recomendaciones']))
			{
				$recomendaciones=$rs_r->fields['recomendaciones'];
				$mejoras=$rs_r->fields['mejoras'];
			}
		}
	?>
			<div style='display:table-row;'>
				<div style='display:table-cell;width:50%;text-align:center;padding:1%;'>				
					<fieldset><legend>Recomendaciones <?php if($sel_filtro_est=='' OR $cerrado=='1'){?><img width='8px' src='../../../../img/acad/cierre_subperiodo_evaluativo/cerrado.png'><?php }?></legend><textarea <?php if($sel_filtro_est=='' OR $cerrado=='1'){?>disabled<?php }?> name='txt_recomendaciones' id='txt_recomendaciones' rows='10' cols='70' readonly><?php print $recomendaciones;?></textarea></fieldset>
				</div>
				
				<div style='display:table-cell;width:50%;text-align:center;padding:1%;'>	
					<fieldset><legend>Mejoras <?php if($sel_filtro_est=='' OR $cerrado=='1'){?><img width='8px' src='../../../../img/acad/cierre_subperiodo_evaluativo/cerrado.png'><?php }?></legend><textarea <?php if($sel_filtro_est=='' OR $cerrado=='1'){?>disabled<?php }?> name='txt_mejoras' id='txt_mejoras' rows='10' cols='70' readonly><?php print $mejoras;?></textarea></fieldset>
				</div>
			</div>
	<?php
		}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
}
?>
