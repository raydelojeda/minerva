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


$elemento_titulo="de actividad"; // para el título
$elemento="actividad"; // elemento o nomenclador al que se accede
$camino="pag/acad/".$elemento; // camino para acceder
$location=$x.$camino;


$img_encabezado="img/acad/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a las actividades registradas en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="actividad";// tabla de la BD

$tabla_anidada[0]='n_seccion_academica';

$tabla_anidada2[0]='n_actividad as gra';

$campo_anidado[0]='id_seccion_academica';

$campo_anidado2[0]='gra.id_proximo_actividad';

$where=' AND gra.id_actividad=n_actividad.id_proximo_actividad';

$field[0]=$tabla.'.id_actividad'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]=$tabla.'.actividad';
$field[2]='gra.id_proximo_actividad';
$field[3]='gra.actividad';
$field[4]=$tabla.'.ultimo_actividad';
$field[5]=$tabla.'.abreviatura';
$field[6]=$tabla.'.promocion';
$field[7]=$tabla.'.id_seccion_academica';

$alias_col=array();
$alias_col[0]='id_actividad_mod';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='id_clase_mod';
$alias_col[2]='id_clase_mod';
$alias_col[3]='id_tipo_mod';
$alias_col[4]='id_tipo_mod';
$alias_col[5]='act_mod';
$alias_col[6]='des_mod';
$alias_col[7]='fec_mod';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Clase';
$columna[2]='Clase';
$columna[3]='Tipo de actividaad';
$columna[4]='Tipo de actividaad';
$columna[5]='Actividad o examen';
$columna[6]='Descripci&oacute;n';
$columna[7]='Fecha';

$field_col=array();
$field_col[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$field_col[1]=$alias_col[1];
$field_col[2]=$alias_col[2];
$field_col[3]=$alias_col[3];
$field_col[4]=$alias_col[4];
$field_col[5]=$alias_col[5];
$field_col[6]=$alias_col[6];
$field_col[7]=$alias_col[7];

$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]=1;
$info_emerg[2]='';
$info_emerg[3]=1;
$info_emerg[4]=2;
$info_emerg[5]=1;
$info_emerg[6]=1;
$info_emerg[7]='';

$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]=1;
$info_col[2]='';
$info_col[3]=1;
$info_col[4]=2;
$info_col[5]=1;
$info_col[6]=1;
$info_col[7]='';

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='18%';
$ancho[2]='';
$ancho[3]='18%';
$ancho[4]='9%';
$ancho[5]='10%';
$ancho[6]='';
$ancho[7]='25%';

$var_mod='';
$columna_suma[0]='';
$href_m='mod_actividad.php?mod='; // camino de la pagina para Editar

$id_cadenacheckboxp='';

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Nuevo','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Editar','exp'=>'Editar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Eliminar','exp'=>'eliminar la informaci&oacute;n');
$l_botones_ayuda[3]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[5]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'actividad del estudiante');
$l_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'actividad pr&oacute;ximo al que debe pasar el estudiante');
$l_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Es el &uacute;ltimo actividad?: Si o No');
$l_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Abreviatura');
$l_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Nombre que aparece en el certificado de promoci&oacute;n, se compone del curso y la secci&oacute;n. Ejemplo: Tercero de básica elemental');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Nuevo','accion'=>'Insertar');
$l_botones[1]=array('target'=>'_self','href'=>'#','onclic'=>'modif(\'mod_actividad.php\')','src'=>$x.'img/general/Editar.png','nombre'=>'editar','texto'=>'Editar','accion'=>'Editar');
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

$insert_field[0]='id_actividad'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='id_clase'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='';
$insert_field[3]='id_tipo_actividad';
$insert_field[4]='';
$insert_field[5]='actividad_examen';
$insert_field[6]='descripcion';
$insert_field[7]='fecha';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[1];
$insert_alias[2]='';
$insert_alias[3]=$alias_col[3];
$insert_alias[4]='';
$insert_alias[5]=$alias_col[5];
$insert_alias[6]=$alias_col[6];
$insert_alias[7]=$alias_col[7];

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[2];
$name_input[2]=$alias_col[2]; 
$name_input[3]=$alias_col[4]; 
$name_input[4]=$alias_col[4];
$name_input[5]=$alias_col[5];
$name_input[6]=$alias_col[6]; 
$name_input[7]=$alias_col[7];

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[2]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[2];
$label_input[3]=$columna[4];
$label_input[4]=$columna[4];
$label_input[5]=$columna[5];
$label_input[6]=$columna[6];
$label_input[7]=$columna[7];

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]='';
$field_unico[2]='';
$field_unico[3]='';
$field_unico[4]='';
$field_unico[5]='';
$field_unico[6]='';
$field_unico[7]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='hidden';
$tipo_input[2]='';
$tipo_input[3]='';
$tipo_input[4]='texto_select';
$tipo_input[5]='input';
$tipo_input[6]='input';
$tipo_input[7]='input';

// valores que va a tomar el campo tipo <select> en cada <option>
$g=4;

//$combo_sql[$g] = "select id_tipo_actividad as id_tipo, concat(abv_tipo_actividad_examen,' - ',tipo_actividad_examen) as tipo from n_seccion_academica order by orden ASC";

$opt_name[$g][0]='tipo';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$g][1]='';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$g][0]='id_tipo_mod';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$g][1]='';

$opt_sel[$g][0]='id_tipo_mod';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$g][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='';
$dato_permit[2]='';
$dato_permit[3]='';
$dato_permit[4]='Rselect';
$dato_permit[5]='Rvarchar';
$dato_permit[6]='varchar';
$dato_permit[7]='Rfecha';

$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
if(isset($id_clase))$value_input[1]=$id_clase;else $value_input[1]='';
$value_input[2]='';
$value_input[3]='';
$value_input[4]='';
$value_input[5]='';
$value_input[6]='';
$value_input[7]='';

$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='';
$onclic[3]='';
$onclic[4]='ejecutar_ajax("calificacion/tarea_detalles.php","id_tipo_mod", "tarea_detalles_mod","");';
$onclic[5]='';
$onclic[6]='';
$onclic[7]='displayCalendar(document.frm.'.$name_input[7].',"yyyy-mm-dd",this);';

$size[0]=''; // tamaño del <input> (NO TOCAR)
$size[1]='';
$size[2]='';
$size[3]='';
$size[4]='50';
$size[5]='100';
$size[6]='100';
$size[7]='10';

$placeholder=array();
$evento=array();
$texto_input=array();

$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
$onsubmit=$obj_var->Llenar_onsubmit($inputs);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)

$n_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit,'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$n_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$n_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_insertar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$mini_onsubmit="ok=validar_sin_submit(";
$mini_onsubmit=$mini_onsubmit.$obj_var->Llenar_varios_onsubmit($inputs);$mini_onsubmit_sin_cerrar=$mini_onsubmit;
$mini_onsubmit=$mini_onsubmit.");";

$mini_onsubmit_sin_cerrar=$mini_onsubmit_sin_cerrar.",'ini','','Rfecha','fin','','Rfecha');";

$n_botones_ayuda=array(); // botonera que va a tener en el encabezado (NO TOCAR) 
$n_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$n_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$n_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$n_label_ayuda=array(); // campos de los <input> (NO TOCAR) 
$n_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'actividad del estudiante');
$n_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'actividad pr&oacute;ximo al que debe pasar el estudiante');
$n_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Es el &uacute;ltimo actividad?: Si o No');
$n_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Abreviatura');
$n_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Nombre que aparece en el certificado de promoci&oacute;n, se compone del curso y la secci&oacute;n. Ejemplo: Tercero de básica elemental');

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

$campos_origen=array();
$campos_origen[0]=$name_input[1];//id_clase
$campos_origen[1]=$name_input[4];//id_tipo
$campos_origen[2]=$name_input[5];//act
$campos_origen[3]=$name_input[6];//des
$campos_origen[4]=$name_input[7];//fec
$campos_origen[5]='sel_filtro_cal';
$campos_origen[6]='hdn_id_asignatura';
$campos_origen[7]='hdn_id_actividad_mod';
$campos_origen[8]='sel_filtro_tip';

$campos_origen[9]='ini';//inicia la tarea
$campos_origen[10]='fin';//finaliza la tarea
$campos_origen[11]='opc';//opcional la tarea
$campos_origen[12]='hdn_txt_descrip';//opcional la tarea

$mini_m_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$mini_m_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>"if(document.getElementById('txt_descrip')){".$mini_onsubmit_sin_cerrar."} else {".$mini_onsubmit."} if(ok==0)return false;if(document.getElementById('txt_descrip'))document.frm.hdn_txt_descrip.value=encodeURIComponent(CKEDITOR.instances.txt_descrip.getData());ejecutar_ajax('calificacion/mod_".$elemento.".php','".implode(",", $campos_origen)."','contenido_grid_calificaciones');",'src'=>'../../../img/general/guardar_mini.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'Insertar');
$mini_m_botones[1]=array('target'=>'_self','href'=>'#close','onclic'=>'vaciar_tmp();','src'=>'../../../img/general/cerrar_mini.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');

$m_botones_ayuda=array(); // botonera en el encabezado (NO TOCAR) 
$m_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$m_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$m_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$m_label_ayuda=array(); // campos de los <input> (NO TOCAR)
$m_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'actividad del estudiante');
$m_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'actividad pr&oacute;ximo al que debe pasar el estudiante');
$m_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Es el &uacute;ltimo actividad?: Si o No');
$m_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Abreviatura');
$m_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Nombre que aparece en el certificado de promoci&oacute;n, se compone del curso y la secci&oacute;n. Ejemplo: Tercero de básica elemental');


//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>