<?php
ob_start();

include_once("var_lis.php");
include_once("cuaderno_clase_resumen.php");
if(!isset($obj_cuaderno_clase_resumen))$obj_cuaderno_clase_resumen = new cuaderno_clase_resumen();// (NO TOCAR)
include_once("cuaderno_clase_asistencia.php");
if(!isset($obj_cuaderno_clase_asistencia))$obj_cuaderno_clase_asistencia = new cuaderno_clase_asistencia();// (NO TOCAR)
include_once("cuaderno_clase_calificacion.php");
if(!isset($obj_cuaderno_clase_calificacion))$obj_cuaderno_clase_calificacion = new cuaderno_clase_calificacion();// (NO TOCAR)
include_once("cuaderno_clase_comportamiento.php");
if(!isset($cuaderno_clase_comportamiento))$obj_cuaderno_clase_comportamiento = new cuaderno_clase_comportamiento();// (NO TOCAR)
include_once("cuaderno_clase_recomendacion.php");
if(!isset($cuaderno_clase_recomendacion))$obj_cuaderno_clase_recomendacion = new cuaderno_clase_recomendacion();// (NO TOCAR)

include_once($x."plantillas/mod_header.php");
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href='<?php print $x."js/tabs/css/luna/tab.css";?>'>
<script type="text/javascript" src='<?php print $x."js/tabs/js/tabpane.js";?>'></script>

<script src="<?php print $x."include/ckeditor/ckeditor.js";?>"></script>

<link data-jsfiddle="common" rel="stylesheet" media="screen" href="<?php print $x."js/handsontable/dist/handsontable.css";?>">
<link data-jsfiddle="common" rel="stylesheet" media="screen" href="<?php print $x."js/handsontable/dist/pikaday/pikaday.css";?>">
<script data-jsfiddle="common" src="<?php print $x."js/handsontable/dist/pikaday/pikaday.js";?>"></script>
<script data-jsfiddle="common" src="<?php print $x."js/handsontable/dist/moment/moment.js";?>"></script>
<script data-jsfiddle="common" src="<?php print $x."js/handsontable/dist/zeroclipboard/ZeroClipboard.js";?>"></script>
<script data-jsfiddle="common" src="<?php print $x."js/handsontable/dist/handsontable.js";?>"></script>

<script src="<?php echo $x;?>js/Highcharts-4.1.4/js/highcharts.js"></script>
<script src="<?php echo $x;?>js/Highcharts-4.1.4/js/modules/exporting.js"></script>

<p style='text-align:center;font-weight: bold; width:98%;'>
<?php //print $asignatura.',  '.$referencia;?>
</p>

<input name="row" id="row" type="hidden" value=""/>
<input name="col" id="col" type="hidden" value=""/>

<div style='margin: 0 auto;width:98%;'>
	<div class="tab-pane" id="tabPane">
		<?php
			//$sel_filtro_cal=$obj_cuaderno_clase->insertar_periodos_avance($db, $mod);//print 'ee '.$sel_filtro_cal;
			///$sel_filtro_asis=$obj_cuaderno_clase->devolver_id_subperiodo($db, $mod);
			$obj_cuaderno_clase_resumen->pestana_resumen($db);
			$obj_cuaderno_clase_asistencia->pestana_asistencia($db);				
			$obj_cuaderno_clase_calificacion->pestana_calificacion($db);
			$obj_cuaderno_clase_comportamiento->pestana_comportamiento($db);
			$obj_cuaderno_clase_recomendacion->pestana_recomendacion($db);
		?>
	</div>
</div>

<?php
if(isset($_GET['mensaje']))
$mensaje=$_GET['mensaje'];
if(isset($return[0]))
$mensaje=$return[0];
$obj->Imprimir_mensaje($mensaje);
?>
<br>
<div id="modal_asistencia" class="modalmask"></div>
<div id="modal_calificacion" class="modalmask"></div>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
include_once($x."plantillas/new_footer.php");
?>