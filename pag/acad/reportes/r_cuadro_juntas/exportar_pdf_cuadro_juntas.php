<?php
$x='../../../../';
include_once($x."config/variables.php");
include_once($x."config/clases.inc.php");
include_once($x."include/PHPExcel_1.8.0_doc/Classes/PHPExcel.php");
include_once($x."include/PHPExcel_1.8.0_doc/Classes/PHPExcel/Writer/Excel2007.php");
$clases = new clases();
$objPHPExcel = new PHPExcel();
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

$mis_clases = new mis_clases();// (NO TOCAR)
include("../../clases_acad.php");
$clases_acad = new clases_acad();// (NO TOCAR)

for($g=0;$g<10;$g++)
{
	if(isset($_GET['val'.$g]))
	$array_periodos[$g]=$_GET['val'.$g];
}

$varios_arreglos=$clases_acad->encabezado_filtrado($db, $array_periodos);
		
$id=$varios_arreglos[0]['id'];
$id_encab=$varios_arreglos[0]['id_encab'];
$tipo_id=$varios_arreglos[0]['tipo_id'];
$position_id=$varios_arreglos[0]['position_id'];
$pertenece=$varios_arreglos[0]['pertenece'];
$actividad=$varios_arreglos[0]['actividad'];
$abv=$varios_arreglos[0]['abv'];
$column=$varios_arreglos[0]['column'];
$tipo=$varios_arreglos[0]['tipo'];
$color_celda=$varios_arreglos[0]['color'];
$position=$varios_arreglos[0]['position'];

$id_class=array();
$id_clase_estudiante=array();

$i=0;

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

$datos_est=$clases_acad->datos_estudiante($db, $id_estudiante);

//--------------------------------------------------------------------------------------------------------

$title = $titulo_sitio."-Reporte calificaciones";
$file = $title.".xlsx";

$objPHPExcel->getProperties()->setCreator("Raydel Ojeda Figueroa");
$objPHPExcel->getProperties()->setTitle('Reporte de calificaciones');
$objPHPExcel->setActiveSheetIndex(0); //Elegimos la hoja 0
$encabezados_exp=array();
$datos_exp=array();
$e=0;
$col=0;
$fila=3;

$objPHPExcel->setActiveSheetIndex(0);
		
$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');//para el título
$objPHPExcel->getActiveSheet()->mergeCells('A2:F2');//para el título
$objPHPExcel->getActiveSheet()->mergeCells('A3:F3');//para el título

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,1,utf8_encode($clases->Reemplazar_a_tildes("Reporte de calificaciones ".date("d-m-Y"))));//para el título
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,utf8_encode($clases->Reemplazar_a_tildes('Curso: '.$datos_est['curso'].' '.$datos_est['paralelo'])));//para el título
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,3,utf8_encode($clases->Reemplazar_a_tildes('Período académico: '.$rs_periodo->fields['nombre'])));//para el título

$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);//para el título
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);//para el título
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);//para el título
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);//para el título

$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);//para el título
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);//para el título
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);//para el título

$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);//para el título
$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);//para el título
$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setSize(14);//para el título


$objPHPExcel->getDefaultStyle()->getFont()->setName('Verdana');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(8);

$styleArray = array(
	'font' => array(
		'bold' => true,
	),
	
	'borders' => array(
		'top' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
		),
	),
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
		'rotation' => 90,
		'startcolor' => array(
			'argb' => 'FFA0A0A0',
		),
		'endcolor' => array(
			'argb' => 'FFFFFFFF',
		),
	),
);

$objPHPExcel->getActiveSheet()->getStyle('B5')->getFont()->setSize(12);//para los estudiantes
$objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setSize(12);//para los estudiantes

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);//para los estudiantes
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(3);//para los estudiantes
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);//para los estudiantes

$objPHPExcel->getActiveSheet()->mergeCells('B5:B6');//para los estudiantes
$objPHPExcel->getActiveSheet()->mergeCells('C5:C6');//para los estudiantes

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,5,'#');//para los estudiantes
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,5,'Estudiantes');//para los estudiantes

$objPHPExcel->getActiveSheet()->getStyle('B5:B7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFF000');//para los estudiantes
$objPHPExcel->getActiveSheet()->getStyle('C5:C7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFF000');//para los estudiantes

$objPHPExcel->getActiveSheet()->mergeCells('D5:D6');//para el promedio general
$objPHPExcel->getActiveSheet()->getStyle('D5:D6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00000000');//para el promedio general
$objPHPExcel->getActiveSheet()->getStyle('D5:D6')->getFont()->getColor()->setARGB('FFFFFFFF');//para el promedio general
$objPHPExcel->getActiveSheet()->getStyle('D5:D6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);//para el promedio general
$objPHPExcel->getActiveSheet()->getStyle('D5:D6')->getAlignment()->setWrapText(true);//para el promedio general
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);//para el promedio general
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,5,'Promedio general');//para el promedio general

for($fila=0;$fila<count($id_estudiantes);$fila++)//para los estudiantes
{
	$comienzo=$fila+7;
	
	$id_estudiante=$id_estudiantes[$fila];//para los estudiantes
	$datos_est=$clases_acad->datos_estudiante($db, $id_estudiante);//para los estudiantes
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$comienzo,$fila+1);//para los estudiantes
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$comienzo,$clases->Reemplazar_a_tildes($datos_est['estudiante']));//para los estudiantes
	$objPHPExcel->getActiveSheet()->getRowDimension($comienzo)->setRowHeight(15);//para los estudiantes
	
	if($comienzo % 2)$color='FFF0A0A0';else $color='DDDDDDDD';//para los colores de las filas
	
	$literal=$clases->devolver_celda_excel_litela($comienzo,1);//print $literal;die();
	$objPHPExcel->getActiveSheet()->getStyle($literal)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);
	
	$literal=$clases->devolver_celda_excel_litela($comienzo,2);
	$objPHPExcel->getActiveSheet()->getStyle($literal)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);
	
	$literal=$clases->devolver_celda_excel_litela($comienzo,3);
	$objPHPExcel->getActiveSheet()->getStyle($literal)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);
	
	$prom_gen=$clases_acad->calcular_prom_general($db, $id_estudiante);//para el promedio general
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$comienzo,$prom_gen);//para el promedio general
	
	$objPHPExcel->getActiveSheet()->getStyle('D7:D100')->getNumberFormat()->setFormatCode('#,##0.00');//para el promedio general
	$objPHPExcel->getActiveSheet()->getStyle('D5:D100')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//para el promedio general
	
	$sql_cla="SELECT n_asignatura.cuantitativa, clase.id_clase as id_clase, clase_estudiante.id_clase_estudiante, clase.id_asignatura as id_asignatura, concat(abreviatura,' - ',asignatura) as asignatura, clase.peso, clase.nombre as nombre, referencia as referencia, 
	codigo as codigo, curso_grado_paralelo_est.id_curso_grado_paralelo_est
	FROM clase, n_periodo_academico, n_asignatura, clase_estudiante, curso_grado_paralelo_est, estudiante
	WHERE 1 
	AND clase.id_asignatura=n_asignatura.id_asignatura 
	AND clase.id_periodo_academico=n_periodo_academico.id_periodo_academico
	AND clase.id_clase=clase_estudiante.id_clase
	AND clase_estudiante.id_curso_grado_paralelo_est=curso_grado_paralelo_est.id_curso_grado_paralelo_est
	AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante	
	AND n_periodo_academico.activo='1'
	AND estudiante.id_estudiante='".$id_estudiante."'
	ORDER BY n_asignatura.cuantitativa, codigo_unico DESC";//print $sql_cla;
	$rs_cla=$db->Execute($sql_cla) or die($db->ErrorMsg());
	
	for($c=0;$c<$rs_cla->RecordCount();$c++)
	{
		//print $rs_cla->fields['id_clase'].' - '.$id_class;
		if(!in_array($rs_cla->fields['id_clase'], $id_class))
		{
			$class[$i]=$rs_cla->fields['nombre'].' ('.$rs_cla->fields['peso'].'%)';
			$id_class[$i]=$rs_cla->fields['id_clase'];
			$id_clase_estudiantes[$fila][$i]=$rs_cla->fields['id_clase_estudiante'];
			//print $fila.' - '.$i.'<br>';
			$i=$i+1;
			
		}
		else
		{
			$k=array_search($rs_cla->fields['id_clase'], $id_class);
			$id_clase_estudiantes[$fila][$k]=$rs_cla->fields['id_clase_estudiante'];
			//print $fila.' - '.$k.'<br>';
		}
		
	$rs_cla->MoveNext();
	}
}

//die();
if($rs_cla->RecordCount()>0)
{
	for($clas=0;$clas<count($class);$clas++)
	{
		$comienzo=$clas*count($actividad)+4;
		$termina=$comienzo+count($actividad)-1;
		
		$literal_1=$clases->devolver_celda_excel_litela(5,$comienzo);//print $literal_1.'-';//die();
		$literal_2=$clases->devolver_celda_excel_litela(5,$termina);//print $literal_2.'<br>';
		
		$bg=rand(000, 999);$bg1=rand(00, 99);//print $bg.'<br>';
		
		$objPHPExcel->getActiveSheet()->mergeCells($literal_1.':'.$literal_2);//combinar celdas de la clase
		$objPHPExcel->getActiveSheet()->getStyle($literal_1.':'.$literal_2)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFD'.$bg1.$bg);//para la clase
		$objPHPExcel->getActiveSheet()->getStyle($literal_1.':'.$literal_2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);//para la clase
		$objPHPExcel->getActiveSheet()->getStyle($literal_1.':'.$literal_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//para la clase
		
		if(array_key_exists ($clas,$class))$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($comienzo,5,$class[$clas]);//para la clase
		$id_clase=$id_class[$clas];
		
		//print $comienzo.'<br>';
		for($enc=1;$enc<=count($actividad);$enc++)
		{
			//print $comienzo.'<br>';
			$col=$comienzo+$enc-1;
			$color_excel=substr($color_celda[$enc],1,6).'00';//para el encabezado
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,6,utf8_encode($clases->Reemplazar_a_tildes($abv[$enc])));//para el encabezado
			
			$literal=$clases->devolver_celda_excel_litela(6,$col);
			$objPHPExcel->getActiveSheet()->getStyle($literal)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);//para el encabezado
			$objPHPExcel->getActiveSheet()->getStyle($literal)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//para el encabezado
			$objPHPExcel->getActiveSheet()->getStyle($literal)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color_excel);//para el encabezado
		}	
			
		for($fila=0;$fila<count($id_estudiantes);$fila++)//para los estudiantes
		{
			//print 'fila: '.$fila.' - '.$clas.'<br>';
			$id_clase_estudiante=$id_clase_estudiantes[$fila][$clas];
			
			$arreglos=$mis_clases->calcula_promedios($db, $clases_acad, $id_clase_estudiante, $fila, $varios_arreglos);
			$datos=$arreglos[0]['datos'];
			//print $datos;
			//for($d=0;$d<count($datos);$d++){print $datos[$d];}
			for($d=1;$d<=count($datos[$fila]);$d++)
			{
				$comienzo=bcadd(bcmul($clas,count($actividad)),4);//print $d.'<br>';
				$m=bcadd($comienzo,$d)-1;
				$n=bcadd($fila,7);
				//print $m.' - '.$n.'<br>';
				
				if($n % 2)$color='FFF0A0A0';else $color='DDDDDDDD';
				$literal=$clases->devolver_celda_excel_litela($n,$m);//print $literal;die();
				$objPHPExcel->getActiveSheet()->getStyle($literal)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);
				$objPHPExcel->getActiveSheet()->getStyle($literal)->getNumberFormat()->setFormatCode('#,##0.00');//para el promedio general
				$objPHPExcel->getActiveSheet()->getStyle($literal)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//para el promedio general
				if($datos[$fila][$d]<$nota_aprobado)
				//$objPHPExcel->getActiveSheet()->getStyle($literal)->getFill()->getStartColor()->setARGB('FFFF0000');
				$objPHPExcel->getActiveSheet()->getStyle($literal)->getFont()->getColor()->setARGB('FFFF0000');
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($m,$n,$datos[$fila][$d]);
			}
		}
		
	}
	
	/*
	//die();
	$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
	*/
	
}

if(file_exists($file)) 
{
	$objPHPExcel->getSecurity()->setLockWindows(false);
	$objPHPExcel->getSecurity()->setLockStructure(false);
	
	$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
	$objPHPExcel->getActiveSheet()->getStyle()->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
	
	$objWriter->setOffice2003Compatibility(true);
	$objWriter->save($file);
	/*header('Content-Disposition: attachment; filename='.$file );
	header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Length: ' . filesize($file));
	header('Content-Transfer-Encoding: binary');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	ob_clean();
	flush(); 
	readfile($file);*/
	
	//$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Reporte de calificaciones.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');
	


	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;	
}



class mis_clases
{
	function calcula_promedios($db, $clases_acad, $id_clase_estudiante, $fila, $varios_arreglos)
	{
		$id=$varios_arreglos[0]['id'];
		$id_encab=$varios_arreglos[0]['id_encab'];
		$tipo_id=$varios_arreglos[0]['tipo_id'];
		$position_id=$varios_arreglos[0]['position_id'];
		$pertenece=$varios_arreglos[0]['pertenece'];
		$actividad=$varios_arreglos[0]['actividad'];
		$abv=$varios_arreglos[0]['abv'];
		$column=$varios_arreglos[0]['column'];
		$tipo=$varios_arreglos[0]['tipo'];
		$position=$varios_arreglos[0]['position'];

		for($h=1;$h<=count($position);$h++)
		{//print $tipo[$position[$h]].'<br>';
			if($tipo[$position[$h]]=='s')
			{
				$promedio_s=$clases_acad->calcular_prom_subperiodo($db, $id_clase_estudiante, $id_encab[$position[$h]], '');
				$nota=$promedio_s['promedio'];
				$datos[$fila][$position[$h]]=$nota;		//print $fila.' - '.$position[$h].'<br>';	
			}
			
			elseif($tipo[$position[$h]]=='p')
			{
				$promedio_p=$clases_acad->calcular_prom_periodo($db, $id_clase_estudiante, $id_encab[$position[$h]]);//print 'examen_periodo: '.$examen_periodo.'<br>';
				$nota=$promedio_p;
				$datos[$fila][$position[$h]]=$nota;
			}
			
			elseif($tipo[$position[$h]]=='l')
			{
				$promedio_l=$clases_acad->calcular_prom_lectivo($db, $id_clase_estudiante, $id_encab[$position[$h]]);//print 'examen_periodo: '.$examen_periodo.'<br>';
				$nota=$promedio_l['promedio'];
				$datos[$fila][$position[$h]]=$nota;
			}
			
			elseif($tipo[$position[$h]]=='p_exa')
			{
				for($a=1;$a<=count($position_id);$a++)
				{					
					if($tipo_id[$position_id[$a]]=='p_exa' AND $id_encab[$position[$h]]==$pertenece[$position_id[$a]])//substr($sel_filtro_cal, 2, strlen($sel_filtro_cal));
					{
						$examen_periodo=$clases_acad->consulta_nota_examen_periodo($db, $id_clase_estudiante, $id[$position_id[$a]]);
						$nota=$examen_periodo['nota'];
						$datos[$fila][$position[$h]]=$nota;
						if($examen_periodo['nota']!='')break;
					}
				}
			}

			elseif($tipo[$position[$h]]=='p_adic')
			{
				for($a=1;$a<=count($position_id);$a++)
				{
					if($tipo_id[$position_id[$a]]=='p_adic' AND $id_encab[$position[$h]]==$pertenece[$position_id[$a]])
					{
						$examen_periodo_adic=$clases_acad->consulta_nota_examen_periodo_adicional($db, $id_clase_estudiante, $id[$position_id[$a]]);
						$nota=$examen_periodo_adic['nota'];
						$datos[$fila][$position[$h]]=$nota;
						if($examen_periodo_adic['nota']!='')break;
					}
				}
			}
			
			elseif($tipo[$position[$h]]=='l_exa')
			{
				for($a=1;$a<=count($position_id);$a++)
				{
					if($tipo_id[$position_id[$a]]=='l_exa' AND $id_encab[$position[$h]]==$pertenece[$position_id[$a]])
					{
						$examen_lectivo=$clases_acad->consulta_nota_examen_lectivo($db, $id_clase_estudiante, $id[$position_id[$a]]);
						$nota=$examen_lectivo['nota'];
						$datos[$fila][$position[$h]]=$nota;
						if($examen_lectivo['nota']!='')break;
					}
				}
			}
			
			elseif($tipo[$position[$h]]=='l_adic')
			{
				for($a=1;$a<=count($position_id);$a++)
				{//if($tipo_id[$position_id[$a]]=='l_adic')print 'tipo_id: '.$tipo_id[$position_id[$a]].'&nbsp;&nbsp;&nbsp;&nbsp; id_encab: '.$id_encab[$position[$h]].' == pertenece: '.$pertenece[$position_id[$a]].'<br>';
					if($tipo_id[$position_id[$a]]=='l_adic' AND $id_encab[$position[$h]]==$pertenece[$position_id[$a]])
					{
						$examen_lectivo_adic=$clases_acad->consulta_nota_examen_lectivo_adicional($db, $id_clase_estudiante, $id[$position_id[$a]]);
						$nota=$examen_lectivo_adic['nota'];
						$datos[$fila][$position[$h]]=$nota;
						if($examen_lectivo_adic['nota']!='')break;
					}
				}
			}
		}
		
		$arreglos=array();
		$arreglos[0]=array('abv'=>$abv,'datos'=>$datos,'column'=>$column,'actividad'=>$actividad);//print count($data);

		return $arreglos;
	}
}

?>