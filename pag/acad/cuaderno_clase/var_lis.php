<?php
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($_GET["var"]))//$_GET["var"] se envia en el onclick de boton de ayuda, si existe que no modifique la variable $x, asi puede incluir clases_var.inc.php (NO TOCAR)
if(!isset($x))$x="../../../";// (NO TOCAR)
include_once($x."config/clases_var.inc.php");// (NO TOCAR)
if(!isset($obj_var))$obj_var = new clases_var();// (NO TOCAR)
$_SESSION["modulo"]="acad";

// declaraciones
$datos="";// (NO TOCAR)
$pag=1;// (NO TOCAR)
$cadenacheckboxp="";// (NO TOCAR)
$l_info_emergente="";// (NO TOCAR)
$mensaje="";// (NO TOCAR)
$options="";// (NO TOCAR)
// declaraciones


$elemento_titulo="de cuadernos de clase"; // para el título
$elemento="cuaderno_clase"; // elemento o nomenclador al que se accede
$camino="pag/acad/".$elemento; // camino para acceder
$location=$x.$camino;
$modulo='acad';

$img_encabezado="img/acad/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a las cuaderno_clases registradas en la base de datos.";//introduccion de la ayuda



$b=0;

$accion='';
$elem='';

//--------Módulo Académico---------
//--------Módulo Académico---------
//--------Módulo Académico---------
$l_sql="SELECT id_clase as id_clase, clase.id_asignatura as id_asignatura, concat(abreviatura,' - ',asignatura) as asignatura, n_asignatura.foto, clase.nombre as nombre, referencia as referencia, 
codigo as codigo, clase.id_empleado_academico as id_empleado_academico, concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre,' - ',persona.identificacion) as empleado_academico, peso as peso 
FROM clase, n_periodo_academico, n_asignatura, empleado_academico, empleado, persona, usuario WHERE 1 
AND clase.id_periodo_academico=n_periodo_academico.id_periodo_academico AND clase.id_asignatura=n_asignatura.id_asignatura 
AND clase.id_empleado_academico=empleado_academico.id_empleado_academico AND persona.id_persona=empleado.id_persona AND persona.id_persona=usuario.id_persona
AND empleado_academico.id_empleado=empleado.id_empleado AND n_periodo_academico.activo='1'";

if(isset($todos))
{
	if($todos!='ok')
	$l_sql.=" AND usuario='".$_SESSION['user']."'";
}

if(isset($filtro)){if($filtro!=''){$l_sql.=$filtro;}}

$l_sql.=" ORDER BY asignatura, clase.codigo";
$rs=$db->Execute($l_sql) or die($db->ErrorMsg());

if($modulo=='acad')
{
	
	for($g=0;$g<$rs->RecordCount();$g++)
	{
		$foto=$rs->fields['foto'];
		if(base64_encode($foto))
		$img="data:image/jpeg;base64,". base64_encode($foto);
		else
		$img=$x."img/general/no_doc.png";
		
		$titulo_pag[$b]=$rs->fields['nombre'];
		$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/mod_".$elemento.".php?mod=".$rs->fields['id_clase'];
		$ico_pag[$b]=$img;
		$color[$b]='#F0F0FA';
		$b=$b+1;
	
	$rs->MoveNext();
	}
			

}
//--------Módulo Académico---------
//--------Módulo Académico---------
//--------Módulo Académico---------
?>