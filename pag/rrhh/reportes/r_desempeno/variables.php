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


$elemento_titulo="de evaluaci&oacute;n de desempe&ntilde;o"; // para el título
$elemento="r_desempeno"; // elemento o nomenclador al que se accede
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

$where=" AND empleado.id_persona=persona.id_persona AND desempeno.id_empleado_jefe=emp.id_empleado 
AND emp.id_persona=per.id_persona AND emp.id_persona=usuario.id_persona ORDER BY fecha_ini, ".$tabla_anidada2[0].'.id_persona,'.$tabla.".id_competencia, cod_criterio DESC";

//$where.=" AND usuario='".$_SESSION['user']."'";//die();

//$order=" fecha_ini, ".$tabla_anidada2[0].'.id_persona,'.$tabla.".id_competencia, cod_criterio DESC";
//$ver=500;

$field[0]='id_desempeno'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]=$tabla_anidada2[0].'.id_persona';
$field[2]=$tabla_anidada2[0].'.primer_nombre';
$field[3]=$tabla_anidada2[0].'.segundo_nombre';
$field[4]=$tabla_anidada2[0].'.primer_apellido';
$field[5]=$tabla_anidada2[0].'.segundo_apellido';
$field[6]="concat(fecha_ini,'/',fecha_fin,' - ',persona.identificacion,' - ',persona.primer_nombre,' ',persona.segundo_nombre,' ',persona.primer_apellido,' ',persona.segundo_apellido)";
$field[7]=$tabla.'.id_cargo';
$field[8]='cargo';
$field[9]=$tabla.'.id_criterio';
$field[10]='cod_criterio';
$field[11]='criterio';
$field[12]=$tabla.'.id_evaluacion';
$field[13]='cod_evaluacion';
$field[14]='evaluacion';
$field[15]='valor_e';
$field[16]='exp_eval';
$field[17]=$tabla.'.id_competencia';
$field[18]='competencia';
$field[19]=$tabla.'.id_compromiso';
$field[20]='compromiso';
$field[21]=$tabla.'.id_periodo';
$field[22]="concat(fecha_ini,'/',fecha_fin)";
$field[23]='fecha_conclusion';
$field[24]=$tabla.'.fecha';
$field[25]=$tabla.'.id_empleado_jefe';
$field[26]="concat(per.identificacion,' - ',per.primer_nombre,' ',per.segundo_nombre,' ',per.primer_apellido,' ',per.segundo_apellido)";

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
$alias_col[1]='id_empleado';
$alias_col[2]='primer_n';
$alias_col[3]='segundo_n';
$alias_col[4]='primer_a';
$alias_col[5]='segundo_a';
$alias_col[6]='id';
$alias_col[7]='id_cargo';
$alias_col[8]='cargo';
$alias_col[9]='id_criterio';
$alias_col[10]='cod_criterio';
$alias_col[11]='criterio';
$alias_col[12]='id_evaluacion';
$alias_col[13]='cod_eval';
$alias_col[14]='eval';
$alias_col[15]='valor';
$alias_col[16]='exp_eval';
$alias_col[17]='id_competencia';
$alias_col[18]='competencia';
$alias_col[19]='id_compromiso';
$alias_col[20]='compromiso';
$alias_col[21]='id_periodo';
$alias_col[22]='periodo';
$alias_col[23]='fecha_con';
$alias_col[24]='fecha';
$alias_col[25]='id_empleado_jefe';
$alias_col[26]='empleado_jefe';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Primer nombre';
$columna[2]='Primer nombre';
$columna[3]='Segundo nombre';
$columna[4]='Primer apellido';
$columna[5]='Segundo apellido';
$columna[6]='Per&iacute;odo - persona';
$columna[7]='Cargo';
$columna[8]='Cargo';
$columna[9]='C&oacute;d. de criterio';
$columna[10]='C&oacute;d. de criterio';
$columna[11]='Criterio';
$columna[12]='C&oacute;d. de evaluaci&oacute;n';
$columna[13]='C&oacute;d. de evaluaci&oacute;n';
$columna[14]='Evaluaci&oacute;n';
$columna[15]='Valor de la evaluaci&oacute;n';
$columna[16]='Explicaci&oacute;n de evaluaci&oacute;n';
$columna[17]='Competencia';
$columna[18]='Competencia';
$columna[19]='Compromiso';
$columna[20]='Compromiso';
$columna[21]='Per&iacute;odo evaluado';
$columna[22]='Per&iacute;odo evaluado';
$columna[23]='Fecha conclusi&oacute;n';
$columna[24]='Fecha';
$columna[25]='Evaluador';
$columna[26]='Evaluador';

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
$field_col[25]=$alias_col[25];
$field_col[26]=$alias_col[26];

$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]='';
$info_emerg[2]=1;
$info_emerg[3]=1;
$info_emerg[4]=1;
$info_emerg[5]=1;
$info_emerg[6]=1;
$info_emerg[7]='';
$info_emerg[8]=1;
$info_emerg[9]='';
$info_emerg[10]=1;
$info_emerg[11]=1;
$info_emerg[12]='';
$info_emerg[13]=1;
$info_emerg[14]=1;
$info_emerg[15]=1;
$info_emerg[16]=1;
$info_emerg[17]='';
$info_emerg[18]=1;
$info_emerg[19]='';
$info_emerg[20]=1;
$info_emerg[21]='';
$info_emerg[22]=1;
$info_emerg[23]=1;
$info_emerg[24]=1;
$info_emerg[25]='';
$info_emerg[26]=1;

$info_col[0]=''; // si se muestra o no la columna para listar, diferente de 1, 2 o vacío es para agrupar por un campo las filas, el número deber ser el colspan + 2, que haya número no significa que aparezca en columna
$info_col[1]='';
$info_col[2]='';
$info_col[3]='';
$info_col[4]='';
$info_col[5]='';
$info_col[6]=6;
$info_col[7]='';
$info_col[8]=1;
$info_col[9]='';
$info_col[10]=1;
$info_col[11]='';
$info_col[12]='';
$info_col[13]='';
$info_col[14]='';
$info_col[15]=1;
$info_col[16]='';
$info_col[17]='';
$info_col[18]=1;
$info_col[19]='';
$info_col[20]='';
$info_col[21]='';
$info_col[22]='';
$info_col[23]='';
$info_col[24]=1;
$info_col[25]='';
$info_col[26]='';

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='';
$ancho[2]='';
$ancho[3]='';
$ancho[4]='';
$ancho[5]='';
$ancho[6]='';
$ancho[7]='';
$ancho[8]='25%';
$ancho[9]='';
$ancho[10]='10%';
$ancho[11]='';
$ancho[12]='';
$ancho[13]='';
$ancho[14]='';
$ancho[15]='14%';
$ancho[16]='';
$ancho[17]='';
$ancho[18]='43%';
$ancho[19]='';
$ancho[20]='';
$ancho[21]='';
$ancho[22]='';
$ancho[23]='';
$ancho[24]='7%';
$ancho[25]='';
$ancho[26]='';

$var_mod='';
$columna_suma[0]='';
$href_m=''; // camino de la pagina para Editar

$id_cadenacheckboxp=$alias_col[0];

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Nuevo','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Editar','exp'=>'Editar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[3]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Primer nombre del evaluado');
$l_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Segundo nombre del evaluado');
$l_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Primer apellido del evaluado');
$l_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Segundo apellido del evaluado');
$l_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Identificaci&oacute;n del evaluado');
$l_label_ayuda[5]=array('texto'=>$columna[8],'exp'=>'Cargo del empleado');
$l_label_ayuda[6]=array('texto'=>$columna[10],'exp'=>'C&oacute;digo de criterio');
$l_label_ayuda[7]=array('texto'=>$columna[11],'exp'=>'Criterio');
$l_label_ayuda[8]=array('texto'=>$columna[13],'exp'=>'C&oacute;digo de evaluaci&oacute;n');
$l_label_ayuda[9]=array('texto'=>$columna[14],'exp'=>'Evaluaci&oacute;n');
$l_label_ayuda[10]=array('texto'=>$columna[15],'exp'=>'Valor de la evaluaci&oacute;n');
$l_label_ayuda[11]=array('texto'=>$columna[16],'exp'=>'Explicaci&oacute;n de la evaluaci&oacute;n');
$l_label_ayuda[12]=array('texto'=>$columna[18],'exp'=>'Competencia');
$l_label_ayuda[13]=array('texto'=>$columna[20],'exp'=>'Compromiso del evaluado ');
$l_label_ayuda[14]=array('texto'=>$columna[22],'exp'=>'Fecha inicial y final del per&iacute;odo de evaluaci&oacute;n');
$l_label_ayuda[15]=array('texto'=>$columna[24],'exp'=>'Fecha de conclusi&oacute;n del per&iacute;odo de evaluaci&oacute;n');
$l_label_ayuda[16]=array('texto'=>$columna[24],'exp'=>'Fecha de la evaluaci&oacute;n');
$l_label_ayuda[17]=array('texto'=>$columna[26],'exp'=>'Jefe del evaluado');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
//$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Nuevo','accion'=>'Insertar');
$l_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'planilla_'.$elemento.'.php\')','src'=>$x.'img/general/pdf.png','nombre'=>'editar','texto'=>'Planilla','accion'=>'Imprimir');
$l_botones[1]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'planilla_r_resumen_desempeno.php\')','src'=>$x.'img/general/pdf.png','nombre'=>'editar','texto'=>'Resumen','accion'=>'Imprimir');
//$l_botones[2]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'../../../plantillas/eliminar.php\')','src'=>$x.'img/general/eliminar.png','nombre'=>'eliminar','texto'=>'Eliminar','accion'=>'Eliminar');
$l_botones[2]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'imp_'.$elemento.'.php\');','src'=>$x.'img/general/imprimir.png','nombre'=>'imprimir','texto'=>'Imprimir','accion'=>'Imprimir');
$l_botones[3]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'exp_'.$elemento.'.php\');','src'=>$x.'img/general/exportar_csv.png','nombre'=>'exportar_csv','texto'=>'Exportar','accion'=>'Exportar');
//$l_botones[4]=array('target'=>'_self','href'=>'graf_linea_basica_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/grafico.png','nombre'=>'grafico','texto'=>'Gr&aacute;fico','accion'=>'Visualizar');
$l_botones[4]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_listar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------

$insert_field[0]='id_desempeno'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='id_periodo'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='';
$insert_field[3]='id_empleado';
$insert_field[4]='';
$insert_field[5]='id_cargo';
$insert_field[6]='';
$insert_field[7]='id_competencia';
$insert_field[8]='';
$insert_field[9]='id_criterio';
$insert_field[10]='';
$insert_field[11]='id_evaluacion';
$insert_field[12]='';
$insert_field[13]='id_empleado_jefe';
$insert_field[14]='';
$insert_field[15]='id_compromiso';
$insert_field[16]='';
$insert_field[17]='fecha';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[21];
$insert_alias[2]='';
$insert_alias[3]=$alias_col[1];
$insert_alias[4]='';
$insert_alias[5]=$alias_col[7];
$insert_alias[6]='';
$insert_alias[7]=$alias_col[17];
$insert_alias[8]='';
$insert_alias[9]=$alias_col[9];
$insert_alias[10]='';
$insert_alias[11]=$alias_col[12];
$insert_alias[12]='';
$insert_alias[13]=$alias_col[25];
$insert_alias[14]='';
$insert_alias[15]=$alias_col[19];
$insert_alias[16]='';
$insert_alias[17]=$alias_col[24];

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[21]; 
$name_input[2]=$alias_col[21]; 
$name_input[3]=$alias_col[4]; 
$name_input[4]=$alias_col[4]; 
$name_input[5]=$alias_col[7]; 
$name_input[6]=$alias_col[7]; 
$name_input[7]=$alias_col[18]; 
$name_input[8]=$alias_col[18]; 
$name_input[9]=$alias_col[10]; 
$name_input[10]=$alias_col[10]; 
$name_input[11]=$alias_col[13]; 
$name_input[12]=$alias_col[13]; 
$name_input[13]=$alias_col[26]; 
$name_input[14]=$alias_col[26]; 
$name_input[15]=$alias_col[20];
$name_input[16]=$alias_col[20]; 
$name_input[17]=$alias_col[24]; 

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[21]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[21];
$label_input[3]='Evaluado';
$label_input[4]='Evaluado';
$label_input[5]=$columna[7]." en el momento de la evaluaci&oacute;n";
$label_input[6]=$columna[7];
$label_input[7]=$columna[18];
$label_input[8]=$columna[18];
$label_input[9]=$columna[9];
$label_input[10]=$columna[9];
$label_input[11]=$columna[12];
$label_input[12]=$columna[12];
$label_input[13]=$columna[26];//24
$label_input[14]=$columna[26];
$label_input[15]=$columna[20];//19
$label_input[16]=$columna[20];
$label_input[17]=$columna[24];

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]=2;
$field_unico[2]='';
$field_unico[3]=2;
$field_unico[4]='';
$field_unico[5]='';
$field_unico[6]='';
$field_unico[7]='';
$field_unico[8]='';
$field_unico[9]='';
$field_unico[10]='';
$field_unico[11]='';
$field_unico[12]='';
$field_unico[13]='';
$field_unico[14]='';
$field_unico[15]='';
$field_unico[16]='';
$field_unico[17]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='texto_select';
$tipo_input[2]='';
$tipo_input[3]='texto_select';
$tipo_input[4]='';
$tipo_input[5]='texto_select';
$tipo_input[6]='';
$tipo_input[7]='texto_select';
$tipo_input[8]='';
$tipo_input[9]='texto_select';
$tipo_input[10]='';
$tipo_input[11]='selectBD';
$tipo_input[12]='';
$tipo_input[13]='texto_select';
$tipo_input[14]='';
$tipo_input[15]='texto_select';
$tipo_input[16]='';
$tipo_input[17]='texto';

// valores que va a tomar el campo tipo <select> en cada <option>
$f=1;
$ff=3;
$fff=5;
$c=7;
$fffff=9;
$ffffff=11;
$j=13;
$p=15;
$fffffffff=17;

$combo_sql[$f] = "SELECT id_periodo, concat(fecha_ini,' - ',fecha_fin) AS periodo FROM n_periodo ORDER BY fecha_ini DESC";

$opt_name=array();
$opt_name[$f][0]='periodo';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value=array();
$opt_value[$f][0]='id_periodo';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel=array();
$opt_sel[$f][0]='id_periodo';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$ff] = "SELECT empleado.id_empleado as id_empleado, concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre,' - ',persona.identificacion) as empleado 
FROM persona,empleado,usuario,empleado as emp, persona as per, n_cargo
WHERE persona.id_persona=empleado.id_persona AND per.id_persona=emp.id_persona AND per.id_persona=usuario.id_persona AND empleado.id_cargo_jefe=n_cargo.id_cargo AND usuario='".$_SESSION["user"]."'";

$opt_name[$ff][0]='empleado';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$ff][0]='id_empleado';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$ff][0]='id_empleado';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$fff] = "SELECT n_cargo.id_cargo, cargo FROM n_cargo";//print $combo_sql[$fff];die();

 
$opt_name[$fff][0]='cargo';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$fff][0]='id_cargo';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$fff][0]='id_cargo';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$c] = "select id_competencia as id_competencia, competencia as competencia from n_competencia";

$opt_name[$c][0]='competencia';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$c][0]='id_competencia';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$c][0]='id_competencia';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$fffff] = "select id_criterio as id_criterio, concat(cod_criterio,' - ',criterio) as criterio from n_criterio";

$opt_name[$fffff][0]='criterio';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$fffff][0]='id_criterio';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$fffff][0]='id_criterio';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$ffffff] = "select id_evaluacion as id_evaluacion, concat(cod_evaluacion,' - ',evaluacion) as evaluacion from n_evaluacion";

$opt_name[$ffffff][0]='evaluacion';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$ffffff][0]='id_evaluacion';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$ffffff][0]='id_evaluacion';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$j] = "SELECT id_empleado as id_empleado_jefe, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as empleado 
FROM persona,empleado,usuario
WHERE persona.id_persona=empleado.id_persona AND persona.id_persona=usuario.id_persona AND usuario='".$_SESSION["user"]."'";

$opt_name[$j][0]='empleado';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$j][0]='id_empleado_jefe';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$j][0]='id_empleado_jefe';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$p] = "select id_compromiso as id_compromiso, compromiso as compromiso from compromiso";

$opt_name[$p][0]='compromiso';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$p][0]='id_compromiso';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$p][0]='id_compromiso';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido. Si es texto no es un input (NO TOCAR)
$dato_permit[1]='texto';
$dato_permit[2]='';
$dato_permit[3]='texto';
$dato_permit[4]='';
$dato_permit[5]='texto';
$dato_permit[6]='';
$dato_permit[7]='texto';
$dato_permit[8]='';
$dato_permit[9]='texto';
$dato_permit[10]='';
$dato_permit[11]='Rselec';
$dato_permit[12]='';
$dato_permit[13]='texto';
$dato_permit[14]='';
$dato_permit[15]='texto';
$dato_permit[16]='';
$dato_permit[17]='Rvarchar';

$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='';
$value_input[2]='';
$value_input[3]='';
$value_input[4]='';
$value_input[5]='';
$value_input[6]='';
$value_input[7]='';
$value_input[8]='';
$value_input[9]='';
$value_input[10]='';
$value_input[11]='';
$value_input[12]='';
$value_input[13]='';
$value_input[14]='';
$value_input[15]='';
$value_input[16]='';
$value_input[17]=date('Y-m-d');

$texto_input=array();
$placeholder=array();
$evento=array();

$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='';
$onclic[3]='';
$onclic[4]='';
$onclic[5]='';
$onclic[6]='';
$onclic[7]='';
$onclic[8]='';
$onclic[9]='';
$onclic[10]='';
$onclic[11]='';
$onclic[12]='';
$onclic[13]='';
$onclic[14]='';
$onclic[15]='';
$onclic[16]='';
$onclic[17]='displayCalendar(document.frm.'.$name_input[17].',"yyyy-m-d",this);';

$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='50';
$size[2]='';
$size[3]='50';
$size[4]='';
$size[5]='50';
$size[6]='';
$size[7]='50';
$size[8]='';
$size[9]='100';
$size[10]='';
$size[11]='50';
$size[12]='';
$size[13]='50';
$size[14]='';
$size[15]='50';
$size[16]='';
$size[17]='10';

$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
$onsubmit=$obj_var->Llenar_onsubmit($inputs);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)

$n_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>"javascript:valida_radio();",'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$n_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$n_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_insertar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$n_botones_ayuda=array(); // botonera que va a tener en el encabezado (NO TOCAR) 
$n_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$n_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$n_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$n_label_ayuda=array(); // campos de los <input> (NO TOCAR) 
$n_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Primer nombre del evaluado');
$n_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Segundo nombre del evaluado');
$n_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Primer apellido del evaluado');
$n_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Segundo apellido del evaluado');
$n_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Identificaci&oacute;n del evaluado');
$n_label_ayuda[5]=array('texto'=>$columna[8],'exp'=>'Cargo del empleado');
$n_label_ayuda[6]=array('texto'=>$columna[10],'exp'=>'C&oacute;digo de criterio');
$n_label_ayuda[7]=array('texto'=>$columna[11],'exp'=>'Criterio');
$n_label_ayuda[8]=array('texto'=>$columna[13],'exp'=>'C&oacute;digo de evaluaci&oacute;n');
$n_label_ayuda[9]=array('texto'=>$columna[14],'exp'=>'Evaluaci&oacute;n');
$n_label_ayuda[10]=array('texto'=>$columna[15],'exp'=>'Valor de la evaluaci&oacute;n');
$n_label_ayuda[11]=array('texto'=>$columna[16],'exp'=>'Explicaci&oacute;n de la evaluaci&oacute;n');
$n_label_ayuda[12]=array('texto'=>$columna[18],'exp'=>'Competencia');
$n_label_ayuda[13]=array('texto'=>$columna[20],'exp'=>'Compromiso del evaluado ');
$n_label_ayuda[14]=array('texto'=>$columna[22],'exp'=>'Fecha inicial y final del per&iacute;odo de evaluaci&oacute;n');
$n_label_ayuda[15]=array('texto'=>$columna[24],'exp'=>'Fecha de conclusi&oacute;n del per&iacute;odo de evaluaci&oacute;n');
$n_label_ayuda[16]=array('texto'=>$columna[24],'exp'=>'Fecha de la evaluaci&oacute;n');
$n_label_ayuda[17]=array('texto'=>$columna[26],'exp'=>'Jefe del evaluado');
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
$m_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Primer nombre del evaluado');
$m_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Segundo nombre del evaluado');
$m_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Primer apellido del evaluado');
$m_label_ayuda[3]=array('texto'=>$columna[5],'exp'=>'Segundo apellido del evaluado');
$m_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Identificaci&oacute;n del evaluado');
$m_label_ayuda[5]=array('texto'=>$columna[8],'exp'=>'Cargo del empleado');
$m_label_ayuda[6]=array('texto'=>$columna[10],'exp'=>'C&oacute;digo de criterio');
$m_label_ayuda[7]=array('texto'=>$columna[11],'exp'=>'Criterio');
$m_label_ayuda[8]=array('texto'=>$columna[13],'exp'=>'C&oacute;digo de evaluaci&oacute;n');
$m_label_ayuda[9]=array('texto'=>$columna[14],'exp'=>'Evaluaci&oacute;n');
$m_label_ayuda[10]=array('texto'=>$columna[15],'exp'=>'Valor de la evaluaci&oacute;n');
$m_label_ayuda[11]=array('texto'=>$columna[16],'exp'=>'Explicaci&oacute;n de la evaluaci&oacute;n');
$m_label_ayuda[12]=array('texto'=>$columna[18],'exp'=>'Competencia');
$m_label_ayuda[13]=array('texto'=>$columna[20],'exp'=>'Compromiso del evaluado ');
$m_label_ayuda[14]=array('texto'=>$columna[22],'exp'=>'Fecha inicial y final del per&iacute;odo de evaluaci&oacute;n');
$m_label_ayuda[15]=array('texto'=>$columna[24],'exp'=>'Fecha de conclusi&oacute;n del per&iacute;odo de evaluaci&oacute;n');
$m_label_ayuda[16]=array('texto'=>$columna[24],'exp'=>'Fecha de la evaluaci&oacute;n');
$m_label_ayuda[17]=array('texto'=>$columna[26],'exp'=>'Jefe del evaluado');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>