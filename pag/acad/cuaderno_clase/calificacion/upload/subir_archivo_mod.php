<?php
if (isset($_FILES['archivo_mod']))
{
    $carpeta = "../../../../../archivos/tareas/".$_SESSION['user']."/tmp";
	if (!file_exists($carpeta)) {
		mkdir($carpeta, 0777, true);
	}
	
	$archivo = $_FILES['archivo_mod'];
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
	//print $archivo['size'];
	if($archivo['size'] <= 4000000 ) 
	{
		$nombre = utf8_decode(substr($_POST['nombre_archivo_mod'], 0, strpos(basename($_POST['nombre_archivo_mod']),'.')).'.'.$extension);
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
