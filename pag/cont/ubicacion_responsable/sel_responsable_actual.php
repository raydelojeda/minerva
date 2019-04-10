<?php
include("variables.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

if(isset($_POST['campo0']))
{
	$sql_a="SELECT fecha_mov, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as responsable, 
	concat(ubicacion,' - ',bloque,' - ',secc,' - ',division) as ubicacion  
	FROM ubicacion_responsable, persona, empleado, n_ubicacion, n_bloque, n_division, n_secc 
	WHERE 1 AND empleado.id_persona=persona.id_persona AND ubicacion_responsable.id_responsable=empleado.id_empleado AND n_ubicacion.id_bloque=n_bloque.id_bloque 
	AND n_ubicacion.id_division=n_division.id_division AND n_ubicacion.id_secc=n_secc.id_secc AND n_ubicacion.id_ubicacion=ubicacion_responsable.id_ubicacion 
	AND id_inventario='".$_POST['campo0']."' AND fecha_mov=(SELECT MAX(fecha_mov) FROM ubicacion_responsable WHERE 1 AND id_inventario='".$_POST['campo0']."')";//print $sql_a.'<br>';
	$rs_a=$db->Execute($sql_a) or die($db->ErrorMsg());
	
	if(isset($rs_a->fields['fecha_mov']))
	{
		for($a=0;$a<$rs_a->RecordCount();$a++) 
		{
			print '<b>El art&iacute;culo est&aacute; a cargo de: </b>'.$rs_a->fields['responsable'].'<br><b>Fue movido el: </b>'.$rs_a->fields['fecha_mov'].'<br><b>Se ubica en: </b>'.$rs_a->fields['ubicacion'].'<br><br>';//
		$rs_a->MoveNext();		
		}
	}
	else
	print 'El art&iacute;culo est&aacute; en almac&eacute;n a&uacute;n.<br><br>';
}

if(isset($_POST['campo0']))
{
	$sql_a="SELECT atributo, valor_atributo FROM n_atributo, articulo_atributo, inventario, n_articulo WHERE 1 AND inventario.id_articulo=n_articulo.id_articulo AND articulo_atributo.id_articulo=n_articulo.id_articulo
	AND n_atributo.id_atributo=articulo_atributo.id_atributo AND id_inventario='".$_POST['campo0']."'";//print $sql_a;
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
?>