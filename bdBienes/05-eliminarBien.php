<?php
	include('../conexion/datosConexion.php');
	session_start();	
	$codBien=$_REQUEST["codBien"];
	$tabla="bienes";	
	mysqli_query($conexion,"DELETE FROM ".$tabla." WHERE codBien=".$codBien);
	//Para reordenar los registros.
	mysqli_query($conexion,"SET @count = 0");
	mysqli_query($conexion,"UPDATE ".$tabla." SET ".$tabla.".codBien = @count:= @count + 1");
	mysqli_query($conexion,"DELETE FROM detallesDeBienes WHERE codBien=".$codBien);
	$sql=mysqli_query($conexion, "SELECT * FROM detallesDeBienes");
	while($f=mysqli_fetch_array($sql)){
		$fcb=intval($f['codBien']);
		if($fcb>$codBien){
			$fcb=$fcb-1;
			mysqli_query($conexion,"UPDATE detallesDeBienes SET codBien=".$fcb." WHERE codBien=".$f['codBien']);
		}
	}
	mysqli_close($conexion);
?>