<?php
include("variables.php");
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)
$disable='';
$checked='';

$sql_left="SELECT id_asignatura as id_left, concat(abreviatura,' - ',asignatura) AS leeft FROM n_asignatura";
$rs_left=$db->Execute($sql_left) or die($db->ErrorMsg());

$sql_top="SELECT n_periodo_evaluativo.id_periodo_evaluativo AS id_top, periodo_evaluativo AS top FROM n_periodo_evaluativo, n_periodo_lectivo,n_conf_academica 
WHERE 1 AND n_periodo_lectivo.id_periodo_lectivo=n_periodo_evaluativo.id_periodo_lectivo AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica AND n_conf_academica.activa='1'";
$rs_top=$db->Execute($sql_top) or die($db->ErrorMsg());

if(isset($_POST['examen_eval']) AND isset($_POST['abv_tipo_examen_eval']) AND isset($_POST['peso']))
{
	if($_POST['examen_eval']!='' AND $_POST['abv_tipo_examen_eval']!='' AND $_POST['peso']!='')
	{
		$rs_top->MoveFirst();
		for($top=0;$top<$rs_top->RecordCount();$top++)
		{
			$rs_left->MoveFirst();
			for($left=0;$left<$rs_left->RecordCount();$left++)
			{
				$cbx = (string) 'checkbox_'.$rs_left->fields['id_left'].$rs_top->fields['id_top'];
				
				if(isset($_POST[$cbx]))
				{
					/*$sql="SELECT id_examen_periodo_eval FROM n_examen_periodo_eval
					WHERE id_periodo_evaluativo='".$rs_top->fields['id_top']."' AND id_asignatura='".$rs_left->fields['id_left']."'";//print $sql."<br>";//die();
					$rs=$db->Execute($sql) or die($db->ErrorMsg());
					
					if(!isset($rs->fields['id_examen_periodo_eval']))
					{*/					
						$i_sql="INSERT INTO n_examen_periodo_eval(id_periodo_evaluativo, id_asignatura, examen_eval, abv_tipo_examen_eval, peso) 
						VALUES ('".$rs_top->fields['id_top']."','".$rs_left->fields['id_left']."','".$_POST['examen_eval']."', '".$_POST['abv_tipo_examen_eval']."', '".$_POST['peso']."')";//print $i_sql."<br>";
						$db->Execute($i_sql) or die($db->ErrorMsg());
					/*}
					else
					{
						$u_sql="UPDATE n_examen_periodo_eval SET examen_eval='".$_POST['examen_eval']."', abv_tipo_examen_eval='".$_POST['abv_tipo_examen_eval']."', peso='".$_POST['peso']."'
						WHERE id_periodo_evaluativo='".$rs_top->fields['id_top']."' AND id_asignatura='".$rs_left->fields['id_left']."'";//print $u_sql."<br>";
						$db->Execute($u_sql) or die($db->ErrorMsg());
					}*/
				}
				
			$rs_left->MoveNext();
			}
		$rs_top->MoveNext();
		}
	}
}
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->


<script type="text/javascript" class="js-code-basic">
$(document).ready(function() {
$(".js-example-basic-single_cliente").select2();
});
</script>


<tr>
<td>
<?php
if(isset($rs_left))
$rs_left->MoveFirst();

if(isset($rs_top))
$rs_top->MoveFirst();
?>
<div align="center">
<table align="center" width='100%'>
	<tr >
		<td colspan="<?php print $rs_top->RecordCount()+1; ?>" align="left">
			Examen o actividad:
			<input id="examen_eval" type="text" value="" maxlength="50" size="50" onclick="" title="Examen lectivo" name="examen_eval" placeholder="">
			&nbsp;
			
			Abreviatura del examen o actividad:
			<input id="abv_tipo_examen_eval" type="text" value="" maxlength="20" size="20" onclick="" title="Abreviatura" name="abv_tipo_examen_eval" placeholder="">
			&nbsp;
			
			Peso para el promedio:
			<input id="peso" type="text" value="" maxlength="10" size="10" onclick="" title="Peso" name="peso" placeholder="">
			
			<?php $msg='La informaci&oacute;n a insertar para cada asignatura y per&iacute;odo evaluativo que est&eacute;n activadas, es la ingresada en las cajas de texto.';?>
			<a onMouseOver="return overlib('<?php print $msg;?>', ABOVE, RIGHT);"onMouseOut="return nd();"><img src='<?php print $x."img/general/help.png";?>'></a>
			
			
			
		</td>
	</tr>
	
	<tr class="encabezado">
		<td align="left" width='40%'>&nbsp;</td>
		
		<?php for($top=0;$top<$rs_top->RecordCount();$top++){ ?>
		<td height="25" align="center">
			<?php print $rs_top->fields['top']; ?>&nbsp;<input name='checkbox_<?php print $rs_top->fields['id_top']; ?>' onclick='marcar_p(<?php print $rs_top->fields['id_top']; ?>);' type='checkbox'/>
		</td>
		<?php $rs_top->MoveNext();}?>
	</tr>
	
	<?php 
	for($left=0;$left<$rs_left->RecordCount();$left++)
	{
		$rs_top->MoveFirst();
		print "<tr ";if($left % 2) print "class='row1'";else print "class='row0'";print " >";?>	
		<td align="left" height="25">
			<a class='hlink' onmouseover="return overlib('<?php //print $rs_c->fields['descripcion']; ?>', ABOVE, RIGHT)" onmouseout='return nd();'>
				<?php if(!isset($p))$p=1;print $p .' - '.$rs_left->fields['leeft'];$p=$p+1;?>
			</a>
		</td>
		
		<?php for($top=0;$top<$rs_top->RecordCount();$top++)
		{
		?>
			<td height="25" align="center">		
				<section>
					<div class="checkbox-2">
						<input class="checkbox_oculto" name='checkbox_<?php print $rs_left->fields['id_left'].$rs_top->fields['id_top']; ?>' <?php print $disable; ?> <?php print $checked; ?> type='checkbox' value='checkbox_<?php print $rs_left->fields['id_left'].$rs_top->fields['id_top'] ?>'type="checkbox" id="<?php print $rs_left->fields['id_left'].$rs_top->fields['id_top']; ?>" />
						<label for="<?php print $rs_left->fields['id_left'].$rs_top->fields['id_top']; ?>"><?php if($disable)print "X"; ?></label>
					</div>
				</section>
			</td>
		<?php
			// $cadenacheckboxp contiene los id del elemento
			if($cadenacheckboxp == ""){$cadenacheckboxp = $rs_left->fields['id_left'].$rs_top->fields['id_top'];}
			else{$cadenacheckboxp .= ",".$rs_left->fields['id_left'].$rs_top->fields['id_top'];}
			// $cadenacheckboxp contiene los id del elemento
		
			$rs_top->MoveNext();
			$checked="";
		}
		?>
	</tr>
	
	<?php
	$rs_left->MoveNext();
	}
	?>
	
</table>
<div>
</td>
</tr>

<?php
if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];
if(isset($return[0]))
$mensaje=$return[0];
$obj->Imprimir_mensaje($mensaje);
?>

<br>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
include($x."plantillas/new_footer.php");
?>