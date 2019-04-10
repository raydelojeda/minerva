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


$elemento_titulo="de facturaci&oacute;n de pensiones"; // para el título
$elemento="venta"; // elemento o nomenclador al que se accede
$camino="pag/cont/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/cont/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Administraci&oacute;n ".$elemento_titulo.": listar"; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a la facturaci&oacute;n de pensiones registradas en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="venta";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='cliente';
$tabla_anidada[1]='producto_precio';
$tabla_anidada[2]='n_factura';

$tabla_anidada2[0]='persona';
$tabla_anidada2[1]='n_producto';
$tabla_anidada2[2]='n_punto_venta';

$campo_anidado=array();
$campo_anidado[0]='id_cliente';
$campo_anidado[1]='id_producto_precio';
$campo_anidado[2]='id_factura';

$campo_anidado2[0]='id_persona';
$campo_anidado2[1]='id_producto';
$campo_anidado2[2]='id_punto_venta';

$where=' AND persona.id_persona=cliente.id_persona AND producto_precio.id_producto=n_producto.id_producto AND producto_precio.id_punto_venta=n_punto_venta.id_punto_venta';

$order=" fac DESC";
$ver=1000;

$field[0]='id_venta'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]=$tabla.'.id_cliente';
$field[2]="concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion)";//,' No factura: ',no_factura)";
$field[3]="concat(factura_apellidos,' ',factura_nombres,' - ',factura_cedula,'<br>',factura_direccion,' - ',factura_telefono)";
$field[4]=$tabla.'.id_producto_precio';
$field[5]="concat(cod_producto,' - ',producto)";
$field[6]=$tabla.'.id_factura';
$field[7]='no_factura';
$field[8]='cantidad';
$field[9]='precio';
$field[10]='';
$field[11]='fecha_venta';
$field[12]='anulada';
$field[13]="no_autorizo";
$field[14]=$tabla_anidada[1].'.id_punto_venta';
$field[15]="concat(punto_venta,' - ',descripcion)";

$alias_col=array();
$alias_col[0]='id_venta';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='id_c';
$alias_col[2]='per';
$alias_col[3]='d_fac';
$alias_col[4]='id_p';
$alias_col[5]='pro';
$alias_col[6]='id_f';
$alias_col[7]='fac';
$alias_col[8]='can';
$alias_col[9]='pre';
$alias_col[10]='number_format(bcmul($rs->fields["pre"], $rs->fields["can"],14), 2, ".", "");';
$alias_col[11]='fec';
$alias_col[12]='anu';
$alias_col[13]='aut';
$alias_col[14]='id_pun';
$alias_col[15]='pun';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Persona';
$columna[2]='Persona';
$columna[3]='Datos de factura';
$columna[4]='Producto';
$columna[5]='Producto';
$columna[6]='No autorizo';
$columna[7]='No factura';
$columna[8]='Cantidad';
$columna[9]='Precio';
$columna[10]='Subtotal';
$columna[11]='Fecha de venta';
$columna[12]='A';
$columna[13]='No autorizo';
$columna[14]='Punto de venta';
$columna[15]='Punto de venta';

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

$info_emerg[0]=''; // si se muestra o no en la ventana emergente la informacion para listar (NO TOCAR)
$info_emerg[1]='';
$info_emerg[2]=1;
$info_emerg[3]=1;
$info_emerg[4]='';
$info_emerg[5]=1;
$info_emerg[6]='';
$info_emerg[7]=1;
$info_emerg[8]=1;
$info_emerg[9]=1;
$info_emerg[10]=1;
$info_emerg[11]=1;
$info_emerg[12]=2;
$info_emerg[13]=1;
$info_emerg[14]='';
$info_emerg[15]=1;

$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]='';
$info_col[2]=1;
$info_col[3]='';
$info_col[4]='';
$info_col[5]=1;
$info_col[6]='';
$info_col[7]=1;
$info_col[8]=1;
$info_col[9]=1;
$info_col[10]='calc';
$info_col[11]=1;
$info_col[12]=2;
$info_col[13]='';
$info_col[14]='';
$info_col[15]=9;

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='';
$ancho[2]='30%';
$ancho[3]='';
$ancho[4]='';
$ancho[5]='25%';
$ancho[6]='';
$ancho[7]='9%';
$ancho[8]='6%';
$ancho[9]='6%';
$ancho[10]='6%';
$ancho[11]='15%';
$ancho[12]='1%';
$ancho[13]='';
$ancho[14]='';
$ancho[15]='';

$var_mod='';


$columna_suma[0]='';
$href_m=''; // camino de la pagina para Editar

$id_cadenacheckboxp=$alias_col[0];

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Venta','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Anular','exp'=>'Editar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[3]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Persona que realiza la compra');
$l_label_ayuda[1]=array('texto'=>$columna[5],'exp'=>'Producto a vender');
$l_label_ayuda[2]=array('texto'=>$columna[7],'exp'=>'No de autorizo del SRI');
$l_label_ayuda[3]=array('texto'=>$columna[8],'exp'=>'Cantidad a vender');
$l_label_ayuda[4]=array('texto'=>$columna[9],'exp'=>'Precio');
$l_label_ayuda[5]=array('texto'=>$columna[10],'exp'=>'Fecha de venta');
$l_label_ayuda[6]=array('texto'=>$columna[11],'exp'=>'Anulada: Si o No');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Venta','accion'=>'Insertar');
$l_botones[1]=array('target'=>'_self','href'=>'new_pension.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Pensi&oacute;n','accion'=>'Insertar');
$l_botones[2]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'anular_'.$elemento.'.php\')','src'=>$x.'img/cont/venta/anular.png','nombre'=>'editar','texto'=>'Anular','accion'=>'Editar');
$l_botones[3]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'habilitar_'.$elemento.'.php\')','src'=>$x.'img/cont/venta/habilitar.png','nombre'=>'editar','texto'=>'Habilitar','accion'=>'Editar');
$l_botones[4]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'imp_'.$elemento.'.php\');','src'=>$x.'img/general/imprimir.png','nombre'=>'imprimir','texto'=>'Imprimir','accion'=>'Imprimir');
$l_botones[5]=array('target'=>'_blank','href'=>'#','onclic'=>'submit(\'exp_'.$elemento.'.php\');','src'=>$x.'img/general/exportar_csv.png','nombre'=>'exportar_csv','texto'=>'Exportar','accion'=>'Exportar');
$l_botones[6]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_listar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------
//------------------------------------------------INSERTAR------------------------------------------------

$insert_field[0]='id_venta'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='id_cliente'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='';
$insert_field[3]='id_producto';
$insert_field[4]='';
$insert_field[5]='id_factura';
$insert_field[6]='';
$insert_field[7]='cantidad';
$insert_field[8]='no_factura';
$insert_field[9]='fecha_venta';
$insert_field[10]='anulada';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[1];
$insert_alias[2]='';
$insert_alias[3]=$alias_col[3];
$insert_alias[4]='';
$insert_alias[5]=$alias_col[5];
$insert_alias[6]='';
$insert_alias[7]=$alias_col[7];
$insert_alias[8]=$alias_col[8];
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
$name_input[7]=$alias_col[7];
$name_input[8]=$alias_col[8];
$name_input[9]=$alias_col[9];
$name_input[10]=$alias_col[10];

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[2]; // label de los inputs, se utiliza ya que en el listar puede haber campos de más según las otras tablas anidadas
$label_input[2]=$columna[2];
$label_input[3]=$columna[4];
$label_input[4]=$columna[4];
$label_input[5]=$columna[6];
$label_input[6]=$columna[6];
$label_input[7]=$columna[7];
$label_input[8]=$columna[8];
$label_input[9]=$columna[9];
$label_input[10]=$columna[10];

$field_unico=array();
$field_unico[0]=''; // fields que deben ser únicos en la tabla en la BD, diferente de 1 y vacío es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]=2;
$field_unico[2]='';
$field_unico[3]=2;
$field_unico[4]='';
$field_unico[5]=2;
$field_unico[6]='';
$field_unico[7]='';
$field_unico[8]='';
$field_unico[9]=2;
$field_unico[10]='';

$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='';
$tipo_input[2]='texto_select';
$tipo_input[3]='';
$tipo_input[4]='texto_select';
$tipo_input[5]='';
$tipo_input[6]='texto_select';
$tipo_input[7]='';
$tipo_input[8]='texto';
$tipo_input[9]='texto';
$tipo_input[10]='input';

// valores que va a tomar el campo tipo <select> en cada <option>
$j=12;
$f=2;
$combo_sql[$f] = "select id_punto_venta as id_p, punto_venta as pun from n_cliente ORDER BY punto_venta";

$opt_name=array();
$opt_name[$f][0]='pun';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$f][1]='';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value=array();
$opt_value[$f][0]='id_p';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$f][1]='';

$opt_sel=array();
$opt_sel[$f][0]='id_p';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$f][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$j] = "";

$opt_name[$j][0]='<img width=10px src='.$x.'img/general/no.png>';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$j][1]='<img width=10px src='.$x.'img/general/si.png>';//Además puedes tener del campo de la tabla en caso de selectBD

$opt_value[$j][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$j][1]='0';


$opt_sel[$j][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma estática se pone en uno solo "selected"
$opt_sel[$j][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='';
$dato_permit[2]='';
$dato_permit[3]='';
$dato_permit[4]='';
$dato_permit[5]='';
$dato_permit[6]='';
$dato_permit[7]='';
$dato_permit[8]='';
$dato_permit[9]='';
$dato_permit[10]='';

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

$size[0]='50'; // tamaño del <input> (NO TOCAR)
$size[1]='50';
$size[2]='50';
$size[3]='50';
$size[4]='50';
$size[5]='50';
$size[6]='50';
$size[7]='50';
$size[8]='50';
$size[9]='50';
$size[10]='50';

$inputs=$obj_var->Llenar_inputs($tipo_input,$name_input,$value_input,$columna,$label_input,$dato_permit,$onclic,$size,$field_col,$texto_input,$placeholder,$evento);// para llenar los input (NO TOCAR)
$onsubmit=$obj_var->Llenar_onsubmit($inputs);// para llenar la variable $onsubmit con la funcion en js con los parametros del id del input y el dato permitido (NO TOCAR)

$n_botones=array(); // botonera que va a tener en el encabezado (NO TOCAR)
$n_botones[0]=array('target'=>'_self','href'=>'#','onclic'=>"submit('pension.php');",'src'=>$x.'img/general/guardar.png','nombre'=>'guardar','texto'=>'Guardar','accion'=>'');
$n_botones[1]=array('target'=>'_self','href'=>'lis_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/cancelar.png','nombre'=>'cancelar','texto'=>'Salir','accion'=>'');
$n_botones[2]=array('target'=>'_blank','href'=>$x.'plantillas/ayu_insertar.php?var='.$camino.'/variables.php','onclic'=>'','src'=>$x.'img/general/ayuda.png','nombre'=>'ayuda','texto'=>'Ayuda','accion'=>'');

$n_botones_ayuda=array(); // botonera que va a tener en el encabezado (NO TOCAR) 
$n_botones_ayuda[0]=array('texto'=>'Guardar','exp'=>'guardar la informaci&oacute;n');
$n_botones_ayuda[1]=array('texto'=>'Salir','exp'=>'cancelar la acción y volver al listado');
$n_botones_ayuda[2]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$n_label_ayuda=array(); // campos de los <input> (NO TOCAR) 
$n_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'No de autorizo del SRI');
$n_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Inicio del facturero');
$n_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Fin del facturero');
$n_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Fecha de emisi&oacute;n del facturero');
$n_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Fecha de vencimiento del facturero');
$n_label_ayuda[5]=array('texto'=>$columna[7],'exp'=>'Activo: Si o No');
$n_label_ayuda[6]=array('texto'=>$columna[8],'exp'=>'Punto de venta');

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
$m_label_ayuda[0]=array('texto'=>$columna[1],'exp'=>'No de autorizo del SRI');
$m_label_ayuda[1]=array('texto'=>$columna[2],'exp'=>'Inicio del facturero');
$m_label_ayuda[2]=array('texto'=>$columna[3],'exp'=>'Fin del facturero');
$m_label_ayuda[3]=array('texto'=>$columna[4],'exp'=>'Fecha de emisi&oacute;n del facturero');
$m_label_ayuda[4]=array('texto'=>$columna[6],'exp'=>'Fecha de vencimiento del facturero');
$m_label_ayuda[5]=array('texto'=>$columna[7],'exp'=>'Activo: Si o No');
$m_label_ayuda[6]=array('texto'=>$columna[8],'exp'=>'Punto de venta');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
//archivo de configuración de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aquí
?>