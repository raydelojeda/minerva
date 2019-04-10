<?php
class clases_acad
{
	function consulta_nota_comportamental($db, $id_estudiante)
	{		
		$sql_est="SELECT curso_grado_paralelo_est.id_curso_grado_paralelo_est FROM curso_grado_paralelo_est, grado_paralelo_periodo, n_periodo_academico
		WHERE grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico AND activo='1'
		AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
		AND id_estudiante='".$id_estudiante."'";//print $sql_asig.'<br>';
		$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
		
		$id_curso_grado_paralelo_est=$rs_est->fields['id_curso_grado_paralelo_est'];
		
		$sql_l="SELECT id_periodo_lectivo, periodo_lectivo
		FROM n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica		
		AND n_conf_academica.activa='1'";//print $sql_p;die();
		$rs_l=$db->Execute($sql_l) or die($db->ErrorMsg());
		
		//-----------INSPECTOR------------
		$rs_l->MoveFirst();$cant=0;
		for($l=0;$l<$rs_l->RecordCount();$l++)
		{
			$id_periodo_lectivo=$rs_l->fields['id_periodo_lectivo'];
			$nota[$l]=$this->consulta_nota_comportamental_lec_inspector($db, $id_curso_grado_paralelo_est, $id_periodo_lectivo);
			if($nota[$l]!='')$cant=$cant+1;
			
		$rs_l->MoveNext();
		}
		
		if($cant!=0)$nota_gen_insp=bcdiv(array_sum($nota), $cant, 10);else $nota_gen_insp=0;
		//-----------INSPECTOR------------
		
		//-----------TUTOR------------
		$rs_l->MoveFirst();$cant=0;
		for($l=0;$l<$rs_l->RecordCount();$l++)
		{
			$id_periodo_lectivo=$rs_l->fields['id_periodo_lectivo'];
			$nota[$l]=$this->consulta_nota_comportamental_lec_tutor($db, $id_curso_grado_paralelo_est, $id_periodo_lectivo);
			if($nota[$l]!='')$cant=$cant+1;
			
		$rs_l->MoveNext();
		}
		
		if($cant!=0)$nota_gen_tut=bcdiv(array_sum($nota), $cant, 10);else $nota_gen_tut=0;
		//-----------TUTOR------------
		
		//-----------DOCENTES------------
		$rs_l->MoveFirst();$cant=0;
		for($l=0;$l<$rs_l->RecordCount();$l++)
		{
			$id_periodo_lectivo=$rs_l->fields['id_periodo_lectivo'];
			$nota[$l]=$this->consulta_nota_comportamental_lectivo($db, $id_curso_grado_paralelo_est, $id_periodo_lectivo);//print $l.'- '.$nota[$l].'<br>';
			if($nota[$l]!='')$cant=$cant+1;//print $cant;
			
		$rs_l->MoveNext();
		}
		
		if($cant!=0)$nota_gen_doc=bcdiv(array_sum($nota), $cant, 10);else $nota_gen_doc=0;//print $nota_gen_doc;
		//-----------DOCENTES------------
		
		$sql_conf_comp="SELECT peso_clases, peso_inspector, peso_tutor FROM n_conf_conductual WHERE activa='1' ORDER BY id_conf_conductual DESC";//print $sql_asig.'<br>';
		$rs_conf_comp=$db->Execute($sql_conf_comp) or die($db->ErrorMsg());
		
		$peso_clases=$rs_conf_comp->fields['peso_clases'];if($peso_clases=='')$peso_clases=0;//print $peso_clases;
		$peso_inspector=$rs_conf_comp->fields['peso_inspector'];if($peso_inspector=='')$peso_inspector=0;
		$peso_tutor=$rs_conf_comp->fields['peso_tutor'];if($peso_tutor=='')$peso_tutor=0;
		
		$nota_gen=$this->comportamental_ponderado_aritmetico($peso_clases, $peso_inspector, $peso_tutor, $nota_gen_doc, $nota_gen_insp, $nota_gen_tut);//print $nota_gen;

		return $nota_gen;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//-----------------------------------------------------------------COMPORTAMIENTO---------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_nota_comportamental_lec_inspector($db, $id_curso_grado_paralelo_est, $id_periodo_lectivo)
	{
		$sql_l_n="SELECT AVG(nota) AS nota FROM nota_comportamental_sub_insp, n_subperiodo_evaluativo, n_periodo_evaluativo WHERE 1
		AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
		AND nota_comportamental_sub_insp.id_subperiodo_evaluativo=n_subperiodo_evaluativo.id_subperiodo_evaluativo
		AND id_periodo_lectivo='".$id_periodo_lectivo."'
		AND nota_comportamental_sub_insp.id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'";//print $sql_s_n.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
		$rs_l_n=$db->Execute($sql_l_n) or die($db->ErrorMsg());
		
		if(isset($rs_l_n->fields['nota']))
		{
			$nota=$rs_l_n->fields['nota'];
		}
		else 
		$nota='';
		
		return $nota;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_nota_comportamental_periodo_inspector($db, $id_curso_grado_paralelo_est, $id_periodo_evaluativo)
	{
		$sql_p_n="SELECT AVG(nota) AS nota FROM nota_comportamental_sub_insp, n_subperiodo_evaluativo WHERE 1
		AND nota_comportamental_sub_insp.id_subperiodo_evaluativo=n_subperiodo_evaluativo.id_subperiodo_evaluativo
		AND id_periodo_evaluativo='".$id_periodo_evaluativo."'
		AND nota_comportamental_sub_insp.id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'";//print $sql_s_n.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
		$rs_p_n=$db->Execute($sql_p_n) or die($db->ErrorMsg());
		
		if(isset($rs_p_n->fields['nota']))
		{
			$nota=$rs_p_n->fields['nota'];
		}
		else 
		$nota='';
		
		return $nota;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_nota_comportamental_subperiodo_inspector($db, $id_curso_grado_paralelo_est, $id_subperiodo_evaluativo)
	{
		$sql_s_n="SELECT nota FROM nota_comportamental_sub_insp WHERE 1
		AND nota_comportamental_sub_insp.id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."'
		AND nota_comportamental_sub_insp.id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'";//print $sql_s_n.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
		$rs_s_n=$db->Execute($sql_s_n) or die($db->ErrorMsg());
		
		if(isset($rs_s_n->fields['nota']))
		{
			$nota=$rs_s_n->fields['nota'];
		}
		else 
		$nota='';
		
		return $nota;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_nota_comportamental_lec_tutor($db, $id_curso_grado_paralelo_est, $id_periodo_lectivo)
	{
		$sql_l_n="SELECT AVG(nota) AS nota FROM nota_comportamental_sub_tut, n_subperiodo_evaluativo, n_periodo_evaluativo WHERE 1
		AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
		AND nota_comportamental_sub_tut.id_subperiodo_evaluativo=n_subperiodo_evaluativo.id_subperiodo_evaluativo
		AND id_periodo_lectivo='".$id_periodo_lectivo."'
		AND nota_comportamental_sub_tut.id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'";//print $sql_s_n.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
		$rs_l_n=$db->Execute($sql_l_n) or die($db->ErrorMsg());
		
		if(isset($rs_l_n->fields['nota']))
		{
			$nota=$rs_l_n->fields['nota'];
		}
		else 
		$nota='';
		
		return $nota;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_nota_comportamental_periodo_tutor($db, $id_curso_grado_paralelo_est, $id_periodo_evaluativo)
	{
		$sql_p_n="SELECT AVG(nota) AS nota FROM nota_comportamental_sub_tut, n_subperiodo_evaluativo WHERE 1
		AND nota_comportamental_sub_tut.id_subperiodo_evaluativo=n_subperiodo_evaluativo.id_subperiodo_evaluativo
		AND id_periodo_evaluativo='".$id_periodo_evaluativo."'
		AND nota_comportamental_sub_tut.id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'";//print $sql_s_n.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
		$rs_p_n=$db->Execute($sql_p_n) or die($db->ErrorMsg());
		
		if(isset($rs_p_n->fields['nota']))
		{
			$nota=$rs_p_n->fields['nota'];
		}
		else 
		$nota='';
		
		return $nota;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_nota_comportamental_subperiodo_tutor($db, $id_curso_grado_paralelo_est, $id_subperiodo_evaluativo)
	{
		$sql_s_n="SELECT nota FROM nota_comportamental_sub_tut WHERE 1
		AND nota_comportamental_sub_tut.id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."'
		AND nota_comportamental_sub_tut.id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'";//print $sql_s_n.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
		$rs_s_n=$db->Execute($sql_s_n) or die($db->ErrorMsg());
		
		if(isset($rs_s_n->fields['nota']))
		{
			$nota=$rs_s_n->fields['nota'];
		}
		else 
		$nota='';
		
		return $nota;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_nota_comportamental_lectivo($db, $id_curso_grado_paralelo_est, $id_periodo_lectivo)
	{
		$cant=0;
		
		$sql_p="SELECT id_periodo_evaluativo, periodo_evaluativo, abv_periodo
		FROM n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo		
		AND n_conf_academica.activa='1'
		AND n_periodo_evaluativo.id_periodo_lectivo='".$id_periodo_lectivo."'";//print $sql_p;die();
		$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
			
		for($p=0;$p<$rs_p->RecordCount();$p++)
		{
			$id_periodo_evaluativo=$rs_p->fields['id_periodo_evaluativo'];
			$nota[$p]=$this->consulta_nota_comportamental_periodo($db, $id_curso_grado_paralelo_est, $id_periodo_evaluativo);//print $p.'ppp- '.$nota[$p].'<br>';
			if($nota[$p]!='')$cant=$cant+1;
			
		$rs_p->MoveNext();
		}
		
		if($cant!=0)$nota=bcdiv(array_sum($nota), $cant, 10);else $nota='';
		
		return $nota;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_nota_comportamental_periodo($db, $id_curso_grado_paralelo_est, $id_periodo_evaluativo)
	{
		$cant=0;
		
		$sql_s="SELECT id_subperiodo_evaluativo, subperiodo_evaluativo, abv_subperiodo
		FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
		AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
		AND n_conf_academica.activa='1'
		AND n_subperiodo_evaluativo.id_periodo_evaluativo='".$id_periodo_evaluativo."'";//print $sql_s.'<br><br><br>';//die();
		$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
		
		for($s=0;$s<$rs_s->RecordCount();$s++)
		{
			$id_subperiodo_evaluativo=$rs_s->fields['id_subperiodo_evaluativo'];
			$nota[$s]=$this->consulta_nota_comportamental_subperiodo($db, $id_curso_grado_paralelo_est, $id_subperiodo_evaluativo);//print $s.' sss- '.$nota[$s].'<br>';
			if($nota[$s]!='')$cant=$cant+1;
			
		$rs_s->MoveNext();
		}
		
		if($cant!=0)$nota=bcdiv(array_sum($nota), $cant, 10);else $nota='';
		
		return $nota;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_nota_comportamental_subperiodo($db, $id_curso_grado_paralelo_est, $id_subperiodo_evaluativo)
	{
		$sql_s_n="SELECT AVG(nota) AS nota FROM nota_comportamental_sub, clase_estudiante WHERE 1
		AND nota_comportamental_sub.id_clase_estudiante=clase_estudiante.id_clase_estudiante
		AND nota_comportamental_sub.id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."'
		AND clase_estudiante.id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'";//print $sql_s_n.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
		$rs_s_n=$db->Execute($sql_s_n) or die($db->ErrorMsg());
		
		if(isset($rs_s_n->fields['nota']))
		{
			$nota=$rs_s_n->fields['nota'];
		}
		else 
		$nota='';
		
		return $nota;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//--------------------------------------------------------------------POR CLASES----------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_nota_comportamental_lec($db, $id_clase_estudiante, $id_periodo_lectivo)
	{
		$cant=0;
		
		$sql_p="SELECT id_periodo_evaluativo, periodo_evaluativo, abv_periodo
		FROM n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo		
		AND n_conf_academica.activa='1'
		AND n_periodo_evaluativo.id_periodo_lectivo='".$id_periodo_lectivo."'";//print $sql_p;die();
		$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
			
		for($p=0;$p<$rs_p->RecordCount();$p++)
		{
			$id_periodo_evaluativo=$rs_p->fields['id_periodo_evaluativo'];			
			$nota[$p]=$this->consulta_nota_comportamental_per($db, $id_clase_estudiante, $id_periodo_evaluativo);
			if($nota[$p]!='')$cant=$cant+1;
			
		$rs_p->MoveNext();
		}
		
		if($cant!=0)$nota=bcdiv(array_sum($nota), $cant, 10);else $nota='';
		
		return $nota;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_nota_comportamental_per($db, $id_clase_estudiante, $id_periodo_evaluativo)
	{
		$sql_p_n="SELECT AVG(nota) AS nota FROM nota_comportamental_sub, n_subperiodo_evaluativo WHERE 1
		AND nota_comportamental_sub.id_subperiodo_evaluativo=n_subperiodo_evaluativo.id_subperiodo_evaluativo
		AND id_periodo_evaluativo='".$id_periodo_evaluativo."'
		AND nota_comportamental_sub.id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_p_n.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
		$rs_p_n=$db->Execute($sql_p_n) or die($db->ErrorMsg());
		
		if(isset($rs_p_n->fields['nota']))
		{
			$nota=$rs_p_n->fields['nota'];
		}
		else 
		$nota='';
		
		return $nota;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_nota_comportamental_sub($db, $id_clase_estudiante, $id_subperiodo_evaluativo)
	{
		$sql_s_n="SELECT nota FROM nota_comportamental_sub WHERE 1
		AND nota_comportamental_sub.id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."'
		AND nota_comportamental_sub.id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_s_n.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
		$rs_s_n=$db->Execute($sql_s_n) or die($db->ErrorMsg());
		
		if(isset($rs_s_n->fields['nota']))
		{
			$nota=$rs_s_n->fields['nota'];
		}
		else 
		$nota='';
		
		return $nota;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//-----------------------------------------------------------------COMPORTAMIENTO---------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//-----------------------------------------------------------------ASISTENCIA-------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calcular_inasis_x_est($db, $id_estudiante)
	{
		$atrasos=array();$justificadas=array();$injustificadas=array();$doc_inp=array();
		
		$sql_asig="SELECT DISTINCT id_asignatura, curso_grado_paralelo_est.id_curso_grado_paralelo_est FROM clase, clase_estudiante, curso_grado_paralelo_est
		WHERE clase.id_clase=clase_estudiante.id_clase AND clase_estudiante.id_curso_grado_paralelo_est=curso_grado_paralelo_est.id_curso_grado_paralelo_est
		AND id_estudiante='".$id_estudiante."'";//print $sql_asig.'<br>';
		$rs_asig=$db->Execute($sql_asig) or die($db->ErrorMsg());
		
		for($a=0;$a<$rs_asig->RecordCount();$a++)
		{
			$id_asignatura=$rs_asig->fields['id_asignatura'];
			$id_curso_grado_paralelo_est=$rs_asig->fields['id_curso_grado_paralelo_est'];
			
			$inasistencia_x_asig[$a]=$this->calcular_inasis_x_asig_est($db, $id_asignatura, $id_curso_grado_paralelo_est);

		$rs_asig->MoveNext();
		}
		
		for($v=0;$v<$rs_asig->RecordCount();$v++)
		{
			if(isset($inasistencia_x_asig[$v]['atrasos']))$atrasos[$v]=$inasistencia_x_asig[$v]['atrasos'];			
			if(isset($inasistencia_x_asig[$v]['justificadas']))$justificadas[$v]=$inasistencia_x_asig[$v]['justificadas'];
			if(isset($inasistencia_x_asig[$v]['injustificadas']))$injustificadas[$v]=$inasistencia_x_asig[$v]['injustificadas'];
		}
		
		$inasistencia['atrasos']=array_sum($atrasos);
		$inasistencia['justificadas']=array_sum($justificadas);
		$inasistencia['injustificadas']=array_sum($injustificadas);
		
		return $inasistencia;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calcular_inasis_x_asig_est($db, $id_asignatura, $id_curso_grado_paralelo_est)
	{
		$atrasos=array();$justificadas=array();$injustificadas=array();$doc_inp=array();
		
		$sql_l="SELECT id_periodo_lectivo, periodo_lectivo
		FROM n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica		
		AND n_conf_academica.activa='1'";//print $sql_p;die();
		$rs_l=$db->Execute($sql_l) or die($db->ErrorMsg());
		
		for($l=0;$l<$rs_l->RecordCount();$l++)
		{
			$id_periodo_lectivo=$rs_l->fields['id_periodo_lectivo'];
			$inasistencia_x_lec[$l]=$this->calcular_inasis_x_asig_x_lec_x_est($db, $id_asignatura, $id_periodo_lectivo, $id_curso_grado_paralelo_est);
		
		$rs_l->MoveNext();
		}
		
		for($v=0;$v<$rs_l->RecordCount();$v++)
		{
			if(isset($inasistencia_x_lec[$v]['atrasos']))$atrasos[$v]=$inasistencia_x_lec[$v]['atrasos'];			
			if(isset($inasistencia_x_lec[$v]['justificadas']))$justificadas[$v]=$inasistencia_x_lec[$v]['justificadas'];
			if(isset($inasistencia_x_lec[$v]['injustificadas']))$injustificadas[$v]=$inasistencia_x_lec[$v]['injustificadas'];
		}
		
		$inasistencia_x_asig['atrasos']=array_sum($atrasos);
		$inasistencia_x_asig['justificadas']=array_sum($justificadas);
		$inasistencia_x_asig['injustificadas']=array_sum($injustificadas);
		
		return $inasistencia_x_asig;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calcular_inasis_x_asig_x_lec_x_est($db, $id_asignatura, $id_periodo_lectivo, $id_curso_grado_paralelo_est)
	{
		$atrasos=array();$justificadas=array();$injustificadas=array();$doc_inp=array();
		
		$sql_p="SELECT id_periodo_evaluativo, periodo_evaluativo, abv_periodo
		FROM n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo		
		AND n_conf_academica.activa='1'
		AND n_periodo_evaluativo.id_periodo_lectivo='".$id_periodo_lectivo."'";//print $sql_p;die();
		$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
		
		for($p=0;$p<$rs_p->RecordCount();$p++)
		{
			$id_periodo_evaluativo=$rs_p->fields['id_periodo_evaluativo'];
			$inasistencia_x_per[$p]=$this->calcular_inasis_x_asig_x_eval_x_est($db, $id_asignatura, $id_periodo_evaluativo, $id_curso_grado_paralelo_est);
		
		$rs_p->MoveNext();
		}
		
		for($v=0;$v<$rs_p->RecordCount();$v++)
		{
			if(isset($inasistencia_x_per[$v]['atrasos']))$atrasos[$v]=$inasistencia_x_per[$v]['atrasos'];			
			if(isset($inasistencia_x_per[$v]['justificadas']))$justificadas[$v]=$inasistencia_x_per[$v]['justificadas'];
			if(isset($inasistencia_x_per[$v]['injustificadas']))$injustificadas[$v]=$inasistencia_x_per[$v]['injustificadas'];
		}
		
		$inasistencia_x_lec['atrasos']=array_sum($atrasos);
		$inasistencia_x_lec['justificadas']=array_sum($justificadas);
		$inasistencia_x_lec['injustificadas']=array_sum($injustificadas);
		
		return $inasistencia_x_lec;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calcular_inasis_x_asig_x_eval_x_est($db, $id_asignatura, $id_periodo_evaluativo, $id_curso_grado_paralelo_est)
	{
		$atrasos=array();$justificadas=array();$injustificadas=array();$doc_inp=array();
		
		$sql_s="SELECT id_subperiodo_evaluativo, subperiodo_evaluativo, abv_subperiodo
		FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
		AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
		AND n_conf_academica.activa='1'
		AND n_subperiodo_evaluativo.id_periodo_evaluativo='".$id_periodo_evaluativo."'";//print $sql_s.'<br><br><br>';//die();
		$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
		
		for($s=0;$s<$rs_s->RecordCount();$s++)
		{
			$id_subperiodo_evaluativo=$rs_s->fields['id_subperiodo_evaluativo'];
			$inasistencia_x_eval[$s]=$this->calcular_inasis_x_asig_x_sub_x_est($db, $id_asignatura, $id_subperiodo_evaluativo, $id_curso_grado_paralelo_est);
		
		$rs_s->MoveNext();
		}
		
		for($v=0;$v<$rs_s->RecordCount();$v++)
		{
			if(isset($inasistencia_x_eval[$v]['atrasos']))$atrasos[$v]=$inasistencia_x_eval[$v]['atrasos'];			
			if(isset($inasistencia_x_eval[$v]['justificadas']))$justificadas[$v]=$inasistencia_x_eval[$v]['justificadas'];
			if(isset($inasistencia_x_eval[$v]['injustificadas']))$injustificadas[$v]=$inasistencia_x_eval[$v]['injustificadas'];
		}
		
		$inasistencia_x_per['atrasos']=array_sum($atrasos);
		$inasistencia_x_per['justificadas']=array_sum($justificadas);
		$inasistencia_x_per['injustificadas']=array_sum($injustificadas);
		
		return $inasistencia_x_per;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calcular_inasis_x_asignaturas_x_lec_x_est($db, $id_periodo_lectivo, $id_estudiante)//SE USA PARA LA LIBRETA
	{
		$atrasos=array();$justificadas=array();$injustificadas=array();
		
		$sql_p="SELECT id_periodo_evaluativo, periodo_evaluativo, abv_periodo
		FROM n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo		
		AND n_conf_academica.activa='1'
		AND n_periodo_evaluativo.id_periodo_lectivo='".$id_periodo_lectivo."'";//print $sql_p;die();
		$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
		
		for($p=0;$p<$rs_p->RecordCount();$p++)
		{
			$id_periodo_evaluativo=$rs_p->fields['id_periodo_evaluativo'];
			$inasistencia_x_asig[$p]=$this->calcular_inasis_x_asignaturas_x_eval_x_est($db, $id_periodo_evaluativo, $id_estudiante);
		
		$rs_p->MoveNext();
		}
		
		for($v=0;$v<$rs_p->RecordCount();$v++)
		{
			if(isset($inasistencia_x_asig[$v]['atrasos']))$atrasos[$v]=$inasistencia_x_asig[$v]['atrasos'];			
			if(isset($inasistencia_x_asig[$v]['justificadas']))$justificadas[$v]=$inasistencia_x_asig[$v]['justificadas'];
			if(isset($inasistencia_x_asig[$v]['injustificadas']))$injustificadas[$v]=$inasistencia_x_asig[$v]['injustificadas'];
			//$doc_inp=$inasistencia_x_asig[$v]['doc_inp'];
		}
		
		$inasistencia_x_asignaturas['atrasos']=array_sum($atrasos);
		$inasistencia_x_asignaturas['justificadas']=array_sum($justificadas);
		$inasistencia_x_asignaturas['injustificadas']=array_sum($injustificadas);
		//$inasistencia_x_asignaturas['doc_inp']=$inasistencia_x_asig[$v]['doc_inp'];
		
		return $inasistencia_x_asignaturas;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calcular_inasis_x_asignaturas_x_eval_x_est($db, $id_periodo_evaluativo, $id_estudiante)//SE USA PARA LA LIBRETA
	{
		$atrasos=array();$justificadas=array();$injustificadas=array();
		
		$sql_s="SELECT id_subperiodo_evaluativo, subperiodo_evaluativo, abv_subperiodo
		FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
		AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
		AND n_conf_academica.activa='1'
		AND n_subperiodo_evaluativo.id_periodo_evaluativo='".$id_periodo_evaluativo."'";//print $sql_s.'<br><br><br>';//die();
		$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
		
		for($s=0;$s<$rs_s->RecordCount();$s++)
		{
			$id_subperiodo_evaluativo=$rs_s->fields['id_subperiodo_evaluativo'];			
			$inasistencia_x_asig[$s]=$this->calcular_inasis_x_asignaturas_x_sub_x_est($db, $id_subperiodo_evaluativo, $id_estudiante);
	
		$rs_s->MoveNext();
		}
		
		for($v=0;$v<$rs_s->RecordCount();$v++)
		{
			if(isset($inasistencia_x_asig[$v]['atrasos']))$atrasos[$v]=$inasistencia_x_asig[$v]['atrasos'];			
			if(isset($inasistencia_x_asig[$v]['justificadas']))$justificadas[$v]=$inasistencia_x_asig[$v]['justificadas'];
			if(isset($inasistencia_x_asig[$v]['injustificadas']))$injustificadas[$v]=$inasistencia_x_asig[$v]['injustificadas'];
			//$doc_inp=$inasistencia_x_asig[$v]['doc_inp'];
		}
		
		$inasistencia_x_asignaturas['atrasos']=array_sum($atrasos);
		$inasistencia_x_asignaturas['justificadas']=array_sum($justificadas);
		$inasistencia_x_asignaturas['injustificadas']=array_sum($injustificadas);
		//$inasistencia_x_asignaturas['doc_inp']=$inasistencia_x_asig[$v]['doc_inp'];
		
		return $inasistencia_x_asignaturas;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calcular_inasis_x_asignaturas_x_sub_x_est($db, $id_subperiodo_evaluativo, $id_estudiante)//SE USA PARA LA LIBRETA
	{
		$atrasos=array();$justificadas=array();$injustificadas=array();
		
		$sql_asig="SELECT DISTINCT id_asignatura, curso_grado_paralelo_est.id_curso_grado_paralelo_est FROM clase, clase_estudiante, curso_grado_paralelo_est
		WHERE clase.id_clase=clase_estudiante.id_clase AND clase_estudiante.id_curso_grado_paralelo_est=curso_grado_paralelo_est.id_curso_grado_paralelo_est
		AND id_estudiante='".$id_estudiante."'";//print $sql_asig.'<br>';
		$rs_asig=$db->Execute($sql_asig) or die($db->ErrorMsg());
		
		for($a=0;$a<$rs_asig->RecordCount();$a++)
		{
			$id_asignatura=$rs_asig->fields['id_asignatura'];
			$id_curso_grado_paralelo_est=$rs_asig->fields['id_curso_grado_paralelo_est'];			
			$inasistencia_x_asig[$a]=$this->calcular_inasis_x_asig_x_sub_x_est($db, $id_asignatura, $id_subperiodo_evaluativo, $id_curso_grado_paralelo_est);
	
		$rs_asig->MoveNext();
		}
		
		for($v=0;$v<$rs_asig->RecordCount();$v++)
		{
			if(isset($inasistencia_x_asig[$v]['atrasos']))$atrasos[$v]=$inasistencia_x_asig[$v]['atrasos'];			
			if(isset($inasistencia_x_asig[$v]['justificadas']))$justificadas[$v]=$inasistencia_x_asig[$v]['justificadas'];
			if(isset($inasistencia_x_asig[$v]['injustificadas']))$injustificadas[$v]=$inasistencia_x_asig[$v]['injustificadas'];
			//$doc_inp=$inasistencia_x_asig[$v]['doc_inp'];
		}
		
		$inasistencia_x_asignaturas['atrasos']=array_sum($atrasos);
		$inasistencia_x_asignaturas['justificadas']=array_sum($justificadas);
		$inasistencia_x_asignaturas['injustificadas']=array_sum($injustificadas);
		//$inasistencia_x_asignaturas['doc_inp']=$inasistencia_x_asig[$v]['doc_inp'];
		
		return $inasistencia_x_asignaturas;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calcular_inasis_x_asig_x_sub_x_est($db, $id_asignatura, $id_subperiodo_evaluativo, $id_curso_grado_paralelo_est)
	{
		$inasistencia_x_asig=array();$atrasos=array();$justificadas=array();$injustificadas=array();$doc_inp=array();
		
		$sql_cla="SELECT DISTINCT clase.id_clase, clase.nombre
		FROM clase_inasistencia, clase_estudiante, clase, n_periodo_academico 
		WHERE 1 
		AND n_periodo_academico.id_periodo_academico=clase.id_periodo_academico
		AND clase_estudiante.id_clase=clase.id_clase AND clase_inasistencia.id_clase=clase.id_clase
		AND id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' 
		AND clase.id_asignatura='".$id_asignatura."' AND id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'
		AND n_periodo_academico.activo='1'";//print $sql_cla.'<br>';//die();
		$rs_cla=$db->Execute($sql_cla) or die($db->ErrorMsg());
		
		if($rs_cla->fields['id_clase']!='')
		{
			$varios_arreglos=array();
			
			for($c=0;$c<$rs_cla->RecordCount();$c++)
			{
				$id_clase=$rs_cla->fields['id_clase'];//print $c.' - '.$id_clase.'<br>';		
				$varios_arreglos[$c]=$this->calcular_inasis_x_clase_x_sub_x_est($db, $id_clase, $id_subperiodo_evaluativo, $id_curso_grado_paralelo_est);
				
			$rs_cla->MoveNext();
			}
			
			for($v=0;$v<count($varios_arreglos);$v++)
			{
				$atrasos[$v]=array_sum($varios_arreglos[$v]['atrasos']);
				$justificadas[$v]=array_sum($varios_arreglos[$v]['justificadas']);
				$injustificadas[$v]=array_sum($varios_arreglos[$v]['injustificadas']);
			}
			
			$inasistencia_x_asig['atrasos']=array_sum($atrasos);//print 'atrasos '.$inasistencia_x_asig['atrasos'].'<br>';
			$inasistencia_x_asig['justificadas']=array_sum($justificadas);//print 'justificadas '.$inasistencia_x_asig['justificadas'].'<br>';
			$inasistencia_x_asig['injustificadas']=array_sum($injustificadas);//print 'injustificadas '.$inasistencia_x_asig['injustificadas'].'<br>';
		}		
		
	return $inasistencia_x_asig;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calcular_inasis_x_clase_x_sub_x_est($db, $id_clase, $id_subperiodo_evaluativo, $id_curso_grado_paralelo_est)
	{
		$atrasos=array();$justificadas=array();$injustificadas=array();$doc_inp=array();
		
		$sql_ina="SELECT clase_inasistencia.id_clase_inasistencia, fecha, tema_impartir, inasistencia, observacion, inasistencia_inspector, observacion_inspector
		FROM clase_inasistencia, inasistencia_clase, clase_estudiante, clase, n_periodo_academico 
		WHERE 1 
		AND n_periodo_academico.id_periodo_academico=clase.id_periodo_academico
		AND clase_estudiante.id_clase=clase.id_clase AND clase_inasistencia.id_clase_inasistencia=inasistencia_clase.id_clase_inasistencia
		AND inasistencia_clase.id_clase_estudiante=clase_estudiante.id_clase_estudiante	AND id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' 
		AND clase_inasistencia.id_clase='".$id_clase."' AND id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'
		AND n_periodo_academico.activo='1' ORDER BY fecha";//print $sql_ina.'<br>';//die();
		$rs_ina=$db->Execute($sql_ina) or die($db->ErrorMsg());
		
		$sql_horas_clase="SELECT clase_inasistencia.id_clase_inasistencia, fecha, tema_impartir
		FROM clase_inasistencia WHERE 1 
		AND id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' 
		AND clase_inasistencia.id_clase='".$id_clase."' ORDER BY fecha";//print $sql_ina;//die();
		$rs_horas_clase=$db->Execute($sql_horas_clase) or die($db->ErrorMsg());
		
		$horas_clase=$rs_horas_clase->RecordCount();
		
		for($a=0;$a<$rs_ina->RecordCount();$a++)
		{
			$inasistencia=$rs_ina->fields['inasistencia'];
			$inasistencia_inspector=$rs_ina->fields['inasistencia_inspector'];
			$atrasos[$a]=0;$justificadas[$a]=0;$injustificadas[$a]=0;$doc_inp[$a]=0;
			
			if($inasistencia!=0 AND $inasistencia_inspector==99)
			{
				if($inasistencia==1)$atrasos[$a]=1;
				elseif($inasistencia==2)$justificadas[$a]=1;
				elseif($inasistencia==3)$injustificadas[$a]=1;
				$doc_inp[$a]='doc';
			}
			
			if($inasistencia_inspector!=99)
			{
				if($inasistencia_inspector==1)$atrasos[$a]=1;
				elseif($inasistencia_inspector==2)$justificadas[$a]=1;
				elseif($inasistencia_inspector==3)$injustificadas[$a]=1;
				$doc_inp[$a]='insp';
			}
			
		$rs_ina->MoveNext();
		}
		
		$varios_arreglos=array();
		$varios_arreglos=array('horas_clase'=>$horas_clase,'atrasos'=>$atrasos,'justificadas'=>$justificadas,'injustificadas'=>$injustificadas,'doc_inp'=>$doc_inp);
		
		return $varios_arreglos;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//-----------------------------------------------------------------ASISTENCIA-------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------	
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function encabezado_l($db)
	{
		$pos=0;$pos_id=1;
		
		$l_examen_lec_ant=array();
		$l_abv_tipo_examen_lec_ant=array();
		
		$l_examen_adicional_ant=array();
		$l_abv_examen_ant=array();
		
		$sql_l="SELECT id_periodo_lectivo, periodo_lectivo
		FROM n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica		
		AND n_conf_academica.activa='1'";//print $sql_p;die();
		$rs_l=$db->Execute($sql_l) or die($db->ErrorMsg());
		
		for($l=0;$l<$rs_l->RecordCount();$l++)
		{
			$pos=$pos+1;
			$actividad[$pos]=$rs_l->fields['periodo_lectivo'];
			$abv[$pos]='A&ntilde;o';
			$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, renderer: "html"}';
			$tipo[$pos]='l';
			$position[$pos]=$pos;
			$id_encab[$pos]=$rs_l->fields['id_periodo_lectivo'];

			$position_id[$pos_id]=$pos_id;
			$id[$pos_id]=$rs_l->fields['id_periodo_lectivo'];
			$tipo_id[$pos_id]='l';//print '  mi pos1: '.$pos_id;
			$pos_id=$pos_id+1;
	
		$rs_l->MoveNext();
		}
	
		$varios_arreglos=array();
		$varios_arreglos[0]=array('id'=>$id, 'id_encab'=>$id_encab, 'actividad'=>$actividad, 'abv'=>$abv, 'column'=>$column, 'tipo'=>$tipo, 'tipo_id'=>$tipo_id, 'position'=>$position, 'position_id'=>$position_id);//print count($data);

		return $varios_arreglos;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calcular_prom_general($db, $id_estudiante)
	{
		$cant=0;$promedio='';
		
		$sql_asig="SELECT DISTINCT id_asignatura, curso_grado_paralelo_est.id_curso_grado_paralelo_est 
		FROM clase, clase_estudiante, curso_grado_paralelo_est, grado_paralelo_periodo, n_periodo_academico
		WHERE 1 AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico
		AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
		AND clase.id_clase=clase_estudiante.id_clase AND clase_estudiante.id_curso_grado_paralelo_est=curso_grado_paralelo_est.id_curso_grado_paralelo_est
		AND id_estudiante='".$id_estudiante."' AND n_periodo_academico.activo='1'";//print $sql_asig.'<br>';
		$rs_asig=$db->Execute($sql_asig) or die($db->ErrorMsg());
		
		for($a=0;$a<$rs_asig->RecordCount();$a++)
		{
			$id_asignatura=$rs_asig->fields['id_asignatura'];
			$id_curso_grado_paralelo_est=$rs_asig->fields['id_curso_grado_paralelo_est'];
			$prom_gen[$a]=$this->calcular_prom_x_asignatura($db, $id_asignatura, $id_curso_grado_paralelo_est);//print $prom_gen[$a].'<br>';
			if($prom_gen[$a]!='' AND $prom_gen[$a]!=0)$cant=$cant+1;
			
		$rs_asig->MoveNext();
		}
		
		if($cant!=0)$promedio=bcdiv(array_sum($prom_gen),$cant, 10);
		
		return $promedio;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calcular_prom_x_asignatura($db, $id_asignatura, $id_curso_grado_paralelo_est)
	{
		$codigo_unico_ant='';
		$no_pond=0;$cant=0;
		
		$varios_arreglos=$this->encabezado_l($db);
		
		$sql_clase_est="SELECT codigo_unico, peso, id_clase_estudiante FROM clase, clase_estudiante, n_asignatura 
		WHERE clase.id_clase=clase_estudiante.id_clase AND clase.id_asignatura=n_asignatura.id_asignatura AND n_asignatura.id_asignatura='".$id_asignatura."' 
		AND id_curso_grado_paralelo_est='".$id_curso_grado_paralelo_est."'
		AND cuantitativa='1'";//print $sql_clase_est.'<br>';
		$rs_clase_est=$db->Execute($sql_clase_est) or die($db->ErrorMsg());
		$prom_pond=array();
		for($c=0;$c<$rs_clase_est->RecordCount();$c++)
		{
			$codigo_unico=$rs_clase_est->fields['codigo_unico'];			
			
			if($codigo_unico_ant=='' OR $codigo_unico==$codigo_unico_ant)
			{
				$promedio=array();
				
				
				$codigo_unico_ant=$codigo_unico;
				$id_clase_estudiante=$rs_clase_est->fields['id_clase_estudiante'];
				$peso[$c]=$rs_clase_est->fields['peso'];
				$id_encab=$varios_arreglos[0]['id_encab'];		
				$tipo=$varios_arreglos[0]['tipo'];
				$position=$varios_arreglos[0]['position'];
				
				//--------------------------------------------------------------------------------------------------------------------
				for($h=1;$h<=count($position);$h++)
				{					
					if($tipo[$position[$h]]=='l')
					{
						$promedio_l=$this->calcular_prom_lectivo($db, $id_clase_estudiante, $id_encab[$position[$h]]);//print $promedio_l['promedio'].'<br>';//print 'examen_periodo: '.$promedio_l['promedio'].'<br>';//$nota='<a ';if($promedio_l['promedio']<$nota_aprobado)$nota.='style="color:red;" '; $nota.='>&nbsp;&nbsp;'.$promedio_l['promedio'].'&nbsp;&nbsp;</a>';
						$promedio[$c]=$promedio_l['promedio'];
						if($promedio[$c]!='')$cant=$cant+1;
					}
				}
				//--------------------------------------------------------------------------------------------------------------------
				if($cant!=0)
				{
					$anno_lectivo[$c]=bcdiv(array_sum($promedio),$cant, 10);//print 'prom: '.array_sum($promedio).' cant:'.$cant;			
					if($anno_lectivo[$c]!='')$prom_pond[$c]=bcmul($anno_lectivo[$c], $peso[$c], 10);else $no_pond=1;//print $anno_lectivo[$c].'*'.$peso[$c].'='.$prom_pond[$c].'<br>';
				}
				$cant=0;
			}		
			
		$rs_clase_est->MoveNext();
		}
		
		//print array_sum($peso).'<br>';
		
		if($no_pond==0)
		return bcdiv(array_sum($prom_pond), 100, 10);
		else
		return array_sum($anno_lectivo);
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------	
	function calcular_prom_lectivo($db, $id_clase_estudiante, $id_periodo_lectivo)
	{
		$sql_nota="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_academica WHERE activa='1'";//print $sql_nota.'<br>';
		$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
		
		$nota_aprobado=$rs_nota->fields['nota_aprobado'];
		
		$datos_l=$this->calcular_prom_lectivo_sin_adicional($db, $id_clase_estudiante, $id_periodo_lectivo);
		$datos_l_adicional=$this->calcular_prom_lectivo_con_adicional($db, $id_clase_estudiante, $id_periodo_lectivo);
		
		for($d=0;$d<count($datos_l_adicional);$d++)
		{
			if($datos_l_adicional[$d]['opcional']==1)//el estudiante quiere mejorar la nota
			{
				if($datos_l_adicional[$d]['sustituye_nota']==1)//sustituye la nota completa del período
				{
					if($datos_l['promedio']<$datos_l_adicional[$d]['nota'])
					$datos_l['promedio']=$datos_l_adicional[$d]['nota'];
				}
				elseif($datos_l_adicional[$d]['sustituye_nota']==0)//sustituye la nota solo del exámen
				{
					/*if($datos_l['parte_2']<$datos_l_adicional[$d]['nota'])
					{
						$datos_l['parte_2']=$datos_l_adicional[$d]['nota'];
						if($datos_l['parte_1']!=0 AND $datos_l['parte_2']!=0)$datos_l['promedio']=number_format(round(bcadd($datos_l['parte_1'], $datos_l['parte_2']), 2), 2, ".", "");		
						if($datos_l['promedio']>10)$datos_l['promedio']=number_format(round(bcdiv($datos_l['promedio'], 100, 15), 2), 2, ".", "");
					}*/
				}
			}
			elseif($datos_l_adicional[$d]['opcional']==0)//está suspenso el estudiante
			{
				if($datos_l_adicional[$d]['sustituye_nota']==1 && $datos_l['promedio']<$nota_aprobado)//sustituye la nota completa del período
				{
					if($datos_l_adicional[$d]['publica_nota']==1)
					{
						if($datos_l_adicional[$d]['publica_nota']==1 && $datos_l['promedio']<$datos_l_adicional[$d]['nota'])
						$datos_l['promedio']=$datos_l_adicional[$d]['nota'];
					}
					
					elseif($datos_l_adicional[$d]['publica_nota']==0 && $datos_l['promedio']<$datos_l_adicional[$d]['nota'] && $datos_l_adicional[$d]['nota']>=$nota_aprobado)
					{
						$datos_l['promedio']=number_format(round($nota_aprobado, 2), 2, ".", "");//se pone el aprobado						
					}
					
					elseif($datos_l_adicional[$d]['publica_nota']==0 && $datos_l['promedio']<$datos_l_adicional[$d]['nota'] && $datos_l_adicional[$d]['nota']<$nota_aprobado)
					{
						$datos_l['promedio']=$datos_l_adicional[$d]['nota'];//se pone la nota mayor aunque no haya aprobado aún
					}
				}
				elseif($datos_l_adicional[$d]['sustituye_nota']==0)//si sustituye solo la nota del exámen
				{
					/*if($datos_l['parte_2']<$datos_l_adicional[$d]['nota'])
					{
					
					}*/
				}
			}
		}					
					
		$promedio_l=$datos_l;
		return $promedio_l;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calcular_prom_lectivo_sin_adicional($db, $id_clase_estudiante, $id_periodo_lectivo)//OK
	{
		$suma_nota_peso=0;$i=0;$suma_peso=0;$inicial=2;$suma_promedios_p='';$cant_promedios_p='';
		
		$sql_p="SELECT id_periodo_evaluativo, periodo_evaluativo, abv_periodo, periodo_lectivo
		FROM n_periodo_evaluativo, n_periodo_lectivo
		WHERE 1	
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
		AND n_periodo_evaluativo.id_periodo_lectivo='".$id_periodo_lectivo."'";//print $sql_p;
		$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
		
		$datos_l['lectivo']=$rs_p->fields['periodo_lectivo'];
		$datos_l['abv_lectivo']='A&ntilde;o';
		
		for($p=$inicial;$p<$rs_p->RecordCount()+$inicial;$p++)
		{
			$id_periodo_evaluativo=$rs_p->fields['id_periodo_evaluativo'];			
			$prom=$this->calcular_prom_periodo($db, $id_clase_estudiante, $id_periodo_evaluativo);
			
			if($prom!='')
			{
				$suma_promedios_p=bcadd($suma_promedios_p, $prom, 14);
				$cant_promedios_p=$cant_promedios_p+1;
			}
			
		$rs_p->MoveNext();
		}
		if($cant_promedios_p!=0)
		$datos_l['promedio']=number_format(round(bcdiv($suma_promedios_p, $cant_promedios_p, 14), 2), 2, ".", "");//promedio aritmetico de los subperiodos para el calculo del promedio del periodo evaluativo
		else
		$datos_l['promedio']='';
		
		$sql_l_exa="SELECT id_examen_periodo_lec, examen_lec, abv_tipo_examen_lec, peso
		FROM n_examen_periodo_lec, n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_examen_periodo_lec.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
		AND n_periodo_lectivo.id_periodo_lectivo='".$id_periodo_lectivo."'			
		AND n_conf_academica.activa='1'
		ORDER BY examen_lec";//print $sql_l_exa;//die();//AND n_examen_periodo_lec.id_asignatura='".$id_asignatura."'
		$rs_l_exa=$db->Execute($sql_l_exa) or die($db->ErrorMsg());
		
		for($l_exa=0;$l_exa<$rs_l_exa->RecordCount();$l_exa++)
		{	
			if($rs_l_exa->fields['peso']!=0)
			{
				$id_examen_periodo_lec=$rs_l_exa->fields['id_examen_periodo_lec'];
				$examen_lectivo=$this->consulta_nota_examen_lectivo($db, $id_clase_estudiante, $id_examen_periodo_lec);
				
				if($examen_lectivo['nota']!='' AND is_numeric($examen_lectivo['nota']))
				{
					$suma_peso=bcadd($rs_l_exa->fields['peso'], $suma_peso, 15);
					$nota_peso=bcmul($examen_lectivo['nota'], $rs_l_exa->fields['peso'], 15);
					$suma_nota_peso=bcadd($suma_nota_peso,$nota_peso,15);					
				}
			}
		}
		$parte_2=$suma_nota_peso;//la parte_2 tiene que ver con los exámenes
		$datos_l['parte_2']=$parte_2;
		
		if($suma_peso>1)
		$peso_restante=100-$suma_peso;
		else
		$peso_restante=1-$suma_peso;
		
		$parte_1=bcmul($peso_restante, $datos_l['promedio'], 15);//la parte_1 tiene que ver con el resto de las evaluaciones
		$datos_l['parte_1']=$parte_1;
		
		if($parte_1!=0 AND $parte_2!=0)$datos_l['promedio']=number_format(round(bcadd($parte_1, $parte_2), 2), 2, ".", "");		
		if($datos_l['promedio']>10)$datos_l['promedio']=number_format(round(bcdiv($datos_l['promedio'], 100, 15), 2), 2, ".", "");

		return $datos_l;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calcular_prom_lectivo_con_adicional($db, $id_clase_estudiante, $id_periodo_lectivo)
	{
		$i=0;
		$sql_l_adic="SELECT id_exa_adicional_lectivo, examen_adicional, abv_examen, tipo_examen, opcional
		FROM n_examen_adicional, n_tipo_examen, n_exa_adicional_lectivo, n_examen_periodo_lec, n_periodo_lectivo, n_conf_academica, n_asignatura
		WHERE 1
		AND n_examen_periodo_lec.id_asignatura=n_asignatura.id_asignatura
		AND n_examen_adicional.id_examen_adicional=n_exa_adicional_lectivo.id_examen_adicional
		AND n_tipo_examen.id_tipo_examen=n_exa_adicional_lectivo.id_tipo_examen
		AND n_exa_adicional_lectivo.id_examen_periodo_lec=n_examen_periodo_lec.id_examen_periodo_lec
		AND n_examen_periodo_lec.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
		AND n_periodo_lectivo.id_periodo_lectivo='".$id_periodo_lectivo."'
		AND n_asignatura.cuantitativa='1'
		AND n_conf_academica.activa='1' ORDER BY n_exa_adicional_lectivo.orden";//print $sql_l_adic;//die();//, actividad.fecha
		$rs_l_adic=$db->Execute($sql_l_adic) or die($db->ErrorMsg());
		
		$rs_l_adic->MoveFirst();
		
		for($d=0;$d<$rs_l_adic->RecordCount();$d++)
		{
			$examen_lectivo_adicional=$this->consulta_nota_examen_lectivo_adicional($db, $id_clase_estudiante, $rs_l_adic->fields['id_exa_adicional_lectivo']);
			
			if(isset($examen_lectivo_adicional['nota']))
			{
				if($examen_lectivo_adicional['nota']!='')
				{
					$datos_l_adicional[$i]['nota']=$examen_lectivo_adicional['nota'];
					$datos_l_adicional[$i]['opcional']=$examen_lectivo_adicional['opcional'];
					$datos_l_adicional[$i]['publica_nota']=$examen_lectivo_adicional['publica_nota'];
					$datos_l_adicional[$i]['sustituye_nota']=$examen_lectivo_adicional['sustituye_nota'];
					$datos_l_adicional[$i]['id_exa_adicional_lectivo']=$examen_lectivo_adicional['id_exa_adicional_lectivo'];
					$i=$i+1;
				}
				else
				{
					$datos_l_adicional[$i]['nota']='';
					$datos_l_adicional[$i]['opcional']='';
					$datos_l_adicional[$i]['publica_nota']='';
					$datos_l_adicional[$i]['sustituye_nota']='';
					$datos_l_adicional[$i]['id_exa_adicional_lectivo']='';
				}
			}
			else
			{
				$datos_l_adicional[$i]['nota']='';
				$datos_l_adicional[$i]['opcional']='';
				$datos_l_adicional[$i]['publica_nota']='';
				$datos_l_adicional[$i]['sustituye_nota']='';
				$datos_l_adicional[$i]['id_exa_adicional_lectivo']='';
			}
			
			
		$rs_l_adic->MoveNext();
		}
		
		return $datos_l_adicional;
	}
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_nota_examen_lectivo($db, $id_clase_estudiante, $id_examen_periodo_lec)
	{
		$sql_nota="SELECT nota, peso FROM nota_examen_periodo_lec, n_examen_periodo_lec, n_asignatura
		WHERE 1 
		AND n_examen_periodo_lec.id_asignatura=n_asignatura.id_asignatura
		AND nota_examen_periodo_lec.id_examen_periodo_lec=n_examen_periodo_lec.id_examen_periodo_lec 
		AND n_examen_periodo_lec.id_examen_periodo_lec='".$id_examen_periodo_lec."'
		AND n_asignatura.cuantitativa='1'
		AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_nota.'<br>';
		$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
		
		if(isset($rs_nota->fields['nota']))
		{
			$examen_lectivo['nota']=number_format(round($rs_nota->fields['nota'], 2), 2, ".", "");//print $e.' - '.$a;
		}
		else
		$examen_lectivo['nota']='';
		
		return $examen_lectivo;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_nota_examen_lectivo_adicional($db, $id_clase_estudiante, $id_exa_adicional_lectivo)
	{		
		$sql_nota="SELECT nota, opcional, publica_nota, sustituye_nota FROM nota_exa_adicional_lectivo, n_exa_adicional_lectivo, n_examen_adicional, n_tipo_examen, n_examen_periodo_lec, n_asignatura
		WHERE 1
		AND n_examen_periodo_lec.id_asignatura=n_asignatura.id_asignatura
		AND n_examen_periodo_lec.id_examen_periodo_lec=n_exa_adicional_lectivo.id_examen_periodo_lec
		AND nota_exa_adicional_lectivo.id_exa_adicional_lectivo=n_exa_adicional_lectivo.id_exa_adicional_lectivo
		AND n_examen_adicional.id_examen_adicional=n_exa_adicional_lectivo.id_examen_adicional
		AND n_tipo_examen.id_tipo_examen=n_exa_adicional_lectivo.id_tipo_examen
		AND n_asignatura.cuantitativa='1'
		AND n_exa_adicional_lectivo.id_exa_adicional_lectivo='".$id_exa_adicional_lectivo."' 
		AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_nota.'<br>';
		$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
		
		if(isset($rs_nota->fields['nota']))
		{
			$examen_lectivo_adicional['nota']=number_format(round($rs_nota->fields['nota'], 2), 2, ".", "");//print $e.' - '.$a;
			$examen_lectivo_adicional['opcional']=$rs_nota->fields['opcional'];
			$examen_lectivo_adicional['publica_nota']=$rs_nota->fields['publica_nota'];
			$examen_lectivo_adicional['sustituye_nota']=$rs_nota->fields['sustituye_nota'];
			$examen_lectivo_adicional['id_exa_adicional_lectivo']=$id_exa_adicional_lectivo;
		}
		else
		$examen_lectivo_adicional['nota']='';
		
		return $examen_lectivo_adicional;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	function calcular_prom_periodos($db, $id_clase_estudiante, $id_periodo_lectivo)
	{
		$inicial=2;$suma_promedios_p='';$cant_promedios_p='';
		
		$sql_p="SELECT id_periodo_evaluativo, periodo_evaluativo, abv_periodo, periodo_lectivo
		FROM n_periodo_evaluativo, n_periodo_lectivo
		WHERE 1	
		AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
		AND n_periodo_evaluativo.id_periodo_lectivo='".$id_periodo_lectivo."'";//print $sql_p;
		$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
		
		$promedio_p['lectivo'][0]=$rs_p->fields['periodo_lectivo'];
		$promedio_p['abv_lectivo'][0]='A&ntilde;o';
		
		for($p=$inicial;$p<$rs_p->RecordCount()+$inicial;$p++)
		{
			$id_periodo_evaluativo=$rs_p->fields['id_periodo_evaluativo'];
			
			$promedio_p['id_periodo_evaluativo'][$p]=$rs_p->fields['id_periodo_evaluativo'];
			$promedio_p['periodo_evaluativo'][$p]=$rs_p->fields['periodo_evaluativo'];
			$promedio_p['abv_periodo'][$p]=$rs_p->fields['abv_periodo'];
			
			$prom=$this->calcular_prom_periodo($db, $id_clase_estudiante, $id_periodo_evaluativo);
			
			if($prom!='')
			{
				$suma_promedios_p=bcadd($suma_promedios_p, $prom, 14);
				$cant_promedios_p=$cant_promedios_p+1;
			}
			
			if($prom!='')
			$promedio_p['promedio'][$p]=$prom;//aqui asigna el promedio del periodo
			else
			$promedio_p['promedio'][$p]='';//print $prom;die();
			
		$rs_p->MoveNext();
		}
		if($cant_promedios_p!=0)
		$promedio_p['promedio_l'][0]=number_format(round(bcdiv($suma_promedios_p, $cant_promedios_p, 14), 2), 2, ".", "");//promedio aritmetico de los subperiodos para el calculo del promedio del periodo evaluativo
		else
		$promedio_p['promedio_l'][0]='';
		
		return $promedio_p;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calcular_prom_subperiodos($db, $id_clase_estudiante, $id_periodo_evaluativo)
	{
		$inicial=2;$suma_promedios_s='';$cant_promedios_s='';
		
		$sql_s="SELECT id_subperiodo_evaluativo, subperiodo_evaluativo, abv_subperiodo, periodo_evaluativo, abv_periodo
		FROM n_subperiodo_evaluativo, n_periodo_evaluativo
		WHERE 1	
		AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
		AND n_subperiodo_evaluativo.id_periodo_evaluativo='".$id_periodo_evaluativo."'";//print $sql_s;//die();
		$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
		
		$promedio_s['periodo'][0]=$rs_s->fields['periodo_evaluativo'];
		$promedio_s['abv'][0]=$rs_s->fields['abv_periodo'];
		
		for($s=$inicial;$s<$rs_s->RecordCount()+$inicial;$s++)
		{
			$id_subperiodo_evaluativo=$rs_s->fields['id_subperiodo_evaluativo'];
			
			$promedio_s['id_subperiodo_evaluativo'][$s]=$rs_s->fields['id_subperiodo_evaluativo'];
			$promedio_s['subperiodo_evaluativo'][$s]=$rs_s->fields['subperiodo_evaluativo'];
			$promedio_s['abv_subperiodo'][$s]=$rs_s->fields['abv_subperiodo'];
			
			$prom=$this->calcular_prom_subperiodo($db, $id_clase_estudiante, $id_subperiodo_evaluativo, '');
			
			if($prom['promedio']!='')
			{
				$suma_promedios_s=bcadd($suma_promedios_s, $prom['promedio'], 14);//die();
				$cant_promedios_s=$cant_promedios_s+1;
			}
			
			if($prom['promedio']!='')
			$promedio_s['promedio'][$s]=$prom['promedio'];
			else
			$promedio_s['promedio'][$s]='';
			
		$rs_s->MoveNext();
		}
		if($cant_promedios_s!=0)
		$promedio_s['promedio_p'][0]=bcdiv($suma_promedios_s, $cant_promedios_s, 14);//print $promedio_s['promedio_p'][0].'      ';//promedio aritmetico de los subperiodos para el calculo del promedio del periodo evaluativo
		else
		$promedio_s['promedio_p'][0]='';
		
		return $promedio_s;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calcular_prom_subperiodo($db, $id_clase_estudiante, $id_subperiodo_evaluativo, $sel_filtro_tip)
	{
		$inicial=2;
		$suma_peso=0;
		$promedio_pond=0;
		$suma_notas=0;
		$cant_nota=0;
		$promedio_arit='';
		$promedio_s['promedio']='';
		
		$sql_abv="SELECT abv_subperiodo, subperiodo_evaluativo, n_tipo_actividad.peso AS peso
		FROM n_tipo_actividad, actividad, clase_estudiante, n_subperiodo_evaluativo
		WHERE 1
		AND n_subperiodo_evaluativo.id_subperiodo_evaluativo=n_tipo_actividad.id_subperiodo_evaluativo
		AND n_tipo_actividad.id_tipo_actividad=actividad.id_tipo_actividad
		AND clase_estudiante.id_clase_estudiante='".$id_clase_estudiante."'
		AND n_tipo_actividad.id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' GROUP BY n_tipo_actividad.id_tipo_actividad";//print $sql_nota_tipo.'<br><br>';
		$rs_abv=$db->Execute($sql_abv) or die($db->ErrorMsg());
		
		$sql_nota_tipo="SELECT abv_subperiodo, subperiodo_evaluativo, n_tipo_actividad.peso AS peso, AVG(nota) AS nota
		FROM n_tipo_actividad, actividad, clase_estudiante, nota_actividad_examen, n_subperiodo_evaluativo, clase, n_asignatura
		WHERE 1
		AND clase.id_asignatura=n_asignatura.id_asignatura
		AND clase.id_clase=clase_estudiante.id_clase
		AND n_subperiodo_evaluativo.id_subperiodo_evaluativo=n_tipo_actividad.id_subperiodo_evaluativo
		AND actividad.id_actividad=nota_actividad_examen.id_actividad
		AND clase_estudiante.id_clase_estudiante=nota_actividad_examen.id_clase_estudiante
		AND n_tipo_actividad.id_tipo_actividad=actividad.id_tipo_actividad
		
		AND clase_estudiante.id_clase_estudiante='".$id_clase_estudiante."'
		AND n_tipo_actividad.id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."'";
		
		if($sel_filtro_tip!='')		
		$sql_nota_tipo=$sql_nota_tipo." AND n_tipo_actividad.id_tipo_actividad='".$sel_filtro_tip."'";
		
		$sql_nota_tipo=$sql_nota_tipo." GROUP BY n_tipo_actividad.id_tipo_actividad";//print $sql_nota_tipo.'<br><br>';
		$rs_nota_tipo=$db->Execute($sql_nota_tipo) or die($db->ErrorMsg());
		
		$promedio_s['subperiodo']=$rs_abv->fields['subperiodo_evaluativo'];
		$promedio_s['abv']=$rs_abv->fields['abv_subperiodo'];
		
		for($n=$inicial;$n<$rs_nota_tipo->RecordCount()+$inicial;$n++)
		{
			$nota=$rs_nota_tipo->fields['nota'];
			
			if($nota!='' AND is_numeric($nota))
			{//print 'nota: '.$nota.'<br><br>';
				$peso=$rs_nota_tipo->fields['peso'];
				$suma_peso=bcadd($suma_peso,$peso,14);			
				
				$nota_peso=bcmul($nota,$peso,14);
				$promedio_pond=bcadd($promedio_pond,$nota_peso,14);
				
				$suma_notas=bcadd($suma_notas,$nota,14);
				$cant_nota=$cant_nota+1;
			}
				
		$rs_nota_tipo->MoveNext();
		}
		
		if($promedio_pond>100)
		$promedio_pond=bcdiv($promedio_pond,100,14);//print $promedio_pond;

		if($cant_nota>0 && $suma_notas>0)
		$promedio_arit=bcdiv($suma_notas,$cant_nota,14);//print '<br>sumaaa:  '.$suma_peso.'<br>';
		
		if($suma_peso==100)
		{
			if($promedio_pond!='')
			{
				$promedio_s['promedio']=number_format(round($promedio_pond, 2), 2, ".", "");
			}
		}
		else
		{
			if($promedio_arit!='')
			{
				$promedio_s['promedio']=number_format(round($promedio_arit, 2), 2, ".", "");
			}
		}
		
		$suma_peso=0;$promedio_pond=0;$suma_notas=0;$promedio_arit='';
		
	return $promedio_s;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calcular_prom_periodo_aux($suma_peso_p, $promedio_subperiodos, $suma_nota_peso_p)
	{
		$prom='';//print $suma_peso_p;//die();
		
		$resto_peso_s=(100-$suma_peso_p)/100;//peso que corresponde a los subperiodos para el calculo del promedio del periodo evaluativo		
		$prom=bcadd(bcmul($promedio_subperiodos, $resto_peso_s, 14), $suma_nota_peso_p, 14);
		
		if($prom!=0)
		$prom=number_format(round($prom, 2), 2, ".", "");
		else
		$prom='';
		
		return $prom;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------

	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function calcular_prom_periodo($db, $id_clase_estudiante, $id_periodo_evaluativo)
	//EN LOS EXAMENES ADICIONALES DEL PERIODO FALTA PROGRAMAR QUE SEAN VARIOS Y TRATAR EL CAMPO SUSTITUYE_NOTA
	{
		$inicial=2;	
		$promedio_p=$this->calcular_prom_subperiodos($db, $id_clase_estudiante, $id_periodo_evaluativo);
		//$promedio_p['promedio_p'];//solo es el promedio de los subperiodos sin la nota del periodo y adicional
		
		$sql_nota="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_academica WHERE activa='1'";//print $sql_nota.'<br>';
		$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
		
		$nota_aprobado=$rs_nota->fields['nota_aprobado'];

			//-----------------NOTAS-----------------	
			$suma_peso_p='';$suma_nota_peso_p='';	
				
			$sql_nota="SELECT nota, peso, periodo_evaluativo, abv_periodo FROM nota_examen_periodo_eval, n_examen_periodo_eval, n_periodo_evaluativo, n_asignatura
			WHERE n_examen_periodo_eval.id_asignatura=n_asignatura.id_asignatura
			AND n_examen_periodo_eval.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
			AND nota_examen_periodo_eval.id_examen_periodo_eval=n_examen_periodo_eval.id_examen_periodo_eval 
			AND n_asignatura.cuantitativa='1'
			AND n_periodo_evaluativo.id_periodo_evaluativo='".$id_periodo_evaluativo."'
			AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_nota.'<br>';
			$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
			
			$promedio_p['periodo']=$rs_nota->fields['periodo_evaluativo'];
			$promedio_p['abv_periodo']=$rs_nota->fields['abv_periodo'];
			
			for($n=$inicial;$n<$rs_nota->RecordCount()+$inicial;$n++)
			{				
				if(isset($rs_nota->fields['nota']))
				{
					$peso=$rs_nota->fields['peso'];
					$suma_peso_p=bcadd($suma_peso_p, $peso, 14);
					$nota_peso_p=bcmul($rs_nota->fields['nota'], $peso/100, 14);
					$suma_nota_peso_p=bcadd($suma_nota_peso_p, $nota_peso_p, 14);
				}
			}		
			//-----------------NOTAS-----------------
			
			//-----------------PROMEDIO-----------------
			$promedio_p=$this->calcular_prom_periodo_aux($suma_peso_p, $promedio_p['promedio_p'][0], $suma_nota_peso_p);//die();
			$promedio_periodo=$promedio_p;
			//-----------------PROMEDIO-----------------
			
			//-----------------ADICIONAL-----------------
			$sql_p_nota_adic="SELECT nota, opcional, publica_nota
			FROM nota_exa_adicional_periodo, n_examen_adicional, n_tipo_examen, n_exa_adicional_periodo, n_examen_periodo_eval, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica, n_asignatura
			WHERE 1 
			AND n_examen_periodo_eval.id_asignatura=n_asignatura.id_asignatura
			AND nota_exa_adicional_periodo.id_exa_adicional_periodo=n_exa_adicional_periodo.id_exa_adicional_periodo
			AND n_examen_adicional.id_examen_adicional=n_exa_adicional_periodo.id_examen_adicional
			AND n_tipo_examen.id_tipo_examen=n_exa_adicional_periodo.id_tipo_examen
			AND n_exa_adicional_periodo.id_examen_periodo_eval=n_examen_periodo_eval.id_examen_periodo_eval
			AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
			AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
			AND n_examen_periodo_eval.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
			AND n_periodo_evaluativo.id_periodo_evaluativo='".$id_periodo_evaluativo."'
			AND n_conf_academica.activa='1' 
			AND n_asignatura.cuantitativa='1'
			AND id_clase_estudiante='".$id_clase_estudiante."'
			ORDER BY n_exa_adicional_periodo.orden";//print $sql_p_adic;die();//, actividad.fecha
			$rs_p_nota_adic=$db->Execute($sql_p_nota_adic) or die($db->ErrorMsg());
			
			if(isset($rs_p_nota_adic->fields['nota']))
			{
				if($rs_p_nota_adic->fields['nota']!='')
				{
					if($rs_p_nota_adic->fields['opcional']==1)
					{
						if($promedio_p>$rs_p_nota_adic->fields['nota'])
						$promedio_periodo=$promedio_p;
						else
						$promedio_periodo=$rs_p_nota_adic->fields['nota'];
					}
					else 
					{
						if($rs_p_nota_adic->fields['publica_nota']==0)
						$promedio_periodo=$nota_aprobado;//7 es el aprobado
						else
						$promedio_periodo=$rs_p_nota_adic->fields['nota'];
					}
				}
			}
			//-----------------ADICIONAL-----------------
			
			if($promedio_periodo!='')$promedio_periodo=number_format(round($promedio_periodo, 2), 2, ".", "");
		return $promedio_periodo;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function contenido_asistencias($db, $x, $mod, $sel_filtro_asis)
	{
		$varios_arreglos=$this->consulta_est_asistencias($db, $mod, $sel_filtro_asis);
		
		$id_clase_inasistencia=$varios_arreglos[0]['id_clase_inasistencia'];	
		$fecha=$varios_arreglos[0]['fecha'];
		$tema=$varios_arreglos[0]['tema'];
		$datos=$varios_arreglos[0]['datos'];
		$data=$varios_arreglos[0]['data'];
		$column=$varios_arreglos[0]['column'];
		$abv=$varios_arreglos[0]['abv'];
		$comment=$varios_arreglos[0]['comment'];
		$cerrado=$varios_arreglos[0]['cerrado'];
		$familiares=$varios_arreglos[0]['familiares'];
		$width=300+count($id_clase_inasistencia)*50;
?>
			<div style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
				
					<div id="container">
						<div class="columnLayout">
							<div class="rowLayout">
								<div class="descLayout">
									<div class="pad">
										<div id="msg_asis" style='float:right;'></div>
										<div id="grid_asistencias" style="width: <?php print $width;?>px; height: 50%; overflow: hidden1;"></div>
										<input name="hdn_comment" id="hdn_comment" type="hidden"/>
									</div>
								</div>

								<div class="codeLayout">
									<div class="pad">
										<script>
										var emerg = new Array();
										<?php
											for($c=0;$c<count($id_clase_inasistencia);$c++)
											{
												if($c==0)
												{
										?>
													emerg[<?php print $c;?>]='Estudiantes';
										<?php
												}
												elseif($c>=1)
												{
													$emerg='<b>Fecha: </b>'.$fecha[$c];
													$emerg=$emerg.'<br><b>Tema: </b>'.$tema[$c];
										?>
													<?php if($cerrado==1){?>
													btn_eli='';
													btn_mod='<a onMouseOver="return overlib(\'<?php print $emerg;?>\', ABOVE, RIGHT);"onMouseOut="return nd();"><?php print $abv[$c];?></a>';
													<?php }else{?>
													btn_eli='<a  onclick="alertify.confirm(\'Confirma que desea eliminar la fecha de clase?\', function(e){if(e){ejecutar_ajax(\'asistencia/eli_clase_inasistencia.php\',\'hdn_id_clase, sel_filtro_asis, hdn_id_clase_inasistencia_<?php print $id_clase_inasistencia[$c];?>\',\'contenido_grid_asistencias\')}else {alertify.error(\'Has pulsado \' + alertify.labels.cancel);}});"><img width=14px src=<?php print $x."img/general/mini_eliminar.png";?>></a>';
													btn_mod='<a href="#modal_mod_asistencia" onclick="ejecutar_ajax(\'asistencia/modal_mod_asistencia.php\',\'hdn_id_clase, sel_filtro_asis, hdn_id_clase_inasistencia_<?php print $id_clase_inasistencia[$c];?>\',\'modal_mod_asistencia\')" onMouseOver="return overlib(\'<?php print $emerg;?>\', ABOVE, RIGHT);"onMouseOut="return nd();"><?php print $abv[$c];?></a>';
													<?php }?>
													emerg[<?php print $c;?>]=btn_mod+btn_eli;
										<?php
												}
											}
										?>
										
										var $container = $("#grid_asistencias"),
										id_msg = document.getElementById('msg_asis'),
										$parent = $container.parent(),
										tableLoaded=false,
										hot_asis;

										hot_asis = new Handsontable($container[0], 
										{
											data:<?php print json_encode($data);?>,
											minRows: 5,
											minCols: 5,
											maxRows: <?php print count($data);?>,
											rowHeaders: true,
											colHeaders: true,
											minSpareRows: 1,
											contextMenu: true,
											comments: true,
											fillHandle: false,
											contextMenu: ['commentsAddEdit'],
											fixedColumnsLeft: 1,
											manualColumnFreeze: true,
											
											colWidths:[300
											<?php for($c=1;$c<count($id_clase_inasistencia);$c++){?>, 50 <?php }?>
											],
											
											colHeaders:['Estudiantes'
											<?php for($c=1;$c<count($id_clase_inasistencia);$c++){?>,emerg[<?php print $c;?>]<?php }?>
											],
											
											columns:[{readOnly: true, className: "htLeft", renderer: "html"}
											<?php for($c=1;$c<count($id_clase_inasistencia);$c++){print $column[$c];}?>
											],
											
											cell: [<?php print $comment;?>],
											
											afterSetCellMeta: function (row, col, key, val)
											{
												if(tableLoaded)
												{
													<?php if($cerrado==1){?>
													document.frm.hdn_comment.value=val;
													<?php }else{?>
													document.frm.hdn_comment.value=val;
													ejecutar_ajax('asistencia/guardar_inasistencia_obs.php','hdn_comment, hdn_row_col_asis'+row+'_'+col+', hdn_id_clase, sel_filtro_asis','contenido_grid_asistencias');
													<?php }?>
												}
											},
										});	
										
										tableLoaded=true;																	
										</script>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_est_asistencias($db, $mod, $sel_filtro_asis)
	{		
		$inicial=2;
		$datos[0][0]='0';
		$actividad[0]='Promedio';
		$id_clase_inasistencia[0]=0;
		$abv[0]='0';
		$fecha[0]='';
		$tema[0]='';
		$column[0]='0';
		$varios_arreglos[0]='0';
		$comment='';
		$familiares='';

		$sql_f="SELECT id_clase_inasistencia, fecha, tema_impartir
		FROM clase_inasistencia
		WHERE 1
		AND id_subperiodo_evaluativo='".$sel_filtro_asis."'
		AND id_clase='".$mod."' ORDER BY fecha";//print $sql_f;die();
		$rs_f=$db->Execute($sql_f) or die($db->ErrorMsg());
		
		$sql_avance="SELECT cerrado FROM cierre_subperiodo_evaluativo WHERE 1 AND id_subperiodo_evaluativo='".$sel_filtro_asis."' AND id_clase='".$mod."'";//print $sql_f;die();
		$rs_avance=$db->Execute($sql_avance) or die($db->ErrorMsg());
		$cerrado=$rs_avance->fields['cerrado'];
		
		$sql_est="SELECT estudiante.id_estudiante, clase_estudiante.id_clase_estudiante, clase_estudiante.fecha_entrada, clase_estudiante.fecha_salida, clase_estudiante.retirado, concat(per_estudiante.primer_apellido,' ',per_estudiante.segundo_apellido,' ',per_estudiante.primer_nombre,' ',per_estudiante.segundo_nombre) AS estudiante
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
		AND n_periodo_academico.activo='1' AND clase.id_clase='".$mod."'";//print $sql_est;
		$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
		
		$rs_est->MoveFirst();		
		for($e=0;$e<$rs_est->RecordCount();$e++)
		{
			$familiares=$this->datos_familiares($db, $rs_est->fields['id_estudiante']);
			$estudiante='<a onMouseOver="return overlib(\''.$familiares.'\', ABOVE, RIGHT);"onMouseOut="return nd();">'.$rs_est->fields['estudiante'].'</a>';
			
			$retirado=$rs_est->fields['retirado'];
			
			if($retirado=='1')
			$datos[$e][0]='<strike style="color:red;">'.$estudiante.'</strike>';
			else 
			$datos[$e][0]=$estudiante;
						
			$id_clase_estudiante=$rs_est->fields['id_clase_estudiante'];
			$fecha_ingreso_clase=$rs_est->fields['fecha_entrada'];
			$fecha_salida=$rs_est->fields['fecha_salida'];
				
			$rs_f->MoveFirst();
			for($f=1;$f<$rs_f->RecordCount()+1;$f++)
			{
				$id_clase_inasistencia[$f]=$rs_f->fields['id_clase_inasistencia'];
				
				$fecha[$f]=$rs_f->fields['fecha'];
				$tema[$f]=$rs_f->fields['tema_impartir'];
				$abv[$f]=$this->fecha_literal($rs_f->fields['fecha']);
				$id=$rs_est->fields['id_clase_estudiante'].'_'.$rs_f->fields['id_clase_inasistencia'];
				$row_col=$e.'_'.$f;
				?>
				
				<input name="hdn_celda_<?php print $id;?>" id="hdn_celda_<?php print $id;?>" type="hidden" value="<?php print $id;?>"/>
				<input name="hdn_row_col_asis<?php print $row_col;?>" id="hdn_row_col_asis<?php print $row_col;?>" type="hidden" value="<?php print $id;?>"/>
					
				<?php
				$sql_i="SELECT inasistencia, observacion FROM inasistencia_clase WHERE id_clase_inasistencia='".$rs_f->fields['id_clase_inasistencia']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $sql_nota.'<br>';
				$rs_i=$db->Execute($sql_i) or die($db->ErrorMsg());
				
				
				if($retirado=='0')
				{
					$fecha_salida='';
					if(isset($rs_i->fields['inasistencia']))
					{
						if($rs_i->fields['inasistencia']==0)//presente
						{
							$img='<a ';if($fecha_ingreso_clase<$rs_f->fields['fecha']){$img=$img.'onclick="cambiar_asistencia(\''.$id.'\')"';}$img=$img.'><img id="'.$id.'" width=13px src="../../../img/acad/asistencia/ok.png"></a>';
							if($cerrado==1)//presente
							{
								$img='<img id="'.$id.'" width=13px src="../../../img/acad/asistencia/ok.png">';
							}
						}
						elseif($rs_i->fields['inasistencia']==1)//atraso
						{
							$img='<a ';if($fecha_ingreso_clase<$rs_f->fields['fecha']){$img=$img.'onclick="cambiar_asistencia(\''.$id.'\')"';}$img=$img.'><img id="'.$id.'" width=13px src="../../../img/acad/asistencia/atraso.png"></a>';
							if($cerrado==1)//presente
							{
								$img='<img id="'.$id.'" width=13px src="../../../img/acad/asistencia/atraso.png">';
							}
						}
						elseif($rs_i->fields['inasistencia']==2)//justificado
						{
							$img='<a ';if($fecha_ingreso_clase<$rs_f->fields['fecha']){$img=$img.'onclick="cambiar_asistencia(\''.$id.'\')"';}$img=$img.'><img id="'.$id.'" width=13px src="../../../img/acad/asistencia/tarjeta_amarilla.png"></a>';
							if($cerrado==1)//presente
							{
								$img='<img id="'.$id.'" width=13px src="../../../img/acad/asistencia/tarjeta_amarilla.png">';
							}
						}
						elseif($rs_i->fields['inasistencia']==3)//injustificado
						{
							$img='<a ';if($fecha_ingreso_clase<$rs_f->fields['fecha']){$img=$img.'onclick="cambiar_asistencia(\''.$id.'\')"';}$img=$img.'><img id="'.$id.'" width=13px src="../../../img/acad/asistencia/tarjeta_roja.png"></a>';
							if($cerrado==1)//presente
							{
								$img='<img id="'.$id.'" width=13px src="../../../img/acad/asistencia/tarjeta_roja.png">';
							}
						}
					}
					else
					{
						$img='<a ';if($fecha_ingreso_clase<$rs_f->fields['fecha']){$img=$img.'onclick="cambiar_asistencia(\''.$id.'\')"';}$img=$img.'><img id="'.$id.'" width=13px src="../../../img/acad/asistencia/ok.png"></a>';
						if($cerrado==1)//presente
						{
							$img='<img id="'.$id.'" width=13px src="../../../img/acad/asistencia/ok.png">';
						}
					}
				}
				elseif($retirado=='1')
				{
					if(isset($rs_i->fields['inasistencia']))
					{
						if($rs_i->fields['inasistencia']==0)//presente
						{
							$img='<a ';if($fecha_ingreso_clase<$rs_f->fields['fecha'] AND $fecha_salida>$rs_f->fields['fecha']){$img=$img.'onclick="cambiar_asistencia(\''.$id.'\')"';}$img=$img.'><img id="'.$id.'" width=13px src="../../../img/acad/asistencia/ok.png"></a>';
							if($cerrado==1)//presente
							{
								$img='<img id="'.$id.'" width=13px src="../../../img/acad/asistencia/ok.png">';
							}
						}
						elseif($rs_i->fields['inasistencia']==1)//atraso
						{
							$img='<a ';if($fecha_ingreso_clase<$rs_f->fields['fecha'] AND $fecha_salida>$rs_f->fields['fecha']){$img=$img.'onclick="cambiar_asistencia(\''.$id.'\')"';}$img=$img.'><img id="'.$id.'" width=13px src="../../../img/acad/asistencia/atraso.png"></a>';
							if($cerrado==1)//presente
							{
								$img='<img id="'.$id.'" width=13px src="../../../img/acad/asistencia/atraso.png">';
							}
						}
						elseif($rs_i->fields['inasistencia']==2)//justificado
						{
							$img='<a ';if($fecha_ingreso_clase<$rs_f->fields['fecha'] AND $fecha_salida>$rs_f->fields['fecha']){$img=$img.'onclick="cambiar_asistencia(\''.$id.'\')"';}$img=$img.'><img id="'.$id.'" width=13px src="../../../img/acad/asistencia/tarjeta_amarilla.png"></a>';
							if($cerrado==1)//presente
							{
								$img='<img id="'.$id.'" width=13px src="../../../img/acad/asistencia/tarjeta_amarilla.png">';
							}
						}
						elseif($rs_i->fields['inasistencia']==3)//injustificado
						{
							$img='<a ';if($fecha_ingreso_clase<$rs_f->fields['fecha'] AND $fecha_salida>$rs_f->fields['fecha']){$img=$img.'onclick="cambiar_asistencia(\''.$id.'\')"';}$img=$img.'><img id="'.$id.'" width=13px src="../../../img/acad/asistencia/tarjeta_roja.png"></a>';
							if($cerrado==1)//presente
							{
								$img='<img id="'.$id.'" width=13px src="../../../img/acad/asistencia/tarjeta_roja.png">';
							}
						}
					}
					else
					{
						$img='<a ';if($fecha_ingreso_clase<$rs_f->fields['fecha'] AND $fecha_salida>$rs_f->fields['fecha']){$img=$img.'onclick="cambiar_asistencia(\''.$id.'\')"';}$img=$img.'><img id="'.$id.'" width=13px src="../../../img/acad/asistencia/ok.png"></a>';
						if($cerrado==1)//presente
						{
							$img='<img id="'.$id.'" width=13px src="../../../img/acad/asistencia/ok.png">';
						}
					}
				}
				
				//print $fecha_ingreso_clase.' '.$rs_f->fields['fecha'].'<br>';
				$datos[$e][$f]=$img;				
				
				$column[$f]=',{renderer: "html"';
				$column[$f]=$column[$f].',readOnly: true}';
				
				if($rs_i->fields['observacion']!='')
				{
					$obs=str_replace( array("\\", "¨", "~", "|", "\"", "·", "$", "&", "?", "'", "¿", "[", "^", "`", "]", "}", "{", "¨", "´", ">“, “< ", ";"), '', $rs_i->fields['observacion']);
					$obs=str_replace( array("\n"), '\\n', $obs);
					
					if($comment=='')
					$comment='{row: '.$e.', col: '.$f.', comment: "'.$obs.'"}';
					else
					$comment=$comment.',{row: '.$e.', col: '.$f.', comment: "'.$obs.'"}';				
				}
				
			$rs_f->MoveNext();
			}

		$rs_est->MoveNext();
		}
		
		for($d=0;$d<count($datos);$d++){$data[$d]=$datos[$d];}
		
		$varios_arreglos=array();
		$varios_arreglos[0]=array('abv'=>$abv,'datos'=>$datos,'data'=>$data,'id_clase_inasistencia'=>$id_clase_inasistencia,'fecha'=>$fecha,'tema'=>$tema,'column'=>$column,'comment'=>$comment,'cerrado'=>$cerrado,'familiares'=>$familiares);//print count($data);
		
		for($i=0;$i<count($id_clase_inasistencia);$i++)
		{
		?>
			<input name="hdn_id_clase_inasistencia_<?php print $id_clase_inasistencia[$i];?>" title='<?php print $i;?>' id="hdn_id_clase_inasistencia_<?php print $id_clase_inasistencia[$i];?>" type="hidden" value="<?php print $id_clase_inasistencia[$i];?>"/>
		<?php 
		}
		
		return $varios_arreglos;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function fecha_literal($fecha)
	{
		$mes=substr($fecha, 5, 2);
		
		if($mes=='01')$mes_literal='Ene';
		if($mes=='02')$mes_literal='Feb';
		if($mes=='03')$mes_literal='Mar';
		if($mes=='04')$mes_literal='Abr';
		if($mes=='05')$mes_literal='May';
		if($mes=='06')$mes_literal='Jun';
		if($mes=='07')$mes_literal='Jul';
		if($mes=='08')$mes_literal='Ago';
		if($mes=='09')$mes_literal='Sep';
		if($mes=='10')$mes_literal='Oct';
		if($mes=='11')$mes_literal='Nov';
		if($mes=='12')$mes_literal='Dic';
		
		return substr($fecha, 8, 2).'-'.$mes_literal;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function contenido_calificaciones($db, $x, $mod, $sel_filtro_cal, $id_asignatura, $sel_filtro_tip)
	{
		$hidden='';
		$varios_arreglos=$this->consulta_est_notas($db, $mod, $sel_filtro_cal, $id_asignatura, $sel_filtro_tip);
		
		$id_actividad=$varios_arreglos[0]['id_actividad'];
		$actividad=$varios_arreglos[0]['actividad'];
		$descripcion=$varios_arreglos[0]['descripcion'];
		$fecha=$varios_arreglos[0]['fecha'];
		
		$abv=$varios_arreglos[0]['abv'];		
		$datos=$varios_arreglos[0]['datos'];
		$data=$varios_arreglos[0]['data'];//print 'count'.count($id_actividad);
		$column=$varios_arreglos[0]['column'];
		$cerrado=$varios_arreglos[0]['cerrado'];
		$width=300+count($id_actividad)*40;
		if($width>1400)
		{
			$width='';
			$hidden='hidden';
		}
		
		if(substr($sel_filtro_cal, 0, 2)=="s_")
		$comment=$varios_arreglos[0]['comment'];
		else
		$comment='';
		
		$sql_nota="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_academica WHERE activa='1'";//print $sql_nota.'<br>';
		$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
		
		$nota_minima=$rs_nota->fields['nota_minima'];
		$nota_aprobado=$rs_nota->fields['nota_aprobado'];
		$nota_maxima=$rs_nota->fields['nota_maxima'];
?>
			<div style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
				
					<div id="container">
						<div class="columnLayout">
							<div class="rowLayout">
								<div class="descLayout">
									<div class="pad">
										<div id="msg_cal" style='float:right;'></div>
										<div id="grid_calificaciones" style="width: <?php print $width;?>px; height: 50%; overflow: <?php print $hidden;?>;"></div>
									</div>
								</div>

								<div class="codeLayout">
									<div class="pad">
										<script>
										var emerg = new Array();//		alert(document.frm.sel_filtro_cal.value.substring(0, 2));
										<?php
											for($c=0;$c<count($id_actividad);$c++)
											{//print count($id_actividad);
												if($c==0)
												{
										?>
													emerg[<?php print $c;?>]='Estudiantes';
										<?php
												}
												if($c==1 && isset($abv[$c]))
												{
													if($abv[$c]!='' && $actividad[$c]!='')$emerg='<b>Promedio: </b><br>'.$abv[$c].': '.$actividad[$c];$emerg='';
										?>
													emerg[<?php print $c;?>]='<a onMouseOver="return overlib(\'<?php print $emerg;?>\', ABOVE, LEFT);"onMouseOut="return nd();"><?php print $abv[$c];?></a>';
										<?php
												}
												elseif($c>=2)
												{
													$emerg='<b>Nombre: </b>'.$abv[$c].': '.$actividad[$c];
													if(substr($sel_filtro_cal, 0, 2)=="s_"){$emerg=$emerg.'<br>'.'<b>Descripci&oacute;n: </b>'.$descripcion[$c];}
													if(substr($sel_filtro_cal, 0, 2)=="s_"){$emerg=$emerg.'<br>'.'<b>Fecha: </b>'.$fecha[$c];}
										?>
													if(document.frm.sel_filtro_cal.value.substring(0, 2)=="s_")
													{	
														<?php if($cerrado==1){?>
														btn_eli='';
														btn_mod='<a onMouseOver="return overlib(\'<?php print $emerg;?>\', ABOVE, LEFT);"onMouseOut="return nd();"><?php print $abv[$c];?></a>';
														<?php }else{?>
														btn_eli='<a  onclick="alertify.confirm(\'Confirma que desea eliminar la actividad?\', function(e){if(e){ejecutar_ajax(\'calificacion/eli_actividad.php\',\'hdn_id_clase, sel_filtro_cal, hdn_id_asignatura, hdn_id_actividad_<?php print $id_actividad[$c];?>, sel_filtro_tip\',\'contenido_grid_calificaciones\')}else {alertify.error(\'Has pulsado \' + alertify.labels.cancel);}});"><img width=14px src=<?php print $x."img/general/mini_eliminar.png";?>></a>';
														btn_mod='<a href="#modal_mod_actividad" onclick="ejecutar_ajax(\'calificacion/modal_mod_actividad.php\',\'hdn_id_clase, sel_filtro_cal, hdn_id_asignatura, hdn_id_actividad_<?php print $id_actividad[$c];?>\',\'modal_mod_actividad\')" onMouseOver="return overlib(\'<?php print $emerg;?>\', ABOVE, LEFT);"onMouseOut="return nd();">&nbsp;&nbsp;<?php print $abv[$c];?>&nbsp;&nbsp;</a>';
														<?php }?>
													}
													else
													{
														btn_eli='';
														btn_mod='<a  onMouseOver="return overlib(\'<?php print $emerg;?>\', ABOVE, LEFT);"onMouseOut="return nd();"><?php print $abv[$c];?></a>';
													}
													emerg[<?php print $c;?>]=btn_mod+btn_eli;//alert('<?php print $actividad[$c].$c;?>');
										<?php
												}
											}
										?>
										
										valida_rango = function (value, callback) 
										{
											if(value=='0') 
											{alertify.error('Debe intertar notas entre 0.05 y 10 puntos.');callback(false);}
											else if((value<=<?php print $nota_maxima;?> && parseFloat(value)>=parseFloat(<?php print $nota_minima;?>)) || value==='') 
											{callback(true);}
											else
											{alertify.error('Debe intertar notas entre 0.05 y 10 puntos.');callback(false);}
										};
										
										var inHeadRenderer=function(instance, td, row, col, prop, value, cellProperties)
										{
											Handsontable.NumericCell.renderer.apply(this, arguments);		
											cellProperties.type = 'numeric';
											
											if (parseInt(value, 10) < <?php print $nota_aprobado;?>)
											td.style.color = 'red';
											else
											td.style.color = '#000';
										
											if(!value || value === '') 
											td.style.background = '#eee';
											else
											td.style.background = '';
										};

										var $container = $("#grid_calificaciones"),
										id_msg_cal = document.getElementById('msg_cal'),
										$parent = $container.parent(),
										autosaveNotification,
										tableLoaded=false,
										hot;

										hot = new Handsontable($container[0], 
										{
											data:<?php print json_encode($data);?>,
											maxRows: <?php print count($data);?>,
											rowHeaders: true,
											colHeaders: true,
											minSpareRows: 1,
											
											<?php if(substr($sel_filtro_cal, 0, 2)=="s_"){?>
											comments: true, contextMenu: true,contextMenu: ['commentsAddEdit'], 
											<?php } else {?>
											comments: false, contextMenu: false,
											<?php }?>
										
											fillHandle: 'vertical',											
											fixedColumnsLeft: 1,
	
											colHeaders:['Estudiantes'
											<?php for($c=1;$c<count($id_actividad);$c++){?>,emerg[<?php print $c;?>]<?php }?>
											],
											
											colWidths:[300
											<?php for($c=1;$c<count($id_actividad);$c++){?>, 40 <?php }?>
											],

											columns:[{readOnly: true, className: "htLeft", renderer: "html"}
											,{readOnly: true, className: "htRight", allowInvalid: true}
											<?php for($c=2;$c<count($id_actividad);$c++){print $column[$c];}?>
											],
																				
											cells:function (td, row, col, prop) {
											var cellProperties = {};
											 
											if (col >= 1)
											{
												cellProperties.type = 'numeric',
												cellProperties.format='0,0.00',//validator: valida_rango, allowInvalid: false
												cellProperties.validator = valida_rango,
												cellProperties.renderer = inHeadRenderer;
											}
											
											return cellProperties;
											},

											afterChange: function (change, source) 
											{
												var data, filas='';												
												cambios = String(change).split(",");//alert(change);
												
												if(source != 'loadData' && source != 'celda_promedio')
												{
													change=change+','+document.frm.hdn_id_clase.value;
													change=change+','+document.frm.sel_filtro_cal.value;
													change=change+','+document.frm.hdn_id_asignatura.value;
													change=change+','+document.frm.sel_filtro_tip.value;

													$.ajax(
													{
														url: 'calificacion/guardar_nota.php',
														data: {changes: change}, // returns all cells' data
														dataType: 'json',
														type: 'POST',
														success: function (res) 
														{//alert(res);
															if (res.result === 'ok')
															{
																id_msg_cal.innerHTML='<img width=24px src="../../../img/general/ajax_loader.gif">';
																setTimeout(function(){id_msg_cal.innerHTML='<img width=24px src="../../../img/general/ok.png">';}, 500);
															}
															else 
															{
																id_msg_cal.innerHTML='<img width=24px src="../../../img/general/error.png">';
																setTimeout(function(){id_msg_cal.innerHTML='';}, 1000);
															}
															
															//----------------------------------------------------------------------
															for (i=0;i<(cambios.length);i+=4) 
															{
																if(filas=='')
																filas=cambios[0];
																else
																filas=filas+','+cambios[i];
															}
															
															array_filas = String(filas).split(",");//id_msg='';
															
															if(document.frm.sel_filtro_cal.value.substring(0, 2)=="s_")
															{	
																if(array_filas.length>1)
																ejecutar_ajax('calificacion/actualizar_grid.php','hdn_id_clase, sel_filtro_cal, hdn_id_asignatura, sel_filtro_tip', 'contenido_grid_calificaciones', function(){sel();});
																else
																calc_promedio('calificacion/calcular_promedio_sub.php','hdn_id_clase, sel_filtro_cal, hdn_id_asignatura, sel_filtro_tip', filas);
															}
															else if(document.frm.sel_filtro_cal.value.substring(0, 2)=="p_")
															{
																if(array_filas.length>1)
																ejecutar_ajax('calificacion/actualizar_grid.php','hdn_id_clase, sel_filtro_cal, hdn_id_asignatura, sel_filtro_tip', 'contenido_grid_calificaciones', function(){sel();});
																else
																calc_promedio('calificacion/calcular_promedio_per.php','hdn_id_clase, sel_filtro_cal, hdn_id_asignatura', filas);
															}
															else if(document.frm.sel_filtro_cal.value.substring(0, 2)=="l_")
															ejecutar_ajax('calificacion/actualizar_grid.php','hdn_id_clase, sel_filtro_cal, hdn_id_asignatura, sel_filtro_tip', 'contenido_grid_calificaciones', function(){sel();});
															//----------------------------------------------------------------------
	
														},
														error: function () 
														{
															id_msg_cal.innerHTML='<img width=24px src="../../../img/general/error.png">';
															setTimeout(function(){id_msg_cal.innerHTML='';}, 1000);
														}
													});
												}
							
											},
											
											cell: [<?php print $comment;?>],
											
											afterSetCellMeta: function (row, col, key, val)
											{
												if(tableLoaded)
												{
													<?php if($cerrado==1){?>
													document.frm.hdn_comment.value=val;
													<?php }else{?>
													document.frm.hdn_comment.value=val;
													ejecutar_ajax('calificacion/guardar_calificacion_obs.php','hdn_comment, hdn_row_col_cal_'+row+'_'+col,'');
													<?php }?>
												}
											},
											
											afterSelectionEnd: function (e) 
											{
												var selection = hot.getSelected();
												document.frm.row.value=selection[0];
												document.frm.col.value=selection[1];
											}
										});	

										function sel()
										{
											row=parseInt(document.frm.row.value);
											col=parseInt(document.frm.col.value);
											hot.selectCell(row, col);
										}
										
										tableLoaded=true;
										</script>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_est_notas($db, $mod, $sel_filtro_cal, $id_asignatura, $sel_filtro_tip)
	{
		//$varios_arreglos=$this->consulta_est_notas_S($db, $mod, $sel_filtro_cal);
		
		$tipo=substr($sel_filtro_cal, 0, 2);
		$sel_filtro_cal=substr($sel_filtro_cal, 2, strlen($sel_filtro_cal));
		
		if($tipo=='l_')
		$varios_arreglos=$this->consulta_est_notas_l($db, $mod, $sel_filtro_cal, $id_asignatura);
		
		elseif($tipo=='p_')
		$varios_arreglos=$this->consulta_est_notas_p($db, $mod, $sel_filtro_cal, $id_asignatura);

		else
		$varios_arreglos=$this->consulta_est_notas_s($db, $mod, $sel_filtro_cal, $sel_filtro_tip);
		
		return $varios_arreglos;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_est_notas_l($db, $mod, $sel_filtro_cal, $id_asignatura)
	{	
		$inicial=2;
		$datos[0][0]='0';
		$actividad[0]='Promedio';
		$id_actividad[0]='0';//$id_actividad[1]='p_0';
		$abv[0]='0';
		$descripcion[0]='Promedio';
		$fecha[0]='0';
		$colunm='';
		$varios_arreglos[0]='0';
		
		$sql_nota="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_academica WHERE activa='1'";//print $sql_nota.'<br>';
		$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
		
		$nota_aprobado=$rs_nota->fields['nota_aprobado'];

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
		AND n_conf_academica.activa='1' ORDER BY n_exa_adicional_lectivo.orden";//print $sql_l_adic;die();//, actividad.fecha
		$rs_l_adic=$db->Execute($sql_l_adic) or die($db->ErrorMsg());
		
		$sql_avance="SELECT cerrado FROM cierre_periodo_lectivo WHERE 1 AND id_periodo_lectivo='".$sel_filtro_cal."' AND id_clase='".$mod."'";//print $sql_f;die();
		$rs_avance=$db->Execute($sql_avance) or die($db->ErrorMsg());
		$cerrado=$rs_avance->fields['cerrado'];
		
		$sql_est="SELECT estudiante.id_estudiante, clase_estudiante.id_clase_estudiante, clase_estudiante.retirado, concat(per_estudiante.primer_apellido,' ',per_estudiante.segundo_apellido,' ',per_estudiante.primer_nombre,' ',per_estudiante.segundo_nombre) AS estudiante
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
		AND n_periodo_academico.activo='1' AND clase.id_clase='".$mod."'";//print $sql_est;
		$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
		
		$rs_est->MoveFirst();		
		for($e=0;$e<$rs_est->RecordCount();$e++)
		{
			$familiares=$this->datos_familiares($db, $rs_est->fields['id_estudiante']);
			$estudiante='<a onMouseOver="return overlib(\''.$familiares.'\', ABOVE, RIGHT);"onMouseOut="return nd();">'.$rs_est->fields['estudiante'].'</a>';
			
			$retirado=$rs_est->fields['retirado'];
			
			if($retirado=='1')
			$datos[$e][0]='<strike style="color:red;">'.$estudiante.'</strike>';
			else 
			$datos[$e][0]=$estudiante;
				
			$id_clase_estudiante=$rs_est->fields['id_clase_estudiante'];
			
			//-----------------PROMEDIOS DE PERIODOS-----------------
			$promedio_p=$this->calcular_prom_periodos($db, $id_clase_estudiante, $sel_filtro_cal);
			
			$ini_per=count($promedio_p['periodo_evaluativo'])+$inicial;
			$ini_per_lec=$rs_l->RecordCount()+count($promedio_p['periodo_evaluativo'])+$inicial;
			$ini_per_lec_adic=$rs_l_adic->RecordCount()+$rs_l->RecordCount()+count($promedio_p['periodo_evaluativo'])+$inicial+1;
			
			$actividad[1]=$promedio_p['lectivo'][0];
			$abv[1]=$promedio_p['abv_lectivo'][0];

			for($p=$inicial;$p<count($promedio_p['periodo_evaluativo'])+$inicial;$p++)
			{
				$id_actividad[$p]='p_'.$promedio_p['id_periodo_evaluativo'][$p];
				$actividad[$p]=$promedio_p['periodo_evaluativo'][$p];
				$abv[$p]=$promedio_p['abv_periodo'][$p];	
				$column[$p]=',{readOnly: true, className: "htRight", allowInvalid: true}';
				
				if($promedio_p['promedio'][$p]!='')
				$datos[$e][$p]=number_format(round($promedio_p['promedio'][$p], 2), 2, ".", "");
				else
				$datos[$e][$p]='';
			}
			//-----------------PROMEDIOS DE PERIODOS-----------------
			
			//-----------------NOTAS-----------------			
			$rs_l->MoveFirst();
			$suma_peso_l='';$suma_nota_peso_l='';			
			for($l=$ini_per;$l<$ini_per_lec;$l++)
			{				
				$id_actividad[$l]='l_'.$rs_l->fields['id_examen_periodo_lec'];
				$actividad[$l]=$rs_l->fields['examen_lec'];
				$abv[$l]=$rs_l->fields['abv_tipo_examen_lec'];
				
				$sql_nota="SELECT nota, peso FROM nota_examen_periodo_lec, n_examen_periodo_lec
				WHERE nota_examen_periodo_lec.id_examen_periodo_lec=n_examen_periodo_lec.id_examen_periodo_lec 
				AND n_examen_periodo_lec.id_examen_periodo_lec='".$rs_l->fields['id_examen_periodo_lec']."' 
				AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_nota.'<br>';
				$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
				
				if(isset($rs_nota->fields['nota']))
				{
					$datos[$e][$l]=number_format(round($rs_nota->fields['nota'], 2), 2, ".", "");//print $e.' - '.$a;
					$peso=$rs_nota->fields['peso'];					
					$suma_peso_l=bcadd($suma_peso_l, $peso, 14);
					$nota_peso_l=bcmul($rs_nota->fields['nota'], $peso/100, 14);
					$suma_nota_peso_l=bcadd($suma_nota_peso_l, $nota_peso_l, 14);
				}
				else
				$datos[$e][$l]='';
				
				if($cerrado==1)$column[$l]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false, readOnly: true}';else $column[$l]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false}';
				
			$rs_l->MoveNext();
			}
			//-----------------NOTAS-----------------
			
			//-----------------PROMEDIO-----------------
			$promedio_l=$this->calcular_prom_periodo_aux($suma_peso_l, $promedio_p['promedio_l'][0], $suma_nota_peso_l);//die();
			$promedio_periodo=$promedio_l;
			//-----------------PROMEDIO-----------------
		
			//-----------------ADICIONAL-----------------
			//$promedio_periodo=0;
			$rs_l_adic->MoveFirst();
			for($d=$ini_per_lec;$d<$ini_per_lec_adic;$d++)
			{	
				$id_actividad[$d]='l_adic'.$rs_l_adic->fields['id_exa_adicional_lectivo'];
				$actividad[$d]=$rs_l_adic->fields['examen_adicional'];//print $actividad[$d].$d;
				$abv[$d]=$rs_l_adic->fields['abv_examen'];
				if($cerrado==1)$column[$d]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false, readOnly: true}';else $column[$d]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false}';
				
				$sql_l_nota_adic="SELECT nota, opcional, publica_nota
				FROM nota_exa_adicional_lectivo, n_examen_adicional, n_tipo_examen, n_exa_adicional_lectivo, n_examen_periodo_lec, n_periodo_lectivo, n_conf_academica
				WHERE 1
				AND nota_exa_adicional_lectivo.id_exa_adicional_lectivo=n_exa_adicional_lectivo.id_exa_adicional_lectivo
				AND n_examen_adicional.id_examen_adicional=n_exa_adicional_lectivo.id_examen_adicional
				AND n_tipo_examen.id_tipo_examen=n_exa_adicional_lectivo.id_tipo_examen
				AND n_exa_adicional_lectivo.id_examen_periodo_lec=n_examen_periodo_lec.id_examen_periodo_lec
				AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
				AND n_examen_periodo_lec.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
				AND n_periodo_lectivo.id_periodo_lectivo='".$sel_filtro_cal."'
				AND n_examen_periodo_lec.id_asignatura='".$id_asignatura."'
				AND n_exa_adicional_lectivo.id_exa_adicional_lectivo='".$rs_l_adic->fields['id_exa_adicional_lectivo']."'
				AND n_conf_academica.activa='1' 
				AND id_clase_estudiante='".$id_clase_estudiante."'
				ORDER BY n_exa_adicional_lectivo.orden";//print $sql_l_nota_adic.'                       <br> ';//die();//, actividad.fecha
				$rs_l_nota_adic=$db->Execute($sql_l_nota_adic) or die($db->ErrorMsg());
				
				if(isset($rs_l_nota_adic->fields['nota']))
				{
					$datos[$e][$d]=number_format(round($rs_l_nota_adic->fields['nota'], 2), 2, ".", "");//print $e.' - '.$a;
					if($rs_l_nota_adic->fields['opcional']==1)
					{
						if($promedio_l>$rs_l_nota_adic->fields['nota'])
						$promedio_periodo=$promedio_l;
						else
						$promedio_periodo=$rs_l_nota_adic->fields['nota'];
					}
					else 
					{
						if($promedio_periodo<$nota_aprobado && $rs_l_nota_adic->fields['publica_nota']==0 && $promedio_periodo<$rs_l_nota_adic->fields['nota'] && $rs_l_nota_adic->fields['nota']>=7)
						$promedio_periodo=$nota_aprobado;//7 es el aprobado
						else if($promedio_periodo<$nota_aprobado && $rs_l_nota_adic->fields['publica_nota']==0 && $promedio_periodo<$rs_l_nota_adic->fields['nota'] && $rs_l_nota_adic->fields['nota']<7)
						$promedio_periodo=$rs_l_nota_adic->fields['nota'];
						else if($promedio_periodo<$nota_aprobado && $rs_l_nota_adic->fields['publica_nota']==1 && $promedio_periodo<$rs_l_nota_adic->fields['nota'])
						$promedio_periodo=$rs_l_nota_adic->fields['nota'];
					}
				}
				else
				$datos[$e][$d]='';
				
			$rs_l_adic->MoveNext();
			}// tipo_examen, opcional
			//-----------------ADICIONAL-----------------
		
			//-----------------PROMEDIO-----------------
			if($promedio_periodo!=0)
			$datos[$e][1]=$promedio_periodo;
			else
			$datos[$e][1]='';
			//-----------------PROMEDIO-----------------

		$rs_est->MoveNext();
		}
	
		for($d=0;$d<count($datos);$d++){$data[$d]=$datos[$d];}
		
		$varios_arreglos=array();
		$varios_arreglos[0]=array('actividad'=>$actividad,'abv'=>$abv,'descripcion'=>$descripcion,'datos'=>$datos,'data'=>$data,'id_actividad'=>$id_actividad,'fecha'=>$fecha,'column'=>$column,'cerrado'=>$cerrado);//print count($data);
		
		return $varios_arreglos;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_est_notas_p($db, $mod, $sel_filtro_cal, $id_asignatura)
	{
		$inicial=2;
		$datos[0][0]='0';
		$actividad[0]='Promedio';
		$id_actividad[0]='p_0';$id_actividad[1]='p_0';
		$abv[0]='0';
		$descripcion[0]='Promedio';
		$fecha[0]='0';
		$column='';
		$varios_arreglos[0]='0';
		
		$sql_nota="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_academica WHERE activa='1'";//print $sql_nota.'<br>';
		$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
		
		$nota_aprobado=$rs_nota->fields['nota_aprobado'];

		$sql_p="SELECT id_examen_periodo_eval, examen_eval, abv_tipo_examen_eval, peso
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
		
		$sql_avance="SELECT cerrado FROM cierre_periodo_evaluativo WHERE 1 AND id_periodo_evaluativo='".$sel_filtro_cal."' AND id_clase='".$mod."'";//print $sql_avance;die();
		$rs_avance=$db->Execute($sql_avance) or die($db->ErrorMsg());
		$cerrado=$rs_avance->fields['cerrado'];
		
		$sql_est="SELECT estudiante.id_estudiante, clase_estudiante.id_clase_estudiante, clase_estudiante.retirado, concat(per_estudiante.primer_apellido,' ',per_estudiante.segundo_apellido,' ',per_estudiante.primer_nombre,' ',per_estudiante.segundo_nombre) AS estudiante
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
		AND n_periodo_academico.activo='1' AND clase.id_clase='".$mod."'";//print $sql_est;
		$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
		
		$rs_est->MoveFirst();		
		for($e=0;$e<$rs_est->RecordCount();$e++)
		{
			$familiares=$this->datos_familiares($db, $rs_est->fields['id_estudiante']);
			$estudiante='<a onMouseOver="return overlib(\''.$familiares.'\', ABOVE, RIGHT);"onMouseOut="return nd();">'.$rs_est->fields['estudiante'].'</a>';
			
			$retirado=$rs_est->fields['retirado'];
			
			if($retirado=='1')
			$datos[$e][0]='<strike style="color:red;">'.$estudiante.'</strike>';
			else 
			$datos[$e][0]=$estudiante;
					
			$id_clase_estudiante=$rs_est->fields['id_clase_estudiante'];
			
			//-----------------PROMEDIOS DE SUBPERIODOS-----------------
			$promedio_s=$this->calcular_prom_subperiodos($db, $id_clase_estudiante, $sel_filtro_cal);//die();
			
			$ini_sub=count($promedio_s['subperiodo_evaluativo'])+$inicial;
			$ini_sub_per=$rs_p->RecordCount()+count($promedio_s['subperiodo_evaluativo'])+$inicial;
			$ini_sub_per_adic=$rs_p_adic->RecordCount()+$rs_p->RecordCount()+count($promedio_s['subperiodo_evaluativo'])+$inicial;
			
			$actividad[1]=$promedio_s['periodo'][0];
			$abv[1]=$promedio_s['abv'][0];

			for($s=$inicial;$s<count($promedio_s['subperiodo_evaluativo'])+$inicial;$s++)
			{
				$id_actividad[$s]='s_'.$promedio_s['id_subperiodo_evaluativo'][$s];
				$actividad[$s]=$promedio_s['subperiodo_evaluativo'][$s];
				$abv[$s]=$promedio_s['abv_subperiodo'][$s];	
				$column[$s]=',{readOnly: true, className: "htRight", allowInvalid: true}';
				
				if($promedio_s['promedio'][$s]!='')
				$datos[$e][$s]=number_format(round($promedio_s['promedio'][$s], 2), 2, ".", "");
				else
				$datos[$e][$s]='';
			}
			//-----------------PROMEDIOS DE SUBPERIODOS-----------------
			
			//-----------------NOTAS-----------------			
			$rs_p->MoveFirst();
			$suma_peso_p='';$suma_nota_peso_p='';			
			for($p=$ini_sub;$p<$ini_sub_per;$p++)
			{				
				$id_actividad[$p]='p_'.$rs_p->fields['id_examen_periodo_eval'];
				$actividad[$p]=$rs_p->fields['examen_eval'];
				$abv[$p]=$rs_p->fields['abv_tipo_examen_eval'];
				
				$sql_nota="SELECT nota, peso FROM nota_examen_periodo_eval, n_examen_periodo_eval
				WHERE nota_examen_periodo_eval.id_examen_periodo_eval=n_examen_periodo_eval.id_examen_periodo_eval 
				AND n_examen_periodo_eval.id_examen_periodo_eval='".$rs_p->fields['id_examen_periodo_eval']."' 
				AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_nota.'<br>';
				$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
				
				if(isset($rs_nota->fields['nota']))
				{
					if($rs_nota->fields['nota']!='')
					{//print $rs_nota->fields['nota'].'   ';
						$datos[$e][$p]=number_format(round($rs_nota->fields['nota'], 2), 2, ".", "");//print $e.' - '.$a;
						$peso=$rs_nota->fields['peso'];
						
						$suma_peso_p=bcadd($suma_peso_p, $peso, 14);
						$nota_peso_p=bcmul($rs_nota->fields['nota'], $peso/100, 14);
						$suma_nota_peso_p=bcadd($suma_nota_peso_p, $nota_peso_p, 14);
					}
				}
				else
				$datos[$e][$p]='';
				
				if($cerrado==1)$column[$p]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false, readOnly: true}';else $column[$p]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false}';
				
			$rs_p->MoveNext();
			}
			//-----------------NOTAS-----------------
			
			//-----------------PROMEDIO-----------------
			$promedio_p=$this->calcular_prom_periodo_aux($suma_peso_p, $promedio_s['promedio_p'][0], $suma_nota_peso_p);//print $suma_peso_p.'   -   '.$e.'   pp   '.$promedio_s['promedio_p'][0];//die();
			$promedio_periodo=$promedio_p;
			//-----------------PROMEDIO-----------------
			
			//-----------------ADICIONAL-----------------
			//$promedio_periodo=0;
			$rs_p_adic->MoveFirst();
			for($d=$ini_sub_per;$d<$ini_sub_per_adic;$d++)
			{	
				$id_actividad[$d]='p_adic'.$rs_p_adic->fields['id_exa_adicional_periodo'];
				$actividad[$d]=$rs_p_adic->fields['examen_adicional'];//print $actividad[$d].$d;
				$abv[$d]=$rs_p_adic->fields['abv_examen'];
				if($cerrado==1)$column[$d]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false, readOnly: true}';else $column[$d]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false}';
				
				$sql_p_nota_adic="SELECT nota, opcional, publica_nota
				FROM nota_exa_adicional_periodo, n_examen_adicional, n_tipo_examen, n_exa_adicional_periodo, n_examen_periodo_eval, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
				WHERE 1
				AND nota_exa_adicional_periodo.id_exa_adicional_periodo=n_exa_adicional_periodo.id_exa_adicional_periodo
				AND n_examen_adicional.id_examen_adicional=n_exa_adicional_periodo.id_examen_adicional
				AND n_tipo_examen.id_tipo_examen=n_exa_adicional_periodo.id_tipo_examen
				AND n_exa_adicional_periodo.id_examen_periodo_eval=n_examen_periodo_eval.id_examen_periodo_eval
				AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
				AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
				AND n_examen_periodo_eval.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
				AND n_periodo_evaluativo.id_periodo_evaluativo='".$sel_filtro_cal."'
				AND n_examen_periodo_eval.id_asignatura='".$id_asignatura."'
				AND n_exa_adicional_periodo.id_exa_adicional_periodo='".$rs_p_adic->fields['id_exa_adicional_periodo']."'
				AND n_conf_academica.activa='1' 
				AND id_clase_estudiante='".$id_clase_estudiante."'
				ORDER BY n_exa_adicional_periodo.orden";//print $sql_p_adic;die();//, actividad.fecha
				$rs_p_nota_adic=$db->Execute($sql_p_nota_adic) or die($db->ErrorMsg());
				
				if(isset($rs_p_nota_adic->fields['nota']))
				{
					if($rs_p_nota_adic->fields['nota']!='')
					{
						$datos[$e][$d]=number_format(round($rs_p_nota_adic->fields['nota'], 2), 2, ".", "");//print $e.' - '.$a;
						if($rs_p_nota_adic->fields['opcional']==1)
						{
							if($promedio_p>$rs_p_nota_adic->fields['nota'])
							$promedio_periodo=$promedio_p;
							else
							$promedio_periodo=$rs_p_nota_adic->fields['nota'];
						}
						else 
						{
							if($rs_p_nota_adic->fields['publica_nota']==0)
							$promedio_periodo=$nota_aprobado;//7 es el aprobado
							else
							$promedio_periodo=$rs_p_nota_adic->fields['nota'];
						}
					}
				}
				else
				$datos[$e][$d]='';
				
			$rs_p_adic->MoveNext();
			}// tipo_examen, opcional
			//-----------------ADICIONAL-----------------
			
			//-----------------PROMEDIO-----------------
			if($promedio_periodo!=0)
			$datos[$e][1]=$promedio_periodo;
			else
			$datos[$e][1]='';
			//-----------------PROMEDIO-----------------

		$rs_est->MoveNext();
		}
	
		for($d=0;$d<count($datos);$d++){$data[$d]=$datos[$d];}
		
		$varios_arreglos=array();
		$varios_arreglos[0]=array('actividad'=>$actividad,'abv'=>$abv,'descripcion'=>$descripcion,'datos'=>$datos,'data'=>$data,'id_actividad'=>$id_actividad,'fecha'=>$fecha,'column'=>$column,'cerrado'=>$cerrado);//print count($data);
		
		return $varios_arreglos;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_est_notas_s($db, $mod, $sel_filtro_cal, $sel_filtro_tip)
	{
		$datos[0][0]='0';
		$actividad[0]='Promedio';
		$id_actividad[0]='s_0';$id_actividad[1]='s_0';
		$abv[0]='0';
		$descripcion[0]='Promedio';
		$fecha[0]='0';
		$column='';
		$varios_arreglos[0]='0';
		$comment='';//{row: 0, col: 0, comment: ""}
		
		$sql_act="SELECT actividad.id_actividad, actividad.actividad_examen, actividad.descripcion, actividad.fecha, abv_tipo_actividad_examen
		FROM clase, actividad, n_periodo_academico,	empleado_academico, empleado, n_tipo_actividad
		WHERE 1
		AND n_tipo_actividad.id_tipo_actividad=actividad.id_tipo_actividad
		AND actividad.id_clase=clase.id_clase
		AND clase.id_periodo_academico=n_periodo_academico.id_periodo_academico
		AND clase.id_empleado_academico=empleado_academico.id_empleado_academico 
		AND empleado_academico.id_empleado=empleado.id_empleado 
		AND n_periodo_academico.activo='1' AND clase.id_clase='".$mod."' 
		AND n_tipo_actividad.id_subperiodo_evaluativo='".$sel_filtro_cal."'";//print $sql_act;
		
		if($sel_filtro_tip!='')		
		$sql_act=$sql_act." AND n_tipo_actividad.id_tipo_actividad='".$sel_filtro_tip."'";
		
		$sql_act=$sql_act." ORDER BY n_tipo_actividad.orden, actividad.fecha, actividad.id_actividad";//print $sql_act;
		$rs_act=$db->Execute($sql_act) or die($db->ErrorMsg());
		
		$sql_avance="SELECT cerrado FROM cierre_subperiodo_evaluativo WHERE 1 AND id_subperiodo_evaluativo='".$sel_filtro_cal."' AND id_clase='".$mod."'";//print $sql_f;die();
		$rs_avance=$db->Execute($sql_avance) or die($db->ErrorMsg());
		$cerrado=$rs_avance->fields['cerrado'];
		
		$sql_est="SELECT estudiante.id_estudiante, clase_estudiante.id_clase_estudiante, clase_estudiante.fecha_entrada, clase_estudiante.fecha_salida, clase_estudiante.retirado, concat(per_estudiante.primer_apellido,' ',per_estudiante.segundo_apellido,' ',per_estudiante.primer_nombre,' ',per_estudiante.segundo_nombre) AS estudiante
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
		AND n_periodo_academico.activo='1' AND clase.id_clase='".$mod."'";//print $sql_est;
		$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
		
		$rs_est->MoveFirst();		
		for($e=0;$e<$rs_est->RecordCount();$e++)
		{
			$familiares=$this->datos_familiares($db, $rs_est->fields['id_estudiante']);
			$estudiante='<a onMouseOver="return overlib(\''.$familiares.'\', ABOVE, RIGHT);"onMouseOut="return nd();">'.$rs_est->fields['estudiante'].'</a>';
			
			$retirado=$rs_est->fields['retirado'];
			
			if($retirado==1)
			$datos[$e][0]='<strike style="color:red;">'.$estudiante.'</strike>';
			else 
			$datos[$e][0]=$estudiante;
			
			$id_clase_estudiante=$rs_est->fields['id_clase_estudiante'];
			$fecha_ingreso_clase=$rs_est->fields['fecha_entrada'];//print $fecha_ingreso_clase;
			$fecha_salida=$rs_est->fields['fecha_salida'];			
			
			//-----------------PROMEDIO-----------------
			$promedio_s=$this->calcular_prom_subperiodo($db, $id_clase_estudiante, $sel_filtro_cal, $sel_filtro_tip);
			
			$actividad[1]=$promedio_s['subperiodo'];
			$abv[1]=$promedio_s['abv'];
			
			if($promedio_s['promedio']!='')
			$datos[$e][1]=number_format(round($promedio_s['promedio'], 2), 2, ".", "");
			else
			$datos[$e][1]='';
			//-----------------PROMEDIO-----------------
			
			//-----------------NOTAS-----------------
			$rs_act->MoveFirst();
			for($a=2;$a<$rs_act->RecordCount()+2;$a++)
			{
				$id_actividad[$a]='s_'.$rs_act->fields['id_actividad'];
				$actividad[$a]=$rs_act->fields['actividad_examen'];
				$descripcion[$a]=$rs_act->fields['descripcion'];
				$fecha[$a]=$rs_act->fields['fecha'];
				$abv[$a]=$rs_act->fields['abv_tipo_actividad_examen'];
				$id=$rs_est->fields['id_clase_estudiante'].'_'.$rs_act->fields['id_actividad'];
				if($cerrado==1)$column[$a]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false, readOnly: true}';else $column[$a]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false}';
				$row_col=$e.'_'.$a;
				?>
				
				<input name="hdn_row_col_cal_<?php print $row_col;?>" id="hdn_row_col_cal_<?php print $row_col;?>" type="hidden" value="<?php print $id;?>"/>
					
				<?php
				if($retirado==0)
				{
					$fecha_salida='';
					if($fecha_ingreso_clase<$rs_act->fields['fecha'])//se valida por si el estudiante entró a mitad del curso
					{
						$sql_nota="SELECT nota, observacion FROM nota_actividad_examen WHERE id_actividad='".$rs_act->fields['id_actividad']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $sql_nota.'<br>';
						$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
						
						if(isset($rs_nota->fields['nota']))
						{
							$datos[$e][$a]=number_format(round($rs_nota->fields['nota'], 2), 2, ".", "");//print $e.' - '.$a;
						}
						else
						$datos[$e][$a]='';
						
						//if($cerrado==1)$column[$a]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false, readOnly: true}';else $column[$a]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false}';
						
						if($rs_nota->fields['observacion']!='')
						{
							$obs=str_replace( array("\\", "¨", "~", "|", "\"", "·", "$", "&", "?", "'", "¿", "[", "^", "`", "]", "}", "{", "¨", "´", ">“, “< ", ";"), '', $rs_nota->fields['observacion']);
							$obs=str_replace( array("\n"), '\\n', $obs);
							
							if($comment=='')
							$comment='{row: '.$e.', col: '.$a.', comment: "'.$obs.'"}';
							else
							$comment=$comment.',{row: '.$e.', col: '.$a.', comment: "'.$obs.'"}';				
						}
					}
					else
					{
						$datos[$e][$a]="-";
						if($comment=='')
						$comment='{row: '.$e.', col: '.$a.', readOnly: true, comment: "El estudiante se agreg\u00F3 a la clase el: '.$fecha_ingreso_clase.', por tanto00ppp no puede editar este dato."}';
						else
						$comment=$comment.',{row: '.$e.', col: '.$a.', readOnly: true, comment: "El estudiante se agreg\u00F3 a la clase el: '.$fecha_ingreso_clase.', por tanto00ppp no puede editar este dato."}';
					}
				}
				elseif($retirado==1)
				{
					if($fecha_ingreso_clase<$rs_act->fields['fecha'] AND $fecha_salida>$rs_act->fields['fecha'])//se valida por si el estudiante entró a mitad del curso
					{
						$sql_nota="SELECT nota, observacion FROM nota_actividad_examen WHERE id_actividad='".$rs_act->fields['id_actividad']."' AND id_clase_estudiante='".$rs_est->fields['id_clase_estudiante']."'";//print $sql_nota.'<br>';
						$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
						
						if(isset($rs_nota->fields['nota']))
						{
							$datos[$e][$a]=number_format(round($rs_nota->fields['nota'], 2), 2, ".", "");//print $e.' - '.$a;
						}
						else
						$datos[$e][$a]='';
						
						//if($cerrado==1)$column[$a]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false, readOnly: true}';else $column[$a]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false}';
						
						if($rs_nota->fields['observacion']!='')
						{
							$obs=str_replace( array("\\", "¨", "~", "|", "\"", "·", "$", "&", "?", "'", "¿", "[", "^", "`", "]", "}", "{", "¨", "´", ">“, “< ", ";"), '', $rs_nota->fields['observacion']);
							$obs=str_replace( array("\n"), '\\n', $obs);
							
							if($comment=='')
							$comment='{row: '.$e.', col: '.$a.', comment: "'.$obs.'"}';
							else
							$comment=$comment.',{row: '.$e.', col: '.$a.', comment: "'.$obs.'"}';				
						}
					}
					else
					{
						$datos[$e][$a]="-";
						if($comment=='')
						$comment='{row: '.$e.', col: '.$a.', readOnly: true, comment: "El estudiante se agreg\u00F3 a la clase el: '.$fecha_ingreso_clase.' y sali\u00F3 el: '.$fecha_salida.', por tanto11 no puede editar este dato."}';
						else
						$comment=$comment.',{row: '.$e.', col: '.$a.', readOnly: true, comment: "El estudiante se agreg\u00F3 a la clase el: '.$fecha_ingreso_clase.' y sali\u00F3 el: '.$fecha_salida.', por tanto11 no puede editar este dato."}';
					}
				}
				
			$rs_act->MoveNext();
			}
			//-----------------NOTAS-----------------
		$rs_est->MoveNext();
		}

		for($d=0;$d<count($datos);$d++){$data[$d]=$datos[$d];}
		
		$varios_arreglos=array();
		$varios_arreglos[0]=array('actividad'=>$actividad,'abv'=>$abv,'descripcion'=>$descripcion,'datos'=>$datos,'data'=>$data,'id_actividad'=>$id_actividad,'fecha'=>$fecha,'column'=>$column,'comment'=>$comment,'cerrado'=>$cerrado);//print count($data);
		
		for($i=0;$i<count($id_actividad);$i++)
		{
		?>
			<input name="hdn_id_actividad_<?php print $id_actividad[$i];?>" title='<?php print $i;?>' id="hdn_id_actividad_<?php print $id_actividad[$i];?>" type="hidden" value="<?php print $id_actividad[$i];?>"/>
		<?php 
		}		
		
		return $varios_arreglos;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
		
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function filtro_calificaciones($db, $rs_sub, $sel_filtro_cal, $id_asignatura, $id_clase)
	{
		$tipo=substr($sel_filtro_cal, 0, 2);
		
		if($tipo=='s_')
		{
			$id_subperiodo_evaluativo=substr($sel_filtro_cal, 2, strlen($sel_filtro_cal));
			
			$sql_abv="SELECT DISTINCT n_tipo_actividad.id_tipo_actividad, abv_tipo_actividad_examen, tipo_actividad_examen, n_tipo_actividad.peso
			FROM n_tipo_actividad, n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
			WHERE 1
			AND n_tipo_actividad.id_subperiodo_evaluativo=n_subperiodo_evaluativo.id_subperiodo_evaluativo
			AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
			AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
			AND n_conf_academica.id_conf_academica=n_periodo_lectivo.id_conf_academica
			AND n_conf_academica.id_conf_academica='1'  
			AND n_tipo_actividad.id_asignatura='".$id_asignatura."'
			AND n_tipo_actividad.id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."'
			ORDER BY n_tipo_actividad.orden";//print $sql_abv;
			$rs_abv=$db->Execute($sql_abv) or die($db->ErrorMsg());
			
			$sql_avance="SELECT cerrado, subperiodo_evaluativo FROM cierre_subperiodo_evaluativo, n_subperiodo_evaluativo WHERE 1 AND cierre_subperiodo_evaluativo.id_subperiodo_evaluativo=n_subperiodo_evaluativo.id_subperiodo_evaluativo
			AND n_subperiodo_evaluativo.id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_clase='".$id_clase."'";//print $sql_avance;//die();
			$rs_avance=$db->Execute($sql_avance) or die($db->ErrorMsg());
			$rs_avance->MoveFirst();
			$cerrado=$rs_avance->fields['cerrado'];//print $cerrado;
		}
		elseif($tipo=='p_')
		{
			$id_periodo=substr($sel_filtro_cal, 2, strlen($sel_filtro_cal));
			
			$sql_avance="SELECT cerrado, periodo_evaluativo FROM cierre_periodo_evaluativo, n_periodo_evaluativo WHERE 1 AND cierre_periodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
			AND n_periodo_evaluativo.id_periodo_evaluativo='".$id_periodo."' AND id_clase='".$id_clase."'";//print $sql_avance.'<br>';
			$rs_avance=$db->Execute($sql_avance) or die($db->ErrorMsg());
			
			$cerrado=$rs_avance->fields['cerrado'];
		}
		elseif($tipo=='l_')
		{
			$id_periodo=substr($sel_filtro_cal, 2, strlen($sel_filtro_cal));
			
			$sql_avance="SELECT cerrado, periodo_lectivo FROM cierre_periodo_lectivo, n_periodo_lectivo WHERE 1 AND cierre_periodo_lectivo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
			AND n_periodo_lectivo.id_periodo_lectivo='".$id_periodo."' AND id_clase='".$id_clase."'";//print $sql_i.'<br>';
			$rs_avance=$db->Execute($sql_avance) or die($db->ErrorMsg());
			
			$cerrado=$rs_avance->fields['cerrado'];
		}
?>
		<div style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
			<div  style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
					
					<?php
					if($tipo=='s_')
					{
					?>
					<fieldset>
						<legend>Tipos de actividades y sus pesos</legend>
						<div style='display:table;width:100%;' >
							<div style='display:table-row;'>
								<div style='display:table-cell;width:100%;height:12px;text-align:left;padding-left:1%;'>
									<div id='btn_ins_act1'>
									<?php
										$rs_abv->MoveFirst();
										for($e=0;$e<$rs_abv->RecordCount();$e++)
										{
											print '<b>'.$rs_abv->fields['abv_tipo_actividad_examen'].': </b>'.$rs_abv->fields['tipo_actividad_examen'].' ('.$rs_abv->fields['peso'].'%)'.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';			
										$rs_abv->MoveNext();
										}
									?>
									</div>
								</div>	
							</div>
						</div>
					</fieldset>
					<?php
					}
					?>
					
					<br>
					
					<div class='tabla_filtro' style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
						<div class='tabla_filtro' style='display:table-row;'>
							<div style='display:table-cell;text-align:left;width:35%;padding:1%;'>
								<?php
									$callback="ejecutar_ajax3('calificacion/ocultar_btn_sub.php','sel_filtro_cal, hdn_id_clase', div, '')";
									$callback="ejecutar_ajax2('calificacion/reset_filtro_tip.php','sel_filtro_cal, hdn_id_asignatura', 'filtro_tip', ".$callback.")";
									$parametros_extras="onChange=\"
									str=document.frm.sel_filtro_cal.value;if(str.substr(0, 2)=='s_')div='btn_ins_sub';else div='btn_ins_sub2';
									document.frm.sel_filtro_tip.value='';
									ejecutar_ajax('calificacion/actualizar_grid.php','hdn_id_clase, sel_filtro_cal, hdn_id_asignatura, sel_filtro_tip', 'contenido_grid_calificaciones', ".$callback.");
									if(document.frm.sel_filtro_cal.value.substring(0, 2)=='s_')
									{
										ejecutar_ajax1('calificacion/filtrar_subperiodo.php','sel_filtro_cal, hdn_id_asignatura, hdn_id_clase', 'modal_insertar_actividad');
									}
									obj_btn_ins_act=document.getElementById('btn_ins_act');
									obj_btn_ins_act1=document.getElementById('btn_ins_act1');
									obj_btn_ins_sub2=document.getElementById('btn_ins_sub2');
									
									if(document.frm.sel_filtro_cal.value.substring(0, 2)=='s_')
									{
										obj_btn_ins_act.style.display='block';
										obj_btn_ins_act1.style.display='block';
										obj_btn_ins_sub2.style.display='none';
									}
									else 
									{
										obj_btn_ins_act.style.display='none';
										obj_btn_ins_act1.style.display='none';
										obj_btn_ins_sub2.style.display='block';
									}\"";
									
									$this->select_filtro_cal($db, $rs_sub, $sel_filtro_cal, $parametros_extras);
								?>								
							</div>
							
							
							
							<div id='btn_ins_act' <?php if($tipo=='p_' OR $tipo=='l_'){?>style='display:none;'<?php }?>>
							
								<div style='display:table-cell;text-align:left;width:35%;padding:1%;' id='filtro_tip'>
									<?php
										$parametros_extras="onChange=\"ejecutar_ajax('calificacion/actualizar_grid.php','hdn_id_clase, sel_filtro_cal, hdn_id_asignatura, sel_filtro_tip', 'contenido_grid_calificaciones');\"";
										if(isset($rs_abv))$this->select_filtro_tip($rs_abv, $parametros_extras);else $this->select_filtro_tip('', $parametros_extras);
									?>								
								</div>
							
								<div style='display:table-cell;width:2%;text-align:center;padding:1%;'>
									<?php $msg_fam='El c&aacute;lculo del promedio para cada estudiante es ponderado por los pesos de cada tipo de actividad o examen, si el estudiante no posee al menos una nota en alg&uacute;n tipo de actividad el c&aacute;lculo del promedio mostrado ser&aacute; el aritm&eacute;tico simple de cada tipo de actividad.';?>
									<a onMouseOver="return overlib('<?php print $msg_fam;?>', ABOVE, RIGHT);"onMouseOut="return nd();"><img src='<?php print "../../../img/general/help.png";?>'></a>
								</div>						
								
								<div style='display:table-cell;width:28%;text-align:center;padding:1%;' id='btn_ins_sub'>
									<?php if(isset($sel_filtro_cal) AND $cerrado=='0'){?>
										<a href="#modal_ins_actividad"><div class="boton" width="100px" height="22px" border="0"> + Insertar actividad </div></a>
									<?php }
									else
									{
										print 'El '.$rs_avance->fields['subperiodo_evaluativo'].' est&aacute; bloqueado.';
									?>
										<img width="25px" src='<?php print "../../../img/acad/cierre_subperiodo_evaluativo/cerrado.png";?>'>
									<?php }?>
								</div>
								
							</div>
							
							<div style='display:table-cell;width:65%;text-align:right;padding:1%;display:none;' id='btn_ins_sub2'></div>
							
						</div>
					</div>
					
					
					
				</div>
			</div>
		</div>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function select_filtro_cal($db, $rs_sub, $sel_filtro_cal, $parametros_extras)
	{	
		$id_seleccionado=substr($sel_filtro_cal, 2, strlen($sel_filtro_cal));
		$tipo=substr($sel_filtro_cal, 0, 2);
?>
		<select name="sel_filtro_cal" class="sel_filtro_cal" title="Filtro" id="sel_filtro_cal" <?php print $parametros_extras;?>>
			<?php
			$id_periodo_lectivo='';
			$id_periodo_evaluativo='';
			$id_subperiodo_evaluativo='';
			
			$rs_sub->MoveFirst();
			for($m=0;$m<$rs_sub->RecordCount();$m++)
			{ 
			?>
				
				<?php if($id_periodo_lectivo!=$rs_sub->fields['id_periodo_lectivo']){$id_periodo_lectivo=$rs_sub->fields['id_periodo_lectivo'];?>
				<option value="l_<?php print $rs_sub->fields['id_periodo_lectivo']; ?>" <?php if($id_seleccionado!='' AND $tipo=='l_'){if($rs_sub->fields['id_periodo_lectivo']==$id_seleccionado){; ?> selected="selected"<?php }} ?> ><?php print $rs_sub->fields['periodo_lectivo'];?></option>
				<?php }if($id_periodo_evaluativo!=$rs_sub->fields['id_periodo_evaluativo']){$id_periodo_evaluativo=$rs_sub->fields['id_periodo_evaluativo'];?>
				<option value="p_<?php print $rs_sub->fields['id_periodo_evaluativo']; ?>" <?php if($id_seleccionado!='' AND $tipo=='p_'){if($rs_sub->fields['id_periodo_evaluativo']==$id_seleccionado){; ?> selected="selected"<?php }} ?>>&nbsp;&nbsp;&nbsp;<?php print $rs_sub->fields['periodo_evaluativo'];?></option>
				<?php }if($id_subperiodo_evaluativo!=$rs_sub->fields['id_subperiodo_evaluativo']){$id_subperiodo_evaluativo=$rs_sub->fields['id_subperiodo_evaluativo'];?>
				<option value="s_<?php print $rs_sub->fields['id_subperiodo_evaluativo']; ?>" <?php if($id_seleccionado!='' AND $tipo=='s_'){if($rs_sub->fields['id_subperiodo_evaluativo']==$id_seleccionado){; ?> selected="selected"<?php }} ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php print $rs_sub->fields['subperiodo_evaluativo'];?> </option>
				<?php }?>
				
			<?php 
			$rs_sub->MoveNext();
			} 
			?>
		</select>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function select_filtro_tip($rs_abv, $parametros_extras)
	{	
?>
		<select name="sel_filtro_tip" class="sel_filtro_tip" title="Filtro" id="sel_filtro_tip" <?php print $parametros_extras;?>>
			<option value=''>---------------------Cualquier tipo---------------------</option>
			<?php
			if($rs_abv!='')
			{
				$rs_abv->MoveFirst();
				for($t=0;$t<$rs_abv->RecordCount();$t++)
				{ 
				?>
					<option value="<?php print $rs_abv->fields['id_tipo_actividad']; ?>" <?php if(isset($sel_filtro_tip)){if($rs_abv->fields['id_tipo_actividad']==$sel_filtro_tip){; ?> selected="selected"<?php }} ?>><?php print '<b>'.$rs_abv->fields['abv_tipo_actividad_examen'].': </b>'.$rs_abv->fields['tipo_actividad_examen'].' ('.$rs_abv->fields['peso'].'%)';?></option>
				<?php 
				$rs_abv->MoveNext();
				}
			}
			?>
		</select>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function contenido_comportamientos($db, $mod)
	{
		$varios_arreglos=$this->consulta_est_notas_comp($db, $mod);
		
		$id_actividad=$varios_arreglos[0]['id_actividad'];
		$actividad=$varios_arreglos[0]['actividad'];
		$descripcion=$varios_arreglos[0]['descripcion'];
		
		$abv=$varios_arreglos[0]['abv'];		
		$datos=$varios_arreglos[0]['datos'];
		$data=$varios_arreglos[0]['data'];//print 'count'.count($id_actividad);
		$column=$varios_arreglos[0]['column'];
		$comment=$varios_arreglos[0]['comment'];
		$cerrado=$varios_arreglos[0]['cerrado'];
		$width=300+count($id_actividad)*40;
				
		$sql_nota="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_academica WHERE activa='1'";//print $sql_nota.'<br>';
		$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
		
		$nota_minima=$rs_nota->fields['nota_minima'];
		$nota_aprobado=$rs_nota->fields['nota_aprobado'];
		$nota_maxima=$rs_nota->fields['nota_maxima'];
?>
			<div style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
				
					<div id="container">
						<div class="columnLayout">
							<div class="rowLayout">
								<div class="descLayout">
									<div class="pad">
										<div id="msg_comp" style='float:right;'></div>
										<div id="grid_comportamientos" style="width: <?php print $width;?>px; height: 50%; overflow: hidden1;"></div>
									</div>
								</div>

								<div class="codeLayout">
									<div class="pad">
										<script>
										var emerg = new Array();//		alert(document.frm.sel_filtro_cal.value.substring(0, 2));
										<?php
											for($c=0;$c<count($id_actividad);$c++)
											{//print count($id_actividad);
												if($c==0)
												{
										?>
													emerg[<?php print $c;?>]='Estudiantes';
										<?php
												}
												elseif($c>=1)
												{
													$emerg='<b>Nombre: </b>'.$abv[$c].': '.$actividad[$c];
										?>
													btn_mod='<a  onMouseOver="return overlib(\'<?php print $emerg;?>\', ABOVE, RIGHT);"onMouseOut="return nd();"><?php print $abv[$c];?></a>';
													
													emerg[<?php print $c;?>]=btn_mod;//alert('<?php print $actividad[$c].$c;?>');
										<?php
												}
											}
										?>
										
										valida_rango = function (value, callback) 
										{
											if(value=='0') 
											{alertify.error('Debe intertar notas entre 0.05 y 10 puntos.');callback(false);}
											else if((value<=<?php print $nota_maxima;?> && parseFloat(value)>=parseFloat(<?php print $nota_minima;?>)) || value==='') 
											{callback(true);}
											else
											{alertify.error('Debe intertar notas entre 0.05 y 10 puntos.');callback(false);}
										};
										
										var inHeadRenderer=function(instance, td, row, col, prop, value, cellProperties)
										{
											Handsontable.NumericCell.renderer.apply(this, arguments);		
											cellProperties.type = 'numeric';
											
											if (parseInt(value, 10) < <?php print $nota_aprobado;?>)
											td.style.color = 'red';
											else
											td.style.color = '#000';
										
											if(!value || value === '') 
											td.style.background = '#eee';
											else
											td.style.background = '';
										};

										var $container = $("#grid_comportamientos"),
										id_msg = document.getElementById('msg_comp'),
										$parent = $container.parent(),
										autosaveNotification,
										tableLoaded=false,
										hot_comp;

										hot_comp = new Handsontable($container[0], 
										{
											data:<?php print json_encode($data);?>,
											maxRows: <?php print count($data);?>,
											rowHeaders: true,
											colHeaders: true,
											minSpareRows: 1,
											comments: false, 
											contextMenu: false,
											//contextMenu: ['commentsAddEdit'],										
										
											fillHandle: 'vertical',											
											fixedColumnsLeft: 1,
	
											colHeaders:['Estudiantes'
											<?php for($c=1;$c<count($id_actividad);$c++){?>,emerg[<?php print $c;?>]<?php }?>
											],
											
											colWidths:[300
											<?php for($c=1;$c<count($id_actividad);$c++){?>, 35 <?php }?>
											],

											columns:[{readOnly: true, className: "htLeft", renderer: "html"}
											,{readOnly: true, className: "htRight", allowInvalid: true}
											<?php for($c=2;$c<count($id_actividad);$c++){print $column[$c];}?>
											],
																				
											cells:function (td, row, col, prop) {
											var cellProperties = {};
											 
											if (col >= 1)
											{
												cellProperties.type = 'numeric',
												cellProperties.format='0,0.00',//validator: valida_rango, allowInvalid: false
												cellProperties.validator = valida_rango,
												cellProperties.renderer = inHeadRenderer;
											}
											
											return cellProperties;
											},

											afterChange: function (change, source) 
											{
												var data, filas='';												
												cambios = String(change).split(",");//alert(change);
												
												if(source != 'loadData' && source != 'celda_promedio')
												{
													change=change+','+document.frm.hdn_id_clase.value;
													change=change+','+document.frm.hdn_cadena_pos_s_comp.value;

													$.ajax(
													{
														url: 'comportamiento/guardar_nota.php',
														data: {changes: change}, // returns all cells' data
														dataType: 'json',
														type: 'POST',
														success: function (res) 
														{
															if (res.result === 'ok')
															{
																id_msg.innerHTML='<img width=24px src="../../../img/general/ajax_loader.gif">';
																setTimeout(function(){id_msg.innerHTML='<img width=24px src="../../../img/general/ok.png">';}, 500);
															}
															else 
															{
																id_msg.innerHTML='<img width=24px src="../../../img/general/error.png">';
																setTimeout(function(){id_msg.innerHTML='';}, 500);
															}
															
															//------------------------------------------------------------
															for (i=0;i<(cambios.length);i+=4) 
															{
																if(filas=='')
																filas=cambios[0];
																else
																filas=filas+','+cambios[i];
															}
															
															array_filas = String(filas).split(",");			
															ejecutar_ajax('comportamiento/actualizar_grid.php','hdn_id_clase', 'contenido_grid_comportamientos', function(){sel();});
															//------------------------------------------------------------
													
													
														},
														error: function () 
														{
															id_msg.innerHTML='<img width=24px src="../../../img/general/error.png">';
															setTimeout(function(){id_msg.innerHTML='';}, 500);
														}
													});
												}
											},
											
											/*cell: [<?php print $comment;?>],
											
											afterSetCellMeta: function (row, col, key, val)
											{
												if(tableLoaded)
												{													
													hdn_cadena_pos_s_comp = String(document.frm.hdn_cadena_pos_s_comp.value).split("-");
													hdn_cadena_cerrado_s_comp = String(document.frm.hdn_cadena_cerrado_s_comp.value).split("-");
													
													for (i=0;i<(hdn_cadena_pos_s_comp.length);i+=1)
													{													
														if(col==hdn_cadena_pos_s_comp[i])
														{
															if(hdn_cadena_cerrado_s_comp[i]==1)
															{
																document.frm.hdn_comment.value=val;
															}
															else
															{
																document.frm.hdn_comment.value=val;
																ejecutar_ajax('comportamiento/guardar_comportamiento_obs.php','hdn_comment,hdn_row_col_comp_'+row+'_'+col,'');
															}
														}
													}
												}
											},*/
											
											afterSelectionEnd: function (e) 
											{
												var selection = hot_comp.getSelected();//alert(selection);
												hdn_cadena_cerrado_s_comp = String(document.frm.hdn_cadena_cerrado_s_comp.value).split("-");
												//document.frm.row.value=selection[0];
												//document.frm.col.value=selection[1];//alert(selection[0]);alert(selection[1]);
												
												if(tableLoaded)
												{	
																								
													hdn_cadena_pos_s_comp = String(document.frm.hdn_cadena_pos_s_comp.value).split("-");
													hdn_cadena_cerrado_s_comp = String(document.frm.hdn_cadena_cerrado_s_comp.value).split("-");
													
													for (i=0;i<(hdn_cadena_pos_s_comp.length);i++)
													{	//alert('i: '+i);											
														if(selection[1]==hdn_cadena_pos_s_comp[i])
														{//alert('col: '+selection[1]);alert('cadena: '+hdn_cadena_pos_s_comp[i]);
															if(hdn_cadena_cerrado_s_comp[i]==0)
															{
																if(document.getElementById('hdn_row_col_comp_'+selection[0]+'_'+selection[1]))
																ejecutar_ajax('comportamiento/mostrar_obs_comportamiento.php','hdn_row_col_comp_'+selection[0]+'_'+selection[1],'div_comportamiento');
																break;
															}
															else
															div_comportamiento.innerHTML='';
														}
													}
												}
												
											}
										});	

										function sel()
										{
											row=parseInt(document.frm.row.value);
											col=parseInt(document.frm.col.value);
											hot_comp.selectCell(row, col);
										}
										
										tableLoaded=true;
										</script>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				
				
			</div>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_est_notas_comp($db, $mod)
	{
		$datos[0][0]='0';
		$actividad[0]='Promedio';
		$id_actividad[0]='s_0';$id_actividad[1]='s_0';
		$abv[0]='0';
		$descripcion[0]='Promedio';
		$fecha[0]='0';
		$column='';
		$varios_arreglos[0]='0';
		$comment='';//{row: 0, col: 0, comment: ""}
		$cerrado='';
		$pos=1;
		$cadena_pos_s='';
		$cadena_cerrado_s='';
		
		$suma_nota='';$cant_nota='';$suma_prom='';$cant_prom='';
		
		$sql_l="SELECT id_periodo_lectivo, periodo_lectivo
		FROM n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica		
		AND n_conf_academica.activa='1'";//print $sql_p;die();
		$rs_l=$db->Execute($sql_l) or die($db->ErrorMsg());
		
		for($l=0;$l<$rs_l->RecordCount();$l++)
		{
			$id_actividad[$pos]=$rs_l->fields['id_periodo_lectivo'];
			$actividad[$pos]=$rs_l->fields['periodo_lectivo'];
			$abv[$pos]='A&ntilde;o';
			$column[$pos]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false,readOnly: true}';
			$pos=$pos+1;
				
			$sql_p="SELECT id_periodo_evaluativo, periodo_evaluativo, abv_periodo
			FROM n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
			WHERE 1
			AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
			AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo		
			AND n_conf_academica.activa='1'
			AND n_periodo_evaluativo.id_periodo_lectivo='".$rs_l->fields['id_periodo_lectivo']."'";//print $sql_p;die();
			$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
			
			for($p=0;$p<$rs_p->RecordCount();$p++)
			{
				$id_actividad[$pos]=$rs_p->fields['id_periodo_evaluativo'];
				$actividad[$pos]=$rs_p->fields['periodo_evaluativo'];
				$abv[$pos]=$rs_p->fields['abv_periodo'];
				$column[$pos]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false,readOnly: true, comment: false}';
				$pos=$pos+1;
				
				$sql_s="SELECT id_subperiodo_evaluativo, subperiodo_evaluativo, abv_subperiodo
				FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
				WHERE 1
				AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
				AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
				AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
				AND n_conf_academica.activa='1'
				AND n_subperiodo_evaluativo.id_periodo_evaluativo='".$rs_p->fields['id_periodo_evaluativo']."'";//print $sql_p;die();
				$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
				
				for($s=0;$s<$rs_s->RecordCount();$s++)
				{
					$sql_avance="SELECT cerrado FROM cierre_subperiodo_evaluativo WHERE 1 AND id_subperiodo_evaluativo='".$rs_s->fields['id_subperiodo_evaluativo']."' AND id_clase='".$mod."'";//print $sql_f;die();
					$rs_avance=$db->Execute($sql_avance) or die($db->ErrorMsg());
					$cerrado=$rs_avance->fields['cerrado'];
					
					$id_actividad[$pos]=$rs_s->fields['id_subperiodo_evaluativo'];
					if($cerrado==1)$actividad[$pos]='El '.$rs_s->fields['subperiodo_evaluativo'].' est&aacute; bloqueado';else $actividad[$pos]=$rs_s->fields['subperiodo_evaluativo'];
					if($cerrado==1)$abv[$pos]=$rs_s->fields['abv_subperiodo'].' <img width=8px src=../../../img/acad/cierre_subperiodo_evaluativo/cerrado.png>';else $abv[$pos]=$rs_s->fields['abv_subperiodo'];
					
					if($cerrado==1)$column[$pos]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false, readOnly: true}';else $column[$pos]=',{format: "0.00",type: "numeric",className: "htRight", validator: valida_rango, allowInvalid: false, readOnly: true}';
					
						if($cadena_cerrado_s=='')
						$cadena_cerrado_s=$cerrado;
						else
						$cadena_cerrado_s=$cadena_cerrado_s.'-'.$cerrado;
						
						if($cadena_pos_s=='')
						$cadena_pos_s=$pos;
						else
						$cadena_pos_s=$cadena_pos_s.'-'.$pos;
						
					$pos=$pos+1;
					
				$rs_s->MoveNext();
				}
			
			$rs_p->MoveNext();
			}
			
		$rs_l->MoveNext();
		}
		
		$sql_est="SELECT estudiante.id_estudiante, clase_estudiante.id_clase_estudiante, clase_estudiante.retirado, concat(per_estudiante.primer_apellido,' ',per_estudiante.segundo_apellido,' ',per_estudiante.primer_nombre,' ',per_estudiante.segundo_nombre) AS estudiante
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
		AND n_periodo_academico.activo='1' AND clase.id_clase='".$mod."'";//print $sql_est;
		$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
		
		$rs_est->MoveFirst();		
		for($e=0;$e<$rs_est->RecordCount();$e++)
		{
			$familiares=$this->datos_familiares($db, $rs_est->fields['id_estudiante']);
			$estudiante='<a onMouseOver="return overlib(\''.$familiares.'\', ABOVE, RIGHT);"onMouseOut="return nd();">'.$rs_est->fields['estudiante'].'</a>';
			
			$retirado=$rs_est->fields['retirado'];
			
			if($retirado=='1')
			$datos[$e][0]='<strike style="color:red;">'.$estudiante.'</strike>';
			else 
			$datos[$e][0]=$estudiante;
			
			$id_clase_estudiante=$rs_est->fields['id_clase_estudiante'];
			
			$rs_l->MoveFirst();$pos=0;
			for($l=0;$l<$rs_l->RecordCount();$l++)
			{
				$pos=$pos+1;
				$pos_l=$pos;
				
				$sql_p="SELECT id_periodo_evaluativo, periodo_evaluativo, abv_periodo
				FROM n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
				WHERE 1
				AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
				AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo		
				AND n_conf_academica.activa='1'
				AND n_periodo_evaluativo.id_periodo_lectivo='".$rs_l->fields['id_periodo_lectivo']."'";//print $sql_p;die();
				$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
				
				for($p=0;$p<$rs_p->RecordCount();$p++)
				{					
					$pos=$pos+1;
					$pos_p=$pos;
					
					$sql_s="SELECT id_subperiodo_evaluativo, subperiodo_evaluativo, abv_subperiodo
					FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
					WHERE 1
					AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
					AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
					AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
					AND n_conf_academica.activa='1'
					AND n_subperiodo_evaluativo.id_periodo_evaluativo='".$rs_p->fields['id_periodo_evaluativo']."' ORDER BY id_subperiodo_evaluativo";//print $sql_p;die();
					$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());

					for($s=0;$s<$rs_s->RecordCount();$s++)
					{	
						$pos=$pos+1;
						$pos_s=$pos;
						
						$id=$rs_est->fields['id_clase_estudiante'].'_'.$rs_s->fields['id_subperiodo_evaluativo'];
						$row_col=$e.'_'.$pos_s;
						?>							
						<input name="hdn_row_col_comp_<?php print $row_col;?>" id="hdn_row_col_comp_<?php print $row_col;?>" title="hdn_row_col_comp_<?php print $row_col;?>" type="hidden" value="<?php print $id;?>"/>								
						<?php
						
						$sql_s_n="SELECT nota
						FROM nota_comportamental_sub
						WHERE 1
						AND nota_comportamental_sub.id_subperiodo_evaluativo='".$rs_s->fields['id_subperiodo_evaluativo']."'
						AND nota_comportamental_sub.id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_s_n.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
						$rs_s_n=$db->Execute($sql_s_n) or die($db->ErrorMsg());
						
						if(isset($rs_s_n->fields['nota']))
						{
							$datos[$e][$pos_s]=$rs_s_n->fields['nota'];
							$suma_nota=$suma_nota+$rs_s_n->fields['nota'];
							$cant_nota=$cant_nota+1;
						}
						else 
						$datos[$e][$pos_s]='';

						/*if($rs_s_n->fields['observacion']!='')
						{
							$obs=str_replace( array("\\", "¨", "~", "|", "\"", "·", "$", "&", "?", "'", "¿", "[", "^", "`", "]", "}", "{", "¨", "´", ">“, “< ", ";"), '', $rs_s_n->fields['observacion']);
							$obs=str_replace( array("\n"), '\\n', $obs);
							
							if($comment=='')
							$comment='{row: '.$e.', col: '.$pos_s.', comment: "'.$obs.'"}';
							else
							$comment=$comment.',{row: '.$e.', col: '.$pos_s.', comment: "'.$obs.'"}';				
						}*/
						
					$rs_s->MoveNext();
					}
					
					if($cant_nota!=0)$prom_per=bcdiv($suma_nota, $cant_nota, 14); else $prom_per='';
					if($prom_per!='')
					{
						$datos[$e][$pos_p]=$prom_per;					
						$suma_prom=$suma_prom+$prom_per;
						$cant_prom=$cant_prom+1;
					}
					$prom_per='';$cant_nota='';$suma_nota='';
				
				$rs_p->MoveNext();
				}
				
				if($cant_prom!=0)$prom_lec=bcdiv($suma_prom, $cant_prom, 14); else $prom_lec='';
				$datos[$e][$pos_l]=$prom_lec;
				$prom_lec='';$cant_prom='';$suma_prom='';

			$rs_l->MoveNext();
			}
		
			$suma_nota='';$cant_nota='';$suma_prom='';$cant_prom='';
		$rs_est->MoveNext();
		}

		for($d=0;$d<count($datos);$d++){$data[$d]=$datos[$d];}
		
		$varios_arreglos=array();
		$varios_arreglos[0]=array('actividad'=>$actividad,'abv'=>$abv,'descripcion'=>$descripcion,'datos'=>$datos,'data'=>$data,'id_actividad'=>$id_actividad,'fecha'=>$fecha,'column'=>$column,'comment'=>$comment,'cerrado'=>$cerrado);//print count($data);

		?>					
			<input name="hdn_cadena_pos_s_comp" id="hdn_cadena_pos_s_comp" type="hidden" value="<?php print $cadena_pos_s;?>"/>
			<input name="hdn_cadena_cerrado_s_comp" id="hdn_cadena_cerrado_s_comp" type="hidden" value="<?php print $cadena_cerrado_s;?>"/>				
		<?php
		
		return $varios_arreglos;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	function contenido_recomendaciones($db, $x, $id_clase, $sel_filtro_recom, $sel_filtro_est)
	{
		$recomendaciones='';
		$mejoras='';
		
		$tipo=substr($sel_filtro_recom, 0, 2);
		$sel_filtro_recom=substr($sel_filtro_recom, 2, strlen($sel_filtro_recom));
		if($tipo=='l_' AND $sel_filtro_est!='')
		{
			$sql_r="SELECT recomendaciones, mejoras
			FROM recomendaciones_mejoras_lec
			WHERE 1
			AND recomendaciones_mejoras_lec.id_periodo_lectivo='".$sel_filtro_recom."'
			AND recomendaciones_mejoras_lec.id_clase_estudiante='".$sel_filtro_est."'";
			$rs_r=$db->Execute($sql_r) or die($db->ErrorMsg());
			
			$sql_lec="SELECT cerrado FROM cierre_periodo_lectivo WHERE 1 AND id_periodo_lectivo='".$sel_filtro_recom."' AND id_clase='".$id_clase."'";//print $sql_nota.'<br>';
			$rs_lec=$db->Execute($sql_lec) or die($db->ErrorMsg());
			$cerrado=$rs_lec->fields['cerrado'];
			
			if(isset($rs_r->fields['recomendaciones']))
			{
				$recomendaciones=$rs_r->fields['recomendaciones'];
				$mejoras=$rs_r->fields['mejoras'];
			}
		}		
		elseif($tipo=='p_' AND $sel_filtro_est!='')
		{
			$sql_r="SELECT recomendaciones, mejoras
			FROM recomendaciones_mejoras_per
			WHERE 1
			AND recomendaciones_mejoras_per.id_periodo_evaluativo='".$sel_filtro_recom."'
			AND recomendaciones_mejoras_per.id_clase_estudiante='".$sel_filtro_est."'";
			$rs_r=$db->Execute($sql_r) or die($db->ErrorMsg());
			
			$sql_per="SELECT cerrado FROM cierre_periodo_evaluativo WHERE 1 AND id_periodo_evaluativo='".$sel_filtro_recom."' AND id_clase='".$id_clase."'";//print $sql_nota.'<br>';
			$rs_per=$db->Execute($sql_per) or die($db->ErrorMsg());
			$cerrado=$rs_per->fields['cerrado'];
			
			if(isset($rs_r->fields['recomendaciones']))
			{
				$recomendaciones=$rs_r->fields['recomendaciones'];
				$mejoras=$rs_r->fields['mejoras'];
			}
		}		
		elseif($tipo=='s_' AND $sel_filtro_est!='')
		{
			$sql_r="SELECT recomendaciones, mejoras
			FROM recomendaciones_mejoras_sub
			WHERE 1
			AND recomendaciones_mejoras_sub.id_subperiodo_evaluativo='".$sel_filtro_recom."'
			AND recomendaciones_mejoras_sub.id_clase_estudiante='".$sel_filtro_est."'";//print $sql_r.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
			$rs_r=$db->Execute($sql_r) or die($db->ErrorMsg());
			
			$sql_sub="SELECT cerrado FROM cierre_subperiodo_evaluativo WHERE 1 AND id_subperiodo_evaluativo='".$sel_filtro_recom."' AND id_clase='".$id_clase."'";//print $sql_sub.'<br><br>';
			$rs_sub=$db->Execute($sql_sub) or die($db->ErrorMsg());
			$cerrado=$rs_sub->fields['cerrado'];
			
			if(isset($rs_r->fields['recomendaciones']))
			{
				$recomendaciones=$rs_r->fields['recomendaciones'];
				$mejoras=$rs_r->fields['mejoras'];
			}
		}
?>
			<div style='display:table-row;'>
				<div style='display:table-cell;width:50%;text-align:center;padding:1%;'>				
					<fieldset><legend>Recomendaciones <?php if($sel_filtro_est=='' OR $cerrado=='1'){?><img width='8px' src='../../../img/acad/cierre_subperiodo_evaluativo/cerrado.png'><?php }?></legend><textarea <?php if($sel_filtro_est=='' OR $cerrado=='1'){?>disabled<?php }?> name='txt_recomendaciones' id='txt_recomendaciones' rows='10' cols='70' onBlur="ejecutar_ajax('recomendacion/guardar_recomendacion.php','sel_filtro_recom, sel_filtro_est, txt_recomendaciones, txt_mejoras', '');"><?php print $recomendaciones;?></textarea></fieldset>
				</div>
				
				<div style='display:table-cell;width:50%;text-align:center;padding:1%;'>	
					<fieldset><legend>Mejoras <?php if($sel_filtro_est=='' OR $cerrado=='1'){?><img width='8px' src='../../../img/acad/cierre_subperiodo_evaluativo/cerrado.png'><?php }?></legend><textarea <?php if($sel_filtro_est=='' OR $cerrado=='1'){?>disabled<?php }?> name='txt_mejoras' id='txt_mejoras' rows='10' cols='70' onBlur="ejecutar_ajax('recomendacion/guardar_recomendacion.php','sel_filtro_recom, sel_filtro_est, txt_recomendaciones, txt_mejoras', '');"><?php print $mejoras;?></textarea></fieldset>
				</div>
			</div>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function filtro_recomendaciones($db, $rs_sub, $mod, $sel_filtro_recom)
	{
		$sql_est="SELECT estudiante.id_estudiante, clase_estudiante.id_clase_estudiante, clase_estudiante.retirado, concat(per_estudiante.primer_apellido,' ',per_estudiante.segundo_apellido,' ',per_estudiante.primer_nombre,' ',per_estudiante.segundo_nombre) AS estudiante
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
		AND n_periodo_academico.activo='1' AND clase.id_clase='".$mod."'";//print $sql_est;
		$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
?>
		<div style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
			<div  style='display:table-row;'>
				<div style='display:table-cell;width:100%;text-align:center;padding:1%;'>
					
					<div class='tabla_filtro' style='display:table;width:100%;margin-left:auto;margin-right:auto;'>
						<div class='tabla_filtro' style='display:table-row;'>
							<div style='display:table-cell;width:30%;text-align:left;padding:1%;'>
								<?php
									$parametros_extras="onChange=\"ejecutar_ajax('recomendacion/actualizar_datos.php','hdn_id_clase, sel_filtro_recom, sel_filtro_est', 'contenido_recomendacioness');\"";
									$this->select_filtro_periodos($rs_sub, $sel_filtro_recom, $parametros_extras);
								?>	
							</div>
							<div style='display:table-cell;width:70%;text-align:left;padding:1%;'>
								<?php
									$parametros_extras="onChange=\"ejecutar_ajax('recomendacion/actualizar_datos.php','hdn_id_clase, sel_filtro_recom, sel_filtro_est', 'contenido_recomendacioness');\"";
									$this->select_filtro_est($rs_est, $parametros_extras);
								?>	
							</div>
							
						</div>
					</div>
					
				</div>
			</div>
		</div>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function select_filtro_periodos($rs_sub, $sel_filtro_recom, $parametros_extras)
	{
		$id_seleccionado=substr($sel_filtro_recom, 2, strlen($sel_filtro_recom));
		$tipo=substr($sel_filtro_recom, 0, 2);
?>
		<select name="sel_filtro_recom" class="sel_filtro_recom" title="Filtro" id="sel_filtro_recom" <?php print $parametros_extras;?>>
			<?php
			$id_periodo_lectivo='';
			$id_periodo_evaluativo='';
			$id_subperiodo_evaluativo='';
			
			$rs_sub->MoveFirst();
			for($m=0;$m<$rs_sub->RecordCount();$m++)
			{ 
			?>
				<?php if($id_periodo_lectivo!=$rs_sub->fields['id_periodo_lectivo']){$id_periodo_lectivo=$rs_sub->fields['id_periodo_lectivo'];?>
				<option value="l_<?php print $rs_sub->fields['id_periodo_lectivo']; ?>" <?php if($id_seleccionado!='' AND $tipo=='l_'){if($rs_sub->fields['id_periodo_lectivo']==$id_seleccionado){; ?> selected="selected"<?php }} ?> ><?php print $rs_sub->fields['periodo_lectivo'];?></option>
				<?php }if($id_periodo_evaluativo!=$rs_sub->fields['id_periodo_evaluativo']){$id_periodo_evaluativo=$rs_sub->fields['id_periodo_evaluativo'];?>
				<option value="p_<?php print $rs_sub->fields['id_periodo_evaluativo']; ?>" <?php if($id_seleccionado!='' AND $tipo=='p_'){if($rs_sub->fields['id_periodo_evaluativo']==$id_seleccionado){; ?> selected="selected"<?php }} ?>>&nbsp;&nbsp;&nbsp;<?php print $rs_sub->fields['periodo_evaluativo'];?></option>
				<?php }if($id_subperiodo_evaluativo!=$rs_sub->fields['id_subperiodo_evaluativo']){$id_subperiodo_evaluativo=$rs_sub->fields['id_subperiodo_evaluativo'];?>
				<option value="s_<?php print $rs_sub->fields['id_subperiodo_evaluativo']; ?>" <?php if($id_seleccionado!='' AND $tipo=='s_'){if($rs_sub->fields['id_subperiodo_evaluativo']==$id_seleccionado){; ?> selected="selected"<?php }} ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php print $rs_sub->fields['subperiodo_evaluativo'];?> </option>
				<?php }?>
			<?php 
			$rs_sub->MoveNext();
			} 
			?>
		</select>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function select_filtro_est($rs_est, $parametros_extras)
	{
?>
		<select name="sel_filtro_est" class="sel_filtro_est" title="Filtro" id="sel_filtro_est" <?php print $parametros_extras;?>>
			<?php
			$id_clase_estudiante='';
			?>
			<option value="" >--------------------------------Seleccionar Estudiante------------------------</option>
			<?php
			$rs_est->MoveFirst();
			for($m=0;$m<$rs_est->RecordCount();$m++)
			{ 
			?>
				<option value="<?php print $rs_est->fields['id_clase_estudiante'];?>" <?php if(isset($sel_filtro_est)){if($rs_est->fields['id_clase_estudiante']==$sel_filtro_est){; ?> selected="selected"<?php }} ?> ><?php print $rs_est->fields['estudiante'];if($rs_est->fields['retirado']=='1')print ' (ELIMINADO)'?></option>
			<?php 
			$rs_est->MoveNext();
			} 
			?>
		</select>
<?php
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function datos_familiares($db, $id_estudiante)
	{
		$familiares='';
		$sql_fam="SELECT concat(per_familiar.primer_apellido,' ',per_familiar.segundo_apellido,' ',per_familiar.primer_nombre,' ',per_familiar.segundo_nombre) AS familiar, email, telefono1, telefono2, parentesco
		FROM familiar_estudiante, n_parentesco, familiar, persona AS per_familiar
		WHERE 1
		AND familiar_estudiante.id_familiar=familiar.id_familiar
		AND familiar_estudiante.id_parentesco=n_parentesco.id_parentesco
		AND per_familiar.id_persona=familiar.id_persona
		AND id_estudiante='".$id_estudiante."'
		AND representante_aca='1'";//print $sql_est;
		$rs_fam=$db->Execute($sql_fam) or die($db->ErrorMsg());
		
		for($fam=0;$fam<$rs_fam->RecordCount();$fam++)
		{
			$familiares=$familiares.'<b>'.$rs_fam->fields['parentesco'].':</b><br>'.$rs_fam->fields['familiar'].'<br>';
			if($rs_fam->fields['email'])$familiares=$familiares.$rs_fam->fields['email'].'<br>';
			if($rs_fam->fields['telefono1'])$familiares=$familiares.$rs_fam->fields['telefono1'].'<br>';
			if($rs_fam->fields['telefono2'])$familiares=$familiares.$rs_fam->fields['telefono2'].'<br>';
		$rs_fam->MoveNext();
		}
		
		return $familiares;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function mostrar_obs_comportamiento($db, $id_clase_estudiante, $id_subperiodo_evaluativo, $x, $modif)
	{
		$sql_obs="SELECT id_obs_comportamental_sub, nota_comportamental_sub.id_nota_comportamental_sub, fecha, destacada, positiva, nota_perdida, obs_comportamental_sub.observacion FROM nota_comportamental_sub, obs_comportamental_sub 
		WHERE nota_comportamental_sub.id_nota_comportamental_sub=obs_comportamental_sub.id_nota_comportamental_sub
		AND id_subperiodo_evaluativo='".$id_subperiodo_evaluativo."' AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_i.'<br>';
		$rs_obs=$db->Execute($sql_obs) or die($db->ErrorMsg());
		
		if($rs_obs->RecordCount()>0)
		{
		?>
		<table class="" width='100%' border='0'>
			<tr>
				<td class="">						
					<div class='tabla_listar' style='display:table;width:100%;'>
					
						<div class="encabezado_col" style='display:table-row;height:22px;'>
							<div style='display:table-cell;width:2%;text-align:left;padding-left:1%;vertical-align:middle;'>
								No
							</div>
							
							<div style='display:table-cell;width:3%;text-align:center;padding-left:1%;vertical-align:middle;'>
								
							</div>
							
							<div style='display:table-cell;width:15%;text-align:left;padding-left:1%;vertical-align:middle;'>
								Fecha
							</div>
							
							<div style='display:table-cell;width:3%;text-align:left;padding-left:1%;vertical-align:middle;'>
								
							</div>
							
							<div style='display:table-cell;width:15%;text-align:center;padding-left:1%;vertical-align:middle;'>
								Nota
							</div>
							
							<div style='display:table-cell;width:59%;text-align:left;padding-left:1%;vertical-align:middle;'>
								Observaci&oacute;n
							</div>
							
							<div style='display:table-cell;width:3%;text-align:left;padding-left:1%;vertical-align:middle;'>
								
							</div>
						</div>
					
					<?php $rs_obs->MoveFirst();for($i=0;$i<$rs_obs->RecordCount();$i++){?>
					
						<input type="hidden" name="hdn_id_obs_comportamental_sub_<?php print $rs_obs->fields['id_obs_comportamental_sub'];?>" value="<?php print $rs_obs->fields['id_obs_comportamental_sub'];?>">
						
						<div <?php if($i % 2) print "class='row1'";else print "class='row0'";?> style='display:table-row;'>
							
							<div style='display:table-cell;text-align:left;padding-left:1%;vertical-align:middle;' <?php if($modif=='1'){?> onClick='document.frm.hdn_modificar.value="1";document.frm.hdn_id_obs_comportamental_sub.value="<?php print $rs_obs->fields['id_obs_comportamental_sub'];?>";document.frm.rbt_positiva.value="<?php print $rs_obs->fields['positiva'];?>";document.frm.rbt_destacada.value="<?php print $rs_obs->fields['destacada'];?>";document.frm.txt_fecha.value="<?php print $rs_obs->fields['fecha'];?>";document.frm.txt_nota.value="<?php print $rs_obs->fields['nota_perdida'];?>";document.frm.txt_obs.value="<?php print $rs_obs->fields['observacion'];?>";'<?php }?>>
								<?php print $i+1;?>
							</div>
							
							<div style='display:table-cell;text-align:center;padding-left:1%;vertical-align:middle;' <?php if($modif=='1'){?> onClick='document.frm.hdn_modificar.value="1";document.frm.hdn_id_obs_comportamental_sub.value="<?php print $rs_obs->fields['id_obs_comportamental_sub'];?>";document.frm.rbt_positiva.value="<?php print $rs_obs->fields['positiva'];?>";document.frm.rbt_destacada.value="<?php print $rs_obs->fields['destacada'];?>";document.frm.txt_fecha.value="<?php print $rs_obs->fields['fecha'];?>";document.frm.txt_nota.value="<?php print $rs_obs->fields['nota_perdida'];?>";document.frm.txt_obs.value="<?php print $rs_obs->fields['observacion'];?>";'<?php }?>>
								<?php 
									if($rs_obs->fields['destacada']==1)print '<img width=13px src="'.$x.'img/general/importante.png">';
								?>
							</div>
							
							<div style='display:table-cell;text-align:left;padding-left:1%;vertical-align:middle;' <?php if($modif=='1'){?> onClick='document.frm.hdn_modificar.value="1";document.frm.hdn_id_obs_comportamental_sub.value="<?php print $rs_obs->fields['id_obs_comportamental_sub'];?>";document.frm.rbt_positiva.value="<?php print $rs_obs->fields['positiva'];?>";document.frm.rbt_destacada.value="<?php print $rs_obs->fields['destacada'];?>";document.frm.txt_fecha.value="<?php print $rs_obs->fields['fecha'];?>";document.frm.txt_nota.value="<?php print $rs_obs->fields['nota_perdida'];?>";document.frm.txt_obs.value="<?php print $rs_obs->fields['observacion'];?>";'<?php }?>>
								<?php print $rs_obs->fields['fecha'];?>
							</div>
							
							<div style='display:table-cell;text-align:left;padding-left:1%;vertical-align:middle;' <?php if($modif=='1'){?> onClick='document.frm.hdn_modificar.value="1";document.frm.hdn_id_obs_comportamental_sub.value="<?php print $rs_obs->fields['id_obs_comportamental_sub'];?>";document.frm.rbt_positiva.value="<?php print $rs_obs->fields['positiva'];?>";document.frm.rbt_destacada.value="<?php print $rs_obs->fields['destacada'];?>";document.frm.txt_fecha.value="<?php print $rs_obs->fields['fecha'];?>";document.frm.txt_nota.value="<?php print $rs_obs->fields['nota_perdida'];?>";document.frm.txt_obs.value="<?php print $rs_obs->fields['observacion'];?>";'<?php }?>>
								<?php 
									if($rs_obs->fields['positiva']==1)print '<img width=20px src="'.$x.'img/general/like.png">';
									elseif($rs_obs->fields['positiva']==0)print '<img width=20px src="'.$x.'img/general/dislike.png">';
								?>
							</div>
							
							<div style='display:table-cell;text-align:center;padding-left:1%;vertical-align:middle;' <?php if($modif=='1'){?> onClick='document.frm.hdn_modificar.value="1";document.frm.hdn_id_obs_comportamental_sub.value="<?php print $rs_obs->fields['id_obs_comportamental_sub'];?>";document.frm.rbt_positiva.value="<?php print $rs_obs->fields['positiva'];?>";document.frm.rbt_destacada.value="<?php print $rs_obs->fields['destacada'];?>";document.frm.txt_fecha.value="<?php print $rs_obs->fields['fecha'];?>";document.frm.txt_nota.value="<?php print $rs_obs->fields['nota_perdida'];?>";document.frm.txt_obs.value="<?php print $rs_obs->fields['observacion'];?>";'<?php }?>>
								<?php print $rs_obs->fields['nota_perdida'];?>
							</div>
							
							<div style='display:table-cell;text-align:left;padding-left:1%;vertical-align:middle;' <?php if($modif=='1'){?> onClick='document.frm.hdn_modificar.value="1";document.frm.hdn_id_obs_comportamental_sub.value="<?php print $rs_obs->fields['id_obs_comportamental_sub'];?>";document.frm.rbt_positiva.value="<?php print $rs_obs->fields['positiva'];?>";document.frm.rbt_destacada.value="<?php print $rs_obs->fields['destacada'];?>";document.frm.txt_fecha.value="<?php print $rs_obs->fields['fecha'];?>";document.frm.txt_nota.value="<?php print $rs_obs->fields['nota_perdida'];?>";document.frm.txt_obs.value="<?php print $rs_obs->fields['observacion'];?>";'<?php }?>>
								<?php if($rs_obs->fields['observacion']!='')print $rs_obs->fields['observacion'];else print 'No hay observaci&oacute;n';//print $modif;?>
							</div>
							
							<div style='display:table-cell;text-align:center;vertical-align:middle;'>
								<?php if($modif=='1'){?>
									<a onClick="document.frm.hdn_modificar.value='0';alertify.confirm('Confirma que desea eliminar la observaci&oacute;n?', function(e){if(e){ejecutar_ajax('comportamiento/actualizar_grid.php','hdn_id_clase', 'contenido_grid_comportamientos', ejecutar_ajax1('comportamiento/eli_obs_comportamiento.php','hdn_id_obs_comportamental_sub_<?php print $rs_obs->fields['id_obs_comportamental_sub'];?>, hdn_id_clase_estudiante, hdn_id_subperiodo_evaluativo','div_listado_obs'));}else {alertify.error('Has pulsado ' + alertify.labels.cancel);}limpiar_campos(String('txt_fecha,txt_nota,txt_obs').split(','));});">
										<img width=13px src="<?php print $x;?>img/general/eliminar.png">
									</a>
								<?php }?>
							</div>
						</div>

					<?php $rs_obs->MoveNext();}?>
						
					</div>
				</td>
			</tr>
		</table>
		<?php
		}
		else
		print '<b>No hay observaciones guardadas.</b>';		
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function equivalente_comportamental($db, $nota)
	{
		if($nota!='')
		{
			$sql_s_n="SELECT nota_cualitativa FROM n_conf_conductual, n_equivalencias_conductuales WHERE 1
			AND a_partir<='".$nota."'
			AND n_conf_conductual.id_conf_conductual=n_equivalencias_conductuales.id_conf_conductual AND activa='1' ORDER BY a_partir DESC";//print $sql_s_n.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
			$rs_s_n=$db->Execute($sql_s_n) or die($db->ErrorMsg());
			
			if(isset($rs_s_n->fields['nota_cualitativa']) AND $rs_s_n->fields['nota_cualitativa']!='')
			{
				$nota_cualitativa=$rs_s_n->fields['nota_cualitativa'];
			}
			else 
			$nota_cualitativa='';
		}
		else		
		$nota_cualitativa='';
		
		return $nota_cualitativa;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function nota_cualitativa($db, $nota)
	{
		if($nota!='')
		{
			$sql_s_n="SELECT nota_cualitativa FROM n_conf_academica, c_equivalencias_academicas_cualitativas WHERE 1
			AND a_partir<='".$nota."'
			AND n_conf_academica.id_conf_academica=c_equivalencias_academicas_cualitativas.id_conf_academica AND activa='1' ORDER BY a_partir DESC";//print $sql_s_n.'<br>';//die();//ORDER BY n_tipo_actividad.orden, actividad.fecha
			$rs_s_n=$db->Execute($sql_s_n) or die($db->ErrorMsg());
			
			if(isset($rs_s_n->fields['nota_cualitativa']) AND $rs_s_n->fields['nota_cualitativa']!='')
			{
				$nota_cualitativa=$rs_s_n->fields['nota_cualitativa'];
			}
			else 
			$nota_cualitativa='';
		}
		else		
		$nota_cualitativa='';
		
		return $nota_cualitativa;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function datos_estudiante($db, $id_estudiante)
	{
		$datos_est['curso']='';
		$datos_est['paralelo']='';
		$datos_est['tutor']='';
		$datos_est['inspector']='';
		$datos_est['psicologo']='';
		$datos_est['estudiante']='';
		$datos_est['email_insp']='';
		$datos_est['email_psi']='';
		$datos_est['email_tut']='';
		
		$sql_cla="SELECT grado, paralelo, concat(per_tut.primer_apellido,' ',per_tut.segundo_apellido,' ',per_tut.primer_nombre,' ',per_tut.segundo_nombre) as tutor,emp_tut.email_inst AS email_tut,
		concat(per_ins.primer_apellido,' ',per_ins.segundo_apellido,' ',per_ins.primer_nombre,' ',per_ins.segundo_nombre) as inspector,emp_ins.email_inst AS email_insp,
		concat(per_psi.primer_apellido,' ',per_psi.segundo_apellido,' ',per_psi.primer_nombre,' ',per_psi.segundo_nombre) as psicologo,emp_psi.email_inst AS email_psi,
		concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre) AS estudiante
		FROM n_paralelo, n_grado, n_grado_paralelo, grado_paralelo_periodo, n_periodo_academico, 
		empleado_academico AS amp_aca_tut, empleado AS emp_tut, persona AS per_tut,
		empleado_academico AS amp_aca_ins, empleado AS emp_ins, persona AS per_ins, 
		empleado_academico AS amp_aca_psi, empleado AS emp_psi, persona AS per_psi, 
		curso_grado_paralelo_est, estudiante, persona
		WHERE 1 
		AND n_paralelo.id_paralelo=n_grado_paralelo.id_paralelo
		AND n_grado.id_grado=n_grado_paralelo.id_grado
		AND n_grado_paralelo.id_grado_paralelo=grado_paralelo_periodo.id_grado_paralelo
		AND per_tut.id_persona=emp_tut.id_persona 
		AND amp_aca_tut.id_empleado=emp_tut.id_empleado
		AND grado_paralelo_periodo.id_tutor=amp_aca_tut.id_empleado_academico
		
		AND per_ins.id_persona=emp_ins.id_persona 
		AND amp_aca_ins.id_empleado=emp_ins.id_empleado
		AND grado_paralelo_periodo.id_inspector=amp_aca_ins.id_empleado_academico
		
		AND per_psi.id_persona=emp_psi.id_persona 
		AND amp_aca_psi.id_empleado=emp_psi.id_empleado
		AND grado_paralelo_periodo.id_psicologo=amp_aca_psi.id_empleado_academico
		
		AND  estudiante.id_persona=persona.id_persona
		
		AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico
		AND grado_paralelo_periodo.id_grado_paralelo_periodo=curso_grado_paralelo_est.id_grado_paralelo_periodo		
		AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante		
		AND n_periodo_academico.activo='1'
		AND estudiante.id_estudiante='".$id_estudiante."'
		ORDER BY nombre ASC";//print $sql_cla;
		$rs_cla=$db->Execute($sql_cla) or die($db->ErrorMsg());
		
		$rs_cla->MoveFirst();		
		for($c=0;$c<$rs_cla->RecordCount();$c++)
		{
			$datos_est['curso']=$rs_cla->fields['grado'];
			$datos_est['paralelo']=$rs_cla->fields['paralelo'];
			$datos_est['tutor']=$rs_cla->fields['tutor'];
			$datos_est['inspector']=$rs_cla->fields['inspector'];
			$datos_est['psicologo']=$rs_cla->fields['psicologo'];
			$datos_est['estudiante']=$rs_cla->fields['estudiante'];
			$datos_est['email_insp']=$rs_cla->fields['email_insp'];
			$datos_est['email_psi']=$rs_cla->fields['email_psi'];
			$datos_est['email_tut']=$rs_cla->fields['email_tut'];
			
		$rs_cla->MoveNext();
		}
	return $datos_est;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function consulta_asistencia_libreta($db, $id_estudiante)
	{
		$inasistencias='';
		
		$varios_arreglos=$this->encabezado($db);
	
		$id_encab=$varios_arreglos[0]['id_encab'];
		$position_id=$varios_arreglos[0]['position_id'];
		$tipo=$varios_arreglos[0]['tipo'];
		$position=$varios_arreglos[0]['position'];
		
		for($c=0;$c<3;$c++)
		{
			if($c==0)$inasistencias[$c][0]='FALTAS INJUSTIFICADAS';
			elseif($c==1)$inasistencias[$c][0]='FALTAS JUSTIFICADAS';
			elseif($c==2)$inasistencias[$c][0]='ATRASOS';
			
			for($h=1;$h<=count($position);$h++)
			{
				if($tipo[$position[$h]]=='s')
				{
					$inasistencia=$this->calcular_inasis_x_asignaturas_x_sub_x_est($db, $id_encab[$position[$h]], $id_estudiante);//print $nota_gen;
			
					if($c==0)$inasistencias[$c][$position[$h]]=$inasistencia['injustificadas'];
					if($c==1)$inasistencias[$c][$position[$h]]=$inasistencia['justificadas'];
					if($c==2)$inasistencias[$c][$position[$h]]=$inasistencia['atrasos'];									
				}
				elseif($tipo[$position[$h]]=='p')
				{
					$inasistencia=$this->calcular_inasis_x_asignaturas_x_eval_x_est($db, $id_encab[$position[$h]], $id_estudiante);//print $nota_gen;
			
					if($c==0)$inasistencias[$c][$position[$h]]=$inasistencia['injustificadas'];
					if($c==1)$inasistencias[$c][$position[$h]]=$inasistencia['justificadas'];
					if($c==2)$inasistencias[$c][$position[$h]]=$inasistencia['atrasos'];
				}
				
				elseif($tipo[$position[$h]]=='l')
				{
					$inasistencia=$this->calcular_inasis_x_asignaturas_x_lec_x_est($db, $id_encab[$position[$h]], $id_estudiante);//print $nota_gen;
			
					if($c==0)$inasistencias[$c][$position[$h]]=$inasistencia['injustificadas'];
					if($c==1)$inasistencias[$c][$position[$h]]=$inasistencia['justificadas'];
					if($c==2)$inasistencias[$c][$position[$h]]=$inasistencia['atrasos'];
				}
			}
		}
		
		
		
		$varios_arreglos=array();
		$varios_arreglos[0]=array('inasistencias'=>$inasistencias);//print count($data);

		return $varios_arreglos;
	}	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_comportamental_libreta($db, $id_estudiante)
	{
		$nota_cualit='';
		$color_text='';
		
		$sql_nota_comp="SELECT nota_minima, nota_aprobado, nota_maxima FROM n_conf_conductual WHERE activa='1'";//print $sql_nota.'<br>';
		$rs_nota_comp=$db->Execute($sql_nota_comp) or die($db->ErrorMsg());

		$nota_aprobado_comp=$rs_nota_comp->fields['nota_aprobado'];
		
		$sql_est="SELECT curso_grado_paralelo_est.id_curso_grado_paralelo_est
		FROM curso_grado_paralelo_est, grado_paralelo_periodo, n_periodo_academico
		WHERE 1
		AND curso_grado_paralelo_est.id_grado_paralelo_periodo=grado_paralelo_periodo.id_grado_paralelo_periodo
		AND grado_paralelo_periodo.id_periodo_academico=n_periodo_academico.id_periodo_academico
		AND n_periodo_academico.activo='1' AND curso_grado_paralelo_est.id_estudiante='".$id_estudiante."'";//print $sql_est;
		$rs_est=$db->Execute($sql_est) or die($db->ErrorMsg());
		
		$id_curso_grado_paralelo_est=$rs_est->fields['id_curso_grado_paralelo_est'];
		
		$varios_arreglos=$this->encabezado($db);
	
		$id_encab=$varios_arreglos[0]['id_encab'];
		$position_id=$varios_arreglos[0]['position_id'];
		$tipo=$varios_arreglos[0]['tipo'];
		$position=$varios_arreglos[0]['position'];
		
		$sql_conf_comp="SELECT peso_clases, peso_inspector, peso_tutor FROM n_conf_conductual WHERE activa='1' ORDER BY id_conf_conductual DESC";//print $sql_asig.'<br>';
		$rs_conf_comp=$db->Execute($sql_conf_comp) or die($db->ErrorMsg());
		
		$peso_clases=$rs_conf_comp->fields['peso_clases'];if($peso_clases=='')$peso_clases=0;//print $peso_clases;
		$peso_inspector=$rs_conf_comp->fields['peso_inspector'];if($peso_inspector=='')$peso_inspector=0;
		$peso_tutor=$rs_conf_comp->fields['peso_tutor'];if($peso_tutor=='')$peso_tutor=0;
		
		for($h=1;$h<=count($position);$h++)
		{
			if($tipo[$position[$h]]=='s')
			{
				$nota_insp=$this->consulta_nota_comportamental_subperiodo_inspector($db, $id_curso_grado_paralelo_est, $id_encab[$position[$h]]);	//print 'nota_insp:'.$nota_insp;
				$nota_tut=$this->consulta_nota_comportamental_subperiodo_tutor($db, $id_curso_grado_paralelo_est, $id_encab[$position[$h]]);	
				$nota_doc=$this->consulta_nota_comportamental_subperiodo($db, $id_curso_grado_paralelo_est, $id_encab[$position[$h]]);//print $l.'- '.$nota[$l].'<br>';
		
				$nota_gen=$this->comportamental_ponderado_aritmetico($peso_clases, $peso_inspector, $peso_tutor, $nota_doc, $nota_insp, $nota_tut);//print $nota_gen;
		
				$nota=$this->equivalente_comportamental($db, $nota_gen);
				$nota_cualit[$position[$h]]=$nota;
				if($nota_gen<$nota_aprobado_comp)$color_text[$position[$h]]='red';else $color_text[$position[$h]]='#000';
			}
			
			elseif($tipo[$position[$h]]=='p')
			{
				$nota_insp=$this->consulta_nota_comportamental_periodo_inspector($db, $id_curso_grado_paralelo_est, $id_encab[$position[$h]]);	
				$nota_tut=$this->consulta_nota_comportamental_periodo_tutor($db, $id_curso_grado_paralelo_est, $id_encab[$position[$h]]);	
				$nota_doc=$this->consulta_nota_comportamental_periodo($db, $id_curso_grado_paralelo_est, $id_encab[$position[$h]]);//print $l.'- '.$nota[$l].'<br>';
		
				$nota_gen=$this->comportamental_ponderado_aritmetico($peso_clases, $peso_inspector, $peso_tutor, $nota_doc, $nota_insp, $nota_tut);//print $nota_gen;
		
				$nota=$this->equivalente_comportamental($db, $nota_gen);
				$nota_cualit[$position[$h]]=$nota;
				if($nota_gen<$nota_aprobado_comp)$color_text[$position[$h]]='red';else $color_text[$position[$h]]='#000';
			}
			
			elseif($tipo[$position[$h]]=='l')
			{
				$nota_insp=$this->consulta_nota_comportamental_lec_inspector($db, $id_curso_grado_paralelo_est, $id_encab[$position[$h]]);	
				$nota_tut=$this->consulta_nota_comportamental_lec_tutor($db, $id_curso_grado_paralelo_est, $id_encab[$position[$h]]);	
				$nota_doc=$this->consulta_nota_comportamental_lectivo($db, $id_curso_grado_paralelo_est, $id_encab[$position[$h]]);//print $l.'- '.$nota[$l].'<br>';
				
				$nota_gen=$this->comportamental_ponderado_aritmetico($peso_clases, $peso_inspector, $peso_tutor, $nota_doc, $nota_insp, $nota_tut);//print $nota_gen;
		
				$nota=$this->equivalente_comportamental($db, $nota_gen);
				$nota_cualit[$position[$h]]=$nota;
				if($nota_gen<$nota_aprobado_comp)$color_text[$position[$h]]='red';else $color_text[$position[$h]]='#000';
			}
		}
		
		$varios_arreglos=array();
		$varios_arreglos[0]=array('nota_cualit'=>$nota_cualit,'color_text'=>$color_text);//print count($data);

		return $varios_arreglos;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_est_calificaciones_libreta($db, $id_estudiante, $array_periodos)
	{
		$datos[0][0]='';
		$actividad[0]='';
		$id[0]='';
		$abv[0]='';
		$column[0]='';
		$asig='';
		$peso='';
		$cualit='';
		
		$varios_arreglos=$this->encabezado_filtrado($db, $array_periodos);
		
		$id=$varios_arreglos[0]['id'];
		$id_encab=$varios_arreglos[0]['id_encab'];
		$tipo_id=$varios_arreglos[0]['tipo_id'];
		$position_id=$varios_arreglos[0]['position_id'];
		$pertenece=$varios_arreglos[0]['pertenece'];
		$actividad=$varios_arreglos[0]['actividad'];
		$abv=$varios_arreglos[0]['abv'];
		$column=$varios_arreglos[0]['column'];
		$tipo=$varios_arreglos[0]['tipo'];
		$position=$varios_arreglos[0]['position'];
		$pos_libreta=$varios_arreglos[0]['pos_libreta'];
		
		/*for($c=1;$c<=count($pos_libreta);$c++)
		{
			print $position[$c].' - '.$actividad[$c].' - '.$pos_libreta[$c].'<br>';
		}*/

		$sql_cla="SELECT n_asignatura.cuantitativa, clase.id_clase as id_clase, clase_estudiante.id_clase_estudiante, clase.id_asignatura as id_asignatura, 
		concat(asignatura) as asignatura, n_asignatura.foto, clase.peso, clase.nombre as nombre, referencia as referencia, 
		codigo as codigo, curso_grado_paralelo_est.id_curso_grado_paralelo_est, clase.id_empleado_academico as id_empleado_academico, 
		concat(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre) as empleado_academico, peso as peso 
		FROM clase, n_periodo_academico, n_asignatura, empleado_academico, empleado, persona, clase_estudiante, curso_grado_paralelo_est, estudiante
		WHERE 1 
		AND persona.id_persona=empleado.id_persona 
		AND empleado_academico.id_empleado=empleado.id_empleado
		AND clase.id_empleado_academico=empleado_academico.id_empleado_academico
		AND clase.id_asignatura=n_asignatura.id_asignatura 
		AND clase.id_periodo_academico=n_periodo_academico.id_periodo_academico
		AND clase.id_clase=clase_estudiante.id_clase
		AND clase_estudiante.id_curso_grado_paralelo_est=curso_grado_paralelo_est.id_curso_grado_paralelo_est
		AND estudiante.id_estudiante=curso_grado_paralelo_est.id_estudiante
		AND n_periodo_academico.activo='1'
		AND estudiante.id_estudiante='".$id_estudiante."'
		AND mostrar_reportes_ofic='1'
		ORDER BY n_asignatura.id_asignatura, n_asignatura.cuantitativa ASC";//print $sql_cla;//AND usuario='".$_SESSION['user']."'
		$rs_cla=$db->Execute($sql_cla) or die($db->ErrorMsg());
		
		$rs_cla->MoveFirst();		
		for($c=0;$c<$rs_cla->RecordCount();$c++)
		{
			$id_clase=$rs_cla->fields['id_clase'];
			$id_asignatura=$rs_cla->fields['id_asignatura'];
			$id_clase_estudiante=$rs_cla->fields['id_clase_estudiante'];
			$asig_cuantitativa=$rs_cla->fields['cuantitativa'];
			$asignatura=$rs_cla->fields['asignatura'];			
			$clase=$rs_cla->fields['nombre'].' ('.$rs_cla->fields['peso'].'%)';
			$datos[$c][0]=$clase;//print $c.'  '.$clase;
			$asig[$c][0]=$asignatura;
			$peso[$c][0]=$rs_cla->fields['peso'];
			$cualit[$c][0]=$asig_cuantitativa;
			
			$pos=0;
			$examen_periodo='';
			//--------------------------------------------------------------------------------------------------------------------
			for($h=1;$h<=count($position);$h++)
			{
				if($tipo[$position[$h]]=='s')
				{
					$promedio_s=$this->calcular_prom_subperiodo($db, $id_clase_estudiante, $id_encab[$position[$h]], '');
					$nota=$promedio_s['promedio'];
					//if($asig_cuantitativa=='0')$nota=$this->nota_cualitativa($db, $nota);
					$datos[$c][$position[$h]]=$nota;
					$asig[$c][$position[$h]]=$nota;
				}
				
				if($tipo[$position[$h]]=='p')
				{
					$promedio_p=$this->calcular_prom_periodo($db, $id_clase_estudiante, $id_encab[$position[$h]]);//print 'examen_periodo: '.$examen_periodo.'<br>';
					$nota=$promedio_p;
					//if($asig_cuantitativa=='0')$nota=$this->nota_cualitativa($db, $nota);
					$datos[$c][$position[$h]]=$nota;
					$asig[$c][$position[$h]]=$nota;
				}
				
				if($tipo[$position[$h]]=='l')
				{
					$promedio_l=$this->calcular_prom_lectivo($db, $id_clase_estudiante, $id_encab[$position[$h]]);//print 'examen_periodo: '.$examen_periodo.'<br>';
					$nota=$promedio_l['promedio'];
					//if($asig_cuantitativa=='0')$nota=$this->nota_cualitativa($db, $nota);
					$datos[$c][$position[$h]]=$nota;
					$asig[$c][$position[$h]]=$nota;
				}
				
				elseif($tipo[$position[$h]]=='p_exa')
				{
					for($a=1;$a<=count($position_id);$a++)
					{					
						if($tipo_id[$position_id[$a]]=='p_exa' AND $id_encab[$position[$h]]==$pertenece[$position_id[$a]])//substr($sel_filtro_cal, 2, strlen($sel_filtro_cal));
						{
							$examen_periodo=$this->consulta_nota_examen_periodo($db, $id_clase_estudiante, $id[$position_id[$a]]);
							$nota=$examen_periodo['nota'];
							//if($asig_cuantitativa=='0')$nota=$this->nota_cualitativa($db, $nota);
							$datos[$c][$position[$h]]=$nota;
							$asig[$c][$position[$h]]=$nota;
							if($examen_periodo['nota']!='')break;
						}
					}
				}
			
				elseif($tipo[$position[$h]]=='p_adic')
				{
					for($a=1;$a<=count($position_id);$a++)
					{
						if($tipo_id[$position_id[$a]]=='p_adic' AND $id_encab[$position[$h]]==$pertenece[$position_id[$a]])
						{
							$examen_periodo_adic=$this->consulta_nota_examen_periodo_adicional($db, $id_clase_estudiante, $id[$position_id[$a]]);
							$nota=$examen_periodo_adic['nota'];
							//if($asig_cuantitativa=='0')$nota=$this->nota_cualitativa($db, $nota);
							$datos[$c][$position[$h]]=$nota;
							$asig[$c][$position[$h]]=$nota;
							if($examen_periodo_adic['nota']!='')break;
						}
					}
				}
				
				elseif($tipo[$position[$h]]=='l_exa')
				{
					for($a=1;$a<=count($position_id);$a++)
					{
						if($tipo_id[$position_id[$a]]=='l_exa' AND $id_encab[$position[$h]]==$pertenece[$position_id[$a]])
						{
							$examen_lectivo=$this->consulta_nota_examen_lectivo($db, $id_clase_estudiante, $id[$position_id[$a]]);
							$nota=$examen_lectivo['nota'];
							//if($asig_cuantitativa=='0')$nota=$this->nota_cualitativa($db, $nota);
							$datos[$c][$position[$h]]=$nota;
							$asig[$c][$position[$h]]=$nota;
							if($examen_lectivo['nota']!='')break;
						}
					}
				}
				
				elseif($tipo[$position[$h]]=='l_adic')
				{
					for($a=1;$a<=count($position_id);$a++)
					{//if($tipo_id[$position_id[$a]]=='l_adic')print 'tipo_id: '.$tipo_id[$position_id[$a]].'&nbsp;&nbsp;&nbsp;&nbsp; id_encab: '.$id_encab[$position[$h]].' == pertenece: '.$pertenece[$position_id[$a]].'<br>';
						if($tipo_id[$position_id[$a]]=='l_adic' AND $id_encab[$position[$h]]==$pertenece[$position_id[$a]])
						{
							$examen_lectivo_adic=$this->consulta_nota_examen_lectivo_adicional($db, $id_clase_estudiante, $id[$position_id[$a]]);
							$nota=$examen_lectivo_adic['nota'];
							//if($asig_cuantitativa=='0')$nota=$this->nota_cualitativa($db, $nota);
							$datos[$c][$position[$h]]=$nota;
							$asig[$c][$position[$h]]=$nota;
							if($examen_lectivo_adic['nota']!='')break;
						}
					}
				//print '<br>';
				}
			}
			
			//--------------------------------------------------------------------------------------------------------------------		
		$rs_cla->MoveNext();
		}
		
		$varios_arreglos=array();
		$varios_arreglos[0]=array('abv'=>$abv,'id'=>$id,'datos'=>$datos,'column'=>$column,'asig'=>$asig,'peso'=>$peso,'cualit'=>$cualit,'actividad'=>$actividad,'tipo'=>$tipo,'pos_libreta'=>$pos_libreta);//print count($data);

		return $varios_arreglos;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function encabezado_filtrado($db, $array_periodos)
	{
		$pos=0;$pos_id=1;$pos_libreta=array();$no_todos_periodos=0;
		
		$l_examen_lec_ant=array();
		$l_abv_tipo_examen_lec_ant=array();
		
		$l_examen_adicional_ant=array();
		$l_abv_examen_ant=array();
		
		$sql_l="SELECT id_periodo_lectivo, periodo_lectivo
		FROM n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica		
		AND n_conf_academica.activa='1'";//print $sql_p;die();
		$rs_l=$db->Execute($sql_l) or die($db->ErrorMsg());
		
		for($l=0;$l<$rs_l->RecordCount();$l++)
		{
			$pos=$pos+1;
			$pos_l_lib=$pos;
			$actividad[$pos]=$rs_l->fields['periodo_lectivo'];
			$abv[$pos]='Promedio';
			$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, renderer: "html"}';
			$tipo[$pos]='l';
			$color[$pos]='#D8D8D8';
			$position[$pos]=$pos;
			$id_encab[$pos]=$rs_l->fields['id_periodo_lectivo'];

			$position_id[$pos_id]=$pos_id;
			$id[$pos_id]=$rs_l->fields['id_periodo_lectivo'];
			$tipo_id[$pos_id]='l';//print '  mi pos1: '.$pos_id;
			$pos_id=$pos_id+1;
				
			$sql_p="SELECT id_periodo_evaluativo, periodo_evaluativo, abv_periodo
			FROM n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
			WHERE 1
			AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
			AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo		
			AND n_conf_academica.activa='1'
			AND n_periodo_evaluativo.id_periodo_lectivo='".$rs_l->fields['id_periodo_lectivo']."'";//print $sql_p;die();
			$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
			
			for($p=0;$p<$rs_p->RecordCount();$p++)
			{
				//print ' array_periodos: '.$array_periodos[$p];
				if(in_array($rs_p->fields['id_periodo_evaluativo'], $array_periodos))
				{
					$pos=$pos+1;
					$pos_p_lib=$pos;
					$actividad[$pos]=$rs_p->fields['periodo_evaluativo'];
					$abv[$pos]=$rs_p->fields['abv_periodo'];
					$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, comment: false, renderer: "html"}';
					$tipo[$pos]='p';
					$color[$pos]='#2EFE9A';
					$position[$pos]=$pos;
					$id_encab[$pos]=$rs_p->fields['id_periodo_evaluativo'];

					
					$position_id[$pos_id]=$pos_id;
					$id[$pos_id]=$rs_p->fields['id_periodo_evaluativo'];
					$tipo_id[$pos_id]='p';//print '  mi pos1: '.$pos_id;
					$pos_id=$pos_id+1;
					
					$sql_s="SELECT id_subperiodo_evaluativo, subperiodo_evaluativo, abv_subperiodo
					FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
					WHERE 1
					AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
					AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
					AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
					AND n_conf_academica.activa='1'
					AND n_subperiodo_evaluativo.id_periodo_evaluativo='".$rs_p->fields['id_periodo_evaluativo']."'";//print $sql_s.'<br><br><br>';//die();
					$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
					
					for($s=0;$s<$rs_s->RecordCount();$s++)
					{	
						$pos=$pos+1;
						$actividad[$pos]=$rs_s->fields['subperiodo_evaluativo'];
						$abv[$pos]=$rs_s->fields['abv_subperiodo'];
						$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false, readOnly: true, renderer: "html"}';						
						$tipo[$pos]='s';
						$color[$pos]='#F5A9BC';
						$position[$pos]=$pos;
						$id_encab[$pos]=$rs_s->fields['id_subperiodo_evaluativo'];
						
						
						$position_id[$pos_id]=$pos_id;
						$id[$pos_id]=$rs_s->fields['id_subperiodo_evaluativo'];
						$tipo_id[$pos_id]='s';//print '  mi pos1: '.$pos_id;
						$pos_id=$pos_id+1;
						
						
						//print $pos_libreta[$pos-1].'<br>';
						if(end($pos_libreta)!=null)$pos_libreta[$pos]=end($pos_libreta)+1;
						else $pos_libreta[$pos]=1;
						
					$rs_s->MoveNext();
					}
					
				
					
					//----------------EXAMENES Y EXAMENES ADICIONALES DEL PERIODO EVALUATIVO----------------
					$sql_p_exa="SELECT id_examen_periodo_eval, examen_eval, abv_tipo_examen_eval, peso
					FROM n_examen_periodo_eval, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
					WHERE 1
					AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
					AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
					AND n_examen_periodo_eval.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
					AND n_periodo_evaluativo.id_periodo_evaluativo='".$rs_p->fields['id_periodo_evaluativo']."'				
					AND n_conf_academica.activa='1'
					ORDER BY examen_eval";//print $sql_p_exa.'<br><br><br>';//die();//AND n_examen_periodo_eval.id_asignatura='".$id_asignatura."'
					$rs_p_exa=$db->Execute($sql_p_exa) or die($db->ErrorMsg());
					
					$p_examen_eval_ant=array();
					$p_abv_tipo_examen_eval_ant=array();
					
					$p_examen_adicional_ant=array();
					$p_abv_examen_ant=array();
						
					for($p_exa=0;$p_exa<$rs_p_exa->RecordCount();$p_exa++)
					{	
						if($rs_p_exa->fields['peso']!=0)
						{
							if(!in_array($rs_p_exa->fields['examen_eval'], $p_examen_eval_ant) OR !in_array($rs_p_exa->fields['abv_tipo_examen_eval'], $p_abv_tipo_examen_eval_ant))
							{
								$pos=$pos+1;
								$actividad[$pos]=$rs_p_exa->fields['examen_eval'];
								$abv[$pos]=$rs_p_exa->fields['abv_tipo_examen_eval'];
								$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, comment: false, renderer: "html"}';
								$position[$pos]=$pos;	
								$tipo[$pos]='p_exa';
								$color[$pos]='#CEE3F6';
								
								$p_examen_eval_ant[$pos]=$rs_p_exa->fields['examen_eval'];
								$p_abv_tipo_examen_eval_ant[$pos]=$rs_p_exa->fields['abv_tipo_examen_eval'];	
								$id_encab[$pos]=$rs_p_exa->fields['id_examen_periodo_eval'];
								$id_aux_p_exa=$rs_p_exa->fields['id_examen_periodo_eval'];
								
								$pos_libreta[$pos]=end($pos_libreta)+1;
							}
							
							$pertenece[$pos_id]=$id_aux_p_exa;
							$position_id[$pos_id]=$pos_id;
							$id[$pos_id]=$rs_p_exa->fields['id_examen_periodo_eval'];
							$tipo_id[$pos_id]='p_exa';//print '  mi pos1: '.$pos;
							$pos_id=$pos_id+1;
						}
						
						$sql_p_adic="SELECT id_exa_adicional_periodo, examen_adicional, abv_examen, tipo_examen, opcional
						FROM n_examen_adicional, n_tipo_examen, n_exa_adicional_periodo, n_examen_periodo_eval, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
						WHERE 1
						AND n_examen_adicional.id_examen_adicional=n_exa_adicional_periodo.id_examen_adicional
						AND n_tipo_examen.id_tipo_examen=n_exa_adicional_periodo.id_tipo_examen
						AND n_exa_adicional_periodo.id_examen_periodo_eval=n_examen_periodo_eval.id_examen_periodo_eval
						AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
						AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
						AND n_examen_periodo_eval.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
						AND n_exa_adicional_periodo.id_examen_periodo_eval='".$rs_p_exa->fields['id_examen_periodo_eval']."'
						AND n_conf_academica.activa='1' ORDER BY n_exa_adicional_periodo.orden";//print $sql_p_adic;die();//, actividad.fecha
						$rs_p_adic=$db->Execute($sql_p_adic) or die($db->ErrorMsg());
						
						for($p_adic=0;$p_adic<$rs_p_adic->RecordCount();$p_adic++)
						{
							if(!in_array($rs_p_adic->fields['examen_adicional'], $p_examen_adicional_ant) OR !in_array($rs_p_adic->fields['abv_examen'], $p_abv_examen_ant))
							{
								$pos=$pos+1;
								if(!isset($p_adi))$p_adi=0;else $p_adi=$p_adi+1;$pos_p_adic_lib[$p_adi]=$pos;
								$actividad[$pos]=$rs_p_adic->fields['examen_adicional'];
								$abv[$pos]=$rs_p_adic->fields['abv_examen'];
								$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, comment: false, renderer: "html"}';
								$position[$pos]=$pos;							
								$tipo[$pos]='p_adic';
								$color[$pos]='#F3F781';
							
								$p_examen_adicional_ant[$pos]=$rs_p_adic->fields['examen_adicional'];
								$p_abv_examen_ant[$pos]=$rs_p_adic->fields['abv_examen'];
								$id_encab[$pos]=$rs_p_adic->fields['id_exa_adicional_periodo'];
								$id_aux_p_adic=$rs_p_adic->fields['id_exa_adicional_periodo'];
							}
				
							$pertenece[$pos_id]=$id_aux_p_adic;
							$position_id[$pos_id]=$pos_id;
							$id[$pos_id]=$rs_p_adic->fields['id_exa_adicional_periodo'];
							$tipo_id[$pos_id]='p_adic';//print '  mi pos222: '.$pos_id;
							$pos_id=$pos_id+1;
						
						$rs_p_adic->MoveNext();
						}
						
					$rs_p_exa->MoveNext();
					}
					//----------------EXAMENES Y EXAMENES ADICIONALES DEL PERIODO EVALUATIVO----------------
					
					
					$pos_libreta[$pos_p_lib]=end($pos_libreta)+1;				
				}
				else
				$no_todos_periodos=1;
				
				//print 'no_todos_periodos: '.$no_todos_periodos;
				
			$rs_p->MoveNext();
			}
			
			for($k=0;$k<count($pos_p_adic_lib);$k++)
			{
				$pos_libreta[$pos_p_adic_lib[$k]]=end($pos_libreta)+1;
			}
			
			if($no_todos_periodos==0)
			{
				//----------------EXAMENES Y EXAMENES ADICIONALES DEL PERIODO LECTIVO----------------
				$sql_l_exa="SELECT id_examen_periodo_lec, examen_lec, abv_tipo_examen_lec, peso
				FROM n_examen_periodo_lec, n_periodo_lectivo, n_conf_academica
				WHERE 1
				AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
				AND n_examen_periodo_lec.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
				AND n_periodo_lectivo.id_periodo_lectivo='".$rs_l->fields['id_periodo_lectivo']."'			
				AND n_conf_academica.activa='1'
				ORDER BY examen_lec";//print $sql_l_exa;//die();//AND n_examen_periodo_lec.id_asignatura='".$id_asignatura."'
				$rs_l_exa=$db->Execute($sql_l_exa) or die($db->ErrorMsg());
				
				for($l_exa=0;$l_exa<$rs_l_exa->RecordCount();$l_exa++)
				{	
					if($rs_l_exa->fields['peso']!=0)
					{
						if(!in_array($rs_l_exa->fields['examen_lec'], $l_examen_lec_ant) OR !in_array($rs_l_exa->fields['abv_tipo_examen_lec'], $l_abv_tipo_examen_lec_ant))
						{
							$pos=$pos+1;
							$actividad[$pos]=$rs_l_exa->fields['examen_lec'];
							$abv[$pos]=$rs_l_exa->fields['abv_tipo_examen_lec'];
							$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, comment: false, renderer: "html"}';
							$position[$pos]=$pos;
							$tipo[$pos]='l_exa';
							$color[$pos]='#FA8258';
							
							$l_examen_lec_ant[$pos]=$rs_l_exa->fields['examen_lec'];
							$l_abv_tipo_examen_lec_ant[$pos]=$rs_l_exa->fields['abv_tipo_examen_lec'];
							$id_encab[$pos]=$rs_l_exa->fields['id_examen_periodo_lec'];
							$pertenece[$pos_id]=$rs_l_exa->fields['id_examen_periodo_lec'];
							
							$pos_libreta[$pos]=$pos_libreta[$pos_p_lib]+1;
						}
						else
						{
							$pos_arr=array_search($rs_l_exa->fields['examen_lec'], $actividad);//print 'pos_arr:'.$pos_arr;
							$pertenece[$pos_id]=$id_encab[$pos_arr];
						}
						
						$position_id[$pos_id]=$pos_id;
						$id[$pos_id]=$rs_l_exa->fields['id_examen_periodo_lec'];
						$tipo_id[$pos_id]='l_exa';
						$pos_id=$pos_id+1;
					}
					
					$sql_l_adic="SELECT id_exa_adicional_lectivo, examen_adicional, abv_examen, tipo_examen, opcional
					FROM n_examen_adicional, n_tipo_examen, n_exa_adicional_lectivo, n_examen_periodo_lec, n_periodo_lectivo, n_conf_academica
					WHERE 1
					AND n_examen_adicional.id_examen_adicional=n_exa_adicional_lectivo.id_examen_adicional
					AND n_tipo_examen.id_tipo_examen=n_exa_adicional_lectivo.id_tipo_examen
					AND n_exa_adicional_lectivo.id_examen_periodo_lec=n_examen_periodo_lec.id_examen_periodo_lec
					AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica					
					AND n_examen_periodo_lec.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
					AND n_examen_periodo_lec.id_examen_periodo_lec='".$rs_l_exa->fields['id_examen_periodo_lec']."'
					AND n_conf_academica.activa='1' ORDER BY n_exa_adicional_lectivo.orden";//print '<br><br>'.$sql_l_adic.'<br><br>';//die();//, actividad.fecha
					$rs_l_adic=$db->Execute($sql_l_adic) or die($db->ErrorMsg());
					
					for($l_adic=0;$l_adic<$rs_l_adic->RecordCount();$l_adic++)
					{
						if(!in_array($rs_l_adic->fields['examen_adicional'], $l_examen_adicional_ant) OR !in_array($rs_l_adic->fields['abv_examen'], $l_abv_examen_ant))
						{
							$pos=$pos+1;
							$actividad[$pos]=$rs_l_adic->fields['examen_adicional'];
							$abv[$pos]=$rs_l_adic->fields['abv_examen'];
							$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, comment: false, renderer: "html"}';
							$position[$pos]=$pos;
							$tipo[$pos]='l_adic';
							$color[$pos]='#CEF6CE';
							
							$l_examen_adicional_ant[$pos]=$rs_l_adic->fields['examen_adicional'];
							$l_abv_examen_ant[$pos]=$rs_l_adic->fields['abv_examen'];
							$id_encab[$pos]=$rs_l_adic->fields['id_exa_adicional_lectivo'];
							$pertenece[$pos_id]=$rs_l_adic->fields['id_exa_adicional_lectivo'];
							
							if(isset($pos_libreta[$pos-1]))
							$pos_libreta[$pos]=end($pos_libreta)+1;
							else
							$pos_libreta[$pos]=$pos_libreta[$pos_p_lib]+1;
						}
						else
						{
							$pos_arr=array_search($rs_l_adic->fields['examen_adicional'], $actividad);//print 'pos_arr:'.$pos_arr;
							$pertenece[$pos_id]=$id_encab[$pos_arr];
						}

						$position_id[$pos_id]=$pos_id;
						$id[$pos_id]=$rs_l_adic->fields['id_exa_adicional_lectivo'];
						$tipo_id[$pos_id]='l_adic';//print '  id: '.$rs_l_adic->fields['id_exa_adicional_lectivo'].' pertenece: '.$pertenece[$pos_id].'<br>';
						$pos_id=$pos_id+1;
						
					$rs_l_adic->MoveNext();
					}
				
				$rs_l_exa->MoveNext();
				}
				//----------------EXAMENES Y EXAMENES ADICIONALES DEL PERIODO LECTIVO----------------
					
			}		
				
			$pos_libreta[$pos_l_lib]=$pos_libreta[$pos]+1;			
			
		$rs_l->MoveNext();
		}
	
		$varios_arreglos=array();
		$varios_arreglos[0]=array('color'=>$color, 'id'=>$id, 'id_encab'=>$id_encab, 'actividad'=>$actividad, 'abv'=>$abv, 'column'=>$column, 'tipo'=>$tipo, 'tipo_id'=>$tipo_id, 'position'=>$position, 'position_id'=>$position_id, 'pertenece'=>$pertenece, 'pos_libreta'=>$pos_libreta);//print count($data);

		return $varios_arreglos;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function encabezado($db)
	{
		$pos=0;$pos_id=1;$pos_libreta=array();
		
		$l_examen_lec_ant=array();
		$l_abv_tipo_examen_lec_ant=array();
		
		$l_examen_adicional_ant=array();
		$l_abv_examen_ant=array();
		
		$sql_l="SELECT id_periodo_lectivo, periodo_lectivo
		FROM n_periodo_lectivo, n_conf_academica
		WHERE 1
		AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica		
		AND n_conf_academica.activa='1'";//print $sql_p;die();
		$rs_l=$db->Execute($sql_l) or die($db->ErrorMsg());
		
		for($l=0;$l<$rs_l->RecordCount();$l++)
		{
			$pos=$pos+1;
			$pos_l_lib=$pos;
			$actividad[$pos]=$rs_l->fields['periodo_lectivo'];
			$abv[$pos]='A&ntilde;o';
			$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, renderer: "html"}';
			$tipo[$pos]='l';
			$color[$pos]='#D8D8D8';
			$position[$pos]=$pos;
			$id_encab[$pos]=$rs_l->fields['id_periodo_lectivo'];

			$position_id[$pos_id]=$pos_id;
			$id[$pos_id]=$rs_l->fields['id_periodo_lectivo'];
			$tipo_id[$pos_id]='l';//print '  mi pos1: '.$pos_id;
			$pos_id=$pos_id+1;
				
			$sql_p="SELECT id_periodo_evaluativo, periodo_evaluativo, abv_periodo
			FROM n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
			WHERE 1
			AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
			AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo		
			AND n_conf_academica.activa='1'
			AND n_periodo_evaluativo.id_periodo_lectivo='".$rs_l->fields['id_periodo_lectivo']."'";//print $sql_p;die();
			$rs_p=$db->Execute($sql_p) or die($db->ErrorMsg());
			
			for($p=0;$p<$rs_p->RecordCount();$p++)
			{
				$pos=$pos+1;
				$pos_p_lib=$pos;
				$actividad[$pos]=$rs_p->fields['periodo_evaluativo'];
				$abv[$pos]=$rs_p->fields['abv_periodo'];
				$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, comment: false, renderer: "html"}';
				$tipo[$pos]='p';
				$color[$pos]='#2EFE9A';
				$position[$pos]=$pos;
				$id_encab[$pos]=$rs_p->fields['id_periodo_evaluativo'];

				
				$position_id[$pos_id]=$pos_id;
				$id[$pos_id]=$rs_p->fields['id_periodo_evaluativo'];
				$tipo_id[$pos_id]='p';//print '  mi pos1: '.$pos_id;
				$pos_id=$pos_id+1;
				
				$sql_s="SELECT id_subperiodo_evaluativo, subperiodo_evaluativo, abv_subperiodo
				FROM n_subperiodo_evaluativo, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
				WHERE 1
				AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
				AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
				AND n_subperiodo_evaluativo.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
				AND n_conf_academica.activa='1'
				AND n_subperiodo_evaluativo.id_periodo_evaluativo='".$rs_p->fields['id_periodo_evaluativo']."'";//print $sql_s.'<br><br><br>';//die();
				$rs_s=$db->Execute($sql_s) or die($db->ErrorMsg());
				
				for($s=0;$s<$rs_s->RecordCount();$s++)
				{	
					$pos=$pos+1;
					$actividad[$pos]=$rs_s->fields['subperiodo_evaluativo'];
					$abv[$pos]=$rs_s->fields['abv_subperiodo'];
					$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false, readOnly: true, renderer: "html"}';						
					$tipo[$pos]='s';
					$color[$pos]='#F5A9BC';
					$position[$pos]=$pos;
					$id_encab[$pos]=$rs_s->fields['id_subperiodo_evaluativo'];
					
					
					$position_id[$pos_id]=$pos_id;
					$id[$pos_id]=$rs_s->fields['id_subperiodo_evaluativo'];
					$tipo_id[$pos_id]='s';//print '  mi pos1: '.$pos_id;
					$pos_id=$pos_id+1;
					
					
					//print $pos_libreta[$pos-1].'<br>';
					if(end($pos_libreta)!=null)$pos_libreta[$pos]=end($pos_libreta)+1;
					else $pos_libreta[$pos]=1;
					
				$rs_s->MoveNext();
				}
				
			
				
				//----------------EXAMENES Y EXAMENES ADICIONALES DEL PERIODO EVALUATIVO----------------
				$sql_p_exa="SELECT id_examen_periodo_eval, examen_eval, abv_tipo_examen_eval, peso
				FROM n_examen_periodo_eval, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
				WHERE 1
				AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
				AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
				AND n_examen_periodo_eval.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
				AND n_periodo_evaluativo.id_periodo_evaluativo='".$rs_p->fields['id_periodo_evaluativo']."'				
				AND n_conf_academica.activa='1'
				ORDER BY examen_eval";//print $sql_p_exa.'<br><br><br>';//die();//AND n_examen_periodo_eval.id_asignatura='".$id_asignatura."'
				$rs_p_exa=$db->Execute($sql_p_exa) or die($db->ErrorMsg());
				
				$p_examen_eval_ant=array();
				$p_abv_tipo_examen_eval_ant=array();
				
				$p_examen_adicional_ant=array();
				$p_abv_examen_ant=array();
					
				for($p_exa=0;$p_exa<$rs_p_exa->RecordCount();$p_exa++)
				{	
					if($rs_p_exa->fields['peso']!=0)
					{
						if(!in_array($rs_p_exa->fields['examen_eval'], $p_examen_eval_ant) OR !in_array($rs_p_exa->fields['abv_tipo_examen_eval'], $p_abv_tipo_examen_eval_ant))
						{
							$pos=$pos+1;
							$actividad[$pos]=$rs_p_exa->fields['examen_eval'];
							$abv[$pos]=$rs_p_exa->fields['abv_tipo_examen_eval'];
							$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, comment: false, renderer: "html"}';
							$position[$pos]=$pos;	
							$tipo[$pos]='p_exa';
							$color[$pos]='#CEE3F6';
							
							$p_examen_eval_ant[$pos]=$rs_p_exa->fields['examen_eval'];
							$p_abv_tipo_examen_eval_ant[$pos]=$rs_p_exa->fields['abv_tipo_examen_eval'];	
							$id_encab[$pos]=$rs_p_exa->fields['id_examen_periodo_eval'];
							$id_aux_p_exa=$rs_p_exa->fields['id_examen_periodo_eval'];
							
							$pos_libreta[$pos]=end($pos_libreta)+1;
						}
						
						$pertenece[$pos_id]=$id_aux_p_exa;
						$position_id[$pos_id]=$pos_id;
						$id[$pos_id]=$rs_p_exa->fields['id_examen_periodo_eval'];
						$tipo_id[$pos_id]='p_exa';//print '  mi pos1: '.$pos;
						$pos_id=$pos_id+1;
					}
					
					$sql_p_adic="SELECT id_exa_adicional_periodo, examen_adicional, abv_examen, tipo_examen, opcional
					FROM n_examen_adicional, n_tipo_examen, n_exa_adicional_periodo, n_examen_periodo_eval, n_periodo_evaluativo, n_periodo_lectivo, n_conf_academica
					WHERE 1
					AND n_examen_adicional.id_examen_adicional=n_exa_adicional_periodo.id_examen_adicional
					AND n_tipo_examen.id_tipo_examen=n_exa_adicional_periodo.id_tipo_examen
					AND n_exa_adicional_periodo.id_examen_periodo_eval=n_examen_periodo_eval.id_examen_periodo_eval
					AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
					AND n_periodo_evaluativo.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
					AND n_examen_periodo_eval.id_periodo_evaluativo=n_periodo_evaluativo.id_periodo_evaluativo
					AND n_exa_adicional_periodo.id_examen_periodo_eval='".$rs_p_exa->fields['id_examen_periodo_eval']."'
					AND n_conf_academica.activa='1' ORDER BY n_exa_adicional_periodo.orden";//print $sql_p_adic;die();//, actividad.fecha
					$rs_p_adic=$db->Execute($sql_p_adic) or die($db->ErrorMsg());
					
					for($p_adic=0;$p_adic<$rs_p_adic->RecordCount();$p_adic++)
					{
						if(!in_array($rs_p_adic->fields['examen_adicional'], $p_examen_adicional_ant) OR !in_array($rs_p_adic->fields['abv_examen'], $p_abv_examen_ant))
						{
							$pos=$pos+1;
							if(!isset($p_adi))$p_adi=0;else $p_adi=$p_adi+1;$pos_p_adic_lib[$p_adi]=$pos;
							$actividad[$pos]=$rs_p_adic->fields['examen_adicional'];
							$abv[$pos]=$rs_p_adic->fields['abv_examen'];
							$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, comment: false, renderer: "html"}';
							$position[$pos]=$pos;							
							$tipo[$pos]='p_adic';
							$color[$pos]='#F3F781';
						
							$p_examen_adicional_ant[$pos]=$rs_p_adic->fields['examen_adicional'];
							$p_abv_examen_ant[$pos]=$rs_p_adic->fields['abv_examen'];
							$id_encab[$pos]=$rs_p_adic->fields['id_exa_adicional_periodo'];
							$id_aux_p_adic=$rs_p_adic->fields['id_exa_adicional_periodo'];
						}
			
						$pertenece[$pos_id]=$id_aux_p_adic;
						$position_id[$pos_id]=$pos_id;
						$id[$pos_id]=$rs_p_adic->fields['id_exa_adicional_periodo'];
						$tipo_id[$pos_id]='p_adic';//print '  mi pos222: '.$pos_id;
						$pos_id=$pos_id+1;
					
					$rs_p_adic->MoveNext();
					}
					
				$rs_p_exa->MoveNext();
				}
				//----------------EXAMENES Y EXAMENES ADICIONALES DEL PERIODO EVALUATIVO----------------
				
				
				$pos_libreta[$pos_p_lib]=end($pos_libreta)+1;				
				
				
			$rs_p->MoveNext();
			}
			
			for($k=0;$k<count($pos_p_adic_lib);$k++)
			{
				$pos_libreta[$pos_p_adic_lib[$k]]=end($pos_libreta)+1;
			}
			
			//----------------EXAMENES Y EXAMENES ADICIONALES DEL PERIODO LECTIVO----------------
			$sql_l_exa="SELECT id_examen_periodo_lec, examen_lec, abv_tipo_examen_lec, peso
			FROM n_examen_periodo_lec, n_periodo_lectivo, n_conf_academica
			WHERE 1
			AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica
			AND n_examen_periodo_lec.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
			AND n_periodo_lectivo.id_periodo_lectivo='".$rs_l->fields['id_periodo_lectivo']."'			
			AND n_conf_academica.activa='1'
			ORDER BY examen_lec";//print $sql_l_exa;//die();//AND n_examen_periodo_lec.id_asignatura='".$id_asignatura."'
			$rs_l_exa=$db->Execute($sql_l_exa) or die($db->ErrorMsg());
			
			for($l_exa=0;$l_exa<$rs_l_exa->RecordCount();$l_exa++)
			{	
				if($rs_l_exa->fields['peso']!=0)
				{
					if(!in_array($rs_l_exa->fields['examen_lec'], $l_examen_lec_ant) OR !in_array($rs_l_exa->fields['abv_tipo_examen_lec'], $l_abv_tipo_examen_lec_ant))
					{
						$pos=$pos+1;
						$actividad[$pos]=$rs_l_exa->fields['examen_lec'];
						$abv[$pos]=$rs_l_exa->fields['abv_tipo_examen_lec'];
						$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, comment: false, renderer: "html"}';
						$position[$pos]=$pos;
						$tipo[$pos]='l_exa';
						$color[$pos]='#FA8258';
						
						$l_examen_lec_ant[$pos]=$rs_l_exa->fields['examen_lec'];
						$l_abv_tipo_examen_lec_ant[$pos]=$rs_l_exa->fields['abv_tipo_examen_lec'];
						$id_encab[$pos]=$rs_l_exa->fields['id_examen_periodo_lec'];
						$pertenece[$pos_id]=$rs_l_exa->fields['id_examen_periodo_lec'];
						
						$pos_libreta[$pos]=$pos_libreta[$pos_p_lib]+1;
					}
					else
					{
						$pos_arr=array_search($rs_l_exa->fields['examen_lec'], $actividad);//print 'pos_arr:'.$pos_arr;
						$pertenece[$pos_id]=$id_encab[$pos_arr];
					}
					
					$position_id[$pos_id]=$pos_id;
					$id[$pos_id]=$rs_l_exa->fields['id_examen_periodo_lec'];
					$tipo_id[$pos_id]='l_exa';
					$pos_id=$pos_id+1;
				}
				
				$sql_l_adic="SELECT id_exa_adicional_lectivo, examen_adicional, abv_examen, tipo_examen, opcional
				FROM n_examen_adicional, n_tipo_examen, n_exa_adicional_lectivo, n_examen_periodo_lec, n_periodo_lectivo, n_conf_academica
				WHERE 1
				AND n_examen_adicional.id_examen_adicional=n_exa_adicional_lectivo.id_examen_adicional
				AND n_tipo_examen.id_tipo_examen=n_exa_adicional_lectivo.id_tipo_examen
				AND n_exa_adicional_lectivo.id_examen_periodo_lec=n_examen_periodo_lec.id_examen_periodo_lec
				AND n_periodo_lectivo.id_conf_academica=n_conf_academica.id_conf_academica					
				AND n_examen_periodo_lec.id_periodo_lectivo=n_periodo_lectivo.id_periodo_lectivo
				AND n_examen_periodo_lec.id_examen_periodo_lec='".$rs_l_exa->fields['id_examen_periodo_lec']."'
				AND n_conf_academica.activa='1' ORDER BY n_exa_adicional_lectivo.orden";//print '<br><br>'.$sql_l_adic.'<br><br>';//die();//, actividad.fecha
				$rs_l_adic=$db->Execute($sql_l_adic) or die($db->ErrorMsg());
				
				for($l_adic=0;$l_adic<$rs_l_adic->RecordCount();$l_adic++)
				{
					if(!in_array($rs_l_adic->fields['examen_adicional'], $l_examen_adicional_ant) OR !in_array($rs_l_adic->fields['abv_examen'], $l_abv_examen_ant))
					{
						$pos=$pos+1;
						$actividad[$pos]=$rs_l_adic->fields['examen_adicional'];
						$abv[$pos]=$rs_l_adic->fields['abv_examen'];
						$column[$pos]=',{format: "0.00",type: "numeric", className: "htRight", allowInvalid: false,readOnly: true, comment: false, renderer: "html"}';
						$position[$pos]=$pos;
						$tipo[$pos]='l_adic';
						$color[$pos]='#CEF6CE';
						
						$l_examen_adicional_ant[$pos]=$rs_l_adic->fields['examen_adicional'];
						$l_abv_examen_ant[$pos]=$rs_l_adic->fields['abv_examen'];
						$id_encab[$pos]=$rs_l_adic->fields['id_exa_adicional_lectivo'];
						$pertenece[$pos_id]=$rs_l_adic->fields['id_exa_adicional_lectivo'];
						
						if(isset($pos_libreta[$pos-1]))
						$pos_libreta[$pos]=end($pos_libreta)+1;
						else
						$pos_libreta[$pos]=$pos_libreta[$pos_p_lib]+1;
					}
					else
					{
						$pos_arr=array_search($rs_l_adic->fields['examen_adicional'], $actividad);//print 'pos_arr:'.$pos_arr;
						$pertenece[$pos_id]=$id_encab[$pos_arr];
					}

					$position_id[$pos_id]=$pos_id;
					$id[$pos_id]=$rs_l_adic->fields['id_exa_adicional_lectivo'];
					$tipo_id[$pos_id]='l_adic';//print '  id: '.$rs_l_adic->fields['id_exa_adicional_lectivo'].' pertenece: '.$pertenece[$pos_id].'<br>';
					$pos_id=$pos_id+1;
					
				$rs_l_adic->MoveNext();
				}
			
			$rs_l_exa->MoveNext();
			}
			//----------------EXAMENES Y EXAMENES ADICIONALES DEL PERIODO LECTIVO----------------
				
				
			$pos_libreta[$pos_l_lib]=$pos_libreta[$pos]+1;	
			
		$rs_l->MoveNext();
		}
	
		$varios_arreglos=array();
		$varios_arreglos[0]=array('color'=>$color, 'id'=>$id, 'id_encab'=>$id_encab, 'actividad'=>$actividad, 'abv'=>$abv, 'column'=>$column, 'tipo'=>$tipo, 'tipo_id'=>$tipo_id, 'position'=>$position, 'position_id'=>$position_id, 'pertenece'=>$pertenece, 'pos_libreta'=>$pos_libreta);//print count($data);

		return $varios_arreglos;
	}	
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_nota_examen_periodo($db, $id_clase_estudiante, $id_examen_periodo_eval)
	{		
		$sql_nota="SELECT nota, peso FROM nota_examen_periodo_eval, n_examen_periodo_eval
		WHERE nota_examen_periodo_eval.id_examen_periodo_eval=n_examen_periodo_eval.id_examen_periodo_eval 
		AND n_examen_periodo_eval.id_examen_periodo_eval='".$id_examen_periodo_eval."' 
		AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_nota.'<br>';
		$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
		
		if(isset($rs_nota->fields['nota']))
		{
			$examen_periodo['nota']=number_format(round($rs_nota->fields['nota'], 2), 2, ".", "");//print $e.' - '.$a;
		}
		else
		$examen_periodo['nota']='';
		
		return $examen_periodo;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function consulta_nota_examen_periodo_adicional($db, $id_clase_estudiante, $id_exa_adicional_periodo)
	{
		$sql_nota="SELECT nota, opcional, publica_nota FROM nota_exa_adicional_periodo, n_exa_adicional_periodo, n_examen_adicional, n_tipo_examen
		WHERE nota_exa_adicional_periodo.id_exa_adicional_periodo=n_exa_adicional_periodo.id_exa_adicional_periodo
		AND n_examen_adicional.id_examen_adicional=n_exa_adicional_periodo.id_examen_adicional
		AND n_tipo_examen.id_tipo_examen=n_exa_adicional_periodo.id_tipo_examen
		AND n_exa_adicional_periodo.id_exa_adicional_periodo='".$id_exa_adicional_periodo."' 
		AND id_clase_estudiante='".$id_clase_estudiante."'";//print $sql_nota.'<br>';
		$rs_nota=$db->Execute($sql_nota) or die($db->ErrorMsg());
		
		if(isset($rs_nota->fields['nota']))
		{
			$examen_periodo_adicional['nota']=number_format(round($rs_nota->fields['nota'], 2), 2, ".", "");//print $e.' - '.$a;			
		}
		else
		$examen_periodo_adicional['nota']='';
		
		return $examen_periodo_adicional;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	function comportamental_ponderado_aritmetico($peso_clases, $peso_inspector, $peso_tutor, $nota_gen_doc, $nota_gen_insp, $nota_gen_tut)
	{
		$nota_gen='';
		$peso_total=$peso_clases+$peso_inspector+$peso_tutor;
		
		if($peso_total==100 && $nota_gen_doc!='' && $nota_gen_insp!='' && $nota_gen_tut!='')
		{
			$a=bcdiv(bcmul($peso_clases, $nota_gen_doc, 10), 100, 10);
			$b=bcdiv(bcmul($peso_inspector, $nota_gen_insp, 10), 100, 10);
			$c=bcdiv(bcmul($peso_tutor, $nota_gen_tut, 10), 100, 10);			
			$nota_gen=$a+$b+$c;	
		}
		else
		{
			if($nota_gen_doc!='' && $nota_gen_insp!='' && $nota_gen_tut!='')
			{
				$a=bcadd(bcadd($nota_gen_insp, $nota_gen_doc, 10), $nota_gen_tut, 10);
				$nota_gen=bcdiv($a, 3, 10);
			}
			elseif($nota_gen_doc!='' && $nota_gen_insp!='')
			{
				$a=bcadd($nota_gen_insp, $nota_gen_doc, 10);
				$nota_gen=bcdiv($a, 2, 10);
			}
			
			elseif($nota_gen_doc!='' && $nota_gen_tut!='')
			{
				$a=bcadd($nota_gen_tut, $nota_gen_doc, 10);
				$nota_gen=bcdiv($a, 2, 10);
			}
			elseif($nota_gen_insp!='' && $nota_gen_tut!='')
			{
				$a=bcadd($nota_gen_tut, $nota_gen_insp, 10);
				$nota_gen=bcdiv($a, 2, 10);
			}
			elseif($nota_gen_doc!='')
			{
				$nota_gen=$nota_gen_doc;
			}
			elseif($nota_gen_insp!='')
			{
				$nota_gen=$nota_gen_insp;
			}
			elseif($nota_gen_tut!='')
			{
				$nota_gen=$nota_gen_tut;
			}
		}
		
	return $nota_gen;
	}
}
?>
