<?php
$x='../../../../';
include($x."config/variables.php");
include($x."config/clases.inc.php");

$id_estudiante=88;

include("../../clases_acad.php");
if(!isset($clases_acad))$clases_acad = new clases_acad();// (NO TOCAR)
ob_start();
?>	
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $titulo_sitio;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $x.$tema_sitio;?>"/> 

<?php
$sql_periodo="SELECT nombre FROM n_periodo_academico WHERE 1 AND activo='1'";
$rs_periodo=$db->Execute($sql_periodo) or die($db->ErrorMsg());

$datos_est=$clases_acad->datos_estudiante($db, $id_estudiante);
?>




</head>
<body>

<br>

<table  cellspacing='0' style='border:2px solid;'width='100%'>	
	<tr width='100%' height='50' style='background-color:#ddd;'>	
		<td style='width:33%;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 14px;text-align:center;border:0px ;'>
			<img src="<?php print $x.$logo;?>" width="45px"><?php echo $nombre_sucursal;?>
		</td>

		<td style='width:33%;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 18px;text-align:center;border:0px ;'>
			Reporte de rendimiento y comportamiento
		</td>
		
		<td style='font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 14px;text-align:center;border:0px ;'>
			Per&iacute;odo acad&eacute;mico <?php print $rs_periodo->fields['nombre'];?>
		</td>		
	</tr>
</table>

<br>

<table  cellspacing='0' style='border:2px solid;'width='100%'>
	<tr width='100%' height='30' style='background-color:#ddd;'>	
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
<table  cellspacing='0' style='border:1px solid;'width='100%'>
	

<?php
$varios_arreglos=$clases_acad->consulta_est_calificaciones_libreta($db, $id_estudiante);
		
$datos=$varios_arreglos[0]['datos'];
$column=$varios_arreglos[0]['column'];
$abv=$varios_arreglos[0]['abv'];
$actividad=$varios_arreglos[0]['actividad'];
$tipo=$varios_arreglos[0]['tipo'];
$asig=$varios_arreglos[0]['asig'];
$peso=$varios_arreglos[0]['peso'];
$cualit=$varios_arreglos[0]['cualit'];
$width=300+count($actividad)*50;//print 'ddd';

$abv[0]='ASIGNATURAS';
$asig_ant='';$asig_sig='';
?>

<tr width='100%'>
	<?php for($c=0;$c<=count($actividad);$c++){?>
		<td style='background-color:#ddd;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:center;border:1px solid;'<?php if($c!=0){?>width='4.6875%'<?php }else{?>width='25%'<?php }?>>
			<?php print $abv[$c];?>
		</td>
	<?php }?>
</tr>	


<?php
$fila=0;

for($f=0;$f<count($datos);$f++)
{
	if($asig[$f][0]!=$asig_ant)//AKI SE AGREGA LA ASIGNATURA Y SE CALCULA SU PROMEDIO
	{
		if(isset($asig[$f+1][0]))$asig_sig=$asig[$f+1][0];else $asig_sig='';
		
		?>
		<tr width='100%'>
			<td style='font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:left;border:1px solid;'>
				<?php print $asig[$f][0];?>
			</td>
			<?php 
			for($c=1;$c<=count($actividad);$c++)//UN FOR POR LOS PERIODOS
			{
				$cant_clase=0;$suma_prom_peso_clase=0;$suma_prom_clase=0;$prom_asig='';$asignatura_sig='';$suma_peso=0;
		
				$asignatura_pri=$asig[$f][0];
				$peso_pri=$peso[$f][0];
				$prom_clase_pri=$datos[$f][$c];
				
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
							$prom_clase_act=$datos[$n][$c];
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
			?>
				
				<td style='font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:center;border:1px solid;'>
					<?php
						print $prom_asig;
						if(!ctype_alpha($prom_asig))$promedio_asignaturas[$f][$c]=$prom_asig;//print $f.' - '.$c;
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
		<tr width='100%' style='background-color:#fff;'>
			<td style='FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:left;border:1px solid;'>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php print $x;?>img/general/flecha_left_down.png" width="10px"><?php print '&nbsp;'.$datos[$f][0];?>
			</td>
			<?php for($c=1;$c<=count($actividad);$c++){?>
				<td style='FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:center;border:1px solid;'>
					<?php print $datos[$f][$c];?>
				</td>
			<?php }?>
		</tr>		
		<?php
	}
	
	$asig_ant=$asig[$f][0];
	
}

for($c=1;$c<=count($actividad);$c++)//UN FOR POR LOS PERIODOS
{
	if($tipo[$c]=='s' OR $tipo[$c]=='p' OR $tipo[$c]=='l')
	{
		$cant_prom_fila=0;
		
		for($f=0;$f<count($datos);$f++)
		{
			if(isset($promedio_asignaturas[$f][$c]))
			{
				if($promedio_asignaturas[$f][$c]!='')
				{
					$prom_fila[$f]=$promedio_asignaturas[$f][$c];//print 'count:'.count($promedio_asignaturas);print ' - '.$f.' - '.$c.'<br>';
					$cant_prom_fila=$cant_prom_fila+1;
				}
				else
				$prom_fila[$f]='';
			}
		}
		//print '   array_sum: '.array_sum($prom_fila).'   cant_prom_fila: '.$cant_prom_fila;
		if(array_sum($prom_fila)!=0 && $cant_prom_fila!=0)
		$provechamiento[$c]=number_format(round(bcdiv(array_sum($prom_fila), $cant_prom_fila, 10), 2), 2, ".", "");
		else
		$provechamiento[$c]='';
	}
}
?>							
	<tr width='100%' style='background-color:#fff;'>
		<td colspan='<?php print count($actividad)+1;?>'style='border:1px solid;'>
			&nbsp;
		</td>
	</tr>
	
	<tr width='100%' style='background-color:#fff;'>
		<td style='background-color:#ddd;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:left;border:1px solid;'>
			<?php print 'RENDIMIENTO';?>
		</td>
		<?php for($c=1;$c<=count($actividad);$c++){?>
			<td style='background-color:#ddd;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:center;border:1px solid;'>
				<?php if(isset($provechamiento[$c]))print $provechamiento[$c];else print '-';?>
			</td>
		<?php }?>
	</tr>
	
<?php
//-----------------------------------COMPORTAMIENTO---------------------------------------------
$varios_arreglos=$clases_acad->consulta_comportamental_libreta($db, $id_estudiante);		
$nota_cualit=$varios_arreglos[0]['nota_cualit'];
?>
	
	<tr width='100%' style='background-color:#fff;'>
		<td style='background-color:#ddd;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:left;border:1px solid;'>
			<?php print 'COMPORTAMIENTO';?>
		</td>
		<?php for($c=1;$c<=count($actividad);$c++){?>
			<td style='background-color:#ddd;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:center;border:1px solid;'>
				<?php if(isset($nota_cualit[$c]))print $nota_cualit[$c];else print '-';?>
			</td>
		<?php }?>
	</tr>
	
	<tr width='100%' style='background-color:#fff;'>
		<td colspan='<?php print count($actividad)+1;?>'style='border:1px solid;'>
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
	
	<tr width='100%' style='background-color:#fff;'>
		<td style='background-color:#ddd;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:left;border:1px solid;'>
			<?php print $inasistencias[$f][0];?>
		</td>
		<?php for($c=1;$c<=count($actividad);$c++){?>
			<td style='background-color:#ddd;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:center;border:1px solid;'>
				<?php if(isset($inasistencias[$f][$c]))print $inasistencias[$f][$c];else print '-';?>
			</td>
		<?php }?>
	</tr>
<?php
}
//--------------------------------------ASISTENCIA----------------------------------------------
?>
</table>

<br>

<table  cellspacing='0' style='border:2px solid;'width='100%'>	
	<tr width='100%' height='50' style='background-color:#fff;'>	
		<td style='width:80%;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 14px;text-align:left;border:0px ;'>
			Observaciones:
		</td>

		<td style='font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 180x;text-align:center;border:0px ;'>
			&nbsp;
		</td>				
	</tr>
	
	<tr width='100%' height='30' style='background-color:#fff;'>	
		<td style='width:80%;font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 14px;text-align:center;border:0px ;'>
			&nbsp;
		</td>

		<td style='font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:center;border-top:1px solid;'>
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

<table  cellspacing='0' style='border:0;'width='100%'>
	<tr width='100%' height='10' style='background-color:#fff;'>	
		<td style='width:33%;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 12px;text-align:left;border:0px;padding-left:2%'>
			COMPORTAMIENTOArt. 222
		</td>

		<td style='FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 12px;text-align:left;border:0px ;'>
			ASIGNATURAS CUALITATIVAS
		</td>

		<td style='font-weight:bold;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 12px;text-align:left;border:0px ;'>
			&nbsp;
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
	<tr width='100%' height='10' style='background-color:#fff;'>	
		<td style='width:33%;FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:left;border:0px;padding-left:2%'>
			<?php if($nota_cualitativa_c!='')print $nota_cualitativa_c.': '.$observacion_c;?>
		</td>

		<td style='FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:left;border:0px ;'>
			<?php if($nota_cualitativa_a!='')print $nota_cualitativa_a.': '.$observacion_a;?>
		</td>

		<td style='FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;text-align:center;border:0px ;'>
			&nbsp;
		</td>
	</tr>
<?php
	}
$rs_c->MoveNext();$rs_a->MoveNext();
}
?>
</table>

<br>

</body>
</html>	
<?php
die();
require_once("../../../../include/dompdf/vendor/autoload.php");
require_once("../../../../include/dompdf/autoload.inc.php");

use Dompdf\Dompdf;
$dompdf = new Dompdf();
//$dompdf->Set_Option('isHtml5ParserEnabled', true);
$dompdf->loadHtml(ob_get_clean());
ini_set("memory_limit","32M");  
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();
						
		
			
			
		//	