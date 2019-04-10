<?php
include("variables.php");
include($x."config/clases.inc.php");

date_default_timezone_set("America/Guayaquil");
$hoy=date("Y-m-d H:i:s");

$font_f="<font face='Arial' size='2px'>";
$font_b="</font>";
$t0=0;$t12=0;$total=0;$cadena='';$cadena_abajo='';

/*if(isset($_POST['sel_cliente']))
{
	if($_POST['sel_cliente']==0)
	{	*/
		if(isset($_POST['txt_nombres1']))
		{
			if($_POST['txt_nombres1']=='')
			echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='new_".$elemento.".php?mensaje=Debe escribir un nombre.'</script>");
		}
		else
		echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='new_".$elemento.".php?mensaje=Debe escribir un nombre.'</script>");
	/*}
}
else
echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='new_".$elemento.".php'</script>");
*/

//print $_POST['sel_forma_pago1'];die();
if(isset($_POST['sel_pro1']))
{
	if($_POST['sel_pro1']==0)
	echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='new_".$elemento.".php?mensaje=Debe seleccionar un producto.'</script>");
	else
	{
		if(isset($_POST['sel_forma_pago1']))
		{
			if($_POST['sel_forma_pago1']==0)
			echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='new_".$elemento.".php?mensaje=Debe seleccionar la forma de pago.'</script>");
		}
		else
		echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='new_".$elemento.".php?mensaje=Debe seleccionar la forma de pago.'</script>");
	}
}
else
echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='new_".$elemento.".php?mensaje=Debe seleccionar un producto.'</script>");

$sel_punto_venta= $_POST['sel_punto_venta'];
$sel_cliente= $_POST['sel_cliente'];
$id_factura= $_POST['id_factura'];
$txt_no_factura= $_POST['txt_no_factura'];

$sql_f="SELECT formato_factura FROM n_punto_venta WHERE id_punto_venta='".$sel_punto_venta."' ORDER BY punto_venta DESC";//print $sql_p;
$rs_f=$db->Execute($sql_f) or die($db->ErrorMsg());

$formato_factura=$rs_f->fields['formato_factura'];

if($sel_cliente!=0)
{
	if(isset($_POST['txt_nombres1']))$txt_nombres=$_POST['txt_nombres1'];else $txt_nombres='';
	if(isset($_POST['txt_apellidos1']))$txt_apellidos=$_POST['txt_apellidos1'];else $txt_apellidos='';
	if(isset($_POST['txt_identificacion1']))$txt_identificacion=$_POST['txt_identificacion1'];else $txt_identificacion='';
	if(isset($_POST['txt_telefono1']))$txt_telefono=$_POST['txt_telefono1'];else $txt_telefono='';
	if(isset($_POST['txt_direccion1']))$txt_direccion=$_POST['txt_direccion1'];else $txt_direccion='';
	
	$u_sql="UPDATE cliente SET factura_nombres='".$txt_nombres."', factura_apellidos='".$txt_apellidos."', factura_cedula='".$txt_identificacion."', 
	factura_direccion='".$txt_direccion."', factura_telefono='".$txt_telefono."' WHERE id_cliente='".$sel_cliente."'";//print $u_sql.'<br>';
	$db->Execute($u_sql) or die($db->ErrorMsg());
	
}
elseif($sel_cliente==0)
{
	if(isset($_POST['txt_nombres1']))$txt_nombres=$_POST['txt_nombres1'];else $txt_nombres='';
	if(isset($_POST['txt_apellidos1']))$txt_apellidos=$_POST['txt_apellidos1'];else $txt_apellidos='';
	if(isset($_POST['txt_identificacion1']))$txt_identificacion=$_POST['txt_identificacion1'];else $txt_identificacion='';
	if(isset($_POST['txt_telefono1']))$txt_telefono=$_POST['txt_telefono1'];else $txt_telefono='';
	if(isset($_POST['txt_direccion1']))$txt_direccion=$_POST['txt_direccion1'];else $txt_direccion='';
	//if(isset($_POST['cbx_nat_jur']))$cbx_nat_jur=$_POST['cbx_nat_jur'];else $cbx_nat_jur=0;
	
	$sql_p="select cliente.id_cliente, persona.id_persona from  persona, cliente where cliente.id_persona=persona.id_persona 
	AND cliente.factura_cedula='".$txt_identificacion."'";
	$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());//print $sql_p;
	
	if(!isset($rs_p->fields['id_cliente']))
	{
		//------------------------------------------------------------------------------------------
		$elem='tipo_sangre';
		$var_var='id_'.$elem;
		$sql="select id_".$elem." from n_".$elem." where ".$elem."='N/D'";
		$rs=$db->Execute($sql) or die($db->ErrorMsg());
		
		if(!isset($rs->fields['id_'.$elem]))
		{
			$sql_i="INSERT INTO n_".$elem." (".$elem.") VALUES ('N/D')";
			$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
			
			$sql="select id_".$elem." from n_".$elem." where ".$elem."='N/D'";
			$rs=$db->Execute($sql) or die($db->ErrorMsg());
			
			$$var_var=$rs->fields['id_'.$elem];
		}
		else
		$$var_var=$rs->fields['id_'.$elem];
		//------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------
		$elem='tipo_identificacion';
		$var_var='id_'.$elem;
		$sql="select id_".$elem." from n_".$elem." where ".$elem."='N/D'";
		$rs=$db->Execute($sql) or die($db->ErrorMsg());
		
		if(!isset($rs->fields['id_'.$elem]))
		{
			$sql_i="INSERT INTO n_".$elem." (".$elem.") VALUES ('N/D')";
			$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
			
			$sql="select id_".$elem." from n_".$elem." where ".$elem."='N/D'";
			$rs=$db->Execute($sql) or die($db->ErrorMsg());
			
			$$var_var=$rs->fields['id_'.$elem];
		}
		else
		$$var_var=$rs->fields['id_'.$elem];
		//------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------
		$elem='genero';
		$var_var='id_'.$elem;
		$sql="select id_".$elem." from n_".$elem." where ".$elem."='N/D'";
		$rs=$db->Execute($sql) or die($db->ErrorMsg());
		
		if(!isset($rs->fields['id_'.$elem]))
		{
			$sql_i="INSERT INTO n_".$elem." (".$elem.") VALUES ('N/D')";
			$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
			
			$sql="select id_".$elem." from n_".$elem." where ".$elem."='N/D'";
			$rs=$db->Execute($sql) or die($db->ErrorMsg());
			
			$$var_var=$rs->fields['id_'.$elem];
		}
		else
		$$var_var=$rs->fields['id_'.$elem];
		//------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------
		$elem='pais';
		$var_var='id_'.$elem;
		$sql="select id_".$elem." from n_".$elem." where ".$elem."='N/D'";
		$rs=$db->Execute($sql) or die($db->ErrorMsg());
		
		if(!isset($rs->fields['id_'.$elem]))
		{
			$sql_i="INSERT INTO n_".$elem." (".$elem.") VALUES ('N/D')";
			$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
			
			$sql="select id_".$elem." from n_".$elem." where ".$elem."='N/D'";
			$rs=$db->Execute($sql) or die($db->ErrorMsg());
			
			$$var_var=$rs->fields['id_'.$elem];
		}
		else
		$$var_var=$rs->fields['id_'.$elem];
		//------------------------------------------------------------------------------------------
		
		//print "tt:".$id_tipo_sangre;print "  ii:".$id_tipo_identificacion;print "  gg:".$id_genero;print "  pp:".$id_pais;
		
		$sql_i="INSERT INTO persona (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, identificacion , residencia, id_genero, id_pais, id_tipo_sangre, id_tipo_identificacion) 
		VALUES ('".$txt_nombres."', ' ', '".$txt_apellidos."', ' ', '".$txt_identificacion."', '0', '".$id_genero."', '".$id_pais."', '".$id_tipo_sangre."', '".$id_tipo_identificacion."')";//print $sql_i;
		$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
		
		$sql_p="select persona.id_persona from  persona where identificacion='".$txt_identificacion."'";//print $sql_p;
		$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
		
		$id_persona=$rs_p->fields['id_persona'];
		
		$sql_i="INSERT INTO cliente (factura_nombres, factura_apellidos, factura_cedula, factura_direccion, factura_telefono, permite_credito, id_persona) 
		VALUES ('".$txt_nombres."', '".$txt_apellidos."', '".$txt_identificacion."', '".$txt_direccion."', '".$txt_telefono."', '0', '".$id_persona."')";//print $sql_i;
		$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
		
		$sql_c="select cliente.id_cliente from cliente where cliente.id_persona='".$id_persona."'";
		$rs_c=$db->Execute($sql_c) or die($db->ErrorMsg());
		
		$id_cliente=$rs_c->fields['id_cliente'];
		
		//----------FORMA DE PAGO-----------
		$sql_forma="SELECT * FROM n_forma_pago WHERE predeterminada='1'";//print $sql_forma;
		$rs_forma=$db->Execute($sql_forma) or die($db->ErrorMsg());
		
		$id_forma_pago=$rs_forma->fields['id_forma_pago'];
		
		$i_sql="INSERT INTO cliente_forma_pago (id_cliente, id_forma_pago, id_punto_venta, fecha) VALUES ('".$id_cliente."','".$id_forma_pago."','".$sel_punto_venta."', '".date('Y-m-d')."')";//print $i_sql."<br>";
		$db->Execute($i_sql) or die($db->ErrorMsg());
		//----------FORMA DE PAGO-----------

	}
	else
	{
		$id_cliente=$rs_p->fields['id_cliente'];
		
		$u_sql="UPDATE cliente SET factura_nombres='".$txt_nombres."', factura_apellidos='".$txt_apellidos."', factura_cedula='".$txt_identificacion."', 
		factura_direccion='".$txt_direccion."', factura_telefono='".$txt_telefono."' WHERE id_cliente='".$id_cliente."'";///print $u_sql.'<br>';
		$db->Execute($u_sql) or die($db->ErrorMsg());
	}
	
}

for($f=1;$f<=7;$f++)
{	
	if(isset($_POST['sel_pro'.$f]))
	{
		if($_POST['sel_pro'.$f]!='0')
		{
			$sel_pro=$_POST['sel_pro'.$f];
			$sel_forma_pago=$_POST['sel_forma_pago'.$f];
			$txt_cantidad=$_POST['txt_cantidad'.$f];
			
			if($txt_cantidad==0 OR $txt_cantidad=='')
			$txt_cantidad=1;
			
			if($sel_cliente==0)
			$sel_cliente=$id_cliente;
			
			$sql="INSERT INTO venta (cantidad, fecha_venta, no_factura, anulada, id_factura, id_cliente, id_producto_precio, id_forma_pago) 
			VALUES ('".$txt_cantidad."', '".$hoy."', '".$txt_no_factura."', '0', '".$id_factura."', '".$sel_cliente."', '".$sel_pro."', '".$sel_forma_pago."')";//print $sql;//die();
			$rs=$db->Execute($sql) or die($db->ErrorMsg());
			
					
			$sql_p="select producto, precio, graba_iva from producto_precio, n_producto where producto_precio.id_producto=n_producto.id_producto  AND producto_precio.id_producto_precio=".$sel_pro;//print $sql_p;		
			$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
			
			$producto=$rs_p->fields['producto'];
			$precio=$rs_p->fields['precio'];
			$graba_iva=$rs_p->fields['graba_iva'];
			$pre_cant=bcmul($precio, $txt_cantidad,14);
			
			$cadena=$cadena."<table width='350'><tr>
			<td width='215'>".$font_f.$producto.$font_b."</td>
			<td width='30' align='center'>".$font_f.$txt_cantidad.$font_b."</td>
			<td width='45' align='right'>".$font_f."$ ".number_format($precio, 2, '.', '').$font_b."</td>
			<td width='60' align='right'>".$font_f."$ ".number_format($pre_cant, 2, '.', '').$font_b."</td>
			</tr></table>";
			
			if($graba_iva)
			$t0=bcadd($t0,$pre_cant,14);
			else
			$t12=bcadd($t12,$pre_cant,14);
				
			$total=bcadd($total,$pre_cant,14);
		}
		else
		$cadena_abajo=$cadena_abajo."<tr><td colspan='4'>.&nbsp;</td><tr>";
	}
	else
	$cadena_abajo=$cadena_abajo."<tr><td colspan='4'>.&nbsp;</td><tr>";
}
$t12=bcdiv($t12, 1.14,14);//print "<br>t12 antes  ".$t12;//print "<br>t12 despues  ".$t12;
$iva=bcmul($t12,0.14,14);//print "<br>iva despues  ".$iva;
$subtotal=bcadd($t0,$t12,14);

include($formato_factura.".php");
$t0=0;$t12=0;$total=0;$cadena='';
?>

<script language="javascript"  type="text/javascript">
window.print();
location.href='new_venta.php?msg=Datos guardados satisfactoriamente.&id_p=<?php print $sel_punto_venta;?>&id_f=<?php print $sel_forma_pago;?>';
</script>


