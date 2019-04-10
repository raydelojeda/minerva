<?php
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($_GET["var"]))//$_GET["var"] se envia en el onclick de boton de ayuda, si existe que no modifique la variable $x, asi puede incluir clases_var.inc.php (NO TOCAR)
if(!isset($x))$x="../../../../";// (NO TOCAR)
include_once($x."config/clases_var.inc.php");// (NO TOCAR)
if(!isset($obj_var))$obj_var = new clases_var();// (NO TOCAR)
$_SESSION["modulo"]="rrhh";

include_once($x."config/clases.inc.php");
$obj = new clases();

/*session_save_path($x."temp" );
session_start();*/

// declaraciones
$datos="";// (NO TOCAR)
$pag=1;// (NO TOCAR)
$cadenacheckboxp="";// (NO TOCAR)
$l_info_emergente="";// (NO TOCAR)
$mensaje="";// (NO TOCAR)
$options="";// (NO TOCAR)
// declaraciones


$elemento_titulo="resumen de evaluaci&oacute;n de desempe&ntilde;o"; // para el título
$elemento="r_desempeno2"; // elemento o nomenclador al que se accede
$camino="pag/rrhh/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/rrhh/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Reporte ".$elemento_titulo; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a las evaluaciones de desempe&ntilde;o registradas en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="desempeno";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='empleado';
$tabla_anidada[1]='n_criterio';
$tabla_anidada[2]='n_evaluacion';
$tabla_anidada[3]='n_competencia';
$tabla_anidada[4]='n_periodo';
$tabla_anidada[5]='compromiso';
$tabla_anidada[6]='n_cargo';

$campo_anidado=array();
$campo_anidado[0]='id_empleado';
$campo_anidado[1]='id_criterio';
$campo_anidado[2]='id_evaluacion';
$campo_anidado[3]='id_competencia';
$campo_anidado[4]='id_periodo';
$campo_anidado[5]='id_compromiso';
$campo_anidado[6]='id_cargo';

$tabla_anidada2=array();
$tabla_anidada2[0]='persona';
$tabla_anidada2[1]='empleado as emp';
$tabla_anidada2[2]='persona as per';
$tabla_anidada2[3]='usuario';

$campo_anidado2=array();
$campo_anidado2[0]='id_persona';

$select="SELECT id_desempeno,n_cargo.cargo, concat(fecha_ini,'/',fecha_fin) AS periodo, persona.identificacion, persona.primer_nombre, persona.segundo_nombre,
persona.primer_apellido, persona.segundo_apellido, AVG(resultado_cri) as valor, concat(fecha_ini,'/',fecha_fin,' - ',persona.identificacion,' - ',persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre) AS per, seccion

FROM n_cargo, cargo_empleado, n_seccion,desempeno,empleado,n_criterio,n_evaluacion,n_competencia,n_periodo,compromiso,persona 

WHERE 1 AND desempeno.id_empleado=empleado.id_empleado 
AND cargo_empleado.activo='1' 
AND n_cargo.id_cargo=cargo_empleado.id_cargo 
AND cargo_empleado.id_empleado=empleado.id_empleado 
AND n_seccion.id_seccion=empleado.id_seccion 
AND desempeno.id_criterio=n_criterio.id_criterio 
AND desempeno.id_evaluacion=n_evaluacion.id_evaluacion 
AND desempeno.id_competencia=n_competencia.id_competencia 
AND desempeno.id_periodo=n_periodo.id_periodo 
AND desempeno.id_compromiso=compromiso.id_compromiso 
AND empleado.id_persona=persona.id_persona
GROUP BY periodo, identificacion ORDER BY periodo, primer_apellido ASC";//print $select;

$order="";

/*SELECT per,avg(valor) as valor, periodo, seccion, ident, p_n, p_a, s_a, cargo
FROM (SELECT n_cargo.cargo, concat(fecha_ini,'/',fecha_fin) AS periodo, persona.identificacion AS ident, persona.primer_nombre AS p_n,  
persona.primer_apellido AS p_a, persona.segundo_apellido AS s_a, competencia, AVG(resultado_cri) as valor, concat(fecha_ini,'/',fecha_fin,' - ',persona.identificacion,' - ',persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre) AS per, seccion
FROM n_cargo, cargo_empleado, n_seccion,desempeno,empleado,n_criterio,n_evaluacion,n_competencia,n_periodo,compromiso,persona WHERE 1 AND desempeno.id_empleado=empleado.id_empleado 
AND cargo_empleado.activo='1' AND n_cargo.id_cargo=cargo_empleado.id_cargo AND cargo_empleado.id_empleado=empleado.id_empleado AND n_seccion.id_seccion=empleado.id_seccion 
AND desempeno.id_criterio=n_criterio.id_criterio AND desempeno.id_evaluacion=n_evaluacion.id_evaluacion AND desempeno.id_competencia=n_competencia.id_competencia 
AND desempeno.id_periodo=n_periodo.id_periodo AND desempeno.id_compromiso=compromiso.id_compromiso AND empleado.id_persona=persona.id_persona
GROUP BY periodo, ident, competencia ORDER BY fecha_ini, primer_apellido,competencia ASC) as t GROUP BY periodo, per */

$field[0]='id_desempeno'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]='per';
$field[2]='valor';
$field[3]='seccion';
$field[4]='identificacion';
$field[5]='primer_nombre';
$field[6]='segundo_nombre';
$field[7]='primer_apellido';
$field[8]='segundo_apellido';
$field[9]='periodo';
$field[10]='cargo';
$field[11]='valor';
$field[12]='valor';

$field_busqueda=array();
$field_busqueda[0]='persona.primer_nombre'; 
$field_busqueda[1]='persona.segundo_nombre';
$field_busqueda[2]="persona.primer_apellido";
$field_busqueda[3]='persona.identificacion';
$field_busqueda[4]="persona.segundo_apellido";
$field_busqueda[5]="fecha_ini";
$field_busqueda[6]="fecha_fin";

$alias_col=array();
$alias_col[0]='id_desempeno';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='per';
$alias_col[2]='';//number_format(round($rs->fields["valor"],2), 2, ".", "")." - ".$cualitativo=$this->Convertir_cualitativo(round($rs->fields["valor"],2),"des"); 
$alias_col[3]='seccion';
$alias_col[4]='identificacion';
$alias_col[5]='primer_nombre';
$alias_col[6]='segundo_nombre';
$alias_col[7]='primer_apellido';
$alias_col[8]='segundo_apellido';
$alias_col[9]='periodo';
$alias_col[10]='cargo';
$alias_col[11]='number_format(round($rs->fields["valor"],2), 2, ".", "");';
$alias_col[12]='$cualitativo=$obj->Convertir_cualitativo(round($rs->fields["valor"],2),"des"); ';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Per&iacute;odo';
$columna[2]='Resultado final';
$columna[3]='Secci&oacute;n';
$columna[4]='Identificaci&oacute;n';
$columna[5]='Primer nombre';
$columna[6]='Segundo nombre';
$columna[7]='Primer apellido';
$columna[8]='Segundo apellido';
$columna[9]='Per&iacute;odo';
$columna[10]='Cargo del empleado';
$columna[11]='Numeral';
$columna[12]='Literal';

$field_col=array();
$field_col[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$field_col[1]=$alias_col[1];
$field_col[2]=$alias_col[2];
$field_col[3]=$alias_col[3];
$field_col[4]=$alias_col[4];
$field_col[5]=$alias_col[5];
$field_col[6]=$alias_col[6];
$field_col[7]=$alias_col[7];
$field_col[8]=$alias_col[8];
$field_col[9]=$alias_col[9];
$field_col[10]=$alias_col[10];
$field_col[11]=$alias_col[11];
$field_col[12]=$alias_col[12];

$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]=1;
$info_emerg[2]='';
$info_emerg[3]=1;
$info_emerg[4]=1;
$info_emerg[5]=1;
$info_emerg[6]=1;
$info_emerg[7]=1;
$info_emerg[8]=1;
$info_emerg[9]=1;
$info_emerg[10]=1;
$info_emerg[11]=1;
$info_emerg[12]=1;

$info_col[0]=''; // si se muestra o no la columna para listar, diferente de 1, 2 o vacío es para agrupar por un campo las filas, el número deber ser el colspan + 2, que haya número no significa que aparezca en columna
$info_col[1]=1;
$info_col[2]='';
$info_col[3]=1;
$info_col[4]='';
$info_col[5]='';
$info_col[6]='';
$info_col[7]='';
$info_col[8]='';
$info_col[9]='';
$info_col[10]='';
$info_col[11]='calc';
$info_col[12]='calc';

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='60%';
$ancho[2]='';
$ancho[3]='20%';
$ancho[4]='';
$ancho[5]='';
$ancho[6]='';
$ancho[7]='';
$ancho[8]='';
$ancho[9]='';
$ancho[10]='';
$ancho[11]='9%';
$ancho[12]='9%';

$var_mod='';
$columna_suma[0]='';
$href_m=''; // camino de la pagina para Editar

$id_cadenacheckboxp='';

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Nuevo','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Editar','exp'=>'Editar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[3]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Per&iacute;odo');
$l_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Resultado final');


$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
//$l_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'planilla_r_desempeno.php\')','src'=>$x.'img/general/pdf.png','nombre'=>'editar','texto'=>'Planilla','accion'=>'Imprimir');
$l_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'planilla_r_resumen_desempeno.php\')','src'=>$x.'img/general/pdf.png','nombre'=>'editar','texto'=>'Resumen','accion'=>'Imprimir');
//$l_botones[2]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'../../../plantillas/eliminar.php\')','src'=>$x.'img/general/eliminar.png','nombre'=>'eliminar','texto'=>'Eliminar','accion'=>'Eliminar');
$l_botones[1]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'imp_'.$elemento.'.php\');','src'=>$x.'img/general/imprimir.png','nombre'=>'imprimir','texto'=>'Imprimir','accion'=>'Imprimir');
$l_botones[2]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'exp_'.$elemento.'.php\');','src'=>$x.'img/general/exportar_csv.png','nombre'=>'exportar_csv','texto'=>'Exportar','accion'=>'Exportar');
//$l_botones[4]=array('target'=>'_self','href'=>'graf_linea_basica_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/grafico.png','nombre'=>'grafico','texto'=>'Gr&aacute;fico','accion'=>'Visualizar');
$l_botones[3]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_listar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------

$insert_field[0]='id_desempeno'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='id_periodo'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[1];
$insert_alias[2]='';

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[1]; 
$name_input[2]=$alias_col[2]; 

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[1]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[2];

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]=2;
$field_unico[2]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='';
$tipo_input[2]='';

// valores que va a tomar el campo tipo <select> en cada <option>
$f=1;


$combo_sql[$f] = "SELECT id_periodo, concat(fecha_ini,' - ',fecha_fin) AS periodo FROM n_periodo ORDER BY fecha_ini DESC";

$opt_name=array();
$opt_name[$f][0]='periodo';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value=array();
$opt_value[$f][0]='id_periodo';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel=array();
$opt_sel[$f][0]='id_periodo';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD


// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido. Si es texto no es un input (NO TOCAR)
$dato_permit[1]='texto';
$dato_permit[2]='';

$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='';
$value_input[2]='';

$texto_input=array();
$placeholder=array();
$evento=array();

$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='';

$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='50';
$size[2]='';

//$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
//$onsubmit=$obj_var->Llenar_onsubmit($inputs);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)

$n_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>"javascript:valida_radio();",'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$n_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$n_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_insertar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$n_botones_ayuda=array(); // botonera que va a tener en el encabezado (NO TOCAR) 
$n_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$n_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$n_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$n_label_ayuda=array(); // campos de los <input> (NO TOCAR) 
$n_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Per&iacute;odo');
$n_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Resultado final');

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$m_botones=array(); // botonera que va a tener en el encabezado  (NO TOCAR) 
//$m_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit,'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$m_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$m_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_Editar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$m_botones_ayuda=array(); // botonera en el encabezado (NO TOCAR) 
$m_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$m_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$m_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$m_label_ayuda=array(); // campos de los <input> (NO TOCAR)
$m_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Per&iacute;odo');
$m_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Resultado final');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>