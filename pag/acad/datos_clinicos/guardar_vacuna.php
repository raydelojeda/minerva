<?php
$x='../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{	
	$id_estudiante=$_POST['campo0'];
	$id_vacuna=$_POST['campo1'];
	$fecha=$_POST['campo2'];
	$desc=$_POST['campo3'];
	
	$sql_datos_clinicos="SELECT id_datos_clinicos FROM datos_clinicos WHERE id_estudiante='".$id_estudiante."'";//print $sql_p;
	$rs_datos_clinicos=$db->Execute($sql_datos_clinicos) or die($db->ErrorMsg());//print $rs_p;
	
	$id_datos_clinicos=$rs_datos_clinicos->fields['id_datos_clinicos'];
	
	$sql="SELECT id_vacuna_est FROM vacuna_est WHERE id_vacuna='".$id_vacuna."' AND id_datos_clinicos='".$id_datos_clinicos."'";//print $sql_p;
	$rs=$db->Execute($sql) or die($db->ErrorMsg());//print $rs_p;
	
	if(!isset($rs->fields[0]))
	{
		$ins="INSERT INTO vacuna_est (id_datos_clinicos, id_vacuna, fecha, descripcion) 
		VALUES ('".$id_datos_clinicos."','".$id_vacuna."','".$fecha."','".$desc."')";//print $i_sql."<br>";
		$db->Execute($ins) or die($db->ErrorMsg());
	}
	else
	{
		$upd="UPDATE vacuna_est SET fecha='".$fecha."',descripcion='".$desc."'
		WHERE id_vacuna='".$id_vacuna."' AND id_datos_clinicos='".$id_datos_clinicos."'";//print $upd;// die();
		$db->Execute($upd) or die($db->ErrorMsg());
	}
	
	$sql="SELECT id_vacuna_est, vacuna, fecha, descripcion FROM vacuna_est, n_vacuna 
	WHERE vacuna_est.id_vacuna=n_vacuna.id_vacuna AND id_datos_clinicos='".$id_datos_clinicos."'";//print $sql_p;
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