<?php
	include('../conexion/datosConexion.php');

	session_start();
	
	$codCategoria=$_REQUEST["codCategoria"];	

	$tabla="categoriasDeBienes";
	
	mysqli_query($conexion,"DELETE FROM ".$tabla." WHERE codCategoria=".$codCategoria);

	mysqli_close($conexion);

?>