<?php
	session_start();
	include('../conexion/datosConexion.php');
	$columnas =array('codBien','nomBien','detalleDelBien','serieDelBien','origenDelBien','fechaAdquisicion','precio','cantBien','codCategoria','codDependencias','codEstado','codAlmacenamiento','codMantenimiento');
		//Obtener variables.
	$id=$_REQUEST['id'];
	$vlr1=$_REQUEST['vlr1'];
	$vlr2=$_REQUEST['vlr2'];
	$vlr3=$_REQUEST['vlr3'];
	$vlr4=$_REQUEST['vlr4'];
	$vlr5=$_REQUEST['vlr5'];
	$vlr6=$_REQUEST['vlr6'];
	$respuesta="";
	if($vlr1==""){
		$vlr1="N/A";
	}
	if($vlr2==""){
		$vlr2="N/A";
	}
	if($vlr3==""){
		$vlr3="N/A";
	}
	if($vlr4==""){
		$vlr4="N/A";
	}
	if($vlr5==""){
		$vlr5="N/A";
	}
	if($vlr6==""){
		$vlr6="N/A";
	}	
	$sql01=mysqli_query($conexion,"SELECT * FROM detallesDeBienes WHERE codBien=".$id);    
    $row1 = mysqli_num_rows($sql01); //Verificamos cuántas filas cumplen con la consulta "$sql"
	if($row1==0){			
		mysqli_query($conexion,"INSERT INTO detallesDeBienes (codBien, carEsp, tamano, material, color, marca, otra) VALUES (".$id.",'".$vlr1."','".$vlr2."','".$vlr3."','".$vlr4."','".$vlr5."','".$vlr6."')");
	}else{
		mysqli_query($conexion,"UPDATE detallesDeBienes SET carEsp ='".$vlr1."', tamano ='".$vlr2."',  material ='".$vlr3."', color ='".$vlr4."', marca ='".$vlr5."', otra ='".$vlr6."' WHERE codBien=".$id);
	}
	$valor="";
	if(isset($_SESSION['usuario'])){	
		$codigo=$_SESSION['permiso'];
		if($codigo==1){
			$sql01=mysqli_query($conexion,"SELECT * FROM modificacionesBienes WHERE codBien=".$id);    
			$row2 = mysqli_num_rows($sql01); //Verificamos cuántas filas cumplen con la consulta "$sql"
			$valor=$vlr1."; ".$vlr2."; ".$vlr3."; ".$vlr4."; ".$vlr5."; ".$vlr6; 
			if($row2==0){
				mysqli_query($conexion,"INSERT INTO modificacionesBienes (codBien, detalleDelBien) VALUES (".$id.",'".$valor."')");
			}else{
				mysqli_query($conexion,"UPDATE modificacionesBienes SET detalleDelBien ='".$valor."' WHERE codBien=".$id);
			}
		}else if($codigo==6){
			$valor=$vlr1."; ".$vlr2."; ".$vlr3."; ".$vlr4."; ".$vlr5."; ".$vlr6;			
			mysqli_query($conexion,"UPDATE bienes SET detalleDelBien='".$valor."' WHERE codBien=".$id);
		}
	}
	$cnt=0;
	/*Se recorren las tablas bienes y modificacionesBienes y se compara el valor de cada campo
	cada coincidencia se suma a la variable $cnt*/
	foreach($columnas as $columna){
		$sql01=mysqli_query($conexion,"SELECT ".$columna." FROM modificacionesBienes WHERE codBien=".$id);
		while($f01=mysqli_fetch_array($sql01)){
			$vl01=$f01[$columna];			
		}
		$sql02=mysqli_query($conexion,"SELECT ".$columna." FROM bienes WHERE codBien=".$id);
		while($f02=mysqli_fetch_array($sql02)){
			$vl02=$f02[$columna];
		}		
		if(@$vl01==Null){
			$cnt++;
		}else if($vl01==$vl02){
			$cnt++;
		}
	}
	//Si el $cnt es igual al número de campos (es decir, 14) se entiende que la modificación ya fue incluida en bienes y se puede borrar.
	if($cnt==14){
		mysqli_query($conexion,"DELETE FROM modificacionesBienes WHERE codBien=".$id);
	}	
	//echo $row2; Este echo es solo para hacer seguimiento.
	mysqli_close($conexion);
?>