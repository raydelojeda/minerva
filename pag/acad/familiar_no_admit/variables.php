<?php
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($_GET["var"]))//$_GET["var"] se envia en el onclick de boton de ayuda, si existe que no modifique la variable $x, asi puede incluir clases_var.inc.php (NO TOCAR)
if(!isset($x))$x="../../../";// (NO TOCAR)
include_once($x."config/clases_var.inc.php");// (NO TOCAR)
if(!isset($obj_var))$obj_var = new clases_var();// (NO TOCAR)

include($x."pag/rrhh/persona/variables.php");
$inputs2=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)

$_SESSION["modulo"]="acad";

// declaraciones
$datos="";// (NO TOCAR)
$pag=1;// (NO TOCAR)
$cadenacheckboxp="";// (NO TOCAR)
$l_info_emergente="";// (NO TOCAR)
$mensaje="";// (NO TOCAR)
$options="";// (NO TOCAR)
// declaraciones

$elemento_titulo="de familiar con estudiantes no admitidos en el per&iacute;odo actual"; // para el título
$elemento="familiar_no_admit"; // elemento o nomenclador al que se accede
$camino="pag/acad/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/acad/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a los familiares con estudiantes no admitidos registrados en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="familiar";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='persona';
$tabla_anidada[1]='familiar_estudiante';

$tabla_anidada2[0]='n_pais';
$tabla_anidada2[1]='n_genero';
$tabla_anidada2[2]='n_tipo_sangre';
$tabla_anidada2[3]='n_tipo_identificacion';
$tabla_anidada2[4]='estudiante';

$campo_anidado=array();
$campo_anidado[0]='id_persona';
$campo_anidado[1]='id_familiar';

$campo_anidado2[0]='id_pais';
$campo_anidado2[1]='id_genero';
$campo_anidado2[2]='id_tipo_sangre';
$campo_anidado2[3]='id_tipo_identificacion';
$campo_anidado2[4]='id_estudiante';

$where=' AND n_pais.id_pais=persona.id_pais AND n_genero.id_genero=persona.id_genero AND n_tipo_sangre.id_tipo_sangre=persona.id_tipo_sangre 
AND n_tipo_identificacion.id_tipo_identificacion=persona.id_tipo_identificacion AND estudiante.id_estudiante=familiar_estudiante.id_estudiante 
AND NOT EXISTS (SELECT 1 FROM curso_grado_paralelo_est, grado_paralelo_periodo, n_periodo_academico WHERE 1 AND grado_paralelo_periodo.id_grado_paralelo_periodo=curso_grado_paralelo_est.id_grado_paralelo_periodo
AND n_periodo_academico.id_periodo_academico=grado_paralelo_periodo.id_periodo_academico 
AND curso_grado_paralelo_est.id_estudiante = estudiante.id_estudiante AND n_periodo_academico.activo=1)';

//$order=" per DESC";
$operador='DISTINCT ';

$field=array();
$field[0]=$tabla.'.id_familiar'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]=$tabla.'.id_persona';
$field[2]="concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre,' - ',persona.identificacion)";
$field[3]='identificacion';
$field[4]='fecha_nacimiento';
$field[5]='direccion';
$field[6]='email';
$field[7]='telefono1';
$field[8]='telefono2';
$field[9]='residencia';
$field[10]=$tabla_anidada[0].'.id_pais';
$field[11]='pais';
$field[12]=$tabla_anidada[0].'.id_genero';
$field[13]='genero';
$field[14]=$tabla_anidada[0].'.id_tipo_sangre';
$field[15]='tipo_sangre';
$field[16]=$tabla_anidada[0].'.id_tipo_identificacion';
$field[17]='tipo_identificacion';
$field[18]=$tabla.'.lugar_nacimiento';
$field[19]='profesion';
$field[20]='ocupacion';
$field[21]='empresa_oficina';
$field[22]='dir_trabajo';
$field[23]='tel_trabajo';
$field[24]='camino_foto';

$field_busqueda=array();
$field_busqueda[0]='primer_nombre'; 
$field_busqueda[1]='segundo_nombre';
$field_busqueda[2]="primer_apellido";
$field_busqueda[3]='identificacion';
$field_busqueda[4]="segundo_apellido";
$field_busqueda[5]='direccion';
$field_busqueda[6]='email';
$field_busqueda[7]='telefono1';

$alias_col=array();
$alias_col[0]='id_familiar';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='id_p';
$alias_col[2]='per';
$alias_col[3]='ide';
$alias_col[4]='fec';
$alias_col[5]='dir';
$alias_col[6]='ema';
$alias_col[7]='tel1';
$alias_col[8]='tel2';
$alias_col[9]='res';
$alias_col[10]='id_pais';
$alias_col[11]='pais';
$alias_col[12]='id_g';
$alias_col[13]='gen';
$alias_col[14]='id_t';
$alias_col[15]='tip';
$alias_col[16]='id_i';
$alias_col[17]='tide';
$alias_col[18]='luga';
$alias_col[19]='prof';
$alias_col[20]='ocupa';
$alias_col[21]='empre';
$alias_col[22]='dir_t';
$alias_col[23]='tel_t';
$alias_col[24]='foto';

$columna=array();
$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Familiar';
$columna[2]='Familiar';
$columna[3]='Identificaci&oacute;n';
$columna[4]='Nacimiento';
$columna[5]='Direcci&oacute;n';
$columna[6]='Correo';
$columna[7]='Tel&eacute;fono';
$columna[8]='Celular';
$columna[9]='Residencia';
$columna[10]='Nacionalidad';
$columna[11]='Nacionalidad';
$columna[12]='G&eacute;nero';
$columna[13]='G&eacute;nero';
$columna[14]='Tipo de sangre';
$columna[15]='Tipo de sangre';
$columna[16]='Tipo de identificaci&oacute;n';
$columna[17]='Tipo de identificaci&oacute;n';
$columna[18]='Lugar de nacimiento';
$columna[19]='Profesi&oacute;n';
$columna[20]='Ocupaci&oacute;n';
$columna[21]='Entidad';
$columna[22]='Direcci&oacute;n de trabajo';
$columna[23]='Tel&eacute;fono de trabajo';
$columna[24]='';

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
$field_col[13]=$alias_col[13];
$field_col[14]=$alias_col[14];
$field_col[15]=$alias_col[15];
$field_col[16]=$alias_col[16];
$field_col[17]=$alias_col[17];
$field_col[18]=$alias_col[18];
$field_col[19]=$alias_col[19];
$field_col[20]=$alias_col[20];
$field_col[21]=$alias_col[21];
$field_col[22]=$alias_col[22];
$field_col[23]=$alias_col[23];
$field_col[24]=$alias_col[24];

$info_emerg=array();
$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]='';
$info_emerg[2]=1;
$info_emerg[3]=1;
$info_emerg[4]=1;
$info_emerg[5]='';
$info_emerg[6]=1;
$info_emerg[7]=1;
$info_emerg[8]=1;
$info_emerg[9]=2;
$info_emerg[10]='';
$info_emerg[11]=1;
$info_emerg[12]='';
$info_emerg[13]=1;
$info_emerg[14]='';
$info_emerg[15]=1;
$info_emerg[16]='';
$info_emerg[17]=1;
$info_emerg[18]=1;
$info_emerg[19]=1;
$info_emerg[20]=1;
$info_emerg[21]=1;
$info_emerg[22]='';
$info_emerg[23]=1;
$info_emerg[24]='';

$info_col=array();
$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]='';
$info_col[2]=1;
$info_col[3]='';
$info_col[4]='';
$info_col[5]='';
$info_col[6]=1;
$info_col[7]=1;
$info_col[8]=1;
$info_col[9]='';
$info_col[10]='';
$info_col[11]='';
$info_col[12]='';
$info_col[13]=1;
$info_col[14]='';
$info_col[15]='';
$info_col[16]='';
$info_col[17]='';
$info_col[18]='';
$info_col[19]='';
$info_col[20]='';
$info_col[21]=1;
$info_col[22]='';
$info_col[23]=1;
$info_col[24]='img_doc';

$ancho=array();
$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='';
$ancho[2]='30%';
$ancho[3]='';
$ancho[4]='';
$ancho[5]='';
$ancho[6]='15%';
$ancho[7]='8%';
$ancho[8]='8%';
$ancho[9]='';
$ancho[10]='';
$ancho[11]='';
$ancho[12]='';
$ancho[13]='5%';
$ancho[14]='';
$ancho[15]='';
$ancho[16]='';
$ancho[17]='';
$ancho[18]='';
$ancho[19]='';
$ancho[20]='';
$ancho[21]='21%';
$ancho[22]='';
$ancho[23]='10%';
$ancho[24]='1%';

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
$l_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Familiar');
$l_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Identificaci&oacute;n');
$l_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Nacimiento');
$l_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Direcci&oacute;n de domicilio');
$l_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Correo electr&oacute;nico');
$l_label_ayuda[5]=array('texto'=>$columna[7],'exp'=>'Tel&eacute;fono fijo');
$l_label_ayuda[6]=array('texto'=>$columna[8],'exp'=>'Celular');
$l_label_ayuda[7]=array('texto'=>$columna[9],'exp'=>'Tiene residencia? Si o No');
$l_label_ayuda[8]=array('texto'=>$columna[11],'exp'=>'Nacionalidad');
$l_label_ayuda[9]=array('texto'=>$columna[13],'exp'=>'G&eacute;nero');
$l_label_ayuda[10]=array('texto'=>$columna[15],'exp'=>'Tipo de sangre');
$l_label_ayuda[11]=array('texto'=>$columna[16],'exp'=>'Tipo de identificaci&oacute;n');
$l_label_ayuda[12]=array('texto'=>$columna[17],'exp'=>'Tiene residencia? Si o No');
$l_label_ayuda[13]=array('texto'=>$columna[18],'exp'=>'Lugar de nacimiento');
$l_label_ayuda[14]=array('texto'=>$columna[19],'exp'=>'Profesi&oacute;n');
$l_label_ayuda[15]=array('texto'=>$columna[20],'exp'=>'Ocupaci&oacute;n');
$l_label_ayuda[16]=array('texto'=>$columna[21],'exp'=>'Entidad donde trabaja');
$l_label_ayuda[17]=array('texto'=>$columna[22],'exp'=>'Direcci&oacute;n de trabajo');
$l_label_ayuda[18]=array('texto'=>$columna[23],'exp'=>'Tel&eacute;fono de trabajo');
$l_label_ayuda[19]=array('texto'=>$columna[24],'exp'=>'Foto');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Nuevo','accion'=>'Insertar');
$l_botones[1]=array('target'=>'_self','href'=>'#','onclic'=>'modif(\'mod_'.$elemento.'.php\')','src'=>$x.'img/general/Editar.png','nombre'=>'editar','texto'=>'Editar','accion'=>'Editar');
$l_botones[2]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'eliminar.php\')','src'=>$x.'img/general/eliminar.png','nombre'=>'eliminar','texto'=>'Eliminar','accion'=>'Eliminar');
$l_botones[3]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'imp_'.$elemento.'.php\');','src'=>$x.'img/general/imprimir.png','nombre'=>'imprimir','texto'=>'Imprimir','accion'=>'Imprimir');
$l_botones[4]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'exp_'.$elemento.'.php\');','src'=>$x.'img/general/exportar_csv.png','nombre'=>'exportar_csv','texto'=>'Exportar','accion'=>'Exportar');
$l_botones[5]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_listar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
$insert_field=array();
$insert_field[0]='id_familiar'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='lugar_nacimiento'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='profesion';
$insert_field[3]='ocupacion';
$insert_field[4]='empresa_oficina';
$insert_field[5]='dir_trabajo';
$insert_field[6]='tel_trabajo';
$insert_field[7]='id_persona';
$insert_field[8]='';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[18];
$insert_alias[2]=$alias_col[19];
$insert_alias[3]=$alias_col[20];
$insert_alias[4]=$alias_col[21];
$insert_alias[5]=$alias_col[22];
$insert_alias[6]=$alias_col[23];
$insert_alias[7]=$alias_col[1];
$insert_alias[8]='';

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[18];
$name_input[2]=$alias_col[19];
$name_input[3]=$alias_col[20];
$name_input[4]=$alias_col[21];
$name_input[5]=$alias_col[22];
$name_input[6]=$alias_col[23];
$name_input[7]=$alias_col[2]; 
$name_input[8]=$alias_col[2]; 

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[18];// label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[19];
$label_input[3]=$columna[20];
$label_input[4]=$columna[21];
$label_input[5]=$columna[22];
$label_input[6]=$columna[23];
$label_input[7]=$columna[2];
$label_input[8]=$columna[2];

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]='';
$field_unico[2]='';
$field_unico[3]='';
$field_unico[4]='';
$field_unico[5]='';
$field_unico[6]='';
$field_unico[7]=1;
$field_unico[8]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='input';
$tipo_input[2]='input';
$tipo_input[3]='input';
$tipo_input[4]='input';
$tipo_input[5]='textarea';
$tipo_input[6]='input';
$tipo_input[7]='hidden';
$tipo_input[8]='';
// valores que va a tomar el campo tipo <select> en cada <option>
$f=8;
$j=4;
$h=19;
$r=9;
$combo_sql[$f] = "";

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

$opt_name[$j][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$j][1]='No';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$j][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$j][1]='0';


$opt_sel[$j][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$j][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$h] = "";

$opt_name[$h][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$h][1]='No';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$h][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$h][1]='0';


$opt_sel[$h][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$h][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$r] = "";

$opt_name[$r][0]='Si';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$r][1]='No';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$r][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$r][1]='0';


$opt_sel[$r][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$r][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit=array();
$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='varchar';
$dato_permit[2]='varchar';
$dato_permit[3]='varchar';
$dato_permit[4]='varchar';
$dato_permit[5]='varchar';
$dato_permit[6]='varchar';
$dato_permit[7]='';
$dato_permit[8]='';

$value_input=array();
$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='';
$value_input[2]='';
$value_input[3]='';
$value_input[4]='';
$value_input[5]='';
$value_input[6]='';
if(isset($return[1]))$value_input[7]=$return[1];else $value_input[7]='';
$value_input[8]='';

$onclic=array();
$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='';
$onclic[3]='';
$onclic[4]='';
$onclic[5]='';
$onclic[6]='';
$onclic[7]='';
$onclic[8]='';

$size=array();
$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='50';
$size[2]='50';
$size[3]='50';
$size[4]='50';
$size[5]='50';
$size[6]='15';
$size[7]='';
$size[8]='';

$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)

$onsubmit="validar_form(";
$onsubmit=$onsubmit.$obj_var->Llenar_varios_onsubmit($inputs2);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)
$onsubmit=$onsubmit.','.$obj_var->Llenar_varios_onsubmit($inputs);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)
$onsubmit=$onsubmit.");";

//print $onsubmit;

$n_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit,'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$n_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$n_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_insertar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$n_botones_ayuda=array(); // botonera que va a tener en el encabezado (NO TOCAR) 
$n_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$n_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$n_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$n_label_ayuda=array(); // campos de los <input> (NO TOCAR) 
$n_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Familiar');
$n_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Identificaci&oacute;n');
$n_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Nacimiento');
$n_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Direcci&oacute;n de domicilio');
$n_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Correo electr&oacute;nico');
$n_label_ayuda[5]=array('texto'=>$columna[7],'exp'=>'Tel&eacute;fono fijo');
$n_label_ayuda[6]=array('texto'=>$columna[8],'exp'=>'Celular');
$n_label_ayuda[7]=array('texto'=>$columna[9],'exp'=>'Tiene residencia? Si o No');
$n_label_ayuda[8]=array('texto'=>$columna[11],'exp'=>'Nacionalidad');
$n_label_ayuda[9]=array('texto'=>$columna[13],'exp'=>'G&eacute;nero');
$n_label_ayuda[10]=array('texto'=>$columna[15],'exp'=>'Tipo de sangre');
$n_label_ayuda[11]=array('texto'=>$columna[16],'exp'=>'Tipo de identificaci&oacute;n');
$n_label_ayuda[12]=array('texto'=>$columna[17],'exp'=>'Tiene residencia? Si o No');
$n_label_ayuda[13]=array('texto'=>$columna[18],'exp'=>'Lugar de nacimiento');
$n_label_ayuda[14]=array('texto'=>$columna[19],'exp'=>'Profesi&oacute;n');
$n_label_ayuda[15]=array('texto'=>$columna[20],'exp'=>'Ocupaci&oacute;n');
$n_label_ayuda[16]=array('texto'=>$columna[21],'exp'=>'Entidad donde trabaja');
$n_label_ayuda[17]=array('texto'=>$columna[22],'exp'=>'Direcci&oacute;n de trabajo');
$n_label_ayuda[18]=array('texto'=>$columna[23],'exp'=>'Tel&eacute;fono de trabajo');
$n_label_ayuda[19]=array('texto'=>$columna[24],'exp'=>'Foto');

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
$m_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'Familiar');
$m_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Identificaci&oacute;n');
$m_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Nacimiento');
$m_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Direcci&oacute;n de domicilio');
$m_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Correo electr&oacute;nico');
$m_label_ayuda[5]=array('texto'=>$columna[7],'exp'=>'Tel&eacute;fono fijo');
$m_label_ayuda[6]=array('texto'=>$columna[8],'exp'=>'Celular');
$m_label_ayuda[7]=array('texto'=>$columna[9],'exp'=>'Tiene residencia? Si o No');
$m_label_ayuda[8]=array('texto'=>$columna[11],'exp'=>'Nacionalidad');
$m_label_ayuda[9]=array('texto'=>$columna[13],'exp'=>'G&eacute;nero');
$m_label_ayuda[10]=array('texto'=>$columna[15],'exp'=>'Tipo de sangre');
$m_label_ayuda[11]=array('texto'=>$columna[16],'exp'=>'Tipo de identificaci&oacute;n');
$m_label_ayuda[12]=array('texto'=>$columna[17],'exp'=>'Tiene residencia? Si o No');
$m_label_ayuda[13]=array('texto'=>$columna[18],'exp'=>'Lugar de nacimiento');
$m_label_ayuda[14]=array('texto'=>$columna[19],'exp'=>'Profesi&oacute;n');
$m_label_ayuda[15]=array('texto'=>$columna[20],'exp'=>'Ocupaci&oacute;n');
$m_label_ayuda[16]=array('texto'=>$columna[21],'exp'=>'Entidad donde trabaja');
$m_label_ayuda[17]=array('texto'=>$columna[22],'exp'=>'Direcci&oacute;n de trabajo');
$m_label_ayuda[18]=array('texto'=>$columna[23],'exp'=>'Tel&eacute;fono de trabajo');
$m_label_ayuda[19]=array('texto'=>$columna[24],'exp'=>'Foto');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>