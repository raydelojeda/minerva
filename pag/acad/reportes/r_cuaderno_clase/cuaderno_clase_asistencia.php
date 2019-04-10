<?php
class cuaderno_clase_asistencia
{
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function pestana_asistencia($db)
	{
?>
		<div class="tab-page">
			<h2 class="tab">Asistencia</h2>
			<div class="tab-pane" id="tabPane1">		
				<?php				
					$this->filtro_asistencia($db);
				?>				
				<div style='display:table;width:100%;margin-left:auto;margin-right:auto;' id='contenido_grid_asistencias'>				
					<?php
						//$tihs->contenido_asistencias($db, '');
					?>
				</div>
			</div>
		</div>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function filtro_asistencia($db)
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
		<div style='display:table;width:100%;'>
			<div  style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:left;padding:1%;'>
					
					<div class='tabla_filtro' style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
						<div class='tabla_filtro' style='display:table-row;'>
							<div style='display:table-cell;width:100%;text-align:left;padding:1%;'>
								<?php
									$parametros_extras="onChange=\"ejecutar_ajax('asistencia/actualizar_grid.php', 'sel_filtro_asis', 'contenido_grid_asistencias');\"";
									$this->select_filtro_asis($parametros_extras, $rs_est);
								
									$msg_asis='Ud. puede dar clic en la cantidad de inasistencias de cada parcial y clase para ver el detalle de asistencias.';
								?>
								&nbsp;<a onMouseOver="return overlib('<?php print $msg_asis;?>', ABOVE, RIGHT);"onMouseOut="return nd();"><img src='../../../../img/general/help.png'></a>
							</div>
							
						</div>
					</div>
					
					<br>
					
					<fieldset>
						<legend>Estado de la asistencia</legend>
						<div style='display:table;width:100%;'>
							<div style='display:table-row;'>
								<div style='display:table-cell;width:100%;height:12px;text-align:left;padding-left:1%;'>
									<?php
										$leyenda='<img width=13px src="../../../../img/acad/asistencia/ok.png">&nbsp;Presente&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
										$leyenda=$leyenda.'<img width=13px src="../../../../img/acad/asistencia/atraso.png">&nbsp;Atraso&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
										$leyenda=$leyenda.'<img width=13px src="../../../../img/acad/asistencia/tarjeta_amarilla.png">&nbsp;Ausencia justificada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
										$leyenda=$leyenda.'<img width=13px src="../../../../img/acad/asistencia/tarjeta_roja.png">&nbsp;Ausencia injustificada';									
										print $leyenda;	
									?>
								</div>
							</div>
						</div>
					</fieldset>
					
				</div>
			</div>
		</div>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function select_filtro_asis($parametros_extras, $rs_est)
	{
?>
		Cantidad de inasistencias del estudiante: <select name="sel_filtro_asis" class="sel_filtro_asis" title="Filtro" id="sel_filtro_asis" <?php print $parametros_extras;?>>
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
	function contenido_asistencias($db, $id_estudiante)
	{
		$varios_arreglos=$this->consulta_est_asistencias($db, $id_estudiante);
		
		$id_clase_inasistencia=$varios_arreglos[0]['id_clase_inasistencia'];//print count($id_clase_inasistencia);
		$datos=$varios_arreglos[0]['datos'];
		$data=$varios_arreglos[0]['data'];
		$column=$varios_arreglos[0]['column'];
		$abv=$varios_arreglos[0]['abv'];
		$actividad=$varios_arreglos[0]['actividad'];
		$comment=$varios_arreglos[0]['comment'];
		$width=300+count($id_clase_inasistencia)*50;
?>
		<div style='display:table-row;'>
			<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
			
				<div id="container">
					<div class="columnLayout">
						<div class="rowLayout">
							<div class="descLayout">
								<div class="pad">
									<div id="msg_asis" style='float:right;'></div>
									<div id="grid_asistencias" style="width: <?php print $width;?>px; height: 50%; overflow: hidden1;"></div>
									<input name="hdn_comment" id="hdn_comment" type="hidden"/>
								</div>
							</div>

							<div class="codeLayout">
								<div class="pad">
									<script>
									var emerg = new Array();
									<?php 
									for($c=0;$c<count($id_clase_inasistencia);$c++)
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
									
									var $container = $("#grid_asistencias"),
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
										<?php for($c=1;$c<count($id_clase_inasistencia);$c++){?>, 30 <?php }?>
										],
										
										colHeaders:['Clases'
										<?php for($c=1;$c<count($id_clase_inasistencia);$c++){?>,emerg[<?php print $c;?>]<?php }?>
										],
										
										columns:[{readOnly: true, className: "htLeft", renderer: "html"}
										<?php for($c=1;$c<count($id_clase_inasistencia);$c++){print $column[$c];}?>
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
	function consulta_est_asistencias($db, $id_estudiante)
	{
		$datos[0][0]='';
		$actividad[0]='';
		$id_clase_inasistencia[0]='';
		$abv[0]='';
		$column[0]='';
		$comment='';
		
		$sql_cla="SELECT DISTINCT clase.id_clase as id_clase, clase.id_asignatura as id_asignatura, concat(abreviatura,' - ',asignatura) as asignatura, n_asignatura.foto, clase.nombre as nombre, referencia as referencia, 
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
		AND usuario='".$_SESSION['user']."' ORDER BY nombre";//print $sql_cla;
		$rs_cla=$db->Execute($sql_cla) or die($db->ErrorMsg());
		
		$rs_cla->MoveFirst();		
		for($c=0;$c<$rs_cla->RecordCount();$c++)
		{
			$id_clase=$rs_cla->fields['id_clase'];
			?>					
			<input name="hdn_asis_id_clase_<?php print $id_clase;?>" id="hdn_asis_id_clase_<?php print $id_clase;?>" type="hidden" value="<?php print $id_clase;?>"/>
			<?php
			$clase='<a onMouseOver="return overlib(\''.'<b>Profesor:</b> '.$rs_cla->fields['empleado_academico'].'<br>'.$rs_cla->fields['asignatura'].'<br>'.$rs_cla->fields['referencia'].'\', ABOVE, RIGHT);"onMouseOut="return nd();">'.$rs_cla->fields['nombre'].'</a>';
			$datos[$c][0]=$clase;
			$pos=1;
			
			$sql_l="SELECT id_periodo_lectivo, periodo_lectivo
			FROM n_periodo_lectivo, n_conf_academica
			WHERE 1
			AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica		
			AND n_conf_academica.activa='1'";//print $sql_p;die();
			$rs_l=$db->Execute($sql_l) or die($db->ErrorMsg());
			
			for($l=0;$l<$rs_l->RecordCount();$l++)
			{
				$id_clase_inasistencia[$pos]=$rs_l->fields['id_periodo_lectivo'];
				$actividad[$pos]=$rs_l->fields['periodo_lectivo'];
				$abv[$pos]='A&ntilde;o';
				$column[$pos]=',{className: "htCenter", allowInvalid: false,readOnly: true, renderer: "html"}';
				$pos_l=$pos;$pos=$pos+1;
				
					
				$sql_p="SELECT id_periodo_evaluativo, periodo_evaluativo, abv_periodo
				FROM n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
				WHERE 1
				AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
				AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo		
				AND n_conf_academica.activa='1'
				AND n_periodo_evaluativo.id_periodo_lectivo='".$rs_l->fields['id_periodo_lectivo']."'";//print $sql_p;die();
				$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
				
				$suma_l_injustificadas='';
				
				for($p=0;$p<$rs_p->RecordCount();$p++)
				{
					$id_clase_inasistencia[$pos]=$rs_p->fields['id_periodo_evaluativo'];
					$actividad[$pos]=$rs_p->fields['periodo_evaluativo'];
					$abv[$pos]=$rs_p->fields['abv_periodo'];
					$column[$pos]=',{className: "htCenter", allowInvalid: false,readOnly: true, comment: false, renderer: "html"}';
					$pos_p=$pos;$pos=$pos+1;
					
					
					$sql_s="SELECT id_subperiodo_evaluativo, subperiodo_evaluativo, abv_subperiodo
					FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
					WHERE 1
					AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
					AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
					AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
					AND n_conf_academica.activa='1'
					AND n_subperiodo_evaluativo.id_periodo_evaluativo='".$rs_p->fields['id_periodo_evaluativo']."'";//print $sql_p;die();
					$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
					
					$suma_p_injustificadas='';
					
					for($s=0;$s<$rs_s->RecordCount();$s++)
					{					
						$id_sub_eval=$rs_s->fields['id_subperiodo_evaluativo'];
						?>					
						<input name="hdn_asis_id_subperiodo_evaluativo_<?php print $id_clase.$id_sub_eval;?>" id="hdn_asis_id_subperiodo_evaluativo_<?php print $id_clase.$id_sub_eval;?>" type="hidden" value="<?php print $id_sub_eval;?>"/>
						<?php
						$id_clase_inasistencia[$pos]=$rs_s->fields['id_subperiodo_evaluativo'];
						$actividad[$pos]=$rs_s->fields['subperiodo_evaluativo'];
						$abv[$pos]=$rs_s->fields['abv_subperiodo'];
						$column[$pos]=',{className: "htCenter", allowInvalid: false, readOnly: true, renderer: "html"}';						
						$pos_s=$pos;$pos=$pos+1;						
						
						$sql_ina="SELECT clase_inasistencia.id_clase_inasistencia, fecha, tema_impartir, inasistencia, observacion, inasistencia_inspector, observacion_inspector
						FROM clase_inasistencia, inasistencia_clase, clase_estudiante, clase, n_periodo_academico 
						WHERE 1 
						AND n_periodo_academico.id_periodo_academico=clase.id_periodo_academico
						AND clase_estudiante.id_clase=clase.id_clase AND clase_inasistencia.id_clase_inasistencia=inasistencia_clase.id_clase_inasistencia
						AND inasistencia_clase.id_clase_estudiante=clase_estudiante.id_clase_estudiante	AND id_subperiodo_evaluativo='".$rs_s->fields['id_subperiodo_evaluativo']."' 
						AND clase_inasistencia.id_clase='".$id_clase."' AND id_curso_grado_paralelo_est='".$rs_cla->fields['id_curso_grado_paralelo_est']."'
						AND n_periodo_academico.activo='1' ORDER BY fecha";//print $sql_ina;die();
						$rs_ina=$db->Execute($sql_ina) or die($db->ErrorMsg());
						
						$sql_horas_clase="SELECT clase_inasistencia.id_clase_inasistencia, fecha, tema_impartir
						FROM clase_inasistencia WHERE 1 
						AND id_subperiodo_evaluativo='".$rs_s->fields['id_subperiodo_evaluativo']."' 
						AND clase_inasistencia.id_clase='".$id_clase."' ORDER BY fecha";//print $sql_ina;die();
						$rs_horas_clase=$db->Execute($sql_horas_clase) or die($db->ErrorMsg());
						
						$atrasos=0;
						$justificadas=0;
						$injustificadas=0;
						
						for($a=0;$a<$rs_ina->RecordCount();$a++)
						{
							$inasistencia=$rs_ina->fields['inasistencia'];
							$inasistencia_inspector=$rs_ina->fields['inasistencia_inspector'];
							
							if($inasistencia!=0 AND $inasistencia_inspector==99)
							{
								if($inasistencia==1)$atrasos=$atrasos+1;
								elseif($inasistencia==2)$justificadas=$justificadas+1;
								elseif($inasistencia==3)$injustificadas=$injustificadas+1;
							}
							
							if($inasistencia_inspector!=99)
							{
								//if($inasistencia_inspector==0)$presentes_insp=$presentes_insp+1;
								if($inasistencia_inspector==1)$atrasos=$atrasos+1;
								elseif($inasistencia_inspector==2)$justificadas=$justificadas+1;
								elseif($inasistencia_inspector==3)$injustificadas=$injustificadas+1;
							}
							
						$rs_ina->MoveNext();
						}
						
						$presentes=$rs_horas_clase->RecordCount()-$atrasos-$justificadas-$injustificadas;
						$detalle='Presente:'.$presentes.' <img width=12px src=../../../../img/acad/asistencia/ok.png>';
						$detalle.='<br>Atrasos:'.$atrasos.' <img width=12px src=../../../../img/acad/asistencia/atraso.png>';
						$detalle.='<br>Justificadas:'.$justificadas.' <img width=12px src=../../../../img/acad/asistencia/tarjeta_amarilla.png>';
						$detalle.='<br>Injustificadas:'.$injustificadas.' <img width=12px src=../../../../img/acad/asistencia/tarjeta_roja.png>';
						$detalle.='<br>Horas clase:'.$rs_horas_clase->RecordCount().' <img width=12px src=../../../../img/general/cuaderno_clase.png>';
						
						if($injustificadas==0)$injustificadas_celda='-';else $injustificadas_celda='&nbsp;'.$injustificadas.'&nbsp;<img width=5px src="../../../../img/acad/asistencia/tarjeta_roja.png">';
						$injustificadas_over='<a href="#modal_asistencia" onClick="ejecutar_ajax(\'asistencia/modal_asistencia.php\', \'sel_filtro_asis,hdn_asis_id_clase_'.$id_clase.',hdn_asis_id_subperiodo_evaluativo_'.$id_clase.$id_sub_eval.'\',\'modal_asistencia\')" onMouseOver="return overlib(\''.$detalle.'\', ABOVE, RIGHT);" onMouseOut="return nd();">'.$injustificadas_celda.'</a>';
						
						if($injustificadas!=0)$datos[$c][$pos_s]=$injustificadas_over;else $datos[$c][$pos_s]=$injustificadas_over;
						$suma_p_injustificadas=$suma_p_injustificadas+$injustificadas;
					
						
					$rs_s->MoveNext();
					}
					
					if($suma_p_injustificadas!=0)$injustificadas_p_celda='&nbsp;'.$suma_p_injustificadas.'&nbsp;<img width=5px src="../../../../img/acad/asistencia/tarjeta_roja.png">';else $injustificadas_p_celda=''; 
					$datos[$c][$pos_p]=$injustificadas_p_celda;
					
					$suma_l_injustificadas=$suma_l_injustificadas+$suma_p_injustificadas;
					
				$rs_p->MoveNext();
				}
				
				if($suma_l_injustificadas!=0)$injustificadas_l_celda='&nbsp;'.$suma_l_injustificadas.'&nbsp;<img width=5px src="../../../../img/acad/asistencia/tarjeta_roja.png">';else $injustificadas_l_celda=''; 
				$datos[$c][$pos_l]=$injustificadas_l_celda;
					
			$rs_l->MoveNext();
			}

		$rs_cla->MoveNext();
		}
		
		for($d=0;$d<count($datos);$d++){$data[$d]=$datos[$d];}
		
		$varios_arreglos=array();
		$varios_arreglos[0]=array('abv'=>$abv,'datos'=>$datos,'data'=>$data,'id_clase_inasistencia'=>$id_clase_inasistencia,'column'=>$column,'comment'=>$comment,'actividad'=>$actividad);//print count($data);

		return $varios_arreglos;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
}
?>
