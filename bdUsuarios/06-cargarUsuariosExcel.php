<?php
	error_reporting(-1);
    $directorio = '../bdUsuarios/';
    $subir_archivo = $directorio.basename($_FILES['subir_archivo']['name']);
    move_uploaded_file($_FILES['subir_archivo']['tmp_name'], $subir_archivo);    
	// ini_set('max_execution_time', 300); //300 seconds = 5 minutes
	ini_set('max_execution_time', 0); // for infinite time of execution
	require "../vendor/autoload.php"; //Agregamos la librería 
	include('../conexion/datosConexion.php');//Agregamos la conexión
	include('../mayIni.php');		
	use PhpOffice\PhpSpreadsheet\IOFactory;			
	$nombreArchivo = $subir_archivo; //Variable con el nombre del archivo
	if(@$instalacion==1){//viene del archivo instalacion.php
		include('mayIni.php');
		require 'Classes/PHPExcel/Autoloader.php'; //Agregamos la librería 
		include('conexion/datosConexion.php');//Agregamos la conexión	
		$nombreArchivo = $subir_archivo; //Variable con el nombre del archivo
	}else{//viene desde "cargar excel", dentro de la aplicacion.		
	}
	// Cargo la hoja de cálculo
	$documento = IOFactory::load($nombreArchivo);	
	//Asigno la hoja de calculo activa
	$documento->setActiveSheetIndex(0);
	//Obtengo el numero de filas del archivo
	$numRows = $documento->setActiveSheetIndex(0)->getHighestRow();	
	//Borrar los registros actuales.
	mysqli_query($conexion,"SET FOREIGN_KEY_CHECKS=0");
	mysqli_query($conexion,"TRUNCATE TABLE usuarios");	
	for ($i=2;$i<=$numRows;$i++) {		
		$usuarioCED = $documento->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$usuario = $documento->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$contrasena = $documento->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$nombres = $documento->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$apellidos = $documento->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		$defUsuario = $documento->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
		$permiso = $documento->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();		
		$nombres=mayIni($nombres);
		$apellidos=mayIni($apellidos);
        echo $nombres;
		$sql='	INSERT INTO usuarios (usuarioCED, usuario, contrasena, nombres, apellidos, defUsuario,permiso) 
				VALUES ('.$usuarioCED.','.$usuario.',\''.$contrasena.'\',\''.$nombres.'\',\''.$apellidos.'\','.$defUsuario.','.$permiso.')';	
	    mysqli_query($conexion,$sql);
	}	
    header('Location:' . getenv('HTTP_REFERER'));
?>