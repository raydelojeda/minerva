<?php 
include("variables.php");
include($x."adodb519/adodb.inc.php");  //adodb library
include($x."coneccion/conn.php"); //conection
include($x."config/clases.inc.php");
include($x.$_POST['camino']."/variables.php");

if(!empty($_POST['var_aux']))// con esto evito el intento de acceder directamente a esta pagina escribiendo su URL en el browser
{
	$var = explode(",",$_POST['var_aux']);		
	
	if(count($var) != 0)
	{
		for ($i = 0; $i < count($var); next($var), $i++) 
		{		
			$id = current($var);//print $id;die();
			
			$d_sql= "DELETE FROM familiar_estudiante WHERE id_estudiante='".$id."'";print $d_sql;
			$db->Execute($d_sql) or die($db->ErrorMsg()."Este mensaje no es un error como tal, lo que sucede es que existen datos que dependen de lo que se quiere eliminar. Por tanto se debe proceder a eliminar las entradas dependientes. Dé click en el botón <- Atrás del navegador.");
			
			$d_sql= "DELETE FROM curso_grado_paralelo_est WHERE id_estudiante='".$id."'";//print $d_sql;
			$db->Execute($d_sql) or die($db->ErrorMsg()."Este mensaje no es un error como tal, lo que sucede es que existen datos que dependen de lo que se quiere eliminar. Por tanto se debe proceder a eliminar las entradas dependientes. Dé click en el botón <- Atrás del navegador.");
						
			$d_sql= "DELETE FROM ".$tabla." WHERE ".$field[0]."='".$id."'";//print $d_sql;
			$d_rs = $db->Execute($d_sql) or die($db->ErrorMsg()."Este mensaje no es un error como tal, lo que sucede es que existen datos que dependen de lo que se quiere eliminar. Por tanto se debe proceder a eliminar las entradas dependientes. Dé click en el botón <- Atrás del navegador.");//print $a;print $query_rs_delete;	
		} 		
	} 
}
header("Location:lis_".$elemento.".php");
?>
