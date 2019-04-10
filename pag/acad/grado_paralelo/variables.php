<?php
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�

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


$elemento_titulo="del grado y paralelo"; // para el t�tulo
$elemento="grado_paralelo"; // elemento o nomenclador al que se accede
$camino="pag/acad/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/acad/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto al grado y paralelo registrados seg&uacute;n el cargo en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="n_grado_paralelo";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='n_grado';
$tabla_anidada[1]='n_tipo_grado';
$tabla_anidada[2]='n_paralelo';
$tabla_anidada[3]='n_responsable_acta';

$tabla_anidada2[0]='n_seccion_academica';

$campo_anidado=array();
$campo_anidado[0]='id_grado';
$campo_anidado[1]='id_tipo_grado';
$campo_anidado[2]='id_paralelo';
$campo_anidado[3]='id_responsable_acta';

$campo_anidado2[0]='id_seccion_academica';

$where=' AND n_seccion_academica.id_seccion_academica=n_grado.id_seccion_academica';

$field=array();
$field[0]='id_grado_paralelo'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]=$tabla.'.id_grado';
$field[2]="concat(seccion_academica,' - ',grado)";
$field[3]=$tabla.'.id_tipo_grado';
$field[4]="tipo_grado";
$field[5]=$tabla.'.id_paralelo';
$field[6]='paralelo';
$field[7]=$tabla.'.id_responsable_acta';
$field[8]="concat(nombre,' - ',cargo)";
$field[9]=$tabla.'.abreviatura';
$field[10]='nombre_ministerio';

$alias_col=array();
$alias_col[0]='id_grado_paralelo';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='id_grado';
$alias_col[2]='grado';
$alias_col[3]='id_tipo_grado';
$alias_col[4]='tipo_grado';
$alias_col[5]='id_paralelo';
$alias_col[6]='paralelo';
$alias_col[7]='id_responsable_acta';
$alias_col[8]='nombre';
$alias_col[9]='abrev';
$alias_col[10]='nombre_ministerio';

$field_busqueda=array();
$field_busqueda[0]=''; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field_busqueda[1]='';
$field_busqueda[2]="seccion_academica";
$field_busqueda[3]='';
$field_busqueda[4]="tipo_grado";
$field_busqueda[5]='';
$field_busqueda[6]='paralelo';
$field_busqueda[7]='';
$field_busqueda[8]="nombre";
$field_busqueda[9]=$tabla.'.abreviatura';
$field_busqueda[10]='nombre_ministerio';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Curso';
$columna[2]='Curso';
$columna[3]='Tipo de curso';
$columna[4]='Tipo de curso';
$columna[5]='Paralelo';
$columna[6]='Paralelo';
$columna[7]='Responsable de acta';
$columna[8]='Responsable de acta';
$columna[9]='Abreviatura';
$columna[10]='Nombre del ministerio';

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

$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]='';
$info_emerg[2]=1;
$info_emerg[3]='';
$info_emerg[4]=1;
$info_emerg[5]='';
$info_emerg[6]=1;
$info_emerg[7]='';
$info_emerg[8]=1;
$info_emerg[9]=1;
$info_emerg[10]=1;

$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]='';
$info_col[2]=1;
$info_col[3]='';
$info_col[4]=1;
$info_col[5]='';
$info_col[6]=1;
$info_col[7]='';
$info_col[8]=1;
$info_col[9]=1;
$info_col[10]=1;

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='';
$ancho[2]='20%';
$ancho[3]='';
$ancho[4]='10%';
$ancho[5]='';
$ancho[6]='10%';
$ancho[7]='';
$ancho[8]='20%';
$ancho[9]='10%';
$ancho[10]='25%';

$var_mod='';
$columna_suma[0]='';
$href_m='mod_grado_paralelo.php?mod='; // camino de la pagina para Editar

$id_cadenacheckboxp='';

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Nuevo','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Editar','exp'=>'Editar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Eliminar','exp'=>'eliminar la informaci&oacute;n');
$l_botones_ayuda[3]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[5]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Curso');
$l_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Tipo de curso');
$l_label_ayuda[2]=array('texto'=>$columna[6],'exp'=>'Paralelo');
$l_label_ayuda[3]=array('texto'=>$columna[8],'exp'=>'Responsable de acta');
$l_label_ayuda[4]=array('texto'=>$columna[9],'exp'=>'Abreviatura');
$l_label_ayuda[5]=array('texto'=>$columna[10],'exp'=>'Nombre del ministerio');

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
$insert_field=array();
$insert_field[0]='id_grado_paralelo'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='id_grado';
$insert_field[2]='';
$insert_field[3]='id_tipo_grado';
$insert_field[4]='';
$insert_field[5]='id_paralelo';
$insert_field[6]='';
$insert_field[7]='id_responsable_acta';
$insert_field[8]='';
$insert_field[9]='abreviatura';
$insert_field[10]='nombre_ministerio'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[1];
$insert_alias[2]='';
$insert_alias[3]=$alias_col[3];
$insert_alias[4]='';
$insert_alias[5]=$alias_col[5];
$insert_alias[6]='';
$insert_alias[7]=$alias_col[7];
$insert_alias[8]='';
$insert_alias[9]=$alias_col[9];
$insert_alias[10]=$alias_col[10];

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[2]; 
$name_input[2]=$alias_col[2]; 
$name_input[3]=$alias_col[4]; 
$name_input[4]=$alias_col[4]; 
$name_input[5]=$alias_col[6]; 
$name_input[6]=$alias_col[6];
$name_input[7]=$alias_col[8];
$name_input[8]=$alias_col[8];
$name_input[9]=$alias_col[9];
$name_input[10]=$alias_col[10];

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[1]; // label de los inputs, se utiliza ya que en el listar puede haber campos de m�s seg�n las otras tablas anidadas
$label_input[2]=$columna[2];
$label_input[3]=$columna[3];
$label_input[4]=$columna[4];
$label_input[5]=$columna[5];
$label_input[6]=$columna[6];
$label_input[7]=$columna[7];
$label_input[8]=$columna[8];
$label_input[9]=$columna[9];
$label_input[10]=$columna[10];

$field_unico=array();
$field_unico[0]=''; // fields que deben ser �nicos en la tabla en la BD, diferente de 1 y vac�o es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]=2;
$field_unico[2]='';
$field_unico[3]=2;
$field_unico[4]='';
$field_unico[5]=2;
$field_unico[6]='';
$field_unico[7]='';
$field_unico[8]='';
$field_unico[9]=1;
$field_unico[10]='';

$texto_input=array();
$placeholder=array();
$evento=array();

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='';
$tipo_input[2]='selectBD';
$tipo_input[3]='';
$tipo_input[4]='selectBD';
$tipo_input[5]='';
$tipo_input[6]='selectBD';
$tipo_input[7]='';
$tipo_input[8]='selectBD';
$tipo_input[9]='input';
$tipo_input[10]='input';

// valores que va a tomar el campo tipo <select> en cada <option>
$f=2;
$ff=4;
$g=6;
$gs=8;

$combo_sql[$f] = "select id_grado as id_grado, concat(seccion_academica,' - ',grado) as grado from n_seccion_academica, n_grado WHERE 1 AND n_seccion_academica.id_seccion_academica=n_grado.id_seccion_academica ORDER BY orden ASC";

$opt_name=array();
$opt_name[$f][0]='grado';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$f][1]='';//Adem�s puedes tener del campo de la tabla en caso de selectBD

$opt_value=array();
$opt_value[$f][0]='id_grado';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$f][1]='';

$opt_sel=array();
$opt_sel[$f][0]='id_grado';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma est�tica se pone en uno solo "selected"
$opt_sel[$f][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$ff] = "select id_tipo_grado as id_tipo_grado, tipo_grado as tipo_grado from n_tipo_grado ORDER BY tipo_grado";

$opt_name[$ff][0]='tipo_grado';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$ff][1]='';//Adem�s puedes tener del campo de la tabla en caso de selectBD

$opt_value[$ff][0]='id_tipo_grado';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$ff][1]='';

$opt_sel[$ff][0]='id_tipo_grado';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma est�tica se pone en uno solo "selected"
$opt_sel[$ff][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$g] = "select id_paralelo as id_paralelo, paralelo as paralelo from n_paralelo ORDER BY paralelo";

$opt_name[$g][0]='paralelo';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$g][1]='';//Adem�s puedes tener del campo de la tabla en caso de selectBD

$opt_value[$g][0]='id_paralelo';//value del option, campo de la tabla externa de la consulta del combo

$opt_sel[$g][0]='id_paralelo';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma est�tica se pone en uno solo "selected"
$opt_sel[$g][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$gs] = "select id_responsable_acta as id_responsable_acta, concat(cargo,' - ',nombre) as responsable_acta from n_responsable_acta ORDER BY responsable_acta";

$opt_name[$gs][0]='responsable_acta';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$gs][1]='';//Adem�s puedes tener del campo de la tabla en caso de selectBD

$opt_value[$gs][0]='id_responsable_acta';//value del option, campo de la tabla externa de la consulta del combo

$opt_sel[$gs][0]='id_responsable_acta';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma est�tica se pone en uno solo "selected"
$opt_sel[$gs][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='';
$dato_permit[2]='Rselec';
$dato_permit[3]='';
$dato_permit[4]='Rselec';
$dato_permit[5]='';
$dato_permit[6]='Rselec';
$dato_permit[7]='';
$dato_permit[8]='Rselec';
$dato_permit[9]='Rvarchar';
$dato_permit[10]='Rvarchar';

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

$size[0]='50'; // tama�o del <input> (NO TOCAR)
$size[1]='';
$size[2]='50';
$size[3]='';
$size[4]='50';
$size[5]='';
$size[6]='50';
$size[7]='';
$size[8]='50';
$size[9]='50';
$size[10]='50';

$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
$onsubmit=$obj_var->Llenar_onsubmit($inputs);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)

$n_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>$onsubmit,'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$n_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$n_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_insertar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$n_botones_ayuda=array(); // botonera que va a tener en el encabezado (NO TOCAR) 
$n_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$n_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acci�n y volver al listado');
$n_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$n_label_ayuda=array(); // campos de los <input> (NO TOCAR) 
$n_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Curso');
$n_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Tipo de curso');
$n_label_ayuda[2]=array('texto'=>$columna[6],'exp'=>'Paralelo');
$n_label_ayuda[3]=array('texto'=>$columna[8],'exp'=>'Responsable de acta');
$n_label_ayuda[4]=array('texto'=>$columna[9],'exp'=>'Abreviatura');
$n_label_ayuda[5]=array('texto'=>$columna[10],'exp'=>'Nombre del ministerio');

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
$m_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acci�n y volver al listado');
$m_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$m_label_ayuda=array(); // campos de los <input> (NO TOCAR)
$m_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Curso');
$m_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Tipo de curso');
$m_label_ayuda[2]=array('texto'=>$columna[6],'exp'=>'Paralelo');
$m_label_ayuda[3]=array('texto'=>$columna[8],'exp'=>'Responsable de acta');
$m_label_ayuda[4]=array('texto'=>$columna[9],'exp'=>'Abreviatura');
$m_label_ayuda[5]=array('texto'=>$columna[10],'exp'=>'Nombre del ministerio');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
?>