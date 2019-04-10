<?php


$acc_genero=1;
$acc_pais=1;
$tipo_sangre=1;	
zzz
if($acc_genero || $acc_pais){?>
[null,'M&oacute;dulos',null,null,'M&oacute;dulos del sistema ERP.',
	
	<?php if($acc_genero){?>	
	['<img src="http://'+dir+site+img+'/rrhh.png" >','Recursos Humanos','http://'+dir+site+'/pag/panel/modulo.php?modulo=rrhh',null,'Recursos Humanos.'],
	<?php }?>	
	
	<?php if($acc_pais){?>
	['<img src="http://'+dir+site+img+'/adm.png" >','Admisiones','http://'+dir+site+'/pag/panel/modulo.php?modulo=adm',null,'Admisiones.'],
	<?php }?>
	
	<?php if($tipo_sangre){?>
	['<img src="http://'+dir+site+img+'/pen.png" >','Pensiones','http://'+dir+site+'/pag/panel/modulo.php?modulo=pen',null,'Pensiones.'],
	<?php }?>
	
	<?php if($acc_genero){?>	
	['<img src="http://'+dir+site+img+'/3st.png" >','Servicios T&eacute;nicos','http://'+dir+site+'/pag/panel/modulo.php?modulo=3st',null,'Servicios T&eacute;nicos.'],
	<?php }?>	
	
	<?php if($acc_pais){?>
	['<img src="http://'+dir+site+img+'/aca.png" >','Acad&eacute;mico','http://'+dir+site+'/pag/panel/modulo.php?modulo=aca',null,'Acad&eacute;mico.'],
	<?php }?>
	
],
<?php }

?>