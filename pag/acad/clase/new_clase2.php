<?php
include("clase.php");
if(!isset($obj_clase))$obj_clase = new clase();// (NO TOCAR)

include("variables.php");
$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>"valida_pro();",'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
include($x."plantillas/new_header.php");

$visualizar="";// (NO TOCAR)
$checked="";
$abrev="";
$seccion_academica_ant='';
$hoy=date("Y-m-d");

$sql_p="select id_periodo_academico as id_periodo_academico, concat(n_periodo_academico.nombre,'  -  ',fecha_ini,'/',fecha_fin) as periodo_academico, activo from n_periodo_academico WHERE activo='1' ORDER BY fecha_ini";
$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());

$sql_a="SELECT id_asignatura as id_asignatura, concat(abreviatura,' - ',asignatura) AS asignatura, asignatura AS asig FROM n_asignatura";
$rs_a=$db->Execute($sql_a) or die($db->ErrorMsg());

$sql_pro="select id_empleado_academico, concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre,' - ',persona.identificacion) as empleado_academico 
from empleado, persona, empleado_academico WHERE 1 AND persona.id_persona=empleado.id_persona AND empleado_academico.id_empleado=empleado.id_empleado ORDER BY primer_apellido, segundo_apellido, primer_nombre, segundo_nombre";
$rs_pro=$db->Execute($sql_pro) or die($db->ErrorMsg());

$sql_gra="SELECT DISTINCT n_grado_paralelo.id_grado AS id_grado, n_grado.abreviatura AS abv_gra, n_seccion_academica.abreviatura AS abv_secc, seccion_academica, grado, n_periodo_academico.id_periodo_academico 
FROM n_seccion_academica, n_grado, n_grado_paralelo, grado_paralelo_periodo, n_periodo_academico, curso_grado_paralelo_est
WHERE n_seccion_academica.id_seccion_academica=n_grado.id_seccion_academica
AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
AND n_grado_paralelo.id_grado=n_grado.id_grado 
AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico 
AND n_periodo_academico.activo='1' ORDER BY grado_paralelo_periodo.orden";
$rs_gra=$db->Execute($sql_gra) or die($db->ErrorMsg());

if(isset($_POST['aux_submit']))
{
	if($_POST['aux_submit']!='')
	{
		for($g=0;$g<$rs_gra->RecordCount();$g++)
		{
			$rs_a->MoveFirst();
			for($a=0;$a<$rs_a->RecordCount();$a++)
			{//print 'sel_profesor_'.$rs_a->fields['id_asignatura'].$rs_gra->fields['id_grado'].'<br>';
				
				if(isset($_POST['sel_profesor_'.$rs_a->fields['id_asignatura'].$rs_gra->fields['id_grado']]))
				{
					if($_POST['sel_profesor_'.$rs_a->fields['id_asignatura'].$rs_gra->fields['id_grado']]!='')
					{
						
						$asignatura=$rs_a->fields['id_asignatura'];
						$profesor=$_POST['sel_profesor_'.$rs_a->fields['id_asignatura'].$rs_gra->fields['id_grado']];
						$periodo=$rs_gra->fields['id_periodo_academico'];
						
						$sql_par="SELECT n_paralelo.id_paralelo, paralelo FROM n_paralelo, n_grado_paralelo, grado_paralelo_periodo, n_periodo_academico
						WHERE 1 AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
						AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico 
						AND n_periodo_academico.activo='1' AND n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo AND id_grado='".$rs_gra->fields['id_grado']."'";
						$rs_par=$db->Execute($sql_par) or die($db->ErrorMsg());
						
						for($p=0;$p<$rs_par->RecordCount();$p++)
						{
							$nombre=$rs_a->fields['asig'].' '.$rs_gra->fields['abv_gra'].' '.$rs_gra->fields['abv_secc'].'-'.$rs_par->fields['paralelo'];
							$referencia=strtoupper($rs_gra->fields['seccion_academica'].', '.$rs_gra->fields['grado'].', '.$rs_gra->fields['abv_gra'].'-'.$rs_par->fields['paralelo'].', '.$rs_a->fields['asig']);//print $referencia.'<br>';
							$codigo=strtoupper($rs_gra->fields['abv_secc'].'-'.$rs_gra->fields['abv_gra'].'-'.$rs_par->fields['paralelo'].'-'.substr($rs_a->fields['asig'], 0, 3));//print $codigo.'<br>';
																				
							$i_sql="INSERT INTO clase(nombre, referencia, codigo, codigo_unico, peso, id_asignatura, id_empleado_academico, id_periodo_academico) 
							VALUES ('".$nombre."','".$referencia."','".$codigo."', '".$codigo."', '100', '".$asignatura."', '".$profesor."', '".$periodo."')";//print $i_sql."<br>";
							$db->Execute($i_sql) or die($db->ErrorMsg());
							
							$i_sql="SELECT LAST_INSERT_ID() AS myid";
							$rs=$db->Execute($i_sql) or die($db->ErrorMsg());
							
							$id_clase=$rs->fields['myid'];
							
							$sql_est="SELECT curso_grado_paralelo_est.id_curso_grado_paralelo_est 
							FROM n_paralelo, n_grado_paralelo, grado_paralelo_periodo, n_periodo_academico, curso_grado_paralelo_est
							WHERE 1 AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
							AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
							AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico 
							AND n_periodo_academico.activo='1' AND n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo 
							AND id_grado='".$rs_gra->fields['id_grado']."' AND n_paralelo.id_paralelo='".$rs_par->fields['id_paralelo']."'";//print $sql_est.'<br>';
							$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
							
							for($e=0;$e<$rs_est->RecordCount();$e++)
							{
								$i_sql="INSERT INTO clase_estudiante(id_clase, id_curso_grado_paralelo_est, fecha_entrada, retirado) 
								VALUES ('".$id_clase."','".$rs_est->fields['id_curso_grado_paralelo_est']."', '".$hoy."', '0')";//print $i_sql;
								$db->Execute($i_sql) or die($db->ErrorMsg());
			
							$rs_est->MoveNext();
							}	
						
						$rs_par->MoveNext();
						}
					}
				}
			
			$rs_a->MoveNext();
			}
		$rs_gra->MoveNext();
		}
	echo ("<script language=\"JavaScript\" type=\"text/javascript\"> location.href='../".$elemento."/lis_".$elemento.".php?mensaje=Datos guardados correctamente'</script>");
	}
}
$rs_gra->MoveFirst();
$rs_a->MoveFirst();
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href='<?php print $x."js/tabs/css/luna/tab.css";?>'>
<script type="text/javascript" src='<?php print $x."js/tabs/js/tabpane.js";?>'></script>
<?php

?>
<script type="text/javascript" class="js-code-basic">
function quitar_fila(id, id_grado)
{
	fila = document.getElementById(id);
	if(fila.style.display!='none')
	{
		fila.style.display='none';
		if(document.getElementById('vinculo_'+id))document.getElementById('vinculo_'+id).style.display='block';
		
		document.getElementById('sel_profesor_'+id).selectedIndex="0";
		
		hdn_filas_agregadas=document.getElementById('hdn_filas_agregadas_'+id_grado);
		if(hdn_filas_agregadas.value=='')hdn_filas_agregadas.value=0;	
		hdn_filas_agregadas.value=(parseInt(hdn_filas_agregadas.value) - parseInt(1));
		
		if(hdn_filas_agregadas.value<=0){document.getElementById('no_asig_'+id_grado).style.display='table';document.getElementById('pro_asig_'+id_grado).style.display='none';}
		
		var completa=document.frm.on_submit_clase.value;
		if(completa.search(",sel_profesor_"+id) != -1)		
		document.frm.on_submit_clase.value=completa.replace(",sel_profesor_"+id,"");
		else if(completa.search("sel_profesor_"+id+",") != -1)
		document.frm.on_submit_clase.value=completa.replace("sel_profesor_"+id+",","");
		else if(completa.search("sel_profesor_"+id) != -1)
		document.frm.on_submit_clase.value=completa.replace("sel_profesor_"+id,"");	
		
		//if(document.frm.on_submit_clase.value=="")
		//document.frm.on_submit_clase.value="alertify.error('Debe escoger alguna asignatura y su profesor.');"
	}
}

function agregar_fila(id, id_grado)
{
	fila = document.getElementById(id);
	if(fila.style.display!='table')
	{
		fila.style.display='table';
		document.getElementById('vinculo_'+id).style.display='none';
		
		$(".basic_single"+id).select2();
		
		document.getElementById('no_asig_'+id_grado).style.display='none';
		document.getElementById('pro_asig_'+id_grado).style.display='table';
		hdn_filas_agregadas=document.getElementById('hdn_filas_agregadas_'+id_grado);
		if(hdn_filas_agregadas.value=='')hdn_filas_agregadas.value=0;	
		hdn_filas_agregadas.value=(parseInt(hdn_filas_agregadas.value) + parseInt(1));
		
		if(document.frm.on_submit_clase.value=="")
		document.frm.on_submit_clase.value="sel_profesor_"+id;
		else
		{
			document.frm.on_submit_clase.value=document.frm.on_submit_clase.value+",sel_profesor_"+id;
		}
	}
}
function valida_pro()
{
	error=''
	
	if(document.frm.on_submit_clase.value=='')
	error+='Debe escoger alguna asignatura y su profesor.';
	else
	{
		names = String(document.frm.on_submit_clase.value).split(",");
		
		for (i=0;i<(names.length);i+=1) 
		{
			sel_profesor=document.getElementById(names[i]);
			
			if(sel_profesor.value=='')
			error+='Debe escoger el campo '+sel_profesor.title+'.<br>';
		}
	}
	
	if(error!='') 
	alertify.error('El siguiente error ocurri\u00F3:<br>'+error);	
	else
	{
		document.frm.aux_submit.value='ok';
		document.frm.submit();
	}
}
</script>
&nbsp;
<br>

<div style='margin: 0 auto;width:98%;'>
	<div class="tab-pane" id="tabPane">
		<?php 
		for($s=0;$s<$rs_gra->RecordCount();$s++)
		{
			$seccion_academica=$rs_gra->fields['abv_secc'];
			if($seccion_academica_ant!=$seccion_academica)
			{
				$ok=1;
		?>
			<div class="tab-page">
				<h2 class="tab"><?php print $seccion_academica;$seccion_academica_ant=$rs_gra->fields['abv_secc'];?></h2>
				<div class="tab-pane" id="tabPane1">
		<?php 
			}
		?>
				<div class="tab-page">
					<h2 class="tab"><?php print $rs_gra->fields['abv_gra'];?></h2>
						<?php
						$sql_par="SELECT n_paralelo.id_paralelo, paralelo FROM n_paralelo, n_grado_paralelo, grado_paralelo_periodo, n_periodo_academico
						WHERE 1 AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
						AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico 
						AND n_periodo_academico.activo='1' AND n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo AND id_grado='".$rs_gra->fields['id_grado']."'";
						$rs_par=$db->Execute($sql_par) or die($db->ErrorMsg());
						
						if($rs_par->RecordCount()==1)
						print '<center><b>El curso tiene '.$rs_par->RecordCount().' paralelo.</b></center><br>';
						else print '<center><b>Hay '.$rs_par->RecordCount().' paralelos.</b></center><br>';
						?>
						<div class='tabla_filtro' style='display:table;width:98%;margin-left:auto;margin-right:auto'>
						<div style='display:table-row;'>
						<div style='display:table-cell;width:30%;'>
						<?php			
							$obj_clase->asignaturas_clase($db,$x,$rs_gra->fields['id_grado']);
						?>
						</div>
						
						<div style='display:table-cell;width:68%;'>
						<?php			
							$obj_clase->asignaturas_seleccionadas($db,$x,$rs_gra->fields['id_grado']);
						?>
						</div>
						</div>
						</div>
				</div>
				<input name="hdn_filas_agregadas_<?php print $rs_gra->fields['id_grado'];?>" id="hdn_filas_agregadas_<?php print $rs_gra->fields['id_grado'];?>" type="hidden" value=""/>
				
						
		<?php
			$rs_gra->MoveNext();
			$seccion_academica=$rs_gra->fields['abv_secc'];
			if($seccion_academica_ant!=$seccion_academica)
			{
		?>	
				</div>
			</div>
		<?php
			}
		$ok='';
		
		}
		?>
	</div>
</div>

<input name="on_submit_clase" id="on_submit_clase" size='150' type="hidden" value=""/>

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
 include($x."plantillas/new_footer.php");
?>