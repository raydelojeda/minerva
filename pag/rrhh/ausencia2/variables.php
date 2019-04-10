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


$elemento_titulo="de solicitud de ausencia o permiso sin revisar"; // para el título
$elemento="ausencia"; // elemento o nomenclador al que se accede
$camino="pag/rrhh/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/rrhh/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a las solicitudes de ausencias o permisos sin revisar registradas en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="ausencia";// tabla de la BD


$tabla_anidada[0]='empleado';
$tabla_anidada[1]='n_causa_ausencia';


$campo_anidado[0]='id_empleado';
$campo_anidado[1]='id_causa_ausencia';


$tabla_anidada2[0]='persona';


$campo_anidado2[0]='id_persona';

$where=" AND empleado.id_persona=persona.id_persona AND revisado=0";

$field[0]='id_ausencia'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[2]='autorizo_ini';
$field[3]='autorizo_fin';
$field[4]='fecha';
$field[5]='justificacion';
$field[1]='doc_justificativo';
$field[6]='recuperable';
$field[7]='con_pago';
$field[8]=$tabla.'.id_empleado';
$field[9]="concat(persona.identificacion,' - ',persona.primer_nombre,' ',persona.segundo_nombre,' ',persona.primer_apellido,' ',persona.segundo_apellido)";
$field[10]=$tabla.'.id_causa_ausencia';
$field[11]='causa_ausencia';


$alias_col[0]='id_ausencia';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[2]='INICIO_AUTORIZO';
$alias_col[3]='FIN_AUTORIZO';
$alias_col[4]='FECHA_SOLICITUD';
$alias_col[5]='JUSTIFICACION';
$alias_col[1]='DOC';
$alias_col[6]='RECUPERABLE';
$alias_col[7]='CON_PAGO';
$alias_col[8]='ID_EMP';
$alias_col[9]='EMPLEADO';
$alias_col[10]='ID_CAU';
$alias_col[11]='CAUSA_AUSENCIA';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[2]='Inicio de ausencia';
$columna[3]='Fin de ausencia';
$columna[4]='Fecha de solicitud';
$columna[5]='Justificaci&oacute;n';
$columna[1]='';
$columna[6]='Recuperable';
$columna[7]='Con pago';
$columna[8]='Empleado';
$columna[9]='Empleado';
$columna[10]='Causa de ausencia';
$columna[11]='Causa de ausencia';


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

$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]='';
$info_emerg[2]=1;
$info_emerg[3]=1;
$info_emerg[4]=1;
$info_emerg[5]=1;
$info_emerg[6]=2;
$info_emerg[7]=2;
$info_emerg[8]='';
$info_emerg[9]=1;
$info_emerg[10]='';
$info_emerg[11]=1;


$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]='img';
$info_col[2]=1;
$info_col[3]=1;
$info_col[4]=1;
$info_col[5]=1;
$info_col[6]=2;
$info_col[7]=2;
$info_col[8]='';
$info_col[9]='';
$info_col[10]='';
$info_col[11]=1;

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='2%';
$ancho[2]='12%';
$ancho[3]='12%';
$ancho[4]='12%';
$ancho[5]='27%';
$ancho[6]='7%';
$ancho[7]='7%';
$ancho[8]='';
$ancho[9]='';
$ancho[10]='';
$ancho[11]='14%';

$var_mod='';
$columna_suma[0]='';
$href_m='mod_ausencia.php?mod='; // camino de la pagina para Editar

$id_cadenacheckboxp='';

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Nuevo','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Editar','exp'=>'Editar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Eliminar','exp'=>'eliminar la informaci&oacute;n');
$l_botones_ayuda[3]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[5]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Documento adjunto relacionado con la ausencia o permiso del empleado');
$l_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Inicio de la ausencia o permiso del empleado');
$l_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Fin de la ausencia o permiso del empleado');
$l_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Fecha de solicitud de la ausencia o permiso');
$l_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Justificaci&oacute;n de la ausencia o permiso declarada por el empleado');
$l_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'Recuperable o no según lo solicitado por el empleado');
$l_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Con pago o no según lo solicitado por el empleado');
$l_label_ayuda[7]=array('texto'=>$columna[9],'exp'=>'Empleado que solicit&oacute; la ausencia o permiso');
$l_label_ayuda[8]=array('texto'=>$columna[10],'exp'=>'Causa de la ausencia declarada por el empleado');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Nuevo','accion'=>'Insertar');
$l_botones[1]=array('target'=>'_self','href'=>'#','onclic'=>'modif(\'mod_ausencia.php\')','src'=>$x.'img/general/Editar.png','nombre'=>'editar','texto'=>'Editar','accion'=>'Editar');
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

$insert_field[0]='id_ausencia'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='autorizo_ini'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='autorizo_fin';
$insert_field[3]='fecha';
$insert_field[4]='justificacion';
$insert_field[5]='doc_justificativo';
$insert_field[6]='recuperable';
$insert_field[7]='con_pago';
$insert_field[8]='id_empleado';
$insert_field[9]='';
$insert_field[10]='id_causa_ausencia';
$insert_field[11]='';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[2];
$insert_alias[2]=$alias_col[3];
$insert_alias[3]=$alias_col[4];
$insert_alias[4]=$alias_col[5];
$insert_alias[5]=$alias_col[1];
$insert_alias[6]=$alias_col[6];
$insert_alias[7]=$alias_col[7];
$insert_alias[8]=$alias_col[8];
$insert_alias[9]='';
$insert_alias[10]=$alias_col[10];
$insert_alias[11]='';

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[2];
$name_input[2]=$alias_col[3];
$name_input[3]=$alias_col[4];
$name_input[4]=$alias_col[5];
$name_input[5]=$alias_col[1];
$name_input[6]=$alias_col[6];
$name_input[7]=$alias_col[7];
$name_input[8]=$alias_col[9];
$name_input[9]=$alias_col[9];
$name_input[10]=$alias_col[11];
$name_input[11]=$alias_col[11];

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[2]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[3];
$label_input[3]=$columna[4];
$label_input[4]=$columna[5];
$label_input[5]=$columna[1];
$label_input[6]=$columna[6];
$label_input[7]=$columna[7];
$label_input[8]=$columna[9];
$label_input[9]=$columna[9];
$label_input[10]=$columna[11];
$label_input[11]=$columna[11];

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]='';
$field_unico[2]='';
$field_unico[3]=2;
$field_unico[4]='';
$field_unico[5]='';
$field_unico[6]='';
$field_unico[7]='';
$field_unico[8]=2;
$field_unico[9]='';
$field_unico[10]=2;
$field_unico[11]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='input';
$tipo_input[2]='input';
$tipo_input[3]='texto_input';
$tipo_input[4]='textarea';
$tipo_input[5]='file';
$tipo_input[6]='select';
$tipo_input[7]='select';
$tipo_input[8]='';
$tipo_input[9]='select_1_valor';
$tipo_input[10]='';
$tipo_input[11]='selectBD';

$folder_file="justificaciones";

// valores que va a tomar el campo tipo <select> en cada <option>

$f=11;
$g=6;
$h=7;
$ff=9;

$combo_sql[$f] = "select id_causa_ausencia as ID_CAU, causa_ausencia as CAUSA_AUSENCIA from n_causa_ausencia";

$opt_name=array();
$opt_name[$f][0]='CAUSA_AUSENCIA';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD

$opt_value=array();
$opt_value[$f][0]='ID_CAU';//value del option, campo de la tabla externa de la consulta del combo

$opt_sel=array();
$opt_sel[$f][0]='ID_CAU';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$g] = "";

$opt_name[$g][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$g][1]='No';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$g][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$g][1]='0';

$opt_sel[$g][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$g][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$h] = "";

$opt_name[$h][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$h][1]='No';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$h][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$h][1]='0';

$opt_sel[$h][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$h][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$ff] = "SELECT empleado.id_empleado as ID_EMP, concat(persona.identificacion,' - ',persona.primer_nombre,' ',persona.segundo_nombre,' ',persona.primer_apellido,' ',persona.segundo_apellido) as EMPLEADO 
FROM persona,empleado,usuario
WHERE persona.id_persona=empleado.id_persona AND persona.id_persona=usuario.id_persona AND usuario='".$_SESSION["user"]."'";

$opt_name[$ff][0]='EMPLEADO';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$ff][0]='ID_EMP';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$ff][0]='ID_EMP';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='Rfecha';
$dato_permit[2]='Rfecha';
$dato_permit[3]='Rfecha';
$dato_permit[4]='varchar';
$dato_permit[5]='varchar';
$dato_permit[6]='Rselec';
$dato_permit[7]='Rselec';
$dato_permit[8]='';
$dato_permit[9]='Rvarchar';
$dato_permit[10]='';
$dato_permit[11]='Rselec';

$texto_input[0]=''; // valor que va a tener el campo a la derecha como texto explicativo, no es necesario k llegue hasta el final
$texto_input[1]='(yyyy-mm-dd hh:mm)';
$texto_input[2]='(yyyy-mm-dd hh:mm)';

$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='';
$value_input[2]='';
$value_input[3]=date('Y-m-d');
$value_input[4]='';
$value_input[5]='';
$value_input[6]='';
$value_input[7]='';
$value_input[8]='';
$value_input[9]='';
$value_input[10]='';
$value_input[11]='';

$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='displayCalendar(document.frm.'.$name_input[1].',"yyyy-m-d hh:ii",this,1);';
$onclic[2]='displayCalendar(document.frm.'.$name_input[2].',"yyyy-m-d hh:ii",this,1);';
$onclic[3]='';
$onclic[4]='';
$onclic[5]='';
$onclic[6]='';
$onclic[7]='';
$onclic[8]='';
$onclic[9]='';
$onclic[10]='';
$onclic[11]='';

$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='20';
$size[2]='20';
$size[3]='10';
$size[4]='200';
$size[5]='50';
$size[6]='50';
$size[7]='50';
$size[8]='50';
$size[9]='';
$size[10]='50';
$size[11]='';



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
$n_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Documento adjunto relacionado con la ausencia o permiso del empleado');
$n_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Inicio de la ausencia o permiso del empleado');
$n_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Fin de la ausencia o permiso del empleado');
$n_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Fecha de solicitud de la ausencia o permiso');
$n_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Justificaci&oacute;n de la ausencia o permiso declarada por el empleado');
$n_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'Recuperable o no según lo solicitado por el empleado');
$n_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Con pago o no según lo solicitado por el empleado');
$n_label_ayuda[7]=array('texto'=>$columna[9],'exp'=>'Empleado que solicit&oacute; la ausencia o permiso');
$n_label_ayuda[8]=array('texto'=>$columna[10],'exp'=>'Causa de la ausencia declarada por el empleado');

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
$m_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Documento adjunto relacionado con la ausencia o permiso del empleado');
$m_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Inicio de la ausencia o permiso del empleado');
$m_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Fin de la ausencia o permiso del empleado');
$m_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Fecha de solicitud de la ausencia o permiso');
$m_label_ayuda[4]=array('texto'=>$columna[5],'exp'=>'Justificaci&oacute;n de la ausencia o permiso declarada por el empleado');
$m_label_ayuda[5]=array('texto'=>$columna[6],'exp'=>'Recuperable o no según lo solicitado por el empleado');
$m_label_ayuda[6]=array('texto'=>$columna[7],'exp'=>'Con pago o no según lo solicitado por el empleado');
$m_label_ayuda[7]=array('texto'=>$columna[9],'exp'=>'Empleado que solicit&oacute; la ausencia o permiso');
$m_label_ayuda[8]=array('texto'=>$columna[10],'exp'=>'Causa de la ausencia declarada por el empleado');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>