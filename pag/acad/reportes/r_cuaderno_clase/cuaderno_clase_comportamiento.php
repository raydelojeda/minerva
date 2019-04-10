<?php
class cuaderno_clase_comportamiento
{
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function pestana_comportamiento($db)
	{
?>
		<div class="tab-page">
			<h2 class="tab">Comportamiento</h2>
			<div class="tab-pane" id="tabPane1">		
				<?php				
					$this->filtro_comportamiento($db);
				?>				
			
				
				<div style='display:table;width:100%;margin:0;'>
					<div style='display:table-row;'>			
						<div style='display:table-cell;width:50%;text-align:left;vertical-align:top;'>
							
							<div style='display:table;width:100%;margin-left:0;' id='contenido_grid_comportamiento'>				
								
							</div>
						
						</div>
						
						<div style='display:table-cell;width:50%;height:20px;text-align:left;vertical-align:top;'id='div_comportamiento'>
						
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
	function filtro_comportamiento($db)
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
									$parametros_extras="onChange=\"div_comportamiento.innerHTML='';ejecutar_ajax('comportamiento/actualizar_grid.php', 'sel_filtro_comp', 'contenido_grid_comportamiento');\"";
									$this->select_filtro_comp($parametros_extras, $rs_est);
									
									$msg_comp='Ud. puede dar clic en cada parcial y clase para ver las obervaciones planteadas.';
								?>
								&nbsp;<a onMouseOver="return overlib('<?php print $msg_comp;?>', ABOVE, RIGHT);"onMouseOut="return nd();"><img src='../../../../img/general/help.png'></a>
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
	function select_filtro_comp($parametros_extras, $rs_est)
	{
?>
		Comportamiento del estudiante: <select name="sel_filtro_comp" class="sel_filtro_comp" title="Filtro" id="sel_filtro_comp" <?php print $parametros_extras;?>>
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
	function contenido_comportamiento($db, $id_estudiante)
	{
		$varios_arreglos=$this->consulta_est_comportamiento($db, $id_estudiante);
		
		$datos=$varios_arreglos[0]['datos'];
		$data=$varios_arreglos[0]['data'];
		$column=$varios_arreglos[0]['column'];
		$abv=$varios_arreglos[0]['abv'];
		$actividad=$varios_arreglos[0]['actividad'];
		$comment=$varios_arreglos[0]['comment'];
		$width=300+count($actividad)*50;
?>
		<div style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
				
					<div id="container">
						<div class="columnLayout">
							<div class="rowLayout">
								<div class="descLayout">
									<div class="pad">
										<div id="msg_comp" style='float:right;'></div>
										<div id="grid_comportamiento" style="width: <?php print $width;?>px; height: 50%; overflow: hidden1;"></div>
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
									
									var $container = $("#grid_comportamiento"),
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
	function consulta_est_comportamiento($db, $id_estudiante)
	{
		include("../../../clases_acad.php");
		$clases_acad = new clases_acad();
		
		$datos[0][0]='';
		$actividad[0]='';
		$id[0]='';
		$abv[0]='';
		$column[0]='';
		$comment='';
		
		$sql_nota="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_conductual WHERE activa='1'";//print $sql_nota.'<br>';
		$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
		
		$nota_minima=$rs_nota->fields['nota_minima'];
		$nota_aprobado=$rs_nota->fields['nota_aprobado'];
		$nota_maxima=$rs_nota->fields['nota_maxima'];
		
		$varios_arreglos=$this->encabezado($db);
		
		$id=$varios_arreglos[0]['id'];
		$id_encab=$varios_arreglos[0]['id_encab'];
		$tipo_id=$varios_arreglos[0]['tipo_id'];
		$position_id=$varios_arreglos[0]['position_id'];
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

		$sql_cla="SELECT clase.id_clase as id_clase, clase_estudiante.id_clase_estudiante, clase.id_asignatura as id_asignatura, concat(abreviatura,' - ',asignatura) as asignatura, n_asignatura.foto, clase.nombre as nombre, referencia as referencia, 
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
		AND usuario='".$_SESSION['user']."' ORDER BY nombre ASC";//print $sql_cla;
		$rs_cla=$db->Execute($sql_cla) or die($db->ErrorMsg());
		
		$extra=$rs_cla->RecordCount();
		$datos[$extra][0]='Tutor';$datos[$extra+1][0]='Inspector';
		$id_curso_grado_paralelo_est=$rs_cla->fields['id_curso_grado_paralelo_est'];
			
		$rs_cla->MoveFirst();		
		for($c=0;$c<$rs_cla->RecordCount();$c++)
		{
			$id_clase=$rs_cla->fields['id_clase'];
			$id_asignatura=$rs_cla->fields['id_asignatura'];
			$id_clase_estudiante=$rs_cla->fields['id_clase_estudiante'];
			?>					
			<input name="hdn_comp_id_clase_<?php print $id_clase;?>" id="hdn_comp_id_clase_<?php print $id_clase;?>" type="hidden" value="<?php print $id_clase;?>"/>
			<?php
			$clase='<a onMouseOver="return overlib(\''.'<b>Profesor:</b> '.$rs_cla->fields['empleado_academico'].'<br>'.$rs_cla->fields['asignatura'].'<br>'.$rs_cla->fields['referencia'].'\', ABOVE, RIGHT);"onMouseOut="return nd();">'.$rs_cla->fields['nombre'].'</a>';
			$datos[$c][0]=$clase;
			
			$pos=0;
			$examen_periodo='';
			//--------------------------------------------------------------------------------------------------------------------
			for($h=1;$h<=count($position);$h++)
			{
				if($tipo[$position[$h]]=='l')
				{
					$nota_comportamental_lec=$clases_acad->consulta_nota_comportamental_lec($db, $id_clase_estudiante, $id_encab[$position[$h]]);						
					$nota_cualitativa=$clases_acad->equivalente_comportamental($db, $nota_comportamental_lec);
					
					$nota='<a ';if($nota_comportamental_lec<$nota_aprobado)$nota.='style="color:red;text-align:center;" '; $nota.=' onClick=\'div_comportamiento.innerHTML="";\'>&nbsp;&nbsp;'.$nota_cualitativa.'&nbsp;&nbsp;</a>';
					$datos[$c][$position[$h]]=$nota;
				}
				
				if($tipo[$position[$h]]=='p')
				{
					$nota_comportamental_per=$clases_acad->consulta_nota_comportamental_per($db, $id_clase_estudiante, $id_encab[$position[$h]]);						
					$nota_cualitativa=$clases_acad->equivalente_comportamental($db, $nota_comportamental_per);
					
					$nota='<a ';if($nota_comportamental_per<$nota_aprobado)$nota.='style="color:red;text-align:center;" '; $nota.=' onClick=\'div_comportamiento.innerHTML="";\'>&nbsp;&nbsp;'.$nota_cualitativa.'&nbsp;&nbsp;</a>';
					$datos[$c][$position[$h]]=$nota;
				}
				
				if($tipo[$position[$h]]=='s')
				{
					$id_sub_eval=$id_encab[$position[$h]];
					?>					
					<input name="hdn_comp_id_subperiodo_evaluativo_<?php print $id_clase.$id_sub_eval;?>" id="hdn_comp_id_subperiodo_evaluativo_<?php print $id_clase.$id_sub_eval;?>" type="hidden" value="<?php print $id_sub_eval;?>"/>
					<?php
					$nota_comportamental_sub=$clases_acad->consulta_nota_comportamental_sub($db, $id_clase_estudiante, $id_encab[$position[$h]]);						
					$nota_cualitativa=$clases_acad->equivalente_comportamental($db, $nota_comportamental_sub);
					
					$nota='<a ';if($nota_comportamental_sub<$nota_aprobado)$nota.='style="color:red;text-align:center;" '; $nota.=' onClick="ejecutar_ajax(\'comportamiento/mostrar_obs_comportamiento.php\', \'hdn_comp_id_clase_'.$id_clase.', hdn_comp_id_subperiodo_evaluativo_'.$id_clase.$id_sub_eval.', sel_filtro_comp\',\'div_comportamiento\')">&nbsp;&nbsp;&nbsp;&nbsp;'.$nota_cualitativa.'&nbsp;&nbsp;&nbsp;&nbsp;</a>';
					$datos[$c][$position[$h]]=$nota;
				}
			}						
			//--------------------------------------------------------------------------------------------------------------------		
		$rs_cla->MoveNext();
		}
		if($rs_cla->RecordCount()>0)
		{
			for($c=$extra;$c<$extra+2;$c++)
			{
				if($c==$extra)//tutor
				{
					for($h=1;$h<=count($position);$h++)
					{
						if($tipo[$position[$h]]=='l')
						{
							$nota_comportamental_lec=$clases_acad->consulta_nota_comportamental_lec_tutor($db, $id_curso_grado_paralelo_est, $id_encab[$position[$h]]);						
							$nota_cualitativa=$clases_acad->equivalente_comportamental($db, $nota_comportamental_lec);
							
							$nota='<a ';if($nota_comportamental_lec<$nota_aprobado)$nota.='style="color:red;text-align:center;" '; $nota.=' onClick=\'div_comportamiento.innerHTML="";\'>&nbsp;&nbsp;'.$nota_cualitativa.'&nbsp;&nbsp;</a>';
							$datos[$c][$position[$h]]=$nota;
						}
						
						if($tipo[$position[$h]]=='p')
						{
							$nota_comportamental_per=$clases_acad->consulta_nota_comportamental_periodo_tutor($db, $id_curso_grado_paralelo_est, $id_encab[$position[$h]]);						
							$nota_cualitativa=$clases_acad->equivalente_comportamental($db, $nota_comportamental_per);
							
							$nota='<a ';if($nota_comportamental_per<$nota_aprobado)$nota.='style="color:red;text-align:center;" '; $nota.=' onClick=\'div_comportamiento.innerHTML="";\'>&nbsp;&nbsp;'.$nota_cualitativa.'&nbsp;&nbsp;</a>';
							$datos[$c][$position[$h]]=$nota;
						}
						
						if($tipo[$position[$h]]=='s')
						{
							$id_sub_eval=$id_encab[$position[$h]];
							?>					
							<input name="hdn_comp_id_subperiodo_evaluativo_tutor" id="hdn_comp_id_subperiodo_evaluativo_tutor" type="hidden" value="<?php print $id_sub_eval;?>"/>
							<?php
							$nota_comportamental_sub=$clases_acad->consulta_nota_comportamental_subperiodo_tutor($db, $id_curso_grado_paralelo_est, $id_encab[$position[$h]]);						
							$nota_cualitativa=$clases_acad->equivalente_comportamental($db, $nota_comportamental_sub);
							
							$nota='<a ';if($nota_comportamental_sub<$nota_aprobado)$nota.='style="color:red;text-align:center;" '; $nota.=' onClick="ejecutar_ajax(\'comportamiento/mostrar_obs_comportamiento_tutor.php\', \'hdn_comp_id_clase_'.$id_clase.', hdn_comp_id_subperiodo_evaluativo_'.$id_clase.$id_sub_eval.', sel_filtro_comp\',\'div_comportamiento\')">&nbsp;&nbsp;&nbsp;&nbsp;'.$nota_cualitativa.'&nbsp;&nbsp;&nbsp;&nbsp;</a>';
							$datos[$c][$position[$h]]=$nota;
						}
					}
				}
				else//inspector
				{
					for($h=1;$h<=count($position);$h++)
					{
						if($tipo[$position[$h]]=='l')
						{
							$nota_comportamental_lec=$clases_acad->consulta_nota_comportamental_lec_inspector($db, $id_curso_grado_paralelo_est, $id_encab[$position[$h]]);						
							$nota_cualitativa=$clases_acad->equivalente_comportamental($db, $nota_comportamental_lec);
							
							$nota='<a ';if($nota_comportamental_lec<$nota_aprobado)$nota.='style="color:red;text-align:center;" '; $nota.=' onClick=\'div_comportamiento.innerHTML="";\'>&nbsp;&nbsp;'.$nota_cualitativa.'&nbsp;&nbsp;</a>';
							$datos[$c][$position[$h]]=$nota;
						}
						
						if($tipo[$position[$h]]=='p')
						{
							$nota_comportamental_per=$clases_acad->consulta_nota_comportamental_periodo_inspector($db, $id_curso_grado_paralelo_est, $id_encab[$position[$h]]);						
							$nota_cualitativa=$clases_acad->equivalente_comportamental($db, $nota_comportamental_per);
							
							$nota='<a ';if($nota_comportamental_per<$nota_aprobado)$nota.='style="color:red;text-align:center;" '; $nota.=' onClick=\'div_comportamiento.innerHTML="";\'>&nbsp;&nbsp;'.$nota_cualitativa.'&nbsp;&nbsp;</a>';
							$datos[$c][$position[$h]]=$nota;
						}
						
						if($tipo[$position[$h]]=='s')
						{
							$id_sub_eval=$id_encab[$position[$h]];
							?>					
							<input name="hdn_comp_id_subperiodo_evaluativo_tutor" id="hdn_comp_id_subperiodo_evaluativo_tutor" type="hidden" value="<?php print $id_sub_eval;?>"/>
							<?php
							$nota_comportamental_sub=$clases_acad->consulta_nota_comportamental_subperiodo_inspector($db, $id_curso_grado_paralelo_est, $id_encab[$position[$h]]);						
							$nota_cualitativa=$clases_acad->equivalente_comportamental($db, $nota_comportamental_sub);
							
							$nota='<a ';if($nota_comportamental_sub<$nota_aprobado)$nota.='style="color:red;text-align:center;" '; $nota.=' onClick="ejecutar_ajax(\'comportamiento/mostrar_obs_comportamiento_inspector.php\', \'hdn_comp_id_clase_'.$id_clase.', hdn_comp_id_subperiodo_evaluativo_'.$id_clase.$id_sub_eval.', sel_filtro_comp\',\'div_comportamiento\')">&nbsp;&nbsp;&nbsp;&nbsp;'.$nota_cualitativa.'&nbsp;&nbsp;&nbsp;&nbsp;</a>';
							$datos[$c][$position[$h]]=$nota;
						}
					}
				}
			}
		}
		
		for($d=0;$d<count($datos);$d++){$data[$d]=$datos[$d];}
		
		$varios_arreglos=array();
		$varios_arreglos[0]=array('abv'=>$abv,'datos'=>$datos,'data'=>$data,'column'=>$column,'comment'=>$comment,'actividad'=>$actividad);//print count($data);

		return $varios_arreglos;
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
			$column[$pos]=',{format: "0.00",type: "numeric", className: "htCenter", allowInvalid: false,readOnly: true, renderer: "html"}';
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
				$column[$pos]=',{format: "0.00",type: "numeric", className: "htCenter", allowInvalid: false,readOnly: true, comment: false, renderer: "html"}';
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
					$column[$pos]=',{format: "0.00",type: "numeric", className: "htCenter", allowInvalid: false, readOnly: true, renderer: "html"}';						
					$tipo[$pos]='s';
					$position[$pos]=$pos;
					$id_encab[$pos]=$rs_s->fields['id_subperiodo_evaluativo'];
					
					
					$position_id[$pos_id]=$pos_id;
					$id[$pos_id]=$rs_s->fields['id_subperiodo_evaluativo'];
					$tipo_id[$pos_id]='s';//print '  mi pos1: '.$pos_id;
					$pos_id=$pos_id+1;
					
				$rs_s->MoveNext();
				}
			$rs_p->MoveNext();
			}
		$rs_l->MoveNext();
		}
	
		$varios_arreglos=array();
		$varios_arreglos[0]=array('id'=>$id, 'id_encab'=>$id_encab, 'actividad'=>$actividad, 'abv'=>$abv, 'column'=>$column, 'tipo'=>$tipo, 'tipo_id'=>$tipo_id, 'position'=>$position, 'position_id'=>$position_id);//print count($data);

		return $varios_arreglos;
	}
}
?>
