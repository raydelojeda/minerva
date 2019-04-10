<?php
class cuaderno_clase
{
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function devolver_id_subperiodo($db, $id_clase)
	{
		$sql_avance="SELECT id_subperiodo_evaluativo FROM cierre_subperiodo_evaluativo WHERE 1 AND cerrado='0' AND id_clase='".$id_clase."' ORDER BY id_subperiodo_evaluativo";//print $sql_f;die();
		$rs_avance=$db->Execute($sql_avance) or die($db->ErrorMsg());
		$rs_avance->MoveFirst();
		$sel_filtro_asis=$rs_avance->fields['id_subperiodo_evaluativo'];
		
		if($sel_filtro_asis=='')
		{
			$sql_s="SELECT id_subperiodo_evaluativo
			FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
			WHERE 1
			AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
			AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
			AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
			AND n_conf_academica.activa='1' ORDER BY id_subperiodo_evaluativo";//print $sql_s.'<br><br>';//die();
			$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
			
			$rs_s->MoveFirst();		
			$sel_filtro_asis=$rs_s->fields['id_subperiodo_evaluativo'];
		}
		
		return $sel_filtro_asis;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function insertar_periodos_avance($db, $id_clase)
	{	
		$sql_s="SELECT id_subperiodo_evaluativo
		FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
		AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
		AND n_conf_academica.activa='1'";//print $sql_p;die();
		$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
		
		for($s=0;$s<$rs_s->RecordCount();$s++)
		{
			$id_subperiodo_evaluativo=$rs_s->fields['id_subperiodo_evaluativo'];
			
			$sql_i="SELECT cerrado FROM cierre_subperiodo_evaluativo WHERE 1 AND id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_clase='".$id_clase."'";//print $sql_nota.'<br>';
			$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
			
			if(!isset($rs_i->fields['cerrado']))
			{
				$ins_sql='INSERT INTO cierre_subperiodo_evaluativo(id_subperiodo_evaluativo, id_clase, cerrado)
				VALUES("'.$id_subperiodo_evaluativo.'","'.$id_clase.'","0")';//print $ins_sql;die();
				$db->Execute($ins_sql) or die($db->ErrorMsg());
			}
				
		$rs_s->MoveNext();
		}
		
		$sql_p="SELECT id_periodo_evaluativo
		FROM n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo		
		AND n_conf_academica.activa='1'";
		$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
		
		for($p=0;$p<$rs_p->RecordCount();$p++)
		{
			$id_periodo_evaluativo=$rs_p->fields['id_periodo_evaluativo'];
			
			$sql_i="SELECT cerrado FROM cierre_periodo_evaluativo WHERE 1 AND id_periodo_evaluativo='".$id_periodo_evaluativo."' AND id_clase='".$id_clase."'";//print $sql_nota.'<br>';
			$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
			
			if(!isset($rs_i->fields['cerrado']))
			{
				$ins_sql='INSERT INTO cierre_periodo_evaluativo(id_periodo_evaluativo, id_clase, cerrado)
				VALUES("'.$id_periodo_evaluativo.'","'.$id_clase.'","0")';//print $ins_sql;die();
				$db->Execute($ins_sql) or die($db->ErrorMsg());
			}
				
		$rs_p->MoveNext();
		}
		
		$sql_l="SELECT id_periodo_lectivo, periodo_lectivo
		FROM n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica		
		AND n_conf_academica.activa='1'";
		$rs_l=$db->Execute($sql_l) or die($db->ErrorMsg());
		
		for($l=0;$l<$rs_l->RecordCount();$l++)
		{
			$id_periodo_lectivo=$rs_l->fields['id_periodo_lectivo'];
			
			$sql_i="SELECT cerrado FROM cierre_periodo_lectivo WHERE 1 AND id_periodo_lectivo='".$id_periodo_lectivo."' AND id_clase='".$id_clase."'";//print $sql_nota.'<br>';
			$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
			
			if(!isset($rs_i->fields['cerrado']))
			{
				$ins_sql='INSERT INTO cierre_periodo_lectivo(id_periodo_lectivo, id_clase, cerrado)
				VALUES("'.$id_periodo_lectivo.'","'.$id_clase.'","0")';//print $ins_sql;//die();
				$db->Execute($ins_sql) or die($db->ErrorMsg());
			}
				
		$rs_l->MoveNext();
		}
		
		//----------------------------------------------------------------------------------------------------------------------------------------------------
		
		$sel_filtro_cal='';
		
		$sql_l="SELECT id_periodo_lectivo
		FROM n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica		
		AND n_conf_academica.activa='1'";//print $sql_p;die();
		$rs_l=$db->Execute($sql_l) or die($db->ErrorMsg());
		
		for($l=0;$l<$rs_l->RecordCount();$l++)
		{
			$id_periodo_lectivo=$rs_l->fields['id_periodo_lectivo'];
			
			$sql_lec="SELECT cerrado FROM cierre_periodo_lectivo WHERE 1 AND id_periodo_lectivo='".$id_periodo_lectivo."' AND id_clase='".$id_clase."'  ORDER BY id_periodo_lectivo";//print $sql_nota.'<br>';
			$rs_lec=$db->Execute($sql_lec) or die($db->ErrorMsg());
		
			$sql_p="SELECT id_periodo_evaluativo
			FROM n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
			WHERE 1
			AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
			AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo		
			AND n_conf_academica.activa='1'
			AND n_periodo_evaluativo.id_periodo_lectivo='".$rs_l->fields['id_periodo_lectivo']."'";//print $sql_p;die();
			$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
			
			for($p=0;$p<$rs_p->RecordCount();$p++)
			{
				$id_periodo_evaluativo=$rs_p->fields['id_periodo_evaluativo'];
				
				$sql_per="SELECT cerrado FROM cierre_periodo_evaluativo WHERE 1 AND id_periodo_evaluativo='".$id_periodo_evaluativo."' AND id_clase='".$id_clase."' ORDER BY id_periodo_evaluativo";//print $sql_nota.'<br>';
				$rs_per=$db->Execute($sql_per) or die($db->ErrorMsg());
				
				$sql_s="SELECT id_subperiodo_evaluativo
				FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
				WHERE 1
				AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
				AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
				AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
				AND n_conf_academica.activa='1'
				AND n_subperiodo_evaluativo.id_periodo_evaluativo='".$rs_p->fields['id_periodo_evaluativo']."'";//print $sql_s.'<br><br>';//die();
				$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
				
				for($s=0;$s<$rs_s->RecordCount();$s++)
				{
					$id_subperiodo_evaluativo=$rs_s->fields['id_subperiodo_evaluativo'];//print $id_subperiodo_evaluativo;
					
					$sql_sub="SELECT cerrado FROM cierre_subperiodo_evaluativo WHERE 1 AND id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_clase='".$id_clase."' ORDER BY id_subperiodo_evaluativo";//print $sql_sub.'<br><br>';
					$rs_sub=$db->Execute($sql_sub) or die($db->ErrorMsg());
					
					if($rs_sub->fields['cerrado']=='0')
					{
						$sel_filtro_cal='s_'.$id_subperiodo_evaluativo;
						if(substr($sel_filtro_cal, 0, 2)=='s_'){$l=$rs_l->RecordCount();$p=$rs_p->RecordCount();break;}
					}
					
				$rs_s->MoveNext();
				}
				
				if($rs_per->fields['cerrado']=='0')
				{
					if(substr($sel_filtro_cal, 0, 2)!='s_')$sel_filtro_cal='p_'.$id_periodo_evaluativo;
					if(substr($sel_filtro_cal, 0, 2)=='p_'){$l=$rs_l->RecordCount();break;}
				}
				
			$rs_p->MoveNext();
			}

			if($rs_lec->fields['cerrado']=='0')
			{
				if(substr($sel_filtro_cal, 0, 2)!='p_' AND substr($sel_filtro_cal, 0, 2)!='s_')$sel_filtro_cal='l_'.$id_periodo_lectivo;
				if(substr($sel_filtro_cal, 0, 2)=='l_')break;
			}

		$rs_l->MoveNext();
		}
		
		
		if($sel_filtro_cal=='')
		{
		$sql_s="SELECT id_subperiodo_evaluativo
		FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
		AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
		AND n_conf_academica.activa='1' ORDER BY id_subperiodo_evaluativo";//print $sql_s.'<br><br>';//die();
		$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
		
		$rs_s->MoveFirst();		
		$sel_filtro_cal='s_'.$rs_s->fields['id_subperiodo_evaluativo'];
		}
		
		return $sel_filtro_cal;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
		
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function pestana_asistencia($db, $x, $mod, $rs_sub, $rs_asig, $sel_filtro_asis)
	{
?>
		<div class="tab-page">
			<h2 class="tab">Asistencia</h2>
			<div class="tab-pane" id="tabPane1">		
				<?php
					include_once("../clases_acad.php");
					$clases_acad = new clases_acad();				
					
					$this->filtro_asistencia($db, $rs_sub, $sel_filtro_asis, $mod);
				?>				
				<div style='display:table;width:100%;margin-left:auto;margin-right:auto;' id='contenido_grid_asistencias'>				
					<?php	
						$rs_asig->MoveFirst();
						$id_asignatura=$rs_asig->fields['id_asignatura'];
						$clases_acad->contenido_asistencias($db, $x, $mod, $sel_filtro_asis);
					?>
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
	function filtro_asistencia($db, $rs_sub, $sel_filtro_asis, $id_clase)
	{
		$sql_avance="SELECT cerrado, subperiodo_evaluativo FROM cierre_subperiodo_evaluativo, n_subperiodo_evaluativo WHERE 1 AND cierre_subperiodo_evaluativo.id_subperiodo_evaluativo=n_subperiodo_evaluativo.id_subperiodo_evaluativo
		AND n_subperiodo_evaluativo.id_subperiodo_evaluativo='".$sel_filtro_asis."' AND id_clase='".$id_clase."'";//print $sql_f;die();
		$rs_avance=$db->Execute($sql_avance) or die($db->ErrorMsg());
		$rs_avance->MoveFirst();
		$cerrado=$rs_avance->fields['cerrado'];
?>
		<div style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
			<div  style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
					
						<fieldset>
						<legend>Estados de asistencia</legend>
						
						<div style='display:table;width:100%;'>
							<div style='display:table-row;'>
								<div style='display:table-cell;width:100%;height:12px;text-align:left;padding-left:1%;'>
									<?php
										$leyenda='<img width=13px src="../../../img/acad/asistencia/ok.png">&nbsp;Presente&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
										$leyenda=$leyenda.'<img width=13px src="../../../img/acad/asistencia/atraso.png">&nbsp;Atraso&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
										$leyenda=$leyenda.'<img width=13px src="../../../img/acad/asistencia/tarjeta_amarilla.png">&nbsp;Ausencia justificada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
										$leyenda=$leyenda.'<img width=13px src="../../../img/acad/asistencia/tarjeta_roja.png">&nbsp;Ausencia injustificada';									
										print $leyenda;	
									?>
								</div>
							</div>
						</div>
					</fieldset>
					
					<br>
					
					<div class='tabla_filtro' style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
						<div class='tabla_filtro' style='display:table-row;'>
							<div style='display:table-cell;width:72%;text-align:left;padding:1%;'>
								<?php
									$parametros_extras="onChange=\"ejecutar_ajax('asistencia/actualizar_grid.php','hdn_id_clase, sel_filtro_asis', 'contenido_grid_asistencias');ejecutar_ajax1('asistencia/filtrar_subperiodo.php','sel_filtro_asis, hdn_id_clase', 'modal_insertar_asistencia');ejecutar_ajax2('asistencia/ocultar_btn_asis.php','sel_filtro_asis, hdn_id_clase', 'btn_ins_asis');\"";
									$this->select_filtro_asis($rs_sub, $parametros_extras, $sel_filtro_asis);
								?>	
							</div>
							
							<div style='display:table-cell;width:28%;text-align:center;padding:1%;' id='btn_ins_asis'>
							<?php if(isset($sel_filtro_asis) AND $cerrado=='0'){?>
								<a href="#modal_ins_asistencia"><div class="boton" width="100px" height="22px" border="0"> + Insertar asistencia </div></a>
							<?php }
							else
							{
								print 'El '.$rs_avance->fields['subperiodo_evaluativo'].' est&aacute; bloqueado.';
							?>
								<img width="25px" src='<?php print "../../../img/acad/cierre_subperiodo_evaluativo/cerrado.png";?>'>
							<?php }?>
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
	function select_filtro_asis($rs_sub, $parametros_extras, $sel_filtro_asis)
	{
?>
		<select name="sel_filtro_asis" class="sel_filtro_asis" title="Filtro" id="sel_filtro_asis" <?php print $parametros_extras;?>>
			<?php
			$id_periodo_lectivo='';
			$id_periodo_evaluativo='';
			$id_subperiodo_evaluativo='';
			
			$rs_sub->MoveFirst();
			for($m=0;$m<$rs_sub->RecordCount();$m++)
			{ 
				if($id_periodo_evaluativo!=$rs_sub->fields['id_periodo_evaluativo']){$id_periodo_evaluativo=$rs_sub->fields['id_periodo_evaluativo'];?>
				<optgroup label='<?php print $rs_sub->fields['periodo_evaluativo'];?>'>
				<?php }?>
				
					<option value="<?php print $rs_sub->fields['id_subperiodo_evaluativo']; ?>" <?php if(isset($sel_filtro_asis)){if($rs_sub->fields['id_subperiodo_evaluativo']==$sel_filtro_asis){; ?> selected="selected"<?php }} ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php print $rs_sub->fields['subperiodo_evaluativo'];?> </option>
				
				<?php if($id_periodo_evaluativo!=$rs_sub->fields['id_periodo_evaluativo']){$id_periodo_evaluativo=$rs_sub->fields['id_periodo_evaluativo'];?>
				</optgroup>
				<?php }
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
	function pestana_calificacion($db, $x, $mod, $rs_sub, $rs_asig, $sel_filtro_cal)
	{
?>
		<div class="tab-page">
			<h2 class="tab">Calificaciones</h2>
			<div class="tab-pane" id="calificacion">				
				<?php
					include_once("../clases_acad.php");
					$clases_acad = new clases_acad();
					$rs_sub->MoveFirst();
					$rs_asig->MoveFirst();
					$id_asignatura=$rs_asig->fields['id_asignatura'];
					
					$clases_acad->filtro_calificaciones($db, $rs_sub, $sel_filtro_cal, $id_asignatura, $mod);
				?>				
				<div style='display:table;width:100%;margin-left:auto;margin-right:auto;' id='contenido_grid_calificaciones'>				
					<?php
						$clases_acad->contenido_calificaciones($db, $x, $mod, $sel_filtro_cal, $id_asignatura, '');
					?>			
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
	function modal_mod_act1($sel_filtro_cal, $id_asignatura, $id_actividad)
	{
	?>
	<div id="modal_mod_actividad_<?php print $id_actividad;?>" class="modalmask">
		<div class="modalbox movedown">
			<br>
			<div id='modal_modificar_actividad'>
				<?php
				
				/*include("calificacion/var_mod.php");$x='../../../';
				include($x."config/variables.php");
				include($x."coneccion/conn.php"); //conection
				if(!isset($obj))$obj = new clases();
				
				$rs_sesion=$obj->Validar_sesion($db,$x); // (NO TOCAR)
				$obj->Validar_permiso($rs_sesion,$elemento,"Insertar"); // (NO TOCAR)

				include($x."pag/acad/actividad/variables.php");
				
				$combo_sql[$g] = "select id_tipo_actividad as id_tipo, concat(abv_tipo_actividad_examen,' - ',tipo_actividad_examen) as tipo 
				FROM n_tipo_actividad WHERE 1 AND id_asignatura='".$id_asignatura."' AND id_subperiodo_evaluativo='".$sel_filtro_cal."'";//print $combo_sql[$g];//

				$s_rs=$obj->Consulta_llenar_cajas($id_actividad,$insert_field,$tabla,$db,$columna,$insert_alias);
				
				$obj->mini_encabezado_titulo($x,$img_encabezado,$titulo_nuevo,$mini_n_botones,$rs_sesion,$elemento);
				print '<br>';			
				$obj->Generar_inputs($inputs,$s_rs,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li','');
				
				if(isset($_GET['mensaje']))
				$mensaje=$_GET['mensaje'];
				if(isset($return[0]))
				$mensaje=$return[0];
				$obj->Imprimir_mensaje($mensaje);*/
				?>
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
	function pestana_comportamiento($db, $x, $mod, $rs_sub, $rs_asig)
	{
?>
		<div class="tab-page">
			<h2 class="tab">Comportamiento</h2>
			<div class="tab-pane" id="tabPane1">

				<div style='display:table;width:99%;margin:0;'>
					<div style='display:table-row;'>			
						<div style='display:table-cell;width:50%;text-align:center;'>
							
							<div style='display:table;width:100%;margin-left:0;' id='contenido_grid_comportamientos'>				
								<?php
									include_once("../clases_acad.php");
									$clases_acad = new clases_acad();			
									$rs_asig->MoveFirst();
									$id_asignatura=$rs_asig->fields['id_asignatura'];
									$clases_acad->contenido_comportamientos($db, $mod);
								?>
							</div>
						
						</div>
						<div style='display:table-cell;width:49%;text-align:center;'>
							
							<div style='display:table;width:100%;margin-right:0;'>
								<div style='display:table-row;'>			
									<div style='display:table-cell;width:100%;text-align:center;padding:1%;' id='div_comportamiento'>
										
									</div>
								</div>
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
	function pestana_recomendaciones($db, $x, $mod, $rs_sub, $rs_asig, $sel_filtro_recom)
	{
?>
		<div class="tab-page">
			<h2 class="tab">Recomendaciones</h2>
			<div class="tab-pane" id="tabPane1">		
				<?php
				include_once("../clases_acad.php");
				$clases_acad = new clases_acad();
				$clases_acad->filtro_recomendaciones($db, $rs_sub, $mod, $sel_filtro_recom);
				?>				
				<div style='display:table;width:100%;margin-left:auto;margin-right:auto;' id='contenido_recomendacioness'>				
					<?php
						
						$sel_filtro_est='';
						$rs_asig->MoveFirst();
						$id_asignatura=$rs_asig->fields['id_asignatura'];
						$clases_acad->contenido_recomendaciones($db, $x, $mod, $sel_filtro_recom, $sel_filtro_est);
					?>
				</div>
			</div>
		</div>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
}
?>
