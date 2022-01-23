<?php
	$paginaLogs="../bdClasesBienes/01-bdClasesBienes";//para escribir los Logs
	$linkLogs="Clases";//para escribir los Logs
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
				<div id="baseDeDatos">
				<div class="tituloBD">CLASES DE BIENES</div>
					<div class="baseDeDatos2">						
						<table class="tablaBD">
							<thead>
								<tr class="stickyHead1">
									<th class="encabezadoTabla">COD <img src="../art/ordenarAZ.svg" title="Ordenar A-Z" onclick="ordenarClases(\'codClase\')"/></th>
									<th class="encabezadoTabla" colspan="2">CLASES DE BIENES <img src="../art/ordenarAZ.svg" title="Ordenar A-Z" onclick="ordenarClases(\'nomClase\')"/></th>
								</tr>  								
   							</thead>
   							<tbody id="actualizable">   								
   			';
			include('02-cargarClasesBienes.php');
			echo '				
							</tbody>	
						</table>
					</div>
				</div>
			';			
		}

	}
?>