<?php
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($_GET["var"]))//$_GET["var"] se envia en el onclick de boton de ayuda, si existe que no modifique la variable $x, asi puede incluir clases_var.inc.php (NO TOCAR)
if(!isset($x))$x="../../../";// (NO TOCAR)
include_once($x."config/clases_var.inc.php");// (NO TOCAR)
if(!isset($obj_var))$obj_var = new clases_var();// (NO TOCAR)

$_SESSION["modulo"]="comu";

// declaraciones
$datos="";// (NO TOCAR)
$pag=1;// (NO TOCAR)
$cadenacheckboxp="";// (NO TOCAR)
$l_info_emergente="";// (NO TOCAR)
$mensaje="";// (NO TOCAR)
$options="";// (NO TOCAR)
// declaraciones

$elemento_titulo="de bandeja de entrada"; // para el título
$elemento="notificacion"; // elemento o nomenclador al que se accede
$camino="pag/comu/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/comu/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a los mensajes registrados en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="recibidos";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='notificacion';

$tabla_anidada2[0]='persona AS remit';
$tabla_anidada2[1]='persona AS dest';
$tabla_anidada2[2]='usuario';

$campo_anidado=array();
$campo_anidado[0]='id_notificacion';

$campo_anidado2[0]='id_persona AS id_r';
$campo_anidado2[1]='id_persona AS id_d';
$campo_anidado2[2]='id_usuario';

$where=" AND recibidos.id_persona_remitente=remit.id_persona AND recibidos.id_persona_destinatario=dest.id_persona AND remit.id_persona=usuario.id_persona AND usuario.activo='1'
 AND remit.email!='' AND archivado_remit='0' AND usuario.usuario='".$_SESSION['user']."'";

$order=" fecha_envio ASC";

$field=array();
$field[0]=$tabla.'.id_recibidos'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]='urgente';
$field[2]=$tabla.'.id_persona_destinatario';
$field[3]="concat(dest.primer_apellido,' ',dest.primer_nombre)";
$field[4]='asunto';
$field[5]='fecha_envio';
$field[6]='leido';

$field_busqueda=array();
$field_busqueda[0]='dest.primer_apellido'; 
$field_busqueda[1]='dest.primer_nombre';
$field_busqueda[2]="asunto";
$field_busqueda[3]='fecha_envio';

$alias_col=array();
$alias_col[0]='id_recibidos';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='urg';
$alias_col[2]='id_p';
$alias_col[3]='per';
$alias_col[4]='asu';
$alias_col[5]='fec';
$alias_col[6]='lei';

$columna=array();
$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='';
$columna[2]='Destinatario';
$columna[3]='Destinatario';
$columna[4]='Asunto';
$columna[5]='Fecha';
$columna[6]='No Le&iacute;do';

$field_col=array();
$field_col[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$field_col[1]=$alias_col[1];
$field_col[2]=$alias_col[2];
$field_col[3]=$alias_col[3];
$field_col[4]=$alias_col[4];
$field_col[5]=$alias_col[5];
$field_col[6]=$alias_col[6];

$info_emerg=array();
$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]='';
$info_emerg[2]='';
$info_emerg[3]=1;
$info_emerg[4]=1;
$info_emerg[5]=1;
$info_emerg[6]='';

$info_col=array();
$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]=2;
$info_col[2]='';
$info_col[3]=1;
$info_col[4]=1;
$info_col[5]=1;
$info_col[6]=2;

$ancho=array();
$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='1%';
$ancho[2]='';
$ancho[3]='21%';
$ancho[4]='54%';
$ancho[5]='13%';
$ancho[6]='6%';

$var_mod='';
$columna_suma[0]='';
$href_m='mod_notificacion_enviados.php?mod='; // camino de la pagina para Editar

$id_cadenacheckboxp='';

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Redactar','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Archivar','exp'=>'eliminar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[3]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Remitente');
$l_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Asunto');
$l_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Fecha');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Redactar','accion'=>'Insertar');
$l_botones[1]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'archivar_remit.php\')','src'=>$x.'img/general/eliminar.png','nombre'=>'eliminar','texto'=>'Eliminar','accion'=>'Eliminar');
$l_botones[2]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'imp_'.$elemento.'.php\');','src'=>$x.'img/general/imprimir.png','nombre'=>'imprimir','texto'=>'Imprimir','accion'=>'Imprimir');
$l_botones[3]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'exp_'.$elemento.'.php\');','src'=>$x.'img/general/exportar_csv.png','nombre'=>'exportar_csv','texto'=>'Exportar','accion'=>'Exportar');
$l_botones[4]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_listar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
$insert_field=array();
$insert_field[0]='id_recibidos'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='id_persona_remitente'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='';
$insert_field[3]='asunto';
$insert_field[4]='mensaje';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[1];
$insert_alias[2]='';
$insert_alias[3]=$alias_col[3];
$insert_alias[4]=$alias_col[4];

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[2]; 
$name_input[2]=$alias_col[2]; 
$name_input[3]=$alias_col[3];
$name_input[4]=$alias_col[4];

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[2]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[2];
$label_input[3]=$columna[3];
$label_input[4]=$columna[4];

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]='';
$field_unico[2]='';
$field_unico[3]='';
$field_unico[4]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='';
$tipo_input[2]='selectBD';
$tipo_input[3]='texto';
$tipo_input[4]='texto';

// valores que va a tomar el campo tipo <select> en cada <option>
$f=2;
$j=6;
$y=1;
$combo_sql[$f] = "select id_persona as id_p, concat(primer_apellido,' ',primer_nombre) as per from persona ORDER BY primer_apellido";

$opt_name=array();
$opt_name[$f][0]='per';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
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

$combo_sql[$j] = "";

$opt_name[$j][0]='';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$j][1]='<img width="14px" height="14px" src="../../../img/general/mail.png"/>';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$j][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$j][1]='0';

$opt_sel[$j][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$j][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$y] = "";

$opt_name[$y][0]='<img width="14px" height="14px" src="../../../img/general/importante.png"/>';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$y][1]='';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$y][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$y][1]='0';

$opt_sel[$y][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$y][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit=array();
$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='';
$dato_permit[2]='';
$dato_permit[3]='';
$dato_permit[4]='';

$value_input=array();
$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
if(isset($return[1]))$value_input[1]=$return[1];else $value_input[1]='';
$value_input[2]='';
$value_input[3]='';
$value_input[4]='';

$onclic=array();
$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='';
$onclic[3]='';
$onclic[4]='';

$size=array();
$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='';
$size[2]='';
$size[3]='50';
$size[4]='50';

$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)

$onsubmit="validar_form(";
//$onsubmit=$onsubmit.$obj_var->Llenar_varios_onsubmit($inputs2);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)
//$onsubmit=$onsubmit.','.$obj_var->Llenar_varios_onsubmit($inputs);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)
//$onsubmit=$onsubmit.','.$obj_var->Llenar_varios_onsubmit($inputs3);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)
//$onsubmit=$onsubmit.','.$obj_var->Llenar_varios_onsubmit($inputs4);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)
$onsubmit=$onsubmit.");";

//$onsubmit2='valida_parentesco();';

$n_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit,'src'=>$x.'img/general/guardar.png','nombre'=>'enviar','texto'=>'Enviar','accion'=>'');
$n_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$n_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_insertar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$n_botones_ayuda=array(); // botonera que va a tener en el encabezado (NO TOCAR) 
$n_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$n_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$n_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$n_label_ayuda=array(); // campos de los <input> (NO TOCAR) 
$n_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Remitente');
$n_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Asunto');
$n_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Fecha');
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
$m_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Remitente');
$m_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Asunto');
$m_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Fecha');


//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>