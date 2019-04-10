<?php
if(isset($_POST['archivo']))
{
    $archivo = utf8_decode($_POST['archivo']);//print $archivo;
	$carpeta = "../../../../../archivos/tareas/".$_SESSION['user']."/tmp";	
	$target_path = $carpeta."/".$archivo;	
	chown($target_path,0777);
	
	if(isset($_POST['id_tarea']))
	{
		$carpeta1 = "../../../../../archivos/tareas/".$_SESSION['user']."/".$_POST['id_tarea'];
		$target_path1 = $carpeta1."/".$archivo;
		chown($target_path1,0777);
	}

    if(file_exists($target_path))
	{
        unlink($target_path);
        echo 1;
    }
	elseif(file_exists($target_path1))
	{
        unlink($target_path1);
        echo 1;
    } 
	else 
	{
        echo 0;
    }
}
?>
