<?php
include("clases_r_saldo.php");
if(!isset($obj_r_saldo))$obj_r_saldo = new clases_extras();// (NO TOCAR)

include("variables.php");
include($x."plantillas/mod_header.php");

if(isset($_GET["visualizar"]))
$visualizar=$_GET["visualizar"];
else
$visualizar='';

if(isset($_GET["mod"]))
$mod=$_GET["mod"];
else
{
	if(isset($_POST["var_aux"]))
	$mod=$_POST["var_aux"];
}

if(!isset($mod))
echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_".$elemento.".php??mensaje=Reinicie su PC y notifique al Administrador.'</script>");

$hoy=date("Y-m-d");
$mensaje="";

if(!empty($mod))// con esto evito el intento de acceder directamente a esta pagina escribiendo su URL en el browser
{ 
	print " prueba mod: ".$mod."<br>";
	$var = explode(",",$mod);		
	
	if(count($var) != 0)
	{
		for ($i = 0; $i < count($var); next($var), $i++) 
		{
		
			$id = current($var);//print $id."<br>";
			$id_cliente_id_punto_venta = explode("_",$id);
			$id_cliente=$id_cliente_id_punto_venta[0];
			$id_punto_venta=$id_cliente_id_punto_venta[1];
			
			if($_POST["forma".$id]!=0)
			$id_forma_pago=$_POST["forma".$id];
			
			if(isset($id_forma_pago))
			{
				if($_POST[$id]!=0 AND $_POST[$id]!='')
				{
					$saldo_disponible=str_replace(',','.',$_POST[$id]);

					$sql="INSERT INTO saldo (saldo, fecha_ingreso, id_forma_pago, id_cliente, id_punto_venta)
					VALUES ('".$saldo_disponible."','".$hoy."','".$id_forma_pago."','".$id_cliente."','".$id_punto_venta."')";//print $sql."<br>";//die();
					$rs=$db->Execute($sql) or die($db->ErrorMsg()) ;//print "Ya existe la persona en la Base de Datos."
					$ok=1;
				}
				else
				{
					$sql_cli="select punto_venta, identificacion,primer_apellido,segundo_apellido,primer_nombre,segundo_nombre FROM persona, cliente, saldo, n_punto_venta WHERE 
					cliente.id_persona=persona.id_persona AND cliente.id_cliente=saldo.id_cliente AND saldo.id_punto_venta=n_punto_venta.id_punto_venta AND 
					cliente.id_cliente='".$id_cliente."' AND n_punto_venta.id_punto_venta='".$id_punto_venta."'";
					$rs_cli=$db->Execute($sql_cli) or die($db->ErrorMsg());//print $sql_cli;
					
					$mensaje=$mensaje."El cliente ".$rs_cli->fields["primer_nombre"]." ".$rs_cli->fields["segundo_nombre"]." ".$rs_cli->fields["primer_apellido"]." ".$rs_cli->fields["segundo_apellido"].", no tiene definido monto para agregar en ".$rs_cli->fields["punto_venta"]."<br>";
				}
			}
			else
			{
				$sql_cli="select punto_venta, identificacion,primer_apellido,segundo_apellido,primer_nombre,segundo_nombre FROM persona, cliente, saldo, n_punto_venta WHERE 
				cliente.id_persona=persona.id_persona AND cliente.id_cliente=saldo.id_cliente AND saldo.id_punto_venta=n_punto_venta.id_punto_venta AND 
				cliente.id_cliente='".$id_cliente."' AND n_punto_venta.id_punto_venta='".$id_punto_venta."'";
				$rs_cli=$db->Execute($sql_cli) or die($db->ErrorMsg());//print $sql_cli;
				
				$mensaje=$mensaje."El cliente ".$rs_cli->fields["primer_nombre"]." ".$rs_cli->fields["segundo_nombre"]." ".$rs_cli->fields["primer_apellido"]." ".$rs_cli->fields["segundo_apellido"].", no tiene definido forma de pago en ".$rs_cli->fields["punto_venta"]."<br>";
			}
		} 		
	} 
}

if(isset($ok))
$mensaje=$mensaje."Datos guardados satisfactoriamente.";

//print $mensaje;

echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='lis_".$elemento.".php?mensaje=".$mensaje."'</script>");

?>
