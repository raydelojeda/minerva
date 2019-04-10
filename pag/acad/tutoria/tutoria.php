<?php
class tutoria
{
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function contenido_recomendaciones($db, $x, $id_grado, $id_paralelo, $sel_filtro_recom, $sel_filtro_est)
	{
		$recomendaciones='';
		$mejoras='';
		
		$id_gra_par=$id_grado.'_'.$id_paralelo;
		
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
					<fieldset><legend>Recomendaciones <?php if($sel_filtro_est=='' OR $cerrado=='1'){?><img width='8px' src='../../../img/acad/cierre_subperiodo_evaluativo/cerrado.png'><?php }?></legend><textarea <?php if($sel_filtro_est=='' OR $cerrado=='1'){?>disabled<?php }?> name='txt_recomendaciones_<?php print $id_gra_par;?>' id='txt_recomendaciones_<?php print $id_gra_par;?>' rows='10' cols='70' onBlur="ejecutar_ajax('recomendacion/guardar_recomendacion.php','sel_filtro_recom_<?php print $id_gra_par;?>, sel_filtro_est_<?php print $id_gra_par;?>, txt_recomendaciones_<?php print $id_gra_par;?>, txt_mejoras_<?php print $id_gra_par;?>', '');"><?php print $recomendaciones;?></textarea></fieldset>
				</div>
				
				<div style='display:table-cell;width:50%;text-align:center;padding:1%;'>	
					<fieldset><legend>Mejoras <?php if($sel_filtro_est=='' OR $cerrado=='1'){?><img width='8px' src='../../../img/acad/cierre_subperiodo_evaluativo/cerrado.png'><?php }?></legend><textarea <?php if($sel_filtro_est=='' OR $cerrado=='1'){?>disabled<?php }?> name='txt_mejoras_<?php print $id_gra_par;?>' id='txt_mejoras_<?php print $id_gra_par;?>' rows='10' cols='70' onBlur="ejecutar_ajax('recomendacion/guardar_recomendacion.php','sel_filtro_recom_<?php print $id_gra_par;?>, sel_filtro_est_<?php print $id_gra_par;?>, txt_recomendaciones_<?php print $id_gra_par;?>, txt_mejoras_<?php print $id_gra_par;?>', '');"><?php print $mejoras;?></textarea></fieldset>
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
	function filtro_recomendaciones($db, $rs_sub, $id_grado, $id_paralelo, $sel_filtro_recom)
	{
		$sql_est="SELECT estudiante.id_estudiante, id_curso_grado_paralelo_est, retirado, concat(per_estudiante.primer_apellido,' ',per_estudiante.segundo_apellido,' ',per_estudiante.primer_nombre,' ',per_estudiante.segundo_nombre) AS estudiante
		FROM persona AS per_estudiante, estudiante, curso_grado_paralelo_est, n_periodo_academico,
		grado_paralelo_periodo, n_grado_paralelo
		WHERE 1
		AND per_estudiante.id_persona=estudiante.id_persona
		AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante
		
		AND grado_paralelo_periodo.id_grado_paralelo_periodo=curso_grado_paralelo_est.id_grado_paralelo_periodo
		AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico
		AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo
		
		AND retirado='0'
		AND n_periodo_academico.activo='1' AND id_grado='".$id_grado."' AND id_paralelo='".$id_paralelo."'";//print $sql_est;die();
		$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
		
		$id_gra_par=$id_grado.'_'.$id_paralelo;
?>
		<div style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
			<div  style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
					
					<div class='tabla_filtro' style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
						<div class='tabla_filtro' style='display:table-row;'>
							<div style='display:table-cell;width:30%;text-align:left;padding:1%;'>
								<input type="hidden" name="hdn_id_grado_<?php print $id_gra_par;?>" value="<?php print $id_grado;?>">
								<input type="hidden" name="hdn_id_paralelo_<?php print $id_gra_par;?>" value="<?php print $id_paralelo;?>">
								<?php
									$parametros_extras="onChange=\"ejecutar_ajax('recomendacion/actualizar_datos.php','hdn_id_grado_".$id_gra_par.",hdn_id_paralelo_".$id_gra_par.",sel_filtro_recom_".$id_gra_par.", sel_filtro_est_".$id_gra_par."', 'div_recomendaciones_".$id_gra_par."');\"";
									$this->select_filtro_periodos($rs_sub, $sel_filtro_recom, $parametros_extras, $id_grado, $id_paralelo);
								?>	
							</div>
							<div style='display:table-cell;width:70%;text-align:left;padding:1%;'>
								<?php
									$parametros_extras="onChange=\"ejecutar_ajax('recomendacion/actualizar_datos.php','hdn_id_grado_".$id_gra_par.",hdn_id_paralelo_".$id_gra_par.",sel_filtro_recom_".$id_gra_par.", sel_filtro_est_".$id_gra_par."', 'div_recomendaciones_".$id_gra_par."');\"";
									$this->select_filtro_est($rs_est, $parametros_extras, $id_grado, $id_paralelo);
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
	function select_filtro_periodos($rs_sub, $sel_filtro_recom, $parametros_extras, $id_grado, $id_paralelo)
	{
		$id_seleccionado=substr($sel_filtro_recom, 2, strlen($sel_filtro_recom));
		$tipo=substr($sel_filtro_recom, 0, 2);
		$id_gra_par=$id_grado.'_'.$id_paralelo;
?>
		<select name="sel_filtro_recom_<?php print $id_gra_par;?>" class="sel_filtro_recom_<?php print $id_gra_par;?>" title="Filtro" id="sel_filtro_recom_<?php print $id_gra_par;?>" <?php print $parametros_extras;?>>
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
	function select_filtro_est($rs_est, $parametros_extras, $id_grado, $id_paralelo)
	{
		$id_gra_par=$id_grado.'_'.$id_paralelo;
?>
		<select name="sel_filtro_est_<?php print $id_gra_par;?>" class="sel_filtro_est_<?php print $id_gra_par;?>" title="Filtro" id="sel_filtro_est_<?php print $id_gra_par;?>" <?php print $parametros_extras;?>>
			<?php
			$id_clase_estudiante='';
			?>
			<option value="" >--------------------------------Seleccionar Estudiante------------------------</option>
			<?php
			$rs_est->MoveFirst();
			for($m=0;$m<$rs_est->RecordCount();$m++)
			{ 
			?>
				<option value="<?php print $rs_est->fields['id_curso_grado_paralelo_est'];?>" <?php if(isset($sel_filtro_est)){if($rs_est->fields['id_curso_grado_paralelo_est']==$sel_filtro_est){; ?> selected="selected"<?php }} ?> ><?php print $rs_est->fields['estudiante'];if($rs_est->fields['retirado']=='1')print ' (ELIMINADO)'?></option>
			<?php 
			$rs_est->MoveNext();
			} 
			?>
		</select>
		<script type="text/javascript" class="js-code-basic">
			$(".sel_filtro_est_<?php print $id_gra_par;?>").select2();
		</script>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function fecha_literal($fecha)
	{
		$mes=substr($fecha, 5, 2);
		if($mes=='01')$mes_literal='Ene';
		if($mes=='02')$mes_literal='Feb';
		if($mes=='03')$mes_literal='Mar';
		if($mes=='04')$mes_literal='Abr';
		if($mes=='05')$mes_literal='May';
		if($mes=='06')$mes_literal='Jun';
		if($mes=='07')$mes_literal='Jul';
		if($mes=='08')$mes_literal='Ago';
		if($mes=='09')$mes_literal='Sep';
		if($mes=='10')$mes_literal='Oct';
		if($mes=='11')$mes_literal='Nov';
		if($mes=='12')$mes_literal='Dic';
		
		return substr($fecha, 8, 2).'-'.$mes_literal;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function contenido_comportamientos($db, $x, $id_grado, $id_paralelo)
	{
		$varios_arreglos=$this->consulta_est_notas_comp($db, $x, $id_grado, $id_paralelo);
		
		$id_gra_par=$id_grado.'_'.$id_paralelo;//print $id_gra_par; die();
		
		$id_actividad=$varios_arreglos[0]['id_actividad'];
		$actividad=$varios_arreglos[0]['actividad'];
		$descripcion=$varios_arreglos[0]['descripcion'];
		
		$abv=$varios_arreglos[0]['abv'];		
		$datos=$varios_arreglos[0]['datos'];
		$data=$varios_arreglos[0]['data'];//print 'count'.count($id_actividad);
		$column=$varios_arreglos[0]['column'];
		$comment=$varios_arreglos[0]['comment'];
		$cerrado=$varios_arreglos[0]['cerrado'];
		$width=300+count($id_actividad)*40;
				
		$sql_nota="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_academica WHERE activa='1'";//print $sql_nota.'<br>';
		$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
		
		$nota_minima=$rs_nota->fields['nota_minima'];
		$nota_aprobado=$rs_nota->fields['nota_aprobado'];
		$nota_maxima=$rs_nota->fields['nota_maxima'];
?>
			<div style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
				
					<div id="container">
						<div class="columnLayout">
							<div class="rowLayout">
								<div class="descLayout">
									<div class="pad">
										<div id="msg_tut_comp" style='float:right;'></div>
										<div id="grid_tut_comp_<?php print $id_gra_par;?>" style="width: <?php print $width;?>px; height: 50%; overflow: hidden1;"></div>
									</div>
								</div>

								<div class="codeLayout">
									<div class="pad">
										<script>
										var emerg = new Array();//		alert(document.frm.sel_filtro_cal.value.substring(0, 2));
										<?php
											for($c=0;$c<count($id_actividad);$c++)
											{//print count($id_actividad);
												if($c==0)
												{
										?>
													emerg[<?php print $c;?>]='Estudiantes';
										<?php
												}
												elseif($c>=1)
												{
													$emerg='<b>Nombre: </b>'.$abv[$c].': '.$actividad[$c];
										?>
													btn_mod='<a  onMouseOver="return overlib(\'<?php print $emerg;?>\', ABOVE, RIGHT);"onMouseOut="return nd();"><?php print $abv[$c];?></a>';
													
													emerg[<?php print $c;?>]=btn_mod;//alert('<?php print $actividad[$c].$c;?>');
										<?php
												}
											}
										?>
										
										valida_rango = function (value, callback) 
										{
											if(value=='0') 
											{alertify.error('Debe intertar notas entre 0.05 y 10 puntos.');callback(false);}
											else if((value<=<?php print $nota_maxima;?> && parseFloat(value)>=parseFloat(<?php print $nota_minima;?>)) || value==='') 
											{callback(true);}
											else
											{alertify.error('Debe intertar notas entre 0.05 y 10 puntos.');callback(false);}
										};
										
										var inHeadRenderer=function(instance, td, row, col, prop, value, cellProperties)
										{
											Handsontable.NumericCell.renderer.apply(this, arguments);		
											cellProperties.type = 'numeric';
											
											if (parseInt(value, 10) < <?php print $nota_aprobado;?>)
											td.style.color = 'red';
											else
											td.style.color = '#000';
										
											if(!value || value === '') 
											td.style.background = '#eee';
											else
											td.style.background = '';
										};

										var $container = $("#grid_tut_comp_<?php print $id_gra_par;?>"),
										id_msg = document.getElementById('msg_tut_comp'),
										$parent = $container.parent(),
										autosaveNotification,
										tableLoaded=false,
										hot_tut_comp;

										hot_tut_comp_<?php print $id_gra_par;?> = new Handsontable($container[0], 
										{
											data:<?php print json_encode($data);?>,
											maxRows: <?php print count($data);?>,
											rowHeaders: true,
											colHeaders: true,
											minSpareRows: 1,
											comments: false, 
											contextMenu: false,							
										
											fillHandle: 'vertical',											
											fixedColumnsLeft: 1,
	
											colHeaders:['Estudiantes'
											<?php for($c=1;$c<count($id_actividad);$c++){?>,emerg[<?php print $c;?>]<?php }?>
											],
											
											colWidths:[300
											<?php for($c=1;$c<count($id_actividad);$c++){?>, 35 <?php }?>
											],

											columns:[{readOnly: true, className: "htLeft", renderer: "html"}
											,{readOnly: true, className: "htRight", allowInvalid: true}
											<?php for($c=2;$c<count($id_actividad);$c++){print $column[$c];}?>
											],
																				
											cells:function (td, row, col, prop) {
											var cellProperties = {};
											 
											if (col >= 1)
											{
												cellProperties.type = 'numeric',
												cellProperties.format='0,0.00',//validator: valida_rango, allowInvalid: false
												cellProperties.validator = valida_rango,
												cellProperties.renderer = inHeadRenderer;
											}
											
											return cellProperties;
											},

											afterChange: function (change, source) 
											{
												var data, filas='';												
												cambios = String(change).split(",");//alert(change);
												
												if(source != 'loadData' && source != 'celda_promedio')
												{
													change=change+','+document.frm.hdn_id_clase.value;
													change=change+','+document.frm.hdn_cadena_pos_s_comp.value;

													$.ajax(
													{
														url: 'comportamiento/guardar_nota.php',
														data: {changes: change}, // returns all cells' data
														dataType: 'json',
														type: 'POST',
														success: function (res) 
														{
															if (res.result === 'ok')
															{
																id_msg.innerHTML='<img width=24px src="../../../img/general/ajax_loader.gif">';
																setTimeout(function(){id_msg.innerHTML='<img width=24px src="../../../img/general/ok.png">';}, 500);
															}
															else 
															{
																id_msg.innerHTML='<img width=24px src="../../../img/general/error.png">';
																setTimeout(function(){id_msg.innerHTML='';}, 500);
															}
															
															//-------------------------------------------------------------
															for (i=0;i<(cambios.length);i+=4) 
															{
																if(filas=='')
																filas=cambios[0];
																else
																filas=filas+','+cambios[i];
															}
															
															array_filas = String(filas).split(",");			
															ejecutar_ajax('comportamiento/actualizar_grid.php','hdn_id_clase', 'contenido_grid_comportamientos', function(){sel();});
															//-------------------------------------------------------------
														},
														error: function () 
														{
															id_msg.innerHTML='<img width=24px src="../../../img/general/error.png">';
															setTimeout(function(){id_msg.innerHTML='';}, 500);
														}
													});
												}
											},
											
											cell: [<?php print $comment;?>],
											
											afterSetCellMeta: function (row, col, key, val)
											{
												if(tableLoaded)
												{													
													hdn_cadena_pos_s_comp = String(document.frm.hdn_cadena_pos_sub_comp_<?php print $id_gra_par;?> .value).split("-");
													hdn_cadena_cerrado_s_comp = String(document.frm.hdn_cadena_cerrado_s_comp_<?php print $id_gra_par;?> .value).split("-");
													
													for (i=0;i<(hdn_cadena_pos_s_comp.length);i+=1)
													{													
														if(col==hdn_cadena_pos_s_comp[i])
														{
															if(hdn_cadena_cerrado_s_comp[i]==1)
															{
																document.frm.hdn_comment.value=val;
															}
															else
															{
																document.frm.hdn_comment.value=val;
																ejecutar_ajax('comportamiento/guardar_comportamiento_obs.php','hdn_comment,hdn_row_col_comp_<?php print $id_gra_par;?>'+row+'_'+col,'');
															}
														}
													}
												}
											},
											
											afterSelectionEnd: function (e) 
											{
												var selection = hot_tut_comp_<?php print $id_gra_par;?> .getSelected();//alert(selection);
												hdn_cadena_cerrado_s_comp = String(document.frm.hdn_cadena_cerrado_s_comp_<?php print $id_gra_par;?> .value).split("-");
												//alert(document.frm.hdn_cadena_cerrado_s_comp_<?php print $id_gra_par;?> .value);
																					
												if(tableLoaded)
												{	
																								
													hdn_cadena_pos_s_comp = String(document.frm.hdn_cadena_pos_s_comp_<?php print $id_gra_par;?> .value).split("-");
													hdn_cadena_cerrado_s_comp = String(document.frm.hdn_cadena_cerrado_s_comp_<?php print $id_gra_par;?> .value).split("-");
													
													for (i=0;i<(hdn_cadena_pos_s_comp.length);i++)
													{	//alert('i: '+i);		//alert('col: '+selection[1]);									
														if(selection[1]==hdn_cadena_pos_s_comp[i])
														{//alert('cadena: '+hdn_cadena_pos_s_comp[i]);
															if(hdn_cadena_cerrado_s_comp[i]==0)
															{
																if(document.getElementById('hdn_row_col_comp_<?php print $id_gra_par;?>'+selection[0]+'_'+selection[1]))
																ejecutar_ajax('comportamiento/mostrar_obs_comportamiento.php','hdn_row_col_comp_<?php print $id_gra_par;?>'+selection[0]+'_'+selection[1]+', hdn_id_grado_<?php print $id_grado;?>, hdn_id_paralelo_<?php print $id_paralelo;?>','div_comportamiento_<?php print $id_gra_par;?>');
																break;
															}
															else
															div_comportamiento_<?php print $id_gra_par;?> .innerHTML='';
														}
													}
												}											
											}
										});	

										function sel()
										{
											row=parseInt(document.frm.row.value);
											col=parseInt(document.frm.col.value);
											hot_tut_comp.selectCell(row, col);
										}
										
										tableLoaded=true;
										</script>
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
	function consulta_est_notas_comp($db, $x, $id_grado, $id_paralelo)
	{
		include($x."clases_acad.php");
		$clases_acad = new clases_acad();
		
		$id_gra_par=$id_grado.'_'.$id_paralelo;
		?>							
		<input name="hdn_id_grado_<?php print $id_grado;?>" id="hdn_id_grado_<?php print $id_grado;?>" title="hdn_id_grado_<?php print $id_grado;?>" type="hidden" value="<?php print $id_grado;?>"/>
		<input name="hdn_id_paralelo_<?php print $id_paralelo;?>" id="hdn_id_paralelo_<?php print $id_paralelo;?>" title="hdn_id_paralelo_<?php print $id_paralelo;?>" type="hidden" value="<?php print $id_paralelo;?>"/>			
		<?php
		
		$datos[0][0]='0';
		$actividad[0]='Promedio';
		$id_actividad[0]='s_0';$id_actividad[1]='s_0';
		$abv[0]='0';
		$descripcion[0]='Promedio';
		$fecha[0]='0';
		$column='';
		$varios_arreglos[0]='0';
		$comment='';//{row: 0, col: 0, comment: ""}
		$cerrado='';
		$pos=1;
		$cadena_pos_s='';
		$cadena_cerrado_s='';
		
		$suma_nota='';$cant_nota='';$suma_prom='';$cant_prom='';
		
		$sql_l="SELECT id_periodo_lectivo, periodo_lectivo
		FROM n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica		
		AND n_conf_academica.activa='1'";//print $sql_p;die();
		$rs_l=$db->Execute($sql_l) or die($db->ErrorMsg());
		
		for($l=0;$l<$rs_l->RecordCount();$l++)
		{
			$id_actividad[$pos]=$rs_l->fields['id_periodo_lectivo'];
			$actividad[$pos]=$rs_l->fields['periodo_lectivo'];
			$abv[$pos]='A&ntilde;o';
			$column[$pos]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false,readOnly: true}';
			$pos=$pos+1;
				
			$sql_p="SELECT id_periodo_evaluativo, periodo_evaluativo, abv_periodo
			FROM n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
			WHERE 1
			AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
			AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo		
			AND n_conf_academica.activa='1'
			AND n_periodo_evaluativo.id_periodo_lectivo='".$rs_l->fields['id_periodo_lectivo']."'";//print $sql_p;die();
			$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
			
			for($p=0;$p<$rs_p->RecordCount();$p++)
			{
				$id_actividad[$pos]=$rs_p->fields['id_periodo_evaluativo'];
				$actividad[$pos]=$rs_p->fields['periodo_evaluativo'];
				$abv[$pos]=$rs_p->fields['abv_periodo'];
				$column[$pos]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false,readOnly: true, comment: false}';
				$pos=$pos+1;
				
				$sql_s="SELECT id_subperiodo_evaluativo, subperiodo_evaluativo, abv_subperiodo
				FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
				WHERE 1
				AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
				AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
				AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
				AND n_conf_academica.activa='1'
				AND n_subperiodo_evaluativo.id_periodo_evaluativo='".$rs_p->fields['id_periodo_evaluativo']."'";//print $sql_p;die();
				$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
				
				for($s=0;$s<$rs_s->RecordCount();$s++)
				{
					/*$sql_avance="SELECT cerrado FROM cierre_subperiodo_evaluativo WHERE 1 AND id_subperiodo_evaluativo='".$rs_s->fields['id_subperiodo_evaluativo']."'";//print $sql_f;die();
					$rs_avance=$db->Execute($sql_avance) or die($db->ErrorMsg());
					$cerrado=$rs_avance->fields['cerrado'];
					
					for($c=0;$c<$rs_avance->RecordCount();$c++)
					{
						if($rs_avance->fields['cerrado']==1)
						{$cerrado=$rs_avance->fields['cerrado'];break;}
						else
						$cerrado=0;
						
					$rs_avance->MoveNext();
					}
					*/
					$cerrado=0;
					
					$id_actividad[$pos]=$rs_s->fields['id_subperiodo_evaluativo'];
					if($cerrado==1)$actividad[$pos]='El '.$rs_s->fields['subperiodo_evaluativo'].' est&aacute; bloqueado';else $actividad[$pos]=$rs_s->fields['subperiodo_evaluativo'];
					if($cerrado==1)$abv[$pos]=$rs_s->fields['abv_subperiodo'].' <img width=8px src=../../../img/acad/cierre_subperiodo_evaluativo/cerrado.png>';else $abv[$pos]=$rs_s->fields['abv_subperiodo'];
					if($cerrado==1)$column[$pos]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false, readOnly: true}';else $column[$pos]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false, readOnly: true}';
					
					$cadena_cerrado_s=$cadena_cerrado_s.'-'.$cerrado;
					
					if($cadena_pos_s=='')
					$cadena_pos_s=$pos;
					else
					$cadena_pos_s=$cadena_pos_s.'-'.$pos;
						
					$pos=$pos+1;
					
				$rs_s->MoveNext();
				}
			
			$rs_p->MoveNext();
			}
			
		$rs_l->MoveNext();
		}
		
		$sql_est="SELECT estudiante.id_estudiante, id_curso_grado_paralelo_est, curso_grado_paralelo_est.retirado, concat(per_estudiante.primer_apellido,' ',per_estudiante.segundo_apellido,' ',per_estudiante.primer_nombre,' ',per_estudiante.segundo_nombre) AS estudiante
		FROM persona AS per_estudiante, estudiante, curso_grado_paralelo_est, n_periodo_academico, grado_paralelo_periodo, n_grado_paralelo,
		empleado_academico, empleado, persona, usuario 
		WHERE 1
		AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo
		AND per_estudiante.id_persona=estudiante.id_persona
		AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante
		AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo	
		AND grado_paralelo_periodo.id_tutor=empleado_academico.id_empleado_academico 
		AND persona.id_persona=empleado.id_persona 
		AND persona.id_persona=usuario.id_persona
		AND empleado_academico.id_empleado=empleado.id_empleado 
		AND id_paralelo='".$id_paralelo."'
		AND id_grado='".$id_grado."'
		AND n_periodo_academico.activo='1' AND usuario='".$_SESSION['user']."'";//print $sql_est;
		$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
		
		$rs_est->MoveFirst();		
		for($e=0;$e<$rs_est->RecordCount();$e++)
		{
			$familiares=$clases_acad->datos_familiares($db, $rs_est->fields['id_estudiante']);
			$estudiante='<a onMouseOver="return overlib(\''.$familiares.'\', ABOVE, RIGHT);"onMouseOut="return nd();">'.$rs_est->fields['estudiante'].'</a>';
			
			$retirado=$rs_est->fields['retirado'];
			
			if($retirado=='1')
			$datos[$e][0]='<strike style="color:red;">'.$estudiante.'</strike>';
			else 
			$datos[$e][0]=$estudiante;
			
			$id_curso_grado_paralelo_est=$rs_est->fields['id_curso_grado_paralelo_est'];
			
			$rs_l->MoveFirst();$pos=0;
			for($l=0;$l<$rs_l->RecordCount();$l++)
			{
				$pos=$pos+1;
				$pos_l=$pos;
				
				$sql_p="SELECT id_periodo_evaluativo, periodo_evaluativo, abv_periodo
				FROM n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
				WHERE 1
				AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
				AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo		
				AND n_conf_academica.activa='1'
				AND n_periodo_evaluativo.id_periodo_lectivo='".$rs_l->fields['id_periodo_lectivo']."'";//print $sql_p;die();
				$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
				
				for($p=0;$p<$rs_p->RecordCount();$p++)
				{					
					$pos=$pos+1;
					$pos_p=$pos;
					
					$sql_s="SELECT id_subperiodo_evaluativo, subperiodo_evaluativo, abv_subperiodo
					FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
					WHERE 1
					AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
					AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
					AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
					AND n_conf_academica.activa='1'
					AND n_subperiodo_evaluativo.id_periodo_evaluativo='".$rs_p->fields['id_periodo_evaluativo']."' ORDER BY id_subperiodo_evaluativo";//print $sql_p;die();
					$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());

					for($s=0;$s<$rs_s->RecordCount();$s++)
					{	
						$pos=$pos+1;
						$pos_s=$pos;
						
						$id=$rs_est->fields['id_curso_grado_paralelo_est'].'_'.$rs_s->fields['id_subperiodo_evaluativo'];
						$row_col=$e.'_'.$pos_s;
						?>							
						<input name="hdn_row_col_comp_<?php print $id_gra_par; print $row_col;?>" id="hdn_row_col_comp_<?php print $id_gra_par; print $row_col;?>" title="hdn_row_col_comp_<?php print $id_gra_par; print $row_col;?>" type="hidden" value="<?php print $id;?>"/>								
						<?php
						
						$sql_s_n="SELECT nota
						FROM nota_comportamental_sub_tut
						WHERE 1
						AND nota_comportamental_sub_tut.id_subperiodo_evaluativo='".$rs_s->fields['id_subperiodo_evaluativo']."'
						AND nota_comportamental_sub_tut.id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'";//print $sql_s_n.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
						$rs_s_n=$db->Execute($sql_s_n) or die($db->ErrorMsg());
						
						if(isset($rs_s_n->fields['nota']))
						{
							$datos[$e][$pos_s]=$rs_s_n->fields['nota'];
							$suma_nota=$suma_nota+$rs_s_n->fields['nota'];
							$cant_nota=$cant_nota+1;
						}
						else 
						$datos[$e][$pos_s]='';

			
					$rs_s->MoveNext();
					}
					
					if($cant_nota!=0)$prom_per=bcdiv($suma_nota, $cant_nota, 14); else $prom_per='';
					if($prom_per!='')
					{
						$datos[$e][$pos_p]=$prom_per;					
						$suma_prom=$suma_prom+$prom_per;
						$cant_prom=$cant_prom+1;
					}
					$prom_per='';$cant_nota='';$suma_nota='';
				
				$rs_p->MoveNext();
				}
				
				if($cant_prom!=0)$prom_lec=bcdiv($suma_prom, $cant_prom, 14); else $prom_lec='';
				$datos[$e][$pos_l]=$prom_lec;
				$prom_lec='';$cant_prom='';$suma_prom='';

			$rs_l->MoveNext();
			}
		
			$suma_nota='';$cant_nota='';$suma_prom='';$cant_prom='';
		$rs_est->MoveNext();
		}

		for($d=0;$d<count($datos);$d++){$data[$d]=$datos[$d];}
		
		$varios_arreglos=array();
		$varios_arreglos[0]=array('actividad'=>$actividad,'abv'=>$abv,'descripcion'=>$descripcion,'datos'=>$datos,'data'=>$data,'id_actividad'=>$id_actividad,'fecha'=>$fecha,'column'=>$column,'comment'=>$comment,'cerrado'=>$cerrado);//print count($data);

		?>					
			<input name="hdn_cadena_pos_s_comp_<?php print $id_gra_par;?>" id="hdn_cadena_pos_s_comp_<?php print $id_gra_par;?>" type="hidden" value="<?php print $cadena_pos_s;?>"/>
			<input name="hdn_cadena_cerrado_s_comp_<?php print $id_gra_par;?>" id="hdn_cadena_cerrado_s_comp_<?php print $id_gra_par;?>" type="hidden" value="<?php print $cadena_cerrado_s;?>"/>				
		<?php
		
		return $varios_arreglos;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function mostrar_obs_comportamiento($db, $id_curso_grado_paralelo_est, $id_subperiodo_evaluativo, $id_grado, $id_paralelo, $x, $modif)
	{
		$id_gra_par=$id_grado.'_'.$id_paralelo;	
		
		$sql_obs_tut="SELECT id_obs_comportamental_sub_tut, nota_comportamental_sub_tut.id_nota_comportamental_sub_tut, fecha, destacada, positiva, nota_perdida, obs_comportamental_sub_tut.observacion 
		FROM nota_comportamental_sub_tut, obs_comportamental_sub_tut
		WHERE nota_comportamental_sub_tut.id_nota_comportamental_sub_tut=obs_comportamental_sub_tut.id_nota_comportamental_sub_tut
		AND id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."' ORDER BY fecha";//print $sql_obs_tut.'<br>';
		$rs_obs_tut=$db->Execute($sql_obs_tut) or die($db->ErrorMsg());
		
		if($rs_obs_tut->RecordCount()>0)
		{
		?>
		<table class="" width='100%' border='0'>
			<tr>
				<td class="">						
					<div class='tabla_listar' style='display:table;width:100%;'>
					
						<div class="encabezado_col" style='display:table-row;height:22px;'>
							<div style='display:table-cell;width:2%;text-align:left;padding-left:1%;vertical-align:middle;'>
								No
							</div>
							
							<div style='display:table-cell;width:3%;text-align:center;padding-left:1%;vertical-align:middle;'>
								
							</div>
							
							<div style='display:table-cell;width:15%;text-align:left;padding-left:1%;vertical-align:middle;'>
								Fecha
							</div>
							
							<div style='display:table-cell;width:3%;text-align:left;padding-left:1%;vertical-align:middle;'>
								
							</div>
							
							<div style='display:table-cell;width:15%;text-align:left;padding-left:1%;vertical-align:middle;'>
								Nota
							</div>
							
							<div style='display:table-cell;width:59%;text-align:left;padding-left:1%;vertical-align:middle;'>
								Observaci&oacute;n
							</div>
							
							<div style='display:table-cell;width:3%;text-align:left;padding-left:1%;vertical-align:middle;'>
								
							</div>
						</div>
					
					<?php $rs_obs_tut->MoveFirst();for($i=0;$i<$rs_obs_tut->RecordCount();$i++){?>
					
						<input type="hidden" name="hdn_id_obs_comportamental_sub_tut_<?php print $rs_obs_tut->fields['id_obs_comportamental_sub_tut'];?>" value="<?php print $rs_obs_tut->fields['id_obs_comportamental_sub_tut'];?>">
						
						<div <?php if($i % 2) print "class='row1'";else print "class='row0'";?> style='display:table-row;' >
							
							<div style='display:table-cell;text-align:left;padding-left:1%;vertical-align:middle;' <?php if($modif=='1'){?> onClick='document.frm.hdn_modificar_<?php print $id_gra_par;?>.value="1";document.frm.hdn_id_obs_comportamental_sub_tut_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['id_obs_comportamental_sub_tut'];?>";document.frm.rbt_positiva_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['positiva'];?>";document.frm.rbt_destacada_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['destacada'];?>";document.frm.txt_fecha_comp_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['fecha'];?>";document.frm.txt_nota_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['nota_perdida'];?>";document.frm.txt_obs_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['observacion'];?>";'<?php }?>>
								<?php print $i+1;?>
							</div>
							
							<div style='display:table-cell;text-align:center;padding-left:1%;vertical-align:middle;' <?php if($modif=='1'){?> onClick='document.frm.hdn_modificar_<?php print $id_gra_par;?>.value="1";document.frm.hdn_id_obs_comportamental_sub_tut_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['id_obs_comportamental_sub_tut'];?>";document.frm.rbt_positiva_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['positiva'];?>";document.frm.rbt_destacada_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['destacada'];?>";document.frm.txt_fecha_comp_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['fecha'];?>";document.frm.txt_nota_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['nota_perdida'];?>";document.frm.txt_obs_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['observacion'];?>";'<?php }?>>
								<?php 
									if($rs_obs_tut->fields['destacada']==1)print '<img width=13px src="'.$x.'img/general/importante.png">';
								?>
							</div>
							
							<div style='display:table-cell;text-align:left;padding-left:1%;vertical-align:middle;' <?php if($modif=='1'){?> onClick='document.frm.hdn_modificar_<?php print $id_gra_par;?>.value="1";document.frm.hdn_id_obs_comportamental_sub_tut_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['id_obs_comportamental_sub_tut'];?>";document.frm.rbt_positiva_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['positiva'];?>";document.frm.rbt_destacada_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['destacada'];?>";document.frm.txt_fecha_comp_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['fecha'];?>";document.frm.txt_nota_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['nota_perdida'];?>";document.frm.txt_obs_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['observacion'];?>";'<?php }?>>
								<?php print $rs_obs_tut->fields['fecha'];?>
							</div>
							
							<div style='display:table-cell;text-align:left;padding-left:1%;vertical-align:middle;' <?php if($modif=='1'){?> onClick='document.frm.hdn_modificar_<?php print $id_gra_par;?>.value="1";document.frm.hdn_id_obs_comportamental_sub_tut_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['id_obs_comportamental_sub_tut'];?>";document.frm.rbt_positiva_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['positiva'];?>";document.frm.rbt_destacada_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['destacada'];?>";document.frm.txt_fecha_comp_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['fecha'];?>";document.frm.txt_nota_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['nota_perdida'];?>";document.frm.txt_obs_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['observacion'];?>";'<?php }?>>
								<?php 
									if($rs_obs_tut->fields['positiva']==1)print '<img width=20px src="'.$x.'img/general/like.png">';
									elseif($rs_obs_tut->fields['positiva']==0)print '<img width=20px src="'.$x.'img/general/dislike.png">';
								?>
							</div>
							
							<div style='display:table-cell;text-align:center;padding-left:1%;vertical-align:middle;' <?php if($modif=='1'){?> onClick='document.frm.hdn_modificar_<?php print $id_gra_par;?>.value="1";document.frm.hdn_id_obs_comportamental_sub_tut_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['id_obs_comportamental_sub_tut'];?>";document.frm.rbt_positiva_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['positiva'];?>";document.frm.rbt_destacada_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['destacada'];?>";document.frm.txt_fecha_comp_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['fecha'];?>";document.frm.txt_nota_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['nota_perdida'];?>";document.frm.txt_obs_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['observacion'];?>";'<?php }?>>
								<?php print $rs_obs_tut->fields['nota_perdida'];?>
							</div>
							
							<div style='display:table-cell;text-align:left;padding-left:1%;vertical-align:middle;' <?php if($modif=='1'){?> onClick='document.frm.hdn_modificar_<?php print $id_gra_par;?>.value="1";document.frm.hdn_id_obs_comportamental_sub_tut_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['id_obs_comportamental_sub_tut'];?>";document.frm.rbt_positiva_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['positiva'];?>";document.frm.rbt_destacada_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['destacada'];?>";document.frm.txt_fecha_comp_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['fecha'];?>";document.frm.txt_nota_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['nota_perdida'];?>";document.frm.txt_obs_<?php print $id_gra_par;?>.value="<?php print $rs_obs_tut->fields['observacion'];?>";'<?php }?>>
								<?php if($rs_obs_tut->fields['observacion']!='')print $rs_obs_tut->fields['observacion'];else print 'No hay observaci&oacute;n';?>
							</div>
							
							<div style='display:table-cell;text-align:center;vertical-align:middle;'>
								<?php if($modif=='1'){?> 
									<a onClick="document.frm.hdn_modificar_<?php print $id_gra_par;?>.value='0';alertify.confirm('Confirma que desea eliminar la observaci&oacute;n?', function(e){if(e){ejecutar_ajax('comportamiento/actualizar_grid.php','hdn_id_grado_<?php print $id_grado;?>, hdn_id_paralelo_<?php print $id_paralelo;?>', 'contenido_grid_comportamiento_<?php print $id_gra_par;?>', ejecutar_ajax1('comportamiento/eli_obs_comportamiento.php','hdn_id_obs_comportamental_sub_tut_<?php print $rs_obs_tut->fields['id_obs_comportamental_sub_tut'];?>, hdn_id_curso_grado_paralelo_est_<?php print $id_gra_par;?>, hdn_id_subperiodo_evaluativo_<?php print $id_gra_par;?>, hdn_id_gra_<?php print $id_grado;?>, hdn_id_par_<?php print $id_gra_par;?>','div_listado_obs_<?php print $id_gra_par;?>'));}else {alertify.error('Has pulsado ' + alertify.labels.cancel);}limpiar_campos(String('txt_fecha_comp_<?php print $id_gra_par;?>,txt_nota_<?php print $id_gra_par;?>,txt_obs_<?php print $id_gra_par;?>').split(','));});">
										<img width=13px src="<?php print $x;?>img/general/eliminar.png">
									</a>
								<?php }?>
							</div>
						</div>

					<?php $rs_obs_tut->MoveNext();}?>
						
					</div>
				</td>
			</tr>
		</table>
		<?php
		}
		else
		print '<b>No hay observaciones guardadas.</b>';		
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
}
?>
