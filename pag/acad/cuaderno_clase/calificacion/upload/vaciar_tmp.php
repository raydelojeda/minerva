<?php
	$carpeta = "../../../../../archivos/tareas/".$_SESSION['user']."/tmp";
	
	$directorio_escaneado = scandir($carpeta);
	foreach ($directorio_escaneado as $item) 
	{
		if ($item != '.' and $item != '..') 
		{
			$archivo = $item;
			$target_path = $carpeta."/".$archivo;//print $target_path;
			chown($target_path,0777);
			
			if (file_exists($target_path))
			{
				unlink($target_path);
				echo 1;
			}
			else 
			{
				echo 0;
			}
		}
	}
?>
