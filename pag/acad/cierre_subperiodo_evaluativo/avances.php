<?php
class avances
{
	function contenido_avances($db, $rs_secc)
	{
		for($s=0;$s<$rs_secc->RecordCount();$s++)
		{
			$seccion_academica=$rs_secc->fields['abv_secc'];
			$id_seccion_academica=$rs_secc->fields['id_seccion_academica'];
		?>
			<div class="tab-page">
				<h2 class="tab"><?php print $seccion_academica;?></h2>
				<div class="tab-pane">
					<input name="hdn_id_seccion_academica_<?php print $id_seccion_academica;?>" id="hdn_id_seccion_academica_<?php print $id_seccion_academica;?>" type="hidden" value="<?php print $id_seccion_academica;?>"/>
					<?php
						$this->filtro_avance($db, $id_seccion_academica);
						$this->contenido_avance($db, $id_seccion_academica, '', '');
					?>
				</div>
			</div>
		<?php		
		$rs_secc->MoveNext();
		}
	}
	
	function contenido_avance($db, $id_seccion_academica, $id_grado, $id_paralelo)
	{
		$varios_arreglos=$this->consulta_clases($db, $id_seccion_academica, $id_grado, $id_paralelo);
		
		$id_actividad=$varios_arreglos[0]['id_actividad'];
		$actividad=$varios_arreglos[0]['actividad'];
		$abv=$varios_arreglos[0]['abv'];
		$data=$varios_arreglos[0]['data'];
		$column=$varios_arreglos[0]['column'];
		$cadena_id_clase=$varios_arreglos[0]['cadena_id_clase'];
		?>
			<div style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
				
					<div id="container">
						<div class="columnLayout">
							<div class="rowLayout">
								<div class="descLayout">
									<div class="pad">
										<div id="msg" style='float:right;'></div>
										<div id="grid_<?php print $id_seccion_academica;?>" style="width:100%; height: 50%; overflow: hidden1;">
											<input name="hdn_id_clase_<?php print $id_seccion_academica;?>" id="hdn_id_clase_<?php print $id_seccion_academica;?>" title="hdn_id_clase_<?php print $id_seccion_academica;?>" type="hidden" value="<?php print $cadena_id_clase;?>"/>									
										</div>
									</div>
								</div>

								<div class="codeLayout">
									<div class="pad">
										<script>
											var emerg = new Array();
											<?php
												for($c=0;$c<count($id_actividad);$c++)
												{
													if($c==0)
													{
											?>
														emerg[<?php print $c;?>]='Clases';
											<?php
													}
													elseif($c>=1)
													{
														$emerg='<b>Nombre: </b>'.$abv[$c].': '.$actividad[$c];
											?>
														btn_mod='<a  onclick="marcar_avances(\'<?php print $id_actividad[$c];?>\')" onMouseOver="return overlib(\'<?php print $emerg;?>\', ABOVE, RIGHT);"onMouseOut="return nd();"><?php print $abv[$c];?></a>';
														
														emerg[<?php print $c;?>]=btn_mod;//alert('<?php print $actividad[$c].$c;?>');
											<?php
													}
												}
											?>
											
											var $container = $("#grid_<?php print $id_seccion_academica;?>"),
											id_msg = document.getElementById('msg_asis'),
											$parent = $container.parent(),
											tableLoaded=false,
											hot_avan;

											hot_avan = new Handsontable($container[0], 
											{
												data:<?php print json_encode($data);?>,
												minRows: 5,
												minCols: 5,
												maxRows: <?php print count($data);?>,
												maxCols: 10,
												rowHeaders: true,
												colHeaders: true,
												minSpareRows: 1,
												contextMenu: true,
												comments: true,
												fillHandle: false,
												contextMenu: ['commentsAddEdit'],
												fixedColumnsLeft: 1,
												manualColumnFreeze: true,
												
												colWidths:[800
												<?php for($c=1;$c<count($id_actividad);$c++){?>, 35 <?php }?>
												],
												
												colHeaders:['Estudiantes'
												<?php for($c=1;$c<count($id_actividad);$c++){?>,emerg[<?php print $c;?>]<?php }?>
												],
												
												columns:[{readOnly: true, className: "htLeft"}
												<?php for($c=1;$c<count($id_actividad);$c++){print $column[$c];}?>
												],
												
												afterSetCellMeta: function (row, col, key, val)
												{
													if(tableLoaded)
													{
														document.frm.hdn_comment.value=val;
														ejecutar_ajax('asistencia/guardar_inasistencia_obs.php','hdn_comment, hdn_row_col_asis'+row+'_'+col,'');
													}
												},
											});	
											
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
	
	function filtro_avance($db, $id_seccion_academica)
	{
		?>
		<div style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
			<div  style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
					
					<div class='tabla_filtro' style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
						<div class='tabla_filtro' style='display:table-row;'>
							<div style='display:table-cell;width:30%;text-align:left;padding:1%;'>
								<?php
									$callback="ejecutar_ajax1('reset_filtro_par.php','sel_filtro_gra_".$id_seccion_academica.", hdn_id_seccion_academica_".$id_seccion_academica."', 'filtro_par_".$id_seccion_academica."')";
									$parametros_extras="onChange=\"ejecutar_ajax('filtrar_grado_paralelo.php','hdn_id_seccion_academica_".$id_seccion_academica.", sel_filtro_gra_".$id_seccion_academica."', 'grid_".$id_seccion_academica."', ".$callback.");\"";
									$this->select_filtro_grados($db, $id_seccion_academica, '', $parametros_extras);
								?>	
							</div>
							<div style='display:table-cell;width:70%;text-align:left;padding:1%;' id='filtro_par_<?php print $id_seccion_academica;?>'>
								<?php
									
								?>	
							</div>
							
						</div>
					</div>
					
				</div>
			</div>
		</div>
	<?php
	}
	
	function select_filtro_grados($db, $id_seccion_academica, $sel_filtro_gra, $parametros_extras)
	{
		$sql_gra="select DISTINCT n_grado.id_grado, grado FROM n_grado, n_grado_paralelo, grado_paralelo_periodo , curso_grado_paralelo_est, n_periodo_academico, n_seccion_academica
		where n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo AND n_grado_paralelo.id_grado=n_grado.id_grado
		AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo 
		AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico AND n_periodo_academico.activo='1' 
		AND n_seccion_academica.id_seccion_academica=n_grado.id_seccion_academica AND n_seccion_academica.id_seccion_academica='".$id_seccion_academica."' ORDER BY grado_paralelo_periodo.orden";
		$rs_gra=$db->Execute($sql_gra) or die($db->ErrorMsg());
	?>
		<select name="sel_filtro_gra_<?php print $id_seccion_academica;?>" id="sel_filtro_gra_<?php print $id_seccion_academica;?>" <?php print $parametros_extras;?>>
			<option value="">------Grado------</option>
			<?php for($g=0;$g<$rs_gra->RecordCount();$g++){?>
			
				<option value="<?php print $rs_gra->fields['id_grado'];?>" <?php if(isset($sel_filtro_gra)){if($rs_gra->fields['id_grado']==$sel_filtro_gra){?> selected="selected"<?php }}?> > <?php print $rs_gra->fields['grado'];?> </option>
				
			<?php $rs_gra->MoveNext();}?>
		</select>
	<?php
	}
	
	function select_filtro_paralelos($db, $id_grado, $parametros_extras)
	{
		$sql_par="select DISTINCT n_paralelo.id_paralelo, abreviatura from n_paralelo, n_grado_paralelo, grado_paralelo_periodo,curso_grado_paralelo_est, n_periodo_academico 
		where n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
		AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
		AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico AND n_periodo_academico.activo='1' 
		AND n_grado_paralelo.id_grado='".$id_grado."' ORDER BY orden";//print $sql_par;
		$rs_par=$db->Execute($sql_par) or die($db->ErrorMsg());
	?>
		<select name="sel_filtro_par_<?php print $id_grado;?>" id="sel_filtro_par<?php print $id_grado;?>" <?php print $parametros_extras;?>>
			<option value="">---Paralelo---</option>
			<?php for($g=0;$g<$rs_par->RecordCount();$g++){?>
			
				<option value="<?php print $rs_par->fields['id_paralelo'];?>"> <?php print $rs_par->fields['abreviatura'];?> </option>
				
			<?php $rs_par->MoveNext();}?>
		</select>
	<?php
	}
	
	function consulta_clases($db, $id_seccion_academica, $id_grado, $id_paralelo)
	{
		$datos[0][0]='No hay clases con estudiantes del grado o paralelo seleccionado.';
		$actividad[0]='';
		$id_actividad[0]='';
		$abv[0]='';
		$column='';
		$varios_arreglos[0]='';
		$pos=1;
		
		$sql_l="SELECT id_periodo_lectivo, periodo_lectivo
		FROM n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica		
		AND n_conf_academica.activa='1'";//print $sql_p;die();
		$rs_l=$db->Execute($sql_l) or die($db->ErrorMsg());
		
		for($l=0;$l<$rs_l->RecordCount();$l++)
		{
			$id_actividad[$pos]='l_'.$id_seccion_academica.'_'.$rs_l->fields['id_periodo_lectivo'];
			$actividad[$pos]=$rs_l->fields['periodo_lectivo'];
			$abv[$pos]='A&ntilde;o';
			$column[$pos]=',{className: "htRight"}';
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
				$id_actividad[$pos]='p_'.$id_seccion_academica.'_'.$rs_p->fields['id_periodo_evaluativo'];
				$actividad[$pos]=$rs_p->fields['periodo_evaluativo'];
				$abv[$pos]=$rs_p->fields['abv_periodo'];
				$column[$pos]=',{className: "htRight"}';
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
					$id_actividad[$pos]='s_'.$id_seccion_academica.'_'.$rs_s->fields['id_subperiodo_evaluativo'];
					$actividad[$pos]=$rs_s->fields['subperiodo_evaluativo'];
					$abv[$pos]=$rs_s->fields['abv_subperiodo'];
					$column[$pos]=',{className: "htRight"}';
					
						/*if($cadena_pos_s=='')
						$cadena_pos_s=$pos;
						else
						$cadena_pos_s=$cadena_pos_s.'-'.$pos;*/
						
					$pos=$pos+1;
					
				$rs_s->MoveNext();
				}
			
			$rs_p->MoveNext();
			}
			
		$rs_l->MoveNext();
		}
		
		$cadena_id_clase='';
		
		$sql_c="SELECT DISTINCT clase.nombre, referencia, codigo, clase.id_clase
		FROM clase, clase_estudiante, curso_grado_paralelo_est, grado_paralelo_periodo, n_grado_paralelo, n_periodo_academico, n_grado, n_seccion_academica
		WHERE 1 
		AND clase.id_clase=clase_estudiante.id_clase
		AND clase_estudiante.id_curso_grado_paralelo_est=curso_grado_paralelo_est.id_curso_grado_paralelo_est
		AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo			
		AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo 
		AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico
		AND n_grado_paralelo.id_grado=n_grado.id_grado 
		AND n_seccion_academica.id_seccion_academica=n_grado.id_seccion_academica
		AND n_periodo_academico.activo='1'
		AND n_seccion_academica.id_seccion_academica='".$id_seccion_academica."'";
		
		if($id_grado!='')$sql_c=$sql_c." AND n_grado.id_grado='".$id_grado."'";
		if($id_paralelo!='')$sql_c=$sql_c." AND n_grado_paralelo.id_paralelo='".$id_paralelo."'";
		
		$sql_c=$sql_c." ORDER BY clase.nombre";//print $sql_c;
		$rs_c=$db->Execute($sql_c) or die($db->ErrorMsg());
		
		$rs_c->MoveFirst();		
		for($e=0;$e<$rs_c->RecordCount();$e++)
		{
			$datos[$e][0]=$rs_c->fields['referencia'].' ('.$rs_c->fields['codigo'].')';			
			$id_clase=$rs_c->fields['id_clase'];
			
			if($cadena_id_clase=='')$cadena_id_clase=$id_clase;else $cadena_id_clase=$cadena_id_clase.','.$id_clase;
			
			$rs_l->MoveFirst();$pos=0;
			for($l=0;$l<$rs_l->RecordCount();$l++)
			{
				$pos=$pos+1;
				$pos_l=$pos;
				
				$id='l_'.$id_seccion_academica.'_'.$rs_l->fields['id_periodo_lectivo'].'_'.$rs_c->fields['id_clase'];
				$row_col=$e.'_'.$pos_l;
				?>
				<input name="hdn_celda_<?php print $id;?>" id="hdn_celda_<?php print $id;?>" type="hidden" value="<?php print $id;?>"/>
				<input name="hdn_row_col_avan_<?php print $row_col;?>" id="hdn_row_col_avan_<?php print $row_col;?>" title="hdn_row_col_avan_<?php print $row_col;?>" type="hidden" value="<?php print $id;?>"/>								
				<?php
				
				$sql_l_avan="SELECT cerrado
				FROM cierre_periodo_lectivo
				WHERE 1
				AND id_periodo_lectivo='".$rs_l->fields['id_periodo_lectivo']."'
				AND id_clase='".$id_clase."'";//print $sql_s_n.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
				$rs_l_avan=$db->Execute($sql_l_avan) or die($db->ErrorMsg());
				
				if(isset($rs_l_avan->fields['cerrado']))
				{
					if($rs_l_avan->fields['cerrado']==0)
					{
						$datos[$e][$pos_l]='<a onclick="cambiar_avance(\''.$id.'\')"><img id="'.$id.'" width=10px src="../../../img/acad/cierre_subperiodo_evaluativo/abierto.png"></a>';
					}
					elseif($rs_l_avan->fields['cerrado']==1)
					{
						$datos[$e][$pos_l]='<a onclick="cambiar_avance(\''.$id.'\')"><img id="'.$id.'" width=10px src="../../../img/acad/cierre_subperiodo_evaluativo/cerrado.png"></a>';
					}
				}
				else 
				$datos[$e][$pos_l]='<a onclick="cambiar_avance(\''.$id.'\')"><img id="'.$id.'" width=10px src="../../../img/acad/cierre_subperiodo_evaluativo/abierto.png"></a>';
				
				$column[$pos_l]=',{renderer: "html", readOnly: true}';
				
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
					
					$id='p_'.$id_seccion_academica.'_'.$rs_p->fields['id_periodo_evaluativo'].'_'.$rs_c->fields['id_clase'];
					$row_col=$e.'_'.$pos_p;
					?>
					<input name="hdn_celda_<?php print $id;?>" id="hdn_celda_<?php print $id;?>" type="hidden" value="<?php print $id;?>"/>
					<input name="hdn_row_col_avan_<?php print $row_col;?>" id="hdn_row_col_avan_<?php print $row_col;?>" title="hdn_row_col_avan_<?php print $row_col;?>" type="hidden" value="<?php print $id;?>"/>								
					<?php
					
					$sql_p_avan="SELECT cerrado
					FROM cierre_periodo_evaluativo
					WHERE 1
					AND id_periodo_evaluativo='".$rs_p->fields['id_periodo_evaluativo']."'
					AND id_clase='".$id_clase."'";//print $sql_s_n.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
					$rs_p_avan=$db->Execute($sql_p_avan) or die($db->ErrorMsg());
					
					if(isset($rs_p_avan->fields['cerrado']))
					{
						if($rs_p_avan->fields['cerrado']==0)//presente
						{
							$datos[$e][$pos_p]='<a onclick="cambiar_avance(\''.$id.'\')"><img id="'.$id.'" width=10px src="../../../img/acad/cierre_subperiodo_evaluativo/abierto.png"></a>';
						}
						elseif($rs_p_avan->fields['cerrado']==1)//atraso
						{
							$datos[$e][$pos_p]='<a onclick="cambiar_avance(\''.$id.'\')"><img id="'.$id.'" width=10px src="../../../img/acad/cierre_subperiodo_evaluativo/cerrado.png"></a>';
						}
					}
					else 
					$datos[$e][$pos_p]='<a onclick="cambiar_avance(\''.$id.'\')"><img id="'.$id.'" width=10px src="../../../img/acad/cierre_subperiodo_evaluativo/abierto.png"></a>';
					
					$column[$pos_p]=',{renderer: "html", readOnly: true}';
					
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
						
						$id='s_'.$id_seccion_academica.'_'.$rs_s->fields['id_subperiodo_evaluativo'].'_'.$rs_c->fields['id_clase'];
						$row_col=$e.'_'.$pos_s;
						?>
						<input name="hdn_celda_<?php print $id;?>" id="hdn_celda_<?php print $id;?>" type="hidden" value="<?php print $id;?>"/>
						<input name="hdn_row_col_avan_<?php print $row_col;?>" id="hdn_row_col_avan_<?php print $row_col;?>" title="hdn_row_col_avan_<?php print $row_col;?>" type="hidden" value="<?php print $id;?>"/>								
						<?php
						
						$sql_s_avan="SELECT cerrado
						FROM cierre_subperiodo_evaluativo
						WHERE 1
						AND id_subperiodo_evaluativo='".$rs_s->fields['id_subperiodo_evaluativo']."'
						AND id_clase='".$id_clase."'";
						$rs_s_avan=$db->Execute($sql_s_avan) or die($db->ErrorMsg());
						
						if(isset($rs_s_avan->fields['cerrado']))
						{
							if($rs_s_avan->fields['cerrado']==0)//presente
							{
								$datos[$e][$pos_s]='<a onclick="cambiar_avance(\''.$id.'\')"><img id="'.$id.'" width=10px src="../../../img/acad/cierre_subperiodo_evaluativo/abierto.png"></a>';
							}
							elseif($rs_s_avan->fields['cerrado']==1)//atraso
							{
								$datos[$e][$pos_s]='<a onclick="cambiar_avance(\''.$id.'\')"><img id="'.$id.'" width=10px src="../../../img/acad/cierre_subperiodo_evaluativo/cerrado.png"></a>';
							}
						}
						else 
						$datos[$e][$pos_s]='<a onclick="cambiar_avance(\''.$id.'\')"><img id="'.$id.'" width=10px src="../../../img/acad/cierre_subperiodo_evaluativo/abierto.png"></a>';
						
						$column[$pos_s]=',{renderer: "html", readOnly: true}';
						
						
					$rs_s->MoveNext();
					}				
				$rs_p->MoveNext();
				}
			$rs_l->MoveNext();
			}
		$rs_c->MoveNext();
		}
		
		?>
		
		<?php
		
		for($d=0;$d<count($datos);$d++){$data[$d]=$datos[$d];}
		
		$varios_arreglos=array();
		$varios_arreglos[0]=array('actividad'=>$actividad,'abv'=>$abv,'datos'=>$datos,'data'=>$data,'id_actividad'=>$id_actividad,'column'=>$column,'cadena_id_clase'=>$cadena_id_clase);//print count($data);

		return $varios_arreglos;
		
	}
}
?>