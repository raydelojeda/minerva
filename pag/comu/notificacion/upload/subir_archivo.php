<?php
if (isset($_FILES['archivo']))
{
    $carpeta = "../../../../archivos/esquelas/".$_SESSION['user']."/tmp";
	if (!file_exists($carpeta)) {
		mkdir($carpeta, 0777, true);
	}
	
	$archivo = $_FILES['archivo'];
    //$extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
	$nombre = pathinfo($archivo['name'],  PATHINFO_BASENAME);
	//print $archivo['size'];
	if($archivo['size'] <= 4000000 ) 
	{
		//$nombre = utf8_decode(substr($_POST['nombre_archivo'], 0, strpos(basename($_POST['nombre_archivo']),'.')).'.'.$extension);
		$target_path = utf8_decode($carpeta."/".$nombre);//print $target_path;
		if (move_uploaded_file(utf8_decode($archivo['tmp_name']), $target_path)) {
			echo 1;
		} else {
			echo 0;
		}
	}
	else
	echo 0;
}
?>
