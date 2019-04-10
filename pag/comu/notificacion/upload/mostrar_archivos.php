<?php
$carpeta = "../../../../archivos/esquelas/".$_SESSION['user']."/tmp";//print $target_path;
$directorio_escaneado = scandir($carpeta);
$archivos = array();
foreach ($directorio_escaneado as $item) {
    if ($item != '.' and $item != '..') {
        $archivos[] = utf8_encode($item);
    }
}
echo json_encode($archivos);
?>
