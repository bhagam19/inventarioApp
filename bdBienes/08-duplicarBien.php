<?php
	include('../conexion/datosConexion.php');	
	session_start();
	//Obtener variables.
	$id=$_REQUEST['id'];
	$codBien=0;
    $sql=mysqli_query($conexion, "SELECT MAX(codBien) AS codBien from bienes");
    if($row = mysqli_fetch_row($sql)){
        $codBien = trim($row[0]+1);
    }
	mysqli_query($conexion,"ALTER TABLE bienes AUTO_INCREMENT=".$codBien);
	$sql1=mysqli_query($conexion,"SELECT * FROM bienes WHERE codBien=".$id);
	while($f=mysqli_fetch_array($sql1)){
		$sql2= mysqli_query($conexion,"INSERT INTO bienes (nomBien,detalleDelBien,origenDelBien,fechaAdquisicion,precio,cantBien,codCategoria,
															codDependencias,usuarioID,codAlmacenamiento,codEstado,codMantenimiento,observaciones) 
								        VALUES ('".$f['nomBien']."','".$f['detalleDelBien']."','".$f['origenDelBien']."','".$f['fechaAdquisicion']."'
                                        ,".$f['precio'].",".$f['cantBien'].",".$f['codCategoria'].",".$f['codDependencias'].",".$f['usuarioID']."
                                        ,".$f['codAlmacenamiento'].",".$f['codEstado'].",".$f['codMantenimiento'].",'".$f['observaciones']."')");
	}
    $sql3=mysqli_query($conexion, "SELECT MAX(codBien) AS codBien from bienes");
    if($row = mysqli_fetch_row($sql3)){
        $codBien = trim($row[0]);
    }
    $sql4=mysqli_query($conexion,"SELECT * FROM detallesDeBienes WHERE codBien=".$id);
    while($f2=mysqli_fetch_array($sql4)){
		$sql5=mysqli_query($conexion,"INSERT INTO detallesDeBienes (codBien, carEsp, tamano, material, color, marca, otra) 
									VALUES (".$codBien.",'".$f2['carEsp']."','".$f2['tamano']."','".$f2['material']."','".$f2['color']."','".$f2['marca']."','".$f2['otra']."')");
	}
    echo $codBien;
	mysqli_close($conexion);
?>