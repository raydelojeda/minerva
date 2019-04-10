<?php
include("variables.php");
include($x."plantillas/new_header_barra.php");

$competencia='';
$criterio='';
$ponderacion='';
$cod_evaluacion='';
$cadena_id_evaluacion='';
$id_evaluacion_ant='';
$cadena_id_ponderacion='';
$id_ponderacion_ant='';
$id_cargo='';

$hoy=date("Y-m-d");
$sql_p="SELECT id_periodo, concat(fecha_ini,'/',fecha_fin) AS periodo FROM n_periodo WHERE fecha_conclusion>='".$hoy."' ORDER BY fecha_ini DESC";
$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());

if(isset($_POST['var_aux']))
{
	if($_POST['var_aux']!='')
	{
		/*$i_sql="INSERT INTO compromiso (compromiso, fecha) 
		VALUES ('---AÚN FALTA LLENAR EL COMPROMISO POR EL EVALUADO Y TALENTO HUMANO.---','')";//print $i_sql."<br>";
		$db->Execute($i_sql) or die($db->ErrorMsg());
		
		$sql_c="SELECT MAX(id_compromiso) AS id_compromiso FROM compromiso";
		$rs_c=$db->Execute($sql_c) or die($db->ErrorMsg());
		
		$id_compromiso=$rs_c->fields['id_compromiso'];*/
		
		
		
		$sql_des="SELECT id_desempeno FROM desempeno WHERE id_periodo='".$rs_p->fields['id_periodo']."' AND id_empleado='".$_POST['sel_empleado']."'";
		$rs_des=$db->Execute($sql_des) or die($db->ErrorMsg());
		
		if(!isset($rs_des->fields['id_desempeno']))
		{
		
			$sql_comp="SELECT distinct comp_cri_eval.id_competencia FROM n_cargo, n_competencia, comp_cri_eval, cargo_comp WHERE n_competencia.id_competencia=comp_cri_eval.id_competencia 
			AND cargo_comp.id_cargo=n_cargo.id_cargo AND cargo_comp.id_competencia=n_competencia.id_competencia  AND n_cargo.id_cargo='".$_POST['id_cargo']."' ORDER BY competencia";
			$rs_comp=$db->Execute($sql_comp) or die($db->ErrorMsg());//print $rs_comp;die();
			
			for($comp=0;$comp<$rs_comp->RecordCount();$comp++)
			{
				$id_competencia=$rs_comp->fields['id_competencia'];
				
				//----------------------------------------------------------------------------------------------
				//----------------------------------------------------------------------------------------------
				//----------------------------------------------------------------------------------------------
				$i_sql="INSERT INTO compromiso (compromiso, id_competencia) 
				VALUES ('---LLENAR EL COMPROMISO SI ES NECESARIO.---','".$id_competencia."')";//print $i_sql."<br>";
				$db->Execute($i_sql) or die($db->ErrorMsg());
				
				$sql_c="SELECT MAX(id_compromiso) AS id_compromiso FROM compromiso";
				$rs_c=$db->Execute($sql_c) or die($db->ErrorMsg());
				
				$id_compromiso=$rs_c->fields['id_compromiso'];
				//----------------------------------------------------------------------------------------------
				//----------------------------------------------------------------------------------------------
				//----------------------------------------------------------------------------------------------
				
				$sql_cri="SELECT cri_eval.id_criterio, cod_criterio FROM comp_cri_eval, cri_eval, n_criterio WHERE comp_cri_eval.id_cri_eval=cri_eval.id_cri_eval AND cri_eval.id_criterio=n_criterio.id_criterio 
				AND comp_cri_eval.id_competencia='".$rs_comp->fields['id_competencia']."' ORDER BY orden";
				$rs_cri=$db->Execute($sql_cri) or die($db->ErrorMsg());
				
				$rs_cri->MoveFirst();
				for($cri=0;$cri<$rs_cri->RecordCount();$cri++)
				{
					$id_criterio=$rs_cri->fields['id_criterio'];
					$cod_criterio=$rs_cri->fields['cod_criterio'];
					
					$radio_cri=$id_competencia.$id_criterio;
									
					$sql_eval="SELECT id_evaluacion, valor_e FROM cri_eval, grupo_eval, n_evaluacion, n_criterio WHERE cri_eval.id_grupo_eval=grupo_eval.id_grupo_eval 
					AND cri_eval.id_criterio=n_criterio.id_criterio AND grupo_eval.id_grupo_eval=n_evaluacion.id_grupo_eval AND cri_eval.id_criterio='".$rs_cri->fields['id_criterio']."' 
					ORDER BY orden_e";
					$rs_eval=$db->Execute($sql_eval) or die($db->ErrorMsg());
					
					$rs_eval->MoveFirst();
					for($eval=0;$eval<$rs_eval->RecordCount();$eval++)
					{
						if($_POST["radio_".$radio_cri]==$rs_eval->fields['id_evaluacion'])
						{
							$id_evaluacion=$rs_eval->fields['id_evaluacion'];
							$valor_e=$rs_eval->fields['valor_e'];
							$eval=$rs_eval->RecordCount();
						}
						
					$rs_eval->MoveNext();
					}
					
					//--------------------------------------------------------------------------------------------------
					
					/*$sql_pond="SELECT n_ponderacion.id_ponderacion,valor_p FROM cri_eval, grupo_pond, n_ponderacion WHERE grupo_pond.id_grupo_pond=n_ponderacion.id_grupo_pond 
					AND cri_eval.id_grupo_pond=grupo_pond.id_grupo_pond AND cri_eval.id_criterio='".$rs_cri->fields['id_criterio']."' ORDER BY orden_p ";
					$rs_pond=$db->Execute($sql_pond) or die($db->ErrorMsg());
					
					$rs_pond->MoveFirst();
					for($pond=0;$pond<$rs_pond->RecordCount();$pond++)
					{
						$radio_pond=$id_competencia.$cod_criterio;
						
						if($_POST["radio_".$radio_pond]==$rs_pond->fields['id_ponderacion'])
						{
							$id_ponderacion=$rs_pond->fields['id_ponderacion'];
							$valor_p=$rs_pond->fields['valor_p'];
							$pond=$rs_pond->RecordCount();
						}
					
					$rs_pond->MoveNext();
					}*/
					
						//------------------------Cálculo------------------------
						//------------------------Cálculo------------------------
						//------------------------Cálculo------------------------
						//$resultado_cri=bcdiv(bcmul($valor_e, $valor_p, 14), 100, 14);
						$resultado_cri=$valor_e;
						//------------------------Cálculo------------------------
						//------------------------Cálculo------------------------
						//------------------------Cálculo------------------------
						
						$i_sql="INSERT INTO desempeno (id_periodo, id_empleado, id_cargo, id_competencia, id_criterio, id_evaluacion, id_empleado_jefe, id_compromiso, resultado_cri, fecha) 
						VALUES ('".$rs_p->fields['id_periodo']."','".$_POST['sel_empleado']."','".$_POST['id_cargo']."','".$rs_comp->fields['id_competencia']."','".$rs_cri->fields['id_criterio']."','".$id_evaluacion."', '".$_POST['txt_id_evaluador']."','".$id_compromiso."','".$resultado_cri."','".date("Y-m-d")."')";//print $i_sql."<br>";
						$db->Execute($i_sql) or die($db->ErrorMsg());

						$mensaje="Los datos se han guardado satisfactoriamente.";						
						
						
				$rs_cri->MoveNext();
				}
			
			$rs_comp->MoveNext();
			}
		}	
		else
		{
			
			$mensaje="El empleado ya ha sido evaluado en este período seleccionado.";
			echo ("<script language=\"JavaScript\" type=\"text/javascript\"> alert('".$mensaje."');</script>");
		}
	}
}
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

<?php
//EVALUADOR
$sql_ev="SELECT DISTINCT empleado.id_empleado, n_cargo.id_cargo, concat(cargo,' - ',identificacion,' - ',primer_nombre,' ',segundo_nombre,' ',primer_apellido,' ',segundo_apellido) as empleado 
FROM persona,empleado,cargo_empleado,n_cargo,usuario,ingreso_salida
WHERE persona.id_persona=empleado.id_persona AND persona.id_persona=usuario.id_persona AND empleado.id_empleado=cargo_empleado.id_empleado AND cargo_empleado.id_cargo=n_cargo.id_cargo AND empleado.id_empleado=ingreso_salida.id_empleado AND baja='0' AND usuario='".$_SESSION["user"]."' AND fecha_cargo=
(SELECT MAX(fecha_cargo) FROM persona,empleado,cargo_empleado,n_cargo,usuario,ingreso_salida WHERE persona.id_persona=empleado.id_persona AND persona.id_persona=usuario.id_persona AND empleado.id_empleado=cargo_empleado.id_empleado AND cargo_empleado.id_cargo=n_cargo.id_cargo AND empleado.id_empleado=ingreso_salida.id_empleado AND baja='0' AND usuario='".$_SESSION["user"]."')";
//print $sql_ev;die();
$rs_ev=$db->Execute($sql_ev) or die($db->ErrorMsg());

//EVALUADO
$sql_e="SELECT DISTINCT empleado.id_empleado, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as empleado 
FROM persona,empleado,ingreso_salida
WHERE persona.id_persona=empleado.id_persona AND empleado.id_empleado=ingreso_salida.id_empleado AND baja='0' AND id_cargo_jefe='".$rs_ev->fields['id_cargo']."' 
AND NOT EXISTS (SELECT 1 FROM desempeno WHERE desempeno.id_empleado = empleado.id_empleado)";
$rs_e=$db->Execute($sql_e) or die($db->ErrorMsg());//print $sql_e;



if(isset($_POST['sel_empleado']))
{
	$sql_cargo="SELECT n_cargo.id_cargo, cargo FROM empleado,n_cargo,cargo_empleado WHERE empleado.id_empleado=cargo_empleado.id_empleado AND cargo_empleado.id_cargo=n_cargo.id_cargo AND empleado.id_empleado='".$_POST["sel_empleado"]."'
	AND fecha_cargo=(SELECT MAX(fecha_cargo) FROM empleado,n_cargo,cargo_empleado WHERE empleado.id_empleado=cargo_empleado.id_empleado AND cargo_empleado.id_cargo=n_cargo.id_cargo AND empleado.id_empleado='".$_POST["sel_empleado"]."')";//print $sql_comp;//die();
	//print $sql_cargo;
	$rs_cargo=$db->Execute($sql_cargo) or die($db->ErrorMsg());
	$id_cargo=$rs_cargo->fields['id_cargo'];
	$cargo=$rs_cargo->fields['cargo'];

	$sql_comp="SELECT distinct comp_cri_eval.id_competencia, competencia, ponderacion FROM n_cargo, n_competencia, comp_cri_eval, cargo_comp, n_ponderacion 
	WHERE n_competencia.id_competencia=comp_cri_eval.id_competencia AND cargo_comp.id_ponderacion=n_ponderacion.id_ponderacion
	AND cargo_comp.id_cargo=n_cargo.id_cargo AND cargo_comp.id_competencia=n_competencia.id_competencia  AND n_cargo.id_cargo='".$id_cargo."' ORDER BY competencia";//print $sql_comp;//die();
	$rs_comp=$db->Execute($sql_comp) or die($db->ErrorMsg());
}

$no_cri=1;
?>
&nbsp;
<tr><td>
<table class="tabla_generica" align="center">
	<tr>
		<td align="left">
		&nbsp;
		</td>	
	</tr>
	<tr>
		<td align="left">&nbsp;&nbsp;
			Evaluador:&nbsp;<input name="txt_evaluador" readonly id="txt_evaluador" value="<?php print $rs_ev->fields['empleado'];?>" size="70">
			<input name="txt_id_evaluador" type="hidden" value="<?php print $rs_ev->fields['id_empleado'];?>">
			&nbsp;&nbsp;&nbsp;<b>Hoy: <?php print date("d/m/Y");?>
			</b>
		</td>	
	</tr>
	<tr>
		<td align="left">&nbsp;&nbsp;
		Evaluado:&nbsp;
			<select name="sel_empleado" id="sel_empleado" onchange="javascript:document.frm.submit();">
				<option>----------------------------------------Seleccionar----------------------------------------</option>
				<?php for($e=0;$e<$rs_e->RecordCount();$e++){?>
				
					<option value="<?php print $rs_e->fields['id_empleado'];?>" <?php if(isset($_POST['sel_empleado'])){if($rs_e->fields['id_empleado']==$_POST['sel_empleado']){;$no_emp=0;?> selected="selected"<?php }}?> > <?php print $rs_e->fields['empleado'];?> </option>
					
				<?php $rs_e->MoveNext();}?>
			</select>
<?php 
if(!isset($no_emp))
$_POST['sel_empleado']='';
?>
			&nbsp;&nbsp;
		Per&iacute;odo a evaluar:&nbsp;
			<input name="txt_periodo" readonly id="txt_periodo" value="<?php print $rs_p->fields['periodo'];?>" size="25">

		</td>
	</tr>

	<?php 
	if(isset($_GET['mensaje']))
	$mensaje=$_GET['mensaje'];
	if(isset($return[0]))
$mensaje=$return[0];
	$obj->Imprimir_mensaje($mensaje);
	?>

<?php 
if(isset($_POST['sel_empleado']))
{ 
	if($_POST['sel_empleado']!=0)
	{
?>
	
		<tr>
			<td align="left">
			&nbsp;
			</td>	
		</tr>
		<tr>
			<td align="left">
			Estimado Evaluador el objetivo de este proceso es darle la oportunidad de conocer de cerca el trabajo de sus colaboradores teniendo en cuenta la forma como act&uacute;an en determinadas
	situaciones relacionadas directamente con su trabajo. 
			</td>	
		</tr>
		
		<?php $rs_comp->MoveFirst();
		for($comp=0;$comp<$rs_comp->RecordCount();$comp++)
		{
		?>		
			<tr>
				<td align="left">
				&nbsp;<br><br><br>
				</td>	
			</tr>
			
			<tr width="100%">
				<td align="left" height="30" width="100%">
				
					<table>
					<?php
					if($competencia!=$rs_comp->fields['competencia'])
					{
						$id_competencia=$rs_comp->fields['id_competencia'];
						$competencia=$rs_comp->fields['competencia'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ponderaci&oacute;n: '.$rs_comp->fields['ponderacion'];
					?>
						<tr class='encabezado_col' width="100%">
							<td colspan="3" align="left" height="30" width="100%">
								<?php print $competencia;?>	
							</td>
							<!--
							<td align="center" height="30" colspan="10">
								Ponderaciones
							</td>-->	
						</tr>
						
						<?php
						$sql_cri="SELECT cri_eval.id_criterio, orden, cod_criterio, criterio FROM comp_cri_eval, cri_eval, n_criterio WHERE comp_cri_eval.id_cri_eval=cri_eval.id_cri_eval AND cri_eval.id_criterio=n_criterio.id_criterio 
						AND comp_cri_eval.id_competencia='".$rs_comp->fields['id_competencia']."' ORDER BY orden";
						$rs_cri=$db->Execute($sql_cri) or die($db->ErrorMsg());
						
						$rs_cri->MoveFirst();
						for($cri=0;$cri<$rs_cri->RecordCount();$cri++)
						{					
							if($criterio!=$rs_cri->fields['criterio'])
							{
								$id_criterio=$rs_cri->fields['id_criterio'];
								$cod_criterio=$rs_cri->fields['cod_criterio'];
								$criterio="<div class='bola'>".$no_cri."</div>"."&nbsp;&nbsp;".$cod_criterio." - ".$rs_cri->fields['criterio'];
								$no_cri=$no_cri+1;
						?>	
								<tr>
									<td align="left" width="100%">
										
										<table align="center" width="100%">
											</tr>
												<td height="50">								
													<br><?php print $criterio;?>
												</td>
											</tr>
											
											</tr>
												<td>
													<table class='row_resaltada' align="center" width="100%">
														</tr>
														<?php
														$sql_eval="SELECT id_evaluacion, cod_evaluacion, evaluacion, valor_e, exp_eval, orden_e FROM cri_eval, grupo_eval, n_evaluacion, n_criterio WHERE cri_eval.id_grupo_eval=grupo_eval.id_grupo_eval 
														AND cri_eval.id_criterio=n_criterio.id_criterio AND grupo_eval.id_grupo_eval=n_evaluacion.id_grupo_eval AND cri_eval.id_criterio='".$rs_cri->fields['id_criterio']."' 
														ORDER BY orden_e";
														$rs_eval=$db->Execute($sql_eval) or die($db->ErrorMsg());
														
														if($rs_eval->RecordCount()!=0)$ancho_eval=100/$rs_eval->RecordCount();
														
														$rs_eval->MoveFirst();
														for($eval=0;$eval<$rs_eval->RecordCount();$eval++)
														{					
															if($cod_evaluacion!=$rs_eval->fields['cod_evaluacion'])
															{
																$cod_evaluacion=$rs_eval->fields['cod_evaluacion'];
																$id_evaluacion=$rs_eval->fields['id_evaluacion'];
																$evaluacion=$rs_eval->fields['evaluacion'];
																$valor_e=$rs_eval->fields['valor_e']."%";
																$exp_eval=$rs_eval->fields['exp_eval'];
																$evalua="<b>C&oacute;digo:</b> ".$cod_evaluacion."<br><b>Evaluaci&oacute;n:</b> ".$evaluacion."<br><b>Valor:</b> ".$valor_e."<br><b>Explicaci&oacute;n:</b> ".$exp_eval."<br>";
																
																if($id_evaluacion_ant!=$id_competencia.$id_criterio)
																{
																	if($cadena_id_evaluacion == ""){$cadena_id_evaluacion = $id_competencia.$id_criterio;}
																	else{$cadena_id_evaluacion .= ",".$id_competencia.$id_criterio;}
																	$id_evaluacion_ant=$id_competencia.$id_criterio; //print $cadena_id_evaluacion."<br>";
																}
																
																$radio_cri=$id_competencia.$id_criterio;
														?>
															<td align="center" width="<?php print $ancho_eval;?>%">
																<a class="hlink" onmouseover="return overlib('<?php print $evalua;?>', ABOVE, RIGHT)" onmouseout="return nd();">
																	<?php print $cod_evaluacion;?><input type="radio" name="radio_<?php print $radio_cri;?>" id="radio_<?php print $radio_cri;?>" value="<?php print $id_evaluacion;?>">
																</a>
															</td>
														<?php 
															}
														$rs_eval->MoveNext();
														}
														?>	
														</tr>
													</table>
												</td>		
											</tr>
										</table>
									
									</td>

									<td align="left" height="30">
										&nbsp	
									</td>
									<!--
									<td align="left" height="30">
									
										<table align="center" width="100%">
											
											</tr>
												<td>								
													<br><br><br>
												</td>
											</tr>
											
											<tr class='row_resaltada'>-->
											<?php
											/*$sql_pond="SELECT n_ponderacion.id_ponderacion, cod_ponderacion, ponderacion, valor_p, exp_pond, orden_p FROM cri_eval, grupo_pond, n_ponderacion WHERE grupo_pond.id_grupo_pond=n_ponderacion.id_grupo_pond AND cri_eval.id_grupo_pond=grupo_pond.id_grupo_pond
											AND cri_eval.id_criterio='".$rs_cri->fields['id_criterio']."' ORDER BY orden_p ";
											$rs_pond=$db->Execute($sql_pond) or die($db->ErrorMsg());
											
											$rs_pond->MoveFirst();
											for($pond=0;$pond<$rs_pond->RecordCount();$pond++)
											{					
												if($ponderacion!=$rs_pond->fields['ponderacion'])
												{
													$id_ponderacion=$rs_pond->fields['id_ponderacion'];
													$cod_ponderacion=$rs_pond->fields['cod_ponderacion'];
													$ponderacion=$rs_pond->fields['ponderacion'];
													$valor_p=$rs_pond->fields['valor_p']."%";
													$exp_pond=$rs_pond->fields['exp_pond'];
													$pondera="<b>C&oacute;digo:</b> ".$cod_ponderacion."<br><b>Ponderaci&oacute;n:</b> ".$ponderacion."<br><b>Valor:</b> ".$valor_p."<br><b>Explicaci&oacute;n:</b> ".$exp_pond."<br>";
										
													if($id_ponderacion_ant!=$id_competencia.$cod_criterio)
													{
														if($cadena_id_ponderacion == ""){$cadena_id_ponderacion = $id_competencia.$cod_criterio;}
														else{$cadena_id_ponderacion .= ",".$id_competencia.$cod_criterio;}
														$id_ponderacion_ant=$id_competencia.$cod_criterio; //print $cadena_id_ponderacion."<br>";
													}
													
													$radio_pond=$id_competencia.$cod_criterio;
											?>	
												<!--
												<td align="center">
													<a class="hlink" onmouseover="return overlib('<?php print $pondera;?>', ABOVE, RIGHT)" onmouseout="return nd();">
														<?php print $cod_ponderacion;?><input type="radio" name="radio_<?php print $radio_pond;?>" id="radio_<?php print $radio_pond;?>" value="<?php print $id_ponderacion;?>">
													</a>
												</td>-->
												
											<?php
												}
											$rs_pond->MoveNext();
											}
											*/?><!--
											</tr>
											
										</table>
										
									</td>-->
								</tr>

						
					<?php 
							}
						$rs_cri->MoveNext();
						}
					}
					?>
					</table>
					
				</td>		
			</tr>
		<?php $rs_comp->MoveNext();
		}
	}
}
?>

		<tr>
			<td align="left">
			&nbsp;
			</td>	
		</tr>
</table>

<input type="hidden" name="cadena_id_evaluacion" value="<?php print $cadena_id_evaluacion;?>">
<input type="hidden" name="cadena_id_ponderacion" value="<?php print $cadena_id_ponderacion;?>">
<input type="hidden" name="id_cargo" value="<?php print $id_cargo;?>">
<input type="hidden" name="var_checkbox" value="<?php echo $cadenacheckboxp;?>">
<input type="hidden" name="var_aux" value="">	

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Fin Contenido-->
		</td>
	</tr>
</table>
						
			<br>				
			</table>
		</td>
	</tr>
	<tr>
		<td class="footer">
			<table class="footer">
				<tr>					
					<td class="footer"><?php echo $nombre_empresa . " - " . $nombre_sucursal;?></td>					
				</tr>
			</table>
		</td>
	</tr>
</table>
</div>

<div id='menu1' class='portal' style="display:block; ">
	<div class="barra">
		<table class="tabla_barra" id="toolbar">
			<tr> 
				<td>				
					<?php 
						print "<font size='2'>".$titulo_nuevo."<font>";
						$obj->Botonera($n_botones,$rs_sesion,$elemento);
					?>				
				</td>
			</tr>								
		</table>
	</div>
</div>
 <!--fin contenido1-->
</form>
</body>
</html>