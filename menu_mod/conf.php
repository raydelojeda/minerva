<?php
//----SA----
//----SA----
//----SA----

$acc_rol=1;
$acc_accion=1;
$acc_elemento=1;
$acc_permiso=1;

if($acc_rol || $acc_accion || $acc_elemento || $acc_permiso){?>
[null,'Administraci&oacute;n',null,null,'Administraci&oacute;n del sistema.',

	<?php if($acc_rol || $acc_accion || $acc_elemento || $acc_permiso){?>
	['<img src="http://'+dir+site+img+'/seguridad.png" >','Control de acceso',null,null,'Control de accesos y permisos en el sistema.',
		
		<?php if($acc_rol){?>	
		['<img src="http://'+dir+site+img+'/rol.png" >','Rol','http://'+dir+site+'/seguridad/rol/lis_rol.php',null,'Rol del usuario en ele sistema.'],
		<?php }?>	
		
		<?php if($acc_accion){?>
		['<img src="http://'+dir+site+img+'/accion.png" >','Acci&oacute;n','http://'+dir+site+'/seguridad/accion/lis_accion.php',null,'Acciones a realizar en el sistema.'],
		<?php }?>
		
		<?php if($acc_elemento){?>
		['<img src="http://'+dir+site+img+'/elemento.png" >','Elemento','http://'+dir+site+'/seguridad/elemento/lis_elemento.php',null,'Elementos o tablas en el sistema.'],
		<?php }?>
		
		<?php if($acc_permiso){?>
		['<img src="http://'+dir+site+img+'/permiso.png" >','Permiso','http://'+dir+site+'/seguridad/permiso/lis_permiso.php',null,'Permisos en el sistema.'],
		<?php }?>
		
	],
	<?php }?>
],
<?php }
//----SA----
//----SA----
//----SA----
?>