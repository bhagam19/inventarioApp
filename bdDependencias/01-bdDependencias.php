<?php

	$paginaLogs="../bdDependencias/01-bdDependencias";//para escribir los Logs
	$linkLogs="Dependencias";//para escribir los Logs
	include('../bdLogs/01-bdEscribirLogs.php');

	if(!isset($_SESSION['usuario'])){		
		echo '
			Lo siento. No tienes permisos suficientes.<br><br>
			Si crees que deberías poder ingresar a esta opción, ponte en contacto con el administrador.
			<br><br>		
		';		
	}else{		
		$codigo=$_SESSION['permiso'];
		if($codigo==6){
			echo'
				<div id="baseDeDatos">
					<div class="tituloBD">DEPENDENCIAS</div>
					<div id="reestablecerBD">
						<form enctype="multipart/form-data" action="../bdDependencias/06-cargarDependenciasExcel.php" method="POST">
							<input type="hidden" name="MAX_FILE_SIZE" value="512000" />
							<input name="subir_archivo" type="file" />
							<input type="submit" value="Reestablecer BD" />
						</form>
					</div>
					<div class="baseDeDatos2">						
						<table class="tablaBD">
							<thead>
								<tr class=stickyHead1>
									<th class="encabezadoTabla">COD <img src="../art/ordenarAZ.svg" title="Ordenar A-Z" onclick="ordenarDependencias(\'codDependencias\')"/></th>
									<th class="encabezadoTabla">DEPENDENCIA <img src="../art/ordenarAZ.svg" title="Ordenar A-Z" onclick="ordenarDependencias(\'nomDependencias\')"/></th>
									<th class="encabezadoTabla">UBICACIÓN <img src="../art/ordenarAZ.svg" title="Ordenar A-Z" onclick="ordenarDependencias(\'codUbicacion\')"/></th>
									<th class="encabezadoTabla" colspan="2">NOMBRE DEL RESPONSABLE <img src="../art/ordenarAZ.svg" title="Ordenar A-Z" onclick="ordenarDependencias(\'usuarioID\')"/></th>
								</tr>								
   							</thead>
   							<tbody id="actualizable">   								
   			';
			include('02-cargarDependencias.php');
			echo '				
							</tbody>	
						</table>
					</div>
				</div>
			';			
		}
	}
?>