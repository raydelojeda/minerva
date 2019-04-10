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


$elemento_titulo="del historial de movimientos de activos fijos"; // para el título
$elemento="ubicacion_responsable"; // elemento o nomenclador al que se accede
$camino="pag/cont/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/cont/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a la ubicaciones y responsables registrados en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="ubicacion_responsable";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='inventario';
$tabla_anidada[1]='n_ubicacion';

$tabla_anidada2[0]='empleado as emp_resp';
$tabla_anidada2[1]='empleado as emp_inv';
$tabla_anidada2[2]='persona as per_resp';
$tabla_anidada2[3]='persona as per_inv';
$tabla_anidada2[4]='n_bloque';
$tabla_anidada2[5]='n_secc';
$tabla_anidada2[6]='n_division';
$tabla_anidada2[7]='n_articulo';
$tabla_anidada2[8]='n_marca';
$tabla_anidada2[9]='n_modelo';

$campo_anidado=array();
$campo_anidado[0]='id_inventario';
$campo_anidado[1]='id_ubicacion';

$campo_anidado2[0]='emp_resp.id_empleado';
$campo_anidado2[1]='emp_inv.id_empleado';
$campo_anidado2[2]='per_resp.id_persona';
$campo_anidado2[3]='per_inv.id_persona';
$campo_anidado2[4]='n_bloque.id_bloque';
$campo_anidado2[5]='n_secc.id_secc';
$campo_anidado2[6]='n_division.id_division';
$campo_anidado2[7]='n_articulo.id_articulo';
$campo_anidado2[8]='n_marca.id_marca';
$campo_anidado2[9]='n_modelo.id_modelo';

$where=' AND emp_resp.id_empleado=ubicacion_responsable.id_responsable AND emp_inv.id_empleado=ubicacion_responsable.id_empleado_inv
 AND per_resp.id_persona=emp_resp.id_persona AND per_inv.id_persona=emp_inv.id_persona
 AND n_ubicacion.id_bloque=n_bloque.id_bloque AND n_ubicacion.id_division=n_division.id_division AND n_ubicacion.id_secc=n_secc.id_secc
 AND inventario.id_articulo=n_articulo.id_articulo AND n_marca.id_marca=n_articulo.id_marca AND n_modelo.id_modelo=n_articulo.id_modelo';
 
$order='fecha_mov DESC';

$field=array();
$field[0]='id_ubicacion_responsable'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]=$tabla.'.id_inventario';
$field[2]="no_inventario";
$field[3]='no_serie';
$field[4]=$tabla_anidada2[7].'.id_articulo';
$field[5]="concat(articulo,' - Marca: ',marca,' Modelo: ', modelo)";
$field[6]=$tabla.".cantidad";
$field[7]=$tabla.".fecha_mov";
$field[8]=$tabla.'.id_responsable';
$field[9]="concat(per_resp.primer_apellido,' ',per_resp.segundo_apellido,' ',per_resp.primer_nombre,' ',per_resp.segundo_nombre,' - ',per_resp.identificacion)";
$field[10]=$tabla.'.id_empleado_inv';
$field[11]="concat(per_inv.primer_apellido,' ',per_inv.segundo_apellido,' ',per_inv.primer_nombre,' ',per_inv.segundo_nombre,' - ',per_inv.identificacion)";
$field[12]=$tabla.'.id_ubicacion';
$field[13]="concat(ubicacion,' - ',bloque,' - ',secc,' - ',division)";

$alias_col=array();
$alias_col[0]='id_ubicacion_responsable';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='id_inventario';
$alias_col[2]='no_inv';
$alias_col[3]='no_serie';
$alias_col[4]='id_articulo';
$alias_col[5]='articulo';
$alias_col[6]='cantidad';
$alias_col[7]='fecha_mov';
$alias_col[8]='id_responsable';
$alias_col[9]='responsable';
$alias_col[10]='id_empleado_inv';
$alias_col[11]='empleado_inv';
$alias_col[12]='id_ubicacion';
$alias_col[13]='ubicacion';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='No inventario';
$columna[2]='No inventario';
$columna[3]='No serie';
$columna[4]='Art&iacute;culo';
$columna[5]='Art&iacute;culo';
$columna[6]='Cantidad';
$columna[7]='Fecha de movimiento';
$columna[8]='Responsable';
$columna[9]='Responsable';
$columna[10]='Jefe de inventario';
$columna[11]='Jefe de inventario';
$columna[12]='Ubicaci&oacute;n';
$columna[13]='Ubicaci&oacute;n';

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
$info_emerg[3]=1;
$info_emerg[4]='';
$info_emerg[5]=1;
$info_emerg[6]=1;
$info_emerg[7]=1;
$info_emerg[8]='';
$info_emerg[9]=1;
$info_emerg[10]='';
$info_emerg[11]=1;
$info_emerg[12]='';
$info_emerg[13]=1;

$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]='';
$info_col[2]=1;
$info_col[3]='';
$info_col[4]='';
$info_col[5]=1;
$info_col[6]=1;
$info_col[7]=1;
$info_col[8]='';
$info_col[9]=1;
$info_col[10]='';
$info_col[11]='';
$info_col[12]='';
$info_col[13]=1;

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='';
$ancho[2]='7%';
$ancho[3]='';
$ancho[4]='';
$ancho[5]='25%';
$ancho[6]='5%';
$ancho[7]='12%';
$ancho[8]='';
$ancho[9]='26%';
$ancho[10]='';
$ancho[11]='';
$ancho[12]='';
$ancho[13]='23%';

$var_mod='';
$columna_suma[0]='';
$href_m='mod_ubicacion_responsable.php?mod='; // camino de la pagina para Editar

$id_cadenacheckboxp='';

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Nuevo','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Editar','exp'=>'Editar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Eliminar','exp'=>'eliminar la informaci&oacute;n');
$l_botones_ayuda[3]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[5]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Grado y paralelo');
$l_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Per&iacute;odo cont&eacute;mico');
$l_label_ayuda[2]=array('texto'=>$columna[6],'exp'=>'Tutor');
$l_label_ayuda[3]=array('texto'=>$columna[8],'exp'=>'Psic&oacute;logo');
$l_label_ayuda[4]=array('texto'=>$columna[9],'exp'=>'Orden');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
//$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'2.php','onclic'=>'','src'=>$x.'img/general/nuevo2.png','nombre'=>'nuevo','texto'=>'Nuevo','accion'=>'Insertar');
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
$insert_field[0]='id_ubicacion_responsable'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='cantidad';
$insert_field[2]='fecha_mov';
$insert_field[3]='id_inventario';
$insert_field[4]='';
$insert_field[5]='id_responsable';
$insert_field[6]='';
$insert_field[7]='id_empleado_inv';
$insert_field[8]='';
$insert_field[9]='id_ubicacion';
$insert_field[10]='';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[6];
$insert_alias[2]=$alias_col[7];
$insert_alias[3]=$alias_col[1];
$insert_alias[4]='';
$insert_alias[5]=$alias_col[8];
$insert_alias[6]='';
$insert_alias[7]=$alias_col[10];
$insert_alias[8]='';
$insert_alias[9]=$alias_col[12];
$insert_alias[10]='';

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[6]; 
$name_input[2]=$alias_col[7]; 
$name_input[3]=$alias_col[2]; 
$name_input[4]=$alias_col[2]; 
$name_input[5]=$alias_col[9]; 
$name_input[6]=$alias_col[9];
$name_input[7]=$alias_col[11];
$name_input[8]=$alias_col[11];
$name_input[9]=$alias_col[13];
$name_input[10]=$alias_col[13];

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[6]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[7];
$label_input[3]=$columna[2];
$label_input[4]=$columna[2];
$label_input[5]=$columna[9];
$label_input[6]=$columna[9];
$label_input[7]=$columna[11];
$label_input[8]=$columna[11];
$label_input[9]=$columna[13];
$label_input[10]=$columna[13];

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]='';
$field_unico[2]='';
$field_unico[3]='';
$field_unico[4]='';
$field_unico[5]='';
$field_unico[6]='';
$field_unico[7]='';
$field_unico[8]='';
$field_unico[9]='';
$field_unico[10]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='texto_input';
$tipo_input[2]='texto_input';
$tipo_input[3]='';
$tipo_input[4]='selectBD';
$tipo_input[5]='';
$tipo_input[6]='selectBD';
$tipo_input[7]='';
$tipo_input[8]='selectBD';
$tipo_input[9]='';
$tipo_input[10]='selectBD';

// valores que va a tomar el campo tipo <select> en cada <option>
$f=4;
$ff=6;
$g=8;
$gs=10;

/*$combo_sql[$f] = "select id_articulo as id_inventario, concat(articulo) as inventario from n_articulo
WHERE 1 ORDER BY articulo ASC";*/

$combo_sql[$f] = "select id_inventario as id_inventario, concat(no_inventario,' - ',articulo,' - Marca:',marca,' Modelo:', modelo) as inventario from inventario, n_articulo, n_marca, n_modelo
WHERE 1 AND n_articulo.id_marca=n_marca.id_marca AND n_articulo.id_modelo=n_modelo.id_modelo AND inventario.id_articulo=n_articulo.id_articulo AND no_inventario!='' ORDER BY articulo ASC";

$opt_name=array();
$opt_name[$f][0]='inventario';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$f][1]='';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value=array();
$opt_value[$f][0]='id_inventario';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$f][1]='';

$opt_sel=array();
$opt_sel[$f][0]='id_inventario';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$f][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$ff] = "select empleado.id_empleado as id_responsable, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as responsable 
from persona, empleado, ingreso_salida WHERE 1 AND empleado.id_persona=persona.id_persona 
AND empleado.id_empleado=ingreso_salida.id_empleado AND baja='0' ORDER BY primer_apellido,segundo_apellido,primer_nombre";

$opt_name[$ff][0]='responsable';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$ff][1]='';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$ff][0]='id_responsable';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$ff][1]='';

$opt_sel[$ff][0]='id_responsable';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$ff][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$g] = "select empleado.id_empleado as id_empleado_inv, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as empleado_inv 
from persona, empleado, ingreso_salida, usuario WHERE 1 AND empleado.id_persona=persona.id_persona AND persona.id_persona=usuario.id_persona AND usuario.usuario='".$_SESSION['user']."'
AND empleado.id_empleado=ingreso_salida.id_empleado AND baja='0' ORDER BY primer_apellido,segundo_apellido,primer_nombre";//print $combo_sql[$g];

$opt_name[$g][0]='empleado_inv';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$g][1]='';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$g][0]='id_empleado_inv';//value del option, campo de la tabla externa de la consulta del combo

$opt_sel[$g][0]='id_empleado_inv';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$g][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$gs] = "SELECT id_ubicacion as id_ubicacion, concat(ubicacion,' - ',bloque,' - ',secc,' - ',division) as ubicacion 
FROM n_ubicacion, n_bloque, n_division, n_secc WHERE 1 AND n_ubicacion.id_bloque=n_bloque.id_bloque AND n_ubicacion.id_division=n_division.id_division AND n_ubicacion.id_secc=n_secc.id_secc ORDER BY bloque,secc,division";

$opt_name[$gs][0]='ubicacion';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$gs][1]='';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$gs][0]='id_ubicacion';//value del option, campo de la tabla externa de la consulta del combo

$opt_sel[$gs][0]='id_ubicacion';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$gs][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='Rentero';
$dato_permit[2]='Rfecha';
$dato_permit[3]='';
$dato_permit[4]='Rselec';
$dato_permit[5]='';
$dato_permit[6]='Rselec';
$dato_permit[7]='';
$dato_permit[8]='Rselec';
$dato_permit[9]='';
$dato_permit[10]='Rselec';

$texto_input=array();
$texto_input[2]='La fecha y hora ser&aacute; la del momento de guardar.';
date_default_timezone_set ('America/Guayaquil');

$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='1';
$value_input[2]=date('Y-m-d H:i:s');
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
$onclic[2]='';//displayCalendar(document.frm.'.$name_input[2].',"yyyy-m-d hh:ii",this,1);
$onclic[3]='';
$onclic[4]='ejecutar_ajax("'.$x.$camino.'/sel_responsable_actual.php","no_inv","div_responsable");';
$onclic[5]='';
$onclic[6]='';
$onclic[7]='';
$onclic[8]='';
$onclic[9]='';
$onclic[10]='';

$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='5';
$size[2]='20';
$size[3]='';
$size[4]='50';
$size[5]='';
$size[6]='50';
$size[7]='';
$size[8]='50';
$size[9]='';
$size[10]='50';

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
$n_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Grado y paralelo');
$n_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Per&iacute;odo cont&eacute;mico');
$n_label_ayuda[2]=array('texto'=>$columna[6],'exp'=>'Tutor');
$n_label_ayuda[3]=array('texto'=>$columna[8],'exp'=>'Psic&oacute;logo');
$n_label_ayuda[4]=array('texto'=>$columna[9],'exp'=>'Orden');

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
$m_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Grado y paralelo');
$m_label_ayuda[1]=array('texto'=>$columna[4],'exp'=>'Per&iacute;odo cont&eacute;mico');
$m_label_ayuda[2]=array('texto'=>$columna[6],'exp'=>'Tutor');
$m_label_ayuda[3]=array('texto'=>$columna[8],'exp'=>'Psic&oacute;logo');
$m_label_ayuda[4]=array('texto'=>$columna[9],'exp'=>'Orden');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>