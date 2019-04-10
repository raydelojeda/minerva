<?php 
include("variables.php");
include($x."adodb519/adodb.inc.php");  //adodb library
include($x."coneccion/conn.php"); //conection
include($x."config/clases.inc.php");

$obj = new clases();
$hoy=date("Y-m-d");

if(!empty($_POST['var_aux']))// con esto evito el intento de acceder directamente a esta pagina escribiendo su URL en el browser
{ 
	$var = explode(",",$_POST['var_aux']);		
	
	if(count($var) != 0)
	{
		for ($i = 0; $i < count($var); next($var), $i++) 
		{
			$id = current($var);
			
			$sql="SELECT id_libro FROM prestamo WHERE id_prestamo='".$id."'";//print $sql; die();
			$rs=$db->Execute($sql) or die($db->ErrorMsg());
			
			$id_libro=$rs->fields['id_libro'];
			
			$upd="UPDATE libro SET prestado='". 0 ."' WHERE id_libro='".$id_libro."'";//print $upd; die();
			$db->Execute($upd) or die($db->ErrorMsg());			
			
			$sql_p = "UPDATE prestamo SET  fecha_dev_real = '".$hoy."' WHERE id_prestamo='".$id."'";//print $sql_p;
			$db->Execute($sql_p) or die($db->ErrorMsg());
			
			if(!$mensaje)
			$mensaje='Préstamo devuelto satisfactoriamente.';
		} 		
	} 
}
header("Location:lis_prestamo.php?mensaje=".utf8_encode($mensaje));/**/
?>
