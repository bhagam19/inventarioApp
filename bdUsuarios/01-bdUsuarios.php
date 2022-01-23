<?php	
	$paginaLogs="../bdUsuarios/01-bdUsuarios";//para escribir los Logs
	$linkLogs="Usuarios";//para escribir los Logs
	include('../bdLogs/01-bdEscribirLogs.php');
	if(!isset($_SESSION['usuario'])){		
		echo'
			Lo siento. No tienes permisos suficientes.<br><br>
			Si crees que deberías poder ingresar a esta opción, ponte en contacto con el administrador.
			<br><br>
		';
	}else{		
		$codigo=$_SESSION['permiso'];
		if($codigo==6){
			echo'
			<div class="tituloBD">ADMINISTRACIÓN DE USUARIOS</div>
			<div id="reestablecerBD">
				<form enctype="multipart/form-data" action="../bdUsuarios/06-cargarUsuariosExcel.php" method="POST">
					<input type="hidden" name="MAX_FILE_SIZE" value="512000" />
					<input name="subir_archivo" type="file" />
					<input type="submit" value="Reestablecer BD" />
				</form>						
			</div>
				<div id="baseDeDatos">
					<div class="baseDeDatos2">																		
						<table class="tablaBD">
							<thead >
								<tr class="stickyHead1">
									<th class="encabezadoTabla">ID <img src="../art/ordenarAZ.svg" title="Ordenar A-Z" onclick="ordenarUsuario(\'usuarioID\',0)"/><img class="imgOrden" src="../art/ordenarZA.svg" onclick="ordenarUsuario(\'usuarioID\',1)"/></th>
									<th class="encabezadoTabla">DOC. IDENTIDAD <img src="../art/ordenarAZ.svg" title="Ordenar A-Z" onclick="ordenarUsuario(\'usuarioCED\',0)"/><img class="imgOrden" src="../art/ordenarZA.svg" onclick="ordenarUsuario(\'usuarioCED\',1)"/></th>
									<th class="encabezadoTabla">APELLIDOS <img src="../art/ordenarAZ.svg" title="Ordenar A-Z" onclick="ordenarUsuario(\'apellidos\',0)"/><img class="imgOrden" src="../art/ordenarZA.svg" onclick="ordenarUsuario(\'apellidos\',1)"/></th>
									<th class="encabezadoTabla">NOMBRES <img src="../art/ordenarAZ.svg" title="Ordenar A-Z" onclick="ordenarUsuario(\'nombres\',0)"/><img class="imgOrden" src="../art/ordenarZA.svg" onclick="ordenarUsuario(\'nombres\',1)"/></th>
									<th class="encabezadoTabla">USUARIO <img src="../art/ordenarAZ.svg" title="Ordenar A-Z" onclick="ordenarUsuario(\'usuario\',0)"/><img class="imgOrden" src="../art/ordenarZA.svg" onclick="ordenarUsuario(\'usuario\',1)"/></th>
									<th class="encabezadoTabla">CONTRASEÑA <img src="../art/ordenarAZ.svg" title="Ordenar A-Z" onclick="ordenarUsuario(\'contrasena\',0)"/><img class="imgOrden" src="../art/ordenarZA.svg" onclick="ordenarUsuario(\'contrasena\',1)"/></th>
									<th class="encabezadoTabla">RESPONSABLE <img src="../art/ordenarAZ.svg" title="Ordenar A-Z" onclick="ordenarUsuario(\'defUsuario\',0)"/><img class="imgOrden" src="../art/ordenarZA.svg" onclick="ordenarUsuario(\'defUsuario\',1)"/></th>
									<th class="encabezadoTabla" colspan="2">PERMISOS <img src="../art/ordenarAZ.svg" title="Ordenar A-Z" onclick="ordenarUsuario(\'permiso\',0)"/><img class="imgOrden" src="../art/ordenarZA.svg" onclick="ordenarUsuario(\'permiso\',1)"/></th>
								</tr> 								
   							</thead>
   							<tbody id="actualizable">   								
   			';
			include('02-cargarUsuarios.php');
			echo '				
							</tbody>	
						</table>
					</div>
				</div>
			';			
		}
	}
?>