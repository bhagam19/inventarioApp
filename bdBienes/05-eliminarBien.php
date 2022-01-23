<?php
	include('../conexion/datosConexion.php');
	session_start();	
	$codBien=$_REQUEST["codBien"];
	$tabla="bienes";	
	mysqli_query($conexion,"DELETE FROM ".$tabla." WHERE codBien=".$codBien);
	//Para reordenar los registros.
	mysqli_query($conexion,"SET @count = 0");
	mysqli_query($conexion,"UPDATE ".$tabla." SET ".$tabla.".codBien = @count:= @count + 1");
	mysqli_close($conexion);
?>