
									<input type="hidden" name="var_checkbox" value="<?php echo $cadenacheckboxp;?>">
									<input type="hidden" name="var_aux" value="">
									<input type="hidden" name="camino" value="<?php echo $camino;?>">
									<input type="hidden" name="aux_submit" value="">
									<input type="hidden" name="l_sql" value="<?php echo $l_sql;?>">
<!--Fin Contenido-->

								</td>
							</tr>
						</table>
						<br>
					</td>
				</tr>				
			</table>
		</td>
	</tr>
	</table>
			<table class="footer">
				<tr>					
					<td class="footer"><?php echo $nombre_empresa . " - " . $nombre_sucursal;?></td>					
				</tr>
			</table>
	

</div>
<div id='menu1' class='portal' style="display:block; ">
	<div class="barra">
		<table class="tabla_barra" id="toolbar">
			<tr> 
				<td>				
					<?php 
						print "<font size='2'>".$titulo_listar."<font>";
						$obj->Botonera($l_botones,$rs_sesion,$elemento);
					?>				
				</td>
			</tr>								
		</table>
	</div>
</div>

 <!--fin contenido1-->
</form>
</body>
</html>