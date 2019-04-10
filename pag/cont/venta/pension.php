<?php
include("variables.php");
include($x."config/clases.inc.php");

date_default_timezone_set("America/Guayaquil");
$hoy=date("Y-m-d H:i:s");

$font_f="";
$font_b="";
$t0=0;$t12=0;$total=0;$cadena='';

if(isset($_POST['txt_nombres1']))
{
	if($_POST['txt_nombres1']=='')
	echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='new_pension1.php?msg=Debe llenar al menos un nombre.'</script>");
}
else
echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='new_pension2.php?msg=Debe llenar al menos un nombre.'</script>");

if(isset($_POST['sel_paralelo']))
{
	if($_POST['sel_paralelo']==0)
	{
		if(isset($_POST['sel_pro1']))
		{
			if($_POST['sel_pro1']==0)
			echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='new_pension4.php?msg=Debe llenar al menos un producto.'</script>");
		}
		else
		echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='new_pension5.php?msg=Debe llenar al menos un producto.'</script>");
	}
}
else
{
	if(isset($_POST['sel_pro1']))
		{
			if($_POST['sel_pro1']==0)
			echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='new_pension4.php?msg=Debe llenar al menos un producto.'</script>");
		}
		else
		echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='new_pension5.php?msg=Debe llenar al menos un producto.'</script>");
}

$sel_punto_venta= $_POST['sel_punto_venta'];
if(isset($_POST['sel_cliente']))$sel_cliente= $_POST['sel_cliente'];else $sel_cliente=0;
if(isset($_POST['sel_grado']))$sel_grado= $_POST['sel_grado'];else $sel_grado=0;
if(isset($_POST['sel_paralelo']))$sel_paralelo= $_POST['sel_paralelo'];else $sel_paralelo=0;
$id_factura= $_POST['id_factura'];
$txt_no_factura= $_POST['txt_no_factura'];

$sql_f="SELECT formato_factura FROM n_punto_venta WHERE id_punto_venta='".$sel_punto_venta."' ORDER BY punto_venta DESC";//print $sql_p;
$rs_f=$db->Execute($sql_f) or die($db->ErrorMsg());

$formato_factura=$rs_f->fields['formato_factura'];

if(isset($_POST['cbx_referencia']))$cbx_referencia= $_POST['cbx_referencia'];else $cbx_referencia=0;

if($sel_paralelo==0 AND $sel_cliente!=0)//
{
	if(isset($_POST['txt_nombres1']))$txt_nombres=$_POST['txt_nombres1'];else $txt_nombres='';
	if(isset($_POST['txt_apellidos1']))$txt_apellidos=$_POST['txt_apellidos1'];else $txt_apellidos='';
	if(isset($_POST['txt_identificacion1']))$txt_identificacion=$_POST['txt_identificacion1'];else $txt_identificacion='';
	if(isset($_POST['txt_telefono1']))$txt_telefono=$_POST['txt_telefono1'];else $txt_telefono='';
	if(isset($_POST['txt_direccion1']))$txt_direccion=$_POST['txt_direccion1'];else $txt_direccion='';
	if(isset($_POST['txt_referencia1']))$txt_referencia=$_POST['txt_referencia1'];else $txt_referencia='';
	
	$u_sql="UPDATE cliente SET factura_nombres='".$txt_nombres."', factura_apellidos='".$txt_apellidos."', factura_cedula='".$txt_identificacion."', 
	factura_direccion='".$txt_direccion."', factura_telefono='".$txt_telefono."' WHERE id_cliente='".$sel_cliente."'";//print $u_sql.'<br>';
	$db->Execute($u_sql) or die($db->ErrorMsg());
	
	if($cbx_referencia==1)
	{
		$sql_r="select id_referencia from referencia WHERE id_cliente='".$sel_cliente."' AND id_punto_venta='".$sel_punto_venta."'";
		$rs_r=$db->Execute($sql_r) or die($db->ErrorMsg());
		
		if(isset($rs_r->fields['id_referencia']))
		{			
			$u_sql="UPDATE referencia SET referencia='".$txt_referencia."' WHERE id_cliente='".$sel_cliente."' AND id_punto_venta='".$sel_punto_venta."'";//print $u_sql.'<br>';
			$db->Execute($u_sql) or die($db->ErrorMsg());
		}
		else
		{
			$sql_i="INSERT INTO referencia (referencia, id_cliente, id_punto_venta) VALUES ('".$txt_referencia."', '".$sel_cliente."', '".$sel_punto_venta."')";//print $sql_i;
			$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
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
				
				$sql="INSERT INTO venta (cantidad, fecha_venta, no_factura, anulada, id_factura, id_cliente, id_producto_precio, id_forma_pago) 
				VALUES ('".$txt_cantidad."', '".$hoy."', '".$txt_no_factura."', '0', '".$id_factura."', '".$sel_cliente."', '".$sel_pro."', '".$sel_forma_pago."')";//print $sql;
				$rs=$db->Execute($sql) or die($db->ErrorMsg());
			
				$sql_p="select producto, precio, graba_iva from producto_precio, n_producto where producto_precio.id_producto=n_producto.id_producto  AND producto_precio.id_producto_precio=".$sel_pro;//print $sql_p;		
				$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
				
				$producto=$rs_p->fields['producto'];
				$precio=$rs_p->fields['precio'];
				$graba_iva=$rs_p->fields['graba_iva'];
				$pre_cant=bcmul($precio, $txt_cantidad,14);
				
				$cadena=$cadena."<tr>
				<td colspan='2' align='left'>".$font_f.$producto.$font_b."</td>
				<td width='100px' align='right'>".$font_f."$ ".number_format($precio, 2, '.', '').$font_b."</td>
				<td width='90px' align='right'>".$font_f."$ ".number_format($pre_cant, 2, '.', '').$font_b."</td>
				</tr>";
				
				if($graba_iva)
				$t0=bcadd($t0,$pre_cant,14);
				else
				$t12=bcadd($t12,$pre_cant,14);
					
				$total=bcadd($total,$pre_cant,14);
			}
			else
			$cadena_abajo="<tr><td colspan='4'>&nbsp;</td><tr>";
		}
	}
	$t12=bcdiv($t12, 1.12,14);//print "<br>t12 antes  ".$t12;//print "<br>t12 despues  ".$t12;
	$iva=bcmul($t12,0.12,14);//print "<br>iva despues  ".$iva;
	$subtotal=bcadd($t0,$t12,14);
	
	include($formato_factura.".php");
	$t0=0;$t12=0;$total=0;$cadena='';
}
elseif($sel_paralelo!=0)
{
	$sql_cli="select DISTINCT cliente.id_cliente,persona.id_persona, factura_nombres, factura_apellidos, factura_cedula, factura_direccion, factura_telefono, 
	concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) AS cliente from  persona, cliente, grupos_clientes, n_grupo_cliente, estudiante, curso_grado_paralelo_est, grado_paralelo_periodo, n_grado_paralelo
	where cliente.id_persona=persona.id_persona and cliente.id_cliente=grupos_clientes.id_cliente AND estudiante.id_persona=persona.id_persona AND curso_grado_paralelo_est.id_estudiante=estudiante.id_estudiante	
	AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo
	and n_grupo_cliente.id_grupo_cliente=grupos_clientes.id_grupo_cliente AND n_grado_paralelo.id_paralelo='".$sel_paralelo."' 
	AND n_grado_paralelo.id_grado='".$sel_grado."' AND n_grupo_cliente.id_punto_venta='".$sel_punto_venta."'";
	$rs_cli=$db->Execute($sql_cli) or die($db->ErrorMsg());//print $rs_gru;
	
	$rs_cli->MoveFirst();
	//$rs_gru->MoveNext();
	
	for($g=1;$g<=$rs_cli->RecordCount();$g++)
	{
		$id_cliente=$rs_cli->fields['id_cliente'];
		$id_persona=$rs_cli->fields['id_persona'];
		
		if(isset($_POST['txt_nombres'.$g]))$txt_nombres=$_POST['txt_nombres'.$g];else $txt_nombres='';
		if(isset($_POST['txt_apellidos'.$g]))$txt_apellidos=$_POST['txt_apellidos'.$g];else $txt_apellidos='';
		if(isset($_POST['txt_identificacion'.$g]))$txt_identificacion=$_POST['txt_identificacion'.$g];else $txt_identificacion='';
		if(isset($_POST['txt_telefono'.$g]))$txt_telefono=$_POST['txt_telefono'.$g];else $txt_telefono='';
		if(isset($_POST['txt_direccion'.$g]))$txt_direccion=$_POST['txt_direccion'.$g];else $txt_direccion='';
		if(isset($_POST['txt_referencia'.$g]))$txt_referencia=$_POST['txt_referencia'.$g];else $txt_referencia='';
		
		$u_sql="UPDATE cliente SET factura_nombres='".$txt_nombres."', factura_apellidos='".$txt_apellidos."', factura_cedula='".$txt_identificacion."', 
		factura_direccion='".$txt_direccion."', factura_telefono='".$txt_telefono."' WHERE id_cliente='".$id_cliente."'";//print $u_sql.'<br>';
		$db->Execute($u_sql) or die($db->ErrorMsg());
		
		if($cbx_referencia==1)
		{
			$sql_r="select id_referencia from referencia WHERE id_cliente='".$id_cliente."' AND id_punto_venta='".$sel_punto_venta."'";
			$rs_r=$db->Execute($sql_r) or die($db->ErrorMsg());
			
			if(isset($rs_r->fields['id_referencia']))
			{			
				$u_sql="UPDATE referencia SET referencia='".$txt_referencia."' WHERE id_cliente='".$id_cliente."' AND id_punto_venta='".$sel_punto_venta."'";//print $u_sql.'<br>';
				$db->Execute($u_sql) or die($db->ErrorMsg());
			}
			else
			{
				$sql_i="INSERT INTO referencia (referencia, id_cliente, id_punto_venta) VALUES ('".$txt_referencia."', '".$id_cliente."', '".$sel_punto_venta."')";//print $sql_i;
				$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
			}
		}
		
		$sql_pro="select producto, cantidad, producto_precio.id_producto_precio AS id_pro, precio, graba_iva from producto_precio, n_producto, n_punto_venta, preventa, grupos_clientes, n_grupo_cliente
		WHERE producto_precio.id_producto=n_producto.id_producto AND preventa.id_producto=n_producto.id_producto AND n_grupo_cliente.id_grupo_cliente=grupos_clientes.id_grupo_cliente 
		AND n_grupo_cliente.id_grupo_cliente=preventa.id_grupo_cliente AND producto_precio.id_punto_venta=n_punto_venta.id_punto_venta AND producto_precio.activo='1' AND grupos_clientes.activo='1' 
		and n_punto_venta.id_punto_venta='".$_POST['sel_punto_venta']."' and grupos_clientes.id_cliente='".$id_cliente."'";//print $sql_pro;
		$rs_pro=$db->Execute($sql_pro) or die($db->ErrorMsg());
		
		for($y=0;$y<$rs_pro->RecordCount();$y++)
		{
			$id_producto_precio=$rs_pro->fields['id_pro'];
			$sel_forma_pago=$_POST['sel_forma_pago'.$y];
			$cantidad=$rs_pro->fields['cantidad'];
			
			$sql="INSERT INTO venta (cantidad, fecha_venta, no_factura, anulada, id_factura, id_cliente, id_producto_precio, id_forma_pago) 
			VALUES ('".$cantidad."', '".$hoy."', '".$txt_no_factura."', '0', '".$id_factura."', '".$id_cliente."', '".$id_producto_precio."', '".$sel_forma_pago."')";//print $sql.'<br>';
			$rs=$db->Execute($sql) or die($db->ErrorMsg());
			
			$producto=$rs_pro->fields['producto'];
			$precio=$rs_pro->fields['precio'];
			$cantidad=$rs_pro->fields['cantidad'];
			$graba_iva=$rs_pro->fields['graba_iva'];
			$pre_cant=bcmul($precio, $cantidad,14);
			
			$cadena=$cadena."<tr>
			<td colspan='2' align='left'>".$font_f.$producto.$font_b."</td>
			<td width='100px' align='right'>".$font_f."$ ".number_format($precio, 2, '.', '').$font_b."</td>
			<td width='90px' align='right'>".$font_f."$ ".number_format($pre_cant, 2, '.', '').$font_b."</td>
			</tr>";
			
			if($graba_iva)
			$t0=bcadd($t0,$pre_cant,14);
			else
			$t12=bcadd($t12,$pre_cant,14);
				
			$total=bcadd($total,$pre_cant,14);
		
		$rs_pro->MoveNext();
		}
		
		$cadena_abajo="<tr><td colspan='4'>&nbsp;</td><tr>";
		
		$t12=bcdiv($t12, 1.12,14);//print "<br>t12 antes  ".$t12;//print "<br>t12 despues  ".$t12;
		$iva=bcmul($t12,0.12,14);//print "<br>iva despues  ".$iva;
		$subtotal=bcadd($t0,$t12,14);
		
		include($formato_factura.".php");
		$t0=0;$t12=0;$total=0;$cadena='';
		
		$txt_no_factura=$txt_no_factura+1;
		
	$rs_cli->MoveNext();
	}
}
elseif($sel_grado==0 AND $sel_cliente==0)
{
	if(isset($_POST['txt_nombres1']))$txt_nombres=$_POST['txt_nombres1'];else $txt_nombres='';
	if(isset($_POST['txt_apellidos1']))$txt_apellidos=$_POST['txt_apellidos1'];else $txt_apellidos='';
	if(isset($_POST['txt_identificacion1']))$txt_identificacion=$_POST['txt_identificacion1'];else $txt_identificacion='';
	if(isset($_POST['txt_telefono1']))$txt_telefono=$_POST['txt_telefono1'];else $txt_telefono='';
	if(isset($_POST['txt_direccion1']))$txt_direccion=$_POST['txt_direccion1'];else $txt_direccion='';
	if(isset($_POST['txt_referencia1']))$txt_referencia=$_POST['txt_referencia1'];else $txt_referencia='';
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
		
		if($cbx_referencia==1)
		{
			$sql_i="INSERT INTO referencia (referencia, id_cliente, id_punto_venta) VALUES ('".$txt_referencia."', '".$id_cliente."', '".$sel_punto_venta."')";//print $sql_i;
			$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
		}
	}
	else
	{
		$id_cliente=$rs_p->fields['id_cliente'];
		
		$u_sql="UPDATE cliente SET factura_nombres='".$txt_nombres."', factura_apellidos='".$txt_apellidos."', factura_cedula='".$txt_identificacion."', 
		factura_direccion='".$txt_direccion."', factura_telefono='".$txt_telefono."' WHERE id_cliente='".$id_cliente."'";///print $u_sql.'<br>';
		$db->Execute($u_sql) or die($db->ErrorMsg());
		
		if($cbx_referencia==1)
		{
			$sql_r="select id_referencia from referencia WHERE id_cliente='".$id_cliente."' AND id_punto_venta='".$sel_punto_venta."'";
			$rs_r=$db->Execute($sql_r) or die($db->ErrorMsg());
			
			if(isset($rs_r->fields['id_referencia']))
			{			
				$u_sql="UPDATE referencia SET referencia='".$txt_referencia."' WHERE id_cliente='".$id_cliente."' AND id_punto_venta='".$sel_punto_venta."'";//print $u_sql.'<br>';
				$db->Execute($u_sql) or die($db->ErrorMsg());
			}
			else
			{
				$sql_i="INSERT INTO referencia (referencia, id_cliente, id_punto_venta) VALUES ('".$txt_referencia."', '".$id_cliente."', '".$sel_punto_venta."')";//print $sql_i;
				$rs=$db->Execute($sql_i) or die($db->ErrorMsg());
			}
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
				
				$sql="INSERT INTO venta (cantidad, fecha_venta, no_factura, anulada, id_factura, id_cliente, id_producto_precio, id_forma_pago) 
				VALUES ('".$txt_cantidad."', '".$hoy."', '".$txt_no_factura."', '0', '".$id_factura."', '".$id_cliente."', '".$sel_pro."', '".$sel_forma_pago."')";//print $sql;
				$rs=$db->Execute($sql) or die($db->ErrorMsg());
			
				$sql_p="select producto, precio, graba_iva from producto_precio, n_producto where producto_precio.id_producto=n_producto.id_producto  AND producto_precio.id_producto_precio=".$sel_pro;//print $sql_p;		
				$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
				
				$producto=$rs_p->fields['producto'];
				$precio=$rs_p->fields['precio'];
				$graba_iva=$rs_p->fields['graba_iva'];
				$pre_cant=bcmul($precio, $txt_cantidad,14);
				
				$cadena=$cadena."<tr>
				<td colspan='2' align='left'>".$font_f.$producto.$font_b."</td>
				<td width='100px' align='right'>".$font_f."$ ".number_format($precio, 2, '.', '').$font_b."</td>
				<td width='90px' align='right'>".$font_f."$ ".number_format($pre_cant, 2, '.', '').$font_b."</td>
				</tr>";
				
				if($graba_iva)
				$t0=bcadd($t0,$pre_cant,14);
				else
				$t12=bcadd($t12,$pre_cant,14);
					
				$total=bcadd($total,$pre_cant,14);
			}
			else
			$cadena_abajo="<tr><td colspan='4'>&nbsp;</td><tr>";
		}
	}
	$t12=bcdiv($t12, 1.12,14);//print "<br>t12 antes  ".$t12;//print "<br>t12 despues  ".$t12;
	$iva=bcmul($t12,0.12,14);//print "<br>iva despues  ".$iva;
	$subtotal=bcadd($t0,$t12,14);
	
	include($formato_factura.".php");
	$t0=0;$t12=0;$total=0;$cadena='';
	
	
}//echo ("<script language='JavaScript' type='text/javascript'> location.href='new_".$elemento.".php?msg=Datos guardados satisfactoriamente.&id_p=".$sel_punto_venta."'</script>");
?>

<script language="javascript"  type="text/javascript">
window.print();
location.href='new_pension.php?msg=Datos guardados satisfactoriamente.&id_p=<?php print $sel_punto_venta;?>';
</script>


















