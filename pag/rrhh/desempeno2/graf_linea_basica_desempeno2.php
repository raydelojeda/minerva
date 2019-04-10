<?php
include("var_graf_linea_basica.php");
include($x."plantillas/graf_linea_basica_header.php");

$sql_e="SELECT empleado.id_empleado, n_cargo.id_cargo, concat(cargo,' - ',identificacion,' - ',primer_nombre,' ',segundo_nombre,' ',primer_apellido,' ',segundo_apellido) as empleado, id_cargo_jefe FROM persona,empleado,cargo_empleado,n_cargo,usuario
WHERE persona.id_persona=empleado.id_persona AND persona.id_persona=usuario.id_persona AND empleado.id_empleado=cargo_empleado.id_empleado AND cargo_empleado.id_cargo=n_cargo.id_cargo AND usuario='".$_SESSION["user"]."' AND fecha_cargo=
(SELECT MAX(fecha_cargo) FROM persona,empleado,cargo_empleado,n_cargo,usuario WHERE persona.id_persona=empleado.id_persona AND persona.id_persona=usuario.id_persona AND empleado.id_empleado=cargo_empleado.id_empleado AND cargo_empleado.id_cargo=n_cargo.id_cargo AND usuario='".$_SESSION["user"]."')";
$rs_e=$db->Execute($sql_e) or die($db->ErrorMsg());

$sql_ev="SELECT empleado.id_empleado, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as empleado FROM persona,empleado
WHERE persona.id_persona=empleado.id_persona AND empleado.id_cargo_jefe='".$rs_e->fields['id_cargo_jefe']."'";

$sql_ev="SELECT empleado.id_empleado, n_cargo.id_cargo, concat(cargo,' - ',identificacion,' - ',primer_nombre,' ',segundo_nombre,' ',primer_apellido,' ',segundo_apellido) as empleado, id_cargo_jefe FROM persona,empleado,cargo_empleado,n_cargo
WHERE persona.id_persona=empleado.id_persona AND empleado.id_empleado=cargo_empleado.id_empleado AND cargo_empleado.id_cargo=n_cargo.id_cargo AND n_cargo.id_cargo='".$rs_e->fields['id_cargo_jefe']."' AND fecha_cargo=
(SELECT MAX(fecha_cargo) FROM persona,empleado,cargo_empleado,n_cargo WHERE persona.id_persona=empleado.id_persona AND empleado.id_empleado=cargo_empleado.id_empleado AND cargo_empleado.id_cargo=n_cargo.id_cargo AND n_cargo.id_cargo='".$rs_e->fields['id_cargo_jefe']."')";

$rs_ev=$db->Execute($sql_ev) or die($db->ErrorMsg());


$sql_p_ini="SELECT distinct desempeno.id_periodo, concat(fecha_ini,' - ',fecha_fin) AS periodo, fecha_ini FROM n_periodo, desempeno WHERE 1 AND n_periodo.id_periodo=desempeno.id_periodo";
if(isset($_POST['txt_id_evaluado']) AND $_POST['txt_id_evaluado']!=0)$sql_p_ini=$sql_p_ini." AND id_empleado = '".$_POST['txt_id_evaluado']."'";
if(isset($_POST['sel_periodo_fin']) AND $_POST['sel_periodo_fin']!=0)$sql_p_ini=$sql_p_ini." AND fecha_fin <= '".$_POST['sel_periodo_fin']."'";
$sql_p_ini=$sql_p_ini." ORDER BY fecha_ini DESC";//print $sql_p_ini;
$rs_p_ini=$db->Execute($sql_p_ini) or die($db->ErrorMsg());


$sql_p_fin="SELECT distinct desempeno.id_periodo, concat(fecha_ini,' - ',fecha_fin) AS periodo, fecha_fin FROM n_periodo, desempeno WHERE 1 AND n_periodo.id_periodo=desempeno.id_periodo";
if(isset($_POST['txt_id_evaluado']) AND $_POST['txt_id_evaluado']!=0)$sql_p_fin=$sql_p_fin." AND id_empleado = '".$_POST['txt_id_evaluado']."'";
if(isset($_POST['sel_periodo_ini']) AND $_POST['sel_periodo_ini']!=0)$sql_p_fin=$sql_p_fin." AND fecha_ini >= '".$_POST['sel_periodo_ini']."'";
$sql_p_fin=$sql_p_fin." ORDER BY fecha_ini DESC";
$rs_p_fin=$db->Execute($sql_p_fin) or die($db->ErrorMsg());


$sql_comp="SELECT distinct desempeno.id_competencia, competencia FROM n_periodo, n_competencia, desempeno WHERE 1 AND n_periodo.id_periodo=desempeno.id_periodo AND n_competencia.id_competencia=desempeno.id_competencia";
if(isset($_POST['sel_periodo_ini']) AND $_POST['sel_periodo_ini']!=0)$sql_comp=$sql_comp." AND fecha_ini >= '".$_POST['sel_periodo_ini']."'";
if(isset($_POST['sel_periodo_fin']) AND $_POST['sel_periodo_fin']!=0)$sql_comp=$sql_comp." AND fecha_fin <= '".$_POST['sel_periodo_fin']."'";
if(isset($_POST['txt_id_evaluado']) AND $_POST['txt_id_evaluado']!=0)$sql_comp=$sql_comp." AND id_empleado = '".$_POST['txt_id_evaluado']."'";//print $sql_comp;
$rs_com=$db->Execute($sql_comp) or die($db->ErrorMsg());


$sql_cri="SELECT distinct desempeno.id_criterio, concat(cod_criterio,' - ',criterio) as criterio FROM n_periodo, n_criterio, desempeno WHERE 1 AND n_periodo.id_periodo=desempeno.id_periodo AND n_criterio.id_criterio=desempeno.id_criterio";
if(isset($_POST['sel_periodo_ini']) AND $_POST['sel_periodo_ini']!=0)$sql_cri=$sql_cri." AND fecha_ini >= '".$_POST['sel_periodo_ini']."'";
if(isset($_POST['sel_periodo_fin']) AND $_POST['sel_periodo_fin']!=0)$sql_cri=$sql_cri." AND fecha_fin <= '".$_POST['sel_periodo_fin']."'";
if(isset($_POST['txt_id_evaluado']) AND $_POST['txt_id_evaluado']!=0)$sql_cri=$sql_cri." AND id_empleado = '".$_POST['txt_id_evaluado']."'";
if(isset($_POST['sel_competencia']) AND $_POST['sel_competencia']!=0)$sql_cri=$sql_cri." AND id_competencia = '".$_POST['sel_competencia']."'";//print $sql_cri;
$rs_cri=$db->Execute($sql_cri) or die($db->ErrorMsg());

?>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

&nbsp;
<br>
<div align="center">
<table class="tabla_generica" align="center">
	<tr>
		<td align="left" colspan="4">
		&nbsp;
		</td>	
	</tr>
	<tr>
		<td align="right" width="10%">
			Evaluador:
		</td>
		<td align="left" width="40%">
			<input name="txt_evaluador" readonly id="txt_evaluador" value="<?php print $rs_ev->fields['empleado'];?>" size="70">
			<input name="txt_id_evaluador" type="hidden" value="<?php print $rs_ev->fields['id_empleado'];?>">
		</td>	
		<td align="right" width="10%">			
			Per&iacute;odo inicial:
		</td>
		<td align="left" width="40%">
			<select name="sel_periodo_ini" id="sel_periodo_ini" onchange="javascript:document.frm.submit();">
				<option value="0">---------------Seleccionar---------------</option>
				<?php for($p=0;$p<$rs_p_ini->RecordCount();$p++){?>
				
					<option value="<?php print $rs_p_ini->fields['fecha_ini'];?>" <?php if(isset($_POST['sel_periodo_ini'])){if($rs_p_ini->fields['fecha_ini']==$_POST['sel_periodo_ini']){;?> selected="selected"<?php }}?> > <?php print $rs_p_ini->fields['periodo'];?> </option>
					
				<?php $rs_p_ini->MoveNext();}?>
			</select>			
		</td>	
		
	</tr>
	
	<tr>
		<td align="right" width="10%">
			Evaluado:
		</td>
		<td align="left">
			<input name="txt_evaluado" readonly id="txt_evaluado" value="<?php print $rs_e->fields['empleado'];?>" size="70">
			<input name="txt_id_evaluado" type="hidden" value="<?php print $rs_e->fields['id_empleado'];?>">
		</td>	
		<td align="right">		
			Per&iacute;odo final:
		</td>
		<td align="left">
			<select name="sel_periodo_fin" id="sel_periodo_fin" onchange="javascript:document.frm.submit();">
				<option value="0">---------------Seleccionar---------------</option>
				<?php for($p=0;$p<$rs_p_fin->RecordCount();$p++){?>
				
					<option value="<?php print $rs_p_fin->fields['fecha_fin'];?>" <?php if(isset($_POST['sel_periodo_fin'])){if($rs_p_fin->fields['fecha_fin']==$_POST['sel_periodo_fin']){;?> selected="selected"<?php }}?> > <?php print $rs_p_fin->fields['periodo'];?> </option>
					
				<?php $rs_p_fin->MoveNext();}?>
			</select>			
		</td>
		
	</tr>
	
	<?php 	
		if(isset($_POST['sel_periodo_ini']) AND isset($_POST['sel_periodo_fin']))
		if($_POST['sel_periodo_ini']!=0 AND $_POST['sel_periodo_fin']!=0)
		{
	?>
	<tr>
		<td align="right" width="10%">
			Competencia:
		</td>
		<td align="left" colspan="3">	
			<select name="sel_competencia" id="sel_competencia" onchange="javascript:document.frm.submit();">
				<option value="0">----------------------------------------Seleccionar----------------------------------------</option>
				<option value="all" <?php if(isset($_POST['sel_competencia'])){if('all'==$_POST['sel_competencia']){;?> selected="selected"<?php }}?>>--------------------------------------------Todas-------------------------------------------</option>
				<option value="all_s" <?php if(isset($_POST['sel_competencia'])){if('all_s'==$_POST['sel_competencia']){;?> selected="selected"<?php }}?>>-------------------------------------Todas separadas-------------------------------------</option>
				<?php for($e=0;$e<$rs_com->RecordCount();$e++){?>
				
					<option value="<?php print $rs_com->fields['id_competencia'];?>" <?php if(isset($_POST['sel_competencia'])){if($rs_com->fields['id_competencia']==$_POST['sel_competencia']){;?> selected="selected"<?php }}?> > <?php print $rs_com->fields['competencia'];?> </option>
				
				<?php $rs_com->MoveNext();}?>
			</select>
		</td>
	</tr>
	<?php } if(isset($_POST['sel_competencia'])){if($_POST['sel_competencia']!=0){?>
	<tr>	
		<td align="right" width="10%">
			Criterio:
		</td>
		<td align="left" colspan="3">	
			<select name="sel_criterio" id="sel_criterio" onchange="javascript:document.frm.submit();">
				<option value="0">---------------Seleccionar---------------</option>
				<?php for($p=0;$p<$rs_cri->RecordCount();$p++){?>
				
					<option value="<?php print $rs_cri->fields['id_criterio'];?>" <?php if(isset($_POST['sel_criterio'])){if($rs_cri->fields['id_criterio']==$_POST['sel_criterio']){;?> selected="selected"<?php }}?> > <?php print $rs_cri->fields['criterio'];?> </option>
					
				<?php $rs_cri->MoveNext();}?>
			</select>			
		</td>
	</tr>
	<?php }}?>
	<tr>
		<td align="left" colspan="3">
		&nbsp;
		</td>	
	</tr>
</table>
</div>
<?php if(isset($_POST['sel_periodo_ini']) AND isset($_POST['sel_periodo_fin']) AND $_POST['sel_periodo_ini']!=0 AND $_POST['sel_periodo_fin']!=0){?>				

<script src="<?php echo $x;?>js/Highcharts-4.1.4/js/highcharts.js"></script>
<script src="<?php echo $x;?>js/Highcharts-4.1.4/js/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<?php
}
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/graf_linea_basica_footer.php");
?>