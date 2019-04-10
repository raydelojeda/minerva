<?php
$x='../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{	
	$id_alergia_est=$_POST['campo0'];
	$id_datos_clinicos=$_POST['campo1'];
	
	$del="DELETE FROM alergia_est WHERE id_alergia_est='".$id_alergia_est."'";//print $sql_p;
	$db->Execute($del) or die($db->ErrorMsg());//print $rs_p;
	
	$sql="SELECT id_alergia_est, alergia, reaccion, descripcion FROM alergia_est, n_alergia 
	WHERE alergia_est.id_alergia=n_alergia.id_alergia AND id_datos_clinicos='".$id_datos_clinicos."'";//print $sql_p;
	$rs=$db->Execute($sql) or die($db->ErrorMsg());
	
	?>
	
	<input name="hdn_datos_alergia_<?php print $id_datos_clinicos;?>" id="hdn_datos_alergia_<?php print $id_datos_clinicos;?>" value='<?php print $id_datos_clinicos;?>' type="hidden"/>
	
	<div class='tabla_listar' style='display:table;width:100%;align:center'>

		<div style='display:table-row;'class="encabezado_col">
			<div style='display:table-cell;height:22px;width:25%;text-align:left;padding-left: 5px;'>Alergia</div>
			<div style='display:table-cell;height:22px;width:20%;text-align:left;padding-left: 5px;'>Reacci&oacute;n</div>
			<div style='display:table-cell;height:22px;width:50%;text-align:left;'>Descripci&oacute;n</div>
			<div style='display:table-cell;height:22px;width:5%;text-align:center;'>&nbsp;</div>
		</div>
	<?php	
	for($e=0;$e<$rs->RecordCount();$e++) 
	{
		$id_alergia_est=$rs->fields['id_alergia_est'];
		$alergia=$rs->fields['alergia'];
		$reaccion=$rs->fields['reaccion'];
		$descripcion=$rs->fields['descripcion'];
	?>
		<input name="hdn_alergia_<?php print $id_alergia_est;?>" id="hdn_alergia_<?php print $id_alergia_est;?>" value='<?php print $id_alergia_est;?>' type="hidden"/>
		<div <?php if($e % 2) print "class='row1'";else print "class='row0'";?> style='display:table-row;'>
			<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $alergia;?></div>
			<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $reaccion;?></div>
			<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $descripcion;?></div>
			<div style='display:table-cell;height:18px;text-align:center;padding-left: 5px;'>
				<a onClick="alertify.confirm('Confirma que desea eliminar la alergia?', function(e){if(e){ejecutar_ajax('eliminar_alergia.php','hdn_alergia_<?php print $id_alergia_est;?>, hdn_datos_alergia_<?php print $id_datos_clinicos;?>', 'div_alergias');}else {alertify.error('Has pulsado ' + alertify.labels.cancel);}});">
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