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


$elemento_titulo="de ingreso o salida de la instituci&oacute;n"; // para el título
$elemento="ingreso_salida"; // elemento o nomenclador al que se accede
$camino="pag/rrhh/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/rrhh/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a los de ingresos o salidas registrados en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="ingreso_salida";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='empleado';
$tabla_anidada[1]='n_causa_ing_sal';

$tabla_anidada2[0]='persona';

$where=' AND empleado.id_persona=persona.id_persona';

$campo_anidado=array();
$campo_anidado[0]='id_empleado';
$campo_anidado[1]='id_causa_ing_sal';

$order=" primer_apellido,segundo_apellido,primer_nombre,segundo_nombre DESC";

$field[0]=$tabla.'.id_ingreso_salida'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]=$tabla.'.id_empleado';
$field[2]=$tabla_anidada2[0].'.identificacion';
$field[3]=$tabla_anidada2[0].'.primer_nombre';
$field[4]=$tabla_anidada2[0].'.segundo_nombre';
$field[5]=$tabla_anidada2[0].'.primer_apellido';
$field[6]=$tabla_anidada2[0].'.segundo_apellido';
$field[7]='fecha_ing_sal';
$field[8]='observacion';
$field[9]=$tabla.'.id_causa_ing_sal';
$field[10]='causa_ing_sal';
$field[11]='baja';

$field_busqueda=array();
$field_busqueda[0]='persona.primer_nombre'; 
$field_busqueda[1]='persona.segundo_nombre';
$field_busqueda[2]="persona.primer_apellido";
$field_busqueda[3]='persona.identificacion';
$field_busqueda[4]="persona.segundo_apellido";
$field_busqueda[5]='causa_ing_sal';
$field_busqueda[6]='baja';

$alias_col=array();
$alias_col[0]='ID_INGRESO_SALIDA';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='ID_EMPLEADO';
$alias_col[2]='IDENTIFICACION';
$alias_col[3]='PRIMER_NOMBRE';
$alias_col[4]='SEGUNDO_NOMBRE';
$alias_col[5]='PRIMER_APELLIDO';
$alias_col[6]='SEGUNDO_APELLIDO';
$alias_col[7]='FECHA';
$alias_col[8]='OBSERVACION';
$alias_col[9]='ID_CAUSA';
$alias_col[10]='CAUSA';
$alias_col[11]='baja';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Identidicaci&oacute;n';
$columna[2]='Identidicaci&oacute;n';
$columna[3]='Primer nombre';
$columna[4]='Segundo nombre';
$columna[5]='Primer apellido';
$columna[6]='Segundo apellido';
$columna[7]='Fecha';
$columna[8]='Observaci&oacute;n';
$columna[9]='Causa';
$columna[10]='Causa';
$columna[11]='Baja';

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

$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]='';
$info_emerg[2]=1;
$info_emerg[3]=1;
$info_emerg[4]=1;
$info_emerg[5]=1;
$info_emerg[6]=1;
$info_emerg[7]=1;
$info_emerg[8]=1;
$info_emerg[9]='';
$info_emerg[10]=1;
$info_emerg[11]=2;

$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]='';
$info_col[2]=1;
$info_col[3]=1;
$info_col[4]=1;
$info_col[5]=1;
$info_col[6]=1;
$info_col[7]=1;
$info_col[8]=1;
$info_col[9]='';
$info_col[10]=1;
$info_col[11]=2;

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='';
$ancho[2]='6%';
$ancho[3]='10%';
$ancho[4]='10%';
$ancho[5]='11%';
$ancho[6]='11%';
$ancho[7]='8%';
$ancho[8]='20%';
$ancho[9]='';
$ancho[10]='16%';
$ancho[11]='6%';

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
$l_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Identidicaci&oacute;n del empleado');
$l_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Primer nombre del empleado');
$l_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Segundo nombre del empleado');
$l_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Primer apellido del empleado');
$l_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Segundo apellido del empleado');
$l_label_ayuda[5]=array('texto'=>$columna[7],'exp'=>'Fecha de entrada o salida del empleado');
$l_label_ayuda[6]=array('texto'=>$columna[8],'exp'=>'Observaci&oacute;n');
$l_label_ayuda[7]=array('texto'=>$columna[10],'exp'=>'Causa de la entrada o salida');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Nuevo','accion'=>'Insertar');
$l_botones[1]=array('target'=>'_self','href'=>'#','onclic'=>'modif(\'mod_'.$elemento.'.php\')','src'=>$x.'img/general/Editar.png','nombre'=>'editar','texto'=>'Editar','accion'=>'Editar');
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

$insert_field[0]='id_ingreso_salida'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='id_empleado'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='';
$insert_field[3]='id_causa_ing_sal';
$insert_field[4]='';
$insert_field[5]='fecha_ing_sal';
$insert_field[6]='observacion';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[1];
$insert_alias[2]='';
$insert_alias[3]=$alias_col[9];
$insert_alias[4]='';
$insert_alias[5]=$alias_col[7];
$insert_alias[6]=$alias_col[8];

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[2]; 
$name_input[2]=$alias_col[2]; 
$name_input[3]=$alias_col[10]; 
$name_input[4]=$alias_col[10]; 
$name_input[5]=$alias_col[7]; 
$name_input[6]=$alias_col[8]; 

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]='Empleado'; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]='Empleado';
$label_input[3]=$columna[10];
$label_input[4]=$columna[10];
$label_input[5]=$columna[7];
$label_input[6]=$columna[8];

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
$tipo_input[1]='';
$tipo_input[2]='selectBD';
$tipo_input[3]='';
$tipo_input[4]='selectBD';
$tipo_input[5]='input';
$tipo_input[6]='input';

// valores que va a tomar el campo tipo <select> en cada <option>
$e=2;
$f=4;
$g=11;

$opt_name=array();$opt_value=array();$opt_sel=array();
$combo_sql[$e] = "SELECT id_empleado as ID_EMPLEADO, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as EMPLEADO FROM persona, empleado WHERE empleado.id_persona=persona.id_persona ORDER BY primer_apellido, segundo_apellido";

$opt_name[$e][0]='EMPLEADO';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$e][0]='ID_EMPLEADO';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$e][0]='ID_EMPLEADO';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$f] = "select id_causa_ing_sal as ID_CAUSA, causa_ing_sal as CAUSA FROM n_causa_ing_sal";

$opt_name[$f][0]='CAUSA';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$f][0]='ID_CAUSA';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$f][0]='ID_CAUSA';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$g] = "";

$opt_name[$g][0]='<img width=10px src=../../../img/general/si.png>';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$g][1]='<img width=10px src=../../../img/general/no.png>';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$g][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$g][1]='0';

$opt_sel[$g][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$g][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='';
$dato_permit[2]='Rselec';
$dato_permit[3]='';
$dato_permit[4]='Rselec';
$dato_permit[5]='Rfecha';
$dato_permit[6]='input';

$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='';
$value_input[2]='';
$value_input[3]='';
$value_input[4]='';
$value_input[5]=date('Y-m-d');
$value_input[6]='';

$texto_input=array();
$placeholder=array();
$evento=array();

$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='';
$onclic[3]='';
$onclic[4]='';
$onclic[5]='displayCalendar(document.frm.'.$name_input[5].',"yyyy-m-d",this);';
$onclic[6]='';

$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='50';
$size[2]='50';
$size[3]='50';
$size[4]='50';
$size[5]='10';
$size[6]='200';

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
$n_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Identidicaci&oacute;n del empleado');
$n_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Primer nombre del empleado');
$n_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Segundo nombre del empleado');
$n_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Primer apellido del empleado');
$n_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Segundo apellido del empleado');
$n_label_ayuda[5]=array('texto'=>$columna[7],'exp'=>'Fecha de entrada o salida del empleado');
$n_label_ayuda[6]=array('texto'=>$columna[8],'exp'=>'Observaci&oacute;n');
$n_label_ayuda[7]=array('texto'=>$columna[10],'exp'=>'Causa de la entrada o salida');

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
$m_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Identidicaci&oacute;n del empleado');
$m_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Primer nombre del empleado');
$m_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Segundo nombre del empleado');
$m_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Primer apellido del empleado');
$m_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Segundo apellido del empleado');
$m_label_ayuda[5]=array('texto'=>$columna[7],'exp'=>'Fecha de entrada o salida del empleado');
$m_label_ayuda[6]=array('texto'=>$columna[8],'exp'=>'Observaci&oacute;n');
$m_label_ayuda[7]=array('texto'=>$columna[10],'exp'=>'Causa de la entrada o salida');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>