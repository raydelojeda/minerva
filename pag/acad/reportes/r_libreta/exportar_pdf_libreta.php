<?php
$x='../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");
require_once("../../../../include/dompdf/vendor/autoload.php");
require_once("../../../../include/dompdf/autoload.inc.php");

use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->set_option('isHtml5ParserEnabled', true);

include("../../clases_acad.php");
if(!isset($clases_acad))$clases_acad = new clases_acad();// (NO TOCAR)

$w=0;
for($g=0;$g<10;$g++)
{
	if(isset($_GET['val'.$g]))
	{
		if($_GET['val'.$g]!=0)
		{
			$array_periodos[$w]=$_GET['val'.$g];
			$w=$w+1;
		}
	}
}

$sql_nota="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_academica WHERE activa='1'";//print $sql_nota.'<br>';
$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());

$nota_aprobado=$rs_nota->fields['nota_aprobado'];

$sql_periodo="SELECT nombre FROM n_periodo_academico WHERE 1 AND activo='1'";
$rs_periodo=$db->Execute($sql_periodo) or die($db->ErrorMsg());

$id_estudiante=$_GET['id'];//die();

$pos = strpos($id_estudiante, '-');
if($pos)
$id_estudiantes = explode("-",$id_estudiante);
else
$id_estudiantes[0]=$id_estudiante;
	
ob_start();
?>	
<!DOCTYPE html>
<html lang="pt">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $titulo_sitio;?></title>
</head>
<body>

<?php
for($e=0;$e<count($id_estudiantes);$e++)
{
	$id_estudiante=$id_estudiantes[$e];

	if($e > 0){?><div style="page-break-before: always;"></div><?php }
	$datos_est=$clases_acad->datos_estudiante($db, $id_estudiante);
?>

	<table style='border:1px solid;width:100%;border-spacing:0px;border-collapse:collapse;'>	
		<tr  style='background-color:#ddd;width:100%;height:50px;'>	
			<td style='width:33%;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 14px;text-align:center;border:0px ;'>
				<img alt='Logotipo' src="<?php print $x.$logo;?>" width="40">&nbsp;&nbsp;<?php echo $nombre_sucursal;?>
			</td>

			<td style='width:33%;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 18px;text-align:center;border:0px ;'>
				Reporte de rendimiento y comportamiento
			</td>
			
			<td style='font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 14px;text-align:center;border:0px;'>
				Per&iacute;odo acad&eacute;mico <?php print $rs_periodo->fields['nombre'];?>
			</td>		
		</tr>
	</table>

	<br>

	<table style='border:1px solid;width:100%;border-spacing:0px;border-collapse:collapse;'>
		<tr  style='background-color:#ddd;width:100%;height:30px;'>	
			<td style='width:10%;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:right;border:0px ;'>
				Estudiante:
			</td>

			<td style='width:30%;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 12px;text-align:left;border:0px ;'>
				<?php print '&nbsp;'.$datos_est['estudiante'];?>
			</td>

			<td style='width:10%;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:right;border:0px ;'>
				Curso:
			</td>

			<td style='width:20%;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 12px;text-align:left;border:0px ;'>
				<?php print '&nbsp;'.$datos_est['curso'];print '&nbsp;'.$datos_est['paralelo'];?>
			</td>
			
			<td style='width:10%;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:right;border:0px ;'>
				Tutor:
			</td>
			
			<td style='width:20%;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 12px;text-align:left;border:0px ;'>
				<?php print '&nbsp;'.$datos_est['tutor'];?>
			</td>
			
		</tr>
		
	</table>
	<br>
	<table style='border:1px solid;width:100%;border-spacing:0px;border-collapse:collapse;'>
		

	<?php
	$varios_arreglos=$clases_acad->consulta_est_calificaciones_libreta($db, $id_estudiante, $array_periodos);
			
	$datos=$varios_arreglos[0]['datos'];
	$column=$varios_arreglos[0]['column'];
	$abv=$varios_arreglos[0]['abv'];
	$actividad=$varios_arreglos[0]['actividad'];
	$tipo=$varios_arreglos[0]['tipo'];
	$pos_libreta=$varios_arreglos[0]['pos_libreta'];
	$asig=$varios_arreglos[0]['asig'];
	$peso=$varios_arreglos[0]['peso'];
	$cualit=$varios_arreglos[0]['cualit'];
	$id=$varios_arreglos[0]['id'];
	$width=300+count($actividad)*50;//print 'ddd';

	$abv[0]='ASIGNATURAS';
	$asig_ant='';$asig_sig='';

	?>

	<tr style='width:100%;'>
		<?php for($c=0;$c<=count($actividad);$c++){$background[array_search($c, $pos_libreta)]='#ddd';if(isset($tipo[$c])){if($tipo[array_search($c, $pos_libreta)]=='p' OR $tipo[array_search($c, $pos_libreta)]=='l')$background[array_search($c, $pos_libreta)]='#aaa';}?>
			<td style='background-color:<?php print $background[array_search($c, $pos_libreta)];?>;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:center;border:1px solid;<?php if($c!=0){?> width:4.6875%;<?php }else{?> width:25%;<?php }?>'>
				<?php if($c!=0)print $abv[array_search($c, $pos_libreta)];else print $abv[$c];?>
			</td>
		<?php }?>
	</tr>	


	<?php
	$fila=0;

	for($f=0;$f<count($datos);$f++)
	{
		if(isset($asig[$f][0]))
		{
			if($asig[$f][0]!=$asig_ant)//AKI SE AGREGA LA ASIGNATURA Y SE CALCULA SU PROMEDIO
			{
				if(isset($asig[$f+1][0]))$asig_sig=$asig[$f+1][0];else $asig_sig='';
				
				?>
				<tr style='width:100%;'>
					<td style='font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:left;border:1px solid;border-color:#000;'>
						<?php print $asig[$f][0];?>
					</td>
					<?php 
					for($c=1;$c<=count($actividad);$c++)//UN FOR POR LOS PERIODOS
					{
						$background[array_search($c, $pos_libreta)]='#fff';if(isset($tipo[$c])){if($tipo[array_search($c, $pos_libreta)]=='p' OR $tipo[array_search($c, $pos_libreta)]=='l')$background[array_search($c, $pos_libreta)]='#aaa';}
						
						$cant_clase=0;$suma_prom_peso_clase=0;$suma_prom_clase=0;$prom_asig='';$asignatura_sig='';$suma_peso=0;
				
						$asignatura_pri=$asig[$f][0];
						$peso_pri=$peso[$f][0];
						$prom_clase_pri=$datos[$f][array_search($c, $pos_libreta)];
						
						//if(!ctype_alpha($prom_clase_pri))//SI NO ES CUALITATIVO
						//{
						
							if($prom_clase_pri!='' && $prom_clase_pri!=0)//PARA EL CALCULO DEL PROMEDIO DE LA ASIGNATURA, AKI SE TOMA LA PRIMERA CLASE
							{
								$suma_peso=bcadd($suma_peso, $peso_pri, 10);
								$prom_peso_clase_pri=bcmul($prom_clase_pri, $peso_pri, 10);
								$suma_prom_peso_clase=bcadd($suma_prom_peso_clase, $prom_peso_clase_pri, 10);
								
								$cant_clase=1;
								$suma_prom_clase=bcadd($suma_prom_clase, $prom_clase_pri, 10);//print ' <br>suma_prom_clase:'.$suma_prom_clase.'  f:'.$f;
							}
							
							for($n=$f+1;$n<count($datos);$n++)//PARA CALCULAR LA NOTA DE LA ASIGNATURA
							{
								if(isset($asig[$n][0]))
								{
									$asignatura_act=$asig[$n][0];
									$peso_act=$peso[$n][0];
									$prom_clase_act=$datos[$n][array_search($c, $pos_libreta)];
								}
								
								if($asignatura_pri!=$asignatura_act)
								{
									//print ' <br>suma_prom_peso_clase: '.$suma_prom_peso_clase;
									break;
								}					
								elseif($asignatura_pri==$asignatura_act && $prom_clase_act!='' && $prom_clase_act!=0)
								{
									//print ' <br>asignatura_act:'.$asignatura_act.' asignatura_sig:'.$asignatura_sig.'prom_clase_act: '.$prom_clase_act.'    prom_clase_sig: '.$prom_clase_sig;
				
									$suma_peso=bcadd($suma_peso, $peso_act, 10);
									$prom_peso_clase_act=bcmul($prom_clase_act, $peso_act, 10);
									$suma_prom_peso_clase=bcadd($suma_prom_peso_clase, $prom_peso_clase_act, 10);//print ' <br>suma_prom_clase2:'.$suma_prom_peso_clase;
									
									$cant_clase=$cant_clase+1;
									$suma_prom_clase=bcadd($suma_prom_clase, $prom_clase_act, 10);//print ' <br>suma_prom_clase: '.$suma_prom_clase.' prom_clase_act: '.$prom_clase_act; 
								}
								
							}
							//print ' <br>suma_prom_clase: '.$suma_prom_clase.' cant_clase: '.$cant_clase;
							if($suma_peso==100)
							$prom_asig=number_format(round(bcdiv($suma_prom_peso_clase, 100, 10), 2), 2, ".", "");				
							elseif($suma_prom_clase!=0 && $cant_clase!=0 && $suma_peso!=100)
							$prom_asig=number_format(round(bcdiv($suma_prom_clase, $cant_clase, 10), 2), 2, ".", "");
						//}//FIN DEL IF K PREGUNTA SI ES CUALITATIVO EL PROMEDIO
						//else
						//$prom_asig=$prom_clase_pri;
						
						if($cualit[$f][0]==0)
						$prom_asig=$clases_acad->nota_cualitativa($db, $prom_asig);
						
						if($prom_asig<$nota_aprobado)$color_text='red';else $color_text='000';
					?>
						
						<td style='color:<?php print $color_text;?>;background-color:<?php print $background[array_search($c, $pos_libreta)];?>;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:center;border:1px solid;border-color:#000;'>
							<?php
								print $prom_asig;
								if(!ctype_alpha($prom_asig))$promedio_asignaturas[$f][array_search($c, $pos_libreta)]=$prom_asig;//print $f.' - '.$c;
							?>
						</td>
					
					<?php 
					}
					?>
				</tr>		
				<?php
			}

			if($asig[$f][0]==$asig_sig && $asig_sig!='')//ESTA PARTE AGREGA LAS CLASES CUANDO HAY VARIAS DENTRO UNA MISMA ASIGNATURA
			{
				
			
				?>
				<tr style='background-color:#fff;width:100%;'>
					<td style='FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:left;border:1px solid;'>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img alt='Clase dentro de la asignatura' src="<?php print $x;?>img/general/flecha_left_down.png" width="10"><?php print '&nbsp;'.$datos[$f][0];?>
					</td>
					<?php 
						for($c=1;$c<=count($actividad);$c++)
						{
							$background[array_search($c, $pos_libreta)]='#fff';if(isset($tipo[$c])){if($tipo[array_search($c, $pos_libreta)]=='p' OR $tipo[array_search($c, $pos_libreta)]=='l')$background[array_search($c, $pos_libreta)]='#aaa';}
							if($datos[$f][array_search($c, $pos_libreta)]<$nota_aprobado)$color_text='red';else $color_text='000';
						?>
						<td style='color:<?php print $color_text;?>;background-color:<?php print $background[array_search($c, $pos_libreta)];?>;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:center;border:1px solid;border-color:#000;'>
							<?php print $datos[$f][array_search($c, $pos_libreta)];?>
						</td>
					<?php 
						}
					?>
				</tr>		
				<?php
			}
			
			$asig_ant=$asig[$f][0];
		}
	}

	for($c=1;$c<=count($actividad);$c++)//UN FOR POR LOS PERIODOS
	{
		$background[array_search($c, $pos_libreta)]='#fff';if(isset($tipo[$c])){if($tipo[array_search($c, $pos_libreta)]=='p' OR $tipo[array_search($c, $pos_libreta)]=='l')$background[array_search($c, $pos_libreta)]='#aaa';}
		
		if($tipo[array_search($c, $pos_libreta)]=='s' OR $tipo[array_search($c, $pos_libreta)]=='p' OR $tipo[array_search($c, $pos_libreta)]=='l')
		{
			$cant_prom_fila=0;
			
			for($f=0;$f<count($datos);$f++)
			{
				if(isset($promedio_asignaturas[$f][array_search($c, $pos_libreta)]))
				{
					if($promedio_asignaturas[$f][array_search($c, $pos_libreta)]!='')
					{
						$prom_fila[$f]=$promedio_asignaturas[$f][array_search($c, $pos_libreta)];//print 'count:'.count($promedio_asignaturas);print ' - '.$f.' - '.$c.'<br>';
						$cant_prom_fila=$cant_prom_fila+1;
					}
					else
					$prom_fila[$f]='';
				}
			}
			if(isset($prom_fila))
			{
				//print '   array_sum: '.array_sum($prom_fila).'   cant_prom_fila: '.$cant_prom_fila;
				if(array_sum($prom_fila)!=0 && $cant_prom_fila!=0)
				$provechamiento[array_search($c, $pos_libreta)]=number_format(round(bcdiv(array_sum($prom_fila), $cant_prom_fila, 10), 2), 2, ".", "");
				else
				$provechamiento[array_search($c, $pos_libreta)]='';
			}
		}
	}
	?>							
		<tr style='background-color:#fff;width:100%;'>
			<td colspan='<?php print count($actividad)+1;?>' style='border:1px solid;'>
				&nbsp;
			</td>
		</tr>
		
		<tr style='width:100%;'>
			<td style='background-color:#ddd;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:left;border:1px solid;border-color:#000;'>
				<?php print 'RENDIMIENTO';?>
			</td>
			<?php 
				for($c=1;$c<=count($actividad);$c++)
				{
					$background[array_search($c, $pos_libreta)]='#ddd';if(isset($tipo[$c])){if($tipo[array_search($c, $pos_libreta)]=='p' OR $tipo[array_search($c, $pos_libreta)]=='l')$background[array_search($c, $pos_libreta)]='#aaa';}
					$color_text='000';if(isset($provechamiento[array_search($c, $pos_libreta)])){if($provechamiento[array_search($c, $pos_libreta)]<$nota_aprobado)$color_text='red';}
			?>
					
				<td style='color:<?php print $color_text;?>;background-color:<?php print $background[array_search($c, $pos_libreta)];?>;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:center;border:1px solid;border-color:#000;'>
					<?php if(isset($provechamiento[array_search($c, $pos_libreta)]))print $provechamiento[array_search($c, $pos_libreta)];else print '-';?>
				</td>
			<?php
				}
			?>
		</tr>
		
	<?php
	//-----------------------------------COMPORTAMIENTO---------------------------------------------
	$varios_arreglos=$clases_acad->consulta_comportamental_libreta($db, $id_estudiante);		
	$nota_cualit=$varios_arreglos[0]['nota_cualit'];
	$color_text=$varios_arreglos[0]['color_text'];
	?>
		
		<tr style='width:100%;'>
			<td style='background-color:#ddd;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:left;border:1px solid;border-color:#000;'>
				<?php print 'COMPORTAMIENTO';?>
			</td>
			<?php 
				for($c=1;$c<=count($actividad);$c++)
				{
					$background[array_search($c, $pos_libreta)]='#ddd';if(isset($tipo[$c])){if($tipo[array_search($c, $pos_libreta)]=='p' OR $tipo[array_search($c, $pos_libreta)]=='l')$background[array_search($c, $pos_libreta)]='#aaa';}
					$color_text_aux='#000';if(isset($color_text[array_search($c, $pos_libreta)]))$color_text_aux=$color_text[array_search($c, $pos_libreta)];
			?>
				<td style='color:<?php print $color_text_aux;?>;background-color:<?php print $background[array_search($c, $pos_libreta)];?>;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:center;border:1px solid;border-color:#000;'>
					<?php if(isset($nota_cualit[array_search($c, $pos_libreta)]))print $nota_cualit[array_search($c, $pos_libreta)];else print '-';?>
				</td>
			<?php }?>
		</tr>
		
		<tr style='background-color:#fff;width:100%;'>
			<td colspan='<?php print count($actividad)+1;?>' style='border:1px solid;'>
				&nbsp;
			</td>
		</tr>
	<?php
	//-----------------------------------COMPORTAMIENTO---------------------------------------------

	//--------------------------------------ASISTENCIA----------------------------------------------
	$varios_arreglos=$clases_acad->consulta_asistencia_libreta($db, $id_estudiante);		
	$inasistencias=$varios_arreglos[0]['inasistencias'];

	for($f=0;$f<count($inasistencias);$f++)
	{
	?>
		
		<tr style='background-color:#fff;width:100%;'>
			<td style='background-color:#ddd;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:left;border:1px solid;border-color:#000;'>
				<?php print $inasistencias[$f][0];?>
			</td>
			<?php 
				for($c=1;$c<=count($actividad);$c++)
				{
					$background[array_search($c, $pos_libreta)]='#ddd';if(isset($tipo[$c])){if($tipo[array_search($c, $pos_libreta)]=='p' OR $tipo[array_search($c, $pos_libreta)]=='l')$background[array_search($c, $pos_libreta)]='#aaa';}
					$color_text='000';if($f==0){if(isset($inasistencias[$f][array_search($c, $pos_libreta)])){if($inasistencias[$f][array_search($c, $pos_libreta)]!=0)$color_text='red';}}
			?>
				<td style='color:<?php print $color_text;?>;background-color:<?php print $background[array_search($c, $pos_libreta)];?>;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:center;border:1px solid;border-color:#000;'>
					<?php if(isset($inasistencias[$f][array_search($c, $pos_libreta)]))print $inasistencias[$f][array_search($c, $pos_libreta)];else print '-';?>
				</td>
			<?php }?>
		</tr>
	<?php
	}
	//--------------------------------------ASISTENCIA----------------------------------------------
	?>
	</table>

	<br>
	<?php
		//print count($array_periodos);
		if(count($array_periodos)==1)
		{
			$sql_i="SELECT recomendaciones
			FROM recomendaciones_mejoras_per_tut, curso_grado_paralelo_est, grado_paralelo_periodo, n_periodo_academico
			WHERE 1
			AND recomendaciones_mejoras_per_tut.id_curso_grado_paralelo_est=curso_grado_paralelo_est.id_curso_grado_paralelo_est
			AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
			AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico
			AND activo='1'
			AND recomendaciones_mejoras_per_tut.id_periodo_evaluativo='".$array_periodos[0]."'
			AND curso_grado_paralelo_est.id_estudiante='".$id_estudiante."'";//print $sql_i.'<br>';die();
			$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
		}
		else
		{
			$sql_i="SELECT recomendaciones
			FROM recomendaciones_mejoras_lec_tut, curso_grado_paralelo_est, grado_paralelo_periodo, n_periodo_academico
			WHERE 1
			AND recomendaciones_mejoras_lec_tut.id_curso_grado_paralelo_est=curso_grado_paralelo_est.id_curso_grado_paralelo_est
			AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
			AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico
			AND activo='1'
			AND curso_grado_paralelo_est.id_estudiante='".$id_estudiante."'";//print $sql_i.'<br>';die();
			$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
		}
	?>

	<table style='border:1px solid;width:100%;border-spacing:0px;border-collapse:collapse;'>	
		<tr style='background-color:#fff;width:100%;height:70;'>	
			<td style='width:80%;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:left;border:0px;vertical-align:text-top;'>
				Observaciones:<?php print $rs_i->fields['recomendaciones'];?>
			</td>

			<td style='font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 180x;text-align:center;border:0px ;'>
				
			</td>				
		</tr>
		
		<tr style='background-color:#fff;width:100%;height:30;'>	
			<td style='width:80%;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 14px;text-align:center;border:0px ;'>
				&nbsp;
			</td>

			<td style='font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:center;border-top:1px solid;border-color:#000;'>
				Tutor
			</td>				
		</tr>
	</table>

	<?php
	$sql_c="SELECT * FROM n_conf_conductual, n_equivalencias_conductuales WHERE 1
	AND n_conf_conductual.id_conf_conductual=n_equivalencias_conductuales.id_conf_conductual AND activa='1' ORDER BY a_partir DESC";//print $sql_s_n.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
	$rs_c=$db->Execute($sql_c) or die($db->ErrorMsg());

	$sql_a="SELECT * FROM n_conf_academica, c_equivalencias_academicas_cualitativas WHERE 1
	AND n_conf_academica.id_conf_academica=c_equivalencias_academicas_cualitativas.id_conf_academica AND activa='1' ORDER BY a_partir DESC";//print $sql_s_n.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
	$rs_a=$db->Execute($sql_a) or die($db->ErrorMsg());
	?>

	<br>

	<table style='border:0px;width:100%;border-spacing:0px;border-collapse:collapse;'>
		<tr style='height:10px;background-color:#fff;width:100%;'>	
			<td style='width:30%;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 12px;text-align:left;border:0px;padding-left:2%'>
				COMPORTAMIENTOArt. 222
			</td>

			<td style='FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 12px;text-align:left;border:0px ;'>
				ASIGNATURAS CUALITATIVAS
			</td>

		</tr>
	<?php
	for($c=0;$c<$rs_c->RecordCount();$c++)
	{
		$nota_cualitativa_c=$rs_c->fields['nota_cualitativa'];
		$observacion_c=$rs_c->fields['observacion'];
		
		$nota_cualitativa_a=$rs_a->fields['nota_cualitativa'];
		$observacion_a=$rs_a->fields['observacion'];
		
		if($nota_cualitativa_c!='' OR $nota_cualitativa_a!='')
		{
	?>	
		<tr  style='background-color:#fff;width:100%;height:10px;'>	
			<td style='width:30%;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:left;border:0px;padding-left:2%'>
				<?php if($nota_cualitativa_c!='')print $nota_cualitativa_c.': '.$observacion_c;?>
			</td>

			<td style='FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:left;border:0px ;'>
				<?php if($nota_cualitativa_a!='')print $nota_cualitativa_a.': '.$observacion_a;?>
			</td>
		</tr>
	<?php
		}
	$rs_c->MoveNext();$rs_a->MoveNext();
	}
	?>
	</table>

	<br>
<?php
}
?>
</body>
</html>	
<?php
$dompdf->loadHtml(ob_get_clean());
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream('Libreta de '.$datos_est['estudiante'].' - '.$rs_periodo->fields['nombre']);
?>