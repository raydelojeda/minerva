<?php
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�

//cuando aparezca una linea con el comentario (NO TOCAR) se refiere a la linea, no al bloque
if(!isset($_GET["var"]))//$_GET["var"] se envia en el onclick de boton de ayuda, si existe que no modifique la variable $x, asi puede incluir clases_var.inc.php (NO TOCAR)
if(!isset($x))$x="../../../../";// (NO TOCAR)
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


$elemento_titulo="de ventas por No de factura"; // para el t�tulo
$elemento="r_venta"; // elemento o nomenclador al que se accede
$camino="pag/cont/".$elemento; // camino para acceder
$location=$x.$camino;

$img_encabezado="img/cont/".$elemento."/".$elemento.".png"; //imagen del encabezado

$titulo_listar="Reporte ".$elemento_titulo; //titulo del encabezado
$titulo_nuevo="Administraci&oacute;n ".$elemento_titulo.": insertar"; //titulo del encabezado
$titulo_editar="Administraci&oacute;n ".$elemento_titulo.": editar"; //titulo del encabezado
$titulo_ayuda="Administraci&oacute;n ".$elemento_titulo.": ayuda"; //titulo del encabezado
$intro_ayuda="Esta p&aacute;gina muestra una ayuda respecto a las ventas por No de factura de los clientes registrados en la base de datos.";//introduccion de la ayuda

//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------
//------------------------------------------------LISTAR------------------------------------------------

$tabla="venta";// tabla de la BD

$tabla_anidada=array();
$tabla_anidada[0]='cliente';
$tabla_anidada[1]='producto_precio';
$tabla_anidada[2]='n_forma_pago';

$tabla_anidada2[0]='persona';
$tabla_anidada2[1]='n_punto_venta';

$campo_anidado=array();
$campo_anidado[0]='id_cliente';
$campo_anidado[1]='id_producto_precio';
$campo_anidado[2]='id_forma_pago';

$campo_anidado2[0]='id_persona';
$campo_anidado2[1]='id_punto_venta';

$where=" AND persona.id_persona=cliente.id_persona AND n_punto_venta.id_punto_venta=producto_precio.id_punto_venta";

if (isset($_POST["txt_factura_ini"]))$_SESSION['txt_factura_ini'] = $_POST['txt_factura_ini'];if(isset($_SESSION['txt_factura_ini']))$txt_factura_ini = $_SESSION['txt_factura_ini'];//print $txt_factura_ini;
if (isset($_POST["txt_factura_fin"]))$_SESSION['txt_factura_fin'] = $_POST['txt_factura_fin'];if(isset($_SESSION['txt_factura_fin']))$txt_factura_fin = $_SESSION['txt_factura_fin'];//print $txt_factura_fin;//die();

if(!isset($txt_factura_ini))$txt_factura_ini = '';
if(!isset($txt_factura_fin))$txt_factura_fin = '';

if (isset($_POST["txt_fecha_ini"]))$_SESSION['txt_fecha_ini'] = $_POST['txt_fecha_ini'];if(isset($_SESSION['txt_fecha_ini']))$txt_fecha_ini = $_SESSION['txt_fecha_ini'];//print $txt_fecha_ini;
if (isset($_POST["txt_fecha_fin"]))$_SESSION['txt_fecha_fin'] = $_POST['txt_fecha_fin'];if(isset($_SESSION['txt_fecha_fin']))$txt_fecha_fin = $_SESSION['txt_fecha_fin'];//print $txt_fecha_fin;//die();

date_default_timezone_set("America/Guayaquil");
$hoy=date("Y-m-d");

if(!isset($txt_fecha_ini))$txt_fecha_ini=$hoy;
if(!isset($txt_fecha_fin))$txt_fecha_fin=$hoy;

$fecha_ini=$txt_fecha_ini." 00:00:00";
$fecha_fin=$txt_fecha_fin." 23:59:59";

if($fecha_ini)
$where .= " and venta.fecha_venta>='".$fecha_ini."'";
if($fecha_fin)
$where .= " and venta.fecha_venta<='".$fecha_fin."'";

if(isset($txt_factura_ini) AND $txt_factura_ini!='')
$where .= " and venta.no_factura>='".$txt_factura_ini."'";
if(isset($txt_factura_fin) AND $txt_factura_fin!='')
$where .= " and venta.no_factura<='".$txt_factura_fin."'";

$order=' fecha_venta DESC';

$field[0]='DISTINCT '.$tabla.'.no_factura'; // fields de la tabla en la BD, $field[0] es la llave de la tabla
$field[1]="punto_venta";
$field[2]='persona.identificacion';
$field[3]="concat(factura_nombres,' ',factura_apellidos,' - ',factura_cedula,' - ',factura_direccion,' - ',factura_telefono)";
$field[4]="concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre)";
$field[5]=$tabla_anidada2[1].'.id_punto_venta';
$field[6]='no_factura';
$field[7]='';
$field[8]='';
$field[9]='';
$field[10]='';
$field[11]='';
$field[12]='fecha_venta';
$field[13]='anulada';
$field[14]=$tabla.'.id_forma_pago';
$field[15]="forma_pago";

$alias_col=array();
$alias_col[0]='ID_cc';//alias de los campos de la consulta, debe haber alias en todos los campos
$alias_col[1]='pun';
$alias_col[2]='iden';
$alias_col[3]='fact';
$alias_col[4]='per';
$alias_col[5]='id_p';
$alias_col[6]='no_f';
$alias_col[7]='$obj2->calculos_x_factura($db,$rs->fields["no_f"])[0];';
$alias_col[8]='$obj2->calculos_x_factura($db,$rs->fields["no_f"])[1];';
$alias_col[9]='$obj2->calculos_x_factura($db,$rs->fields["no_f"])[2];';
$alias_col[10]='$obj2->calculos_x_factura($db,$rs->fields["no_f"])[3];';
$alias_col[11]='$obj2->calculos_x_factura($db,$rs->fields["no_f"])[4];';
$alias_col[12]='fec';
$alias_col[13]='anu';
$alias_col[14]='id_for';
$alias_col[15]='forma';

$columna[0]=''; // labels o encabezados, $field[0] es la llave de la tabla por tanto no lleva label (NO TOCAR)
$columna[1]='Punto de venta';
$columna[2]='Identificaci&oacute;n';
$columna[3]='Datos de factura';
$columna[4]='Consumidor';
$columna[5]='Punto de venta';
$columna[6]='No factura';
$columna[7]='Subtotal';
$columna[8]='Tarifa 0%';
$columna[9]='Tarifa 12% o 14%';
$columna[10]='IVA';
$columna[11]='Total';
$columna[12]='Fecha';
$columna[13]='A';
$columna[14]='Forma de pago';
$columna[15]='Forma de pago';

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
$info_emerg[1]=1;
$info_emerg[2]=1;
$info_emerg[3]=1;
$info_emerg[4]=1;
$info_emerg[5]='';
$info_emerg[6]=1;
$info_emerg[7]=1;
$info_emerg[8]=1;
$info_emerg[9]=1;
$info_emerg[10]=1;
$info_emerg[11]=1;
$info_emerg[12]=1;
$info_emerg[13]=2;
$info_emerg[14]='';
$info_emerg[15]=1;

$info_col[0]=''; // si se muestra o no la columna para listar
$info_col[1]=1;
$info_col[2]=1;
$info_col[3]='';
$info_col[4]=1;
$info_col[5]='';
$info_col[6]=1;
$info_col[7]='calc';
$info_col[8]='calc';
$info_col[9]='calc';
$info_col[10]='calc';
$info_col[11]='calc';
$info_col[12]=1;
$info_col[13]=2;
$info_col[14]='';
$info_col[15]='1';

$ancho[0]=''; // ancho de los <td> para listar, deben sumar 98%
$ancho[1]='10%';
$ancho[2]='7%';
$ancho[3]='';
$ancho[4]='23%';
$ancho[5]='';
$ancho[6]='6%';
$ancho[7]='5%';
$ancho[8]='6%';
$ancho[9]='7%';
$ancho[10]='5%';
$ancho[11]='5%';
$ancho[12]='11%';
$ancho[13]='1%';
$ancho[14]='';
$ancho[15]='10%';

$var_mod=$alias_col[1];
$columna_suma[0]=7;
$columna_suma[1]=8;
$columna_suma[2]=9;
$columna_suma[3]=10;
$columna_suma[4]=11;
$href_m=''; // camino de la pagina para Editar

$id_cadenacheckboxp='';

$l_botones_ayuda=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones_ayuda[0]=array('texto'=>'Nuevo','exp'=>'ingresar nueva informaci&oacute;n');
$l_botones_ayuda[1]=array('texto'=>'Editar','exp'=>'Editar la informaci&oacute;n');
$l_botones_ayuda[2]=array('texto'=>'Eliminar','exp'=>'eliminar la informaci&oacute;n');
$l_botones_ayuda[3]=array('texto'=>'Imprimir','exp'=>'imprimir la informaci&oacute;n mostrada');
$l_botones_ayuda[4]=array('texto'=>'Exportar','exp'=>'exportar la informaci&oacute;n mostrada');
$l_botones_ayuda[5]=array('texto'=>'Ayuda','exp'=>'ver esta p&aacute;gina');

$l_label_ayuda=array(); // botonera para listar que va a tener en el encabezado, el primer label no se muestra por ser el id de la tabla (NO TOCAR)
$l_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Identificaci&oacute;n del consumidor');
$l_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Datos de factura del consumidor');
$l_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Consumidor');
$l_label_ayuda[3]=array('texto'=>$columna[6],'exp'=>'Punto de venta donde el consumidor tiene el saldo');
$l_label_ayuda[4]=array('texto'=>$columna[7],'exp'=>'Saldo disponible del consumidor');

$l_botones=array(); // botonera para listar que va a tener en el encabezado (NO TOCAR)
$l_botones[0]=array('target'=>'_self','href'=>'new_'.$elemento.'.php','onclic'=>'','src'=>$x.'img/general/nuevo.png','nombre'=>'nuevo','texto'=>'Nuevo','accion'=>'Insertar');
$l_botones[1]=array('target'=>'_self','href'=>'#','onclic'=>'seleccion(\'debitar_r_saldo.php\')','src'=>$x.'img/cont/r_saldo/Editar.png','nombre'=>'editar','texto'=>'++ Saldo','accion'=>'Editar');
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

$insert_field[0]='id_saldo'; // campos de la tabla en la BD de la consulta para insertar, Editar, $insert_field[0] es la llave de la tabla principal
$insert_field[1]='saldo'; // hay un # de arreglo menos pues se inserta solo los campos de la tabla
$insert_field[2]='fecha_ingreso';
$insert_field[3]='id_cliente';
$insert_field[4]='';
$insert_field[5]='id_forma_pago';
$insert_field[6]='';
$insert_field[7]='id_punto_venta';

$insert_alias=array();
$insert_alias[0]=$alias_col[0]; //alias de los campos de la consulta, debe haber alias en todos los campos
$insert_alias[1]=$alias_col[1];
$insert_alias[2]=$alias_col[2];
$insert_alias[3]=$alias_col[3];
$insert_alias[4]='';
$insert_alias[5]=$alias_col[5];
$insert_alias[6]='';
$insert_alias[7]=$alias_col[7];

$name_input=array();
$name_input[0]=$alias_col[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$name_input[1]=$alias_col[1]; 
$name_input[2]=$alias_col[2]; 
$name_input[3]=$alias_col[4]; 
$name_input[4]=$alias_col[4];
$name_input[5]=$alias_col[6]; 
$name_input[6]=$alias_col[6];
$name_input[7]=$alias_col[7]; 

$label_input=array();
$label_input[0]=$columna[0]; // datos de columnas, se pone el alias de la consulta, debe haber alias en todos los campos
$label_input[1]=$columna[1]; // label de los inputs, se utiliza ya que en el listar puede haber campos de m�s seg�n las otras tablas anidadas
$label_input[2]=$columna[2];
$label_input[3]=$columna[4];
$label_input[4]=$columna[4];
$label_input[5]=$columna[6];
$label_input[6]=$columna[6];
$label_input[7]=$columna[7];

$field_unico=array();
$field_unico[0]=''; // fields que deben ser �nicos en la tabla en la BD, diferente de 1 y vac�o es para constrain, se pone el mismo valor en los id que combinados no deben repetirse
$field_unico[1]='';
$field_unico[2]='';
$field_unico[3]='';
$field_unico[4]='';
$field_unico[5]='';
$field_unico[6]='';
$field_unico[7]='';


$tipo_input=array();
$tipo_input[0]=''; // tipo de caja de texto, ejem: <input>,<selec> (NO TOCAR)
$tipo_input[1]='input';
$tipo_input[2]='input';
$tipo_input[3]='';
$tipo_input[4]='selectBD';
$tipo_input[5]='';
$tipo_input[6]='selectBD';
$tipo_input[7]='';


// valores que va a tomar el campo tipo <select> en cada <option>
$f=13;
$e=4;
$t=6;
$c=8;

$opt_name=array();$opt_value=array();$opt_sel=array();
$combo_sql[$e] = "select id_cliente as id_p, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as per from persona, cliente WHERE persona.id_persona=cliente.id_persona ORDER BY primer_apellido";

$opt_name[$e][0]='per';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Adem�s puedes tener del campo de la tabla en caso de selectBD
$opt_value[$e][0]='id_p';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$e][0]='id_p';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma est�tica se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$t] = "select id_forma_pago as id_f, forma_pago as forma from n_forma_pago ORDER BY forma";

$opt_name[$t][0]='forma';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Adem�s puedes tener del campo de la tabla en caso de selectBD
$opt_value[$t][0]='id_f';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$t][0]='id_f';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma est�tica se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD

$combo_sql[$c] = "select id_forma_pago AS id_f, forma_pago AS forma FROM n_forma_pago ORDER BY forma";

$opt_name[$c][0]='forma';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. //Adem�s puedes tener del campo de la tabla en caso de selectBD
$opt_value[$c][0]='id_f';//value del option, campo de la tabla externa de la consulta del combo
$opt_sel[$c][0]='id_f';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma est�tica se pone en uno solo "selected"// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD


$combo_sql[$f] = "";

$opt_name[$f][0]='<img width=10px src='.$x.'img/general/no.png>';//dato que va a mostrar al usuario ejem: Elemento 1, Elemento 2, etc. otro: Administrador, Vendedor, Contador, Invitado, etc. 
$opt_name[$f][1]='';//Adem�s puedes tener del campo de la tabla en caso de selectBD
//$opt_name[$f][2]='';
//$opt_name[$f][3]='';

$opt_value[$f][0]='1';//value del option, campo de la tabla externa de la consulta del combo
$opt_value[$f][1]='0';
//$opt_value[$f][2]='';
//$opt_value[$f][3]='';

$opt_sel[$f][0]='selected';//selected del option, campo de la tabla externa de la consulta del combo, en caso que sea de forma est�tica se pone en uno solo "selected"
$opt_sel[$f][1]='';// cuando sea selecBD en la primera fila se pone el alias del id de la tabla externa asociada al selecBD
//$opt_sel[$f][2]='';
//$opt_sel[$f][3]='';
// valores que va a tomar el campo tipo <select> en cada <option>

// valores que va a tomar el campo tipo <select> en cada <option>

$dato_permit[0]=''; // tipo de dato permitido en los input, ejem: varchar, entero, fecha, float, letras, selec, email, rango, la R es requerido (NO TOCAR)
$dato_permit[1]='Rinput';
$dato_permit[2]='Rinput';
$dato_permit[3]='';
$dato_permit[4]='Rselec';
$dato_permit[5]='';
$dato_permit[6]='Rselec';
$dato_permit[7]='';

$value_input[0]=''; // valor que va a tener el <input> (NO TOCAR)
$value_input[1]='';
$value_input[2]=date('Y-m-d');
$value_input[3]='';
$value_input[4]='';
$value_input[5]='';
$value_input[6]='';
$value_input[7]='';
$value_input[8]='';
$value_input[9]='';

$onclic[0]=''; // onclick a ejecutar en los input, normalmente es una funcion js (NO TOCAR)
$onclic[1]='';
$onclic[2]='displayCalendar(document.frm.'.$name_input[2].',"yyyy-m-d",this);';
$onclic[3]='';
$onclic[4]='';
$onclic[5]='';
$onclic[6]='';
$onclic[7]='';


$size[0]='50'; // tama�o del <input> (NO TOCAR)
$size[1]='50';
$size[2]='50';
$size[3]='';
$size[4]='50';
$size[5]='';
$size[6]='50';
$size[7]='';

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
$n_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Identificaci&oacute;n del consumidor');
$n_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Datos de factura del consumidor');
$n_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Consumidor');
$n_label_ayuda[3]=array('texto'=>$columna[6],'exp'=>'Punto de venta donde el consumidor tiene el saldo');
$n_label_ayuda[4]=array('texto'=>$columna[7],'exp'=>'Saldo disponible del consumidor');

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
$m_label_ayuda[0]=array('texto'=>$columna[2],'exp'=>'Identificaci&oacute;n del consumidor');
$m_label_ayuda[1]=array('texto'=>$columna[3],'exp'=>'Datos de factura del consumidor');
$m_label_ayuda[2]=array('texto'=>$columna[4],'exp'=>'Consumidor');
$m_label_ayuda[3]=array('texto'=>$columna[6],'exp'=>'Punto de venta donde el consumidor tiene el saldo');
$m_label_ayuda[4]=array('texto'=>$columna[7],'exp'=>'Saldo disponible del consumidor');

//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------
//------------------------------------------------Editar------------------------------------------------

$campos=$obj_var->Info_columnas($field_col,$info_col,$ancho,$columna,$href_m,$field);// para mostrar info en columnas (NO TOCAR)
$filtros=$obj_var->Info_filtro($field_col,$info_emerg,$columna,$field,$info_col);// para mostrar info en filtros, depende de $info_emerg (NO TOCAR)

//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
//archivo de configuraci�n de un elemento o tabla de la BD, copiar o clonar la carpeta del elemento y hacer los cambios aqu�
?>