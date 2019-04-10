<?php
$tabla_anidada=array();
$campo_anidado=array();
$tabla_anidada2=array();
$campo_anidado2=array();

$field=array();
$alias_col=array();
$alias_col=array();
$columna=array();
$field_col=array();
$info_emerg=array();
$info_col=array();
$ancho=array();
$placeholder=array();
$evento=array();
$texto_input=array();

$field_new=array();

class clases_var
{	
	function Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field)
	{
		// para mostrar info en columnas, filtros
		$c=0;
		for($cmp=0;$cmp<sizeof($field_col);$cmp++) 
		{
			if($info_col[$cmp]==1 OR $info_col[$cmp]==2 OR $info_col[$cmp]=='img_doc' OR $info_col[$cmp]=='img_chec' OR $info_col[$cmp]=='calc' OR $info_col[$cmp]=='input' OR $info_col[$cmp]=='file_no_BD')
			{//print "$campos[$c]=array('ancho'=>$ancho[$cmp],'columna'=>$columna[$cmp],'field_col'=>$field_col[$cmp],'href'=>$href_m,'emergente'=>$emergente)";
				$campos[$c]=array('ancho'=>$ancho[$cmp],'columna'=>$columna[$cmp],'field_col'=>$field_col[$cmp],'field'=>$field[$cmp],'href'=>$href_m,'info_col'=>$info_col[$cmp]);
				$c=$c+1;
			}
		}
		return $campos;
		// para mostrar info en columnas, filtros
	}
	
	function Info_filtro($field_col,$info_emerg,$columna,$field,$info_col)
	{
		// para mostrar info en columnas, filtros
		$c=0;
		for($cmp=0;$cmp<sizeof($field_col);$cmp++) 
		{
			if($info_emerg[$cmp]==1 AND $info_col[$cmp]!='calc' AND $info_col[$cmp]!='input' AND $info_col[$cmp]!='file_no_BD')
			{//print "$campos[$c]=array('ancho'=>$ancho[$cmp],'columna'=>$columna[$cmp],'field_col'=>$field_col[$cmp],'href'=>$href_m,'emergente'=>$emergente)";
				$filtros[$c]=array('columna'=>$columna[$cmp],'field_col'=>$field_col[$cmp],'field'=>$field[$cmp]);
				$c=$c+1;
			}
		}
		return $filtros;
		// para mostrar info en columnas, filtros
	}
		
	function Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento)
	{
		// para llenar los input
		$i=0;
		for($inp=0;$inp<sizeof($tipo_input);$inp++) 
		{	
			if($tipo_input[$inp])
			{
				if(!isset($placeholder[$inp]))$placeholder[$inp]='';
				if(!isset($tipo_input[$inp]))$tipo_input[$inp]='';
				if(!isset($name_input[$inp]))$name_input[$inp]='';
				if(!isset($value_input[$inp]))$value_input[$inp]='';
				if(!isset($dato_permit[$inp]))$dato_permit[$inp]='';
				if(!isset($onclic[$inp]))$onclic[$inp]='';
				if(!isset($size[$inp]))$size[$inp]='';
				if(!isset($field_col[$inp]))$field_col[$inp]='';
				if(!isset($texto_input[$inp]))$texto_input[$inp]='';
				if(!isset($evento[$inp]))$evento[$inp]='';

				$title=$label_input[$inp];
				$inputs[$i]=array('num_valores'=>$inp,'evento'=>$evento[$inp],'placeholder'=>$placeholder[$inp],'tipo_input'=>$tipo_input[$inp],'name_input'=>$name_input[$inp],'id_input'=>$name_input[$inp],'value_input'=>$value_input[$inp],'title'=>$title,'dato_permit'=>$dato_permit[$inp],'onclic'=>$onclic[$inp],'size'=>$size[$inp],'field_col'=>$field_col[$inp],'texto_input'=>$texto_input[$inp]);// el 1er elemento debe ser obligatorio llenarlo ya que se pregunta por él en el isset, tener en cuenta que seria el 1er elemento que tiene $label

				$i=$i+1;	
			}
		}
		return $inputs;
		// para llenar los input
	}
	
	function Llenar_onsubmit($inputs)
	{
		// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido
		$first=0;
		$onsubmit="validar_form(";
		for($edt=0;$edt<sizeof($inputs);$edt++)
		{
			if($inputs[$edt]['dato_permit']!='texto'  AND $inputs[$edt]['dato_permit']!='')
			{
				if($edt==0)
				{
					$onsubmit=$onsubmit."'".$inputs[$edt]['name_input']."','','".$inputs[$edt]['dato_permit']."'";
					$first=1;
				}
				else
				{
					if($first==1)$onsubmit=$onsubmit.",";
					$first=1;
					$onsubmit=$onsubmit."'".$inputs[$edt]['name_input']."','','".$inputs[$edt]['dato_permit']."'";
				}
			}
		}
		$onsubmit=$onsubmit.");";
		//print $onsubmit.'<br>';
		return $onsubmit;
		// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido
	}
	
	function Llenar_varios_onsubmit($inputs)
	{
		// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido
		$onsubmit='';

		for($edt=0;$edt<sizeof($inputs);$edt++)
		{
			if($inputs[$edt]['dato_permit']!='texto' AND $inputs[$edt]['dato_permit']!='')
			{
				if($onsubmit=='')
				{
					$onsubmit="'".$inputs[$edt]['name_input']."','','".$inputs[$edt]['dato_permit']."'";
				}
				else
				{
					$onsubmit=$onsubmit.",";
					$onsubmit=$onsubmit."'".$inputs[$edt]['name_input']."','','".$inputs[$edt]['dato_permit']."'";
				}
			}
		}

		//print $onsubmit;
		return $onsubmit;
		// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido
	}
	
}
?>