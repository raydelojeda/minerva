<?php

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $titulo_sitio;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $x.$tema_sitio;?>"/> 
<link rel="stylesheet" type="text/css" href="<?php echo $x.$tema_menu;?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo $x.$tema_calendario;?>" media="screen"/>
<link rel="shortcut icon" href="<?php echo $x.$fav_icon;?>"/>

<script type="text/javascript" src="<?php echo $x?>js/ajax.js"></script>

<style type="text/css">
	${demo.css}
</style>

<script type="text/javascript">
	$(function () {
		$('#container').highcharts({
			title: {
				text: '<?php echo $titulo_graf;?>',
				x: -20 //center
			},
			subtitle: {
				text: '<?php echo $subtitulo_graf;?>',
				x: -20
			},
			xAxis: {
				categories: [<?php echo $x_categ;?>]
			},
			yAxis: {
				title: {
					text: '<?php echo $y_categ;?>'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				valueSuffix: '<?php echo $unidad;?>'
			},
			legend: {
				layout: '<?php echo $layout;?>',
				align: '<?php echo $align;?>',
				verticalAlign: '<?php echo $verticalAlign;?>',
				borderWidth: 0
			},
			series: [<?php echo $datos;?>]
		});
	});
</script>



<script language="javascript" type="text/javascript" src="<?php echo $x.$js_menu;?>" ></script> 
<script language="javascript" type="text/javascript" src="<?php echo $x.$js_tema_menu;?>" ></script>
<script language="javascript" type="text/javascript" src="<?php echo $x.$js_calendario;?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo $x.$js_info_emergente;?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo $x.$js_general;?>"></script>

</head>

 
<body >
<form method="post" name="frm" id="frm" action="">
					<?php
						$obj->Header_menu($x,$img_banner,$nombre_empresa,$publicidad,$_SESSION["rol"],$camino_logout,$_SESSION["user"],$img_salir,$rs_sesion,$db);
						$obj->Encabezado_titulo($x,$img_encabezado,$titulo_listar,$l_botones,$rs_sesion,$elemento);
					?>
					<table class="tabla_contenido">
						<tr>
							<td  class="contenido">
							<!--Inicio Contenido-->
							