<?php
class cuaderno_clase_calificacion
{
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function pestana_calificacion($db)
	{
?>
		<div class="tab-page">
			<h2 class="tab">Calificaciones</h2>
			<div class="tab-pane" id="tabPane1">		
				<?php				
					$this->filtro_calificacion($db);
				?>				
				<div style='display:table;width:100%;margin-left:auto;margin-right:auto;' id='contenido_grid_calificaciones'>				
					<?php
						//$tihs->contenido_calificaciones($db, '');
					?>
				</div>
			</div>
		</div>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function filtro_calificacion($db)
	{
		$sql_est="SELECT estudiante.id_estudiante as id_estudiante, 
		concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre,' - ',persona.identificacion) as estudiante, 
		persona.identificacion as ide, persona.fecha_nacimiento as fec, persona.camino_foto as foto 
		FROM estudiante, persona, familiar_estudiante, familiar, persona AS per_fam, usuario 
		WHERE 1 AND estudiante.id_persona=persona.id_persona AND estudiante.id_estudiante=familiar_estudiante.id_estudiante 
		AND familiar.id_familiar=familiar_estudiante.id_familiar AND familiar.id_persona=per_fam.id_persona AND per_fam.id_persona=usuario.id_persona AND usuario='".$_SESSION['user']."'";
		$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
		$rs_est->MoveFirst();
?>
		<div style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
			<div  style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
					
					<div class='tabla_filtro' style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
						<div class='tabla_filtro' style='display:table-row;'>
							<div style='display:table-cell;width:72%;text-align:left;padding:1%;'>
								<?php
									$parametros_extras="onChange=\"ejecutar_ajax('calificacion/actualizar_grid.php', 'sel_filtro_cal', 'contenido_grid_calificaciones');\"";
									$this->select_filtro_cal($parametros_extras, $rs_est);
									$msg_asis='Ud. puede dar clic en la nota de cada parcial y clase para ver el detalle de calificaciones.';
								?>
								&nbsp;<a onMouseOver="return overlib('<?php print $msg_asis;?>', ABOVE, RIGHT);"onMouseOut="return nd();"><img src='../../../../img/general/help.png'></a>
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
	function select_filtro_cal($parametros_extras, $rs_est)
	{
?>
		Calificaciones del estudiante: <select name="sel_filtro_cal" class="sel_filtro_cal" title="Filtro" id="sel_filtro_cal" <?php print $parametros_extras;?>>
			<option value="0">-----------------Escoger estudiante------------------------</option>
			<?php			
			$rs_est->MoveFirst();
			for($m=0;$m<$rs_est->RecordCount();$m++)
			{ 
			?>				
				<option value="<?php print $rs_est->fields['id_estudiante'];?>"><?php print $rs_est->fields['estudiante'];?></option>
			<?php
			$rs_est->MoveNext();
			} 
			?>
		</select>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function contenido_calificaciones($db, $id_estudiante)
	{
		$varios_arreglos=$this->consulta_est_calificaciones($db, $id_estudiante);
		
		$datos=$varios_arreglos[0]['datos'];
		$data=$varios_arreglos[0]['data'];
		$column=$varios_arreglos[0]['column'];
		$abv=$varios_arreglos[0]['abv'];
		$actividad=$varios_arreglos[0]['actividad'];
		$comment=$varios_arreglos[0]['comment'];
		$width=300+count($actividad)*50;
?>
		<div style='display:table-row; width:100%;' >
			<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
			
				<div id="container">
					<div class="columnLayout">
						<div class="rowLayout">
							<div class="descLayout">
								<div class="pad">
									<div id="msg_asis" style='float:right;'></div>
									<div id="grid_calificaciones" style="width: <?php print $width;?>px; height: 100%; overflow: hidden1;"></div>
									<input name="hdn_comment" id="hdn_comment" type="hidden"/>
								</div>
							</div>

							<div class="codeLayout">
								<div class="pad">
									<script>
									var emerg = new Array();
									<?php 
									for($c=0;$c<=count($actividad);$c++)
									{
										if($c==0)
										{
									?>
											emerg[<?php print $c;?>]='Estudiantes';
									<?php
										}
										elseif($c>=1)
										{
											$cmerg='<b>Nombre: </b>'.$abv[$c].': '.$actividad[$c];
									?>
											btn_mod='<a onMouseOver="return overlib(\'<?php print $cmerg;?>\', ABOVE, RIGHT);"onMouseOut="return nd();"><?php print $abv[$c];?></a>';
											emerg[<?php print $c;?>]=btn_mod;
									<?php
										}
									}
									?>
									
									var $container = $("#grid_calificaciones"),
									id_msg = document.getElementById('msg_asis'),
									$parent = $container.parent(),
									tableLoaded=false,
									hot_asis;

									hot_asis = new Handsontable($container[0], 
									{
										data:<?php print json_encode($data);?>,
										minRows: 5,
										minCols: 5,
										maxRows: <?php print count($data);?>,
										rowHeaders: true,
										colHeaders: true,
										minSpareRows: 1,
										contextMenu: false,
										comments: true,
										fillHandle: false,
										fixedColumnsLeft: 1,
										manualColumnFreeze: true,
										
										colWidths:[250
										<?php for($c=1;$c<=count($actividad);$c++){?>, 40 <?php }?>
										],
										
										colHeaders:['Clases'
										<?php for($c=1;$c<=count($actividad);$c++){?>,emerg[<?php print $c;?>]<?php }?>
										],
										
										columns:[{readOnly: true, className: "htLeft", renderer: "html"}
										<?php for($c=1;$c<=count($actividad);$c++){print $column[$c];}?>
										],
										
										cell: [<?php print $comment;?>],
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
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_est_calificaciones($db, $id_estudiante)
	{
		include("../../../clases_acad.php");
		$clases_acad = new clases_acad();
		
		$datos[0][0]='';
		$actividad[0]='';
		$id[0]='';
		$abv[0]='';
		$column[0]='';
		$comment='';
		
		$sql_nota="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_academica WHERE activa='1'";//print $sql_nota.'<br>';
		$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
		
		$nota_minima=$rs_nota->fields['nota_minima'];
		$nota_aprobado=$rs_nota->fields['nota_aprobado'];
		$nota_maxima=$rs_nota->fields['nota_maxima'];
		
		$varios_arreglos=$this->encabezado($db);
		
		$id=$varios_arreglos[0]['id'];
		$id_encab=$varios_arreglos[0]['id_encab'];
		$tipo_id=$varios_arreglos[0]['tipo_id'];
		$position_id=$varios_arreglos[0]['position_id'];
		$pertenece=$varios_arreglos[0]['pertenece'];
		$actividad=$varios_arreglos[0]['actividad'];
		$abv=$varios_arreglos[0]['abv'];
		$column=$varios_arreglos[0]['column'];
		$tipo=$varios_arreglos[0]['tipo'];
		$position=$varios_arreglos[0]['position'];
		
		/*for($d=1;$d<=count($position);$d++){print 'position:['.$d.']: '.$position[$d].'<br>';}
		print '<br>';
		for($d=1;$d<=count($id);$d++){print 'id:['.$d.']: '.$id[$d].'<br>';}
		print '<br>';
		for($d=1;$d<=count($pertenece);$d++){print 'pertenece:['.$d.']: '.$pertenece[$d].'<br>';}*/
		
		if($_SESSION['user']=='')
		echo ("<script language='JavaScript' type='text/javascript'> location.href='../../../../seguridad/autenticacion.php?mensaje=Sesion caducada.' </script>");

		$sql_cla="SELECT n_asignatura.cuantitativa, clase.id_clase as id_clase, clase_estudiante.id_clase_estudiante, clase.id_asignatura as id_asignatura, concat(abreviatura,' - ',asignatura) as asignatura, n_asignatura.foto, clase.peso, clase.nombre as nombre, referencia as referencia, 
		codigo as codigo, curso_grado_paralelo_est.id_curso_grado_paralelo_est, clase.id_empleado_academico as id_empleado_academico, 
		concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre) as empleado_academico, peso as peso 
		FROM clase, n_periodo_academico, n_asignatura, empleado_academico, empleado, persona, usuario, clase_estudiante, curso_grado_paralelo_est, estudiante, familiar_estudiante, familiar, persona AS per_fam
		WHERE 1 
		AND persona.id_persona=empleado.id_persona 
		AND empleado_academico.id_empleado=empleado.id_empleado
		AND clase.id_empleado_academico=empleado_academico.id_empleado_academico
		AND clase.id_asignatura=n_asignatura.id_asignatura 
		AND clase.id_periodo_academico=n_periodo_academico.id_periodo_academico
		AND clase.id_clase=clase_estudiante.id_clase
		AND clase_estudiante.id_curso_grado_paralelo_est=curso_grado_paralelo_est.id_curso_grado_paralelo_est
		AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante
		AND estudiante.id_estudiante=familiar_estudiante.id_estudiante
		AND familiar.id_familiar=familiar_estudiante.id_familiar
		AND per_fam.id_persona=familiar.id_persona
		AND per_fam.id_persona=usuario.id_persona
		AND n_periodo_academico.activo='1'
		AND estudiante.id_estudiante='".$id_estudiante."'
		AND usuario='".$_SESSION['user']."' ORDER BY n_asignatura.cuantitativa, codigo_unico DESC";//print $sql_cla;
		$rs_cla=$db->Execute($sql_cla) or die($db->ErrorMsg());
		
		$rs_cla->MoveFirst();		
		for($c=0;$c<$rs_cla->RecordCount();$c++)
		{
			$id_clase=$rs_cla->fields['id_clase'];
			$id_asignatura=$rs_cla->fields['id_asignatura'];
			$id_clase_estudiante=$rs_cla->fields['id_clase_estudiante'];
			$asig_cuantitativa=$rs_cla->fields['cuantitativa'];
			?>					
			<input name="hdn_cal_id_clase_<?php print $id_clase;?>" id="hdn_cal_id_clase_<?php print $id_clase;?>" type="hidden" value="<?php print $id_clase;?>"/>
			<?php
			$clase='<a onMouseOver="return overlib(\''.'<b>Profesor:</b> '.$rs_cla->fields['empleado_academico'].'<br>'.$rs_cla->fields['asignatura'].'<br>'.$rs_cla->fields['referencia'].'\', ABOVE, RIGHT);"onMouseOut="return nd();">'.$rs_cla->fields['nombre'].' ('.$rs_cla->fields['peso'].'%)'.'</a>';
			$datos[$c][0]=$clase;
			
			$pos=0;
			$examen_periodo='';
			//--------------------------------------------------------------------------------------------------------------------
			for($h=1;$h<=count($position);$h++)
			{
				if($tipo[$position[$h]]=='s')
				{
					?>					
					<input name="hdn_cal_id_subperiodo_evaluativo_<?php print $id_clase.$id_encab[$position[$h]];?>" id="hdn_cal_id_subperiodo_evaluativo_<?php print $id_clase.$id_encab[$position[$h]];?>" type="hidden" value="<?php print $id_encab[$position[$h]];?>"/>
					<?php
					$promedio_s=$clases_acad->calcular_prom_subperiodo($db, $id_clase_estudiante, $id_encab[$position[$h]], '');
					$nota=$promedio_s['promedio'];
					if($asig_cuantitativa=='0')$nota_cua=$clases_acad->nota_cualitativa($db, $nota);else $nota_cua=$nota;				
					$nota_html='<a href="#modal_calificacion" onClick="ejecutar_ajax(\'calificacion/modal_calificacion.php\', \'sel_filtro_cal,hdn_cal_id_clase_'.$id_clase.',hdn_cal_id_subperiodo_evaluativo_'.$id_clase.$id_encab[$position[$h]].'\',\'modal_calificacion\')"';if($nota<$nota_aprobado)$nota_html.='style="color:red;text-align:center;" '; $nota_html.='>&nbsp;&nbsp;'.$nota_cua.'&nbsp;&nbsp;</a>';
					$datos[$c][$position[$h]]=$nota_html;				
				}
				
				elseif($tipo[$position[$h]]=='p')
				{
					$promedio_p=$clases_acad->calcular_prom_periodo($db, $id_clase_estudiante, $id_encab[$position[$h]]);//print 'examen_periodo: '.$examen_periodo.'<br>';
					$nota=$promedio_p;
					if($asig_cuantitativa=='0')$nota_cua=$clases_acad->nota_cualitativa($db, $nota);else $nota_cua=$nota;				
					$nota_html='<a ';if($nota<$nota_aprobado)$nota_html.='style="color:red;text-align:center;" '; $nota_html.='>&nbsp;&nbsp;'.$nota_cua.'&nbsp;&nbsp;</a>';
					$datos[$c][$position[$h]]=$nota_html;
				}
				
				elseif($tipo[$position[$h]]=='l')
				{
					$promedio_l=$clases_acad->calcular_prom_lectivo($db, $id_clase_estudiante, $id_encab[$position[$h]]);//print 'examen_periodo: '.$examen_periodo.'<br>';
					$nota=$promedio_l['promedio'];
					if($asig_cuantitativa=='0')$nota_cua=$clases_acad->nota_cualitativa($db, $nota);else $nota_cua=$nota;				
					$nota_html='<a ';if($nota<$nota_aprobado)$nota_html.='style="color:red;text-align:center;" '; $nota_html.='>&nbsp;&nbsp;'.$nota_cua.'&nbsp;&nbsp;</a>';
					$datos[$c][$position[$h]]=$nota_html;
				}
				
				elseif($tipo[$position[$h]]=='p_exa')
				{
					for($a=1;$a<=count($position_id);$a++)
					{					
						if($tipo_id[$position_id[$a]]=='p_exa' AND $id_encab[$position[$h]]==$pertenece[$position_id[$a]])//substr($sel_filtro_cal, 2, strlen($sel_filtro_cal));
						{
							$examen_periodo=$this->consulta_nota_examen_periodo($db, $id_clase_estudiante, $id[$position_id[$a]]);
							$nota=$examen_periodo['nota'];
							if($asig_cuantitativa=='0')$nota_cua=$clases_acad->nota_cualitativa($db, $nota);else $nota_cua=$nota;				
							$nota_html='<a ';if($nota<$nota_aprobado)$nota_html.='style="color:red;text-align:center;" '; $nota_html.='>&nbsp;&nbsp;'.$nota_cua.'&nbsp;&nbsp;</a>';
							$datos[$c][$position[$h]]=$nota_html;
							if($examen_periodo['nota']!='')break;
						}
					}
				}
			
				elseif($tipo[$position[$h]]=='p_adic')
				{
					for($a=1;$a<=count($position_id);$a++)
					{
						if($tipo_id[$position_id[$a]]=='p_adic' AND $id_encab[$position[$h]]==$pertenece[$position_id[$a]])
						{
							$examen_periodo_adic=$this->consulta_nota_examen_periodo_adicional($db, $id_clase_estudiante, $id[$position_id[$a]]);
							$nota=$examen_periodo_adic['nota'];
							if($asig_cuantitativa=='0')$nota_cua=$clases_acad->nota_cualitativa($db, $nota);else $nota_cua=$nota;				
							$nota_html='<a ';if($nota<$nota_aprobado)$nota_html.='style="color:red;text-align:center;" '; $nota_html.='>&nbsp;&nbsp;'.$nota_cua.'&nbsp;&nbsp;</a>';
							$datos[$c][$position[$h]]=$nota_html;
							if($examen_periodo_adic['nota']!='')break;
						}
					}
				}
				
				elseif($tipo[$position[$h]]=='l_exa')
				{
					for($a=1;$a<=count($position_id);$a++)
					{
						if($tipo_id[$position_id[$a]]=='l_exa' AND $id_encab[$position[$h]]==$pertenece[$position_id[$a]])
						{
							$examen_lectivo=$clases_acad->consulta_nota_examen_lectivo($db, $id_clase_estudiante, $id[$position_id[$a]]);
							$nota=$examen_lectivo['nota'];
							if($asig_cuantitativa=='0')$nota_cua=$clases_acad->nota_cualitativa($db, $nota);else $nota_cua=$nota;				
							$nota_html='<a ';if($nota<$nota_aprobado)$nota_html.='style="color:red;text-align:center;" '; $nota_html.='>&nbsp;&nbsp;'.$nota_cua.'&nbsp;&nbsp;</a>';
							$datos[$c][$position[$h]]=$nota_html;
							if($examen_lectivo['nota']!='')break;
						}
					}
				}
				
				elseif($tipo[$position[$h]]=='l_adic')
				{
					for($a=1;$a<=count($position_id);$a++)
					{//if($tipo_id[$position_id[$a]]=='l_adic')print 'tipo_id: '.$tipo_id[$position_id[$a]].'&nbsp;&nbsp;&nbsp;&nbsp; id_encab: '.$id_encab[$position[$h]].' == pertenece: '.$pertenece[$position_id[$a]].'<br>';
						if($tipo_id[$position_id[$a]]=='l_adic' AND $id_encab[$position[$h]]==$pertenece[$position_id[$a]])
						{
							$examen_lectivo_adic=$clases_acad->consulta_nota_examen_lectivo_adicional($db, $id_clase_estudiante, $id[$position_id[$a]]);
							$nota=$examen_lectivo_adic['nota'];
							if($asig_cuantitativa=='0')$nota_cua=$clases_acad->nota_cualitativa($db, $nota);else $nota_cua=$nota;				
							$nota_html='<a ';if($nota<$nota_aprobado)$nota_html.='style="color:red;text-align:center;" '; $nota_html.='>&nbsp;&nbsp;'.$nota_cua.'&nbsp;&nbsp;</a>';
							$datos[$c][$position[$h]]=$nota_html;
							if($examen_lectivo_adic['nota']!='')break;
						}
					}
				//print '<br>';
				}
			}
			
			//--------------------------------------------------------------------------------------------------------------------		
		$rs_cla->MoveNext();
		}
		
		for($d=0;$d<count($datos);$d++){$data[$d]=$datos[$d];}
		
		$varios_arreglos=array();
		$varios_arreglos[0]=array('abv'=>$abv,'datos'=>$datos,'data'=>$data,'column'=>$column,'comment'=>$comment,'actividad'=>$actividad);//print count($data);

		return $varios_arreglos;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_nota_examen_periodo($db, $id_clase_estudiante, $id_examen_periodo_eval)
	{		
		$sql_nota="SELECT nota, peso FROM nota_examen_periodo_eval, n_examen_periodo_eval
		WHERE nota_examen_periodo_eval.id_examen_periodo_eval=n_examen_periodo_eval.id_examen_periodo_eval 
		AND n_examen_periodo_eval.id_examen_periodo_eval='".$id_examen_periodo_eval."' 
		AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_nota.'<br>';
		$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
		
		if(isset($rs_nota->fields['nota']))
		{
			$examen_periodo['nota']=number_format(round($rs_nota->fields['nota'], 2), 2, ".", "");//print $e.' - '.$a;
		}
		else
		$examen_periodo['nota']='';
		
		return $examen_periodo;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_nota_examen_periodo_adicional($db, $id_clase_estudiante, $id_exa_adicional_periodo)
	{
		$sql_nota="SELECT nota, opcional, publica_nota FROM nota_exa_adicional_periodo, n_exa_adicional_periodo, n_examen_adicional, n_tipo_examen
		WHERE nota_exa_adicional_periodo.id_exa_adicional_periodo=n_exa_adicional_periodo.id_exa_adicional_periodo
		AND n_examen_adicional.id_examen_adicional=n_exa_adicional_periodo.id_examen_adicional
		AND n_tipo_examen.id_tipo_examen=n_exa_adicional_periodo.id_tipo_examen
		AND n_exa_adicional_periodo.id_exa_adicional_periodo='".$id_exa_adicional_periodo."' 
		AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_nota.'<br>';
		$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
		
		if(isset($rs_nota->fields['nota']))
		{
			$examen_periodo_adicional['nota']=number_format(round($rs_nota->fields['nota'], 2), 2, ".", "");//print $e.' - '.$a;			
		}
		else
		$examen_periodo_adicional['nota']='';
		
		return $examen_periodo_adicional;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function encabezado($db)
	{
		$pos=0;$pos_id=1;
		
		$l_examen_lec_ant=array();
		$l_abv_tipo_examen_lec_ant=array();
		
		$l_examen_adicional_ant=array();
		$l_abv_examen_ant=array();
		
		$sql_l="SELECT id_periodo_lectivo, periodo_lectivo
		FROM n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica		
		AND n_conf_academica.activa='1'";//print $sql_p;die();
		$rs_l=$db->Execute($sql_l) or die($db->ErrorMsg());
		
		for($l=0;$l<$rs_l->RecordCount();$l++)
		{
			$pos=$pos+1;
			$actividad[$pos]=$rs_l->fields['periodo_lectivo'];
			$abv[$pos]='A&ntilde;o';
			$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, renderer: "html"}';
			$tipo[$pos]='l';
			$position[$pos]=$pos;
			$id_encab[$pos]=$rs_l->fields['id_periodo_lectivo'];

			$position_id[$pos_id]=$pos_id;
			$id[$pos_id]=$rs_l->fields['id_periodo_lectivo'];
			$tipo_id[$pos_id]='l';//print '  mi pos1: '.$pos_id;
			$pos_id=$pos_id+1;
				
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
				$actividad[$pos]=$rs_p->fields['periodo_evaluativo'];
				$abv[$pos]=$rs_p->fields['abv_periodo'];
				$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, comment: false, renderer: "html"}';
				$tipo[$pos]='p';
				$position[$pos]=$pos;
				$id_encab[$pos]=$rs_p->fields['id_periodo_evaluativo'];

				
				$position_id[$pos_id]=$pos_id;
				$id[$pos_id]=$rs_p->fields['id_periodo_evaluativo'];
				$tipo_id[$pos_id]='p';//print '  mi pos1: '.$pos_id;
				$pos_id=$pos_id+1;
				
				$sql_s="SELECT id_subperiodo_evaluativo, subperiodo_evaluativo, abv_subperiodo
				FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
				WHERE 1
				AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
				AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
				AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
				AND n_conf_academica.activa='1'
				AND n_subperiodo_evaluativo.id_periodo_evaluativo='".$rs_p->fields['id_periodo_evaluativo']."'";//print $sql_s.'<br><br><br>';//die();
				$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
				
				for($s=0;$s<$rs_s->RecordCount();$s++)
				{	
					$pos=$pos+1;
					$actividad[$pos]=$rs_s->fields['subperiodo_evaluativo'];
					$abv[$pos]=$rs_s->fields['abv_subperiodo'];
					$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false, readOnly: true, renderer: "html"}';						
					$tipo[$pos]='s';
					$position[$pos]=$pos;
					$id_encab[$pos]=$rs_s->fields['id_subperiodo_evaluativo'];
					
					
					$position_id[$pos_id]=$pos_id;
					$id[$pos_id]=$rs_s->fields['id_subperiodo_evaluativo'];
					$tipo_id[$pos_id]='s';//print '  mi pos1: '.$pos_id;
					$pos_id=$pos_id+1;
					
				$rs_s->MoveNext();
				}
				
				//----------------EXAMENES Y EXAMENES ADICIONALES DEL PERIODO EVALUATIVO----------------
				$sql_p_exa="SELECT id_examen_periodo_eval, examen_eval, abv_tipo_examen_eval, peso
				FROM n_examen_periodo_eval, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
				WHERE 1
				AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
				AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
				AND n_examen_periodo_eval.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
				AND n_periodo_evaluativo.id_periodo_evaluativo='".$rs_p->fields['id_periodo_evaluativo']."'				
				AND n_conf_academica.activa='1'
				ORDER BY examen_eval";//print $sql_p_exa.'<br><br><br>';//die();//AND n_examen_periodo_eval.id_asignatura='".$id_asignatura."'
				$rs_p_exa=$db->Execute($sql_p_exa) or die($db->ErrorMsg());
				
				$p_examen_eval_ant=array();
				$p_abv_tipo_examen_eval_ant=array();
				
				$p_examen_adicional_ant=array();
				$p_abv_examen_ant=array();
					
				for($p_exa=0;$p_exa<$rs_p_exa->RecordCount();$p_exa++)
				{	
					if($rs_p_exa->fields['peso']!=0)
					{
						if(!in_array($rs_p_exa->fields['examen_eval'], $p_examen_eval_ant) OR !in_array($rs_p_exa->fields['abv_tipo_examen_eval'], $p_abv_tipo_examen_eval_ant))
						{
							$pos=$pos+1;
							$actividad[$pos]=$rs_p_exa->fields['examen_eval'];
							$abv[$pos]=$rs_p_exa->fields['abv_tipo_examen_eval'];
							$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, comment: false, renderer: "html"}';
							$position[$pos]=$pos;	
							$tipo[$pos]='p_exa';
							
							$p_examen_eval_ant[$pos]=$rs_p_exa->fields['examen_eval'];
							$p_abv_tipo_examen_eval_ant[$pos]=$rs_p_exa->fields['abv_tipo_examen_eval'];	
							$id_encab[$pos]=$rs_p_exa->fields['id_examen_periodo_eval'];
							$id_aux_p_exa=$rs_p_exa->fields['id_examen_periodo_eval'];
						}
						
						$pertenece[$pos_id]=$id_aux_p_exa;
						$position_id[$pos_id]=$pos_id;
						$id[$pos_id]=$rs_p_exa->fields['id_examen_periodo_eval'];
						$tipo_id[$pos_id]='p_exa';//print '  mi pos1: '.$pos;
						$pos_id=$pos_id+1;
					}
					
					$sql_p_adic="SELECT id_exa_adicional_periodo, examen_adicional, abv_examen, tipo_examen, opcional
					FROM n_examen_adicional, n_tipo_examen, n_exa_adicional_periodo, n_examen_periodo_eval, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
					WHERE 1
					AND n_examen_adicional.id_examen_adicional=n_exa_adicional_periodo.id_examen_adicional
					AND n_tipo_examen.id_tipo_examen=n_exa_adicional_periodo.id_tipo_examen
					AND n_exa_adicional_periodo.id_examen_periodo_eval=n_examen_periodo_eval.id_examen_periodo_eval
					AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
					AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
					AND n_examen_periodo_eval.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
					AND n_exa_adicional_periodo.id_examen_periodo_eval='".$rs_p_exa->fields['id_examen_periodo_eval']."'
					AND n_conf_academica.activa='1' ORDER BY n_exa_adicional_periodo.orden";//print $sql_p_adic;die();//, actividad.fecha
					$rs_p_adic=$db->Execute($sql_p_adic) or die($db->ErrorMsg());
					
					for($p_adic=0;$p_adic<$rs_p_adic->RecordCount();$p_adic++)
					{
						if(!in_array($rs_p_adic->fields['examen_adicional'], $p_examen_adicional_ant) OR !in_array($rs_p_adic->fields['abv_examen'], $p_abv_examen_ant))
						{
							$pos=$pos+1;
							$actividad[$pos]=$rs_p_adic->fields['examen_adicional'];
							$abv[$pos]=$rs_p_adic->fields['abv_examen'];
							$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, comment: false, renderer: "html"}';
							$position[$pos]=$pos;							
							$tipo[$pos]='p_adic';
						
							$p_examen_adicional_ant[$pos]=$rs_p_adic->fields['examen_adicional'];
							$p_abv_examen_ant[$pos]=$rs_p_adic->fields['abv_examen'];
							$id_encab[$pos]=$rs_p_adic->fields['id_exa_adicional_periodo'];
							$id_aux_p_adic=$rs_p_adic->fields['id_exa_adicional_periodo'];							
						}
			
						$pertenece[$pos_id]=$id_aux_p_adic;
						$position_id[$pos_id]=$pos_id;
						$id[$pos_id]=$rs_p_adic->fields['id_exa_adicional_periodo'];
						$tipo_id[$pos_id]='p_adic';//print '  mi pos222: '.$pos_id;
						$pos_id=$pos_id+1;
					
					$rs_p_adic->MoveNext();
					}
					
				$rs_p_exa->MoveNext();
				}
				//----------------EXAMENES Y EXAMENES ADICIONALES DEL PERIODO EVALUATIVO----------------
				
			$rs_p->MoveNext();
			}
			
			//----------------EXAMENES Y EXAMENES ADICIONALES DEL PERIODO LECTIVO----------------
			$sql_l_exa="SELECT id_examen_periodo_lec, examen_lec, abv_tipo_examen_lec, peso
			FROM n_examen_periodo_lec, n_periodo_lectivo, n_conf_academica
			WHERE 1
			AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
			AND n_examen_periodo_lec.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
			AND n_periodo_lectivo.id_periodo_lectivo='".$rs_l->fields['id_periodo_lectivo']."'			
			AND n_conf_academica.activa='1'
			ORDER BY examen_lec";//print $sql_l_exa;//die();//AND n_examen_periodo_lec.id_asignatura='".$id_asignatura."'
			$rs_l_exa=$db->Execute($sql_l_exa) or die($db->ErrorMsg());
			
			for($l_exa=0;$l_exa<$rs_l_exa->RecordCount();$l_exa++)
			{	
				if($rs_l_exa->fields['peso']!=0)
				{
					if(!in_array($rs_l_exa->fields['examen_lec'], $l_examen_lec_ant) OR !in_array($rs_l_exa->fields['abv_tipo_examen_lec'], $l_abv_tipo_examen_lec_ant))
					{
						$pos=$pos+1;
						$actividad[$pos]=$rs_l_exa->fields['examen_lec'];
						$abv[$pos]=$rs_l_exa->fields['abv_tipo_examen_lec'];
						$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, comment: false, renderer: "html"}';
						$position[$pos]=$pos;
						$tipo[$pos]='l_exa';
						
						$l_examen_lec_ant[$pos]=$rs_l_exa->fields['examen_lec'];
						$l_abv_tipo_examen_lec_ant[$pos]=$rs_l_exa->fields['abv_tipo_examen_lec'];
						$id_encab[$pos]=$rs_l_exa->fields['id_examen_periodo_lec'];
						$pertenece[$pos_id]=$rs_l_exa->fields['id_examen_periodo_lec'];
					}
					else
					{
						$pos_arr=array_search($rs_l_exa->fields['examen_lec'], $actividad);//print 'pos_arr:'.$pos_arr;
						$pertenece[$pos_id]=$id_encab[$pos_arr];
					}
					
					$position_id[$pos_id]=$pos_id;
					$id[$pos_id]=$rs_l_exa->fields['id_examen_periodo_lec'];
					$tipo_id[$pos_id]='l_exa';
					$pos_id=$pos_id+1;
				}
				
				$sql_l_adic="SELECT id_exa_adicional_lectivo, examen_adicional, abv_examen, tipo_examen, opcional
				FROM n_examen_adicional, n_tipo_examen, n_exa_adicional_lectivo, n_examen_periodo_lec, n_periodo_lectivo, n_conf_academica
				WHERE 1
				AND n_examen_adicional.id_examen_adicional=n_exa_adicional_lectivo.id_examen_adicional
				AND n_tipo_examen.id_tipo_examen=n_exa_adicional_lectivo.id_tipo_examen
				AND n_exa_adicional_lectivo.id_examen_periodo_lec=n_examen_periodo_lec.id_examen_periodo_lec
				AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica					
				AND n_examen_periodo_lec.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
				AND n_examen_periodo_lec.id_examen_periodo_lec='".$rs_l_exa->fields['id_examen_periodo_lec']."'
				AND n_conf_academica.activa='1' ORDER BY n_exa_adicional_lectivo.orden";//print '<br><br>'.$sql_l_adic.'<br><br>';//die();//, actividad.fecha
				$rs_l_adic=$db->Execute($sql_l_adic) or die($db->ErrorMsg());
				
				for($l_adic=0;$l_adic<$rs_l_adic->RecordCount();$l_adic++)
				{
					if(!in_array($rs_l_adic->fields['examen_adicional'], $l_examen_adicional_ant) OR !in_array($rs_l_adic->fields['abv_examen'], $l_abv_examen_ant))
					{
						$pos=$pos+1;
						$actividad[$pos]=$rs_l_adic->fields['examen_adicional'];
						$abv[$pos]=$rs_l_adic->fields['abv_examen'];
						$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, comment: false, renderer: "html"}';
						$position[$pos]=$pos;
						$tipo[$pos]='l_adic';
						
						$l_examen_adicional_ant[$pos]=$rs_l_adic->fields['examen_adicional'];
						$l_abv_examen_ant[$pos]=$rs_l_adic->fields['abv_examen'];
						$id_encab[$pos]=$rs_l_adic->fields['id_exa_adicional_lectivo'];
						$pertenece[$pos_id]=$rs_l_adic->fields['id_exa_adicional_lectivo'];
					}
					else
					{
						$pos_arr=array_search($rs_l_adic->fields['examen_adicional'], $actividad);//print 'pos_arr:'.$pos_arr;
						$pertenece[$pos_id]=$id_encab[$pos_arr];
					}

					$position_id[$pos_id]=$pos_id;
					$id[$pos_id]=$rs_l_adic->fields['id_exa_adicional_lectivo'];
					$tipo_id[$pos_id]='l_adic';//print '  id: '.$rs_l_adic->fields['id_exa_adicional_lectivo'].' pertenece: '.$pertenece[$pos_id].'<br>';
					$pos_id=$pos_id+1;
					
				$rs_l_adic->MoveNext();
				}
			
			$rs_l_exa->MoveNext();
			}
			//----------------EXAMENES Y EXAMENES ADICIONALES DEL PERIODO LECTIVO----------------
				
		$rs_l->MoveNext();
		}
	
		$varios_arreglos=array();
		$varios_arreglos[0]=array('id'=>$id, 'id_encab'=>$id_encab, 'actividad'=>$actividad, 'abv'=>$abv, 'column'=>$column, 'tipo'=>$tipo, 'tipo_id'=>$tipo_id, 'position'=>$position, 'position_id'=>$position_id, 'pertenece'=>$pertenece);//print count($data);

		return $varios_arreglos;
	}
}
?>
