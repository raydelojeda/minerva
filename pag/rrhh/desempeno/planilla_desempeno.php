<?php
include("planilla_variables.php");

include($x."adodb519/adodb-pager.inc.php"); //paginationprint "yes";
include($x."config/variables.php");
include($x."config/clases.inc.php");

$obj = new clases(); // (NO TOCAR)
$rs_sesion=$obj->Validar_sesion($db,$x); // (NO TOCAR)
$obj->Validar_permiso($rs_sesion,$elemento,"Imprimir"); // (NO TOCAR)

if(!isset($tabla_anidada2))$tabla_anidada2='';if(!isset($campo_anidado2))$campo_anidado2='';if(!isset($where))$where='';

require_once("../../../include/dompdf/vendor/autoload.php");
require_once("../../../include/dompdf/autoload.inc.php");

use Dompdf\Dompdf;
$dompdf = new Dompdf();

$obj = new clases(); // (NO TOCAR)
$rs_sesion=$obj->Validar_sesion($db,$x); // (NO TOCAR)
$obj->Validar_permiso($rs_sesion,$elemento,"Imprimir"); // (NO TOCAR)

if(!isset($tabla_anidada2))$tabla_anidada2='';if(!isset($campo_anidado2))$campo_anidado2='';if(!isset($where))$where='';

$var = explode(",",$_POST['var_aux']);//print $_POST['var_aux'];die();
ob_start();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $titulo_sitio;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $x.$tema_sitio_imprimir;?>"/>
</head>
<body>
<?php
if(count($var) != 0)
{
	for ($i = 0; $i < count($var); next($var), $i++) 
	{				
		$id = current($var);

		$sql="SELECT id_periodo, id_empleado FROM desempeno WHERE 1 AND desempeno.id_desempeno='".$id."'";//print $sql; die();
		$rs=$db->Execute($sql) or die($db->ErrorMsg());
		$id_periodo=$rs->fields['id_periodo'];
		$id_empleado=$rs->fields['id_empleado'];

		$sql="SELECT id_desempeno as id_desempeno, persona.id_persona as id_p, concat(persona.identificacion,' - ',persona.primer_nombre,' ', persona.segundo_nombre,' ',persona.primer_apellido,' ',persona.segundo_apellido) as evaluado,
		n_cargo.id_cargo as id_c, desempeno.id_criterio as id_cri, cod_criterio as cod_criterio, criterio as criterio,
		desempeno.id_evaluacion as id_e, cod_evaluacion as cod_eval, evaluacion as eval, valor_e as valor_e, exp_eval as exp_eval, 
		desempeno.id_competencia as id_comp, competencia as comp,
		desempeno.id_compromiso as id_compromiso, compromiso as compromiso, desempeno.id_periodo as id_periodo, concat(fecha_ini,' - ',fecha_fin) as periodo, desempeno.fecha as fecha, desempeno.id_empleado_jefe as id_u,
		concat(per.identificacion,' - ',per.primer_nombre,' ',per.segundo_nombre,' ',per.primer_apellido,' ',per.segundo_apellido) as evaluador,
		resultado_cri as resultado
		FROM desempeno,empleado,n_cargo,n_criterio,n_evaluacion,n_competencia,n_periodo,compromiso,persona,empleado as emp,persona as per
		WHERE 1
		AND desempeno.id_empleado=empleado.id_empleado
		AND desempeno.id_criterio=n_criterio.id_criterio
		AND desempeno.id_evaluacion=n_evaluacion.id_evaluacion
		AND desempeno.id_competencia=n_competencia.id_competencia
		AND desempeno.id_periodo=n_periodo.id_periodo
		AND desempeno.id_compromiso=compromiso.id_compromiso
		AND desempeno.id_cargo=n_cargo.id_cargo
		AND empleado.id_persona=persona.id_persona
		AND desempeno.id_empleado_jefe=emp.id_empleado
		AND emp.id_persona=per.id_persona
		AND desempeno.id_periodo='".$id_periodo."'
		AND desempeno.id_empleado='".$id_empleado."' ORDER BY comp, cod_criterio";//print $sql;

		$rs=$db->Execute($sql) or die($db->ErrorMsg());
		$compromiso=$rs->fields['compromiso'];
		
		?>
		<?php if($i > 0){?><div style="page-break-before: always;"></div><?php }?>
		<table align="center" width='100%'>
			<tr>
				<td colspan="2"align="center">
					<img width='600px' border="0" src="<?php echo $x;?>img/rrhh/encabezado_iso.png">
					<hr>
				</td>
			</tr>
			<tr>
				<td align="right" width='20%'>
					Evaluador:
				</td>
				<td align="left" width='80%'>
					<?php print $rs->fields['evaluador'];?>
				</td>
			</tr>
			<tr>
				<td align="right">
					Evaluado:
				</td>
				<td align="left">
					<?php print $rs->fields['evaluado'];?>
				</td>
			</tr>
			<tr>
				<td align="right">
					Per&iacute;odo evaluado:
				</td>
				<td align="left">
					<?php print $rs->fields['periodo'];?>
				</td>
			</tr>
			<tr>
				<td align="right">
					Fecha de impresi&oacute;n:
				</td>
				<td align="left">
					<?php print date("d/m/Y");?>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="left">
				&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="2" align="justify">
				Estimado Evaluador el objetivo de este proceso es darle la oportunidad de conocer de cerca el trabajo de sus colaboradores teniendo en cuenta la forma como act&uacute;an en determinadas situaciones relacionadas directamente con su trabajo.
				</td>
			</tr>

			<?php $rs->MoveFirst();$total_c=0;$resultado=0;$resultado_comp;$t=0;$total=0;
			for($comp=0;$comp<$rs->RecordCount();$comp++)
			{
			?>
				<tr>
					<td colspan="2" align="left">
					&nbsp;<br>
					</td>
				</tr>

				<tr>
					<td colspan="2" align="left" height="30">
<hr>
						<table width="100%">
						<?php
						$criterio=$rs->fields['cod_criterio']." - ".$rs->fields['criterio'];
						$evaluacion=$rs->fields['cod_eval']." - ".$rs->fields['eval'].": ".$rs->fields['valor_e']."%";
						//$ponderacion="<div class='bola'>".$rs->fields['cod_pond']."</div> - ".$rs->fields['pond'].": ".$rs->fields['valor_p']."%";
						$resultado=$rs->fields['resultado'];

						if($competencia!=$rs->fields['comp'])
						{

							$c=0;
							$competencia=$rs->fields['comp'];
						?>
							<tr>
								<td align="left" height="30" width="100%" colspan="2">
									<b><?php print $competencia;?></b>
								</td>
							</tr>
						<?php
						}
						$total_c=bcadd($total_c,$resultado,14);
						$c=$c+1;
						if($c!=0)$resultado_comp=bcdiv($total_c, $c, 14);
						?>
							<hr>

							<tr>
								<td align="left" height="20" colspan="2">
									<?php print $criterio;?>
								</td>
							</tr>

							<tr>
								<td align="left" width="50%">
									<?php print $evaluacion;?>
								</td>
								<td align="left">
									<?php //print $ponderacion;?>
								</td>
							</tr>
							
							<?php $rs->MoveNext();if($competencia!=$rs->fields['comp']){$total_c=0;$c=0;$t=$t+1;$total=bcadd($total,$resultado_comp,14);?>
							<tr>
								<td colspan="2" align="left">
									<br><b>Resultado de la competencia: <?php print round($resultado_comp,2)." %";?></b>
								</td>
							</tr>
							<?php }?>
						</table>
					</td>
				</tr>
			<?php //$rs->MoveNext();
			}
		$resultado=bcdiv($total,$t,14);
		?>

		<?php
		/*
				<tr>
					<td colspan="2">
						<hr>
						<b>&nbsp;Compromiso:&nbsp;</b><?php print $compromiso;?>&nbsp;
					</td>
				</tr>
		*/
		?>

		<?php
		$cualitativo=$obj->Convertir_cualitativo($resultado,"des"); 
		?>
				<tr>
					<td colspan="2" align="left">
						<hr>
						<div <?php if($resultado>=80){?> style='color:green;font-size:16px;font-weight:bold;' <?php }else{?> style='color:red;font-size:16px;font-weight:bold;' <?php }?>>Total: <?php print round($resultado,2)." %"." - ".$cualitativo;?></div>
					</td>
				</tr>

				<tr>
					<td colspan="2" align="center">
						<br>
						<b>Evaluado:&nbsp;</b>___________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<b>Evaluador:&nbsp;</b>___________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
				</tr>
		</table>
		<div>
		<br>

		<!--Incertar Contenido Aqui-->
		<!--Incertar Contenido Aqui-->
		<!--Incertar Contenido Aqui-->
		<?php
		
		// die();
		$rs->MoveFirst();
		
	}
} 
include($x."plantillas/imp_footer.php");
$dompdf->loadHtml(ob_get_clean());
ini_set("memory_limit","4020M");
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('Evaluacion de '.$rs->fields['evaluado'].' - '.$rs->fields['periodo']);
		
?>