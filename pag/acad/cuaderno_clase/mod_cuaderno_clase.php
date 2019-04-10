<?php
include("cuaderno_clase.php");
if(!isset($obj_cuaderno_clase))$obj_cuaderno_clase = new cuaderno_clase();// (NO TOCAR)

$x='../../../';
include("calificacion/var_mod.php");
include($x."plantillas/new_header.php");

if(isset($_GET["mod"]))
$mod=$_GET["mod"];

$sql_asig="SELECT clase.id_asignatura, clase.referencia AS referencia, concat(n_asignatura.abreviatura,' - ',n_asignatura.asignatura) AS asignatura FROM n_asignatura, clase, n_periodo_academico,
empleado_academico, empleado, persona, usuario 
WHERE 1
AND n_asignatura.id_asignatura=clase.id_asignatura
AND clase.id_periodo_academico=n_periodo_academico.id_periodo_academico 
AND clase.id_empleado_academico=empleado_academico.id_empleado_academico 
AND persona.id_persona=empleado.id_persona 
AND persona.id_persona=usuario.id_persona
AND empleado_academico.id_empleado=empleado.id_empleado 
AND n_periodo_academico.activo='1' AND clase.id_clase='".$mod."'";

if(isset($rs_sesion->fields[0]))
{
	$rs_sesion->MoveFirst();
	for($q=0;$q<$rs_sesion->RecordCount();$q++)
	{//print $rs_sesion->fields['elemento'].' == '.$rs_sesion->fields['accion'].'<br>';
		if($rs_sesion->fields['elemento']=='todos_cuadernos_clase' AND $rs_sesion->fields['accion']=="Editar")
		{
			$todos="ok";break;
		}
		else
		{
			$todos="";
		}
	$rs_sesion->MoveNext();
	}
}

if(isset($todos))
{
	if($todos!='ok')
	{
		$l_sql="SELECT id_clase as id_clase
		FROM clase, n_periodo_academico, n_asignatura, empleado_academico, empleado, persona, usuario WHERE 1 
		AND clase.id_periodo_academico=n_periodo_academico.id_periodo_academico AND clase.id_asignatura=n_asignatura.id_asignatura 
		AND clase.id_empleado_academico=empleado_academico.id_empleado_academico AND persona.id_persona=empleado.id_persona AND persona.id_persona=usuario.id_persona
		AND empleado_academico.id_empleado=empleado.id_empleado AND n_periodo_academico.activo='1' AND usuario='".$_SESSION['user']."'";
		$rs=$db->Execute($l_sql) or die($db->ErrorMsg());
		
		for($c=0;$c<$rs->RecordCount();$c++)
		{
			if($rs->fields['id_clase']==$mod)
			{$si=1;break;}
			else
			$si=0;
		}
		
		if($si==0)echo ("<script language='JavaScript' type='text/javascript'> location.href='lis_cuaderno_clase.php?mensaje=Ud. no tiene acceso al cuaderno de clase que intenta acceder.' </script>");
	}
}
 
$rs_asig=$db->Execute($sql_asig) or die($db->ErrorMsg());

$sql_sub="SELECT n_periodo_lectivo.id_periodo_lectivo AS id_periodo_lectivo, periodo_lectivo,
n_periodo_evaluativo.id_periodo_evaluativo AS id_periodo_evaluativo, periodo_evaluativo,
n_subperiodo_evaluativo.id_subperiodo_evaluativo AS id_subperiodo_evaluativo, concat(subperiodo_evaluativo,' (',abv_subperiodo,')') as subperiodo_evaluativo 
FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica 
WHERE 1 
AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo 
AND n_periodo_lectivo.id_periodo_lectivo=n_periodo_evaluativo.id_periodo_lectivo 
AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica 
AND n_conf_academica.activa='1'";//print $sql_sub;
$rs_sub=$db->Execute($sql_sub) or die($db->ErrorMsg());

$id_asignatura=$rs_asig->fields['id_asignatura'];
$asignatura=$rs_asig->fields['asignatura'];
$referencia=$rs_asig->fields['referencia'];
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
<script src="<?php print $x."include/upload/js/upload.js";?>"></script>
<script src="<?php print $x."include/upload/js/bootstrap.min.js";?>"></script>
<script src="js.js"></script>
<p style='text-align:center;font-weight: bold; width:98%;'>
<?php print $asignatura.',  '.$referencia;?>
</p>

<input name="row" id="row" type="hidden" value=""/>
<input name="col" id="col" type="hidden" value=""/>
<input name="hdn_id_asignatura" id="hdn_id_asignatura" type="hidden" value="<?php print $id_asignatura;?>"/>
<input name="hdn_id_clase" id="hdn_id_clase" type="hidden" value="<?php print $mod;?>"/>

<?php
	$sel_filtro_cal=$obj_cuaderno_clase->insertar_periodos_avance($db, $mod);//print ' sel_filtro_cal: '.$sel_filtro_cal;
	$sel_filtro_asis=$obj_cuaderno_clase->devolver_id_subperiodo($db, $mod);//print ' sel_filtro_asis: '.$sel_filtro_asis;
?>

<div id="modal_ins_actividad" class="modalmask">
	<div class="modalbox movedown">
		<br>
		<div id='modal_insertar_actividad'>
			<?php
				$id_subperiodo_evaluativo=substr($sel_filtro_cal, 2, strlen($sel_filtro_cal));
				$rs_sub->MoveFirst();
				include($x."pag/acad/actividad/variables.php");
				
				$obj->mini_encabezado_titulo($x,$img_encabezado,$titulo_nuevo,$mini_n_botones,$rs_sesion,$elemento);
				print '<br>';
			?>
			
				<div class="tab-pane" id="tabPane">
					<div class="tab-page">
						<h2 class="tab">Actividad o Examen</h2>
						<?php
							$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li','');
						?>					
					</div>
			
					<div class="tab-page" id='tarea_detalles_ins' style='display:none;'>
						<h2 class="tab">Tarea en casa</h2>
						&nbsp;<b>Este tipo de actividad o examen no tiene nada detallado para hacer en casa.</b>
					</div>
				</div>
			
				<script type="text/javascript">setupAllTabs();</script>		
			<?php
			if(isset($return[0]))
			$mensaje=$return[0];
			$obj->Imprimir_mensaje($mensaje);
			?>
		</div>
	</div>
</div>

<div id="modal_ins_asistencia" class="modalmask">
	<div class="modalbox movedown">
		<br>
		<div id='modal_insertar_asistencia'>
			<?php
			$rs_sub->MoveFirst();//$sel_filtro_asis='1';
			include($x."pag/acad/clase_inasistencia/variables.php");
			
			$obj->mini_encabezado_titulo($x,$img_encabezado,$titulo_nuevo,$mini_n_botones,$rs_sesion,$elemento);
			
			print '<br>';
			$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)			
			$obj->Generar_inputs($inputs,'',$opt_value,$opt_sel,$opt_name,$db,$combo_sql,$insert_alias,'ul-li','');

			if(isset($return[0]))
			$mensaje=$return[0];
			$obj->Imprimir_mensaje($mensaje);
			?>
		</div>
	</div>
</div>

<div id="modal_mod_actividad" class="modalmask"></div>
<div id="modal_mod_asistencia" class="modalmask"></div>

<div style='margin: 0 auto;width:98%;'>
	<div class="tab-pane" id="tabPane">
		<?php
			$obj_cuaderno_clase->pestana_asistencia($db, $x, $mod, $rs_sub, $rs_asig, $sel_filtro_asis);				
			$obj_cuaderno_clase->pestana_calificacion($db, $x, $mod, $rs_sub, $rs_asig, $sel_filtro_cal);
			$obj_cuaderno_clase->pestana_comportamiento($db, $x, $mod, $rs_sub, $rs_asig);
			$obj_cuaderno_clase->pestana_recomendaciones($db, $x, $mod, $rs_sub, $rs_asig, $sel_filtro_cal);
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
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
include($x."plantillas/new_footer.php");
?>