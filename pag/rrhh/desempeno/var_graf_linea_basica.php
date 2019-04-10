<?php
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($_GET["var"]))//$_GET["var"] se envia en el onclick de boton de ayuda, si existe que no modifique la variable $x, asi puede incluir clases_var.inc.php (NO TOCAR)
if(!isset($x))$x="../../../";// (NO TOCAR)
include($x."adodb519/adodb-pager.inc.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");

// declaraciones
$cadenacheckboxp="";
$align='center';
$verticalAlign='bottom';
$layout='horizontal';
$unidad='%';
$datos='';
$y_categ='Porcentaje (%)';
// declaraciones

$elemento_titulo="de la evaluaci&oacute;n de desempe&ntilde;o de los subordinados de: ".$_SESSION['nombre']; // para el título
$elemento="desempeno"; // elemento o nomenclador al que se accede
$camino="pag/rrhh/".$elemento; // camino para acceder
$location=$x.$camino;

$obj = new clases(); // (NO TOCAR)
$rs_sesion=$obj->Validar_sesion($db,$x); // (NO TOCAR)
//print $rs_sesion;
$obj->Validar_permiso($rs_sesion,$elemento,"Visualizar"); // (NO TOCAR)
include_once($x."config/clases_var.inc.php");// (NO TOCAR)
if(!isset($obj_var))$obj_var = new clases_var();// (NO TOCAR)
$_SESSION["modulo"]="rrhh";


$img_encabezado="img/general/ico_grafico.png"; //imagen del encabezado
$titulo_listar="Evoluci&oacute;n ".$elemento_titulo.": gr&aacute;fico"; //titulo del encabezado

//--------------------------------------------------------------------------

$titulo_graf='Evaluaci\u00f3n de desempe\u00f1o';
$subtitulo_graf='Evoluci\u00f3n de las competencias o criterios en el tiempo';

$sql_x="SELECT id_periodo, concat(fecha_ini,'/',fecha_fin) AS periodo FROM n_periodo WHERE 1 ";

if(isset($_POST['sel_periodo_ini']) AND $_POST['sel_periodo_ini']!=0)
$sql_x=$sql_x." AND fecha_ini >= '".$_POST['sel_periodo_ini']."'";

if(isset($_POST['sel_periodo_fin']) AND $_POST['sel_periodo_fin']!=0)
$sql_x=$sql_x." AND fecha_fin <= '".$_POST['sel_periodo_fin']."'";

$sql_x=$sql_x." ORDER BY fecha_ini ASC";//print $sql_x;
$rs_x=$db->Execute($sql_x) or die($db->ErrorMsg());//print $rs_x;

$x_categ='';
for($eje_x=0;$eje_x<$rs_x->RecordCount();$eje_x++)
{
	if($x_categ=='')
	$x_categ="'".$rs_x->fields['periodo']."'";
	else
	$x_categ=$x_categ.",'".$rs_x->fields['periodo']."'";
$rs_x->MoveNext();
}//print $x_categ;


if(isset($_POST['sel_periodo_ini']))
{
	if($_POST['sel_periodo_ini']==0)
	{
		$_POST['sel_competencia']=0;
		$_POST['sel_criterio']=0;
	}
}

if(isset($_POST['sel_periodo_fin']))
{
	if($_POST['sel_periodo_fin']==0)
	{
		$_POST['sel_competencia']=0;
		$_POST['sel_criterio']=0;
	}
}

if(isset($_POST['sel_competencia']))
{
	if($_POST['sel_competencia']==0)
	{
		$_POST['sel_criterio']=0;
	}
}

if(isset($_POST['sel_competencia']) AND isset($_POST['sel_criterio']))
{
	$sql_comp_cri="SELECT n_criterio.id_criterio FROM desempeno,n_criterio,n_competencia,n_periodo
	WHERE 1 
	AND desempeno.id_criterio=n_criterio.id_criterio 
	AND desempeno.id_competencia=n_competencia.id_competencia 
	AND desempeno.id_periodo=n_periodo.id_periodo
	AND desempeno.id_competencia = '".$_POST['sel_competencia']."'
	AND desempeno.id_criterio = '".$_POST['sel_criterio']."'";
	$rs_comp_cri=$db->Execute($sql_comp_cri) or die($db->ErrorMsg());//print $sql_comp_cri;
}

if(isset($_POST['sel_periodo_ini']) AND isset($_POST['sel_periodo_fin']) AND isset($_POST['sel_competencia']) AND $_POST['sel_competencia']!='0')
{
	if(isset($_POST['sel_competencia']))
	{
		if($_POST['sel_competencia']=='all' OR $_POST['sel_competencia']=='all_s' OR $_POST['sel_competencia']=='0')
		{
			$campos_select="competencia as leyenda, concat(fecha_ini,'/',fecha_fin) AS periodo, AVG(resultado_cri) as valor";
		}
	}
	
	elseif(isset($_POST['sel_criterio']))
	{
		if($_POST['sel_criterio']!=0)
		{
			$campos_select="concat(cod_criterio,' - ',criterio) as leyenda, concat(fecha_ini,'/',fecha_fin) AS periodo, resultado_cri as valor";
		}
	}
	
	if(isset($_POST['sel_competencia']))
	{
		if($_POST['sel_competencia']!='all' AND $_POST['sel_competencia']!='all_s' AND $_POST['sel_competencia']!='0')
		{
			$campos_select="concat(cod_criterio,' - ',criterio) as leyenda, concat(fecha_ini,'/',fecha_fin) AS periodo, AVG(resultado_cri) as valor";
		}
	}
	
	$from_y=" FROM desempeno,empleado,n_criterio,n_evaluacion,n_competencia,n_periodo,compromiso,persona
	WHERE 1 
	AND desempeno.id_empleado=empleado.id_empleado 
	AND desempeno.id_criterio=n_criterio.id_criterio 
	AND desempeno.id_evaluacion=n_evaluacion.id_evaluacion
	AND desempeno.id_competencia=n_competencia.id_competencia 
	AND desempeno.id_periodo=n_periodo.id_periodo 
	AND desempeno.id_compromiso=compromiso.id_compromiso 
	AND empleado.id_persona=persona.id_persona";

	if(isset($_POST['sel_periodo_ini']) AND $_POST['sel_periodo_ini']!=0)$from_y=$from_y." AND fecha_ini >= '".$_POST['sel_periodo_ini']."'";
	if(isset($_POST['sel_periodo_fin']) AND $_POST['sel_periodo_fin']!=0)$from_y=$from_y." AND fecha_fin <= '".$_POST['sel_periodo_fin']."'";
	if(isset($_POST['sel_empleado']) AND $_POST['sel_empleado']!=0)$from_y=$from_y." AND desempeno.id_empleado = '".$_POST['sel_empleado']."'";
	if(isset($_POST['sel_competencia']) AND $_POST['sel_competencia']!=0)$from_y=$from_y." AND desempeno.id_competencia = '".$_POST['sel_competencia']."'";
	if(isset($_POST['sel_criterio']) AND $_POST['sel_criterio']!=0 AND isset($rs_comp_cri->fields['id_criterio']))$from_y=$from_y." AND desempeno.id_criterio = '".$_POST['sel_criterio']."'";

	if(isset($_POST['sel_competencia']))
	{
		if($_POST['sel_competencia']=='all' OR $_POST['sel_competencia']=='all_s' OR $_POST['sel_competencia']=='0')
		{
			$from_y=$from_y." GROUP BY competencia, primer_nombre,fecha_ini";
		}
	}
	
	
		
	if(isset($_POST['sel_competencia']))
	{
		if($_POST['sel_competencia']!='all' AND $_POST['sel_competencia']!='all_s' AND $_POST['sel_competencia']!='0')
		{
			$from_y=$from_y." GROUP BY criterio,fecha_ini";
		}
	}

	$from_y=$from_y." ORDER BY leyenda, fecha_ini ASC";//
	
	$sql_y="SELECT ".$campos_select.$from_y;
	
	
	if(isset($_POST['sel_competencia']))
	{
		if($_POST['sel_competencia']=='all')
		{
			$sql_y="SELECT 'Todas las competencias' as leyenda, avg(valor) as valor, periodo FROM (".$sql_y.") as t GROUP BY periodo";
		}
	}
//print $sql_y."<br>";


/*select avg(valor), periodo from (SELECT competencia as leyenda, concat(fecha_ini,'/',fecha_fin) AS periodo, AVG(resultado_cri) as valor 
FROM desempeno,empleado,n_criterio,n_evaluacion,n_competencia,n_periodo,compromiso,persona WHERE 1 AND desempeno.id_empleado=empleado.id_empleado 
AND desempeno.id_criterio=n_criterio.id_criterio AND desempeno.id_evaluacion=n_evaluacion.id_evaluacion AND desempeno.id_competencia=n_competencia.id_competencia 
AND desempeno.id_periodo=n_periodo.id_periodo AND desempeno.id_compromiso=compromiso.id_compromiso AND empleado.id_persona=persona.id_persona 
AND fecha_ini >= '2014-10-01' AND fecha_fin <= '2015-03-31' GROUP BY competencia,fecha_ini ORDER BY leyenda, fecha_ini ASC) as t GROUP BY periodo*/


	$rs_y=$db->Execute($sql_y) or die($db->ErrorMsg());

$datos=$obj->Cadena_grafico_linea($rs_y);
}
$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'volver','texto'=>'Volver','accion'=>'');
//$l_botones[1]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_insertar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------



//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>