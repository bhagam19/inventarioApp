<?php
	error_reporting(-1);
  	$directorio = '../bdBienes/';
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
	mysqli_query($conexion,"TRUNCATE TABLE usuarios");
	echo '<table border=1>
			<tr>
				<td>nomBien</td>
				<td>detalleDelBien</td>
				<td>serieDelBien</td>
				<td>origenDelBien</td>
				<td>fechaAdquisicion</td>
				<td>precio</td>
				<td>cantBien</td>
				<td>codCategoria</td>
				<td>codDependencias</td>
				<td>usuarioID</td>
				<td>codAlmacenamiento</td>
				<td>codEstado</td>
				<td>codMantenimiento</td>
				<td>observaciones</td>
			</tr>';
	echo $numRows.' ||<br>';
	$MALOS="";	
	for ($i=2;$i<=$numRows-1;$i++) {
		$nomBien = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$detalleDelBien = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$detalleDelBien = str_replace("'", "\'", $detalleDelBien);//cambia (') por (\') para evitar el conflicto de comillas.
		$serieDelBien = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
			if($serieDelBien==""){
				$serieDelBien=0;
			}
		$origenDelBien = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
			if($origenDelBien==""){
				$origenDelBien="-";
			}
		$fechaAdquisicion = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
			if($fechaAdquisicion!=""){
				$fechaAdquisicion = date("Y-m-d",PHPExcel_Shared_Date::ExcelToPHP($fechaAdquisicion));
			}else{
				$fechaAdquisicion = "1990-01-01";
			}	
		$precio = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();	
			if($precio==""){
				$precio=0;
			}
		$precio = preg_replace('/\D/', '',$precio); //Quita todos los caracteres no numéricos.
		$cantBien = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
			if($cantBien==""){
				$cantBien=0;
			}
		//$codCategoria="";
		$codCategoria = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
			// echo $codCategoria.' ||<br>';
			/*
			$sql=mysqli_query($conexion,"SELECT * FROM categoriasDeBienes WHERE codCategoria=".$codCategoria);
			while($fila=mysqli_fetch_array($sql)){
				$codCategoria=$fila['codCategoria'];
			}
			*/
		$codDependencias = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
			/*
			$sql1=mysqli_query($conexion,'SELECT * FROM dependencias WHERE nomDependencias="'.$codDependencias.'"');
			while($fila=mysqli_fetch_array($sql1)){
				$codDependencias=$fila['codDependencias'];
			}
			if($codDependencias==""){
				$codDependencias="-";
			}
			*/
		$usuarioID = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
			/*
			$sql=mysqli_query($conexion,"SELECT * FROM usuarios WHERE usuarioCED=".$usuarioID);
			while($fila=mysqli_fetch_array($sql)){
				$usuarioID=$fila['usuarioID'];
			}
			if($usuarioID==""){
				$usuarioID=0;
			}
			*/			
		$codAlmacenamiento = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
			/*
			$sql=mysqli_query($conexion,'SELECT * FROM almacenamiento WHERE nomAlmacenamiento="'.$codAlmacenamiento.'"');
			while($fila=mysqli_fetch_array($sql)){
				$codAlmacenamiento=$fila['codAlmacenamiento'];
			}
			if($codAlmacenamiento==""){
				$codAlmacenamiento=0;
			}
			*/
		$codEstado = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
			$sql=mysqli_query($conexion,'SELECT * FROM estadoDelBien WHERE nomEstado="'.$codEstado.'"');
			while($fila=mysqli_fetch_array($sql)){
				$codEstado=$fila['codEstado'];
			}
			if($codEstado==""){
				$codEstado=0;
			}
		$codMantenimiento = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
			$sql=mysqli_query($conexion,'SELECT * FROM mantenimiento WHERE nomMantenimiento="'.$codMantenimiento.'"');
			while($fila=mysqli_fetch_array($sql)){
				$codMantenimiento=$fila['codMantenimiento'];
			}
			if($codMantenimiento==""){
				$codMantenimiento=0;
			}
		$observaciones = $objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
				
		$nomBien=mayIni($nomBien);
		$detalleDelBien=mayIni($detalleDelBien);
		
		echo '<tr>';
		echo '<td>'.$i.'</td>';
		echo '<td>'.$codCategoria.'</td>';
		echo '<td>'.$nomBien.'</td>';
		echo '<td>'.$detalleDelBien.'</td>';
		echo '<td>'.$serieDelBien.'</td>';
		echo '<td>'.$origenDelBien.'</td>';
		echo '<td>'.$fechaAdquisicion.'</td>';
		echo '<td>'.$precio.'</td>';
		echo '<td>'.$cantBien.'</td>';
		echo '<td>'.$codDependencias.'</td>';
		echo '<td>'.$usuarioID.'</td>';
		echo '<td>'.$codAlmacenamiento.'</td>';	
		echo '<td>'.$codEstado.'</td>';
		echo '<td>'.$codMantenimiento.'</td>';
		echo '<td>'.$observaciones.'</td>';
		echo '</tr>';
			
		$sql='INSERT INTO bienes (nomBien, detalleDelBien, serieDelBien, origenDelBien, fechaAdquisicion, precio, cantBien,codCategoria,codDependencias,usuarioID,codAlmacenamiento,codEstado,codMantenimiento,observaciones) 
		VALUES (\''.$nomBien.'\',\''.$detalleDelBien.'\',\''.$serieDelBien.'\',\''.$origenDelBien.'\',\''.$fechaAdquisicion.'\','.$precio.','.$cantBien.','.$codCategoria.','.$codDependencias.','.$usuarioID.','.$codAlmacenamiento.','.$codEstado.','.$codMantenimiento.',\''.$observaciones.'\')';
		
		if(!mysqli_query($conexion,$sql)){
			echo "NO ".$i."<BR>";
			$MALOS++;
		}
	}

	echo '</table>';

	if($MALOS==0){
		echo "Se guardaron todos los registros de manera existosa!!!!";
	}else{
		echo "No se pudieron guardar ".$MALOS." registros!!!";		
	}
	
?>