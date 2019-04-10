<?php
$x='../../../../';
//include($x."pag/acad/actividad/variables.php");
include($x."config/variables.php");
include($x."config/clases.inc.php");
$clases = new clases();

include("../../clases_acad.php");
$clases_acad = new clases_acad();

date_default_timezone_set('Etc/UTC');
include($x."include/PHPMailer-master/PHPMailerAutoload.php");
$mail = new PHPMailer();

$sql_e="SELECT envio_calificacion_baja, empleado.id_empleado, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, email_inst
FROM empleado, persona, usuario, control_notificaciones_automaticas WHERE 1 AND persona.id_persona=empleado.id_persona
AND control_notificaciones_automaticas.id_empleado=empleado.id_empleado AND persona.id_persona=usuario.id_persona AND usuario='".$_SESSION['user']."'";//print $sql_e;// die();
$rs_e=$db->Execute($sql_e) or die($db->ErrorMsg());
if(isset($rs_e->fields['envio_calificacion_baja']))
$envio_calificacion_baja=$rs_e->fields['envio_calificacion_baja'];
else
$envio_calificacion_baja=0;

$email=$rs_e->fields['email_inst'];
$docente=$rs_e->fields['primer_apellido'].' '.$rs_e->fields['segundo_apellido'].' '.$rs_e->fields['primer_nombre'];
if($rs_e->fields['segundo_nombre']!='')$docente.=' '.$rs_e->fields['segundo_nombre'];
$docente.=' ('.$email.')';

if(isset($_POST['changes']) && $_POST['changes']) 
{//print $_POST['changes'];
	$change = explode(",",$_POST['changes']);//print count($change);die();	
	$i=0;
	$inicial=2;
	$out=array('result'=>'no');
	
	for($r=0;$r<count($change)-3;$r=$r+4)
	{
		$fila[$i]  = $change[$r];//print  'fila: '.$fila[$i];
		$col[$i+$inicial]  = $change[$r+1];//print  '  col: '. $col[$i+$inicial];
		$nuevo_valor[$i] = $change[$r+3];//print  '  nuevo_valor: '.$nuevo_valor;
		
	$i+=1;
	}

	$id_clase = $change[count($change)-4];
	$sel_filtro_cal = $change[count($change)-3];
	$id_asignatura = $change[count($change)-2];
	$sel_filtro_tip = $change[count($change)-1];

	$tipo=substr($sel_filtro_cal, 0, 2);//print $tipo;
	$sel_filtro_cal=substr($sel_filtro_cal, 2, strlen($sel_filtro_cal));
	
	//$actualizar_grid=$clases_acad->contenido_calificaciones($db, $x, $id_clase, $sel_filtro_cal, $id_asignatura, $sel_filtro_tip);
	
	$sql_nota="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_academica WHERE activa='1'";//print $sql_nota.'<br>';
	$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
	
	$nota_aprobado=$rs_nota->fields['nota_aprobado'];
	
	$sql_est="SELECT estudiante.id_estudiante, clase_estudiante.id_clase_estudiante, referencia, concat(per_estudiante.primer_apellido,' ',per_estudiante.segundo_apellido,' ',per_estudiante.primer_nombre,' ',per_estudiante.segundo_nombre) AS estudiante
	FROM persona AS per_estudiante, estudiante, curso_grado_paralelo_est, clase_estudiante, clase, n_periodo_academico,
	empleado_academico, empleado
	WHERE 1
	AND per_estudiante.id_persona=estudiante.id_persona
	AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante
	AND curso_grado_paralelo_est.id_curso_grado_paralelo_est=clase_estudiante.id_curso_grado_paralelo_est
	AND clase_estudiante.id_clase=clase.id_clase
	AND clase.id_periodo_academico=n_periodo_academico.id_periodo_academico
	AND clase.id_empleado_academico=empleado_academico.id_empleado_academico 
	AND empleado_academico.id_empleado=empleado.id_empleado 
	AND n_periodo_academico.activo='1' AND clase.id_clase='".$id_clase."'";//print $sql_est;
	$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
	
	if($tipo=='s_')//falta agregar el codigo para guardar notas de exámenes adicionales en el subperiodo
	{
		$sql_s="SELECT actividad.id_actividad, actividad_examen, fecha
		FROM clase, actividad, n_periodo_academico,	empleado_academico, empleado , n_tipo_actividad
		WHERE 1
		AND n_tipo_actividad.id_tipo_actividad=actividad.id_tipo_actividad
		AND actividad.id_clase=clase.id_clase
		AND clase.id_periodo_academico=n_periodo_academico.id_periodo_academico
		AND clase.id_empleado_academico=empleado_academico.id_empleado_academico 
		AND empleado_academico.id_empleado=empleado.id_empleado 
		AND n_periodo_academico.activo='1' AND clase.id_clase='".$id_clase."' 
		AND n_tipo_actividad.id_subperiodo_evaluativo='".$sel_filtro_cal."' ORDER BY n_tipo_actividad.orden, actividad.fecha, actividad.id_actividad";//print $sql_act;
		$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
		
		$rs_est->MoveFirst();		
		for($e=0;$e<$rs_est->RecordCount();$e++)
		{
			$ini_sub=$inicial+$rs_s->RecordCount();
			
			$sql_fam="SELECT per_familiar.primer_apellido, per_familiar.segundo_apellido, per_familiar.primer_nombre, per_familiar.segundo_nombre, email, telefono1, telefono2, parentesco
			FROM familiar_estudiante, n_parentesco, familiar, persona AS per_familiar
			WHERE 1
			AND familiar_estudiante.id_familiar=familiar.id_familiar
			AND familiar_estudiante.id_parentesco=n_parentesco.id_parentesco
			AND per_familiar.id_persona=familiar.id_persona
			AND id_estudiante='".$rs_est->fields['id_estudiante']."'
			AND representante_aca='1'";//print $sql_est;
			$rs_fam=$db->Execute($sql_fam) or die($db->ErrorMsg());
			
			/*for($fam=0;$fam<$rs_fam->RecordCount();$fam++)
			{
				$familiares=$familiares.'<b>'.$rs_fam->fields['parentesco'].':</b><br>'.$rs_fam->fields['familiar'].'<br>';
				if($rs_fam->fields['email'])$familiares=$familiares.$rs_fam->fields['email'].'<br>';
				if($rs_fam->fields['telefono1'])$familiares=$familiares.$rs_fam->fields['telefono1'].'<br>';
				if($rs_fam->fields['telefono2'])$familiares=$familiares.$rs_fam->fields['telefono2'].'<br>';
			$rs_fam->MoveNext();
			}*/
		
			$rs_s->MoveFirst();
			for($a=$inicial;$a<$ini_sub;$a++)
			{
				for($c=0;$c<$i;$c++)
				{
					if($e==$fila[$c] && $a==$col[$c+$inicial])
					{
						if($nuevo_valor[$c]!='')
						{
							$sql_nota="SELECT nota FROM nota_actividad_examen WHERE id_actividad='".$rs_s->fields['id_actividad']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $sql_nota.'<br>';
							$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
							
							if($rs_nota->fields['nota']=='')
							{
								$ins_nota="INSERT INTO nota_actividad_examen(nota, id_actividad, id_clase_estudiante) VALUES('".$nuevo_valor[$c]."','".$rs_s->fields['id_actividad']."','".$rs_est->fields['id_clase_estudiante']."')";//print $ins_nota.'<br>';
								$db->Execute($ins_nota) or die($db->ErrorMsg());
								$out = array('result'=>'ok');
							}
							else
							{	
								if($nuevo_valor[$c]!=$rs_nota->fields['nota'])
								{
									$upd_nota="UPDATE nota_actividad_examen SET nota='".$nuevo_valor[$c]."' WHERE id_actividad='".$rs_s->fields['id_actividad']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $upd_nota.'<br>';
									$db->Execute($upd_nota) or die($db->ErrorMsg());
									$out = array('result'=>'ok');
									//$clases_acad->contenido_calificaciones($db, $x, $id_clase, $sel_filtro_cal, $id_asignatura, $sel_filtro_tip)
								}
							}
							if($nuevo_valor[$c]<$nota_aprobado)
							{
								$body = 'Estimado/a '.$rs_fam->fields['primer_apellido'].' '.$rs_fam->fields['segundo_apellido'].' '.$rs_fam->fields['primer_nombre'].' '.$rs_fam->fields['segundo_nombre'].':<br><br>';
								$body = $body.'Informamos a Ud. que su representado(a) '.$rs_est->fields['estudiante'].' ha obtenido la calificaci&oacute;n <b>'.$nuevo_valor[$c].' puntos</b>';
								$body = $body.' en la actividad: <b>'.$rs_s->fields['actividad_examen'].'</b>, con fecha: '.$rs_s->fields['fecha'];
								$body = $body.', correspondiente a: '.$rs_est->fields['referencia'].'.';
								$body = $body.'<br><br>Puede revisar las calificaciones en el sistema '.$titulo_sitio.' en la siguiente URL:';
								$body = $body.'<br><a href="'.$url.'">'.$url.'</a>';
								$body = $body.'<br><br>De requerir mayor informaci&oacute;n puede programar una cita con el docente de la asignatura ('.$docente.').';
								$body = $body.'<br><br>Este correo se ha generado autom&aacute;ticamente, cualquier duda o sugerencia escriba a: '.$mail_soporte;
								$body = $body.'<br><br>Saludos cordiales';
								$body = $body.'<br><b>'.$nombre_sucursal.'</b>';
								$body = utf8_decode($body);
								
								$host="smtp.gmail.com";
								$port=465;
								$sec="ssl";
								$from=$mail_sistema;
								$pass=$clave_mail;
								$name=$nombre_sucursal." - ".$titulo_sitio;
								$para="rojeda@atenas.edu.ec; ".$email;//$rs_fam->fields['email'];
								$asunto="Calificación baja del estudiante ".$rs_est->fields['estudiante'];
								$adjunto="";
								if($envio_calificacion_baja==1)
								$clases->enviar_mail($mail, $host, $port, $sec, $from, $pass, $name, $para, $asunto, $body, $adjunto);
							}
						}
						else
						{
							$del_nota="DELETE FROM nota_actividad_examen WHERE id_actividad='".$rs_s->fields['id_actividad']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $del_nota.'<br>';
							$db->Execute($del_nota) or die($db->ErrorMsg());
							$out = array('result'=>'ok');
						}
					}
				}
			$rs_s->MoveNext();
			}		
		$rs_est->MoveNext();
		}
	}
	elseif($tipo=='p_')
	{		
		$sql_s="SELECT id_subperiodo_evaluativo
		FROM n_subperiodo_evaluativo
		WHERE 1	AND n_subperiodo_evaluativo.id_periodo_evaluativo='".$sel_filtro_cal."'";//print $sql_s;
		$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
		
		$sql_p="SELECT id_examen_periodo_eval, examen_eval
		FROM n_examen_periodo_eval, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
		AND n_examen_periodo_eval.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
		AND n_periodo_evaluativo.id_periodo_evaluativo='".$sel_filtro_cal."'
		AND n_examen_periodo_eval.id_asignatura='".$id_asignatura."'
		AND n_examen_periodo_eval.peso!='0'
		AND n_conf_academica.activa='1'";//print $sql_p;die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
		$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
		
		$sql_p_adic="SELECT id_exa_adicional_periodo, examen_adicional, abv_examen, tipo_examen, opcional
		FROM n_examen_adicional, n_tipo_examen, n_exa_adicional_periodo, n_examen_periodo_eval, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_examen_adicional.id_examen_adicional=n_exa_adicional_periodo.id_examen_adicional
		AND n_tipo_examen.id_tipo_examen=n_exa_adicional_periodo.id_tipo_examen
		AND n_exa_adicional_periodo.id_examen_periodo_eval=n_examen_periodo_eval.id_examen_periodo_eval
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
		AND n_examen_periodo_eval.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
		AND n_periodo_evaluativo.id_periodo_evaluativo='".$sel_filtro_cal."'
		AND n_examen_periodo_eval.id_asignatura='".$id_asignatura."'
		AND n_conf_academica.activa='1' ORDER BY n_exa_adicional_periodo.orden";//print $sql_p_adic;die();//, actividad.fecha
		$rs_p_adic=$db->Execute($sql_p_adic) or die($db->ErrorMsg());
		
		$ini_sub=$inicial+$rs_s->RecordCount();
		$ini_sub_per=$inicial+$rs_s->RecordCount()+$rs_p->RecordCount();
		$ini_sub_per_adic=$inicial+$rs_s->RecordCount()+$rs_p->RecordCount()+$rs_p_adic->RecordCount();
		
		$rs_est->MoveFirst();		
		for($e=0;$e<$rs_est->RecordCount();$e++)
		{	
			$sql_fam="SELECT per_familiar.primer_apellido, per_familiar.segundo_apellido, per_familiar.primer_nombre, per_familiar.segundo_nombre, email, telefono1, telefono2, parentesco
			FROM familiar_estudiante, n_parentesco, familiar, persona AS per_familiar
			WHERE 1
			AND familiar_estudiante.id_familiar=familiar.id_familiar
			AND familiar_estudiante.id_parentesco=n_parentesco.id_parentesco
			AND per_familiar.id_persona=familiar.id_persona
			AND id_estudiante='".$rs_est->fields['id_estudiante']."'
			AND representante_aca='1'";//print $sql_est;
			$rs_fam=$db->Execute($sql_fam) or die($db->ErrorMsg());
			
			$rs_p->MoveFirst();
			for($p=$ini_sub;$p<$ini_sub_per;$p++)
			{
				for($c=0;$c<$i;$c++)
				{//print '<br>fila: '.$fila[$c].'  col: '.$col[$c].'  nuevo_valor: '.$nuevo_valor[$c].'  c:'.$c.'  e:'.$e;
					//print '             e: '.$e.' fila:'.$fila[$c].' p:'.$p.' col:'.$col[$c+$inicial];
					if($e==$fila[$c] && $p==$col[$c+$inicial])
					{
						if($nuevo_valor[$c]!='')
						{
							//print $rs_p->fields['id_actividad'];die();
							$sql_nota="SELECT nota FROM nota_examen_periodo_eval WHERE id_examen_periodo_eval='".$rs_p->fields['id_examen_periodo_eval']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $sql_nota.'<br>';
							$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
							
							if($rs_nota->fields['nota']=='')
							{
								$ins_nota="INSERT INTO nota_examen_periodo_eval(nota, id_examen_periodo_eval, id_clase_estudiante) VALUES('".$nuevo_valor[$c]."','".$rs_p->fields['id_examen_periodo_eval']."','".$rs_est->fields['id_clase_estudiante']."')";//print $ins_nota.'<br>';
								$db->Execute($ins_nota) or die($db->ErrorMsg());
								$out = array('result'=>'ok');
							}
							else
							{	
								if($nuevo_valor[$c]!=$rs_nota->fields['nota'])
								{
									$upd_nota="UPDATE nota_examen_periodo_eval SET nota='".$nuevo_valor[$c]."' WHERE id_examen_periodo_eval='".$rs_p->fields['id_examen_periodo_eval']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $upd_nota.'<br>';
									$db->Execute($upd_nota) or die($db->ErrorMsg());
									$out = array('result'=>'ok');
								}
							}
							
							if($nuevo_valor[$c]<$nota_aprobado)
							{
								$body = 'Estimado/a '.$rs_fam->fields['primer_apellido'].' '.$rs_fam->fields['segundo_apellido'].' '.$rs_fam->fields['primer_nombre'].' '.$rs_fam->fields['segundo_nombre'].':<br><br>';
								$body = $body.'Informamos a Ud. que su representado(a) '.$rs_est->fields['estudiante'].' ha obtenido la calificaci&oacute;n <b>'.$nuevo_valor[$c].' puntos</b>';
								$body = $body.' en la actividad: <b>'.$rs_p->fields['examen_eval'].'</b>';
								$body = $body.', correspondiente a: '.$rs_est->fields['referencia'].'.';
								$body = $body.'<br><br>Puede revisar las calificaciones en el sistema '.$titulo_sitio.' en la siguiente URL:';
								$body = $body.'<br><a href="'.$url.'">'.$url.'</a>';
								$body = $body.'<br><br>De requerir mayor informaci&oacute;n puede programar una cita con el docente de la asignatura ('.$docente.').';
								$body = $body.'<br><br>Este correo se ha generado autom&aacute;ticamente, cualquier duda o sugerencia escriba a: '.$mail_soporte;
								$body = $body.'<br><br>Saludos cordiales';
								$body = $body.'<br><b>'.$nombre_sucursal.'</b>';
								$body = utf8_decode($body);
								
								$host="smtp.gmail.com";
								$port=465;
								$sec="ssl";
								$from=$mail_sistema;
								$pass=$clave_mail;
								$name=$nombre_sucursal." - ".$titulo_sitio;
								$para="rojeda@atenas.edu.ec; ".$email;//$rs_fam->fields['email'];
								$asunto="Calificación baja del estudiante ".$rs_est->fields['estudiante'];
								$adjunto="";
								if($envio_calificacion_baja=='1')
								$clases->enviar_mail($mail, $host, $port, $sec, $from, $pass, $name, $para, $asunto, $body, $adjunto);
							}
						}
						else
						{
							$del_nota="DELETE FROM nota_examen_periodo_eval WHERE id_examen_periodo_eval='".$rs_p->fields['id_examen_periodo_eval']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $del_nota.'<br>';
							$db->Execute($del_nota) or die($db->ErrorMsg());
							$out = array('result'=>'ok');
						}
					}
				}
			$rs_p->MoveNext();
			}

			$rs_p_adic->MoveFirst();
			for($d=$ini_sub_per;$d<$ini_sub_per_adic;$d++)
			{
				for($c=0;$c<$i;$c++)
				{//print '<br>fila: '.$fila[$c].'  col: '.$col[$c].'  nuevo_valor: '.$nuevo_valor[$c].'  c:'.$c.'  e:'.$e;
					//print '             e: '.$e.' fila:'.$fila[$c].' d:'.$d.' col:'.$col[$c+$inicial];
					if($e==$fila[$c] && $d==$col[$c+$inicial])
					{
						if($nuevo_valor[$c]!='')
						{
							//print $rs_p->fields['id_actividad'];die();
							$sql_nota="SELECT nota FROM nota_exa_adicional_periodo WHERE id_exa_adicional_periodo='".$rs_p_adic->fields['id_exa_adicional_periodo']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $sql_nota.'<br>';
							$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
							
							if($rs_nota->fields['nota']=='')
							{
								$ins_nota="INSERT INTO nota_exa_adicional_periodo(nota, id_exa_adicional_periodo, id_clase_estudiante) VALUES('".$nuevo_valor[$c]."','".$rs_p_adic->fields['id_exa_adicional_periodo']."','".$rs_est->fields['id_clase_estudiante']."')";//print $ins_nota.'<br>';
								$db->Execute($ins_nota) or die($db->ErrorMsg());
								$out = array('result'=>'ok');
							}
							else
							{	
								if($nuevo_valor[$c]!=$rs_nota->fields['nota'])
								{
									$upd_nota="UPDATE nota_exa_adicional_periodo SET nota='".$nuevo_valor[$c]."' WHERE id_exa_adicional_periodo='".$rs_p_adic->fields['id_exa_adicional_periodo']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $upd_nota.'<br>';
									$db->Execute($upd_nota) or die($db->ErrorMsg());
									$out = array('result'=>'ok');
								}
							}
							
							if($nuevo_valor[$c]<$nota_aprobado)
							{
								$body = 'Estimado/a '.$rs_fam->fields['primer_apellido'].' '.$rs_fam->fields['segundo_apellido'].' '.$rs_fam->fields['primer_nombre'].' '.$rs_fam->fields['segundo_nombre'].':<br><br>';
								$body = $body.'Informamos a Ud. que su representado(a) '.$rs_est->fields['estudiante'].' ha obtenido la calificaci&oacute;n <b>'.$nuevo_valor[$c].' puntos</b>';
								$body = $body.' en la actividad: <b>'.$rs_s->fields['actividad_examen'].'</b>, con fecha: '.$rs_s->fields['fecha'];
								$body = $body.', correspondiente a: '.$rs_est->fields['referencia'].'.';
								$body = $body.'<br><br>Puede revisar las calificaciones en el sistema '.$titulo_sitio.' en la siguiente URL:';
								$body = $body.'<br><a href="'.$url.'">'.$url.'</a>';
								$body = $body.'<br><br>De requerir mayor informaci&oacute;n puede programar una cita con el docente de la asignatura ('.$docente.').';
								$body = $body.'<br><br>Este correo se ha generado autom&aacute;ticamente, cualquier duda o sugerencia escriba a: '.$mail_soporte;
								$body = $body.'<br><br>Saludos cordiales';
								$body = $body.'<br><b>'.$nombre_sucursal.'</b>';
								$body = utf8_decode($body);
								
								$host="smtp.gmail.com";
								$port=465;
								$sec="ssl";
								$from=$mail_sistema;
								$pass=$clave_mail;
								$name=$nombre_sucursal." - ".$titulo_sitio;
								$para="rojeda@atenas.edu.ec; ".$email;//$rs_fam->fields['email'];
								$asunto="Calificación baja del estudiante ".$rs_est->fields['estudiante'];
								$adjunto="";
								if($envio_calificacion_baja=='1')
								$clases->enviar_mail($mail, $host, $port, $sec, $from, $pass, $name, $para, $asunto, $body, $adjunto);
							}
						}
						else
						{
							$del_nota="DELETE FROM nota_exa_adicional_periodo WHERE id_exa_adicional_periodo='".$rs_p_adic->fields['id_exa_adicional_periodo']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $del_nota.'<br>';
							$db->Execute($del_nota) or die($db->ErrorMsg());
							$out = array('result'=>'ok');
						}
					}
				}
			$rs_p_adic->MoveNext();
			}
		$rs_est->MoveNext();
		}
	}
	elseif($tipo=='l_')
	{		
		$sql_p="SELECT id_periodo_evaluativo
		FROM n_periodo_evaluativo
		WHERE 1	AND n_periodo_evaluativo.id_periodo_lectivo='".$sel_filtro_cal."'";//print $sql_s;
		$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
		
		$sql_l="SELECT id_examen_periodo_lec, examen_lec, abv_tipo_examen_lec, peso
		FROM n_periodo_lectivo, n_conf_academica, n_examen_periodo_lec
		WHERE 1
		AND n_examen_periodo_lec.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_lectivo.id_periodo_lectivo='".$sel_filtro_cal."'
		AND n_examen_periodo_lec.id_asignatura='".$id_asignatura."'
		AND n_examen_periodo_lec.peso!='0'
		AND n_conf_academica.activa='1'";//print $sql_p;die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
		$rs_l=$db->Execute($sql_l) or die($db->ErrorMsg());
		
		$sql_l_adic="SELECT id_exa_adicional_lectivo, examen_adicional, abv_examen, tipo_examen, opcional
		FROM n_examen_adicional, n_tipo_examen, n_exa_adicional_lectivo, n_examen_periodo_lec, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_examen_adicional.id_examen_adicional=n_exa_adicional_lectivo.id_examen_adicional
		AND n_tipo_examen.id_tipo_examen=n_exa_adicional_lectivo.id_tipo_examen
		AND n_exa_adicional_lectivo.id_examen_periodo_lec=n_examen_periodo_lec.id_examen_periodo_lec
		AND n_examen_periodo_lec.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_lectivo.id_periodo_lectivo='".$sel_filtro_cal."'
		AND n_examen_periodo_lec.id_asignatura='".$id_asignatura."'
		AND n_conf_academica.activa='1' ORDER BY n_exa_adicional_lectivo.orden";//print $sql_p_adic;die();//, actividad.fecha
		$rs_l_adic=$db->Execute($sql_l_adic) or die($db->ErrorMsg());
		
		$ini_per=$inicial+$rs_p->RecordCount();
		$ini_per_lec=$inicial+$rs_p->RecordCount()+$rs_l->RecordCount();
		$ini_per_lec_adic=$inicial+$rs_p->RecordCount()+$rs_l->RecordCount()+$rs_l_adic->RecordCount();
		
		$rs_est->MoveFirst();		
		for($e=0;$e<$rs_est->RecordCount();$e++)
		{	
			$sql_fam="SELECT per_familiar.primer_apellido, per_familiar.segundo_apellido, per_familiar.primer_nombre, per_familiar.segundo_nombre, email, telefono1, telefono2, parentesco
			FROM familiar_estudiante, n_parentesco, familiar, persona AS per_familiar
			WHERE 1
			AND familiar_estudiante.id_familiar=familiar.id_familiar
			AND familiar_estudiante.id_parentesco=n_parentesco.id_parentesco
			AND per_familiar.id_persona=familiar.id_persona
			AND id_estudiante='".$rs_est->fields['id_estudiante']."'
			AND representante_aca='1'";//print $sql_est;
			$rs_fam=$db->Execute($sql_fam) or die($db->ErrorMsg());
			
			$rs_l->MoveFirst();
			for($l=$ini_per;$l<$ini_per_lec;$l++)
			{
				for($c=0;$c<$i;$c++)
				{//print '<br>fila: '.$fila[$c].'  col: '.$col[$c].'  nuevo_valor: '.$nuevo_valor[$c].'  c:'.$c.'  e:'.$e;
					//print '             e: '.$e.' fila:'.$fila[$c].' p:'.$p.' col:'.$col[$c+$inicial];
					if($e==$fila[$c] && $l==$col[$c+$inicial])
					{
						if($nuevo_valor[$c]!='')
						{
							//print $rs_l->fields['id_actividad'];die();
							$sql_nota="SELECT nota FROM nota_examen_periodo_lec WHERE id_examen_periodo_lec='".$rs_l->fields['id_examen_periodo_lec']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $sql_nota.'<br>';
							$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
							
							if($rs_nota->fields['nota']=='')
							{
								$ins_nota="INSERT INTO nota_examen_periodo_lec(nota, id_examen_periodo_lec, id_clase_estudiante) VALUES('".$nuevo_valor[$c]."','".$rs_l->fields['id_examen_periodo_lec']."','".$rs_est->fields['id_clase_estudiante']."')";//print $ins_nota.'<br>';
								$db->Execute($ins_nota) or die($db->ErrorMsg());
								$out = array('result'=>'ok');
							}
							else
							{	
								if($nuevo_valor[$c]!=$rs_nota->fields['nota'])
								{
									$upd_nota="UPDATE nota_examen_periodo_lec SET nota='".$nuevo_valor[$c]."' WHERE id_examen_periodo_lec='".$rs_l->fields['id_examen_periodo_lec']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $upd_nota.'<br>';
									$db->Execute($upd_nota) or die($db->ErrorMsg());
									$out = array('result'=>'ok');
								}
							}
							
							if($nuevo_valor[$c]<$nota_aprobado)
							{
								$body = 'Estimado/a '.$rs_fam->fields['primer_apellido'].' '.$rs_fam->fields['segundo_apellido'].' '.$rs_fam->fields['primer_nombre'].' '.$rs_fam->fields['segundo_nombre'].':<br><br>';
								$body = $body.'Informamos a Ud. que su representado(a) '.$rs_est->fields['estudiante'].' ha obtenido la calificaci&oacute;n <b>'.$nuevo_valor[$c].' puntos</b>';
								$body = $body.' en la actividad: <b>'.$rs_s->fields['actividad_examen'].'</b>, con fecha: '.$rs_s->fields['fecha'];
								$body = $body.', correspondiente a: '.$rs_est->fields['referencia'].'.';
								$body = $body.'<br><br>Puede revisar las calificaciones en el sistema '.$titulo_sitio.' en la siguiente URL:';
								$body = $body.'<br><a href="'.$url.'">'.$url.'</a>';
								$body = $body.'<br><br>De requerir mayor informaci&oacute;n puede programar una cita con el docente de la asignatura ('.$docente.').';
								$body = $body.'<br><br>Este correo se ha generado autom&aacute;ticamente, cualquier duda o sugerencia escriba a: '.$mail_soporte;
								$body = $body.'<br><br>Saludos cordiales';
								$body = $body.'<br><b>'.$nombre_sucursal.'</b>';
								$body = utf8_decode($body);
								
								$host="smtp.gmail.com";
								$port=465;
								$sec="ssl";
								$from=$mail_sistema;
								$pass=$clave_mail;
								$name=$nombre_sucursal." - ".$titulo_sitio;
								$para="rojeda@atenas.edu.ec; ".$email;//$rs_fam->fields['email'];
								$asunto="Calificación baja del estudiante ".$rs_est->fields['estudiante'];
								$adjunto="";
								if($envio_calificacion_baja=='1')
								$clases->enviar_mail($mail, $host, $port, $sec, $from, $pass, $name, $para, $asunto, $body, $adjunto);
							}
						}
						else
						{
							$del_nota="DELETE FROM nota_examen_periodo_lec WHERE id_examen_periodo_lec='".$rs_l->fields['id_examen_periodo_lec']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $del_nota.'<br>';
							$db->Execute($del_nota) or die($db->ErrorMsg());
							$out = array('result'=>'ok');
						}
					}
				}
			$rs_l->MoveNext();
			}

			$rs_l_adic->MoveFirst();
			for($d=$ini_per_lec;$d<$ini_per_lec_adic;$d++)
			{
				for($c=0;$c<$i;$c++)
				{//print '<br>fila: '.$fila[$c].'  col: '.$col[$c].'  nuevo_valor: '.$nuevo_valor[$c].'  c:'.$c.'  e:'.$e;
					//print '             e: '.$e.' fila:'.$fila[$c].' d:'.$d.' col:'.$col[$c+$inicial];
					if($e==$fila[$c] && $d==$col[$c+$inicial])
					{
						if($nuevo_valor[$c]!='')
						{
							//print $rs_p->fields['id_actividad'];die();
							$sql_nota="SELECT nota FROM nota_exa_adicional_lectivo WHERE id_exa_adicional_lectivo='".$rs_l_adic->fields['id_exa_adicional_lectivo']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $sql_nota.'<br>';
							$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
							
							if($rs_nota->fields['nota']=='')
							{
								$ins_nota="INSERT INTO nota_exa_adicional_lectivo(nota, id_exa_adicional_lectivo, id_clase_estudiante) VALUES('".$nuevo_valor[$c]."','".$rs_l_adic->fields['id_exa_adicional_lectivo']."','".$rs_est->fields['id_clase_estudiante']."')";//print $ins_nota.'<br>';
								$db->Execute($ins_nota) or die($db->ErrorMsg());
								$out = array('result'=>'ok');
							}
							else
							{	
								if($nuevo_valor[$c]!=$rs_nota->fields['nota'])
								{
									$upd_nota="UPDATE nota_exa_adicional_lectivo SET nota='".$nuevo_valor[$c]."' WHERE id_exa_adicional_lectivo='".$rs_l_adic->fields['id_exa_adicional_lectivo']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $upd_nota.'<br>';
									$db->Execute($upd_nota) or die($db->ErrorMsg());
									$out = array('result'=>'ok');
								}
							}
							
							if($nuevo_valor[$c]<$nota_aprobado)
							{
								$body = 'Estimado/a '.$rs_fam->fields['primer_apellido'].' '.$rs_fam->fields['segundo_apellido'].' '.$rs_fam->fields['primer_nombre'].' '.$rs_fam->fields['segundo_nombre'].':<br><br>';
								$body = $body.'Informamos a Ud. que su representado(a) '.$rs_est->fields['estudiante'].' ha obtenido la calificaci&oacute;n <b>'.$nuevo_valor[$c].' puntos</b>';
								$body = $body.' en la actividad: <b>'.$rs_l->fields['examen_adicional'].'</b>';
								$body = $body.', correspondiente a: '.$rs_est->fields['referencia'].'.';
								$body = $body.'<br><br>Puede revisar las calificaciones en el sistema '.$titulo_sitio.' en la siguiente URL:';
								$body = $body.'<br><a href="'.$url.'">'.$url.'</a>';
								$body = $body.'<br><br>De requerir mayor informaci&oacute;n puede programar una cita con el docente de la asignatura ('.$docente.').';
								$body = $body.'<br><br>Este correo se ha generado autom&aacute;ticamente, cualquier duda o sugerencia escriba a: '.$mail_soporte;
								$body = $body.'<br><br>Saludos cordiales';
								$body = $body.'<br><b>'.$nombre_sucursal.'</b>';
								$body = utf8_decode($body);
								
								$host="smtp.gmail.com";
								$port=465;
								$sec="ssl";
								$from=$mail_sistema;
								$pass=$clave_mail;
								$name=$nombre_sucursal." - ".$titulo_sitio;
								$para="rojeda@atenas.edu.ec; ".$email;//$rs_fam->fields['email'];
								$asunto="Calificación baja del estudiante ".$rs_est->fields['estudiante'];
								$adjunto="";
								if($envio_calificacion_baja=='1')
								$clases->enviar_mail($mail, $host, $port, $sec, $from, $pass, $name, $para, $asunto, $body, $adjunto);
							}
						}
						else
						{
							$del_nota="DELETE FROM nota_exa_adicional_lectivo WHERE id_exa_adicional_lectivo='".$rs_l_adic->fields['id_exa_adicional_lectivo']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";print $del_nota.'<br>';
							$db->Execute($del_nota) or die($db->ErrorMsg());
							$out = array('result'=>'ok');
						}
					}
				}
			$rs_l_adic->MoveNext();
			}
		$rs_est->MoveNext();
		}
	}
	
	
//	$out = $out.array('grid'=>$actualizar_grid);

echo json_encode($out);
}
?>