<?php
if(isset($_GET['id_tarea']))
{
	if($_GET['id_tarea']!='')
	{
		$carpeta1 = "../../../../../archivos/tareas/".$_SESSION['user']."/".$_GET['id_tarea'];//print $target_path;
		if (!file_exists($carpeta1)) {
			mkdir($carpeta1, 0777, true);
		}
	}
	else
	$carpeta1 = "";
}
else
$carpeta1 = "";

$carpeta = "../../../../../archivos/tareas/".$_SESSION['user']."/tmp";
if (!file_exists($carpeta)){
	mkdir($carpeta, 0777, true);
}
	
$directorio_escaneado = scandir($carpeta);
$archivos = array();
foreach ($directorio_escaneado as $item) {
	if ($item != '.' and $item != '..') {
		$archivos[] = utf8_encode($item);
	}
}

if($carpeta1!='')
{
	$directorio_escaneado = scandir($carpeta1);
	foreach ($directorio_escaneado as $item) {
		if ($item != '.' and $item != '..') {
			$archivos[] = utf8_encode($item);
		}
	}
}

echo json_encode($archivos);
?>
