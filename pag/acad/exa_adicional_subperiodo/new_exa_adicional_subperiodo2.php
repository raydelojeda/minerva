<?php
include("variables.php");
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)
$disable='';
$checked='';
$orden='';
$publica_nota='';
$sustituye_nota='';
$tipo='';

$sql_t="select id_tipo_examen as id_tipo_examen, concat(tipo_examen) as tipo_examen FROM n_tipo_examen WHERE 1";
$rs_t=$db->Execute($sql_t) or die($db->ErrorMsg());

$sql_top="SELECT id_examen_adicional as id_top, concat(abv_examen,' - ',examen_adicional) as top FROM n_examen_adicional WHERE 1";
$rs_top=$db->Execute($sql_top) or die($db->ErrorMsg());

$sql_left="SELECT id_tipo_actividad as id_left, concat(subperiodo_evaluativo,' - ',asignatura,' - ',tipo_actividad_examen) as leeft
FROM n_asignatura, n_tipo_actividad, n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica WHERE 1 AND n_tipo_actividad.id_asignatura=n_asignatura.id_asignatura 
AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo 
AND n_tipo_actividad.id_subperiodo_evaluativo=n_subperiodo_evaluativo.id_subperiodo_evaluativo AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica 
AND n_conf_academica.activa='1' ORDER BY subperiodo_evaluativo,asignatura,tipo_actividad_examen";
$rs_left=$db->Execute($sql_left) or die($db->ErrorMsg());

$rs_top->MoveFirst();
for($top=0;$top<$rs_top->RecordCount();$top++)
{
	$rs_left->MoveFirst();
	for($left=0;$left<$rs_left->RecordCount();$left++)
	{
		$cbx = (string) 'checkbox_'.$rs_left->fields['id_left'].$rs_top->fields['id_top'];
		
		if(isset($_POST[$cbx]))
		{
			if(isset($_POST['sel_orden_'.$rs_top->fields['id_top']]) AND $orden!='no')
			{
				if($_POST['sel_orden_'.$rs_top->fields['id_top']]!='')
				$orden='ok';
				else
				{$mensaje=$mensaje.'<br>Debe escoger el Orden del examen: '.$rs_top->fields['top'];$orden='no';}
			}
			
			if(isset($_POST['sel_publica_nota_'.$rs_top->fields['id_top']]) AND $publica_nota!='no')
			{
				if($_POST['sel_publica_nota_'.$rs_top->fields['id_top']]!='')
				$publica_nota='ok';
				else
				{$mensaje=$mensaje.'<br>Debe escoger Si publica la nota del examen: '.$rs_top->fields['top'];$publica_nota='no';}
			}
			
			if(isset($_POST['sel_sustituye_nota_'.$rs_top->fields['id_top']]) AND $sustituye_nota!='no')
			{
				if($_POST['sel_sustituye_nota_'.$rs_top->fields['id_top']]!='')
				$sustituye_nota='ok';
				else
				{$mensaje=$mensaje.'<br>Debe escoger si sustituye la nota del subper&iacute;odo: '.$rs_top->fields['top'];$sustituye_nota='no';}
			}
			
			if(isset($_POST['sel_tipo_'.$rs_top->fields['id_top']]) AND $tipo!='no')
			{
				if($_POST['sel_tipo_'.$rs_top->fields['id_top']]!='')
				$tipo='ok';
				else
				{$mensaje=$mensaje.'<br>Debe escoger el Tipo de examen de: '.$rs_top->fields['top'];$tipo='no';}
			}
			
			if($orden=='ok' AND $publica_nota=='ok' AND $tipo=='ok')
			{
				$i_sql="INSERT INTO n_exa_adicional_subperiodo(id_examen_adicional, id_tipo_examen, id_tipo_actividad, publica_nota, sustituye_nota, orden) 
				VALUES ('".$rs_top->fields['id_top']."','".$_POST['sel_tipo_'.$rs_top->fields['id_top']]."','".$rs_left->fields['id_left']."', '".$_POST['sel_publica_nota_'.$rs_top->fields['id_top']]."', '".$_POST['sel_sustituye_nota_'.$rs_top->fields['id_top']]."', '".$_POST['sel_orden_'.$rs_top->fields['id_top']]."')";//print $i_sql."<br>";
				$db->Execute($i_sql) or die($db->ErrorMsg());
			}		

		}
		//else
		//$mensaje='Debe llenar los datos requeridos';
		
	$rs_left->MoveNext();
	}
	
$orden='';
$publica_nota='';
$tipo='';

$rs_top->MoveNext();
}
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->


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

	<tr class="encabezado">
		<td align="right" width='40%'  colspan='2'>Orden del examen adicional:</td>
		
		<?php $rs_top->MoveFirst();for($t=0;$t<$rs_top->RecordCount();$t++){ ?>
		<td height="25" align="center">
			<input id="sel_orden_<?php print $rs_top->fields['id_top'];?>" type="number" maxlength="10" size="10"title="Orden" name="sel_orden_<?php print $rs_top->fields['id_top'];?>" placeholder="">
		</td>
		<?php $rs_top->MoveNext();}?>
	</tr>
	
	<tr class="encabezado">
		<td align="right" width='40%'  colspan='2'>Se publica la nota del examen? (nota del examen o nota para aprobar):</td>
		
		<?php $rs_top->MoveFirst();for($t=0;$t<$rs_top->RecordCount();$t++){ ?>
		<td height="25" align="center">
			<select name="sel_sustituye_nota_<?php print $rs_top->fields['id_top'];?>" id="sel_sustituye_nota_<?php print $rs_top->fields['id_top'];?>">
				<option value=''>--------Seleccionar--------</option>
				<option value='1'>Si</option>
				<option value='0'>No</option>
				
			</select>
		</td>
		<?php $rs_top->MoveNext();}?>
	</tr>
	
	<tr class="encabezado">
		<td align="right" width='40%'  colspan='2'>Sustituye la nota del per&iacute;odo lectivo? Si es "Si" ser&iacute;a la nota del per&iacute;odo. Si es "No" se calcular&iacute;a la nota del per&iacute;odo lectivo seg&uacute;n los pesos:</td>
		
		<?php $rs_top->MoveFirst();for($t=0;$t<$rs_top->RecordCount();$t++){ ?>
		<td height="25" align="center">
			<select name="sel_publica_nota_<?php print $rs_top->fields['id_top'];?>" id="sel_publica_nota_<?php print $rs_top->fields['id_top'];?>">
				<option value=''>--------Seleccionar--------</option>
				<option value='1'>Si</option>
				<option value='0'>No</option>
				
			</select>
		</td>
		<?php $rs_top->MoveNext();}?>
	</tr>
	
	<tr class="encabezado">
		<td align="right" width='40%'  colspan='2'>Tipo de examen:</td>
		
		<?php $rs_top->MoveFirst();for($t=0;$t<$rs_top->RecordCount();$t++){ ?>
		<td height="25" align="center">
			<select name="sel_tipo_<?php print $rs_top->fields['id_top'];?>" id="sel_tipo_<?php print $rs_top->fields['id_top'];?>">
				<option value=''>--------Seleccionar--------</option>
				<?php $rs_t->MoveFirst();for($tip=0;$tip<$rs_t->RecordCount();$tip++){?>					
					<option value="<?php print $rs_t->fields['id_tipo_examen'];?>"> <?php print $rs_t->fields['tipo_examen'];?> </option>						
				<?php $rs_t->MoveNext();}?>
			</select>
		</td>
		<?php $rs_top->MoveNext();}?>
	</tr>
	
	<tr class="encabezado">
		<td align="left" >Examen evaluativo y asignatura </td><td align="right" >Nombre del examen adicional:</td>
		
		<?php $rs_top->MoveFirst();for($top=0;$top<$rs_top->RecordCount();$top++){ ?>
		<td height="25" align="center">
			<?php print $rs_top->fields['top']; ?>&nbsp;<input name='checkbox_<?php print $rs_top->fields['id_top'];?>' onclick='marcar_p(<?php print $rs_top->fields['id_top']; ?>);' type='checkbox'/>
		</td>
		<?php $rs_top->MoveNext();}?>
	</tr>
	
	<?php 
	for($left=0;$left<$rs_left->RecordCount();$left++)
	{
		$rs_top->MoveFirst();
		print "<tr ";if($left % 2) print "class='row1'";else print "class='row0'";print " >";?>	
		<td align="left" height="25"  colspan='2'>
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