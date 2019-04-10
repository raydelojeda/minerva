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


$elemento_titulo="de mis tareas vigentes"; // para el título
$elemento="tarea_vigentes"; // elemento o nomenclador al que se accede
$camino="pag/acad/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/acad/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": Visualizar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a las tareas registradas en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="tarea";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='actividad';
$tabla_anidada[1]='tarea_estudiante';

$tabla_anidada2[0]='clase_estudiante';
$tabla_anidada2[1]='curso_grado_paralelo_est';
$tabla_anidada2[2]='estudiante';
$tabla_anidada2[3]='persona';
$tabla_anidada2[4]='usuario';
$tabla_anidada2[5]='clase';

$campo_anidado=array();
$campo_anidado[0]='id_actividad';
$campo_anidado[1]='id_tarea';

$campo_anidado2[0]='id_clase_estudiante';
$campo_anidado2[1]='id_curso_grado_paralelo_est';
$campo_anidado2[2]='id_estudiante';
$campo_anidado2[3]='id_persona';
$campo_anidado2[4]='id_usuario';
$campo_anidado2[5]='id_clase';

$hoy=date("Y-m-d");

$where=" AND tarea_estudiante.id_clase_estudiante=clase_estudiante.id_clase_estudiante
AND clase_estudiante.id_curso_grado_paralelo_est=curso_grado_paralelo_est.id_curso_grado_paralelo_est
AND curso_grado_paralelo_est.id_estudiante=estudiante.id_estudiante
AND estudiante.id_persona=persona.id_persona
AND persona.id_persona=usuario.id_persona

AND clase_estudiante.id_clase=clase.id_clase AND usuario='".$_SESSION['user']."' AND tarea.fecha_fin>='".$hoy."'";//

//$order=" tarea.fecha_fin ASC";

$field[0]=$tabla.'.id_tarea'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]='actividad_examen';
$field[2]='actividad.descripcion';
$field[3]='fecha_ini';
$field[4]='fecha_fin';
$field[5]='opcional';
$field[6]='clase.nombre';

$field_busqueda=array();
$field_busqueda[0]='actividad_examen'; 
$field_busqueda[1]='actividad.descripcion';
$field_busqueda[2]="fecha_ini";
$field_busqueda[3]='fecha_fin';
$field_busqueda[4]="opcional";
$field_busqueda[5]='clase.nombre';

$alias_col=array();
$alias_col[0]='id_tarea';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='act';
$alias_col[2]='descr';
$alias_col[3]='ini';
$alias_col[4]='fin';
$alias_col[5]='opc';
$alias_col[6]='nom';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Actividad';
$columna[2]='Descripci&oacute;n';
$columna[3]='Inicia';
$columna[4]='Debe entregarse';
$columna[5]='Opcional';
$columna[6]='Clase';

$field_col=array();
$field_col[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$field_col[1]=$alias_col[1];
$field_col[2]=$alias_col[2];
$field_col[3]=$alias_col[3];
$field_col[4]=$alias_col[4];
$field_col[5]=$alias_col[5];
$field_col[6]=$alias_col[6];

$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]=1;
$info_emerg[2]=1;
$info_emerg[3]=1;
$info_emerg[4]=1;
$info_emerg[5]=2;
$info_emerg[6]=1;

$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]=1;
$info_col[2]='';
$info_col[3]=1;
$info_col[4]=1;
$info_col[5]=2;
$info_col[6]=1;

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='44%';
$ancho[2]='';
$ancho[3]='12%';
$ancho[4]='12%';
$ancho[5]='5%';
$ancho[6]='25%';

$var_mod='';
$columna_suma[0]='';
$href_m='mod_'.$elemento.'.php?mod='; // camino de la pagina para Editar

$id_cadenacheckboxp='';

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Nuevo','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Editar','exp'=>'Editar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Eliminar','exp'=>'eliminar la informaci&oacute;n');
$l_botones_ayuda[3]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[5]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Nombre de la tarea');
$l_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Abreviatura de la tarea');
$l_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Aporta a promedios la tarea?: Si o no');
$l_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Es cuantitativa la tarea?: Si o no (La tarea que no sea cuantitativa ser&aacute; cualitativa)');
$l_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Mostrar en reportes oficiales la tarea?: Si o no (La tarea que se muestra en reportes oficiales se muestra en la libreta ministerial)');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Nuevo','accion'=>'Insertar');
$l_botones[1]=array('target'=>'_self','href'=>'#','onclic'=>'modif(\'mod_tarea.php\')','src'=>$x.'img/general/Editar.png','nombre'=>'editar','texto'=>'Editar','accion'=>'Editar');
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

$insert_field[0]='id_tarea'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='fecha_ini'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='fecha_fin';
$insert_field[3]='opcional';
$insert_field[4]='id_actividad';
$insert_field[5]='';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]='ini';
$insert_alias[2]='fin';
$insert_alias[3]='opc';
$insert_alias[4]='id_actividad';
$insert_alias[5]='';

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$insert_alias[1];
$name_input[2]=$insert_alias[2];
$name_input[3]=$insert_alias[3];
$name_input[4]='act';
$name_input[5]='act';

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]='Inicia'; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]='Finaliza';
$label_input[3]='Opcional';
$label_input[4]='Actividad';
$label_input[5]='Actividad';

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]='';
$field_unico[2]='';
$field_unico[3]='';
$field_unico[4]='';
$field_unico[5]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='input';
$tipo_input[2]='input';
$tipo_input[3]='select';
$tipo_input[4]='hidden';
$tipo_input[5]='';

// valores que va a tomar el campo tipo <select> en cada <option>
$f=3;
$r=4;
$w=5;
$combo_sql[$f] = "";

$opt_name[$f][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$f][1]='No';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$f][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$f][1]='0';

$opt_sel[$f][0]='';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$f][1]='selected';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$w] = " ";//SELECT id_actividad FROM

$opt_name[$w][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$w][1]='No';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$w][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$w][1]='0';

$opt_sel[$w][0]='';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$w][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='Rfecha';
$dato_permit[2]='Rfecha';
$dato_permit[3]='Rselec';
$dato_permit[4]='';
$dato_permit[5]='varchar';

$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='';
$value_input[2]='';
$value_input[3]='';
if(isset($id_actividad))$value_input[4]=$id_actividad;else $value_input[4]='';
$value_input[5]='';

$texto_input=array();
$placeholder=array();
$evento=array();

$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='displayCalendar(document.frm.'.$name_input[1].',"yyyy-mm-dd",this);';
$onclic[2]='displayCalendar(document.frm.'.$name_input[2].',"yyyy-mm-dd",this);';
$onclic[3]='';
$onclic[4]='';
$onclic[5]='';

$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='10';
$size[2]='10';
$size[3]='50';
$size[4]='';
$size[5]='50';

$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
$onsubmit=$obj_var->Llenar_onsubmit($inputs);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)

$n_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit,'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$n_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$n_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_insertar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$n_botones_ayuda=array(); // botonera que va a tener en el encabezado (NO TOCAR) 
$n_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$n_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$n_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$n_label_ayuda=array(); // campos de los <input> (NO TOCAR) 
$n_label_ayuda[0]=array('texto'=>'Tipo de actividad','exp'=>'Tipo de actividad de la tarea');
$n_label_ayuda[1]=array('texto'=>'Actividad o Tarea','exp'=>'Nombre de la tarea');
$n_label_ayuda[2]=array('texto'=>'Descripci&oacute;n','exp'=>'Descripci&oacute;n de la tarea');
$n_label_ayuda[3]=array('texto'=>'Fecha','exp'=>'Fecha en que se orient&oacute; la tarea');
$n_label_ayuda[4]=array('texto'=>'Inicia','exp'=>'Fecha en que se debe iniciar la tarea');
$n_label_ayuda[5]=array('texto'=>'Finaliza','exp'=>'Fecha en que se debe finalizar la tarea');
$n_label_ayuda[6]=array('texto'=>'Opcional','exp'=>'Es opcional la tarea? Si o no');
$n_label_ayuda[7]=array('texto'=>'Descripci&oacute;n larga','exp'=>'Descripci&oacute;n de la tarea');
$n_label_ayuda[8]=array('texto'=>'Adjuntos','exp'=>'Listado de adjuntos de la tarea');

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$m_botones=array(); // botonera que va a tener en el encabezado  (NO TOCAR) 
//$m_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit,'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$m_botones[0]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$m_botones[1]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_Editar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$m_botones_ayuda=array(); // botonera en el encabezado (NO TOCAR) 
$m_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$m_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$m_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$m_label_ayuda=array(); // campos de los <input> (NO TOCAR)
$m_label_ayuda[0]=array('texto'=>'Tipo de actividad','exp'=>'Tipo de actividad de la tarea');
$m_label_ayuda[1]=array('texto'=>'Actividad o Tarea','exp'=>'Nombre de la tarea');
$m_label_ayuda[2]=array('texto'=>'Descripci&oacute;n','exp'=>'Descripci&oacute;n de la tarea');
$m_label_ayuda[3]=array('texto'=>'Fecha','exp'=>'Fecha en que se orient&oacute; la tarea');
$m_label_ayuda[4]=array('texto'=>'Inicia','exp'=>'Fecha en que se debe iniciar la tarea');
$m_label_ayuda[5]=array('texto'=>'Finaliza','exp'=>'Fecha en que se debe finalizar la tarea');
$m_label_ayuda[6]=array('texto'=>'Opcional','exp'=>'Es opcional la tarea? Si o no');
$m_label_ayuda[7]=array('texto'=>'Descripci&oacute;n larga','exp'=>'Descripci&oacute;n de la tarea');
$m_label_ayuda[8]=array('texto'=>'Adjuntos','exp'=>'Listado de adjuntos de la tarea');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>