<?php
if (isset($_POST['archivo'])) {
    $archivo = utf8_decode($_POST['archivo']);//print $archivo;
	$carpeta = "../../../../../archivos/tareas/".$_SESSION['user']."/tmp";
	
	//chdir($target_path); // Comment this out if you are on the same folder
	$target_path = $carpeta."/".$archivo;//print $target_path;
	chown($target_path,0777);
	
	
	//fclose($target_path);
    if (file_exists($target_path)) {
        unlink($target_path);
        echo 1;
    } else {
        echo 0;
    }
}
?>
