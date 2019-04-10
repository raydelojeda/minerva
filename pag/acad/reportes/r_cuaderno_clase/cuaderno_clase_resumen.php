<?php
class cuaderno_clase_resumen
{
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function pestana_resumen($db)
	{
?>
		<div class="tab-page">
			<h2 class="tab">Resumen anual</h2>
			<div class="tab-pane" id="tabPane1">		
				<?php				
					$this->filtro_resumen($db);
				?>		
		
				<div style='display:table;width:100%;margin-left:auto;margin-right:auto;' id='contenido_grid_resumen'>				
					<?php
						//$tihs->contenido_resumen($db, '');
					?>
				</div>
			</div>
		</div>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function filtro_resumen($db)
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
									$parametros_extras="onChange=\"ejecutar_ajax('resumen/actualizar_grid.php', 'sel_filtro_resum', 'contenido_grid_resumen');\"";
									$this->select_filtro_resum($parametros_extras, $rs_est);
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
	function select_filtro_resum($parametros_extras, $rs_est)
	{
?>
		Resumen del estudiante: <select name="sel_filtro_resum" class="sel_filtro_resum" title="Filtro" id="sel_filtro_resum" <?php print $parametros_extras;?>>
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
	function contenido_resumen($db, $id_estudiante)
	{
		include_once("../../../clases_acad.php");
		$clases_acad = new clases_acad();
		
		$varios_arreglos=$this->consulta_est_resumen($db, $id_estudiante);
		
		$anno_lectivo=$varios_arreglos[0]['anno_lectivo'];
		$categorias=$varios_arreglos[0]['categorias'];
	
		$sql_nota="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_academica WHERE activa='1'";//print $sql_nota.'<br>';
		$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
		
		$nota_minima=$rs_nota->fields['nota_minima'];
		$nota_aprobado=$rs_nota->fields['nota_aprobado'];
		$nota_maxima=$rs_nota->fields['nota_maxima'];
		
		$datos_est=$clases_acad->datos_estudiante($db, $id_estudiante);
		
		$promedio_total=$clases_acad->calcular_prom_general($db, $id_estudiante);
		$promedio_total=number_format(round($promedio_total,2), 2, ".", "");
		
		$inasistencia_x_asignaturas=$clases_acad->calcular_inasis_x_est($db, $id_estudiante);
		
		$suma_atrasos=$inasistencia_x_asignaturas['atrasos'];
		$suma_justificadas=$inasistencia_x_asignaturas['justificadas'];
		$suma_injustificadas=$inasistencia_x_asignaturas['injustificadas'];//$clases_acad->calcular_inasistencia_total($inasistencia_asig);
		
		$comportamiento=$clases_acad->consulta_nota_comportamental($db, $id_estudiante);//print $comportamiento;
		$comportamiento=$clases_acad->equivalente_comportamental($db, $comportamiento);
		if($comportamiento=='')$comportamiento='-';
		//$comportamiento=number_format(round($comportamiento,2), 2, ".", "");
?>
		<div style='display:table-row;'>		
			<div style='display:table-cell;width:100%;text-align:left;padding-left:1%;'>
		
				<div style='display:table;width:100%;'>
					<div style='display:table-row;'>		
						<div style='display:table-cell;width:50%;text-align:left;padding-left:1%;'>
					
							<div class='tabla_filtro' style='display:table;width:100%;border:1px solid #DDD;'>
								<div style='display:table-row;height:20px;'>		
									<div style='display:table-cell;width:20%;text-align:right;'>
										Curso:
									</div>
									
									<div style='display:table-cell;width:80%;text-align:left;'>
										<?php print '&nbsp;'.$datos_est['curso'];?>
									</div>
								</div>
								
								<div style='display:table-row;height:20px;'>		
									<div style='display:table-cell;width:20%;text-align:right;'>
										Paralelo:
									</div>
									
									<div style='display:table-cell;width:80%;text-align:left;'>
										<?php print '&nbsp;'.$datos_est['paralelo'];?>
									</div>
								</div>
								
								<div style='display:table-row;height:20px;'>		
									<div style='display:table-cell;width:20%;text-align:right;'>
										Tutor:
									</div>
									
									<div style='display:table-cell;width:80%;text-align:left;'>
										<?php print '&nbsp;'.$datos_est['tutor'].' ('.$datos_est['email_tut'].')';?>
									</div>
								</div>
								
								<div style='display:table-row;height:20px;'>		
									<div style='display:table-cell;width:20%;text-align:right;'>
										Inspector:
									</div>
									
									<div style='display:table-cell;width:80%;text-align:left;'>
										<?php print '&nbsp;'.$datos_est['inspector'].' ('.$datos_est['email_insp'].')';?>
									</div>
								</div>
								
								<div style='display:table-row;height:20px;'>		
									<div style='display:table-cell;width:20%;text-align:right;'>
										Psic&oacute;logo:
									</div>
									
									<div style='display:table-cell;width:80%;text-align:left;'>
										<?php print '&nbsp;'.$datos_est['psicologo'].' ('.$datos_est['email_psi'].')';?>
									</div>
								</div>
							</div>
							
						</div>
						
						<div  style='display:table-cell;width:50%;text-align:left;padding:1%;'>
							
							<div class='tabla_filtro' style='display:table;width:100%;border:1px solid #DDD;'>
								<div style='display:table-row;height:20px;'>		
									<div style='display:table-cell;width:30%;text-align:right;'>
										Promedio:
									</div>
									
									<div style='display:table-cell;width:70%;text-align:left;'>
										<?php print '&nbsp;'.$promedio_total;?>
									</div>
								</div>
								
								<div style='display:table-row;height:20px;'>		
									<div style='display:table-cell;width:30%;text-align:right;'>
										Atrasos:
									</div>
									
									<div style='display:table-cell;width:70%;text-align:left;'>
										<?php print '&nbsp;'.$suma_atrasos;?>
									</div>
								</div>
								
								<div style='display:table-row;height:20px;'>		
									<div style='display:table-cell;width:30%;text-align:right;'>
										Faltas justificadas:
									</div>
									
									<div style='display:table-cell;width:70%;text-align:left;'>
										<?php print '&nbsp;'.$suma_justificadas;?>
									</div>
								</div>
								
								<div style='display:table-row;height:20px;'>		
									<div style='display:table-cell;width:30%;text-align:right;'>
										Faltas injustificadas:
									</div>
									
									<div style='display:table-cell;width:70%;text-align:left;'>
										<?php print '&nbsp;'.$suma_injustificadas;?>
									</div>
								</div>
								
								<div style='display:table-row;height:20px;'>		
									<div style='display:table-cell;width:30%;text-align:right;'>
										Comportamiento:
									</div>
									
									<div style='display:table-cell;width:70%;text-align:left;'>
										<?php print '&nbsp;'.$comportamiento;?>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				
			</div>
		</div>
			
		<?php //for($d=0;$d<count($anno_lectivo);$d++){if($d==0)print $anno_lectivo[$d];else print ','.$anno_lectivo[$d];}?>
			
		<style type="text/css">
			${demo.css}
		</style>
		<script type="text/javascript">
			$(function () {
				$('#container_graf').highcharts({
					title: {
						text: 'Resumen anual'
					},
					xAxis: {categories: [<?php for($d=0;$d<count($categorias);$d++){if($d==0)print '"'.$categorias[$d].'"';else print ',"'.$categorias[$d].'"';}?>]},
					
					yAxis: {
						min: 0,
						max: 10,
						title:{text: 'Nota'}
					},
				   
					series: [{
						type: 'column',
						color:  'black',
						name: 'Nota',
						data: [<?php for($d=0;$d<count($anno_lectivo);$d++){if($d==0){if($anno_lectivo[$d]=='')print '0';else print $anno_lectivo[$d];}else {if($anno_lectivo[$d]=='')print ',0';else print ','.$anno_lectivo[$d];}}?>]
					}, {
						color: 'red',
						type: 'spline',
						name: 'Aprobado',
						data: [<?php for($d=0;$d<count($anno_lectivo);$d++){if($d==0)print $nota_aprobado;else print ','.$nota_aprobado;}?>],
						marker: {
							enabled: false
						},
					},],					
					
					legend:{enabled: false},					
				});
			});
		</script>
		
		<br>
		
		<div style='display:table-row;'>		
			<div style='display:table-cell;width:90%;text-align:left;padding-left:1%;'>
		
				<div style='display:table;width:100%;'>
					<div style='display:table-row;'>
						<div style='display:table-cell;width:100%;text-align:center;'>
							<div style='width:100%;height:300px;text-align:center;' id="container_graf"></div>
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
	function consulta_est_resumen($db, $id_estudiante)
	{
		include_once("../../../clases_acad.php");
		$clases_acad = new clases_acad();
		
		$datos[0][0]='';
		$actividad[0]='';
		$id[0]='';
		$abv[0]='';
		$column[0]='';
		$comment='';
		$anno_lectivo='';
		$categorias='';
		
		$sql_nota="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_academica WHERE activa='1'";//print $sql_nota.'<br>';
		$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
		
		$nota_minima=$rs_nota->fields['nota_minima'];
		$nota_aprobado=$rs_nota->fields['nota_aprobado'];
		$nota_maxima=$rs_nota->fields['nota_maxima'];
		
		$varios_arreglos=$clases_acad->encabezado_l($db);
		
		$id_encab=$varios_arreglos[0]['id_encab'];		
		$tipo=$varios_arreglos[0]['tipo'];
		$position=$varios_arreglos[0]['position'];

		$sql_cla="SELECT clase.id_clase as id_clase, clase.peso AS peso_clase, clase_estudiante.id_clase_estudiante, clase.id_asignatura as id_asignatura, concat(abreviatura,' - ',asignatura) as asignatura, n_asignatura.foto, clase.nombre as nombre, referencia as referencia, 
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
		AND aporta_promedio='1'
		AND cuantitativa='1'
		AND estudiante.id_estudiante='".$id_estudiante."'
		AND usuario='".$_SESSION['user']."' ORDER BY codigo_unico ASC";//print $sql_cla.'<br>';
		$rs_cla=$db->Execute($sql_cla) or die($db->ErrorMsg());
		
		$rs_cla->MoveFirst();		
		for($c=0;$c<$rs_cla->RecordCount();$c++)
		{
			$promedio=array();
			$id_clase=$rs_cla->fields['id_clase'];
			$id_asignatura=$rs_cla->fields['id_asignatura'];
			$id_clase_estudiante=$rs_cla->fields['id_clase_estudiante'];

			$categorias[$c]=$rs_cla->fields['nombre'].' ('.$rs_cla->fields['peso_clase'].'%)';

			//--------------------------------------------------------------------------------------------------------------------
			for($h=1;$h<=count($position);$h++)
			{					
				if($tipo[$position[$h]]=='l')
				{
					$promedio_l=$clases_acad->calcular_prom_lectivo($db, $id_clase_estudiante, $id_encab[$position[$h]]);//print 'examen_periodo: '.$promedio_l['promedio'].'<br>';
					//$nota='<a ';if($promedio_l['promedio']<$nota_aprobado)$nota.='style="color:red;" '; $nota.='>&nbsp;&nbsp;'.$promedio_l['promedio'].'&nbsp;&nbsp;</a>';
					$promedio[$c]=$promedio_l['promedio'];
				}
			}
			//--------------------------------------------------------------------------------------------------------------------
			
			if(count($promedio)!=0)$anno_lectivo[$c]=array_sum($promedio)/count($promedio);
			
		$rs_cla->MoveNext();
		}

		$varios_arreglos=array();
		$varios_arreglos[0]=array('anno_lectivo'=>$anno_lectivo,'categorias'=>$categorias);//print count($data);

		return $varios_arreglos;
	}
	
}
?>
