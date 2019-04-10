<?php
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($_GET["var"]))//$_GET["var"] se envia en el onclick de boton de ayuda, si existe que no modifique la variable $x, asi puede incluir clases_var.inc.php (NO TOCAR)
if(!isset($x))$x="../../../";// (NO TOCAR)
include_once($x."config/clases_var.inc.php");// (NO TOCAR)
if(!isset($obj_var))$obj_var = new clases_var();// (NO TOCAR)
$_SESSION["modulo"]="rrhh";

// declaraciones
$datos="";// (NO TOCAR)
$pag=1;// (NO TOCAR)
$cadenacheckboxp="";// (NO TOCAR)
$l_info_emergente="";// (NO TOCAR)
$mensaje="";// (NO TOCAR)
$options="";// (NO TOCAR)
// declaraciones


$elemento_titulo="de instituci&oacute;n educativa"; // para el título
$elemento="inst_educativa"; // elemento o nomenclador al que se accede
$camino="pag/rrhh/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/rrhh/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //inst_educativa del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //inst_educativa del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //inst_educativa del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //inst_educativa del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a las instituciones educativas registradas en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="n_inst_educativa";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='n_pais';
//$tabla_anidada[1]='';

$campo_anidado=array();
$campo_anidado[0]='id_pais';
//$campo_anidado[1]='';

$field[0]='id_inst_educativa'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]='inst_educativa';
$field[2]=$tabla.'.id_pais';
$field[3]='pais';

$alias_col=array();
$alias_col[0]='id_inst_educativa';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='inst';
$alias_col[2]='id_p';
$alias_col[3]='sel_pais';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Instituci&oacute;n educativa';
$columna[2]='Pa&iacute;s';
$columna[3]='Pa&iacute;s';

$field_col=array();
$field_col[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$field_col[1]=$alias_col[1];
$field_col[2]=$alias_col[2];
$field_col[3]=$alias_col[3];


$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]=1;
$info_emerg[2]='';
$info_emerg[3]=1;

$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]=1;
$info_col[2]='';
$info_col[3]=1;

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='49%';
$ancho[2]='';
$ancho[3]='49%';

$var_mod='';
$columna_suma[0]='';
$href_m='mod_inst_educativa.php?mod='; // camino de la pagina para Editar

$id_cadenacheckboxp='';

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Nuevo','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Editar','exp'=>'Editar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Eliminar','exp'=>'eliminar la informaci&oacute;n');
$l_botones_ayuda[3]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[5]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Instituci&oacute;n educativa donde se gradu&oacute; el empleado');
$l_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Pa&iacute;s de la instituci&oacute;n educativa donde se gradu&oacute; el empleado');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Nuevo','accion'=>'Insertar');
$l_botones[1]=array('target'=>'_self','href'=>'#','onclic'=>'modif(\'mod_inst_educativa.php\')','src'=>$x.'img/general/Editar.png','nombre'=>'editar','texto'=>'Editar','accion'=>'Editar');
$l_botones[2]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'../../../plantillas/eliminar.php\')','src'=>$x.'img/general/eliminar.png','nombre'=>'eliminar','texto'=>'Eliminar','accion'=>'Eliminar');
$l_botones[3]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'imp_'.$elemento.'.php\');','src'=>$x.'img/general/imprimir.png','nombre'=>'imprimir','texto'=>'Imprimir','accion'=>'Imprimir');
$l_botones[4]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'exp_'.$elemento.'.php\');','src'=>$x.'img/general/exportar_csv.png','nombre'=>'exportar_csv','texto'=>'Exportar','accion'=>'Exportar');
$l_botones[5]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_listar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------

$insert_field[0]='id_inst_educativa'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='inst_educativa'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='id_pais';
$insert_field[3]='';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[1];
$insert_alias[2]=$alias_col[2];
$insert_alias[3]='';

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[1];
$name_input[2]=$alias_col[3];
$name_input[3]=$alias_col[3]; 

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[1]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[2];
$label_input[3]=$columna[3];

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]=2;
$field_unico[2]=2;
$field_unico[3]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='input';
$tipo_input[2]='';
$tipo_input[3]='selectBD';

// valores que va a tomar el campo tipo <select> en cada <option>
$f=3;
$combo_sql[$f] = "select id_pais as id_p, pais as pais from n_pais order by pais";

$opt_name=array();
$opt_name[$f][0]='pais';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$f][1]='';//Además puedes tener del campo de la tabla en caso de selectBD
$opt_name[$f][2]='';
$opt_name[$f][3]='';

$opt_value=array();
$opt_value[$f][0]='id_p';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$f][1]='';
$opt_value[$f][2]='';
$opt_value[$f][3]='';

$opt_sel=array();
$opt_sel[$f][0]='id_p';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$f][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
$opt_sel[$f][2]='';
$opt_sel[$f][3]='';
// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='Rvarchar';
$dato_permit[2]='';
$dato_permit[3]='Rselec';

$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='';
$value_input[2]='';
$value_input[3]='';

$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='';
$onclic[3]='';

$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='150';
$size[2]='50';
$size[3]='50';

$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
$onsubmit=$obj_var->Llenar_onsubmit($inputs);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)

$n_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit,'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$n_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$n_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_insertar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$mini_onsubmit="ok=validar_sin_submit(";
$mini_onsubmit=$mini_onsubmit.$obj_var->Llenar_varios_onsubmit($inputs);
$mini_onsubmit=$mini_onsubmit.");";

$campos_origen=array();
$campos_origen[0]=$alias_col[1];
$campos_origen[1]=$alias_col[3];

$mini_n_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$mini_n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$mini_onsubmit."if(ok==0)return false;guardar_sin_recargar('".$x.$camino."/ins_".$elemento.".php','".implode(",", $campos_origen)."','INSTITUCION_EDUACATIVA');",'src'=>$x.'img/general/guardar_mini.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'Insertar');
$mini_n_botones[1]=array('target'=>'_self','href'=>'#close','onclic'=>'','src'=>$x.'img/general/cerrar_mini.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');

$n_botones_ayuda=array(); // botonera que va a tener en el encabezado (NO TOCAR) 
$n_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$n_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$n_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$n_label_ayuda=array(); // campos de los <input> (NO TOCAR) 
$n_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Instituci&oacute;n educativa donde se gradu&oacute; el empleado');
$n_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Pa&iacute;s de la instituci&oacute;n educativa donde se gradu&oacute; el empleado');

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$m_botones=array(); // botonera que va a tener en el encabezado  (NO TOCAR) 
$m_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit,'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$m_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$m_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_Editar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$m_botones_ayuda=array(); // botonera en el encabezado (NO TOCAR) 
$m_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$m_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$m_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$m_label_ayuda=array(); // campos de los <input> (NO TOCAR)
$m_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Instituci&oacute;n educativa donde se gradu&oacute; el empleado');
$m_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Pa&iacute;s de la instituci&oacute;n educativa donde se gradu&oacute; el empleado');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>