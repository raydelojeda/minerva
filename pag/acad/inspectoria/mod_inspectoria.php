<?php
include("inspectoria.php");
if(!isset($obj_inspectoria))$obj_inspectoria = new inspectoria();// (NO TOCAR)

include("variables.php");
//$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>"valida_pro();",'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
include($x."plantillas/new_header.php");
$m_botones=array();
$visualizar="";// (NO TOCAR)
$checked="";
$abrev="";
$seccion_academica_ant='';
$hoy=date("Y-m-d");

$sql_p="select id_periodo_academico as id_periodo_academico, concat(n_periodo_academico.nombre,'  -  ',fecha_ini,'/',fecha_fin) as periodo_academico, activo from n_periodo_academico WHERE activo='1' ORDER BY fecha_ini";
$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());

$sql_a="SELECT id_asignatura as id_asignatura, concat(abreviatura,' - ',asignatura) AS asignatura, asignatura AS asig FROM n_asignatura";
$rs_a=$db->Execute($sql_a) or die($db->ErrorMsg());

$sql_pro="select id_empleado_academico, concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre,' - ',persona.identificacion) as empleado_academico 
from empleado, persona, empleado_academico WHERE 1 AND persona.id_persona=empleado.id_persona AND empleado_academico.id_empleado=empleado.id_empleado ORDER BY primer_apellido, segundo_apellido, primer_nombre, segundo_nombre";
$rs_pro=$db->Execute($sql_pro) or die($db->ErrorMsg());

$sql_gra="SELECT DISTINCT n_grado_paralelo.id_grado AS id_grado, n_grado.abreviatura AS abv_gra, n_seccion_academica.abreviatura AS abv_secc, seccion_academica, n_grado.id_seccion_academica, grado, n_periodo_academico.id_periodo_academico 
FROM n_seccion_academica, n_grado, n_grado_paralelo, grado_paralelo_periodo, n_periodo_academico, curso_grado_paralelo_est
WHERE n_seccion_academica.id_seccion_academica=n_grado.id_seccion_academica
AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
AND n_grado_paralelo.id_grado=n_grado.id_grado 
AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico 
AND n_periodo_academico.activo='1' ORDER BY grado_paralelo_periodo.orden";
$rs_gra=$db->Execute($sql_gra) or die($db->ErrorMsg());

$rs_gra->MoveFirst();
$rs_a->MoveFirst();
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href='<?php print $x."js/tabs/css/luna/tab.css";?>'>
<script type="text/javascript" src='<?php print $x."js/tabs/js/tabpane.js";?>'></script>

<link data-jsfiddle="common" rel="stylesheet" media="screen" href="<?php print $x."js/handsontable/dist/handsontable.css";?>">
<link data-jsfiddle="common" rel="stylesheet" media="screen" href="<?php print $x."js/handsontable/dist/pikaday/pikaday.css";?>">
<script data-jsfiddle="common" src="<?php print $x."js/handsontable/dist/pikaday/pikaday.js";?>"></script>
<script data-jsfiddle="common" src="<?php print $x."js/handsontable/dist/moment/moment.js";?>"></script>
<script data-jsfiddle="common" src="<?php print $x."js/handsontable/dist/zeroclipboard/ZeroClipboard.js";?>"></script>
<script data-jsfiddle="common" src="<?php print $x."js/handsontable/dist/handsontable.js";?>"></script>

<div id="modal_clase_fecha_inasistencia" class="modalmask"></div>


<script type="text/javascript" class="js-code-basic">
function cambiar_asistencia(id_imagen)
{
	if (document.getElementById)
	{	
		imagen1=new Image
		imagen1.src="../../../img/acad/asistencia/ok.png";
		imagen2=new Image
		imagen2.src="../../../img/acad/asistencia/atraso.png";
		imagen3=new Image
		imagen3.src="../../../img/acad/asistencia/tarjeta_amarilla.png";
		imagen4=new Image
		imagen4.src="../../../img/acad/asistencia/tarjeta_roja.png";

		if(document.images[id_imagen].src == imagen1.src)
		{
			document.images[id_imagen].src = imagen2.src;
			
		}
		else if(document.images[id_imagen].src == imagen2.src)
		{
			document.images[id_imagen].src = imagen3.src;
		}
		else if(document.images[id_imagen].src == imagen3.src)
		{
			document.images[id_imagen].src = imagen4.src;
		}
		else 
		{
			document.images[id_imagen].src = imagen1.src;
		}
		ejecutar_ajax('asistencia/guardar_inasistencia.php','hdn_celda_'+id_imagen,'')
	}
}
</script>
&nbsp;
<br>

<div style='margin: 0 auto;width:98%;'>
	<div class="tab-pane" id="tabPane_asis">
		<div class="tab-page">
			<h2 class="tab">Asistencia</h2>

			<div class="tab-pane" id="tabPane" style="padding-left:7px;width:99.5%">
				<?php
				$tab=0;$rs_gra->MoveFirst();
				for($s=0;$s<$rs_gra->RecordCount();$s++)
				{					
					$id_gra=$rs_gra->fields['id_grado'];
										
					$seccion_academica=$rs_gra->fields['abv_secc'];
					if($seccion_academica_ant!=$seccion_academica)
					{
						$ok=1;
						
						$sql_insp_sec="SELECT grado_paralelo_periodo.id_inspector
						FROM  n_periodo_academico,
						empleado_academico, empleado, persona, usuario, grado_paralelo_periodo, n_grado_paralelo, n_grado
						WHERE 1
						AND n_grado_paralelo.id_grado=n_grado.id_grado
						AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo
						AND grado_paralelo_periodo.id_inspector=empleado_academico.id_empleado_academico 
						AND persona.id_persona=empleado.id_persona 
						AND persona.id_persona=usuario.id_persona
						AND empleado_academico.id_empleado=empleado.id_empleado 			
						AND id_seccion_academica='".$rs_gra->fields['id_seccion_academica']."'
						AND n_periodo_academico.activo='1' AND usuario='".$_SESSION['user']."'";//print $sql_insp;
						$rs_insp_sec=$db->Execute($sql_insp_sec) or die($db->ErrorMsg());
						
						if(isset($rs_insp_sec->fields['id_inspector']))
						{
					?>
							<div class="tab-page">
								<h2 class="tab"><?php print $seccion_academica;$seccion_academica_ant=$rs_gra->fields['abv_secc'];?></h2>
								<br>
								<div class="tab-pane" id="tabPane_gra<?php print $s;?>" style="padding-left:7px;width:99.5%">
					<?php
						}
					}
					
					$sql_insp_gra="SELECT grado_paralelo_periodo.id_inspector
					FROM  n_periodo_academico,
					empleado_academico, empleado, persona, usuario, grado_paralelo_periodo, n_grado_paralelo
					WHERE 1
					AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo
					AND grado_paralelo_periodo.id_inspector=empleado_academico.id_empleado_academico 
					AND persona.id_persona=empleado.id_persona 
					AND persona.id_persona=usuario.id_persona
					AND empleado_academico.id_empleado=empleado.id_empleado 			
					AND id_grado='".$rs_gra->fields['id_grado']."'
					AND n_periodo_academico.activo='1' AND usuario='".$_SESSION['user']."'";//print $sql_insp;
					$rs_insp_gra=$db->Execute($sql_insp_gra) or die($db->ErrorMsg());
				
					if(isset($rs_insp_gra->fields['id_inspector']))
					{
				?>
						<div class="tab-page">
							<h2 class="tab"><?php print $rs_gra->fields['abv_gra'];?></h2>
							<br>
							<div class="tab-pane" id="tabPane_par<?php print $s;?>" style="padding-left:7px;width:99.5%">
								
								<?php
								$sql_par="SELECT n_paralelo.id_paralelo, paralelo FROM n_paralelo, n_grado_paralelo, grado_paralelo_periodo, n_periodo_academico
								WHERE 1 AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
								AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico 
								AND n_periodo_academico.activo='1' AND n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo AND id_grado='".$rs_gra->fields['id_grado']."'";
								$rs_par=$db->Execute($sql_par) or die($db->ErrorMsg());
								
								for($p=0;$p<$rs_par->RecordCount();$p++)
								{
									$id_gra_par=$rs_gra->fields['id_grado'].'_'.$rs_par->fields['id_paralelo'];
									$id_par=$rs_par->fields['id_paralelo'];
																		
									$sql_insp_par="SELECT grado_paralelo_periodo.id_inspector
									FROM  n_periodo_academico,
									empleado_academico, empleado, persona, usuario, grado_paralelo_periodo, n_grado_paralelo
									WHERE 1
									AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo
									AND grado_paralelo_periodo.id_inspector=empleado_academico.id_empleado_academico 
									AND persona.id_persona=empleado.id_persona 
									AND persona.id_persona=usuario.id_persona
									AND empleado_academico.id_empleado=empleado.id_empleado 			
									AND id_grado='".$rs_gra->fields['id_grado']."'
									AND id_paralelo='".$rs_par->fields['id_paralelo']."'
									AND n_periodo_academico.activo='1' AND usuario='".$_SESSION['user']."'";//print $sql_insp;
									$rs_insp_par=$db->Execute($sql_insp_par) or die($db->ErrorMsg());
									
									if(isset($rs_insp_par->fields['id_inspector']))
									{
									?>
										<div class="tab-page">
											<h2 class="tab"><?php print $rs_par->fields['paralelo'];?></h2>
											<br>
											
											<?php
												$obj_inspectoria->filtro($db, $rs_gra->fields['id_grado'], $rs_par->fields['id_paralelo']);										
											?>
											
											<div style='display:table;width:100%;margin-left:auto;margin-right:auto;' id='contenido_grid_asistencias_<?php print $id_gra_par;?>'></div>
											
										</div>					
									<?php
									}
									
								$rs_par->MoveNext();
								}
								?>
							</div>
						</div>
					
					<?php
						}						
					?>
						<input name="hdn_filas_agregadas_<?php print $rs_gra->fields['id_grado'];?>" id="hdn_filas_agregadas_<?php print $rs_gra->fields['id_grado'];?>" type="hidden" value=""/>		
				<?php
					$rs_gra->MoveNext();
					$seccion_academica=$rs_gra->fields['abv_secc'];
					if($seccion_academica_ant!=$seccion_academica)
					{
						if(isset($rs_insp_sec->fields['id_inspector']))
						{
				?>	
							</div>
						</div>
				<?php
						}
					}
				$ok='';
				
				}
				?>
			</div>
		</div>
<?php		
$abrev="";
$seccion_academica_ant='';
?>
		<div class="tab-page">
			<h2 class="tab">Comportamiento</h2>

			<div class="tab-pane" id="tabPane" style="padding-left:7px;width:99.5%">
				<?php
				$tab=0;$rs_gra->MoveFirst();
				for($s=0;$s<$rs_gra->RecordCount();$s++)
				{
					$id_gra=$rs_gra->fields['id_grado'];
					?>
					<input name="hdn_id_gra_<?php print $id_gra;?>" id="hdn_id_gra_<?php print $id_gra;?>" type="hidden" value="<?php print $id_gra;?>"/>
					<?php
					$seccion_academica=$rs_gra->fields['abv_secc'];
					if($seccion_academica_ant!=$seccion_academica)
					{
						$ok=1;
						
						$sql_insp_sec="SELECT grado_paralelo_periodo.id_inspector
						FROM  n_periodo_academico,
						empleado_academico, empleado, persona, usuario, grado_paralelo_periodo, n_grado_paralelo, n_grado
						WHERE 1
						AND n_grado_paralelo.id_grado=n_grado.id_grado
						AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo
						AND grado_paralelo_periodo.id_inspector=empleado_academico.id_empleado_academico 
						AND persona.id_persona=empleado.id_persona 
						AND persona.id_persona=usuario.id_persona
						AND empleado_academico.id_empleado=empleado.id_empleado 			
						AND id_seccion_academica='".$rs_gra->fields['id_seccion_academica']."'
						AND n_periodo_academico.activo='1' AND usuario='".$_SESSION['user']."'";//print $sql_insp;
						$rs_insp_sec=$db->Execute($sql_insp_sec) or die($db->ErrorMsg());
						
						if(isset($rs_insp_sec->fields['id_inspector']))
						{
					?>
							<div class="tab-page">
								<h2 class="tab"><?php print $seccion_academica;$seccion_academica_ant=$rs_gra->fields['abv_secc'];?></h2>
								<br>
								<div class="tab-pane" id="tabPane_gra<?php print $s;?>" style="padding-left:7px;width:99.5%">
					<?php
						}
					}
					
					$sql_insp_gra="SELECT grado_paralelo_periodo.id_inspector
					FROM  n_periodo_academico,
					empleado_academico, empleado, persona, usuario, grado_paralelo_periodo, n_grado_paralelo
					WHERE 1
					AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo
					AND grado_paralelo_periodo.id_inspector=empleado_academico.id_empleado_academico 
					AND persona.id_persona=empleado.id_persona 
					AND persona.id_persona=usuario.id_persona
					AND empleado_academico.id_empleado=empleado.id_empleado 			
					AND id_grado='".$rs_gra->fields['id_grado']."'
					AND n_periodo_academico.activo='1' AND usuario='".$_SESSION['user']."'";//print $sql_insp;
					$rs_insp_gra=$db->Execute($sql_insp_gra) or die($db->ErrorMsg());
				
					if(isset($rs_insp_gra->fields['id_inspector']))
					{
				?>
						<div class="tab-page">
							<h2 class="tab"><?php print $rs_gra->fields['abv_gra'];?></h2>
							<br>
							<div class="tab-pane" id="tabPane_par<?php print $s;?>" style="padding-left:7px;width:99.5%">
								
								<?php
								$sql_par="SELECT n_paralelo.id_paralelo, paralelo FROM n_paralelo, n_grado_paralelo, grado_paralelo_periodo, n_periodo_academico
								WHERE 1 AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
								AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico 
								AND n_periodo_academico.activo='1' AND n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo AND id_grado='".$rs_gra->fields['id_grado']."'";
								$rs_par=$db->Execute($sql_par) or die($db->ErrorMsg());
								
								for($p=0;$p<$rs_par->RecordCount();$p++)
								{
									$id_gra_par=$rs_gra->fields['id_grado'].'_'.$rs_par->fields['id_paralelo'];
									$id_par=$rs_par->fields['id_paralelo'];
									?>
									<input name="hdn_id_gra_par_<?php print $id_gra_par;?>" id="hdn_id_gra_par_<?php print $id_gra_par;?>" type="hidden" value="<?php print $id_gra_par;?>"/>
									<input name="hdn_id_par_<?php print $id_gra_par;?>" id="hdn_id_par_<?php print $id_gra_par;?>" type="hidden" value="<?php print $id_par;?>"/>
									<?php
									
									$sql_insp_par="SELECT grado_paralelo_periodo.id_inspector
									FROM  n_periodo_academico,
									empleado_academico, empleado, persona, usuario, grado_paralelo_periodo, n_grado_paralelo
									WHERE 1
									AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo
									AND grado_paralelo_periodo.id_inspector=empleado_academico.id_empleado_academico 
									AND persona.id_persona=empleado.id_persona 
									AND persona.id_persona=usuario.id_persona
									AND empleado_academico.id_empleado=empleado.id_empleado 			
									AND id_grado='".$rs_gra->fields['id_grado']."'
									AND id_paralelo='".$rs_par->fields['id_paralelo']."'
									AND n_periodo_academico.activo='1' AND usuario='".$_SESSION['user']."'";//print $sql_insp;
									$rs_insp_par=$db->Execute($sql_insp_par) or die($db->ErrorMsg());
									
									if(isset($rs_insp_par->fields['id_inspector']))
									{
									?>
										<div class="tab-page">
											<h2 class="tab"><?php print $rs_par->fields['paralelo'];?></h2>
											<br>
											
												<div style='display:table;width:100%;margin:0;'>
													<div style='display:table-row;'>			
														
														<div style='display:table-cell;width:50%;text-align:center;'>
											
															<div style='display:table;width:50%;margin-left:0;' id='contenido_grid_comportamiento_<?php print $id_gra_par;?>'>	
															
																<?php
																	$obj_inspectoria->contenido_comportamientos($db, '../', $rs_gra->fields['id_grado'], $rs_par->fields['id_paralelo']);										
																?>
																
															</div>
											
														</div>
							
														<div style='display:table-cell;width:50%;text-align:center;'>
									
															<div style='display:table;width:100%;margin-right:0;'>
																<div style='display:table-row;'>			
																	<div style='display:table-cell;width:50%;text-align:center;padding:1%;'  id='div_comportamiento_<?php print $id_gra_par;?>'>
																	
																	</div>
																</div>
															</div>
														
														</div>
														
													</div>
												</div>											
											
										</div>					
									<?php
									}
									
								$rs_par->MoveNext();
								}
								?>
							</div>
						</div>
					
					<?php
						}						
					?>
					
								
				<?php
					$rs_gra->MoveNext();
					$seccion_academica=$rs_gra->fields['abv_secc'];
					if($seccion_academica_ant!=$seccion_academica)
					{
						if(isset($rs_insp_sec->fields['id_inspector']))
						{
				?>	
							</div>
						</div>
				<?php
						}
					}
				$ok='';
				
				}
				?>
			</div>
		</div>
</div>
<div id="modal_mod_asistencia" class="modalmask"></div>

<?php
if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];
if(isset($return[0]))
$mensaje=$return[0];
$obj->Imprimir_mensaje($mensaje);
?>

<br>

<script type="text/javascript">setupAllTabs();</script>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/new_footer.php");
?>