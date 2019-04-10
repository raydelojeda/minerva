<?php
include("variables.php");
include($x."plantillas/mod_header.php");

if(isset($_GET["visualizar"]))
$visualizar=$_GET["visualizar"];
else
$visualizar='';

if(isset($_GET["mod"]))
$mod=$_GET["mod"];
else
{
	if(isset($_POST["var_aux"]))
	$mod=$_POST["var_aux"];
}
$id_datos_clinicos=$mod;
$s_rs=$obj->Consulta_llenar_cajas($mod,$insert_field,$tabla,$db,$columna,$insert_alias);

if(!$s_rs)
echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_".$elemento.".php?mensaje=Datos guardados satisfactoriamente.'</script>");


if(isset($_POST[$inputs[0]['name_input']]))
{
	$mensaje=$obj->Consulta_update($field_unico,$tabla,$field,$insert_field,$insert_alias,$name_input,$label_input,$db,$mod,$tipo_input,$value_input,$x);
	if(!$mensaje)
	echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_".$elemento.".php?mensaje=Datos guardados satisfactoriamente.'</script>");
}
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
&nbsp;
<br>

<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href='<?php print $x."js/tabs/css/luna/tab.css";?>'>
<script type="text/javascript" src='<?php print $x."js/tabs/js/tabpane.js";?>'></script>

<div style='margin: 0 auto;width:98%;'>
	<div class="tab-pane" id="tabPane1">
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Datos cl&iacute;nicos</h2>			

			<?php
			include("variables.php");
			$tipo_input[2]='select_1_valor';
			$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
			$combo_sql[2] = "select estudiante.id_estudiante as id_est, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as est 
			FROM persona, estudiante, datos_clinicos 
			WHERE persona.id_persona=estudiante.id_persona AND datos_clinicos.id_estudiante=estudiante.id_estudiante AND id_datos_clinicos='".$id_datos_clinicos."' ORDER BY primer_apellido";
			$obj->Generar_inputs($inputs,$s_rs,$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);
			?>
			
		</div>
	
		
		<div class="tab-page" id="tab_enfer" >
			<h2 class="tab">Enfermedades</h2>			
			
			
				<?php
				include($x."pag/acad/enfermedad_est/variables.php");
				$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);
				?>
				<div style=' padding-left:1%;'>
					<table style='border:1px solid;' id="toolbar" width="100%">
						<tbody>
							<tr>
								<td class="botonera_encabezado">
									<div style='text-align:center;'>
										<a class="toolbar" onclick="
											ok=validar_sin_submit('enfermedad','','Rselec','tuvo','','Rselec','tiene','','Rselec');
											if(ok==0)return false;									
											function haceAlgo(callbackPaso1)
											{callbackPaso1;}
											haceAlgo(ejecutar_ajax('guardar_enfermedad.php','est,enfermedad,tuvo,tiene,descripcion_enfer', 'div_enfermedades'));limpiar_campos(String('descripcion_enfer').split(','));" target="_self">
											
											<img id="guardar" border="0" width="16" height="16" name="guardar" alt="Guardar" src="<?php print $x;?>img/general/nuevo2.png">
											<br>
											Agregar
										</a>
									</div>
								</td>
								
								<td class="titulo_encabezado">
									Listado de enfermedades
								</td>
							</tr>
						</tbody>
					</table>					
				</div>

				<br>
				
				<div id='div_enfermedades'style='padding-left:1%;'>
					<?php
					$sql="SELECT id_enfermedad_est, enfermedad, tuvo, tiene, descripcion FROM enfermedad_est, n_enfermedad 
					WHERE enfermedad_est.id_enfermedad=n_enfermedad.id_enfermedad AND id_datos_clinicos='".$id_datos_clinicos."'";//print $sql;
					$rs=$db->Execute($sql) or die($db->ErrorMsg());
					
					?>
					
					<input name="hdn_datos_enfer_<?php print $id_datos_clinicos;?>" id="hdn_datos_enfer_<?php print $id_datos_clinicos;?>" value='<?php print $id_datos_clinicos;?>' type="hidden"/>
						
					<div class='tabla_listar' style='display:table;width:100%;align:center'>

						<div style='display:table-row;'class="encabezado_col">
							<div style='display:table-cell;height:22px;width:25%;text-align:left;padding-left: 5px;'>Enfermedad</div>
							<div style='display:table-cell;height:22px;width:10%;text-align:left;padding-left: 5px;'>Tuvo?</div>
							<div style='display:table-cell;height:22px;width:10%;text-align:left;padding-left: 5px;'>Tiene?</div>
							<div style='display:table-cell;height:22px;width:50%;text-align:left;'>Descripci&oacute;n</div>
							<div style='display:table-cell;height:22px;width:5%;text-align:center;'>&nbsp;</div>
						</div>
					<?php	
					for($e=0;$e<$rs->RecordCount();$e++) 
					{
						$id_enfermedad_est=$rs->fields['id_enfermedad_est'];
						$enfermedad=$rs->fields['enfermedad'];
						if($rs->fields['tuvo']==1)$tuvo='Si';else$tuvo='No';
						if($rs->fields['tiene']==1)$tiene='Si';else$tiene='No';
						$descripcion=$rs->fields['descripcion'];
					?>
						<input name="hdn_enfermedad_<?php print $id_enfermedad_est;?>" id="hdn_enfermedad_<?php print $id_enfermedad_est;?>" value='<?php print $id_enfermedad_est;?>' type="hidden"/>
						<div <?php if($e % 2) print "class='row1'";else print "class='row0'";?> style='display:table-row;'>
							<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $enfermedad;?></div>
							<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $tuvo;?></div>
							<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $tiene;?></div>
							<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $descripcion;?></div>
							<div style='display:table-cell;height:18px;text-align:center;padding-left: 5px;'>
								<a onClick="alertify.confirm('Confirma que desea eliminar la enfermedad?', function(e){if(e){ejecutar_ajax('eliminar_enfermedad.php','hdn_enfermedad_<?php print $id_enfermedad_est;?>, hdn_datos_enfer_<?php print $id_datos_clinicos;?>', 'div_enfermedades');}else {alertify.error('Has pulsado ' + alertify.labels.cancel);}});">
									<img width=13px src="<?php print $x;?>img/general/eliminar.png">
								</a>
							</div>
						</div>
					<?php
					$rs->MoveNext();
					}
					?>					
					</div>
				</div>
			
			
		</div>
		
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Alergias</h2>			
			
			
				<?php
				include($x."pag/acad/alergia_est/variables.php");
				$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);
				?>
				<div style=' padding-left:1%;'>
					<table style='border:1px solid;' id="toolbar" width="100%">
						<tbody>
							<tr>
								<td class="botonera_encabezado">
									<div style='text-align:center;'>
										<a class="toolbar" onclick="
											ok=validar_sin_submit('alergia','','Rselec','reaccion','','R');
											if(ok==0)return false;									
											function haceAlgo(callbackPaso1)
											{callbackPaso1;}
											haceAlgo(ejecutar_ajax('guardar_alergia.php','est,alergia,reaccion,descripcion_alergia', 'div_alergias'));limpiar_campos(String('descripcion_alergia, reaccion').split(','));" target="_self">
											
											<img id="guardar" border="0" width="16" height="16" name="guardar" alt="Guardar" src="<?php print $x;?>img/general/nuevo2.png">
											<br>
											Agregar
										</a>
									</div>
								</td>
								
								<td class="titulo_encabezado">
									Listado de alergias
								</td>
							</tr>
						</tbody>
					</table>					
				</div>

				<br>
				
				<div id='div_alergias'style='padding-left:1%;'>
					<?php
					$sql="SELECT id_alergia_est, alergia, reaccion, descripcion FROM alergia_est, n_alergia 
					WHERE alergia_est.id_alergia=n_alergia.id_alergia AND id_datos_clinicos='".$id_datos_clinicos."'";//print $sql_p;
					$rs=$db->Execute($sql) or die($db->ErrorMsg());
					
					?>
					<input name="hdn_datos_alergia_<?php print $id_datos_clinicos;?>" id="hdn_datos_alergia_<?php print $id_datos_clinicos;?>" value='<?php print $id_datos_clinicos;?>' type="hidden"/>
						
					<div class='tabla_listar' style='display:table;width:100%;align:center'>

						<div style='display:table-row;'class="encabezado_col">
							<div style='display:table-cell;height:22px;width:25%;text-align:left;padding-left: 5px;'>Alergia</div>
							<div style='display:table-cell;height:22px;width:20%;text-align:left;padding-left: 5px;'>Reacci&oacute;n</div>
							<div style='display:table-cell;height:22px;width:50%;text-align:left;'>Descripci&oacute;n</div>
							<div style='display:table-cell;height:22px;width:5%;text-align:center;'>&nbsp;</div>
						</div>
					<?php	
					for($e=0;$e<$rs->RecordCount();$e++) 
					{
						$id_alergia_est=$rs->fields['id_alergia_est'];
						$alergia=$rs->fields['alergia'];
						$reaccion=$rs->fields['reaccion'];
						$descripcion=$rs->fields['descripcion'];
					?>
						<input name="hdn_alergia_<?php print $id_alergia_est;?>" id="hdn_alergia_<?php print $id_alergia_est;?>" value='<?php print $id_alergia_est;?>' type="hidden"/>
						
						<div <?php if($e % 2) print "class='row1'";else print "class='row0'";?> style='display:table-row;'>
							<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $alergia;?></div>
							<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $reaccion;?></div>
							<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $descripcion;?></div>
							<div style='display:table-cell;height:18px;text-align:center;padding-left: 5px;'>
								<a onClick="alertify.confirm('Confirma que desea eliminar la alergia?', function(e){if(e){ejecutar_ajax('eliminar_alergia.php','hdn_alergia_<?php print $id_alergia_est;?>, hdn_datos_alergia_<?php print $id_datos_clinicos;?>', 'div_alergias');}else {alertify.error('Has pulsado ' + alertify.labels.cancel);}});">
									<img width=13px src="<?php print $x;?>img/general/eliminar.png">
								</a>
							</div>
						</div>
					<?php
					$rs->MoveNext();
					}
					?>					
					</div>
				</div>
			
			
		</div>
		
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Vacunas</h2>			
			
			
				<?php
				include($x."pag/acad/vacuna_est/variables.php");
				$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);
				?>
				<div style=' padding-left:1%;'>
					<table style='border:1px solid;' id="toolbar" width="100%">
						<tbody>
							<tr>
								<td class="botonera_encabezado">
									<div style='text-align:center;'>
										<a class="toolbar" onclick="
											ok=validar_sin_submit('vacuna','','Rselec','fecha_vac','','Rfecha');
											if(ok==0)return false;									
											function haceAlgo(callbackPaso1)
											{callbackPaso1;}
											haceAlgo(ejecutar_ajax('guardar_vacuna.php','est,vacuna,fecha_vac,descripcion_vacuna', 'div_vacunas'));limpiar_campos(String('descripcion_vacuna, fecha_vac').split(','));" target="_self">
											
											<img id="guardar" border="0" width="16" height="16" name="guardar" alt="Guardar" src="<?php print $x;?>img/general/nuevo2.png">
											<br>
											Agregar
										</a>
									</div>
								</td>
								
								<td class="titulo_encabezado">
									Listado de vacunas
								</td>
							</tr>
						</tbody>
					</table>					
				</div>

				<br>
				
				<div id='div_vacunas'style='padding-left:1%;'>
					<?php
					$sql="SELECT id_vacuna_est, vacuna, fecha, descripcion FROM vacuna_est, n_vacuna 
					WHERE vacuna_est.id_vacuna=n_vacuna.id_vacuna AND id_datos_clinicos='".$id_datos_clinicos."'";//print $sql;
					$rs=$db->Execute($sql) or die($db->ErrorMsg());
					
					?>
					<input name="hdn_datos_vacuna_<?php print $id_datos_clinicos;?>" id="hdn_datos_vacuna_<?php print $id_datos_clinicos;?>" value='<?php print $id_datos_clinicos;?>' type="hidden"/>
						
					<div class='tabla_listar' style='display:table;width:100%;align:center'>

						<div style='display:table-row;'class="encabezado_col">
							<div style='display:table-cell;height:22px;width:25%;text-align:left;padding-left: 5px;'>Vacuna</div>
							<div style='display:table-cell;height:22px;width:20%;text-align:left;padding-left: 5px;'>Fecha</div>
							<div style='display:table-cell;height:22px;width:50%;text-align:left;'>Descripci&oacute;n</div>
							<div style='display:table-cell;height:22px;width:5%;text-align:center;'>&nbsp;</div>
						</div>
					<?php	
					for($e=0;$e<$rs->RecordCount();$e++) 
					{
						$id_vacuna_est=$rs->fields['id_vacuna_est'];
						$vacuna=$rs->fields['vacuna'];
						$fecha=$rs->fields['fecha'];
						$descripcion=$rs->fields['descripcion'];
					?>
						<input name="hdn_vacuna_<?php print $id_vacuna_est;?>" id="hdn_vacuna_<?php print $id_vacuna_est;?>" value='<?php print $id_vacuna_est;?>' type="hidden"/>
						
						<div <?php if($e % 2) print "class='row1'";else print "class='row0'";?> style='display:table-row;'>
							<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $vacuna;?></div>
							<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $fecha;?></div>
							<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $descripcion;?></div>
							<div style='display:table-cell;height:18px;text-align:center;padding-left: 5px;'>
								<a onClick="alertify.confirm('Confirma que desea eliminar la vacuna?', function(e){if(e){ejecutar_ajax('eliminar_vacuna.php','hdn_vacuna_<?php print $id_vacuna_est;?>, hdn_datos_vacuna_<?php print $id_datos_clinicos;?>', 'div_vacunas');}else {alertify.error('Has pulsado ' + alertify.labels.cancel);}});">
									<img width=13px src="<?php print $x;?>img/general/eliminar.png">
								</a>
							</div>
						</div>
					<?php
					$rs->MoveNext();
					}
					?>					
					</div>
				</div>
			
			
		</div>
		
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Evaluaci&oacute;n nutricional</h2>			
			
			
				<?php
				include($x."pag/acad/eval_nutricional_est/variables.php");
				$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);
				?>
				<div style=' padding-left:1%;'>
					<table style='border:1px solid;' id="toolbar" width="100%">
						<tbody>
							<tr>
								<td class="botonera_encabezado">
									<div style='text-align:center;'>
										<a class="toolbar" onclick="
											ok=validar_sin_submit('altura','','R','peso','','R','fecha_eval','','Rfecha');
											if(ok==0)return false;									
											function haceAlgo(callbackPaso1)
											{callbackPaso1;}
											haceAlgo(ejecutar_ajax('guardar_evaluacion.php','est,altura,peso,fecha_eval', 'div_evaluaciones'));limpiar_campos(String('altura,peso,fecha_eval').split(','));" target="_self">
											
											<img id="guardar" border="0" width="16" height="16" name="guardar" alt="Guardar" src="<?php print $x;?>img/general/nuevo2.png">
											<br>
											Agregar
										</a>
									</div>
								</td>
								
								<td class="titulo_encabezado">
									Listado de evaluaci&oacute;n nutricional
								</td>
							</tr>
						</tbody>
					</table>					
				</div>

				<br>
				
				<div id='div_evaluaciones'style='padding-left:1%;'>
					<?php
					$sql="SELECT id_eval_nutricional_est, fecha, altura, peso FROM eval_nutricional_est 
					WHERE id_datos_clinicos='".$id_datos_clinicos."'";//print $sql_p;
					$rs=$db->Execute($sql) or die($db->ErrorMsg());
					
					?>
					<input name="hdn_datos_eval_<?php print $id_datos_clinicos;?>" id="hdn_datos_eval_<?php print $id_datos_clinicos;?>" value='<?php print $id_datos_clinicos;?>' type="hidden"/>
						
					<div class='tabla_listar' style='display:table;width:100%;align:center'>

						<div style='display:table-row;'class="encabezado_col">
							<div style='display:table-cell;height:22px;width:30%;text-align:left;padding-left: 5px;'>Altura</div>
							<div style='display:table-cell;height:22px;width:30%;text-align:left;padding-left: 5px;'>Peso</div>
							<div style='display:table-cell;height:22px;width:35%;text-align:left;'>Fecha</div>
							<div style='display:table-cell;height:22px;width:5%;text-align:center;'>&nbsp;</div>
						</div>
					<?php	
					for($e=0;$e<$rs->RecordCount();$e++) 
					{
						$id_eval_nutricional_est=$rs->fields['id_eval_nutricional_est'];
						$altura=$rs->fields['altura'];
						$peso=$rs->fields['peso'];
						$fecha=$rs->fields['fecha'];
					?>
						<input name="hdn_eval_<?php print $id_eval_nutricional_est;?>" id="hdn_eval_<?php print $id_eval_nutricional_est;?>" value='<?php print $id_eval_nutricional_est;?>' type="hidden"/>
						
						<div <?php if($e % 2) print "class='row1'";else print "class='row0'";?> style='display:table-row;'>
							<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $altura;?></div>
							<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $peso;?></div>
							<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $fecha;?></div>
							<div style='display:table-cell;height:18px;text-align:center;padding-left: 5px;'>
								<a onClick="alertify.confirm('Confirma que desea eliminar la evaluaci&oacute;n nutricional?', function(e){if(e){ejecutar_ajax('eliminar_evaluacion.php','hdn_eval_<?php print $id_eval_nutricional_est;?>, hdn_datos_eval_<?php print $id_datos_clinicos;?>', 'div_evaluaciones');}else {alertify.error('Has pulsado ' + alertify.labels.cancel);}});">
									<img width=13px src="<?php print $x;?>img/general/eliminar.png">
								</a>
							</div>
						</div>
					<?php
					$rs->MoveNext();
					}
					?>					
					</div>
				</div>
			
			
		</div>
		
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Evoluci&oacute;n</h2>			
			
			
				<?php
				include($x."pag/acad/evolucion_est/variables.php");
				$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);
				?>
				<div style=' padding-left:1%;'>
					<table style='border:1px solid;' id="toolbar" width="100%">
						<tbody>
							<tr>
								<td class="botonera_encabezado">
									<div style='text-align:center;'>
										<a class="toolbar" onclick="
											ok=validar_sin_submit('evolucion','','R','fecha_evol','','Rfecha');
											if(ok==0)return false;									
											function haceAlgo(callbackPaso1)
											{callbackPaso1;}
											haceAlgo(ejecutar_ajax('guardar_evolucion.php','est,evolucion,fecha_evol', 'div_evoluciones'));limpiar_campos(String('evolucion,fecha_evol').split(','));" target="_self">
											
											<img id="guardar" border="0" width="16" height="16" name="guardar" alt="Guardar" src="<?php print $x;?>img/general/nuevo2.png">
											<br>
											Agregar
										</a>
									</div>
								</td>
								
								<td class="titulo_encabezado">
									Listado de evoluci&oacute;n nutricional
								</td>
							</tr>
						</tbody>
					</table>					
				</div>

				<br>
				
				<div id='div_evoluciones'style='padding-left:1%;'>
					<?php
					$sql="SELECT id_evolucion_est, fecha, evolucion FROM evolucion_est 
					WHERE id_datos_clinicos='".$id_datos_clinicos."'";//print $sql_p;
					$rs=$db->Execute($sql) or die($db->ErrorMsg());
					
					?>
					<input name="hdn_datos_evol_<?php print $id_datos_clinicos;?>" id="hdn_datos_evol_<?php print $id_datos_clinicos;?>" value='<?php print $id_datos_clinicos;?>' type="hidden"/>
						
					<div class='tabla_listar' style='display:table;width:100%;align:center'>

						<div style='display:table-row;'class="encabezado_col">
							<div style='display:table-cell;height:22px;width:70%;text-align:left;padding-left: 5px;'>Evoluci&oacute;n</div>
							<div style='display:table-cell;height:22px;width:25%;text-align:left;'>Fecha</div>
							<div style='display:table-cell;height:22px;width:5%;text-align:center;'>&nbsp;</div>
						</div>
					<?php	
					for($e=0;$e<$rs->RecordCount();$e++) 
					{
						$id_evolucion_est=$rs->fields['id_evolucion_est'];
						$evolucion=$rs->fields['evolucion'];
						$fecha=$rs->fields['fecha'];
					?>
						<input name="hdn_evol_<?php print $id_evolucion_est;?>" id="hdn_evol_<?php print $id_evolucion_est;?>" value='<?php print $id_evolucion_est;?>' type="hidden"/>
						
						<div <?php if($e % 2) print "class='row1'";else print "class='row0'";?> style='display:table-row;'>
							<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $evolucion;?></div>
							<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $fecha;?></div>
							<div style='display:table-cell;height:18px;text-align:center;padding-left: 5px;'>
								<a onClick="alertify.confirm('Confirma que desea eliminar la evoluci&oacute;n?', function(e){if(e){ejecutar_ajax('eliminar_evolucion.php','hdn_evol_<?php print $id_evolucion_est;?>, hdn_datos_evol_<?php print $id_datos_clinicos;?>', 'div_evoluciones');}else {alertify.error('Has pulsado ' + alertify.labels.cancel);}});">
									<img width=13px src="<?php print $x;?>img/general/eliminar.png">
								</a>
							</div>
						</div>
					<?php
					$rs->MoveNext();
					}
					?>					
					</div>
				</div>
			
			
		</div>
				
			
		
	</div>
</div>
<br>
<script type="text/javascript">setupAllTabs();</script><!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/mod_footer.php");
?>