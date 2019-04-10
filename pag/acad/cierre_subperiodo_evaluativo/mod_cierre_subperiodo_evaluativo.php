<?php
//include("clase.php");
//if(!isset($obj_clase))$obj_clase = new clase();// (NO TOCAR)

include("variables.php");
include($x."plantillas/mod_header.php");

$mod="";// (NO TOCAR)



$sql_secc="SELECT DISTINCT n_seccion_academica.abreviatura AS abv_secc, seccion_academica, n_seccion_academica.id_seccion_academica 
FROM n_seccion_academica, n_grado, n_grado_paralelo, grado_paralelo_periodo, n_periodo_academico, curso_grado_paralelo_est
WHERE n_seccion_academica.id_seccion_academica=n_grado.id_seccion_academica
AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
AND n_grado_paralelo.id_grado=n_grado.id_grado 
AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico 
AND n_periodo_academico.activo='1' ORDER BY grado_paralelo_periodo.orden";
$rs_secc=$db->Execute($sql_secc) or die($db->ErrorMsg());

$rs_secc->MoveFirst();
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href='<?php print $x."js/tabs/css/luna/tab.css";?>'>
<link rel="stylesheet" type="text/css" href="../../../include/jquery-tree-master/src/css/jquery.tree.css"/>
<link rel="stylesheet" type="text/css" href="../../../include/jquery-tree-master/css/jquery-ui.css"/>

<script type="text/javascript" src='<?php print $x."js/tabs/js/tabpane.js";?>'></script>
<script type="text/javascript">document.documentElement.style.background = "luna";</script>
<script type="text/javascript">tp1 = new WebFXTabPane( document.getElementById( "tabPane1" ) );</script>

<link data-jsfiddle="common" rel="stylesheet" media="screen" href="<?php print $x."js/handsontable/dist/handsontable.css";?>">
<link data-jsfiddle="common" rel="stylesheet" media="screen" href="<?php print $x."js/handsontable/dist/pikaday/pikaday.css";?>">
<script data-jsfiddle="common" src="<?php print $x."js/handsontable/dist/pikaday/pikaday.js";?>"></script>
<script data-jsfiddle="common" src="<?php print $x."js/handsontable/dist/moment/moment.js";?>"></script>
<script data-jsfiddle="common" src="<?php print $x."js/handsontable/dist/zeroclipboard/ZeroClipboard.js";?>"></script>
<script data-jsfiddle="common" src="<?php print $x."js/handsontable/dist/handsontable.js";?>"></script>

<input name="hdn_cadena_id_imagen" id="hdn_cadena_id_imagen" type="hidden" value=""/>		

<script type="text/javascript" class="js-code-basic">
function marcar_avances(tipo_secc_periodo)
{
	cadena_id_imagen='';
	if (document.getElementById)
	{	
		imagen1=new Image
		imagen1.src="../../../img/acad/cierre_subperiodo_evaluativo/abierto.png";
		imagen2=new Image
		imagen2.src="../../../img/acad/cierre_subperiodo_evaluativo/cerrado.png";
	}
	
	arr_tipo_secc_periodo = String(tipo_secc_periodo).split("_");
	
	tipo=arr_tipo_secc_periodo[0];
	secc=arr_tipo_secc_periodo[1];
	periodo=arr_tipo_secc_periodo[2];
	
	id_clases = String(eval("document.frm.hdn_id_clase_"+secc+".value")).split(",");
	
	for (i=0;i<id_clases.length;i++)
	{
		id_imagen=tipo_secc_periodo+'_'+id_clases[i];
		if(cadena_id_imagen=='')cadena_id_imagen=id_imagen;else cadena_id_imagen=cadena_id_imagen+','+id_imagen;
		
		if(document.images[id_imagen].src == imagen1.src)
		{
			document.images[id_imagen].src = imagen2.src;
			
		}
		else 
		{
			document.images[id_imagen].src = imagen1.src;
		}
	}
	document.frm.hdn_cadena_id_imagen.value=cadena_id_imagen;
	ejecutar_ajax('guardar_avance.php','hdn_cadena_id_imagen','')
}

function cambiar_avance(id_imagen)
{
	if (document.getElementById)
	{	
		imagen1=new Image
		imagen1.src="../../../img/acad/cierre_subperiodo_evaluativo/abierto.png";
		imagen2=new Image
		imagen2.src="../../../img/acad/cierre_subperiodo_evaluativo/cerrado.png";

		if(document.images[id_imagen].src == imagen1.src)
		{
			document.images[id_imagen].src = imagen2.src;
			
		}
		else 
		{
			document.images[id_imagen].src = imagen1.src;
		}
		ejecutar_ajax('guardar_avance.php','hdn_celda_'+id_imagen,'')
	}
}
</script>
&nbsp;
<br>

<div style='margin: 0 auto;width:98%;'>
	<div class="tab-pane" id="tabPane">
		<?php 
			include("avances.php");
			$avances = new avances();
			$avances->contenido_avances($db, $rs_secc);
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

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/mod_footer.php");
?>