<?php
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($_GET["var"]))//$_GET["var"] se envia en el onclick de boton de ayuda, si existe que no modifique la variable $x, asi puede incluir clases_var.inc.php (NO TOCAR)
if(!isset($x))$x="../../../";// (NO TOCAR)
include_once($x."config/clases_var.inc.php");// (NO TOCAR)
if(!isset($obj_var))$obj_var = new clases_var();// (NO TOCAR)
$_SESSION["modulo"]="bibl";

// declaraciones
$datos="";// (NO TOCAR)
$pag=1;// (NO TOCAR)
$cadenacheckboxp="";// (NO TOCAR)
$l_info_emergente="";// (NO TOCAR)
$mensaje="";// (NO TOCAR)
$options="";// (NO TOCAR)
// declaraciones


$elemento_titulo="de devoluci&oacute;n (libro devuelto y sin prestar)"; // para el título
$elemento="devolucion"; // elemento o nomenclador al que se accede
$camino="pag/bibl/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/bibl/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a los pr&eacute;stamos de libros registrados en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="prestamo";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='persona';
$tabla_anidada[1]='libro';

$tabla_anidada2[0]='n_editorial';
$tabla_anidada2[1]='n_autor';

$campo_anidado=array();
$campo_anidado[0]='id_persona';
$campo_anidado[1]='id_libro';

$campo_anidado2=array();
$campo_anidado2[0]='id_editorial';
$campo_anidado2[1]='id_autor';

$where=' AND libro.id_editorial=n_editorial.id_editorial AND libro.id_autor=n_autor.id_autor AND prestado="0"';//AND fecha_dev_real=""

$order=" primer_apellido,segundo_apellido,primer_nombre,segundo_nombre DESC";

$field[0]=$tabla.'.id_prestamo'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]=$tabla.'.id_persona';
$field[2]="concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion)";
$field[3]=$tabla.'.id_libro';
$field[4]="concat(no_ficha,' - ',titulo)";
$field[5]=$tabla_anidada2[0].'.id_editorial';
$field[6]='editorial';
$field[7]=$tabla_anidada2[1].'.id_autor';
$field[8]='autor';
$field[9]='fecha_prestamo';
$field[10]='fecha_dev';
$field[11]='fecha_dev_real';
$field[12]='prestado';
$field[13]='baja';

$alias_col=array();
$alias_col[0]='ID_prestamo';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='ID_PER';
$alias_col[2]='PER';
$alias_col[3]='ID_L';
$alias_col[4]='LIB';
$alias_col[5]='ID_E';
$alias_col[6]='EDI';
$alias_col[7]='ID_A';
$alias_col[8]='AUT';
$alias_col[9]='F_PRES';
$alias_col[10]='F_DEV';
$alias_col[11]='F_DEV_R';
$alias_col[12]='PRES';
$alias_col[13]='BAJA';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Persona';
$columna[2]='Persona';
$columna[3]='Libro';
$columna[4]='Libro';
$columna[5]='Editorial';
$columna[6]='Editorial';
$columna[7]='Autor';
$columna[8]='Autor';
$columna[9]='Fecha de pr&eacute;stamo';
$columna[10]='Fecha de devoluci&oacute;n';
$columna[11]='Fecha de devoluci&oacute;n real';
$columna[12]='Prestado';
$columna[13]='Baja';

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
$info_emerg[11]=1;
$info_emerg[12]=2;
$info_emerg[13]='';

$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]='';
$info_col[2]=1;
$info_col[3]='';
$info_col[4]=1;
$info_col[5]='';
$info_col[6]='';
$info_col[7]='';
$info_col[8]='';
$info_col[9]=1;
$info_col[10]=1;
$info_col[11]=1;
$info_col[12]=2;
$info_col[13]='';

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='';
$ancho[2]='28%';
$ancho[3]='';
$ancho[4]='31%';
$ancho[5]='';
$ancho[6]='';
$ancho[7]='';
$ancho[8]='';
$ancho[9]='11%';
$ancho[10]='11%';
$ancho[11]='13%';
$ancho[12]='4%';
$ancho[13]='';

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
$l_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Persona que solicita el pr&eacute;stamo');
$l_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Libro a pretar');
$l_label_ayuda[2]=array('texto'=>$columna[6],'exp'=>'Editorial del libro');
$l_label_ayuda[3]=array('texto'=>$columna[8],'exp'=>'Autor del libro');
$l_label_ayuda[4]=array('texto'=>$columna[9],'exp'=>'Fecha de pr&eacute;stamo del libro');
$l_label_ayuda[5]=array('texto'=>$columna[10],'exp'=>'Fecha de devoluci&oacute;n del libro');
$l_label_ayuda[6]=array('texto'=>$columna[11],'exp'=>'Fecha de devoluci&oacute;n real del libro');
$l_label_ayuda[7]=array('texto'=>$columna[12],'exp'=>'Est&aacute; prestado el libro? Si o No');
$l_label_ayuda[8]=array('texto'=>$columna[13],'exp'=>'Est&aacute; dado de baja el libro? Si o No');

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

$insert_field[0]='id_prestamo'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='id_persona'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='';
$insert_field[3]='id_libro';
$insert_field[4]='';
$insert_field[5]='fecha_prestamo';
$insert_field[6]='fecha_dev';
$insert_field[7]='fecha_dev_real';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[1];
$insert_alias[2]='';
$insert_alias[3]=$alias_col[3];
$insert_alias[4]='';
$insert_alias[5]=$alias_col[9];
$insert_alias[6]=$alias_col[10];
$insert_alias[7]=$alias_col[11];

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[2]; 
$name_input[2]=$alias_col[2]; 
$name_input[3]=$alias_col[4]; 
$name_input[4]=$alias_col[4]; 
$name_input[5]=$alias_col[9];
$name_input[6]=$alias_col[10]; 
$name_input[7]=$alias_col[11];

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[2]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[2];
$label_input[3]=$columna[4];
$label_input[4]=$columna[4];
$label_input[5]=$columna[9];
$label_input[6]=$columna[10];
$label_input[7]=$columna[11];

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]=2;
$field_unico[2]='';
$field_unico[3]='';
$field_unico[4]='';
$field_unico[5]=2;
$field_unico[6]='';
$field_unico[7]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='';
$tipo_input[2]='selectBD';
$tipo_input[3]='';
$tipo_input[4]='selectBD';
$tipo_input[5]='input';
$tipo_input[6]='input';
$tipo_input[7]='input';

// valores que va a tomar el campo tipo <select> en cada <option>
$e=2;
$f=4;
$g=12;
$v=13;

$opt_name=array();$opt_value=array();$opt_sel=array();
$combo_sql[$e] = "SELECT persona.id_persona as ID_PER, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as PER 
FROM persona ORDER BY primer_apellido,segundo_apellido";

$opt_name[$e][0]='PER';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$e][0]='ID_PER';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$e][0]='ID_PER';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$f] = "select id_libro as ID_L, concat(no_ficha,' - ',titulo) as LIB FROM libro WHERE 1 AND prestado='1' AND baja='0'";

$opt_name[$f][0]='LIB';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Además puedes tener del campo de la tabla en caso de selectBD
$opt_value[$f][0]='ID_L';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$f][0]='ID_L';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$g] = "";

$opt_name[$g][0]='<img width=10px src='.$x.'img/general/si.png>';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$g][1]='<img width=10px src='.$x.'img/general/no.png>';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$g][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$g][1]='0';

$opt_sel[$g][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$g][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$v] = "";

$opt_name[$v][0]='<img width=10px src='.$x.'img/general/si.png>';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$v][1]='<img width=10px src='.$x.'img/general/no.png>';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$v][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$v][1]='0';

$opt_sel[$v][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$v][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='';
$dato_permit[2]='Rselec';
$dato_permit[3]='';
$dato_permit[4]='Rselec';
$dato_permit[5]='Rfecha';
$dato_permit[6]='Rfecha';
$dato_permit[7]='fecha';

$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='';
$value_input[2]='';
$value_input[3]='';
$value_input[4]='';
$value_input[5]=date('Y-m-d');
$value_input[6]='';
$value_input[7]='';

$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='';
$onclic[3]='';
$onclic[4]='';
$onclic[5]='displayCalendar(document.frm.'.$name_input[5].',"yyyy-m-d",this);';
$onclic[6]='displayCalendar(document.frm.'.$name_input[6].',"yyyy-m-d",this);';
$onclic[7]='displayCalendar(document.frm.'.$name_input[7].',"yyyy-m-d",this);';

$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='';
$size[2]='50';
$size[3]='';
$size[4]='50';
$size[5]='10';
$size[6]='10';
$size[7]='10';

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
$n_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Persona que solicita el pr&eacute;stamo');
$n_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Libro a pretar');
$n_label_ayuda[2]=array('texto'=>$columna[6],'exp'=>'Editorial del libro');
$n_label_ayuda[3]=array('texto'=>$columna[8],'exp'=>'Autor del libro');
$n_label_ayuda[4]=array('texto'=>$columna[9],'exp'=>'Fecha de pr&eacute;stamo del libro');
$n_label_ayuda[5]=array('texto'=>$columna[10],'exp'=>'Fecha de devoluci&oacute;n del libro');
$n_label_ayuda[6]=array('texto'=>$columna[11],'exp'=>'Fecha de devoluci&oacute;n real del libro');
$n_label_ayuda[7]=array('texto'=>$columna[12],'exp'=>'Est&aacute; prestado el libro? Si o No');
$n_label_ayuda[8]=array('texto'=>$columna[13],'exp'=>'Est&aacute; dado de baja el libro? Si o No');

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
$m_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Persona que solicita el pr&eacute;stamo');
$m_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Libro a pretar');
$m_label_ayuda[2]=array('texto'=>$columna[6],'exp'=>'Editorial del libro');
$m_label_ayuda[3]=array('texto'=>$columna[8],'exp'=>'Autor del libro');
$m_label_ayuda[4]=array('texto'=>$columna[9],'exp'=>'Fecha de pr&eacute;stamo del libro');
$m_label_ayuda[5]=array('texto'=>$columna[10],'exp'=>'Fecha de devoluci&oacute;n del libro');
$m_label_ayuda[6]=array('texto'=>$columna[11],'exp'=>'Fecha de devoluci&oacute;n real del libro');
$m_label_ayuda[7]=array('texto'=>$columna[12],'exp'=>'Est&aacute; prestado el libro? Si o No');
$m_label_ayuda[8]=array('texto'=>$columna[13],'exp'=>'Est&aacute; dado de baja el libro? Si o No');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>