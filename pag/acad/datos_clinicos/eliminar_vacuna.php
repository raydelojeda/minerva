<?php
$x='../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{	
	$id_vacuna_est=$_POST['campo0'];
	$id_datos_clinicos=$_POST['campo1'];
	
	$del="DELETE FROM vacuna_est WHERE id_vacuna_est='".$id_vacuna_est."'";//print $sql_p;
	$db->Execute($del) or die($db->ErrorMsg());//print $rs_p;
	
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
	<?php
}
?>