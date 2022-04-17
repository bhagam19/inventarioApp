<?php
	include('../conexion/datosConexion.php');	
	session_start();
	//Obtener variables.
	$categoriaBien=$_REQUEST['categoriaBien'];	
	$tabla='categoriasDeBienes';
	$sql=mysqli_query($conexion,"SELECT * FROM ".$tabla);
	$contador=0;
	while($fila=mysqli_fetch_array($sql)){
		if($fila['nomCategoria']==$categoriaBien){
			$contador++;
		}
	}	
	if($contador==0){
		mysqli_query($conexion,"INSERT INTO ".$tabla." (nomCategoria) VALUES ('$categoriaBien')");
		echo "si";
	}else{	
		echo "no";
	}
	mysqli_close($conexion);
?>