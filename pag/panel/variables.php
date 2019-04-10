<?php
$b=0;

if(isset($_GET["mensaje"]))$mensaje = $_GET["mensaje"];else $mensaje = '';

if(isset($_GET["modulo"]))
{
$_SESSION["modulo"] = $_GET["modulo"];$modulo=$_GET["modulo"];

$accion='';
$elem='';

//--------Módulo de información general---------
//--------Módulo de información general---------
//--------Módulo de información general---------

$rs_sesion->MoveFirst();
if($modulo=='info')
{
	$titulo_modulo="Informaci&oacute;n del general";
	$img_modulo="info.png";
	
	for($ses=0;$ses<$rs_sesion->RecordCount();$ses++) 
	{//print $rs_sesion->fields['accion']."     ".$rs_sesion->fields['elemento'];
	
		if($accion!=$rs_sesion->fields['accion'] OR $elem!=$rs_sesion->fields['elemento'])
		{
		
			$elemento="persona";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento AND $rs_sesion->fields['modulo']==$modulo)
			{
				$titulo_pag[$b]="Empleado, estudiante, familiar y personal externo";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
		}
		
	$accion=$rs_sesion->fields['accion'];
	$elem=$rs_sesion->fields['elemento'];
	
	$rs_sesion->MoveNext();
	}
}
//--------Módulo de información general---------
//--------Módulo de información general---------
//--------Módulo de información general---------
	
//--------Módulo de configuración del sistema---------
//--------Módulo de configuración del sistema---------
//--------Módulo de configuración del sistema---------

$rs_sesion->MoveFirst();
if($modulo=='conf')
{
	$titulo_modulo="Configuraci&oacute;n del sistema";
	$img_modulo="conf.png";
	
	for($ses=0;$ses<$rs_sesion->RecordCount();$ses++) 
	{//print $rs_sesion->fields['accion']."     ".$rs_sesion->fields['elemento'];
	
		if($accion!=$rs_sesion->fields['accion'] OR $elem!=$rs_sesion->fields['elemento'])
		{
		
			$elemento="usuario";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{			
				$titulo_pag[$b]="Usuario";
				$link_pag[$b]=$x."seguridad/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="usuario_rol";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{			
				$titulo_pag[$b]="Usuario y roles";
				$link_pag[$b]=$x."seguridad/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="elemento";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{			
				$titulo_pag[$b]="Elemento";
				$link_pag[$b]=$x."seguridad/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="accion";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Acci&oacute;n";
				$link_pag[$b]=$x."seguridad/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="permiso";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Permiso";
				$link_pag[$b]=$x."seguridad/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="rol";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Rol";
				$link_pag[$b]=$x."seguridad/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="estilo";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Estilo";
				$link_pag[$b]=$x."seguridad/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
		}
		
	$accion=$rs_sesion->fields['accion'];
	$elem=$rs_sesion->fields['elemento'];
	
	$rs_sesion->MoveNext();
	}
}
//--------Módulo de configuración del sistema---------
//--------Módulo de configuración del sistema---------
//--------Módulo de configuración del sistema---------


//--------Módulo de Talento Humano---------
//--------Módulo de Talento Humano---------
//--------Módulo de Talento Humano---------

$rs_sesion->MoveFirst();
if($modulo=='rrhh')
{
	$titulo_modulo="Talento Humano";
	$img_modulo="rrhh.png";
	
	for($ses=0;$ses<$rs_sesion->RecordCount();$ses++) 
	{//print $rs_sesion->fields['accion']."   ".$rs_sesion->fields['elemento'];
		
		if($accion!=$rs_sesion->fields['accion'] OR $elem!=$rs_sesion->fields['elemento'])
		{
			$elemento="persona";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento AND $rs_sesion->fields['modulo']==$modulo)
			{
				$titulo_pag[$b]="Empleado, familiar y estudiante";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="empleado";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{	
				$titulo_pag[$b]="Empleado";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="ingreso_salida";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{	
				$titulo_pag[$b]="Ingreso o salida";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="autoriza";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{	
				$titulo_pag[$b]="Qui&eacute;n autoriza permisos?";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			/*$elemento="reemplazo";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{	
				$titulo_pag[$b]="Reemplazo";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}*/
			
			$elemento="grupo_empleado";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{	
				$titulo_pag[$b]="Grupo de empleados";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="genero";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="G&eacute;nero";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="tipo_sangre";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Tipo de sangre";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="pais";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Pa&iacute;s";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="titulo";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Titulaci&oacute;n";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="inst_educativa";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Instituci&oacute;n educatica";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="cargo";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Cargo";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="cargo_empleado";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Cargo del empleado";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="sist_salario";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Sistema de salario";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="grupo_gastos";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Grupo de Gastos";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="tipo_contrato";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Tipo de contrato";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="seccion";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Secci&oacute;n";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="tipo_cuenta";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Tipo de cuenta";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="dpto";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Departamento";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="estado_civil";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Estado civil";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="causa_ing_sal";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Causa de ingreso o salida";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			//----------Evaluación de desempeño----------
			
			$elemento="competencia";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Competencia";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="criterio";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Criterio";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="grupo_eval";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Grupo de evaluaci&oacute;n";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="evaluacion";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Evaluaci&oacute;n";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="cri_eval";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Criterio y evaluaci&oacute;n";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="comp_cri_eval";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Competencia, criterio y evaluaci&oacute;n";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="cargo_comp";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Cargo y competencia";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="ponderacion";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Ponderaci&oacute;n";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="periodo";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Per&iacute;odo";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="desempeno";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Evaluaci&oacute;n del personal";// de: ".$_SESSION['nombre'];
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="desempeno2";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Desempe&ntilde;o de : ".$_SESSION['nombre'];
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="compromiso";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Compromiso";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			//-----Nómina-----
			
			$elemento="registro_biometrico";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Registro biom&eacute;trico";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="ausencia";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Solicitud de ausencia o permiso";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="ausencia2";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Aprobaci&oacute;n de ausencia o permiso";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="vacaciones_ejec";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Vacaciones ejecutadas";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="vacaciones_acum";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Vacaciones acumuladas";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="dia_recuperable";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Feriado recuperable";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="grupo";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Grupo";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="jornada";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Jornada";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="causa_ausencia";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Causa de ausencia";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="eventos_feriado";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Eventos feriado";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="feriados";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Feriados";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="vacaciones";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Vacaciones";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="costo_horas_extras";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Costo de horas extras";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="jornada_extra";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Jornada extra";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="hora_extra";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Hora extra";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
		}
	$accion=$rs_sesion->fields['accion'];
	$elem=$rs_sesion->fields['elemento'];
		
	$rs_sesion->MoveNext();
	}
}
//--------Módulo de Talento Humano---------
//--------Módulo de Talento Humano---------
//--------Módulo de Talento Humano---------

//--------Módulo Contable---------
//--------Módulo Contable---------
//--------Módulo Contable---------

$rs_sesion->MoveFirst();
if($modulo=='cont')
{
	$titulo_modulo="Contabilidad";
	$img_modulo="cont.png";
	
	for($ses=0;$ses<$rs_sesion->RecordCount();$ses++) 
	{//print $rs_sesion->fields['accion']."   ".$rs_sesion->fields['elemento'];
		
		if($accion!=$rs_sesion->fields['accion'] OR $elem!=$rs_sesion->fields['elemento'])
		{
			$elemento="punto_venta";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Punto de venta";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="punto_venta_usuario";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Punto de venta y usuario";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="cliente";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Cliente";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="venta";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Venta";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="producto";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Producto";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="factura";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Factura";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="referencia";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Referencia";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="saldo";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Saldo";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="tarjeta";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Tarjeta";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="cliente_forma_pago";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Cliente y su forma de pago";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="forma_pago";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Forma de pago";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="grupo_cliente";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Grupo de personas para facturaci&oacute;n";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="grupos_clientes";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Grupos y personas para facturaci&oacute;n";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="preventa";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Preventa de productos a grupos de clientes";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="producto_precio";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Productos y sus precios";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="ubicacion_responsable";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Movimientos";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="inventario";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Inventario";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="baja";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Baja";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="reposicion";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Reposici&oacute;n";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="articulo";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Activo fijo";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="atributo_articulo";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Activo fijo y sus atributos";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="familia";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Grupo de nivel 1";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="gru";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Grupo de nivel 2";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="subgrupo";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Grupo de nivel 3";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="atributo";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Atributo";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="proveedor";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Proveedor";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="marca";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Marca";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="modelo";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Modelo";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="tipo_depreciacion";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Tipo de depreciaci&oacute;n";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="estado";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Estado";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="motivo_baja";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Motivo de baja";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="ubicacion";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento AND $rs_sesion->fields['modulo']==$modulo)
			{
				$titulo_pag[$b]="Ubicaci&oacute;n";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="bloque";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento AND $rs_sesion->fields['modulo']==$modulo)
			{
				$titulo_pag[$b]="Bloque";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="secc";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento AND $rs_sesion->fields['modulo']==$modulo)
			{
				$titulo_pag[$b]="Secci&oacute;n";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="division";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento AND $rs_sesion->fields['modulo']==$modulo)
			{
				$titulo_pag[$b]="Divisi&oacute;n";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
		}
	$accion=$rs_sesion->fields['accion'];
	$elem=$rs_sesion->fields['elemento'];
		
	$rs_sesion->MoveNext();
	}
}
//--------Módulo Contable---------
//--------Módulo Contable---------
//--------Módulo Contable---------

//--------Módulo Académico---------
//--------Módulo Académico---------
//--------Módulo Académico---------

$rs_sesion->MoveFirst();
if($modulo=='acad')
{
	$titulo_modulo="Acad&eacute;mico";
	$img_modulo="acad.png";
	
	for($ses=0;$ses<$rs_sesion->RecordCount();$ses++) 
	{//print $rs_sesion->fields['accion']."   ".$rs_sesion->fields['elemento'];
		
		if($accion!=$rs_sesion->fields['accion'] OR $elem!=$rs_sesion->fields['elemento'])
		{
			$elemento="estudiante";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Estudiante admitido o matriculado";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="estudiante_no_admit";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Estudiante no admitido";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			/*$elemento="parentesco";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Parentesco";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}*/
			
			/*$elemento="periodo_academico";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Per&iacute;odo acad&eacute;mico";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}*/
			
			/*$elemento="seccion_academica";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Secci&oacute;n acad&eacute;mica";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}*/
			
			/*$elemento="tipo_grado";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Tipo de grado";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}*/
			
			/*$elemento="grado";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Grado";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}*/
			
			/*$elemento="grado_paralelo";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Grado y paralelo";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}*/
			
			$elemento="grado_paralelo_periodo";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Grado, paralelo y per&iacute;odo";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			/*$elemento="paralelo";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Paralelo";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}*/
			
			$elemento="familiar";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Familiar con estudiantes admitidos o matriculados";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="familiar_no_admit";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Familiar con estudiantes no admitidos";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="empleado_academico";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Empleado acad&eacute;mico";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			/*$elemento="responsable_acta";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Responsable de acta";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}*/
			
		/*	$elemento="perfil";
			if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$sql_p="select camino_foto, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido from persona, usuario WHERE persona.id_persona=usuario.id_persona AND usuario='".$_SESSION["user"]."'";//print $sql_p;
				$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
				
				$nombre_completo=$rs_p->fields['primer_nombre'].' '.$rs_p->fields['segundo_nombre'].' '.$rs_p->fields['primer_apellido'].' '.$rs_p->fields['segundo_apellido'];
				$foto=$rs_p->fields['camino_foto'];
				
				if(base64_encode($foto))
				$foto_perfil="data:image/jpeg;base64,". base64_encode($foto);
				else
				$foto_perfil=$x."img/general/no_doc_big.png";
				
				$titulo_pag[$b]="Mi perfil: ".$nombre_completo;
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/mod_".$elemento.".php";				
				$ico_pag[$b]=$foto_perfil;//.'" height="80'
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}*/
			
			$elemento="hijo";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Mis estudiantes";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="tarea_hijo_pasadas";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Tareas pasadas";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="tarea_hijo_vigentes";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Tareas vigentes";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="tarea_pasadas";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Tareas pasadas";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="tarea_vigentes";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Tareas vigentes";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="r_cuaderno_clase";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Resumen de estudiante";
				$link_pag[$b]=$x."pag/".$modulo."/reportes/".$elemento."/lis_cuaderno_clase.php?visualizar=1";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="cuaderno_clase";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Mis cuadernos de clase";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="tutoria";
			if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Tutor&iacute;a";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/mod_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="inspectoria";
			if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Inspector&iacute;a";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/mod_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="cierre_subperiodo_evaluativo";
			if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Avance";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/mod_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="clase";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Clase";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
		}
	$accion=$rs_sesion->fields['accion'];
	$elem=$rs_sesion->fields['elemento'];
		
	$rs_sesion->MoveNext();
	}
}
//--------Módulo Académico---------
//--------Módulo Académico---------
//--------Módulo Académico---------

//--------Módulo de Biblioteca---------
//--------Módulo de Biblioteca---------
//--------Módulo de Biblioteca---------

$rs_sesion->MoveFirst();
if($modulo=='bibl')
{
	$titulo_modulo="de Biblioteca";
	$img_modulo="bibl.png";
	
	for($ses=0;$ses<$rs_sesion->RecordCount();$ses++) 
	{//print $rs_sesion->fields['accion']."   ".$rs_sesion->fields['elemento'];
		
		if($accion!=$rs_sesion->fields['accion'] OR $elem!=$rs_sesion->fields['elemento'])
		{
			$elemento="prestamo";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Pr&eacute;stamo";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="devolucion";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Devoluci&oacute;n";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="libro";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Libro";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="autor";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Autor";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="editorial";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="Editorial";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="genero_literario";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
			{
				$titulo_pag[$b]="G&eacute;nero literario";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			
			$elemento="ubicacion";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento AND $rs_sesion->fields['modulo']==$modulo)
			{
				$titulo_pag[$b]="Ubicaci&oacute;n";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="bloque";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento AND $rs_sesion->fields['modulo']==$modulo)
			{
				$titulo_pag[$b]="Estante";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="secc";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento AND $rs_sesion->fields['modulo']==$modulo)
			{
				$titulo_pag[$b]="Columna";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
			$elemento="division";
			if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento AND $rs_sesion->fields['modulo']==$modulo)
			{
				$titulo_pag[$b]="Celda";
				$link_pag[$b]=$x."pag/".$modulo."/".$elemento."/lis_".$elemento.".php";
				$ico_pag[$b]=$x."img/".$modulo."/".$elemento."/ico_".$elemento.".png";
				$color[$b]=$rs_sesion->fields['color_submodulo'];
				$b=$b+1;
			}
		}
	$accion=$rs_sesion->fields['accion'];
	$elem=$rs_sesion->fields['elemento'];
		
	$rs_sesion->MoveNext();
	}
}
//--------Módulo de Biblioteca---------
//--------Módulo de Biblioteca---------
//--------Módulo de Biblioteca---------

}// if del GET
?>