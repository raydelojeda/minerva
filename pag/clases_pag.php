<?php
class clases_extras
{
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function saldo_disponible($db,$id_punto_venta,$id_cliente)
	{
		if(isset($id_cliente))
		{
			$sql_s="select SUM(saldo) AS suma_saldo from saldo WHERE 1 AND id_punto_venta='".$id_punto_venta."'
			AND saldo.id_cliente='".$id_cliente."'";//print "<br><br>".$sql_s;
			$rs_s=$db->Execute($sql_s) or print $db->ErrorMsg();
				
			$suma_saldo=$rs_s->fields["suma_saldo"];//print "saldo final".$suma_saldo;	
			
			$sql_v="select id_venta, SUM(precio*cantidad) AS suma_venta from venta, cliente, producto_precio
			where venta.id_cliente=cliente.id_cliente AND venta.id_producto_precio=producto_precio.id_producto_precio
			and anulada='0' AND	id_punto_venta='".$id_punto_venta."' and cliente.id_cliente='".$id_cliente."'";//print "<br><br>".$sql_v;			
			$rs_v=$db->Execute($sql_v) or die($db->ErrorMsg());
								
			$suma_venta=$rs_v->fields["suma_venta"];//print "suma_venta: ".$suma_venta;		
			$saldo_disponible=bcsub($suma_saldo, $suma_venta, 14);

			return $saldo_disponible;
		}
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function saldo_disponible_x($db,$id_punto_venta,$id_cliente,$fecha_ini,$fecha_fin)
	{
		if(isset($id_cliente))
		{
			$sql_s="select SUM(saldo) AS suma_saldo from saldo WHERE 1 AND id_punto_venta='".$id_punto_venta."'
			AND saldo.id_cliente='".$id_cliente."'";//print "<br><br>".$sql_s;
			
			if($fecha_ini)
			$sql_s .= " and saldo.fecha_ingreso>='".$fecha_ini."'";
			if($fecha_fin)
			$sql_s .= " and saldo.fecha_ingreso<='".$fecha_fin."'";
			
			$rs_s=$db->Execute($sql_s) or print $db->ErrorMsg();
				
			$suma_saldo=$rs_s->fields["suma_saldo"];//print "saldo final".$suma_saldo;	
			
			$sql_v="select id_venta, SUM(precio*cantidad) AS suma_venta from venta, cliente, producto_precio
			where venta.id_cliente=cliente.id_cliente AND venta.id_producto_precio=producto_precio.id_producto_precio
			and anulada='0' AND	id_punto_venta='".$id_punto_venta."' and cliente.id_cliente='".$id_cliente."'";
			
			if($fecha_ini)
			$sql_v .= " and venta.fecha_venta>='".$fecha_ini."'";
			if($fecha_fin)
			$sql_v .= " and venta.fecha_venta<='".$fecha_fin."'";//print "<br><br>".$sql_v;
			
			$rs_v=$db->Execute($sql_v) or die($db->ErrorMsg());
								
			$suma_venta=$rs_v->fields["suma_venta"];//print "suma_venta: ".$suma_venta;		
			$saldo_disponible=bcsub($suma_saldo, $suma_venta, 14);

			return $saldo_disponible;
		}
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calculos_x_factura($db,$no_factura)
	{
		$sql_iva = "select no_factura, cantidad, precio, graba_iva, anulada, fecha_venta from venta, producto_precio WHERE 1 AND venta.id_producto_precio=producto_precio.id_producto_precio AND no_factura='".$no_factura."'";			
		$rs_iva=$db->Execute($sql_iva) or die($db->ErrorMsg());//print $sql_iva."<br>";

		if(isset($rs_iva))
		{
			if($rs_iva->Fields("anulada")==0)
			{
				if ($rs_iva->RecordCount() > 0)
				{
					$t0=0;
					$t12=0;	
					$total=0;
					$rs_iva->MoveFirst();
					$fecha_venta=$rs_iva->Fields("fecha_venta");
					
					while (!$rs_iva->EOF)
					{
						$precio=$rs_iva->Fields("precio");	
						$incluye_iva=$rs_iva->Fields("graba_iva");
						$cantidad=$rs_iva->Fields("cantidad");

						$pre_cant=bcmul($precio, $cantidad,14);

						if($incluye_iva==1)
						$t0=bcadd($t0,$pre_cant,14);
						else
						$t12=bcadd($t12,$pre_cant,14);//print $t12."<br>";				

						$total=bcadd($total,$pre_cant,14);	

					$rs_iva->MoveNext();					  
					}
				}
				
				if($fecha_venta<"2016-06-01 00:00:00")
				{
					$t12=bcdiv($t12, 1.12,14);//print "<br>t12 despues  ".$t12;
					$iva=bcmul($t12,0.12,14);//print "<br>iva despues  ".$iva;
					$subtotal=bcadd($t0,$t12,14);
				}
				elseif($fecha_venta>="2016-06-01")
				{
					$t12=bcdiv($t12, 1.14,14);//print "<br>t12 despues  ".$t12;
					$iva=bcmul($t12,0.14,14);//print "<br>iva despues  ".$iva;
					$subtotal=bcadd($t0,$t12,14);
				}

				//if($rs_iva->fields["anulada"]==0)		
				//$megatotal=bcadd($megatotal,number_format($total, 2, '.', ''), 2);//$megatotal=bcadd($megatotal,$total, 14);
				
				$valores[0]=number_format(round($subtotal,2), 2, ".", "");
				$valores[1]=number_format(round($t0,2), 2, ".", "");
				$valores[2]=number_format(round($t12,2), 2, ".", "");
				$valores[3]=number_format(round($iva,2), 2, ".", "");
				$valores[4]=number_format(round($total,2), 2, ".", "");
				
				return $valores;
			}
			else
			{
				$valores[0]='';
				$valores[1]='';
				$valores[2]='';
				$valores[3]='';
				$valores[4]='';
			}
		}
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calculo_subtotal_x($db,$precio,$cantidad,$anulada)
	{		
		if($anulada==0)
		{
			$subtotal=number_format(bcmul($precio, $cantidad,14), 2, ".", "");
			
			$valores[0]=number_format($precio,2,".", "");
			$valores[1]=number_format($precio,2,".", "");
			$valores[2]=$cantidad;
			$valores[3]=number_format($subtotal,2,".", "");
			
			return $valores;
		}
		else
		{
			$valores[0]='';
			$valores[1]='';
			$valores[2]='';
			$valores[3]='';
			$valores[4]='';
		}
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consumible_disponible($db,$id_articulo)
	{
		if(isset($id_articulo))
		{
			$sql_i="SELECT SUM(cantidad) AS cant_ingresada FROM inventario_consumibles WHERE 1 AND id_articulo='".$id_articulo."'";//print $sql_i;
			$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
			
			$sql_c="SELECT SUM(cantidad) AS cant_consumida FROM pedido_consumible WHERE 1 AND id_articulo='".$id_articulo."'";//print $sql_c;
			$rs_c=$db->Execute($sql_c) or die($db->ErrorMsg());
			
			if(isset($rs_c->fields['cant_consumida'])){$cantidad=$rs_i->fields['cant_ingresada']-$rs_c->fields['cant_consumida'];}else $cantidad=$rs_i->fields['cant_ingresada'];
//print $cantidad;
			return $cantidad;
		}
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function cuantos_estudiantes_clase($db,$id_clase)
	{
		if(isset($id_clase))
		{
			$sql_c="SELECT id_clase_estudiante FROM clase_estudiante WHERE 1 AND retirado='0' AND id_clase='".$id_clase."'";//print $sql_i;
			$rs_c=$db->Execute($sql_c) or die($db->ErrorMsg());

			if(isset($rs_c->fields['id_clase_estudiante'])){$cantidad=$rs_c->RecordCount();}else $cantidad=0;

			return $cantidad;
		}
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
}
?>