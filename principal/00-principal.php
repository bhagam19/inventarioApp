<!doctype html>
<?php
    session_name("inventarioIEE");
    session_start();
?>
<html>
	<head>
	    <link rel="shortcut icon" href="../art/inventApp.png"/>
		<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
  		<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1, maximun-scale=1.0, minimun-scale=0.2"/>﻿ 
		<title>Inventario IEE</title>		
		<link rel="stylesheet" media="screen" type="text/css" href="00-principal.css"/>
		<script type="text/javascript" src="../jquery/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>		
  		<script type="text/javascript" src="00-principal.js"></script>
  		<script type="text/javascript" src="../bdAlmacenamiento/00-almacenamientos.js"></script>
  		<script type="text/javascript" src="../bdCategorias/00-categoriasBienes.js"></script>
  		<script type="text/javascript" src="../bdDependencias/00-dependencias.js"></script>
  		<script type="text/javascript" src="../bdEstadodelBien/00-estadodelBien.js"></script> 
  		<script type="text/javascript" src="../bdMantenimiento/00-mantenimiento.js"></script>
  		<script type="text/javascript" src="../bdUbicaciones/00-ubicaciones.js"></script> 	
  		<script type="text/javascript" src="../bdUsuarios/00-usuarios.js"></script> 
  		<script type="text/javascript" src="../bdBienes/00-bienes.js"></script>   
		<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  		<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>		
  		<script>
			$(function(){
				//alert("La resolución de tu pantalla es: " + screen.width + " x " + screen.height);				
				document.getElementById("contenedor").style.width = (screen.width*0.97)+ "px";
				document.getElementById("contenedor").style.height = (screen.height*0.70) + "px";
				//document.getElementById("menuNavegacion").style.height = (screen.height*0.715) + "px";
				if(screen.width<800){
					document.getElementById("contenedor").style.width = (screen.width*1.6)+ "px";
					document.getElementById("contenedor").style.height = (screen.height*1.2) + "px";
				}
				//document.getElementById("contenedor").style.height = "100px";
				//document.getElementById("contenedor").style.width = "50px";
			});			
	</script>	
	</head>	
	<body >
		<div id="contenedorGlobal">			
			<?php
				//$paginaLogs="../principal/principal";//para escribir los Logs
				//$linkLogs="Principal";//para escribir los Logs
				//include('../bdLogs/01-bdEscribirLogs.php');
				include('01-estructuraPermisosPpal.php');
			?>
		</div>
	</body>
</html>