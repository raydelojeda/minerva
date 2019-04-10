<?php
include("variables.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{
	$sql_a="SELECT atributo, valor_atributo FROM n_atributo, articulo_atributo WHERE 1 AND n_atributo.id_atributo=articulo_atributo.id_atributo AND id_articulo='".$_POST['campo0']."'";//print $sql_a;
	$rs_a=$db->Execute($sql_a) or die($db->ErrorMsg());
	
	if(isset($rs_a))
	{
		for($a=0;$a<$rs_a->RecordCount();$a++) 
		{
			print '<b>'.$rs_a->fields['atributo'].':</b> '.$rs_a->fields['valor_atributo'].'<br>';//
		$rs_a->MoveNext();		
		}
	}
	else
	print 'El art&iacute;culo no tiene atributos.<br>';
	
	
}

if(isset($_POST['campo0']))
{
	$sql_i="SELECT SUM(cantidad) AS cant_ingresada FROM inventario_consumibles WHERE 1 AND id_articulo='".$_POST['campo0']."'";//print $sql_a;
	$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
	
	$sql_c="SELECT SUM(cantidad) AS cant_consumida FROM pedido_consumible WHERE 1 AND id_articulo='".$_POST['campo0']."'";//print $sql_a;
	$rs_c=$db->Execute($sql_c) or die($db->ErrorMsg());
	
	if(isset($rs_c->fields['cant_consumida'])){$cantidad=$rs_i->fields['cant_ingresada']-$rs_c->fields['cant_consumida'];}else $cantidad=$rs_i->fields['cant_ingresada'];
	
	print '<br><b>Cantidad disponible:</b><div class="bola_notificacion"> '.$cantidad.'</div>';//

	
}
?>