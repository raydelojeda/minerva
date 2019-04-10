<?php
$x='../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{	
	$id_estudiante=$_POST['campo0'];
	$altura=$_POST['campo1'];
	$peso=$_POST['campo2'];
	$fecha=$_POST['campo3'];
	
	$sql_datos_clinicos="SELECT id_datos_clinicos FROM datos_clinicos WHERE id_estudiante='".$id_estudiante."'";//print $sql_p;
	$rs_datos_clinicos=$db->Execute($sql_datos_clinicos) or die($db->ErrorMsg());//print $rs_p;
	
	$id_datos_clinicos=$rs_datos_clinicos->fields['id_datos_clinicos'];
	
	$sql="SELECT id_eval_nutricional_est FROM eval_nutricional_est WHERE fecha='".$fecha."' AND id_datos_clinicos='".$id_datos_clinicos."'";//print $sql_p;
	$rs=$db->Execute($sql) or die($db->ErrorMsg());//print $rs_p;
	
	if(!isset($rs->fields[0]))
	{
		$ins="INSERT INTO eval_nutricional_est (id_datos_clinicos, fecha, altura, peso) 
		VALUES ('".$id_datos_clinicos."','".$fecha."','".$altura."','".$peso."')";//print $i_sql."<br>";
		$db->Execute($ins) or die($db->ErrorMsg());
	}
	else
	{
		$upd="UPDATE eval_nutricional_est SET altura='".$altura."',peso='".$peso."'
		WHERE fecha='".$fecha."' AND id_datos_clinicos='".$id_datos_clinicos."'";//print $upd;// die();
		$db->Execute($upd) or die($db->ErrorMsg());
	}
	
	$sql="SELECT id_eval_nutricional_est, fecha, altura, peso FROM eval_nutricional_est 
	WHERE id_datos_clinicos='".$id_datos_clinicos."'";//print $sql_p;
	$rs=$db->Execute($sql) or die($db->ErrorMsg());
	
	?>
	<input name="hdn_datos_eval_<?php print $id_datos_clinicos;?>" id="hdn_datos_eval_<?php print $id_datos_clinicos;?>" value='<?php print $id_datos_clinicos;?>' type="hidden"/>
		
	<div class='tabla_listar' style='display:table;width:100%;align:center'>

		<div style='display:table-row;'class="encabezado_col">
			<div style='display:table-cell;height:22px;width:30%;text-align:left;padding-left: 5px;'>Altura</div>
			<div style='display:table-cell;height:22px;width:30%;text-align:left;padding-left: 5px;'>Peso</div>
			<div style='display:table-cell;height:22px;width:35%;text-align:left;'>Fecha</div>
			<div style='display:table-cell;height:22px;width:5%;text-align:center;'>&nbsp;</div>
		</div>
	<?php	
	for($e=0;$e<$rs->RecordCount();$e++) 
	{
		$id_eval_nutricional_est=$rs->fields['id_eval_nutricional_est'];
		$altura=$rs->fields['altura'];
		$peso=$rs->fields['peso'];
		$fecha=$rs->fields['fecha'];
	?>
		<input name="hdn_eval_<?php print $id_eval_nutricional_est;?>" id="hdn_eval_<?php print $id_eval_nutricional_est;?>" value='<?php print $id_eval_nutricional_est;?>' type="hidden"/>
		
		<div <?php if($e % 2) print "class='row1'";else print "class='row0'";?> style='display:table-row;'>
			<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $altura;?></div>
			<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $peso;?></div>
			<div style='display:table-cell;height:18px;text-align:left;padding-left: 5px;'><?php print $fecha;?></div>
			<div style='display:table-cell;height:18px;text-align:center;padding-left: 5px;'>
				<a onClick="alertify.confirm('Confirma que desea eliminar la evaluaci&oacute;n nutricional?', function(e){if(e){ejecutar_ajax('eliminar_evaluacion.php','hdn_eval_<?php print $id_eval_nutricional_est;?>, hdn_datos_eval_<?php print $id_datos_clinicos;?>', 'div_evaluaciones');}else {alertify.error('Has pulsado ' + alertify.labels.cancel);}});">
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