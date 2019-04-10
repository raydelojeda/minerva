<tr>
	<td align="right" width='5%'>
		&nbsp;
	</td>
	
	<td colspan='1' align="left">
		&nbsp;
	</td>
	
	<td align="center" width='20%'>
		Forma de pago
	</td>
	
	<td align="center" width='20%'>
		Cantidad
	</td>
	
	<td align="left" width='20%'>
		Precio ($)
	</td>
	
	<td align="right">
		&nbsp;
	</td>
	
	<td align="right">
		&nbsp;
	</td>
	
	<td align="left" width='20%'>
		Subtotal
	</td>
	
</tr>

<?php
$total=0;
$subtotal=0;

$filas=1;
if(isset($_POST['filas']))
$filas=$_POST['filas'];

$sql_forma="SELECT * FROM n_forma_pago";//print $sql_forma;
$rs_forma=$db->Execute($sql_forma) or die($db->ErrorMsg());
	
for($f=1;$f<=$filas;$f++)
{

?>

<tr>
	<td align="right">
		Producto:
	</td>
	
	<td colspan='1' align="left">
		<select name="sel_pro<?php echo $f;?>" id="sel_pro<?php echo $f;?>" <?php if($f==$filas) print "autofocus='autofocus'"; ?> onchange="javascript:document.frm.submit();">
			<option value="0">--------------Seleccionar--------------</option>
			<?php for($g=0;$g<$rs_pro->RecordCount();$g++){?>
			
				<option value="<?php print $rs_pro->fields['id_pro'];?>" <?php if(isset($_POST['sel_pro'.$f])){if($rs_pro->fields['id_pro']==$_POST['sel_pro'.$f]){?> selected="selected"<?php }}?> > <?php print $rs_pro->fields['pro'];?> </option>
				
			<?php $rs_pro->MoveNext();}$rs_pro->MoveFirst();if(isset($_POST['sel_pro'.$f])) if($_POST['sel_pro'.$f]==0)$filas=$f;?>
		</select>
	</td>
	
	<td align="center">
	<?php if(isset($_POST['sel_pro'.$f])){if($_POST['sel_pro'.$f]!=0){?>
		<select style="width:200px" name="sel_forma_pago<?php echo $f;?>" id="sel_forma_pago<?php echo $f;?>" onchange='forma_pago(<?php echo $f;?>)'>
			<?php for($k=0;$k<$rs_forma->RecordCount();$k++){?>
				<option value="<?php print $rs_forma->fields['id_forma_pago'];?>" <?php if(isset($_POST['sel_forma_pago'.$f])){if($rs_forma->fields['id_forma_pago']==$_POST['sel_forma_pago'.$f]){?> selected="selected"<?php }}?> > <?php print $rs_forma->fields['forma_pago'];?> </option>
			<?php $rs_forma->MoveNext();}$rs_forma->MoveFirst();?>
		</select>
	<?php }}?>
	</td>
	
	<td align="center">
	<?php if(isset($_POST['sel_pro'.$f])){if($_POST['sel_pro'.$f]!=0){?>
		<input type="text" name="txt_cantidad<?php echo $f;?>" onblur="javascript:document.frm.submit();" id="txt_cantidad<?php echo $f;?>"  title="Cantidad <?php echo $f;?>"  value="<?php print ${'cant_'.$f};?>" size="5" />
	<?php }}?>
	</td>
	
	
	
	<?php
	if(isset($_POST['sel_pro'.$f]))
	{
		if($_POST['sel_pro'.$f]!=0)
		{
			$subtotal=bcmul(${'prec_'.$f}, ${'cant_'.$f},14);//print " prec ".${'prec_'.$f}." cant ".${'cant_'.$f}." sub ".$subtotal;
			$total=bcadd($total,$subtotal,14);	
		}
	}
	
	
	//$saldo_final=bcsub($saldo_disponible,$total,14);
	?>
	
	<td align="left"><b>
		<?php if(isset($_POST['sel_pro'.$f])){if($_POST['sel_pro'.$f]!=0){ print number_format(${'prec_'.$f}, 2, ',', '');}}?>
	</b></td>
	
	<td align="right">
		&nbsp;
	</td>
	
	<td align="right">
		&nbsp;
	</td>
	
	<td align="left"><b>
		<?php if(isset($_POST['sel_pro'.$f])){if($_POST['sel_pro'.$f]!=0){ print number_format($subtotal, 2, ',', '');}}?>
		<input type="hidden" name="txt_subtotal<?php echo $f;?>" id="txt_subtotal<?php echo $f;?>" value="<?php print number_format($subtotal, 2, ',', '');$subtotal=0;?>"/>
	</b></td>
	
</tr>

<?php 
}
?>
<input name="filas" type="hidden" value="<?php if($filas<7)echo $filas+1;else echo $filas;?>"/>