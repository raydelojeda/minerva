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
}
?>