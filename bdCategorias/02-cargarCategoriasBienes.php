<?php
    include('../conexion/datosConexion.php');
	setlocale(LC_MONETARY,"es_CO"); //para establecer el localismo para la moneda	
	$tabla="categoriasDeBienes";
	@$ordenarPor=$_REQUEST['ordenarPor'];	
	if($ordenarPor){			
		$sql01=mysqli_query($conexion,"SELECT * FROM ".$tabla." ORDER BY ".$ordenarPor);							
	}else{
		$sql01=mysqli_query($conexion,"SELECT * FROM ".$tabla);				
	}
	$respuesta="";
	$respuesta.='	
					<tr class="filaNuevo">									
						<td>Nuevo:</td>
						<td><input type="text" name"categoriaBien" id="categoriaBien" style="width:150px" onkeyup="showHint(this.value)"></td>
						<td class="img"><img src="../art/ok.svg" title="Guardar" onclick="registrarCategoriaBien()"/></td>
					</tr>
				';
	while($fila2=mysqli_fetch_array($sql01)){//$fila2 es un arr. multidemensional que contiene arr. con cada registro de cada tabla.
		$respuesta.='
					<tr>									
						
						<td style="text-align:center">'.$fila2["codCategoria"].'</td>
						<td style="text-align:left;!important" id="tdCategoriaBien'.$fila2["codCategoria"].'" title="Click para modificar" onclick="actualizarInputCategoria(this.id,'.$fila2["codCategoria"].',\'nomCategoria\',\'categoriaBienAct'.$fila2["codCategoria"].'\')">'.$fila2["nomCategoria"].'</td>	
						<td class="img"><img src="../art/eliminar.svg" title="Eliminar" onclick="eliminarRegistroCategoria('.$fila2["codCategoria"].')"/></td>											
					</tr>
			';		
	}	
	mysqli_free_result($sql01); 
	echo $respuesta;
	mysqli_close($conexion);
?>