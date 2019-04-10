<?php
$x='../../../../';
include($x."pag/acad/clase_inasistencia/variables_mod.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{
	$id_grado=$_POST['campo0'];
	$id_paralelo=$_POST['campo1'];
	$id_gra_par=$id_grado.'_'.$id_paralelo;
	
	$sql_est="SELECT estudiante.id_estudiante as id_estudiante, curso_grado_paralelo_est.id_curso_grado_paralelo_est, n_grado_paralelo.id_grado_paralelo, n_grado_paralelo.abreviatura, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as estudiante
	FROM persona, estudiante, curso_grado_paralelo_est, grado_paralelo_periodo, n_grado_paralelo, n_periodo_academico 
	WHERE estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
	AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo
	AND persona.id_persona=estudiante.id_persona 
	AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico AND n_periodo_academico.activo='1' 
	AND n_grado_paralelo.id_grado='".$id_grado."'
	AND n_grado_paralelo.id_paralelo='".$id_paralelo."'
	ORDER BY orden, primer_apellido, segundo_apellido, primer_nombre";//print $sql_est;
	$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
?>

<div class="modalbox movedown">
		<br>
		<table class="encabezado" cellpadding="0">
			<tr>
				<td>
					<table class="menubar mini_menubar" id="toolbar">		
						<tr class='tabla_listar'>
							<td class="titulo_encabezado">Modificar asistencia en un per&iacute;odo determinado de un estudiante de <?php print $rs_est->fields['abreviatura'];?></td>
							
							<td class="botonera_encabezado" style='text-align:center;'>
								<div>
									<a class="toolbar" href="#" target="_self" onclick="ok=validar_sin_submit('sel_est','','Rselect','txt_fecha_ini','','Rfecha','txt_fecha_fin','','Rfecha','sel_asis','','Rselect'); if(ok==0)return false;
									ejecutar_ajax('asistencia/mod_asis_per.php','sel_est, txt_fecha_ini, txt_fecha_fin, sel_asis, txt_obs, sel_estudiante_<?php print $id_gra_par;?>, hdn_id_grado_<?php print $id_gra_par;?>, hdn_id_paralelo_<?php print $id_gra_par;?>, txt_fecha_<?php print $id_gra_par;?>','contenido_grid_asistencias_<?php print $id_gra_par;?>');"  >
										<img src="../../../img/general/guardar_mini.png" alt="Guardar" name="guardar" width="16" height="16" border="0" id="guardar"/><br/>Guardar
									</a>
								</div>
							</td>
							
							<td class="botonera_encabezado" style='text-align:center;'>
								<div>
									<a class="toolbar" target="_self" href="#close">
										<img src="../../../img/general/cerrar_mini.png" alt="Salir" name="cancelar" width="16" height="16" border="0" id="cancelar"/><br/>Salir
									</a>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<br>
		
		<div style='display:table;width:99%;'>
			<div style='display:table-row;width: 100%;'>
				<div style='height:22px;width:20%;display:table-cell;text-align:right;'>
					Estudiante:
				</div>
				
				<div style='display:table-cell;text-align:left;'>
					<select class="sel_est" name="sel_est" id="sel_est" title="Estudiante">
						<option value="">----------------------------Estudiante----------------------------</option>
						<?php for($c=0;$c<$rs_est->RecordCount();$c++){?>
						
							<option value="<?php print $rs_est->fields['id_curso_grado_paralelo_est'];?>"><?php print $rs_est->fields['estudiante'];?></option>
							
						<?php $rs_est->MoveNext();}?>
					</select>
					<script type="text/javascript" class="js-code-basic">
						$(".sel_est").select2();
					</script>
				</div>
			</div>
			
			<div style='display:table-row;'>
				<div style='height:22px;width:20%;display:table-cell;text-align:right;'>
					Fecha de inicio:
				</div>
				
				<div style='display:table-cell;text-align:left;'>
					<input title="Fecha de inicio" size="10" name="txt_fecha_ini" id="txt_fecha_ini" type="text" onclick='displayCalendar(document.frm.txt_fecha_ini,"yyyy-mm-dd",this);' value="<?php print date("Y-m-d");?>"/>
				</div>
			</div>
			
			<div  style='display:table-row;'>
				<div style='height:22px;width:20%;display:table-cell;text-align:right;'>
					Fecha final:
				</div>
				
				<div style='display:table-cell;text-align:left;'>
					<input title="Fecha final" size="10" name="txt_fecha_fin" id="txt_fecha_fin" type="text" onclick='displayCalendar(document.frm.txt_fecha_fin,"yyyy-mm-dd",this);' value="<?php print date("Y-m-d");?>"/>
				</div>
			</div>
			
			<div style='display:table-row;width: 100%;'>
				<div style='height:22px;width:20%;display:table-cell;text-align:right;'>
					Tipo de asistencia:
				</div>
				
				<div style='display:table-cell;text-align:left;'>
					<select title="Tipo de asistencia" class="sel_asis" name="sel_asis" id="sel_asis">
						<option value="0">Presente</option>
						<option value="1">Atraso</option>
						<option value="2">Ausencia justificada</option>
						<option value="3">Ausencia injustificada</option>
					</select>
				</div>
			</div>
			
			<div style='display:table-row;width: 100%;'>
				<div style='height:22px;width:20%;display:table-cell;text-align:right;'>
					Observaciones:
				</div>
				
				<div style='display:table-cell;text-align:left;'>
					<textarea cols="50" name="txt_obs" id="txt_obs" type="text" title="Tipo de asistencia"></textarea>
				</div>
			</div>
		</div>
		
	</div>
<?php 

}
?>