<?php
class clases_menu_notificaciones
{
	function menu_mod($rs_sesion,$db)
	{
		$not=0;
		$msg=0;
		$warning=array();
		
		
		$mod="rrhh";		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="ingreso_salida";
		$id_elemento="id_empleado";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		$link="https://'+dir+site+'/pag/".$mod."/".$elemento."/new_".$elemento.".php";
		
		$sql1="SELECT ".$id_elemento.",primer_nombre,primer_apellido FROM empleado,persona WHERE 1 AND empleado.id_persona=persona.id_persona AND NOT EXISTS (SELECT 1 FROM ".$elemento." WHERE ".$elemento.".".$id_elemento." = empleado.".$id_elemento.")";//print $sql1;
		$rs1=$db->Execute($sql1) or print $db->ErrorMsg();
		
		if(isset($rs1->fields[0]))	
		{
			while(!$rs1->EOF)
			{
				$texto="Al empleado: ".$rs1->fields["primer_nombre"]." ".$rs1->fields["primer_apellido"]." no se le ha dado ingreso a&uacute;n.";
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs1->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="cargo_empleado";
		$id_elemento="id_empleado";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		$link="https://'+dir+site+'/pag/".$mod."/".$elemento."/new_".$elemento.".php";
		
		$sql2="SELECT ".$id_elemento.",primer_nombre,primer_apellido FROM empleado,persona WHERE 1 AND empleado.id_persona=persona.id_persona AND NOT EXISTS (SELECT 1 FROM ".$elemento." WHERE ".$elemento.".".$id_elemento." = empleado.".$id_elemento.")";//print $sql1;
		$rs2=$db->Execute($sql2) or print $db->ErrorMsg();
		
		if(isset($rs2->fields[0]))	
		{
			while(!$rs2->EOF)
			{
				$texto="Al empleado: ".$rs2->fields["primer_nombre"]." ".$rs2->fields["primer_apellido"]." no se le ha asignado un cargo a&uacute;n.";
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs2->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		/*$elemento="reemplazo";
		$id_elemento="id_empleado";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		$link="https://'+dir+site+'/pag/".$mod."/".$elemento."/new_".$elemento.".php";
		
		$sql3="SELECT ".$id_elemento.",primer_nombre,primer_apellido FROM empleado,persona WHERE 1 AND empleado.id_persona=persona.id_persona AND NOT EXISTS (SELECT 1 FROM ".$elemento." WHERE ".$elemento.".".$id_elemento." = empleado.".$id_elemento.")";//print $sql1;
		$rs3=$db->Execute($sql3) or print $db->ErrorMsg();
		
		if(isset($rs3->fields[0]))	
		{
			while(!$rs3->EOF)
			{
				$texto="Al empleado: ".$rs3->fields["primer_nombre"]." ".$rs3->fields["primer_apellido"]." no se le ha asignado un reemplazo a&uacute;n.";
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs3->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}*/
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="autoriza";
		$id_elemento="id_cargo";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		$link="https://'+dir+site+'/pag/".$mod."/".$elemento."/new_".$elemento.".php";
		
		$sql4="SELECT ".$id_elemento.",cargo FROM n_cargo WHERE 1 AND NOT EXISTS (SELECT 1 FROM ".$elemento." WHERE ".$elemento.".".$id_elemento." = n_cargo.".$id_elemento.")";//print $sql1;
		$rs4=$db->Execute($sql4) or print $db->ErrorMsg();
		
		if(isset($rs4->fields[0]))	
		{
			while(!$rs4->EOF)
			{
				$texto="Al cargo: ".$rs4->fields["cargo"]." no se le ha asignado un cargo que da autorizaciones a&uacute;n.";
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs4->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="cargo_comp";
		$id_elemento="id_cargo";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		$link="https://'+dir+site+'/pag/".$mod."/".$elemento."/new_".$elemento.".php";
		
		$sql5="SELECT ".$id_elemento.",cargo FROM n_cargo WHERE 1 AND NOT EXISTS (SELECT 1 FROM ".$elemento." WHERE ".$elemento.".".$id_elemento." = n_cargo.".$id_elemento.")";//print $sql1;
		$rs5=$db->Execute($sql5) or print $db->ErrorMsg();
		
		if(isset($rs5->fields[0]))	
		{
			while(!$rs5->EOF)
			{
				$texto="Al cargo: ".$rs5->fields["cargo"]." no se le ha asignado competencias a&uacute;n.";
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs5->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="desempeno";
		$id_elemento="id_cargo";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		$link="https://'+dir+site+'/pag/".$mod."/".$elemento."/new_".$elemento.".php";
		
		$sql_ev="SELECT DISTINCT empleado.id_empleado, n_cargo.id_cargo FROM persona,empleado,cargo_empleado,n_cargo,usuario,ingreso_salida	WHERE persona.id_persona=empleado.id_persona 
		AND persona.id_persona=usuario.id_persona AND empleado.id_empleado=cargo_empleado.id_empleado AND cargo_empleado.id_cargo=n_cargo.id_cargo 
		AND empleado.id_empleado=ingreso_salida.id_empleado AND baja='0' AND usuario='".$_SESSION["user"]."'AND fecha_cargo=
		(SELECT MAX(fecha_cargo) FROM persona,empleado,cargo_empleado,n_cargo,usuario,ingreso_salida WHERE persona.id_persona=empleado.id_persona 
		AND persona.id_persona=usuario.id_persona AND empleado.id_empleado=cargo_empleado.id_empleado AND cargo_empleado.id_cargo=n_cargo.id_cargo 
		AND empleado.id_empleado=ingreso_salida.id_empleado AND baja='0' AND usuario='".$_SESSION["user"]."')";
		//print $sql_ev;die();
		$rs_ev=$db->Execute($sql_ev) or die($db->ErrorMsg());
		
		$hoy=date("Y-m-d");
		$sql8="SELECT DISTINCT empleado.id_empleado, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as empleado 
		FROM persona,empleado,ingreso_salida,cargo_empleado
		WHERE persona.id_persona=empleado.id_persona AND empleado.id_empleado=ingreso_salida.id_empleado AND baja='0' AND cargo_empleado.id_empleado=empleado.id_empleado AND cargo_empleado.activo='1'
		AND id_cargo_jefe='".$rs_ev->fields['id_cargo']."' AND cargo_empleado.id_cargo!='".$rs_ev->fields['id_cargo']."'  
		AND NOT EXISTS 
		(SELECT 1 FROM desempeno,n_periodo WHERE desempeno.id_empleado = empleado.id_empleado 
		AND desempeno.id_periodo = n_periodo.id_periodo AND fecha_conclusion>='".$hoy."') 
		AND EXISTS 
		(SELECT 1 FROM n_periodo WHERE fecha_conclusion>='".$hoy."')
		ORDER BY primer_apellido,segundo_apellido,primer_nombre,segundo_nombre DESC";//print $sql1;
		$rs8=$db->Execute($sql8) or print $db->ErrorMsg();
		
		if(isset($rs8->fields[0]))	
		{
			while(!$rs8->EOF)
			{
				$texto="Al empleado: ".$rs8->fields["empleado"]." no se le ha hecho su evaluaci&oacute;n de desempe&ntilde;o a&uacute;n.";
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs8->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="r_desempeno";
		$id_elemento="id_cargo";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){
		$link=null;		
		
		$hoy=date("Y-m-d");
		//$hoy="2015-06-01";
		$sql8="SELECT DISTINCT empleado.id_empleado, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as empleado 
		FROM persona,empleado,ingreso_salida,cargo_empleado
		WHERE persona.id_persona=empleado.id_persona AND empleado.id_empleado=ingreso_salida.id_empleado AND baja='0' AND cargo_empleado.id_empleado=empleado.id_empleado AND cargo_empleado.activo='1'
		AND id_cargo_jefe!=cargo_empleado.id_cargo AND NOT EXISTS 
		(SELECT 1 FROM desempeno,n_periodo WHERE desempeno.id_empleado = empleado.id_empleado AND desempeno.id_periodo = n_periodo.id_periodo AND fecha_conclusion>='".$hoy."') 
		AND EXISTS 
		(SELECT 1 FROM n_periodo WHERE fecha_conclusion>='".$hoy."') 
		ORDER BY primer_apellido,segundo_apellido,primer_nombre,segundo_nombre DESC";//print $sql8;
		$rs8=$db->Execute($sql8) or print $db->ErrorMsg();
		
		if(isset($rs8->fields[0]))	
		{
			while(!$rs8->EOF)
			{
				$texto="Al empleado: ".$rs8->fields["empleado"]." no se le ha hecho su evaluaci&oacute;n de desempe&ntilde;o a&uacute;n.";
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs8->MoveNext();
			}
		}
				
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="r_desempeno";
		$id_elemento="id_cargo";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Visualizar' AND $rs_sesion->fields['elemento']==$elemento){
		$link=null;		
		
		$hoy=date("Y-m-d");
		
		$sql="SELECT id_periodo, fecha_ini, fecha_fin, fecha_conclusion FROM n_periodo WHERE fecha_conclusion<'".$hoy."' AND id_periodo=(SELECT MAX(id_periodo) FROM n_periodo)";
		$rs=$db->Execute($sql) or print $db->ErrorMsg();
		
		if(isset($rs))
		{
			$fecha = $rs->fields["fecha_conclusion"];
			$nuevafecha = strtotime ('+30 day',strtotime ( $fecha ) ) ;
			$nuevafecha = date ('Y-m-d',$nuevafecha);

			if($nuevafecha>=$hoy)
			{
				if($rs->fields["fecha_ini"]!='')
				{
					$sql20="SELECT DISTINCT empleado.id_empleado,  concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) as empleado 
					FROM persona,empleado,ingreso_salida,cargo_empleado
					WHERE persona.id_persona=empleado.id_persona AND empleado.id_empleado=ingreso_salida.id_empleado AND baja='0' 
					AND cargo_empleado.id_empleado=empleado.id_empleado AND cargo_empleado.activo='1'
					AND id_cargo_jefe!=cargo_empleado.id_cargo 
					AND NOT EXISTS 
					(SELECT 1 FROM desempeno,n_periodo WHERE desempeno.id_empleado = empleado.id_empleado 
					AND desempeno.id_periodo = n_periodo.id_periodo AND n_periodo.id_periodo=
					(SELECT id_periodo FROM n_periodo WHERE fecha_conclusion<'".$hoy."' AND id_periodo=(SELECT MAX(id_periodo) FROM n_periodo)))
					ORDER BY primer_apellido,segundo_apellido,primer_nombre,segundo_nombre DESC";//print $sql20;
					$rs20=$db->Execute($sql20) or print $db->ErrorMsg();
					
					
					
					if(isset($rs20->fields[0]))	
					{
						while(!$rs20->EOF)
						{
							$texto="Al empleado: ".$rs20->fields["empleado"]." no se le ha hecho su evaluaci&oacute;n de desempe&ntilde;o en el per&iacute;odo ".$rs->fields["fecha_ini"]."/".$rs->fields["fecha_fin"].".";
							$warning[$not]=array('texto'=>$texto,'link'=>$link);
							$not=$not+1;
						$rs20->MoveNext();
						}
					}
				}
			}
		}
				
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		$mod="conf";		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="usuario";
		$id_elemento="id_persona";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		$link="https://'+dir+site+'/seguridad/".$elemento."/new_".$elemento.".php";
		
		$sql6="SELECT persona.".$id_elemento.",primer_nombre, segundo_nombre, primer_apellido,segundo_apellido FROM persona, empleado WHERE 1 AND empleado.baja='0' AND empleado.id_persona=persona.id_persona AND NOT EXISTS (SELECT 1 FROM ".$elemento." WHERE ".$elemento.".".$id_elemento." = persona.".$id_elemento.")";//print $sql6;
		$rs6=$db->Execute($sql6) or print $db->ErrorMsg();
		
		if(isset($rs6->fields[0]))	
		{
			while(!$rs6->EOF)
			{
				$texto="Al empleado: ".$rs6->fields["primer_apellido"].' '.$rs6->fields["segundo_apellido"]." ".$rs6->fields["primer_nombre"]." ".$rs6->fields["segundo_nombre"]." no se le ha asignado un usuario y clave a&uacute;n.";
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs6->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="usuario";
		$id_elemento="id_persona";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		$link="https://'+dir+site+'/seguridad/".$elemento."/new_".$elemento.".php";
		
		$sql13="SELECT persona.".$id_elemento.",primer_nombre, segundo_nombre, primer_apellido,segundo_apellido FROM persona, familiar WHERE 1 AND familiar.id_persona=persona.id_persona AND NOT EXISTS (SELECT 1 FROM ".$elemento." WHERE ".$elemento.".".$id_elemento." = persona.".$id_elemento.")";//print $sql13;
		$rs13=$db->Execute($sql13) or print $db->ErrorMsg();
		
		if(isset($rs13->fields[0]))	
		{
			while(!$rs13->EOF)
			{
				$texto="Al familiar: ".$rs13->fields["primer_apellido"].' '.$rs13->fields["segundo_apellido"]." ".$rs13->fields["primer_nombre"]." ".$rs13->fields["segundo_nombre"]." no se le ha asignado un usuario y clave a&uacute;n.";
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs13->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="usuario";
		$id_elemento="id_persona";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		$link="https://'+dir+site+'/seguridad/".$elemento."/new_".$elemento.".php";
		
		$sql14="SELECT persona.".$id_elemento.",primer_nombre,segundo_nombre,primer_apellido,segundo_apellido FROM persona, estudiante, curso_grado_paralelo_est
		WHERE 1 AND estudiante.id_persona=persona.id_persona AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante AND NOT EXISTS (SELECT 1 FROM ".$elemento." WHERE ".$elemento.".".$id_elemento." = persona.".$id_elemento.")";//print $sql14;
		$rs14=$db->Execute($sql14) or print $db->ErrorMsg();
		
		if(isset($rs14->fields[0]))	
		{
			while(!$rs14->EOF)
			{
				$texto="Al estudiante: ".$rs14->fields["primer_apellido"].' '.$rs14->fields["segundo_apellido"]." ".$rs14->fields["primer_nombre"]." ".$rs14->fields["segundo_nombre"]." no se le ha asignado un usuario y clave a&uacute;n.";
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs14->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="usuario_rol";
		$id_elemento="id_usuario";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		$link="https://'+dir+site+'/seguridad/".$elemento."/new_".$elemento.".php";
		
		$sql7="SELECT usuario.".$id_elemento.",primer_nombre,segundo_nombre,primer_apellido,segundo_apellido FROM usuario, persona WHERE 1 AND usuario.id_persona=persona.id_persona AND NOT EXISTS (SELECT 1 FROM ".$elemento." WHERE ".$elemento.".".$id_elemento." = usuario.".$id_elemento.")";//print $sql7;
		$rs7=$db->Execute($sql7) or print $db->ErrorMsg();
		
		if(isset($rs7->fields[0]))	
		{
			while(!$rs7->EOF)
			{
				$texto="Al usuario: ".$rs7->fields["primer_apellido"].' '.$rs7->fields["segundo_apellido"]." ".$rs7->fields["primer_nombre"]." ".$rs7->fields["segundo_nombre"]." no se le ha asignado rol a&uacute;n.";
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs7->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		$mod="cont";		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="punto_venta_usuario";
		$id_elemento="id_punto_venta";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		$link="https://'+dir+site+'/pag/".$mod."/".$elemento."/new_".$elemento.".php";
		
		$sql9="SELECT ".$id_elemento.", punto_venta FROM n_punto_venta WHERE 1 AND NOT EXISTS (SELECT 1 FROM ".$elemento." WHERE ".$elemento.".".$id_elemento." = n_punto_venta.".$id_elemento.")";//print $sql1;
		$rs9=$db->Execute($sql9) or print $db->ErrorMsg();
		
		if(isset($rs9->fields[0]))	
		{
			while(!$rs9->EOF)
			{
				$texto="Al punto de venta: ".$rs9->fields["punto_venta"]." no se le ha asignado un vendedor a&uacute;n.";
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs9->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="factura";
		$id_elemento="id_punto_venta";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		$link="https://'+dir+site+'/pag/".$mod."/".$elemento."/new_".$elemento.".php";
		
		$sql10="SELECT n_punto_venta.".$id_elemento.", punto_venta FROM n_punto_venta WHERE 1 AND NOT EXISTS (SELECT 1 FROM n_factura WHERE estado='1' AND n_factura.".$id_elemento." = n_punto_venta.".$id_elemento.")";//print "ddd".$sql10;
		$rs10=$db->Execute($sql10) or print $db->ErrorMsg();
		
		if(isset($rs10->fields[0]))	
		{
			while(!$rs10->EOF)
			{
				$texto="Al punto de venta: ".$rs10->fields["punto_venta"]." no se le ha asignado un facturero a&uacute;n.";
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs10->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="cliente_forma_pago";
		$id_elemento="id_cliente";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		$link="https://'+dir+site+'/pag/".$mod."/".$elemento."/new_".$elemento.".php";
		
		$sql12="SELECT cliente.".$id_elemento.", concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre) AS cliente FROM cliente, persona, empleado WHERE 1 AND persona.id_persona=empleado.id_persona AND baja='0' AND cliente.id_persona=persona.id_persona AND NOT EXISTS (SELECT 1 FROM cliente_forma_pago WHERE cliente_forma_pago.".$id_elemento." = cliente.".$id_elemento.")";//print "ddd".$sql12;
		$rs12=$db->Execute($sql12) or print $db->ErrorMsg();
		
		if(isset($rs12->fields[0]))	
		{
			while(!$rs12->EOF)
			{
				$texto="Al empleado: ".$rs12->fields["cliente"].utf8_encode(" no se le ha asignado una forma de pago a&uacute;n en ningún punto de venta.");
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs12->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="persona";
		$id_elemento="id_persona";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		$link="https://'+dir+site+'/pag/".$mod."/".$elemento."/new_".$elemento.".php";
		
		$sql15="SELECT persona.id_persona, concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' - ',identificacion) AS estudiante FROM persona, familiar, familiar_estudiante, estudiante, curso_grado_paralelo_est
		WHERE 1 AND persona.id_persona=estudiante.id_persona AND familiar_estudiante.id_estudiante=estudiante.id_estudiante AND familiar.id_familiar=familiar_estudiante.id_familiar AND representante_eco='1' AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante AND NOT EXISTS (SELECT 1 FROM cliente WHERE cliente.id_persona = persona.id_persona)";//print "ddd".$sql15;
		$rs15=$db->Execute($sql15) or print $db->ErrorMsg();
		
		if(isset($rs15->fields[0]))	
		{
			while(!$rs15->EOF)
			{
				$texto="El representante econ&oacute;mico del estudiante: ".$rs15->fields["estudiante"]." no es cliente a&uacute;n.";
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs15->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		$mod="acad";		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="familiar_estudiante";
		$id_elemento="id_familiar";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']=='estudiante'){
		$link="https://'+dir+site+'/pag/".$mod."/estudiante/new_estudiante.php";
		
		$sql11="SELECT familiar.".$id_elemento.", primer_nombre, primer_apellido FROM familiar, persona WHERE 1 AND familiar.id_persona=persona.id_persona AND NOT EXISTS (SELECT 1 FROM ".$elemento." WHERE ".$elemento.".".$id_elemento." = familiar.".$id_elemento.")";//print $sql11;
		$rs11=$db->Execute($sql11) or print $db->ErrorMsg();
		
		if(isset($rs11->fields[0]))	
		{
			while(!$rs11->EOF)
			{
				$texto="Al familiar: ".$rs11->fields["primer_nombre"]." ".$rs11->fields["primer_apellido"]." no se le ha asignado un estudiante a&uacute;n";
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs11->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="estudiante";
		$id_elemento="id_estudiante";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		
		$sql16="SELECT ".$elemento.".".$id_elemento.", concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre) AS est FROM ".$elemento.", persona, curso_grado_paralelo_est 
		WHERE 1 AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante AND ".$elemento.".id_persona=persona.id_persona AND NOT EXISTS (SELECT 1 FROM familiar_estudiante WHERE ".$elemento.".".$id_elemento." = familiar_estudiante.".$id_elemento.")";//print $sql16;
		$rs16=$db->Execute($sql16) or print $db->ErrorMsg();
		
		if(isset($rs16->fields[0]))	
		{
			while(!$rs16->EOF)
			{
				$texto="Al estudiante: ".$rs16->fields["est"]." no se le ha asignado un familiar a&uacute;n";
				$link="https://'+dir+site+'/pag/".$mod."/estudiante/mod_estudiante.php?mod=".$rs16->fields[$id_elemento];
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs16->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="estudiante";
		$id_elemento="id_estudiante";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		
		$sql17="SELECT ".$elemento.".".$id_elemento.", concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre) AS est FROM ".$elemento.", persona, curso_grado_paralelo_est
		WHERE 1 AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante AND ".$elemento.".id_persona=persona.id_persona AND NOT EXISTS (SELECT 1 FROM familiar_estudiante WHERE representante_eco='1' AND ".$elemento.".".$id_elemento." = familiar_estudiante.".$id_elemento.")";//print $sql17;
		$rs17=$db->Execute($sql17) or print $db->ErrorMsg();
		
		if(isset($rs17->fields[0]))	
		{
			while(!$rs17->EOF)
			{
				$texto="Al estudiante: ".$rs17->fields["est"]." no se le ha asignado un representante econ&oacute;mico a&uacute;n";
				$link="https://'+dir+site+'/pag/".$mod."/estudiante/mod_estudiante.php?mod=".$rs17->fields[$id_elemento];
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs17->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="estudiante";
		$id_elemento="id_estudiante";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		
		$sql18="SELECT ".$elemento.".".$id_elemento.", concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre) AS est FROM ".$elemento.", persona, curso_grado_paralelo_est
		WHERE 1 AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante  AND ".$elemento.".id_persona=persona.id_persona AND NOT EXISTS (SELECT 1 FROM familiar_estudiante WHERE representante_legal='1' AND ".$elemento.".".$id_elemento." = familiar_estudiante.".$id_elemento.")";//print $sql18;
		$rs18=$db->Execute($sql18) or print $db->ErrorMsg();
		
		if(isset($rs18->fields[0]))	
		{
			while(!$rs18->EOF)
			{
				$texto="Al estudiante: ".$rs18->fields["est"]." no se le ha asignado un representante legal a&uacute;n";
				$link="https://'+dir+site+'/pag/".$mod."/estudiante/mod_estudiante.php?mod=".$rs18->fields[$id_elemento];
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs18->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="estudiante";
		$id_elemento="id_estudiante";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		
		$sql19="SELECT ".$elemento.".".$id_elemento.", concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre) AS est FROM ".$elemento.", persona, curso_grado_paralelo_est 
		WHERE 1 AND codigo_matricula!='' AND fecha_retiro='0000-00-00' AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante  AND ".$elemento.".id_persona=persona.id_persona AND NOT EXISTS (SELECT 1 FROM familiar_estudiante WHERE representante_aca='1' AND ".$elemento.".".$id_elemento." = familiar_estudiante.".$id_elemento.")";//print $sql19;
		$rs19=$db->Execute($sql19) or print $db->ErrorMsg();
		
		if(isset($rs19->fields[0]))	
		{
			while(!$rs19->EOF)
			{
				$texto="Al estudiante: ".$rs19->fields["est"]." no se le ha asignado un representante acad&eacute;mico a&uacute;n";
				$link="https://'+dir+site+'/pag/".$mod."/estudiante/mod_estudiante.php?mod=".$rs19->fields[$id_elemento];
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs19->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		
		$mod="bibl";
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$elemento="prestamo";
		$id_elemento="id_prestamo";
		$rs_sesion->MoveFirst();for($m=0;$m<$rs_sesion->RecordCount();$m++){if($rs_sesion->fields['accion']=='Insertar' AND $rs_sesion->fields['elemento']==$elemento){
		
		$hoy=date("Y-m-d");
		
		$sql21="SELECT ".$elemento.".".$id_elemento.", concat(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre) AS per, concat(no_ficha,' - ', titulo) AS libro
		FROM ".$elemento.", persona, libro
		WHERE 1 AND prestado='1' AND ".$elemento.".id_persona=persona.id_persona AND ".$elemento.".id_libro=libro.id_libro AND fecha_dev<'".$hoy."' AND fecha_dev_real='0000-00-00' ORDER BY primer_apellido";//print $sql21;
		$rs21=$db->Execute($sql21) or print $db->ErrorMsg();
		
		if(isset($rs21->fields[0]))	
		{
			while(!$rs21->EOF)
			{
				$texto="La persona: ".$rs21->fields["per"]." debe devolver el libro ".$rs21->fields['libro'];
				$link="https://'+dir+site+'/pag/".$mod."/estudiante/mod_estudiante.php?mod=".$rs21->fields[$id_elemento];
				$warning[$not]=array('texto'=>$texto,'link'=>$link);
				$not=$not+1;
			$rs21->MoveNext();
			}
		}
		break;}$rs_sesion->MoveNext();}
		//------------------------------------------------------------------------------------------------------------------------------------------------------
			
		//------------------------------------------------------------------------------------------------------------------------------------------------------		
		$sql_msg="select persona.id_persona from persona, usuario, recibidos 
		WHERE 1 AND persona.id_persona=usuario.id_persona AND persona.id_persona=recibidos.id_persona_destinatario AND usuario.activo='1' 
		AND email!='' AND recibidos.leido='0' AND recibidos.archivado_dest='0' AND usuario.usuario='".$_SESSION['user']."'";//print $sql19;
		$rs_msg=$db->Execute($sql_msg) or print $db->ErrorMsg();		
		//------------------------------------------------------------------------------------------------------------------------------------------------------
	
				
		if(sizeof($warning)==1){$notif='Notificaci&oacute;n';$aviso='Aviso de configuraci&oacute;n';}else {$notif='Notificaciones';$aviso='Avisos de configuraci&oacute;n';}
		if($rs_msg->RecordCount()==1){$mensaje='Mensaje sin leer';}else {$mensaje='Mensajes sin leer';}
		$link_msg="https://'+dir+site+'/pag/comu/notificacion/lis_notificacion.php";
		?>	
		['<div class="bola_notificacion"><?php print sizeof($warning)+$rs_msg->RecordCount();?></div>','<?php print $notif;?>',null,null,'<?php print $notif;?>',
		
			['<div class="bola_warning_msg bola_warning"><?php print sizeof($warning);?></div>','<?php print $aviso;?>',null,null,null,
		<?php if(isset($warning)){for($n=0;$n<sizeof($warning);$n++){?>			
				['<img src="https://'+dir+site+img+'/warning.png" />','<?php print $warning[$n]['texto'];?>','<?php print $warning[$n]['link'];?>',null,null],
				_cmSplit,
		<?php }}?>
			],
			
			['<div class="bola_warning_msg bola_msg"><?php print $rs_msg->RecordCount();?></div>','<?php print $mensaje;?>','<?php print $link_msg;?>',null,null],
		],
		
		<?php
	} // fin de la funcion
} // fin de la clase
?>