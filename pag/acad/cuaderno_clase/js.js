$(document).ready(function(){
//$(".sel_filtro_asis").select2();
//$(".sel_filtro_cal").select2();
$(".sel_filtro_est").select2();
});

function calc_promedio(script,campos_origen, filas, callback)
{
	var campos_value='';
	campos_origen = String(campos_origen).split(",");
	
	for (i=0;i<(campos_origen.length);i+=1) 
  	{
		if(campos_value=='')
		campos_value="campo0=" + eval('document.frm.'+ campos_origen[0] +'.value');
		else
		campos_value=campos_value + "&campo"+ i +"="+eval('document.frm.'+ campos_origen[i] +'.value');
	}
	campos_value=campos_value + "&filas"+"="+filas;

	if(campos_value)
	{
		ajax=objetoAjax();
		ajax.open("POST", script,true);

		ajax.onreadystatechange=function()
		{
			if(ajax.readyState==4)
			{
				texto_devuelto=ajax.responseText;//alert(texto_devuelto);
				
				fila = String(filas).split(",");
				value = String(texto_devuelto).split(",");//alert(fila.length);
				
				for (i=0;i<(value.length);i+=1) 
				{
					hot.setDataAtCell(fila[i] , 1, value[i], 'celda_promedio');
					if(callback)callback();
				}
			}
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send(campos_value);
	}
}

function cambiar_asistencia(id_imagen)
{
	if (document.getElementById)
	{	
		imagen1=new Image
		imagen1.src="../../../img/acad/asistencia/ok.png";
		imagen2=new Image
		imagen2.src="../../../img/acad/asistencia/atraso.png";
		imagen3=new Image
		imagen3.src="../../../img/acad/asistencia/tarjeta_amarilla.png";
		imagen4=new Image
		imagen4.src="../../../img/acad/asistencia/tarjeta_roja.png";

		if(document.images[id_imagen].src == imagen1.src)
		{
			document.images[id_imagen].src = imagen2.src;
			
		}
		else if(document.images[id_imagen].src == imagen2.src)
		{
			document.images[id_imagen].src = imagen3.src;
		}
		else if(document.images[id_imagen].src == imagen3.src)
		{
			document.images[id_imagen].src = imagen4.src;
		}
		else 
		{
			document.images[id_imagen].src = imagen1.src;
		}
		ejecutar_ajax('asistencia/guardar_inasistencia.php','hdn_celda_'+id_imagen,'')
	}
}

//--------------------UPLOAD---------------------

function subirArchivos() {
	$("#archivo").upload('calificacion/upload/subir_archivo.php',
	{
		nombre_archivo: $("#nombre_archivo").val()
	},
	function(respuesta) {
		//Subida finalizada.
		$("#barra_de_progreso").val(0);
		if (respuesta === 1) {
			mostrarRespuesta('El archivo ha sido subido correctamente.', true);
			$("#nombre_archivo, #archivo").val('');
		} else {
			mostrarRespuesta('El archivo no se ha podido subir. Debe subir archivos de menor tama&ntilde;o a 4Mb.', false);
		}
		mostrarArchivos();
	}, function(progreso, valor) {
		//Barra de progreso.
		$("#barra_de_progreso").val(valor);
	});
}
function eliminarArchivos(archivo) {
	$.ajax({
		url: 'calificacion/upload/eliminar_archivo.php',
		type: 'POST',
		timeout: 10000,
		data: {archivo: archivo},
		error: function() {
			mostrarRespuesta('Error al intentar eliminar el archivo.', false);
		},
		success: function(respuesta) {
			if (respuesta == 1) {
				mostrarRespuesta('El archivo ha sido eliminado.', true);
			} else {
				mostrarRespuesta('Error al intentar eliminar el archivo.', false);                            
			}
			mostrarArchivos();
		}
	});
}


function mostrarArchivos() {
	$.ajax({
		url: 'calificacion/upload/mostrar_archivos.php',
		dataType: 'JSON',
		success: function(respuesta) {
			if (respuesta) {
				var html = '';
				for (var i = 0; i < respuesta.length; i++) {
					if (respuesta[i] != undefined) {
						html += '&nbsp;<span class="archivos_subidos"> ' + respuesta[i] + '<br><br> <a onclick="eliminarArchivos(\'' + respuesta[i] + '\');" href="javascript:void(0);"> <img id="eliminar" width="25" border="0" height="25" name="eliminar" alt="Eliminar" src="../../../img/general/eliminar_rojo.png"> </a> </span>';
				   }
				}//alert(html);
				$("#archivos_subidos").html(html);
				if(html!='' && document.getElementById('row_archivos_subidos'))
				{
					obj = document.getElementById('row_archivos_subidos');
					obj.style.display = 'table-row';
				}
				else if(document.getElementById('row_archivos_subidos'))
				{
					obj = document.getElementById('row_archivos_subidos');
					obj.style.display = 'none';
				}
			}
		}
	});
}
function mostrarRespuesta(mensaje, ok){
	//$("#respuesta").removeClass('alert-success').removeClass('alert-danger').html(mensaje);
	if(ok){
		alertify.success(mensaje);
		//$("#respuesta").addClass('alert-success');
	}else{
		alertify.error(mensaje);
		//$("#respuesta").addClass('alert-danger');
	}
}

function poner_valor(){
    document.getElementById("nombre_archivo").value = document.getElementById("archivo").value;
};

function vaciar_tmp()
{
	$.ajax({
		url: 'calificacion/upload/vaciar_tmp.php',
	});
}

//-----------------------------------------------------------------------------------------------------

function subirArchivos_mod(id_tarea) {
	$("#archivo_mod").upload('calificacion/upload/subir_archivo_mod.php',
	{
		nombre_archivo_mod: $("#nombre_archivo_mod").val()
	},
	function(respuesta) {
		//Subida finalizada.
		$("#barra_de_progreso_mod").val(0);
		if (respuesta === 1) {
			mostrarRespuesta('El archivo ha sido subido correctamente.', true);
			$("#nombre_archivo_mod, #archivo_mod").val('');
		} else {
			mostrarRespuesta('El archivo no se ha podido subir. Debe subir archivos de menor tama&ntilde;o a 4Mb.', false);
		}
		mostrarArchivos_mod(id_tarea);
	}, function(progreso, valor) {
		//Barra de progreso.
		$("#barra_de_progreso_mod").val(valor);
	});
}

function eliminarArchivos_mod(archivo, id_tarea)
{
	$.ajax({
		url: 'calificacion/upload/eliminar_archivo_mod.php',
		type: 'POST',
		timeout: 10000,
		data: {archivo: archivo, id_tarea: id_tarea},
		error: function() {
			mostrarRespuesta('Error al intentar eliminar el archivo.', false);
		},
		success: function(respuesta) {
			if (respuesta == 1) {
				mostrarRespuesta('El archivo ha sido eliminado.', true);
			} else {
				mostrarRespuesta('Error al intentar eliminar el archivo.', false);                            
			}
			mostrarArchivos_mod(id_tarea);
		}
	});
}

function mostrarArchivos_mod(id_tarea) {
	$.ajax({
		url: 'calificacion/upload/mostrar_archivos_mod.php',
		dataType: 'JSON',
		data: {id_tarea: id_tarea},
		success: function(respuesta) {
			if (respuesta) {
				var html = '';
				for (var i = 0; i < respuesta.length; i++) {
					if (respuesta[i] != undefined) {
						html += '&nbsp;<span class="archivos_subidos"> ' + respuesta[i] + '<br><br> <a onclick="eliminarArchivos_mod(\'' + respuesta[i] + '\', \'' + id_tarea + '\');" href="javascript:void(0);"> <img id="eliminar" width="25" border="0" height="25" name="eliminar" alt="Eliminar" src="../../../img/general/eliminar_rojo.png"> </a> </span>';
				   }
				}//alert(html);
				$("#archivos_subidos_mod").html(html);
				if(html!='' && document.getElementById('row_archivos_subidos_mod'))
				{
					obj = document.getElementById('row_archivos_subidos_mod');
					obj.style.display = 'table-row';
				}
				else if(document.getElementById('row_archivos_subidos_mod'))
				{
					obj = document.getElementById('row_archivos_subidos_mod');
					obj.style.display = 'none';
				}
			}
		}
	});
}

function poner_valor_mod(){
    document.getElementById("nombre_archivo_mod").value = document.getElementById("archivo_mod").value;
};