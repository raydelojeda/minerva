<?php
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($_GET["var"]))//$_GET["var"] se envia en el onclick de boton de ayuda, si existe que no modifique la variable $x, asi puede incluir clases_var.inc.php (NO TOCAR)
if(!isset($x))$x="../../../";// (NO TOCAR)
include_once($x."config/clases_var.inc.php");// (NO TOCAR)
if(!isset($obj_var))$obj_var = new clases_var();// (NO TOCAR)
$_SESSION["modulo"]="cont";

// declaraciones
$datos="";// (NO TOCAR)
$pag=1;// (NO TOCAR)
$cadenacheckboxp="";// (NO TOCAR)
$l_info_emergente="";// (NO TOCAR)
$mensaje="";// (NO TOCAR)
$options="";// (NO TOCAR)
// declaraciones


$elemento_titulo="de fecha de clase"; // para el título
$elemento="clase_inasistencia"; // elemento o nomenclador al que se accede
$camino="pag/cont/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/cont/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a los puntos de venta y personas, registrados en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="clase_inasistencia";// tabla de la BD

$field[0]='id_grupos_clientes'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]=$tabla.'.id_grupo_cliente';
$field[2]="concat(punto_venta11, ' - ',grupo_cliente)";
$field[3]=$tabla.'.id_cliente';
$field[4]="concat(persona.identificacion,' - ',persona.primer_nombre,' ',persona.segundo_nombre,' ',persona.primer_apellido,' ',persona.segundo_apellido)";
$field[5]='activo';

$alias_col=array();
$alias_col[0]='id_grupos_clientes';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='id_clasee';
$alias_col[2]='clasee';
$alias_col[3]='id_ss';
$alias_col[4]='subp';
$alias_col[5]='fechaa';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Grupo para facturaci&oacute;n';
$columna[2]='Grupo para facturaci&oacute;n';
$columna[3]='Consumidor';
$columna[4]='Consumidor';
$columna[5]='Activo';

$field_col[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$field_col[1]=$alias_col[1];
$field_col[2]=$alias_col[2];
$field_col[3]=$alias_col[3];
$field_col[4]=$alias_col[4];
$field_col[5]=$alias_col[5];

$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]='';
$info_emerg[2]=1;
$info_emerg[3]='';
$info_emerg[4]=1;
$info_emerg[5]=1;

$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]='';
$info_col[2]=1;
$info_col[3]='';
$info_col[4]=1;
$info_col[5]=1;

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='';
$ancho[2]='38%';
$ancho[3]='';
$ancho[4]='50%';
$ancho[5]='10%';

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
$l_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Grupos y personas para facturaci&oacute;n');
$l_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Consumidor');
$l_label_ayuda[2]=array('texto'=>$columna[5],'exp'=>'Activo el consumidor para facturaci&oacute;n dentro del grupo?: Si o No');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Nuevo','accion'=>'Insertar');
$l_botones[1]=array('target'=>'_self','href'=>'new_'.$elemento.'2.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Gestionar','accion'=>'Insertar');
$l_botones[2]=array('target'=>'_self','href'=>'#','onclic'=>'modif(\'mod_'.$elemento.'.php\')','src'=>$x.'img/general/Editar.png','nombre'=>'editar','texto'=>'Editar','accion'=>'Editar');
$l_botones[3]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'../../../plantillas/eliminar.php\')','src'=>$x.'img/general/eliminar.png','nombre'=>'eliminar','texto'=>'Eliminar','accion'=>'Eliminar');
$l_botones[4]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'imp_'.$elemento.'.php\');','src'=>$x.'img/general/imprimir.png','nombre'=>'imprimir','texto'=>'Imprimir','accion'=>'Imprimir');
$l_botones[5]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'exp_'.$elemento.'.php\');','src'=>$x.'img/general/exportar_csv.png','nombre'=>'exportar_csv','texto'=>'Exportar','accion'=>'Exportar');
$l_botones[6]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_listar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
$insert_field=array();
$insert_field[0]='id_clase_inasistencia'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='id_clase'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='';
$insert_field[3]='id_subperiodo_evaluativo';
$insert_field[4]='';
$insert_field[5]='fecha';
$insert_field[6]='tema_impartir';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[1];
$insert_alias[2]='';
$insert_alias[3]=$alias_col[3];
$insert_alias[4]='';
$insert_alias[5]=$alias_col[5];
$insert_alias[6]='tema';

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[2];
$name_input[2]=$alias_col[2]; 
$name_input[3]=$alias_col[4];
$name_input[4]=$alias_col[4];
$name_input[5]=$alias_col[5];
$name_input[6]='tema';

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[2]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[2];
$label_input[3]=$columna[4];
$label_input[4]='Subper&iacute;odo';
$label_input[5]='Fecha';
$label_input[6]='Tema a impartir';

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]='';
$field_unico[2]='';
$field_unico[3]='';
$field_unico[4]='';
$field_unico[5]='';
$field_unico[6]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='hidden';
$tipo_input[2]='';
$tipo_input[3]='';
$tipo_input[4]='select_1_valor';
$tipo_input[5]='input';
$tipo_input[6]='input';

// valores que va a tomar el campo tipo <select> en cada <option>
$f=4;

$sql_sub="SELECT n_subperiodo_evaluativo.id_subperiodo_evaluativo AS id_ss, concat(subperiodo_evaluativo,' (',abv_subperiodo,')') as subp
FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica 
WHERE 1 
AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo 
AND n_periodo_lectivo.id_periodo_lectivo=n_periodo_evaluativo.id_periodo_lectivo 
AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica 
AND n_conf_academica.activa='1' AND n_subperiodo_evaluativo.id_subperiodo_evaluativo='".$sel_filtro_asis."'";//print $sql_sub;
$combo_sql[$f] = $sql_sub;

$opt_name=array();
$opt_name[$f][0]='subp';//dato que va a mostrar al persona ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$f][1]='';//Además puedes tener del campo de la tabla en caso de selectBD
$opt_name[$f][2]='';
$opt_name[$f][3]='';

$opt_value=array();
$opt_value[$f][0]='id_ss';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$f][1]='';
$opt_value[$f][2]='';
$opt_value[$f][3]='';

$opt_sel=array();
$opt_sel[$f][0]='id_ss';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$f][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
$opt_sel[$f][2]='';
$opt_sel[$f][3]='';

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='';
$dato_permit[2]='';
$dato_permit[3]='';
$dato_permit[4]='Rselec';
$dato_permit[5]='Rfecha';
$dato_permit[6]='varchar';

$value_input=array();
$value_input[0]='';
if(isset($mod))$value_input[1]=$mod;else $value_input[1]='';
$value_input[2]='';
$value_input[3]='';
$value_input[4]='';
$value_input[5]=date('Y-m-d');
$value_input[6]='';

$onclic=array();
$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='';
$onclic[3]='';
$onclic[4]='';
$onclic[5]='displayCalendar(document.frm.'.$name_input[5].',"yyyy-mm-dd",this);';
$onclic[6]='';

$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='';
$size[2]='50';
$size[3]='';
$size[4]='50';
$size[5]='50';
$size[6]='100';

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
$campos_origen[0]=$name_input[2];//id_clase
$campos_origen[1]=$name_input[4];//id_tipo
$campos_origen[2]=$name_input[5];//fec
$campos_origen[3]=$name_input[6];//fec
$campos_origen[4]='sel_filtro_asis';
$campos_origen[5]='sel_filtro_asis';

$campos_origen_limpiar=array();
$campos_origen_limpiar[0]=$name_input[5];
$campos_origen_limpiar[1]=$name_input[6];

$mini_n_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$mini_n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$mini_onsubmit."if(ok==0)return false;ejecutar_ajax('asistencia/ins_".$elemento.".php','".implode(",", $campos_origen)."','contenido_grid_asistencias');limpiar_campos(String('".implode(",", $campos_origen_limpiar)."').split(','));",'src'=>'../../../img/general/guardar_mini.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'Insertar');
$mini_n_botones[1]=array('target'=>'_self','href'=>'#close','onclic'=>'','src'=>'../../../img/general/cerrar_mini.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');

$n_botones_ayuda=array(); // botonera que va a tener en el encabezado (NO TOCAR) 
$n_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$n_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$n_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$n_label_ayuda=array(); // campos de los <input> (NO TOCAR) 
$n_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Grupos y personas para facturaci&oacute;n');
$n_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Consumidor');
$n_label_ayuda[2]=array('texto'=>$columna[5],'exp'=>'Activo el consumidor para facturaci&oacute;n dentro del grupo?: Si o No');

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
$m_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Grupos y personas para facturaci&oacute;n');
$m_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Consumidor');
$m_label_ayuda[2]=array('texto'=>$columna[5],'exp'=>'Activo el consumidor para facturaci&oacute;n dentro del grupo?: Si o No');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>