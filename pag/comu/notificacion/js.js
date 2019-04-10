
//--------------------UPLOAD---------------------

function subirArchivos() {
	$("#archivo").upload('upload/subir_archivo.php',
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
			mostrarRespuesta('El archivo no se ha podido subir.', false);
		}
		mostrarArchivos();
	}, function(progreso, valor) {
		//Barra de progreso.
		$("#barra_de_progreso").val(valor);
	});
}
function eliminarArchivos(archivo) {
	$.ajax({
		url: 'upload/eliminar_archivo.php',
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
		url: 'upload/mostrar_archivos.php',
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
				if(html!='')
				{
					obj = document.getElementById('row_archivos_subidos');
					obj.style.display = 'table-row';
				}
				else
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
		url: 'upload/vaciar_tmp.php',
	});
}

//-----------------------------------------------------------------------------------------------------

function subirArchivos_mod(id_tarea) {
	$("#archivo_mod").upload('upload/subir_archivo_mod.php',
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
			mostrarRespuesta('El archivo no se ha podido subir.', false);
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
		url: 'upload/eliminar_archivo_mod.php',
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
		url: 'upload/mostrar_archivos_mod.php',
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
				if(html!='')
				{
					obj = document.getElementById('row_archivos_subidos_mod');
					obj.style.display = 'table-row';
				}
				else
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