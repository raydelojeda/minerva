<?php
class clases_menu
{
	function menu_mod($rs_sesion)
	{
		//--------Módulo de configuración del sistema---------
		//--------Módulo de configuración del sistema---------
		//--------Módulo de configuración del sistema---------
		if(isset($_SESSION["modulo"]))
		{
			if($_SESSION["modulo"]=="conf")
			{
				$mod="conf";
				
				$elemento="usuario";$label="Usuario";$ayuda=$label." del sistema.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				[null,'<?php print $label;?>','https://'+dir+site+'/seguridad/<?php print $elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php break;}$rs_sesion->MoveNext();}?>
				
				<?php $elemento="usuario_rol";$label="Usuario y roles";$ayuda=$label." para acceder al sistema.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
				[null,'<?php print $label;?>','https://'+dir+site+'/seguridad/<?php print $elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php break;}$rs_sesion->MoveNext();}?>	
				
				<?php $elemento="permiso";$label="Permisos";$ayuda=$label." del rol del usuario.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
				[null,'<?php print $label;?>','https://'+dir+site+'/seguridad/<?php print $elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php break;}$rs_sesion->MoveNext();}	

				$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['modulo']==$mod){?>
				[null,'Nomencladores',null,null,'Nomencladores o parametrizaci&oacute;n.',
					
					<?php $elemento="rol";$label="Rol";$ayuda=$label." del usuario.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/seguridad/<?php print $elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					<?php $elemento="elemento";$label="Elemento";$ayuda=$label." o tabla de la BD.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/seguridad/<?php print $elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>	
					
					<?php $elemento="accion";$label="Acci&oacute;n";$ayuda=$label." permitida al usuario.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/seguridad/<?php print $elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					<?php $elemento="estilo";$label="Estilo";$ayuda=$label." preferido por el usuario.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/seguridad/<?php print $elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
					
				],
				<?php break;}$rs_sesion->MoveNext();}
				
			}
			//--------Módulo de configuración del sistema---------
			//--------Módulo de configuración del sistema---------
			//--------Módulo de configuración del sistema---------
			
			
			
			
			//----RRHH----
			//----RRHH----
			//----RRHH----
			//print $_SESSION["modulo"];
			elseif($_SESSION["modulo"]=="rrhh")
			{
				$mod="rrhh";
				
				$elemento="empleado";$label="Empleados";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND ($rs_sesion->fields['elemento']=='persona'  OR $rs_sesion->fields['elemento']=='empleado')){?>	
				[null,'<?php print $label;?>',null,null,'<?php print $ayuda;?>',
				
					<?php $elemento="persona";$label="Persona";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					<?php $elemento="empleado";$label="Empleado";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					_cmSplit,

					<?php $elemento="ingreso_salida";$label="Ingreso o salida";$ayuda=$label." del empleado.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>

					<?php $elemento="cargo_empleado";$label="Cargo del empleado";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
								
					_cmSplit,

					<?php $rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND ($rs_sesion->fields['elemento']=='genero') OR $rs_sesion->fields['elemento']=='pais' OR $rs_sesion->fields['elemento']=='tipo_sangre' OR $rs_sesion->fields['elemento']=='competencia'){?>
					['<img src="https://'+dir+site+img+'/configuracion.png" >','Par&aacute;metros',null,null,'Nomencladores o parametrizaci&oacute;n.',
					
						<?php $elemento="autoriza";$label="Qui&eacute;n autoriza permisos?";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						_cmSplit,
						
						<?php $elemento="genero";$label="G&eacute;nero";$ayuda=$label." de la persona.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="tipo_identificacion";$label="Tipo de identificaci&oacute;n";$ayuda=$label." de la persona.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="pais";$label="Pa&iacute;s";$ayuda=$label." de la persona.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>	
						
						<?php $elemento="tipo_sangre";$label="Tipo de sangre";$ayuda=$label." de la persona.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="cargo";$label="Cargo";$ayuda=$label." del empleado.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="sist_salario";$label="Sistema salario";$ayuda=$label." del empleado.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="grupo_gastos";$label="Grupo de gastos";$ayuda=$label." del empleado.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="tipo_contrato";$label="Tipo de contrato";$ayuda=$label." del empleado.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="titulo";$label="T&iacute;tulo";$ayuda=$label." del empleado.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="inst_educativa";$label="Instituci&oacute;n educativa";$ayuda=$label." del empleado.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="estado_civil";$label="Estado civil";$ayuda=$label." del empleado.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="dpto";$label="Departamento";$ayuda=$label." del empleado.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="seccion";$label="Secci&oacute;n";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="tipo_cuenta";$label="Tipo de cuenta";$ayuda=$label." de la persona.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="causa_ing_sal";$label="Causa de ingreso o salida";$ayuda=$label." del empleado.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
					],
					<?php break;}$rs_sesion->MoveNext();}?>				
				],
				<?php break;}$rs_sesion->MoveNext();}?>
				
				<?php $rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND ($rs_sesion->fields['elemento']=='grupo'  OR $rs_sesion->fields['elemento']=='jornada')){?>
				[null,'N&oacute;mina',null,null,'N&oacute;mina de empleados.',
				
					<?php $elemento="registro_biometrico";$label="Registro biom&eacute;trico";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					<?php $elemento="ausencia";$label="Ausencia o permiso";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND ($rs_sesion->fields['elemento']==$elemento  OR $rs_sesion->fields['elemento']=='desempeno2')){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>0.png" >','<?php print $label;?>',null,null,'<?php print $ayuda;?>',
					
					
						<?php $elemento="ausencia";$label="Solicitud";$ayuda=$label." de ausencia o permiso.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>1.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="ausencia2";$label="Aprobaci&oacute;n";$ayuda=$label." de ausencia o permiso.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
					
					],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					<?php $elemento="vacaciones_ejec";$label="Vacaciones ejecutadas";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>

					<?php $elemento="vacaciones_acum";$label="Vacaciones acumuladas";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					<?php $elemento="dia_recuperable";$label="Feriado recuperable";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>	
					
					_cmSplit,

					<?php $rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND ($rs_sesion->fields['elemento']=='grupo') OR $rs_sesion->fields['elemento']=='jornada' OR $rs_sesion->fields['elemento']=='causa_permiso' OR $rs_sesion->fields['elemento']=='eventos_feriado'){?>
					['<img src="https://'+dir+site+img+'/configuracion.png" >','Par&aacute;metros',null,null,'Nomencladores o parametrizaci&oacute;n.',
						
						<?php $elemento="grupo_empleado";$label="Grupo de empleados";$ayuda=$label." .";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
					
						<?php $elemento="grupo";$label="Grupo";$ayuda=$label." seg&uacute;n la jornada de trabajo.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="jornada";$label="Jornada";$ayuda=$label." de trabajo.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="causa_ausencia";$label="Causa de ausencia";$ayuda=$label." .";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="eventos_feriado";$label="Eventos feriado";$ayuda=$label." en el a&ntilde;o.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="feriados";$label="Feriados";$ayuda=$label." en el a&ntilde;o.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="vacaciones";$label="Vacaciones";$ayuda=$label." en el a&ntilde;o.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						_cmSplit,
						
						<?php $elemento="costo_horas_extras";$label="Costo de horas extras";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="jornada_extra";$label="Jornada extra";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="hora_extra";$label="Hora extra";$ayuda=$label." seg&uacute;n jornada.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
									
					],
					<?php break;}$rs_sesion->MoveNext();}?>	
				],
				<?php break;}$rs_sesion->MoveNext();}?>			
				
				<?php $rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['modulo']==$mod){?>
				[null,'Desempe&ntilde;o',null,null,'Evaluaciones de desempe&ntilde;o.',
				
					<?php $elemento="desempeno";$label="Evaluaci&oacute;n";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND ($rs_sesion->fields['elemento']==$elemento  OR $rs_sesion->fields['elemento']=='desempeno2')){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>0.png" >','<?php print $label;?>',null,null,'<?php print $ayuda;?>',
					
					
						<?php $elemento="desempeno";$label="Soy evaluador";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>1.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="desempeno2";$label="Soy evaluado";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
					
					],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					<?php $elemento="compromiso";$label="Compromiso";$ayuda=$label." del evaluado.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					_cmSplit,
					
					<?php $rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND ($rs_sesion->fields['elemento']=='competencia') OR $rs_sesion->fields['elemento']=='criterio'){?>
					['<img src="https://'+dir+site+img+'/configuracion.png" >','Par&aacute;metros',null,null,'Nomencladores o parametrizaci&oacute;n.',
					
						<?php $elemento="competencia";$label="Competencia";$ayuda=$label." a evaluar.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="criterio";$label="Criterio";$ayuda=$label." a evaluar.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="grupo_eval";$label="Grupo de evaluaciones";$ayuda=$label." .";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="evaluacion";$label="Evaluaci&oacute;n";$ayuda=$label." de criterios.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="cri_eval";$label="Criterio, evaluaci&oacute;n";$ayuda=$label." .";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="comp_cri_eval";$label="Competencia, criterio, evaluaci&oacute;n";$ayuda=$label." a evaluar.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="ponderacion";$label="Ponderaci&oacute;n";$ayuda=$label." de frecuencia.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="cargo_comp";$label="Cargos y competencias";$ayuda=$label." .";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="cargo_cri_pond";$label="Cargos, criterios y ponderaciones";$ayuda=$label." .";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="periodo";$label="Per&iacute;odo";$ayuda=$label." a evaluar.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
					],
					<?php break;}$rs_sesion->MoveNext();}?>
				],
				<?php break;}$rs_sesion->MoveNext();}?>
				
				<?php $elemento="r_empleado";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
				[null,'Reportes',null,null,'Reportes.',
				
					<?php $elemento="r_empleado";$label="Empleado";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/empleado.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/reportes/'.$elemento;?>/lis_r_empleado.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					_cmSplit,
					
					<?php $elemento="r_desempeno";$label="Evaluaci&oacute;n de desempe&ntilde;o";$ayuda=$label." del evaluado.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/desempeno0.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/reportes/'.$elemento;?>/lis_r_desempeno.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					<?php $elemento="r_desempeno2";$label="Resumen de evaluaci&oacute;n de desempe&ntilde;o";$ayuda=$label." del evaluado.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/desempeno2.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/reportes/'.$elemento;?>/lis_r_desempeno2.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					_cmSplit,
					
					<?php $elemento="r_graf_colum_basica_desempeno";$label="Evaluaci&oacute;n de desempe&ntilde;o";$ayuda=$label." del evaluado.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/graf_colum_basica.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/reportes/'.$elemento;?>/r_graf_colum_basica_desempeno.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					<?php $elemento="r_graf_linea_basica_desempeno";$label="Evoluci&oacute;n de desempe&ntilde;o";$ayuda=$label." del evaluado.";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/graf_linea_basica.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/reportes/'.$elemento;?>/r_graf_linea_basica_desempeno.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
				],
				<?php break;}$rs_sesion->MoveNext();}
				
			}
			//----RRHH----
			//----RRHH----
			//----RRHH----
			
			//--------Módulo Contable---------
			//--------Módulo Contable---------
			//--------Módulo Contable---------
			
			if($_SESSION["modulo"]=="cont")
			{
				$mod="cont";
				
				$elemento="venta";$label="Facturaci&oacute;n";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
				[null,'<?php print $label;?>',null,null,'<?php print $ayuda;?>',
				
				<?php $elemento="venta";$label="Venta de productos";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php break;}$rs_sesion->MoveNext();}?>
				
				<?php $elemento="saldo";$label="Saldo o pago";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php break;}$rs_sesion->MoveNext();}?>
				
				<?php $elemento="tarjeta";$label="Tarjeta";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php break;}$rs_sesion->MoveNext();}?>
				
				<?php $elemento="producto_precio";$label="Producto y precios";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php break;}$rs_sesion->MoveNext();}?>
				
				<?php $elemento="cliente";$label="Cliente";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php break;}$rs_sesion->MoveNext();}?>
				
				<?php $elemento="referencia";$label="Referencia";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php break;}$rs_sesion->MoveNext();}?>
				
				_cmSplit,
						
					<?php $elemento="punto_venta";$label="Par&aacute;metros";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
					['<img src="https://'+dir+site+img+'/configuracion.png" >','<?php print $label;?>',null,null,'Nomencladores o parametrizaci&oacute;n.',
					
						<?php $elemento="preventa";$label="Preventa para pensiones";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						_cmSplit,
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="grupo_cliente";$label="Grupo";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="grupos_clientes";$label="Grupo y clientes";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="cliente_forma_pago";$label="Cliente y forma de pago";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						_cmSplit,
						
						<?php $elemento="punto_venta";$label="Punto de venta";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="punto_venta_usuario";$label="Punto de venta y usuario";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="factura";$label="Facturero";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="forma_pago";$label="Forma de pago";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="producto";$label="Producto";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
					],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					_cmSplit,
					
					<?php $elemento="r_saldo";$label="Reportes";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
					['<img src="https://'+dir+site+img+'/reportes.png" >','<?php print $label;?>',null,null,'Nomencladores o parametrizaci&oacute;n.',
					
						<?php $elemento="r_saldo";$label="Saldo disponible por consumidor";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/reportes/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="r_venta";$label="Venta por No de factura";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/reportes/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
					],
					<?php break;}$rs_sesion->MoveNext();}?>
				],
				<?php break;}$rs_sesion->MoveNext();}
				
				
				
				$elemento="inventario";$label="Inventario";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
				[null,'<?php print $label;?>',null,null,'<?php print $ayuda;?>',
				
				<?php $elemento="ubicacion_responsable";$label="Movimientos";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>',null,null,'<?php print $ayuda;?>',
					
					<?php $elemento="ubicacion_responsable";$label="Activos fijos";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					<?php $elemento="pedido_consumible";$label="Materiales gastables";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
				],
				<?php break;}$rs_sesion->MoveNext();}?>
				
				<?php $elemento="inventario";$label="Ingreso de inventario";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>',null,null,'<?php print $ayuda;?>',
					
					<?php $elemento="inventario";$label="Activos fijos";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					<?php $elemento="inventario_consumibles";$label="Materiales gastables";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
				
				],
				<?php break;}$rs_sesion->MoveNext();}?>
				
				<?php $elemento="baja";$label="Baja de activos";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php break;}$rs_sesion->MoveNext();}?>
				
				<?php $elemento="reposicion";$label="Reposici&oacute;n";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php break;}$rs_sesion->MoveNext();}?>
				
				<?php $elemento="articulo";$label="Activo fijo";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php break;}$rs_sesion->MoveNext();}?>
				
				_cmSplit,
						
					<?php $elemento="familia";$label="Par&aacute;metros";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
					['<img src="https://'+dir+site+img+'/configuracion.png" >','<?php print $label;?>',null,null,'Nomencladores o parametrizaci&oacute;n.',
					
						<?php $elemento="familia";$label="Grupo de nivel 1";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="gru";$label="Grupo de nivel 2";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="subgrupo";$label="Grupo de nivel 3";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						_cmSplit,
						
						<?php $elemento="atributo";$label="Atributo";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						_cmSplit,
						
						<?php $elemento="proveedor";$label="Proveedor";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="marca";$label="Marca";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="modelo";$label="Modelo";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="tipo_depreciacion";$label="Tipo de depreciaci&oacute;n";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="estado";$label="Estado del art&iacute;culo";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="motivo_baja";$label="Motivo de baja";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
					
					
						_cmSplit,
						
						<?php $elemento="ubicacion";$label="Ubicaci&oacute;n";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/reportes.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'Nomencladores o parametrizaci&oacute;n.',
						
							<?php $elemento="bloque";$label="Bloque";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
							['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
							<?php break;}$rs_sesion->MoveNext();}?>
							
							<?php $elemento="secc";$label="Secci&oacute;n";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
							['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
							<?php break;}$rs_sesion->MoveNext();}?>
							
							<?php $elemento="division";$label="Divisi&oacute;n";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
							['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
							<?php break;}$rs_sesion->MoveNext();}?>
						],
						<?php break;}$rs_sesion->MoveNext();}?>
						
					],
					<?php break;}$rs_sesion->MoveNext();}?>
						
					<?php $elemento="r_ubicacion_responsable";$label="Reportes";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
					['<img src="https://'+dir+site+img+'/reportes.png" >','<?php print $label;?>',null,null,'Nomencladores o parametrizaci&oacute;n.',
					
						<?php $elemento="r_ubicacion_responsable";$label="Inventario vigente de activos fijos";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/reportes/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="r_consumibles";$label="Material gastable disponible";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/reportes/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
					],
					<?php break;}$rs_sesion->MoveNext();}?>					
					
				],
				<?php break;}$rs_sesion->MoveNext();}
				
				
			}
			//--------Módulo Contable---------
			//--------Módulo Contable---------
			//--------Módulo Contable---------
			
			//--------Módulo Académico---------
			//--------Módulo Académico---------
			//--------Módulo Académico---------
			
			if($_SESSION["modulo"]=="acad")
			{
				$mod="acad";
				
				$elemento="estudiante";$label="Admisiones";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND ($rs_sesion->fields['elemento']==$elemento OR $rs_sesion->fields['elemento']=='hijo')){?>
				[null,'<?php print $label;?>',null,null,'<?php print $ayuda;?>',
				
				<?php $elemento="hijo";$label="Mis hijos";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php print '_cmSplit,';break;}$rs_sesion->MoveNext();}?>
				
			
				
				<?php $elemento="familiar_no_admit";$label="Familiar con estuadiantes sin admitir en per&iacute;odo actual";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/familiar_no_admit.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/';?>familiar_no_admit/lis_familiar_no_admit.php',null,'<?php print $ayuda;?>'],
				<?php break;}$rs_sesion->MoveNext();}?>
				
				<?php $elemento="estudiante_no_admit";$label="Estudiante sin admitir en per&iacute;odo actual";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/estudiante_no_admit.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/';?>estudiante_no_admit/lis_estudiante_no_admit.php',null,'<?php print $ayuda;?>'],
				<?php print '_cmSplit,';break;}$rs_sesion->MoveNext();}?>
				
				
				
				<?php $elemento="familiar";$label="Familiar con estudiantes admitidos o matriculados en per&iacute;odo actual";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php break;}$rs_sesion->MoveNext();}?>
				
				<?php $elemento="estudiante";$label="Estudiante admitido o matriculado en per&iacute;odo actual";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php print '_cmSplit,';break;}$rs_sesion->MoveNext();}?>
				
				
				
				<?php $elemento="empleado_academico";$label="Empleado acad&eacute;mico";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php print '_cmSplit,';break;}$rs_sesion->MoveNext();}?>
				
				<?php $elemento="datos_clinicos";$label="Ficha m&eacute;dica";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php print '_cmSplit,';break;}$rs_sesion->MoveNext();}?>
				
				<?php $elemento="grado_paralelo_periodo";$label="Grado, paralelo y per&iacute;odo";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php print '_cmSplit,';break;}$rs_sesion->MoveNext();}?>	
				
				
						
					<?php $elemento="grado";$label="Par&aacute;metros";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
					['<img src="https://'+dir+site+img+'/configuracion.png" >','<?php print $label;?>',null,null,'Nomencladores o parametrizaci&oacute;n.',
						
						<?php $elemento="periodo_academico";$label="Per&iacute;odo acad&eacute;mico";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php print '_cmSplit,';break;}$rs_sesion->MoveNext();}?>	
						
						<?php $elemento="parentesco";$label="Parentesco";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>										
						
						<?php $elemento="responsable_acta";$label="Responsable de acta";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="tipo_grado";$label="Tipo de grado";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php print '_cmSplit,';break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="seccion_academica";$label="Secci&oacute;n acad&eacute;mica";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="grado";$label="Grado";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="paralelo";$label="Paralelo";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
											
						<?php $elemento="grado_paralelo";$label="Grado y paralelo";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php print '_cmSplit,';break;}$rs_sesion->MoveNext();}?>

						<?php $elemento="enfermedad";$label="Enfermedad";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="alergia";$label="Alergia";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="vacuna";$label="Vacuna";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
					],
					<?php print '_cmSplit,';break;}$rs_sesion->MoveNext();}?>
					
				],
				<?php break;}$rs_sesion->MoveNext();}
							
				$elemento="tarea_vigentes";$label="Calificaciones";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND ($rs_sesion->fields['elemento']==$elemento OR $rs_sesion->fields['elemento']=='r_cuaderno_clase' OR $rs_sesion->fields['elemento']=='tutoria' OR $rs_sesion->fields['elemento']=='inspectoria' OR $rs_sesion->fields['elemento']=='cuaderno_clase' OR $rs_sesion->fields['elemento']=='conf_academica' OR $rs_sesion->fields['elemento']=='asignatura')){?>
				[null,'<?php print $label;?>',null,null,'<?php print $ayuda;?>',
				
					<?php $elemento="cuaderno_clase";$label="Mis cuadernos de clase";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND ($rs_sesion->fields['elemento']==$elemento)){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>					

					<?php $elemento="tutoria";$label="Tutor&iacute;a";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/mod_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					<?php $elemento="inspectoria";$label="Inspector&iacute;a";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/mod_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					<?php $elemento="tarea_vigentes";$label="Mis tareas";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/tarea.png" >','<?php print $label;?>', null ,null,'<?php print $ayuda;?>',
					
						<?php $elemento="tarea_pasadas";$label="Anteriores";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/tarea.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="tarea_vigentes";$label="Vigentes";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/tarea.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>					
					],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					
					<?php $elemento="tarea_hijo_vigentes";$label="Tareas de mis hijos";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/tarea.png" >','<?php print $label;?>', null ,null,'<?php print $ayuda;?>',
					
						<?php $elemento="tarea_hijo_pasadas";$label="Anteriores";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/tarea.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/tarea_hijo_pasadas';?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="tarea_hijo_vigentes";$label="Vigentes";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/tarea.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/tarea_hijo_vigentes';?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>					
					],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					<?php $elemento="conf_academica";$label="Par&aacute;metros";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
					['<img src="https://'+dir+site+img+'/configuracion.png" >','<?php print $label;?>',null,null,'Nomencladores o parametrizaci&oacute;n.',
						
						<?php $elemento="conf_academica";$label="Configuraci&oacute;n acad&eacute;mica";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>',
						
							<?php $elemento="periodo_lectivo";$label="Per&iacute;odo lectivo";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
							['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>',
							
								<?php $elemento="examen_periodo_lec";$label="Examen o actividad";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
								['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
								<?php break;}$rs_sesion->MoveNext();}?>
								
								<?php $elemento="exa_adicional_lectivo";$label="Examen o actividad adicional";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
								['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
								<?php break;}$rs_sesion->MoveNext();}?>	
							],
							<?php break;}$rs_sesion->MoveNext();}?>
								
							<?php $elemento="periodo_evaluativo";$label="Per&iacute;odo evaluativo";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
							['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>',
							
								<?php $elemento="examen_periodo_eval";$label="Examen o actividad";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
								['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
								<?php break;}$rs_sesion->MoveNext();}?>

								<?php $elemento="exa_adicional_periodo";$label="Examen o actividad adicional";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
								['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
								<?php break;}$rs_sesion->MoveNext();}?>	
							],
							<?php break;}$rs_sesion->MoveNext();}?>	
								
							<?php $elemento="subperiodo_evaluativo";$label="Subper&iacute;odo evaluativo";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
							['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>',
							
								<?php $elemento="tipo_actividad";$label="Examen o actividad";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
								['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
								<?php break;}$rs_sesion->MoveNext();}?>

								<?php $elemento="exa_adicional_subperiodo";$label="Examen o actividad adicional";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
								['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
								<?php break;}$rs_sesion->MoveNext();}?>	
							],
							<?php break;}$rs_sesion->MoveNext();}?>	
						
						],
						<?php print '_cmSplit,';break;}$rs_sesion->MoveNext();}?>

						<?php $elemento="asignatura";$label="Asignatura";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php print '_cmSplit,';break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="clase";$label="Clase";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php print '_cmSplit,';break;}$rs_sesion->MoveNext();}?>

						<?php $elemento="cierre_subperiodo_evaluativo";$label="Avance del a&ntilde;o";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/mod_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php print '_cmSplit,';break;}$rs_sesion->MoveNext();}?>

						<?php $elemento="tipo_examen";$label="Tipo de examen";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>

						<?php $elemento="examen_adicional";$label="Examen o actividad adicional";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php print '_cmSplit,';break;}$rs_sesion->MoveNext();}//supletorio, remedial o gracia?>

						<?php $elemento="hora_antelacion";$label="Tiempo antelaci&oacute;n para deberes";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
					],
					<?php print '_cmSplit,';break;}$rs_sesion->MoveNext();}?>
					
					
					<?php $elemento="r_cuaderno_clase";$label="Resumen de mis hijos";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/reportes/'.$elemento;?>/lis_cuaderno_clase.php?visualizar=1',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					
				],
				<?php break;}$rs_sesion->MoveNext();}
				
				$elemento="r_estudiante";$label="Reportes";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
				[null,'<?php print $label;?>',null,null,'Nomencladores o parametrizaci&oacute;n.',
				
					<?php $elemento="r_estudiante";$label="Historial de estudiantes por per&iacute;odo";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/reportes/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					<?php $elemento="reportes";$label="Descargas de PDF";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/pdf.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/reportes/';?>lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
				],
				<?php break;}$rs_sesion->MoveNext();}
				
			}
			//--------Módulo Académico---------
			//--------Módulo Académico---------
			//--------Módulo Académico---------
			
			//--------Módulo de Biblioteca---------
			//--------Módulo de Biblioteca---------
			//--------Módulo de Biblioteca---------
			
			if($_SESSION["modulo"]=="bibl")
			{
				$mod="bibl";				
				
				$elemento="prestamo";$label="Pr&eacute;stamo y devoluciones";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
				[null,'<?php print $label;?>',null,null,'<?php print $ayuda;?>',
				
					<?php $elemento="prestamo";$label="Pr&eacute;stamo";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>',
						
						<?php $elemento="prestamo";$label="Pr&eacute;stamo a estudiantes";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/prestamo_estudiante';?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
					],
					<?php break;}$rs_sesion->MoveNext();}?>
					
					<?php $elemento="devolucion";$label="Devoluci&oacute;n";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
					['<img src="https://'+dir+site+img+'/devolucion.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
					<?php break;}$rs_sesion->MoveNext();}?>
				],
				<?php break;}$rs_sesion->MoveNext();}
				
				$elemento="libro";$label="Libro";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
				[null,'<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php break;}$rs_sesion->MoveNext();}?>
				
						
					<?php $elemento="ubicacion";$label="Par&aacute;metros";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
					[null,'<?php print $label;?>',null,null,'Nomencladores o parametrizaci&oacute;n.',

						<?php $elemento="genero_literario";$label="G&eacute;nero";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'Nomencladores o parametrizaci&oacute;n.'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="editorial";$label="Editorial";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'Nomencladores o parametrizaci&oacute;n.'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="autor";$label="Autor";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'Nomencladores o parametrizaci&oacute;n.'],
						<?php break;}$rs_sesion->MoveNext();}?>
						
						<?php $elemento="ubicacion";$label="Ubicaci&oacute;n";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
						['<img src="https://'+dir+site+img+'/reportes.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'Nomencladores o parametrizaci&oacute;n.',
						
							<?php $elemento="bloque";$label="Estante";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
							['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
							<?php break;}$rs_sesion->MoveNext();}?>
							
							<?php $elemento="secc";$label="Columna";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
							['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
							<?php break;}$rs_sesion->MoveNext();}?>
							
							<?php $elemento="division";$label="Celda";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
							['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
							<?php break;}$rs_sesion->MoveNext();}?>
						],
						<?php break;}$rs_sesion->MoveNext();}?>
						
					],
					<?php break;}$rs_sesion->MoveNext();}?>
						
					<?php $elemento="r_prestamo";$label="Reportes";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
					['<img src="https://'+dir+site+img+'/reportes.png" >','<?php print $label;?>',null,null,'Nomencladores o parametrizaci&oacute;n.',
					
						<?php $elemento="r_prestamo";$label="Pr&ecute;stamos por usuario";$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>	
						['<img src="https://'+dir+site+img+'/<?php print $elemento;?>.png" >','<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/reportes/'.$elemento;?>/lis_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
						<?php break;}$rs_sesion->MoveNext();}?>
					],
					<?php break;}$rs_sesion->MoveNext();}			
					
				
				
				
			}
			//--------Módulo de Biblioteca---------
			//--------Módulo de Biblioteca---------
			//--------Módulo de Biblioteca---------
			
			//--------Módulo de Perfil---------
			//--------Módulo de Perfil---------
			//--------Módulo de Perfil---------
			if($_SESSION["modulo"]=="perf")
			{
				$mod="perf";
				$elemento="perfil";$label="Mi perfil: ".$_SESSION["nombre"];$ayuda=$label.".";$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento){?>	
				[null,'<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/mod_<?php print $elemento;?>.php',null,'<?php print $ayuda;?>'],
				<?php break;}elseif($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){?>
				[null,'<?php print $label;?>','https://'+dir+site+'/pag/<?php print $mod.'/'.$elemento;?>/mod_<?php print $elemento;?>.php?visualizar=1',null,'<?php print $ayuda;?>'],
				<?php break;}$rs_sesion->MoveNext();}
			}
			
			//--------Módulo de Perfil---------
			//--------Módulo de Perfil---------
			//--------Módulo de Perfil---------
		
			elseif($_SESSION["modulo"]=="mod")
			{/*
			?>
				[null,'M&oacute;dulos',null,null,'M&oacute;dulos del sistema ERP.',
		
						
					['<img src="https://'+dir+site+img+'/perf.png" >','Mi perfil','https://'+dir+site+'/pag/perf/perfil/mod_perfil.php',null,'Mi perfil.'],
					
					['<img src="https://'+dir+site+img+'/rrhh.png" >','Talento Humano','https://'+dir+site+'/pag/panel/modulo.php?modulo=rrhh',null,'Talento Humano.'],
	
					['<img src="https://'+dir+site+img+'/bibl.png" >','Biblioteca','https://'+dir+site+'/pag/panel/modulo.php?modulo=bibl',null,'Biblioteca.'],
					
					['<img src="https://'+dir+site+img+'/cont.png" >','Contabilidad','https://'+dir+site+'/pag/panel/modulo.php?modulo=cont',null,'Contabilidad.'],
					
					['<img src="https://'+dir+site+img+'/info.png" >','Informaci&oacute;n','https://'+dir+site+'/pag/panel/modulo.php?modulo=info',null,'Informaci&oacute;n.'],
					
					['<img src="https://'+dir+site+img+'/acad.png" >','Acad&eacute;mico','https://'+dir+site+'/pag/panel/modulo.php?modulo=acad',null,'Acad&eacute;mico.'],
					
					['<img src="https://'+dir+site+img+'/conf.png" >','Configuraci&oacute;n','https://'+dir+site+'/pag/panel/modulo.php?modulo=conf',null,'Configuraci&oacute;n.'],
								
				],			
			<?php*/
			}
		}		
	} // fin de la funcion
} // fin de la clase
?>