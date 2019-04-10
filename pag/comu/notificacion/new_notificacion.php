<?php
include("variables.php");
include($x."plantillas/new_header.php");
include($x."include/PHPMailer-master/PHPMailerAutoload.php");
$mail = new PHPMailer();

$visualizar="";// (NO TOCAR)
$hay_destinatarios=0;
$adjuntos='';

$sql_f="SELECT id_grado_paralelo_periodo , n_grado.grado, n_grado_paralelo.abreviatura as grado_paralelo, 
n_periodo_academico.nombre as periodo_academico, seccion_academica
FROM grado_paralelo_periodo,n_grado_paralelo,n_periodo_academico,n_grado,n_paralelo, n_seccion_academica
WHERE 1 AND grado_paralelo_periodo.id_grado_paralelo=n_grado_paralelo.id_grado_paralelo 
AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico
AND n_grado_paralelo.id_grado=n_grado.id_grado 
AND n_grado_paralelo.id_paralelo=n_paralelo.id_paralelo
AND n_seccion_academica.id_seccion_academica=n_grado.id_seccion_academica
AND n_periodo_academico.activo='1'
ORDER BY n_seccion_academica.orden, grado_paralelo_periodo.orden";//print $sql_p;
$rs_f=$db->Execute($sql_f) or die($db->ErrorMsg());

?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

<script type="text/javascript" class="js-code-basic">
  $(document).ready(function() {
            $( "#accordion" ).accordion({
                'collapsible': true,
                'active': null,
                'heightStyle': 'content'
            });
            $('.jquery').each(function() {
                eval($(this).html());
            });
            $('.button').button();
        });
        //-->
$(document).ready(function() {
$(".js-example-basic-multiple").select2();
});

function p()
{
	//alert(document.frm.sel_per.value);
	 $(".js-example-basic-multiple").on("select2:select", function (e) {
		 document.frm.txt_per.value=$(".js-example-basic-multiple").select2("val");
	});
}
</script>
<?php
date_default_timezone_set ('America/Guayaquil');
$now=date('Y-m-d H:i:s');
//print $now; die();
//print 
if(isset($_POST['txt_asunto']))
{
	if($_POST['txt_asunto']!='')
	{
		if(isset($_POST['cbx_trabajador']))$cbx_trabajador=$_POST['cbx_trabajador'];else $cbx_trabajador=0;
		if(isset($_POST['cbx_familiar']))$cbx_familiar=$_POST['cbx_familiar'];else $cbx_familiar=0;
		if(isset($_POST['cbx_estudiante']))$cbx_estudiante=$_POST['cbx_estudiante'];else $cbx_estudiante=0;
		if(isset($_POST['cbx_urgente']))$urgente=$_POST['cbx_urgente'];else $urgente=0;
		
		$sql_rem="select persona.id_persona from persona, usuario WHERE 1 AND persona.id_persona=usuario.id_persona AND usuario.activo='1' AND usuario.usuario='".$_SESSION['user']."'";
		$rs_rem=$db->Execute($sql_rem) or die($db->ErrorMsg());
		
		for($f=1;$f<=$rs_f->RecordCount();$f++)
		{
			if(isset($_POST[$rs_f->fields['id_grado_paralelo_periodo']]))//print $rs_f->fields['grado_paralelo'].'<br>';
			{
				if($_POST[$rs_f->fields['id_grado_paralelo_periodo']]!='')//print $rs_f->fields['grado_paralelo'].'<br>';
				{
					if($cbx_trabajador==1)
					{			
						$sql_tra="SELECT persona.id_persona, email
						FROM curso_grado_paralelo_est, estudiante, familiar_estudiante, familiar, persona, usuario
						WHERE 1 AND curso_grado_paralelo_est.id_estudiante=estudiante.id_estudiante
						AND estudiante.id_estudiante=familiar_estudiante.id_estudiante 
						AND familiar.id_familiar=familiar_estudiante.id_familiar 
						AND familiar.id_persona=persona.id_persona 
						AND persona.id_persona=usuario.id_persona  AND email!='' AND usuario.activo='1' AND curso_grado_paralelo_est.retirado='0'
						AND curso_grado_paralelo_est.id_grado_paralelo_periodo='".$rs_f->fields['id_grado_paralelo_periodo']."'";print $sql_tra.'<br>';
						$rs_tra=$db->Execute($sql_tra) or die($db->ErrorMsg());		
					}
					
					if($cbx_familiar==1)
					{			
						$sql_fam="SELECT persona.id_persona, email
						FROM curso_grado_paralelo_est, estudiante, familiar_estudiante, familiar, persona, usuario, grado_paralelo_periodo, n_periodo_academico
						WHERE 1 AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
						AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico
						AND curso_grado_paralelo_est.id_estudiante=estudiante.id_estudiante
						AND estudiante.id_estudiante=familiar_estudiante.id_estudiante 
						AND familiar.id_familiar=familiar_estudiante.id_familiar 
						AND familiar.id_persona=persona.id_persona AND n_periodo_academico.activo='1'
						AND persona.id_persona=usuario.id_persona  AND email!='' AND usuario.activo='1' AND curso_grado_paralelo_est.retirado='0'
						AND curso_grado_paralelo_est.id_grado_paralelo_periodo='".$rs_f->fields['id_grado_paralelo_periodo']."'";//print $sql_fam.'<br><br><br>';
						$rs_fam=$db->Execute($sql_fam) or die($db->ErrorMsg());				
					}
					
					if($cbx_estudiante==1)
					{			
						$sql_est="SELECT persona.id_persona, email
						FROM curso_grado_paralelo_est, estudiante, persona, usuario, grado_paralelo_periodo, n_periodo_academico
						WHERE 1 AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
						AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico
						AND curso_grado_paralelo_est.id_estudiante=estudiante.id_estudiante
						AND estudiante.id_persona=persona.id_persona AND n_periodo_academico.activo='1'
						AND persona.id_persona=usuario.id_persona  AND email!='' AND usuario.activo='1' AND curso_grado_paralelo_est.retirado='0'
						AND curso_grado_paralelo_est.id_grado_paralelo_periodo='".$rs_f->fields['id_grado_paralelo_periodo']."'";//print $sql_est.'<br><br><br>';
						$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());				
					}
					
					if(isset($rs_tra) OR isset($rs_fam) OR isset($rs_est))
					{
						$ins_n="INSERT INTO notificacion (asunto, mensaje, fecha_envio) 
						VALUES ('".$_POST['txt_asunto']."','".$_POST['txt_mensaje']."','".$now."')";//print $ins_n."<br>";
						$db->Execute($ins_n) or die($db->ErrorMsg());
						
						$i_sql="SELECT LAST_INSERT_ID() AS myid";
						$rs=$db->Execute($i_sql) or die($db->ErrorMsg());
						$id_notificacion=$rs->fields['myid'];
					}
					
					if(isset($id_notificacion))
					{
						if(isset($rs_tra))
						{
							$rs_tra->MoveFirst();
							while(!$rs_tra->EOF)
							{
								$ins_rec="INSERT INTO recibidos (id_persona_destinatario, id_persona_remitente, id_notificacion, leido, urgente, archivado_dest, archivado_remit) 
								VALUES ('".$rs_tra->fields['id_persona']."','".$rs_rem->fields['id_persona']."','".$id_notificacion."', '0','".$urgente."','0','0')";//print $ins_n."<br>";
								$db->Execute($ins_rec) or die($db->ErrorMsg());
								
								$origen="../../../archivos/esquelas/".$_SESSION['user']."/tmp/";
								$destino="../../../archivos/esquelas/".$_SESSION['user']."/".$id_notificacion."/";					
								
								$directorio=opendir($origen);
								while ($archivo = readdir($directorio))
								{
									if (($archivo != '.') AND ($archivo != '..')) 
									{
										if(!file_exists($origen)) 
										mkdir($origen, 0777, true);
										
										if(!file_exists($destino)) 
										mkdir($destino, 0777, true);
										
										$archivo_origen = $origen.$archivo;
										$archivo_destino = $destino.$archivo;
										if($adjuntos=='')$adjuntos=$archivo_destino;else $adjuntos.='&&'.$archivo_destino;
										rename($archivo_origen, $archivo_destino);
										
										$ins_adj="INSERT INTO adjuntos(id_notificacion, nombre_adjunto) 
										VALUES ('".$id_notificacion."','".$archivo."')";
										$db->Execute($ins_adj) or die($db->ErrorMsg());
									}
								}
								closedir($directorio);
								
								$body = $_POST['txt_mensaje'];
								$body = utf8_decode($body);									
								$host="smtp.gmail.com";
								$port=465;
								$sec="ssl";
								$from=$mail_sistema;
								$pass=$clave_mail;
								$name=$nombre_sucursal." - ".$titulo_sitio;
								$para=$rs_tra->fields['email'];
								$asunto=utf8_decode($_POST['txt_asunto']);
								$adjunto=$adjuntos;
									
								$obj->enviar_mail($mail, $host, $port, $sec, $from, $pass, $name, $para, $asunto, $body, $adjunto);			
								
								$hay_destinatarios=1;
							
							$rs_tra->MoveNext();
							}
						}
						
						if(isset($rs_fam))
						{
							$rs_fam->MoveFirst();
							while(!$rs_fam->EOF)
							{
								$ins_rec="INSERT INTO recibidos (id_persona_destinatario, id_persona_remitente, id_notificacion, leido, urgente, archivado_dest, archivado_remit) 
								VALUES ('".$rs_fam->fields['id_persona']."','".$rs_rem->fields['id_persona']."','".$id_notificacion."', '0','".$urgente."','0','0')";//print $ins_rec." rec<br>";
								$db->Execute($ins_rec) or die($db->ErrorMsg());
								
								$origen="../../../archivos/esquelas/".$_SESSION['user']."/tmp/";
								$destino="../../../archivos/esquelas/".$_SESSION['user']."/".$id_notificacion."/";					
								
								$directorio=opendir($origen);
								while ($archivo = readdir($directorio))
								{
									if (($archivo != '.') AND ($archivo != '..')) 
									{
										if(!file_exists($origen)) 
										mkdir($origen, 0777, true);
										
										if(!file_exists($destino)) 
										mkdir($destino, 0777, true);
										
										$archivo_origen = $origen.$archivo;
										$archivo_destino = $destino.$archivo;
										if($adjuntos=='')$adjuntos=$archivo_destino;else $adjuntos.='&&'.$archivo_destino;
										rename($archivo_origen, $archivo_destino);
										
										$ins_adj="INSERT INTO adjuntos(id_notificacion, nombre_adjunto) 
										VALUES ('".$id_notificacion."','".$archivo."')";
										$db->Execute($ins_adj) or die($db->ErrorMsg());
									}
								}
								closedir($directorio);
								
								$body = $_POST['txt_mensaje'];
								$body = utf8_decode($body);									
								$host="smtp.gmail.com";
								$port=465;
								$sec="ssl";
								$from=$mail_sistema;
								$pass=$clave_mail;
								$name=$nombre_sucursal." - ".$titulo_sitio;
								$para=$rs_fam->fields['email'];
								$asunto=utf8_decode($_POST['txt_asunto']);
								$adjunto=$adjuntos;
									
								$obj->enviar_mail($mail, $host, $port, $sec, $from, $pass, $name, $para, $asunto, $body, $adjunto);
							
								$hay_destinatarios=1;
							
							$rs_fam->MoveNext();
							}
						}
						
						if(isset($rs_est))
						{
							$rs_est->MoveFirst();
							while(!$rs_est->EOF)
							{	
								$ins_rec="INSERT INTO recibidos (id_persona_destinatario, id_persona_remitente, id_notificacion, leido, urgente, archivado_dest, archivado_remit) 
								VALUES ('".$rs_est->fields['id_persona']."','".$rs_rem->fields['id_persona']."','".$id_notificacion."', '0','".$urgente."','0','0')";//print $ins_rec."<br>";
								$db->Execute($ins_rec) or die($db->ErrorMsg());
								
								$origen="../../../archivos/esquelas/".$_SESSION['user']."/tmp/";
								$destino="../../../archivos/esquelas/".$_SESSION['user']."/".$id_notificacion."/";					
								
								$directorio=opendir($origen);
								while ($archivo = readdir($directorio))
								{
									if (($archivo != '.') AND ($archivo != '..')) 
									{
										if(!file_exists($origen)) 
										mkdir($origen, 0777, true);
										
										if(!file_exists($destino)) 
										mkdir($destino, 0777, true);
										
										$archivo_origen = $origen.$archivo;
										$archivo_destino = $destino.$archivo;
										if($adjuntos=='')$adjuntos=$archivo_destino;else $adjuntos.='&&'.$archivo_destino;
										rename($archivo_origen, $archivo_destino);
										
										$ins_adj="INSERT INTO adjuntos(id_notificacion, nombre_adjunto) 
										VALUES ('".$id_notificacion."','".$archivo."')";
										$db->Execute($ins_adj) or die($db->ErrorMsg());
									}
								}
								closedir($directorio);
								
								$body = $_POST['txt_mensaje'];
								$body = utf8_decode($body);									
								$host="smtp.gmail.com";
								$port=465;
								$sec="ssl";
								$from=$mail_sistema;
								$pass=$clave_mail;
								$name=$nombre_sucursal." - ".$titulo_sitio;
								$para=$rs_est->fields['email'];
								$asunto=utf8_decode($_POST['txt_asunto']);
								$adjunto=$adjuntos;
									
								$obj->enviar_mail($mail, $host, $port, $sec, $from, $pass, $name, $para, $asunto, $body, $adjunto);
								
								$hay_destinatarios=1;
							
							$rs_est->MoveNext();
							}
						}
					}
					else
					$mensaje='No se ha creado la notificaci&oacute;n';
				}
				else
				$hay_destinatarios=0;
			}
			else
			$hay_destinatarios=0;
		$rs_f->MoveNext();
		}
		
		if(isset($_POST['txt_per']))
		{
			if($_POST['txt_per']!='')
			{
				$var = explode(",",$_POST['txt_per']);		
					
				if(count($var) != 0)
				{
					if(!isset($id_notificacion))
					{
						$ins_n="INSERT INTO notificacion (asunto, mensaje, fecha_envio) 
						VALUES ('".$_POST['txt_asunto']."','".$_POST['txt_mensaje']."','".$now."')";//print $ins_n."<br>";
						$db->Execute($ins_n) or die($db->ErrorMsg());
						
						$i_sql="SELECT LAST_INSERT_ID() AS myid";
						$rs=$db->Execute($i_sql) or die($db->ErrorMsg());
						$id_notificacion=$rs->fields['myid'];
					}
					
					if(isset($id_notificacion))
					{
						for ($i = 0; $i < count($var); next($var), $i++) 
						{				
							$id = current($var);
							
							$sql_per="SELECT persona.id_persona, email
							FROM persona WHERE 1 AND persona.id_persona='".$id."'";//print $sql_per.'<br>';
							$rs_per=$db->Execute($sql_per) or die($db->ErrorMsg());	
							
							$ins_rec="INSERT INTO recibidos (id_persona_destinatario, id_persona_remitente, id_notificacion, leido, urgente, archivado_dest, archivado_remit) 
							VALUES ('".$id."','".$rs_rem->fields['id_persona']."','".$id_notificacion."', '0','".$urgente."','0','0')";//print $ins_rec." rec2 <br>";
							$db->Execute($ins_rec) or die($db->ErrorMsg());
							
							$origen="../../../archivos/esquelas/".$_SESSION['user']."/tmp/";
							$destino="../../../archivos/esquelas/".$_SESSION['user']."/".$id_notificacion."/";					
							
							$directorio=opendir($origen);
							while ($archivo = readdir($directorio))
							{
								if (($archivo != '.') AND ($archivo != '..')) 
								{
									if(!file_exists($origen)) 
									mkdir($origen, 0777, true);
									
									if(!file_exists($destino)) 
									mkdir($destino, 0777, true);
									
									$archivo_origen = $origen.$archivo;
									$archivo_destino = $destino.$archivo;
									if($adjuntos=='')$adjuntos=$archivo_destino;else $adjuntos.='&&'.$archivo_destino;
									rename($archivo_origen, $archivo_destino);
									
									$ins_adj="INSERT INTO adjuntos(id_notificacion, nombre_adjunto) 
									VALUES ('".$id_notificacion."','".$archivo."')";
									$db->Execute($ins_adj) or die($db->ErrorMsg());
								}
							}
							closedir($directorio);
							
							$body = $_POST['txt_mensaje'];
							$body = utf8_decode($body);									
							$host="smtp.gmail.com";
							$port=465;
							$sec="ssl";
							$from=$mail_sistema;
							$pass=$clave_mail;
							$name=$nombre_sucursal." - ".$titulo_sitio;
							$para=$rs_per->fields['email'];
							$asunto=utf8_decode($_POST['txt_asunto']);
							$adjunto=$adjuntos;
								
							$obj->enviar_mail($mail, $host, $port, $sec, $from, $pass, $name, $para, $asunto, $body, $adjunto);
							
							$hay_destinatarios=1;
						}
					}
					else
					$mensaje='No se ha creado la notificaci&oacute;n';
				}
			}
			else
			$hay_destinatarios=0;
		}
		else
		$hay_destinatarios=0;
		
		if($hay_destinatarios==1)
		echo ("<script language='JavaScript' type='text/javascript'> location.href='lis_".$elemento.".php?mensaje=Mensaje enviado satisfactoriamente.'</script>");
	}
if($hay_destinatarios==0)
$mensaje='Debe seleccionar destinatarios.';
}

$rs_f->MoveFirst();

if(isset($_GET['mensaje']))
$mensaje.=$_GET['mensaje'];
if(isset($return[0]))
$mensaje.=$return[0];
$obj->Imprimir_mensaje($mensaje);	
?>

&nbsp;
<br>

<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href='<?php print $x."js/tabs/css/luna/tab.css";?>'>
<link rel="stylesheet" type="text/css" href="../../../include/jquery-tree-master/src/css/jquery.tree.css"/>
<link rel="stylesheet" type="text/css" href="../../../include/jquery-tree-master/css/jquery-ui.css"/>

<script type="text/javascript" src='<?php print $x."js/tabs/js/tabpane.js";?>'></script>
<script type="text/javascript" src="../../../include/jquery-tree-master/js/jquery-ui.js"></script>
<script type="text/javascript" src="../../../include/jquery-tree-master/src/js/jquery.tree.js"></script>
<script src="../../../include/ckeditor/ckeditor.js"></script>
<script src="<?php print $x."include/upload/js/upload.js";?>"></script>
<script src="<?php print $x."include/upload/js/bootstrap.min.js";?>"></script>
<script src="js.js"></script>

<div style='margin: 0 auto;width:98%;'>
	<div class="tab-pane" id="tabPane1">
		<div class="tab-page" id="tabPage1" >
			<h2 class="tab">Destinatarios</h2>			
			
			<div style='display:table;width:100%;'>
				<br>
				<div style='display:table-row;'>					
					<div style='display:table-cell;width:30%;text-align:left;padding-left: 1%;'>
					
						<div id="example-0" style='width:100%;'>
							<script class="jquery" lang="text/javascript">
								$('#example-0 div').tree({
								});
							</script>
							<p>Enviar a:</p>
							<div>
								<ul>
									<li><input type="checkbox"><span>Toda la instituci&oacute;n</span>
										<?php
										$grado='';
										$seccion_academica='';
										for($f=1;$f<=$rs_f->RecordCount();$f++)
										{
											if($rs_f->fields['seccion_academica']!=$seccion_academica)
											{								
										?>
												<ul>
													<li><input type="checkbox"><span><?php print utf8_decode($rs_f->fields['seccion_academica']);$seccion_academica=$rs_f->fields['seccion_academica'];?></span>
														<?php
											}
															if($rs_f->fields['grado']!=$grado)
															{
																
														?>
																<ul>
																	<li><input type="checkbox"><span><?php print $rs_f->fields['grado'];$grado=$rs_f->fields['grado'];?></span>
														<?php 
															}												
														?>				
																		<ul>
																			<li><input name="<?php print $rs_f->fields['id_grado_paralelo_periodo'];?>" id="<?php print $rs_f->fields['id_grado_paralelo_periodo'];?>" type="checkbox"><span><?php print utf8_decode($rs_f->fields['grado_paralelo']);?></span>
																		</ul>												
														<?php
															$rs_f->MoveNext();
															
															if($rs_f->fields['grado']!=$grado)
															{
																print '</ul>';
															}
											if($rs_f->fields['seccion_academica']!=$seccion_academica)
											{				
												print '</ul>';
											}
										}
										?>                        
												</ul>						
								</ul>
							</div>
						</div>
					</div>
					
					<div style='display:table-cell;text-align:left;padding-left: 1%;'>
						<p>Filtrar por tipo de persona dentro de las secciones, grupos o paralelos escogidos:</p>
						<div class=' ui-widget-content ' style='display:table;width:100%'>
							<br>
							<div style='display:table-row;'>					
								<div style='display:table-cell;height:32px;text-align:right;padding-left: 1%;width:10%'>
									Trabajador:							
								</div>
								<div style='display:table-cell;height:32px;text-align:left;padding-right: 70%;width:90%'>
									<section>
										<div class="checkbox-3">
											<input class="checkbox_oculto" name='cbx_trabajador' checked value='1' type="checkbox" id="cbx_trabajador" />
											<label for="cbx_trabajador"></label>
										</div>
									</section>						
								</div>								
							</div>
							
							<div style='display:table-row;'>					
								<div style='display:table-cell;height:32px;text-align:right;padding-left: 1%;'>
									Familiar:							
								</div>
								<div style='display:table-cell;height:32px;text-align:left;padding-right: 70%;'>
									<section>
										<div class="checkbox-3">
											<input class="checkbox_oculto" name='cbx_familiar' checked value='1' type="checkbox" id="cbx_familiar" />
											<label for="cbx_familiar"></label>
										</div>
									</section>						
								</div>								
							</div>
							
							<div style='display:table-row;'>					
								<div style='display:table-cell;height:32px;text-align:right;padding-left: 1%;'>
									Estudiante:							
								</div>
								<div style='display:table-cell;height:32px;text-align:left;padding-right: 70%;'>
									<section>
										<div class="checkbox-3">
											<input class="checkbox_oculto" name='cbx_estudiante' value='1' type="checkbox" id="cbx_estudiante" />
											<label for="cbx_estudiante"></label>
										</div>
									</section>						
								</div>								
							</div>
							
							<?php
							$sql_p="SELECT id_persona, primer_apellido,segundo_apellido,primer_nombre,segundo_nombre FROM persona WHERE 1 AND email!=''";
							$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
							?>
						</div>
						
						<br>
						<p>Agregar personas fuera de los filtros escogidos:</p>
						<div class=' ui-widget-content' style='display:table;width:100%'>
							<br>						
							<div style='display:table-row;'>					
								<div style='display:table-cell;height:32px;text-align:right;padding-left: 1%;width:10%'>
									Filtrar:						
								</div>
								<div style='display:table-cell;height:32px;text-align:left;width:90%'>
								<input type="hidden" name="txt_per"id="txt_per" size='100' />	
									<select class="js-example-basic-multiple" name="sel_per" id="sel_per" multiple="multiple" onchange="p();">
										<option value='0'>----------------------Seleccionar----------------------</option>
										<?php $rs_p->MoveFirst();for($p=0;$p<$rs_p->RecordCount();$p++){?>					
											<option value="<?php print $rs_p->fields['id_persona'];?>"> <?php print utf8_decode($rs_p->fields['primer_apellido'].' '.$rs_p->fields['segundo_apellido'].' '.$rs_p->fields['primer_nombre'].' '.$rs_p->fields['segundo_nombre']);?> </option>						
										<?php $rs_p->MoveNext();}?>
									</select>					
								</div>								
							</div>
						</div>
						<br>
						<p><i>Los grupos y paralelos mostrados corresponden al per&iacute;odo lectivo que se encuentre activo. Solo se enviar&aacute;n las notificaciones por correo electr&oacute;nico a las personas que tengan una direcci&oacute;n registrada y est&eacute; correcta. Para el caso de estudiantes si se han retirado no se les enviar&aacute; la notificaci&oacute;n, para el caso de familiares si el usuario no est&aacute; activo o su hijo se ha retirado no se les enviar&aacute; la notificaci&oacute;n, para el caso de un empleado si su usuario no est&aacute; activo no se les enviar&aacute; la notificaci&oacute;n.</i></p>
						

						
						
						
					</div>
					
				</div>
			</div>	
		</div>

		<div class="tab-page" id="tabPage2">
			<h2 class="tab">Mensaje</h2>
			
			<div style='display:table;width:100%;'>
				<br>
				<div style='display:table-row;'>					
					<div style='display:table-cell;height:22px;width:100%;text-align:left;padding-left: 1%;'>
					
						<div style='display:table;width:100%;'>
							<div style='display:table-row;'>
								<div style='display:table-cell;height:22px;width:10%;text-align:left;'>
									Urgente:
								</div>				
								<div style='display:table-cell;height:22px;width:90%;text-align:left;padding-right: 100%;'>
									<section>
										<div class="checkbox-3">
											<input class="checkbox_oculto" name='cbx_urgente' value='1' type="checkbox" id="cbx_urgente" />
											<label for="cbx_urgente"></label>
										</div>
									</section>
								</div>
							</div>
						</div>
						
					</div>
				</div>
				<br>
				<div style='display:table-row;'>					
					<div style='display:table-cell;height:22px;width:100%;text-align:left;padding-left: 1%;'>
						Asunto:<input type="text" title="Asunto" name="txt_asunto"id="txt_asunto" size='100' />
					</div>
				</div>
				<br>
				<div style='display:table-row;'>
					<div style='display:table-cell;height:22px;width:100%;text-align:left;padding-left: 1%;'>
						<textarea name="txt_mensaje" title="Cuerpo del mensaje"  id="txt_mensaje" rows="10" cols="80"></textarea>
						<script>CKEDITOR.replace( 'txt_mensaje', {
							filebrowserBrowseUrl: '../../../include/ckfinder/ckfinder.html',
							filebrowserUploadUrl: '../../../include/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'} );
						</script>
					</div>
				</div>
			</div>			
		</div>
		
		<div class="tab-page">
			<h2 class="tab">Adjuntos</h2>
			
			<div id="respuesta" class="alert"></div>
			<form action="javascript:void(0);">
				<div style='display:table;width:100%;'>			
					
					<div style='display:table-row;'>
						<div style='display:table-cell;width:100%;text-align:center;'>
							<input type="hidden" name="nombre_archivo" id="nombre_archivo" />
							<div class="upload">
								<input type="file" name="archivo" id="archivo" onchange="poner_valor();subirArchivos();"/>
								<progress id="barra_de_progreso" value="0" size="1000"></progress>
							</div>
						</div>									
					</div>	
					
					<br>
					
					<div style='display:none;' id='row_archivos_subidos'>
						<div style='display:table-cell;height:30px;width:100%;text-align:left;'>
							<div id="archivos_subidos" ></div>
						</div>									
					</div>								
					
				</div>	
			</form>
			
		</div>
		<?php /**/?>
		
	</div>
</div>

<script type="text/javascript">setupAllTabs();</script>

<br>

<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/new_footer.php");
?>