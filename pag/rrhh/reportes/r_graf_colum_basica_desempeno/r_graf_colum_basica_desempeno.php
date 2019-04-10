<?php
include("var_r_graf_colum_basica_desempeno.php");
include($x."plantillas/graf_colum_basica_header.php");



$sql_e="SELECT DISTINCT empleado.id_empleado, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as empleado 
FROM persona,empleado,ingreso_salida, n_seccion
WHERE n_seccion.id_seccion=empleado.id_seccion AND persona.id_persona=empleado.id_persona AND empleado.id_empleado=ingreso_salida.id_empleado AND baja='0'";
if(isset($_POST['sel_seccion']) AND $_POST['sel_seccion']!=0)$sql_e=$sql_e." AND empleado.id_seccion = '".$_POST['sel_seccion']."'";//print $sql_e;
$sql_e=$sql_e." ORDER BY primer_apellido,segundo_apellido";
$rs_e=$db->Execute($sql_e) or die($db->ErrorMsg());

$sql_s="SELECT id_seccion, seccion FROM n_seccion ORDER BY seccion";
$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());


$sql_p_ini="SELECT distinct desempeno.id_periodo, concat(fecha_ini,'/',fecha_fin) AS periodo, fecha_ini FROM n_periodo, desempeno WHERE 1 AND n_periodo.id_periodo=desempeno.id_periodo";
if(isset($_POST['sel_empleado']) AND $_POST['sel_empleado']!=0)$sql_p_ini=$sql_p_ini." AND id_empleado = '".$_POST['sel_empleado']."'";
if(isset($_POST['sel_periodo_fin']) AND $_POST['sel_periodo_fin']!=0)$sql_p_ini=$sql_p_ini." AND fecha_fin <= '".$_POST['sel_periodo_fin']."'";
$sql_p_ini=$sql_p_ini." ORDER BY fecha_ini DESC";
$rs_p_ini=$db->Execute($sql_p_ini) or die($db->ErrorMsg());

$sql_comp="SELECT distinct desempeno.id_competencia, competencia FROM n_periodo, n_competencia, desempeno WHERE 1 AND n_periodo.id_periodo=desempeno.id_periodo AND n_competencia.id_competencia=desempeno.id_competencia";
if(isset($_POST['sel_periodo_ini']) AND $_POST['sel_periodo_ini']!=0)$sql_comp=$sql_comp." AND fecha_ini >= '".$_POST['sel_periodo_ini']."'";
if(isset($_POST['sel_periodo_fin']) AND $_POST['sel_periodo_fin']!=0)$sql_comp=$sql_comp." AND fecha_fin <= '".$_POST['sel_periodo_fin']."'";
if(isset($_POST['sel_empleado']) AND $_POST['sel_empleado']!=0)$sql_comp=$sql_comp." AND id_empleado = '".$_POST['sel_empleado']."'";//print $sql_comp;
$rs_com=$db->Execute($sql_comp) or die($db->ErrorMsg());


$sql_cri="SELECT distinct desempeno.id_criterio, concat(cod_criterio,' - ',criterio) as criterio FROM n_periodo, n_criterio, desempeno WHERE 1 AND n_periodo.id_periodo=desempeno.id_periodo AND n_criterio.id_criterio=desempeno.id_criterio";
if(isset($_POST['sel_periodo_ini']) AND $_POST['sel_periodo_ini']!=0)$sql_cri=$sql_cri." AND fecha_ini >= '".$_POST['sel_periodo_ini']."'";
if(isset($_POST['sel_periodo_fin']) AND $_POST['sel_periodo_fin']!=0)$sql_cri=$sql_cri." AND fecha_fin <= '".$_POST['sel_periodo_fin']."'";
if(isset($_POST['sel_empleado']) AND $_POST['sel_empleado']!=0)$sql_cri=$sql_cri." AND id_empleado = '".$_POST['sel_empleado']."'";
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
			Secci&oacute;n:
		</td>
		<td align="left" width="40%" colspan='3'>
			<select name="sel_seccion" id="sel_seccion" onchange="javascript:document.frm.submit();">
				<option>---------------Todas---------------</option>
				<?php for($s=0;$s<$rs_s->RecordCount();$s++){?>
				
					<option value="<?php print $rs_s->fields['id_seccion'];?>" <?php if(isset($_POST['sel_seccion'])){if($rs_s->fields['id_seccion']==$_POST['sel_seccion']){;?> selected="selected"<?php }}?> > <?php print $rs_s->fields['seccion'];?> </option>
					
				<?php $rs_s->MoveNext();}?>
			</select>
		</td>
		
	</tr>
	
	<tr>
		<td align="right" width="10%">
			Evaluado:
		</td>
		<td align="left" width="40%">
			<select name="sel_empleado" id="sel_empleado" onchange="javascript:document.frm.submit();">
				<option>--------------------------------------------Todos-------------------------------------------</option>
				<?php for($e=0;$e<$rs_e->RecordCount();$e++){?>
				
					<option value="<?php print $rs_e->fields['id_empleado'];?>" <?php if(isset($_POST['sel_empleado'])){if($rs_e->fields['id_empleado']==$_POST['sel_empleado']){;?> selected="selected"<?php }}?> > <?php print $rs_e->fields['empleado'];?> </option>
					
				<?php $rs_e->MoveNext();}?>
			</select>
		</td>	
		
		
		<td align="right" width="10%">			
			Per&iacute;odo:
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
		<?php 	
		if(isset($_POST['sel_periodo_ini']))
		{
			if($_POST['sel_periodo_ini']!=0)
			{
		?>
			<td align="right" >
				Competencia:
			</td>
			<td align="left">	
				<select name="sel_competencia" id="sel_competencia" onchange="javascript:document.frm.submit();">
					<option value="0">----------------------------------------Seleccionar----------------------------------------</option>
					<option value="all" <?php if(isset($_POST['sel_competencia'])){if('all'==$_POST['sel_competencia']){;?> selected="selected"<?php }}?>>--------------------------------------------Todas-------------------------------------------</option>
					<option value="all_s" <?php if(isset($_POST['sel_competencia'])){if('all_s'==$_POST['sel_competencia']){;?> selected="selected"<?php }}?>>-------------------------------------Todas separadas-------------------------------------</option>
					<?php for($e=0;$e<$rs_com->RecordCount();$e++){?>
					
						<option value="<?php print $rs_com->fields['id_competencia'];?>" <?php if(isset($_POST['sel_competencia'])){if($rs_com->fields['id_competencia']==$_POST['sel_competencia']){;?> selected="selected"<?php }}?> > <?php print $rs_com->fields['competencia'];?> </option>
					
					<?php $rs_com->MoveNext();}?>
				</select>
			</td>
		<?php 
			} 
			else
			{
		?>
				<td align="right" >&nbsp;</td>
				<td align="left">&nbsp;</td>
		<?php 
			}
		}
		else
		{
		?>	
			<td align="right" >&nbsp;</td>
			<td align="left">&nbsp;</td>
		<?php }?>
		
		<td align="right">		
			&nbsp;	
		</td>
		<td align="left">
			&nbsp;		
		</td>
		
	</tr>
	
	
	<?php if(isset($_POST['sel_competencia'])){if($_POST['sel_competencia']!=0){?>
	<tr>	
		<td align="right">
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
<?php if(isset($_POST['sel_periodo_ini']) AND $_POST['sel_periodo_ini']!=0 ){?>				

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