<?php
include("reportes.php");
if(!isset($obj_reportes))$obj_reportes = new reportes();// (NO TOCAR)

include("variables.php");
//$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>"valida_pro();",'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
include($x."plantillas/lis_header_sin_barra.php");

$visualizar="";// (NO TOCAR)
$checked="";
$abrev="";
$seccion_academica_ant='';
$hoy=date("Y-m-d");

$sql_p="select id_periodo_academico as id_periodo_academico, concat(n_periodo_academico.nombre,'  -  ',fecha_ini,'/',fecha_fin) as periodo_academico, activo from n_periodo_academico WHERE activo='1' ORDER BY fecha_ini";
$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());

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
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href='<?php print $x."js/tabs/css/luna/tab.css";?>'>
<script type="text/javascript" src='<?php print $x."js/tabs/js/tabpane.js";?>'></script>

<div id="reportes"></div>
&nbsp;
<br>

<div style='margin: 0 auto;width:98%;'>
	<div class="tab-pane" id="tabPane_asis">
		
			
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
			?>
					<div class="tab-page">
						<h2 class="tab"><?php print $seccion_academica;$seccion_academica_ant=$rs_gra->fields['abv_secc'];?></h2>
						<br>
						<div class="tab-pane" id="tabPane_gra<?php print $s;?>" style="padding-left:7px;width:99.5%">
			<?php
				
			}
			
			
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
							
								<div class="tab-page">
									<h2 class="tab"><?php print $rs_par->fields['paralelo'];?></h2>
									<br>
									
									<div class="tab-pane" id="tabPane_repo1" style="padding-left:7px;width:99.5%">	
										<div class="tab-page">
											<h2 class="tab">Libreta</h2>
											<br>
										
											<div style='display:table;width:100%;margin:0;'>
												<div style='display:table-row;'>			
													
													<div style='display:table-cell;width:100%;text-align:center;'>
										
														<div style='display:table;width:100%;margin-left:0;' id='contenido_grid_comportamiento_<?php print $id_gra_par;?>'>	
														
															<?php
																$obj_reportes->filtro_libreta($db, $rs_gra->fields['id_grado'], $rs_par->fields['id_paralelo']);											
															?>
															
														</div>
										
													</div>
						
												</div>
											</div>
											
										</div>
										
										<div class="tab-page">
											<h2 class="tab">Calificaci&oacute;n</h2>
											<br>
										
											<div style='display:table;width:100%;margin:0;'>
												<div style='display:table-row;'>			
													
													<div style='display:table-cell;width:100%;text-align:center;'>
										
														<div style='display:table;width:100%;margin-left:0;' id='contenido_grid_comportamiento_<?php print $id_gra_par;?>'>	
														
															<?php
																$obj_reportes->filtro_cuadro_juntas($db, $rs_gra->fields['id_grado'], $rs_par->fields['id_paralelo']);											
															?>
															
														</div>
										
													</div>
						
												</div>
											</div>
											
										</div>
										
										<div class="tab-page">
											<h2 class="tab">Promoci&oacute;n</h2>
											<br>
										
											<div style='display:table;width:100%;margin:0;'>
												<div style='display:table-row;'>			
													
													<div style='display:table-cell;width:100%;text-align:center;'>
										
														<div style='display:table;width:100%;margin-left:0;' id='contenido_grid_comportamiento_<?php print $id_gra_par;?>'>	
														
															<?php
																$obj_reportes->filtro_promocion($db, $rs_gra->fields['id_grado'], $rs_par->fields['id_paralelo']);											
															?>
															
														</div>
										
													</div>
						
												</div>
											</div>
											
										</div>
										
										<div class="tab-page">
											<h2 class="tab">Matr&iacute;cula</h2>
											<br>
										
											<div style='display:table;width:100%;margin:0;'>
												<div style='display:table-row;'>			
													
													<div style='display:table-cell;width:100%;text-align:center;'>
										
														<div style='display:table;width:100%;margin-left:0;' id='contenido_grid_comportamiento_<?php print $id_gra_par;?>'>	
														
															<?php
																$obj_reportes->filtro_matricula($db, $rs_gra->fields['id_grado'], $rs_par->fields['id_paralelo']);											
															?>
															
														</div>
										
													</div>
						
												</div>
											</div>
											
										</div>
										
										<div class="tab-page">
											<h2 class="tab">Ministerial</h2>
											<br>
										
											<div style='display:table;width:100%;margin:0;'>
												<div style='display:table-row;'>			
													
													<div style='display:table-cell;width:100%;text-align:center;'>
										
														<div style='display:table;width:100%;margin-left:0;' id='contenido_grid_comportamiento_<?php print $id_gra_par;?>'>	
														
															<?php
																$obj_reportes->filtro_ministerial($db, $rs_gra->fields['id_grado'], $rs_par->fields['id_paralelo']);											
															?>
															
														</div>
										
													</div>
						
												</div>
											</div>
											
										</div>
										
									</div>									
								</div>

								
							<?php
						$rs_par->MoveNext();
						}
						?>
					</div>
				</div>
		<?php
			$rs_gra->MoveNext();
			$seccion_academica=$rs_gra->fields['abv_secc'];
			if($seccion_academica_ant!=$seccion_academica)
			{						
		?>	
			</div>
		</div>
		<?php
			}
		}
		?>
	</div>
</div>
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
 include($x."plantillas/lis_footer_sin_barra.php");
?>