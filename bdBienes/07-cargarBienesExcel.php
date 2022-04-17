<?php
	error_reporting(0);
	$directorio = '../bdBienes/';
	$subir_archivo = $directorio.basename($_FILES['subir_archivo']['name']);
	move_uploaded_file($_FILES['subir_archivo']['tmp_name'], $subir_archivo);
	// ini_set('max_execution_time', 300); //300 seconds = 5 minutes
	ini_set('max_execution_time', 0); // for infinite time of execution
	require "../vendor/autoload.php"; //Agregamos la librería 
	include('../conexion/datosConexion.php');//Agregamos la conexión
	include('../mayIni.php');		
	use PhpOffice\PhpSpreadsheet\IOFactory;		
	use PhpOffice\PhpSpreadsheet\Shared\Date;
	$nombreArchivo = $subir_archivo; //Variable con el nombre del archivo
	if(@$instalacion==1){//viene del archivo instalacion.php
		include('mayIni.php');
		require 'Classes/PHPExcel/IOFactory.php'; //Agregamos la librería 
		include('conexion/datosConexion.php');//Agregamos la conexión	
		$nombreArchivo = 'bdBienes/inventario.xlsx'; //Variable con el nombre del archivo
	}else{//viene desde "cargar excel", dentro de la aplicacion.		
	}
	// Cargo la hoja de cálculo
	$objPHPExcel = IOFactory::load($nombreArchivo);	
	//Asigno la hoja de calculo activa
	$objPHPExcel->setActiveSheetIndex(0);
	//Obtengo el numero de filas del archivo
	$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();	
	//Borrar los registros actuales.
	mysqli_query($conexion,"SET FOREIGN_KEY_CHECKS=0");
	mysqli_query($conexion,"TRUNCATE TABLE bienes");	
	for ($i=2;$i<=$numRows-1;$i++) {		
    	$nomBien = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();    
		$detalleDelBien = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$detalleDelBien = str_replace("'", "\'", $detalleDelBien);//cambia (') por (\') para evitar el conflicto de comillas.
    	$serieDelBien=0;
		$origenDelBien = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
			if($origenDelBien==""){
				$origenDelBien="-";
			}
		$fechaAdquisicion = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		//echo $i."||".$fechaAdquisicion."|| Tipo: ". gettype($fechaAdquisicion);
			if(gettype($fechaAdquisicion)=="integer"){
				$fechaAdquisicion = date("Y-m-d",Date::excelToTimestamp($fechaAdquisicion));	
				//$fechaAdquisicion = Date::excelToTimestamp($fechaAdquisicion);			
			}else{
				$fechaAdquisicion = "1990-01-01";
			}
		//echo "||".$fechaAdquisicion;
		$precio = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();	
			if($precio==""){
				$precio=0;
			}  
			$precio = preg_replace('/\D/', '',$precio); //Quita todos los caracteres no numéricos.		
		$cantBien = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
			if($cantBien==""){
				$cantBien=0;
			}
		$codCategoria = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
		$codDependencias = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
			if($codDependencias==""){
				$codDependencias="-";
			}
		$usuarioID = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
		$codAlmacenamiento = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
    	$codEstado = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
			if($codEstado==""){
				$codEstado=0;
			}
		$codMantenimiento = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
			if($codMantenimiento==""){
				$codMantenimiento=0;
			}
		$observaciones = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();		
    	$nomBien=mayIni($nomBien);
		$detalleDelBien=mayIni($detalleDelBien);					
		$sql='INSERT INTO bienes (nomBien,detalleDelBien,serieDelBien,origenDelBien,fechaAdquisicion,precio,cantBien,codCategoria,codDependencias,usuarioID,codAlmacenamiento,codEstado,codMantenimiento,observaciones) 
		VALUES (\''.$nomBien.'\',\''.$detalleDelBien.'\',\''.$serieDelBien.'\',\''.$origenDelBien.'\',\''.$fechaAdquisicion.'\','.$precio.','.$cantBien.','.$codCategoria.','.$codDependencias.','.$usuarioID.','.$codAlmacenamiento.','.$codEstado.','.$codMantenimiento.',\''.$observaciones.'\')';
		//echo '<br>'.$sql;
		$conexion->query($sql);	
	}
echo "
  <html>
    <head>
      <meta HTTP-equiv='REFRESH' content='0;url=../principal/00-principal.php'>
    </head>
  </html>
  ";   
	
?>