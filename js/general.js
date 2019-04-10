function marcar()
{arr_a = String(document.frm.var_checkbox.value).split(","); //alert(document.frm.var_checkbox.value);
	for (i=0;i<arr_a.length;i++)
	{//alert (arr_a[i]);
	eval('checkbox = document.frm.checkbox_'+arr_a[i]);
	chequeado = eval("document.frm.checkbox.checked");
	  if (chequeado)
	 checkbox.checked = true; 
	 else
	 checkbox.checked = false; 
	} 
}

function marcar_p(cbx_id_accion)
{arr_a = String(document.frm.var_checkbox.value).split(","); //alert(document.frm.var_checkbox.value);
	for (i=0;i<arr_a.length;i++)
	{
		n=cbx_id_accion.toString();//alert('cbx_id_accion:'+cbx_id_accion);
		//alert(n.length);//alert (arr_a[i].substring(arr_a[i].length-2));
		if(arr_a[i].substring(arr_a[i].length-n.length)==cbx_id_accion)
		{//alert('si');
			checkbox =eval('document.frm.checkbox_'+arr_a[i]);
			//eval("checkbox=document.frm.checkbox_"+arr_a[i]+".checked");
			chequeado = eval("document.frm.checkbox_"+cbx_id_accion+".checked");//alert (cbx_id_accion);
			if (chequeado)
				checkbox.checked = true; 
			else
				checkbox.checked = false;
		}
	} 
}

function pulsar(e) 
{
	tecla = (document.all) ? e.keyCode :e.which;
	if(tecla=='13'){document.frm.submit();}
	//alert(tecla);
}

function MM_findObj(n, d) 
{ //v4.01
	var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
	d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
	if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
	for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
	if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function validar_form() 
{ //v4.0
//alert("sss");
	var i,p,q,nm,test,num,min,max,errors='',args=validar_form.arguments;
	for (i=0; i<(args.length-2); i+=3) 
  	{ 
		test=args[i+2]; val=MM_findObj(args[i]);
    	if (val) 
		{ nm=val.title; //alert(val.title);
		  val=val.value;//alert(args[i+2]);
		  lenght=val.length;
		  No=false;
			if (val!="") 
			{//alert (test.indexOf('selec'));
				if (test.indexOf('letras')!=-1) 
					{
						for(j=0; j<lenght; j++)
						{				
						aux=val.substring(j,j+1);

							if((isNaN(aux))==false && aux!=" ")
							{
								No=true;
							}
						}
						if(No)
						errors+='El campo '+nm+' debe contener solo letras.<br>';										
					}
					
				else if (test.indexOf('selec')!=-1) 
					{ //alert (val);
					if(val=="no")// || val=="0"
						errors+='Debe escoger el campo '+nm+'.<br>';	//alert(val.style.display);										
					}
								
     		    else if (test.indexOf('email')!=-1) 
		 		{ 
					p=val.indexOf('@');
     	  			if (p<1 || p==(val.length-1)) errors+='El campo '+nm+' es una dirección de correo.<br>';
    			}
					
				else if (test.indexOf('fecha')!=-1) 
		 		{ 
					p=val.indexOf('-');
     	  			if (p<1 || p==(val.length-1)) errors+='El campo '+nm+' debe tener el siguiente formato (Y-m-d).<br>';
    			}
					
				else if (test.indexOf('entero')!=-1)
				{ 
				//alert(test);
					num = parseFloat(val);
					if (isNaN(val)) errors+='El campo '+nm+' debe contener solo números.<br>';
					
					if (test.indexOf('rango') != -1) 
					{ 
						p=test.indexOf(':');
						min=test.substring(8,p); max=test.substring(p+1);
						if (num<min || max<num) errors+='El campo '+nm+' debe contener números entre '+min+' y '+max+'.<br>';
					} 
				} 
				
			}
			else if (test.charAt(0) == 'R') errors += 'El campo '+nm+' es requerido.<br>'; 
		}
	} 
	if (errors)  //Ext.MessageBox.alert('Mensaje', 'El siguiente error ocurrió:<br>'+errors);//alert('El siguiente error ocurrió:\n'+errors);
	alertify.error('El siguiente error ocurri\u00F3:<br>'+errors);//alert('El siguiente error ocurrió:\n'+errors);
	//document.MM_returnValue = (errors == ''); 
	else
	{
		//alert("fffffffff");
		document.frm.aux_submit.value='ok';
		document.frm.submit();
	}
}

function validar_sin_submit() 
{ //v4.0

	var i,p,q,nm,test,num,min,max,errors='',args=validar_sin_submit.arguments;
	for (i=0; i<(args.length-2); i+=3) 
  	{ 
		test=args[i+2]; val=MM_findObj(args[i]);
    	if (val) 
		{ nm=val.title; //alert(val.title);//alert(args[i+2]);alert(document.frm.fechaa.value);
		  val=val.value;
		  lenght=val.length;
		  No=false;
			if (val!="") 
			{
				if (test.indexOf('letras')!=-1) 
					{
						for(j=0; j<lenght; j++)
						{				
						aux=val.substring(j,j+1);

							if((isNaN(aux))==false && aux!=" ")
							{
								No=true;
							}
						}
						if(No)
						errors+='El campo '+nm+' debe contener solo letras.<br>';										
					}
					
				else if (test.indexOf('selec')!=-1) //alert (val);
					{ if(val=="no")
						errors+='Debe escoger el campo '+nm+'.<br>';											
					}
								
     		    else if (test.indexOf('email')!=-1) 
		 		{ 
					p=val.indexOf('@');
     	  			if (p<1 || p==(val.length-1)) errors+='El campo '+nm+' es una dirección de correo.<br>';
    			}
					
				else if (test.indexOf('fecha')!=-1) 
		 		{ 
					p=val.indexOf('-');
     	  			if (p<1 || p==(val.length-1)) errors+='El campo '+nm+' debe tener el siguiente formato (d-m-Y).<br>';
    			}
					
				else if (test.indexOf('entero')!=-1)
				{ 
				//alert(test);
					num = parseFloat(val);
					if (isNaN(val)) errors+='El campo '+nm+' debe contener solo números.<br>';
					
					if (test.indexOf('rango') != -1) 
					{ 
						p=test.indexOf(':');
						min=test.substring(8,p); max=test.substring(p+1);
						if (num<min || max<num) errors+='El campo '+nm+' debe contener números entre '+min+' y '+max+'.<br>';
					} 
				} 
				
			}
			else if (test.charAt(0) == 'R') errors += 'El campo '+nm+' es requerido.<br>'; 
		}
	} 
	if (errors)  //Ext.MessageBox.alert('Mensaje', 'El siguiente error ocurrió:<br>'+errors);//alert('El siguiente error ocurrió:\n'+errors);
	{
		alertify.error('El siguiente error ocurrió:<br>'+errors);//alert('El siguiente error ocurrió:\n'+errors);
		return 0;
	}
	
	
}

function seleccion_aux()
{
	sel = ""; 
	arr_a = String(document.frm.var_checkbox.value).split(","); //arreglo con los id
	//alert(document.frm.var_checkbox.value);alert(arr_a.length);
	
	for (i=0;i<arr_a.length;i++)
	{//alert(arr_a[i]);
		art_sel = eval("document.frm.checkbox_"+arr_a[i]+".checked");// alert(art_sel);// noticia seleccionada
		if (art_sel)
		{
			if(String(sel)!="")
			{ 		 
				sel += ","+arr_a[i]; //se guarda id seleccionado
			}
			else
			{
				sel = arr_a[i]; //se guarda id seleccionado
			}
		}			
	} 
	//alert(sel);
return(sel);
}

function seleccion(act)
{  
	msg = "Debe seleccionar al menos una casilla.";
	       
	if(seleccion_aux() != "")
	{  
		alertify.confirm("Confirma que desea ejecutar la acción?", function (e){
		if(e) 
		{
			
			document.frm.action=act;//alert(act);
			document.frm.var_aux.value=seleccion_aux();
			document.frm.submit();
			alertify.success("Has pulsado '" + alertify.labels.ok + "'");
		} 
		else 
		{ 
			alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
		}
		});

	}
	else
	{
		if (msg) alertify.error(msg);
		
	} 
}

function Editar_aux()
{
	sel = ""; 
	arr_a = String(document.frm.var_checkbox.value).split(","); //arreglo con los id
	//alert(document.frm.var_checkbox.value);alert(arr_a.length);
	
	for (i=0;i<arr_a.length;i++)
	{//alert(arr_a[i]);alert(i);
		art_sel = eval("document.frm.checkbox_"+arr_a[i]+".checked");// alert("i:" + i);alert(art_sel);// noticia seleccionada
		if (art_sel==true)
		{//alert("entro");
			sel = arr_a[i]; //se guarda id seleccionado
			i=arr_a.length;
		}			
	} 
return(sel);
}

function modif(act)
{
	msg = "Debe seleccionar al menos una casilla.";
	       
	if(Editar_aux() != "")
	{  //alert("fff");
		document.frm.action=act;//alert(act);
		document.frm.var_aux.value=Editar_aux();//alert(document.frm.var_aux.value);
		document.frm.submit();
	}
	else
	{
		if (msg) alertify.error(msg);
	} 
}


function validarFecha(input1, input2)
{
	if(input1.value>=input2.value && input1.value!='' && input2.value !='')
	alertify.alert('El campo '+input1.title+' debe ser menor que el campo '+input2.title);
}

function Cambio(id_imagen)
{ 
	if (document.getElementById)
	{	
		imagen1=new Image
		imagen1.src="../img/conf/llave1.gif";
		imagen2=new Image
		imagen2.src="../img/conf/llave2.gif";
		imagen3=new Image
		imagen3.src="../img/conf/llave3.gif";
		imagen4=new Image
		imagen4.src="../img/conf/llave4.gif";
		//alert(id_imagen);
		 if(document.images[id_imagen].src == imagen1.src)
			document.images[id_imagen].src = imagen2.src;
		 else if(document.images[id_imagen].src == imagen2.src)
			document.images[id_imagen].src = imagen3.src;
		 else if(document.images[id_imagen].src == imagen3.src)
			document.images[id_imagen].src = imagen4.src;
		 else 
			document.images[id_imagen].src = imagen1.src;
	}	
}

function Requerido(edt)
{
	if(edt=="txt_usuario")
	{
		if(document.frm.txt_usuario.value=="")
		{
			document.frm.txt_usuario.style.borderColor = '#FF0000';
			//document.frm.txt_usuario.style.color = '#cccccc';
			//document.frm.txt_usuario.value="Usuario";
		}
		else
		document.frm.txt_usuario.style.borderColor = '#ffffff';
	}
	
	if(edt=="txt_pass")
	{
		if(document.frm.txt_pass.value=="")
		{
			document.frm.txt_pass.style.borderColor = '#FF0000';
			//document.frm.txt_pass.style.color = '#cccccc';
			//document.frm.txt_pass.type='text';
			//document.frm.txt_pass.value="Clave"; 	
		}
		else
		document.frm.txt_pass.style.borderColor = '#ffffff';
	}
}

function valida_pass(pag)
{
	if(pag=="autenticacion")
	{
		if(document.frm.txt_pass.value=='' || document.frm.txt_usuario.value=='')
			alertify.error("No hay datos proporcionados.");
		else
		{
			if(document.frm.txt_pass.value.length<=4)
			{
				//alertify.alert("Debe cambiar la contraseña para que contenga al menos 5 caracteres.");
				document.frm.action="cambiar_clave.php?mensaje=Debe cambiar la clave para que contenga al menos 5 caracteres.";
				document.frm.submit();
			}
		}
	}
	if(pag=="cambiar")
	{//alert (pag);alert(document.frm.txt_nclave1.value);
		if(document.frm.txt_pass.value=='' || document.frm.txt_usuario.value=='' || document.frm.txt_nclave.value=='' || document.frm.txt_confirmar.value=='')
			{alertify.error("No hay datos proporcionados.");}
		
		if(document.frm.txt_nclave.value!=document.frm.txt_confirmar.value)
			{alertify.error("Debe confirmar correctamente la nueva contraseña.");}
	}
}

function valida_radio()
{
	msg="";
	
	ok_e="";
	arr_e = String(document.frm.cadena_id_evaluacion.value).split(",");
	
	//ok_p="";
	//arr_p = String(document.frm.cadena_id_ponderacion.value).split(",");
	
	for (i=0;i<arr_e.length;i++)
	{
		cant_radios = eval("document.frm.radio_"+arr_e[i]+".length");
		
		
		for (r=0;r<cant_radios;r++)
		{
			if(eval("document.frm.radio_"+arr_e[i]+"["+r+"].checked") == true)
			{
				ok_e=1;
				r=cant_radios;
			}			
		}
		if(ok_e!=1)
		msg+="Debe seleccionar una evaluación del criterio número "+ eval(i + 1) +".<br>"
	
	ok_e="";
	}
	
	
	if(msg)
	{
		alertify.error('El siguiente error ocurrió:<br>'+msg);
	}
	else
	{
		document.frm.var_aux.value='ok';
		//alert('Su informacion se guardó satisfactoriamente');
		document.frm.submit();
	}
}

function ocultar_filas(id_fila) 
{
	obj = document.getElementById(id_fila);
	obj.style.display = (obj.style.display=='none') ? 'block' : 'none';
}

function siguiente_anterior(next) 
{
	var cliente=document.frm.cliente.value;
	var clientes=document.frm.clientes.value;
	var mostrar;
	
	arr_clientes = String(clientes).split(",");
	
	for (i=0;i<arr_clientes.length;i++)
	{
		if(next=='next' && arr_clientes[i]==cliente && !isNaN(arr_clientes[i+1]))
		{
			mostrar=arr_clientes[i+1];
			persona=eval("document.frm.cliente_seleccionado_"+arr_clientes[i+1]+".value");
		}
		else if(next=='prev' && arr_clientes[i]==cliente && !isNaN(arr_clientes[i-1]))
		{
			mostrar=arr_clientes[i-1];
			persona=eval("document.frm.cliente_seleccionado_"+arr_clientes[i-1]+".value");
		}
		
		if(!isNaN(mostrar))
		{
			obj = document.getElementById('id_'+arr_clientes[i]);
			obj.style.display = 'none';
		}
	}
	
	if(!isNaN(mostrar))
	{
		obj = document.getElementById('id_'+mostrar);
		obj.style.display = 'table';
		document.frm.cliente.value=mostrar;
		document.frm.cliente_seleccionado.value=persona;
	}
}


function submit(act)
{ 
	document.frm.action=act;
	document.frm.submit();
}

function seleccion_s(act)
{  
	msg = "Debe seleccionar al menos una casilla.";
	       
	if(seleccion_aux() != "")
	{  
		alertify.confirm("Confirma que desea agregar saldo a estos clientes?", function (e){
		if(e) 
		{
			
			document.frm.action=act;//alert(act);
			document.frm.var_aux.value=seleccion_aux();
			document.frm.submit();
			alertify.success("Has pulsado '" + alertify.labels.ok + "'");
		} 
		else 
		{ 
			alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
		}
		});

	}
	else
	{
		if (msg) alertify.error(msg);
		
	} 
}

function seleccion_elem(act)
{  
	msg = "Debe seleccionar al menos una casilla.";
	       
	if(seleccion_aux() != "")
	{  
		alertify.confirm("Confirma que desea ejecutar la acción?", function (e){
		if(e) 
		{
			
			document.frm.action=act;//alert(act);
			document.frm.var_aux.value=seleccion_aux();
			document.frm.submit();
			alertify.success("Has pulsado '" + alertify.labels.ok + "'");
		} 
		else 
		{ 
			alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
		}
		});

	}
	else
	{
		if (msg) alertify.error(msg);
		
	} 
}





function seleccionar_elementos_aux(uno_varios)
{
	sel = ""; 
	arr_a = String(document.frm.var_checkbox.value).split(","); //arreglo con los id	//alert(document.frm.var_checkbox.value);alert(arr_a.length);
	
	if(uno_varios=='uno')
	elem=1;
	elseif(uno_varios=='varios')
	elem=arr_a.length;
	
	for (i=0;i<elem;i++)
	{//alert(arr_a[i]);
		art_sel = eval("document.frm.checkbox_"+arr_a[i]+".checked"); //alert(art_sel);// noticia seleccionada
		if (art_sel)
		{
			if(String(sel)!="")
			{ 		 
				sel += ","+arr_a[i]; //se guarda id seleccionado
			}
			else
			{
				sel = arr_a[i]; //se guarda id seleccionado
			}
		}			
	} 
return(sel);
}

function seleccionar_elementos(pagina_destino, mensaje_error, mensaje_confirmacion, uno_varios)
{
	if(seleccionar_elementos_aux(uno_varios) != "")
	{  
		alertify.confirm(mensaje_confirmacion, function (e){
		if(e) 
		{			
			document.frm.action=pagina_destino;
			document.frm.var_aux.value=seleccionar_elementos_aux(uno_varios);
			document.frm.submit();
			alertify.success("Has pulsado '" + alertify.labels.ok + "'");
		} 
		else 
		{ 
			alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
		}
		});
	}
	else
	{
		if (mensaje_error) alertify.error(mensaje_error);		
	} 
}

function poner_valor_up(name_input_file) 
{
    document.getElementById("up_"+name_input_file).value = document.getElementById(name_input_file).value;
};

//------------------------------GUARDAR CON AJAX-----------------------------------
//------------------------------GUARDAR CON AJAX-----------------------------------
//------------------------------GUARDAR CON AJAX-----------------------------------
function objetoAjax()
{
	var xmlhttp=false;
	try {xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");}
	catch (e){try {xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");} catch (E){xmlhttp = false;}}
 
	if (!xmlhttp && typeof XMLHttpRequest!='undefined')
	{xmlhttp = new XMLHttpRequest();}
	return xmlhttp;
}

function guardar_sin_recargar(script,campos_origen, campo_destino)
{
	var campos_value='';
	campos_origen = String(campos_origen).split(",");
	
	for (i=0;i<(campos_origen.length);i+=1) 
  	{
		//alert(campos_origen[i]);
		if(campos_value=='')
		campos_value="campo0=" + eval('document.frm.'+ campos_origen[0] +'.value');
		else
		campos_value=campos_value + "&campo"+ i +"="+eval('document.frm.'+ campos_origen[i] +'.value');
	}
	//alert(campos_value);
	
	if(campos_value)
	{	
		
		ajax=objetoAjax();
		ajax.open("POST", script,true);

		ajax.onreadystatechange=function()
		{
			if(ajax.readyState==4)
			{
				texto_devuelto = ajax.responseText;//alert(texto_devuelto);
				texto_devuelto = String(texto_devuelto).split(",");
				
				if(campo_destino)
				{
					$("#" + campo_destino).append('<option value="'+ texto_devuelto[0] +'" selected="selected">'+ texto_devuelto[1] +'</option>');
					$("#" + campo_destino).select2();
					limpiar_campos(campos_origen);
				}
			}
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send(campos_value);
	}
}

function limpiar_campos(campos_origen)
{
	for (i=0;i<(campos_origen.length);i+=1) 
  	{ 
		eval('document.frm.' + campos_origen[i] + '.value=""');
	}
}

function ejecutar_ajax(script,campos_origen, div_destino, callback)
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
	//alert(campos_value);
	if(campos_value)
	{
		ajax=objetoAjax();
		ajax.open("POST", script,true);

		ajax.onreadystatechange=function()
		{
			if(ajax.readyState==4)
			{
				texto_devuelto = ajax.responseText;//alert(texto_devuelto);alert(div_destino);
				if(div_destino)SetContainerHTML(div_destino, texto_devuelto);
				if(callback)callback();
				//return 1;
			}
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send(campos_value);
	}	
}

function ejecutar_ajax2(script,campos_origen, div_destino, callback)
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
	
	if(campos_value)
	{
		ajax2=objetoAjax();
		ajax2.open("POST", script,true);

		ajax2.onreadystatechange=function()
		{
			if(ajax2.readyState==4)
			{
				texto_devuelto = ajax2.responseText;//alert(texto_devuelto);
				if(div_destino)SetContainerHTML(div_destino, texto_devuelto);
				if(callback)callback();
			}
		}
		ajax2.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax2.send(campos_value);
	}	
}

function ejecutar_ajax3(script,campos_origen, div_destino, callback)
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
	
	if(campos_value)
	{
		ajax3=objetoAjax();
		ajax3.open("POST", script,true);

		ajax3.onreadystatechange=function()
		{
			if(ajax3.readyState==4)
			{
				texto_devuelto = ajax3.responseText;//alert(texto_devuelto);
				if(div_destino)SetContainerHTML(div_destino, texto_devuelto);
				if(callback)callback();
			}
		}
		ajax3.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax3.send(campos_value);
	}	
}

function ejecutar_ajax1(script,campos_origen, div_destino, callback)
{
	var campos_value='';
	campos_origen = String(campos_origen).split(",");
	
	for (i=0;i<(campos_origen.length);i+=1) 
  	{
		if(campos_value=='')
		campos_value="campo0=" + eval('document.frm.'+ campos_origen[0] +'.value');
		else
		campos_value=campos_value + "&campo"+ i +"="+eval('document.frm.'+ campos_origen[i] +'.value');//alert(eval('document.frm.'+ campos_origen[i] +'.value'));
	}
	
	if(campos_value)
	{
		ajax1=objetoAjax();
		ajax1.open("POST", script,true);

		ajax1.onreadystatechange=function()
		{
			if(ajax1.readyState==4)
			{
				texto_devuelto = ajax1.responseText;//alert(texto_devuelto);
				SetContainerHTML(div_destino, texto_devuelto);
				if(callback)callback();
			}
		}
		ajax1.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax1.send(campos_value);
	}	
}

function SetContainerHTML(id_contenedor,responseText) 
{ 
	mydiv = document.getElementById(id_contenedor); //alert(id_contenedor);
	mydiv.innerHTML = responseText; 
	var elementos = mydiv.getElementsByTagName('script'); 
	for(i=0;i<elementos.length;i++) 
	{ 
		old=document.getElementById('prefix'+i); 
		//if(old)mydiv.removeChild(old);
		var elemento = elementos[i]; 
		nuevoScript = document.createElement('script'); 
		nuevoScript.text = elemento.innerHTML; 
		nuevoScript.type = 'text/javascript'; 
		nuevoScript.id = 'prefix'+i; 
		if(elemento.src!=null && elemento.src.length>0) 
		{nuevoScript.src = elemento.src;} 
		elemento.parentNode.replaceChild(nuevoScript,elemento); 
	}
} 
//------------------------------GUARDAR CON AJAX-----------------------------------
//------------------------------GUARDAR CON AJAX-----------------------------------
//------------------------------GUARDAR CON AJAX-----------------------------------