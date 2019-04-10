<?php
include("camino.php");
include($x."plantillas/pla_header.php");//die();
//include("variables.php");
if(isset($_GET["mensaje"]))$mensaje = $_GET["mensaje"];else $mensaje = '';
$_SESSION["modulo"]='mod';

$accion='';
$elem='';
$fila=0;
$acad='';
$contab='';
$bibliot='';
$info='';
$visualizar='';
$editar='';
?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<br>
<div align="center">
	<table align="center" class="panel">
		<tr> 
			<td colspan="2" class="panel_header">				
				<img src="../../img/general/minerva.png" width="60" height="60">&nbsp;&nbsp;<?php print $titulo_sitio;?> - <?php print $nombre_empresa;?>				
			</td>
		</tr>
		<tr> 
			<td>
				<table class="modulo">
				<?php 
				if(isset($_GET['mensaje']))
				$mensaje=$_GET['mensaje'];
				$obj->Imprimir_mensaje($mensaje);
				?>
					<tr>					
						<td rowspan="4" width="50%" align='center'>
							<img width="40%" src="../../img/panel/cube_523x243.png">
						</td>
					</tr>
					<?php
						$rs_sesion->MoveFirst();
						for($ses=0;$ses<$rs_sesion->RecordCount();$ses++) 
						{//print $rs_sesion->fields['accion']."     ".$rs_sesion->fields['elemento'];
							if($accion!=$rs_sesion->fields['accion'] OR $elem!=$rs_sesion->fields['elemento'])
							{
								$elemento="perfil";
								if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
								{
									$visualizar=1;
								}
							}
							if($accion!=$rs_sesion->fields['accion'] OR $elem!=$rs_sesion->fields['elemento'])
							{
								$elemento="perfil";
								if($rs_sesion->fields['accion']=='Editar' AND $rs_sesion->fields['elemento']==$elemento)
								{
									$editar=1;
								}
							}
						
							
							if($visualizar==1)
							{
								$visualizar=0;
								$sql_p="select primer_nombre, segundo_nombre, primer_apellido, segundo_apellido from persona, usuario WHERE persona.id_persona=usuario.id_persona AND usuario='".$_SESSION["user"]."'";//print $sql_p;
								$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
								
								$nombre_completo=$rs_p->fields['primer_nombre'].' '.$rs_p->fields['segundo_nombre'].' '.$rs_p->fields['primer_apellido'].' '.$rs_p->fields['segundo_apellido'];//$foto=$rs_p->fields['camino_foto'];

								$foto_perfil=$x."img/panel/no_disponible.png";
					?>
								<tr> 
									<td <?php if($fila>=3) print 'colspan="2"';?>>
										<a href="<?php if($editar==1)print $x."pag/perf/".$elemento."/mod_".$elemento.".php";else print $x."pag/perf/".$elemento."/mod_".$elemento.".php?visualizar=1";?>" >
											<div id="perfilInfo" style='background-image: url("<?php print $foto_perfil;?>");'><p><b><?php  $x."pag/acad/".$elemento."/mod_".$elemento.".php";?>Mi perfil: </b><?php print $nombre_completo;?></p></div><?php $fila=$fila+1;?>
										</a>
									</td>
								</tr>
					<?php
							}	
							
							
							if($accion!=$rs_sesion->fields['accion'] OR $elem!=$rs_sesion->fields['elemento'])
							{
								$elemento="compromiso";
								if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
								{	
					?>
									<tr> 
										<td <?php if($fila>=3) print 'colspan="2"';?>>
											<a href="modulo.php?modulo=rrhh" >
												<div id="recursosHumanosInfo"><p><b>Talento Humano:</b> Gesti&oacute;n del recurso humano, evaluaci&oacute;n de desempe&ntilde;o y n&oacute;mina.</p></div><?php $fila=$fila+1;?>
											</a>
										</td>
									</tr>
					<?php
								}
							}	
						
					
							if($accion!=$rs_sesion->fields['accion'] OR $elem!=$rs_sesion->fields['elemento'])
							{
								$elemento="venta";
								if($contab!=1 AND $rs_sesion->fields['accion']=='Visualizar' AND ($rs_sesion->fields['elemento']==$elemento OR $rs_sesion->fields['elemento']=='inventario'))
								{
								$contab=1;
					?>
									<tr> 
										<td <?php if($fila>=3) print 'colspan="2"';?>>	
											<a href="modulo.php?modulo=cont">
												<div id="contabilidadInfo"><p><b>Contabilidad:</b> Facturaci&oacute;n de punto de venta, pensiones y control de inventario.</p></div><?php $fila=$fila+1;?>
											</a>
										</td>
									</tr>
					<?php
								}
							}	
						
							if($accion!=$rs_sesion->fields['accion'] OR $elem!=$rs_sesion->fields['elemento'])
							{
								$elemento="prestamo";
								if($bibliot!=1 AND $rs_sesion->fields['accion']=='Visualizar' AND ($rs_sesion->fields['elemento']==$elemento OR $rs_sesion->fields['elemento']=='libro'))
								{
								$bibliot=1;
					?>
									<tr> 
										<td <?php if($fila>=3) print 'colspan="2"';?>>
											<a href="modulo.php?modulo=bibl">
												<div id="bibliotecaInfo"><p><b>Biblioteca:</b> Gesti&oacute;n de pr&eacute;stamos, devoluciones y libros.</p></div><?php $fila=$fila+1;?>
											</a>
										</td>
									</tr>
					<?php
								}
							}	
						
							if($accion!=$rs_sesion->fields['accion'] OR $elem!=$rs_sesion->fields['elemento'])
							{
								$elemento="ser";
								if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
								{	
					?>
									<tr> 
										<td <?php if($fila>=3) print 'colspan="2"';?>>
											<a href="modulo.php?modulo=3st">						
												<div id="serviciosTecnicosInfo"><p><b>Servicios T&eacute;cnicos:</p></div><?php $fila=$fila+1;?>
											</a>
										</td>		
									</tr>
					<?php
								}
							}	
						
							if($accion!=$rs_sesion->fields['accion'] OR $elem!=$rs_sesion->fields['elemento'])
							{
								$elemento="perfil";
								if($acad!=1 AND $rs_sesion->fields['accion']=='Visualizar' AND ($rs_sesion->fields['elemento']==$elemento OR $rs_sesion->fields['elemento']=='familiar' OR $rs_sesion->fields['elemento']=='estudiante' OR $rs_sesion->fields['elemento']=='tarea'))
								{	
									$acad=1;
					?>
									<tr> 
										<td <?php if($fila>=3) print 'colspan="2"';?>>
											<a href="modulo.php?modulo=acad" >
												<div id="academicoInfo"><p><b>Acad&eacute;mico:</b> Gesti&oacute;n de familiares, estudiantes, grado y paralelo, asistencia, calificaci&oacute;n, comportamiento, etc.</p></div><?php $fila=$fila+1;?>
											</a>
										</td>		
									</tr>
					<?php
								}
							}	
						
							if($accion!=$rs_sesion->fields['accion'] OR $elem!=$rs_sesion->fields['elemento'])
							{
								$elemento="permiso";
								if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
								{	
					?>
									<tr>
										<td <?php if($fila>=3) print 'colspan="2"';?>>
											<a href="modulo.php?modulo=conf">
												<div id="configuracionInfo"><p><b>Configuraci&oacute;n:</b> Gesti&oacute;n de usuarios, roles y permisos</p></div><?php $fila=$fila+1;?>
											</a>
										</td>		
									</tr>
					<?php
								}
							}	
							
							if($accion!=$rs_sesion->fields['accion'] OR $elem!=$rs_sesion->fields['elemento'])
							{
								$elemento="persona";
								if($info!=1 AND $rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento)
								{
									$info=1;
					?>
									<tr>
										<td <?php if($fila>=3) print 'colspan="2"';?>>
											<a href="modulo.php?modulo=info">
												<div id="informacionInfo"><p><b>Informaci&oacute;n general:</b> Datos generales</p></div><?php $fila=$fila+1;?>
											</a>
										</td>		
									</tr>
					<?php
								}
							}	
						$accion=$rs_sesion->fields['accion'];
						$elem=$rs_sesion->fields['elemento'];						
						$rs_sesion->MoveNext();
						}
					?>
				
				</table>
			</td>			
		</tr>
	</table>	
</div>		
<br>		
		

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/sec_footer.php");
?>