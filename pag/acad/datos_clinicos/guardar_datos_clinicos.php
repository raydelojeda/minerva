<?php
$x='../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{	
	$id_estudiante=$_POST['campo0'];
	
	$sql="SELECT id_datos_clinicos FROM datos_clinicos WHERE id_estudiante='".$id_estudiante."'";//print $sql_p;
	$rs=$db->Execute($sql) or die($db->ErrorMsg());//print $rs_p;
	
	if(!isset($rs->fields[0]))
	{
		$ins="INSERT INTO datos_clinicos (id_estudiante, vac_completa, aut_medicar, aut_vacunar) 
		VALUES ('".$id_estudiante."','1','1','1')";//print $i_sql."<br>";
		$db->Execute($ins) or die($db->ErrorMsg());
	}
	else
	{
		$id_datos_clinicos=$rs->fields['id_datos_clinicos'];
		
		$sql="SELECT id_enfermedad_est, enfermedad, tuvo, tiene, descripcion FROM enfermedad_est, n_enfermedad 
		WHERE enfermedad_est.id_enfermedad=n_enfermedad.id_enfermedad AND id_datos_clinicos='".$id_datos_clinicos."'";//print $sql_p;
		$rs=$db->Execute($sql) or die($db->ErrorMsg());
		
		?>
		<input name="hdn_datos_<?php print $id_datos_clinicos;?>" id="hdn_datos_<?php print $id_datos_clinicos;?>" value='<?php print $id_datos_clinicos;?>' type="hidden"/>
			
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
					<a onClick="alertify.confirm('Confirma que desea eliminar la enfermedad?', function(e){if(e){ejecutar_ajax('eliminar_enfermedad.php','hdn_enfermedad_<?php print $id_enfermedad_est;?>, hdn_datos_<?php print $id_datos_clinicos;?>', 'div_enfermedades');}else {alertify.error('Has pulsado ' + alertify.labels.cancel);}});">
						<img width=13px src="<?php print $x;?>img/general/eliminar.png">
					</a>
				</div>
			</div>
		<?php
		$rs->MoveNext();
		}
		?>					
		</div>
		<?php
	}
}
?>