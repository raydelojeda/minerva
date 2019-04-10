<?php
include("variables.php");
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)

if(isset($_POST['est']))
{
	if($_POST['est']!='no')
	{
		$sql_datos_clinicos="SELECT id_datos_clinicos FROM datos_clinicos WHERE id_estudiante='".$_POST['est']."'";//print $sql_p;
		$rs_datos_clinicos=$db->Execute($sql_datos_clinicos) or die($db->ErrorMsg());//print $rs_p;
		
		$id_datos_clinicos=$rs_datos_clinicos->fields['id_datos_clinicos'];
		
		$mensaje=$obj->Consulta_update($field_unico,$tabla,$field,$insert_field,$insert_alias,$name_input,$label_input,$db,$id_datos_clinicos,$tipo_input,$value_input,$x);//print $mensaje;
		if($mensaje=='')$mensaje='Datos guardados satisfactoriamente.';
		
		//echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='../cargo_empleado/new_cargo_empleado.php'</script>");
	}
	else
	$mensaje='Debe escoger un estudiante.';
}
else
$mensaje='Debe escoger un estudiante.';

$obj->Imprimir_mensaje($mensaje);
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
			$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'',$visualizar);
			?>
			
		</div>
	
		
		<div class="tab-page" id="tab_enfer" >
			<h2 class="tab">Enfermedades</h2>			
			
			<div id="datos_clinicos1" style='display:none;'>
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
				
				</div>
			</div>
			
		</div>
		
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Alergias</h2>			
			
			<div id="datos_clinicos2" style='display:none;'>
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
					
				</div>
			</div>
			
		</div>
		
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Vacunas</h2>			
			
			<div id="datos_clinicos3" style='display:none;'>
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
				
				</div>
			</div>
			
		</div>
		
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Evaluaci&oacute;n nutricional</h2>			
			
			<div id="datos_clinicos4" style='display:none;'>
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
				
				</div>
			</div>
			
		</div>
		
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Evoluci&oacute;n</h2>			
			
			<div id="datos_clinicos5" style='display:none;'>
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
					
				</div>
			</div>
			
		</div>
				
			
		
	</div>
</div>
<br>
<script type="text/javascript">setupAllTabs();</script>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
$obj->Imprimir_mensaje($mensaje);

include($x."plantillas/new_footer.php");
?>