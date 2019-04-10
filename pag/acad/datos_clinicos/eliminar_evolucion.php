<?php
$x='../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{	
	$id_evolucion_est=$_POST['campo0'];
	$id_datos_clinicos=$_POST['campo1'];
	
	$del="DELETE FROM evolucion_est WHERE id_evolucion_est='".$id_evolucion_est."'";//print $sql_p;
	$db->Execute($del) or die($db->ErrorMsg());//print $rs_p;
	
	$sql="SELECT id_evolucion_est, fecha, evolucion FROM evolucion_est 
	WHERE id_datos_clinicos='".$id_datos_clinicos."'";//print $sql;
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
	<?php
}
?>