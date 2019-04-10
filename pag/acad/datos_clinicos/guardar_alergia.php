<?php
$x='../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{	
	$id_estudiante=$_POST['campo0'];
	$id_alergia=$_POST['campo1'];
	$reaccion=$_POST['campo2'];
	$desc=$_POST['campo3'];
	
	$sql_datos_clinicos="SELECT id_datos_clinicos FROM datos_clinicos WHERE id_estudiante='".$id_estudiante."'";//print $sql_p;
	$rs_datos_clinicos=$db->Execute($sql_datos_clinicos) or die($db->ErrorMsg());//print $rs_p;
	
	$id_datos_clinicos=$rs_datos_clinicos->fields['id_datos_clinicos'];
	
	$sql="SELECT id_alergia_est FROM alergia_est WHERE id_alergia='".$id_alergia."' AND id_datos_clinicos='".$id_datos_clinicos."'";//print $sql_p;
	$rs=$db->Execute($sql) or die($db->ErrorMsg());//print $rs_p;
	
	if(!isset($rs->fields[0]))
	{
		$ins="INSERT INTO alergia_est (id_datos_clinicos, id_alergia, reaccion, descripcion) 
		VALUES ('".$id_datos_clinicos."','".$id_alergia."','".$reaccion."','".$desc."')";//print $i_sql."<br>";
		$db->Execute($ins) or die($db->ErrorMsg());
	}
	else
	{
		$upd="UPDATE alergia_est SET reaccion='".$reaccion."',descripcion='".$desc."'
		WHERE id_alergia='".$id_alergia."' AND id_datos_clinicos='".$id_datos_clinicos."'";//print $upd;// die();
		$db->Execute($upd) or die($db->ErrorMsg());
	}
	
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