<?php
include("variables.php");
include($x."plantillas/sec_header.php");

?>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->

<form name="frm" id="frm" method="post" action="" >          
	<table class="login">
		<tr>		
			<td class="intro_sup"> 
				<div align="center">
					<h2>Restaurar contrase&ntilde;a</h2>
					<br>
					<input type="email" class="auth" id="email"  name="email" placeholder="Escribe el email asociado a tu cuenta para recuperar tu contrase&ntilde;a" required>
					<br><br>				
					<input type="submit" class="boton" value="Recuperar contrase&ntilde;a" >
					<br><br>
				</div>
			</td>
		</tr>

	</table>
	<br>
	<div id="mensaje"></div>
</form>
<script src="reset_clave/js/jquery-1.11.1.min.js"></script>
<script src="reset_clave/js/bootstrap.min.js"></script>
<script>
  $(document).ready(function(){
    $("#frm").submit(function(event){
      event.preventDefault();
      $.ajax({
        url:'reset_clave/validaremail.php',
        type:'post',
        dataType:'json',
        data:$("#frm").serializeArray()
      }).done(function(respuesta){
        $("#mensaje").html(respuesta.mensaje);
        $("#email").val('');
      });
    });
  });
</script>
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<!--Incertar Contenido Aqui-->
<?php
 include($x."plantillas/sec_footer.php");
?>

