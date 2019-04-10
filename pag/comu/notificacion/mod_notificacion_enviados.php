<?php
include("variables.php");
include($x."plantillas/mod_header.php");

if(isset($_GET["mod"]))
$mod=$_GET["mod"];

$sql_m="SELECT concat(persona.primer_apellido,' ',persona.primer_nombre) AS remitente, asunto, mensaje, fecha_envio, urgente, notificacion.id_notificacion
FROM recibidos, notificacion, persona
WHERE 1 AND recibidos.id_persona_destinatario=persona.id_persona AND recibidos.id_notificacion=notificacion.id_notificacion
AND id_recibidos='".$mod."'";//print $sql_m;
$rs_m=$db->Execute($sql_m) or die($db->ErrorMsg());

$asunto=$rs_m->fields['asunto'];
$mensaje=$rs_m->fields['mensaje'];
$remitente=$rs_m->fields['remitente'];//destinatario
$fecha_envio=$rs_m->fields['fecha_envio'];
$urgente=$rs_m->fields['urgente'];
$id_notificacion=$rs_m->fields['id_notificacion'];

$sql_adj="SELECT nombre_adjunto
FROM adjuntos, notificacion
WHERE 1 AND adjuntos.id_notificacion=notificacion.id_notificacion
AND notificacion.id_notificacion='".$id_notificacion."'";//print $sql_adj;
$rs_adj=$db->Execute($sql_adj) or die($db->ErrorMsg());
//print $rs_adj->RecordCount();
if(isset($rs_adj))
{
	if($rs_adj->fields['nombre_adjunto']!='')
	{
		$nombre_adjunto='<h1><b>Adjuntos:</b></h1>';
		
		for($a=0;$a<$rs_adj->RecordCount();$a++)
		{
			$nombre_adjunto.='<br>'.'<a href="../../../archivos/esquelas/'.$_SESSION['user'].'/'.$id_notificacion.'/'.utf8_encode($rs_adj->fields['nombre_adjunto']).'"  download="'.utf8_encode($rs_adj->fields['nombre_adjunto']).'">'.utf8_encode($rs_adj->fields['nombre_adjunto']).'</a>';
		$rs_adj->MoveNext();
		}
	}
}
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

&nbsp;
<br>

<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href='<?php print $x."js/tabs/css/luna/tab.css";?>'>
<script type="text/javascript" src='<?php print $x."js/tabs/js/tabpane.js";?>'></script>
<script type="text/javascript">document.documentElement.style.background = "luna";</script>
<script type="text/javascript">tp1 = new WebFXTabPane( document.getElementById( "tabPane1" ) );</script>

<div style='margin: 0 auto;width:98%;'>
	<div class="tab-pane" id="tabPane1">
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Mensaje</h2>
			<div style='display:table;width:100%;'>
				<br>
				<div style='display:table-row;'>					
					<div style='display:table-cell;width:100%;text-align:left;padding-left:1%;font-size:14px;'><?php echo '<img style="margin:3px;border-radius:5px;" width="50px" src="'.$x.'img/general/no_disponible.png"/>';print 'Para: '.$remitente.' - '.$fecha_envio.' ';if($urgente==1)print '<img style="margin:3px;border-radius:5px;" width="16px" src="'.$x.'img/general/importante.png"/>';?></div>
				</div>
				<br>
				<div style='display:table-row;'>					
					<div style='display:table-cell;width:100%;text-align:left;padding-left:1%;font-size:24px;'><?php print $asunto;?></div>
				</div>
				<br>
				<div style='display:table-row;'>					
					<div style='display:table-cell;width:100%;text-align:left;padding-left: 1%;'><?php print $mensaje;?></div>
				</div>
				<?php if(isset($nombre_adjunto)){if($nombre_adjunto!=''){?>
				<br>
				<div style='display:table-row;'>					
					<div style='display:table-cell;width:100%;text-align:left;padding-left: 1%;'><?php print $nombre_adjunto;?></div>
				</div>
				<?php }}?>
			</div>
		</div>
		
</div>

<script type="text/javascript">setupAllTabs();</script>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/mod_footer.php");
?>