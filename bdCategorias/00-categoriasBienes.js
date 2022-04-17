function ordenarCategorias(filtro){
	//alert(filtro);
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET","../bdCategorias/02-cargarCategoriasBienes.php?ordenarPor="+filtro,false);
	xmlhttp.send();
	document.getElementById("actualizable").innerHTML=""
	document.getElementById("actualizable").innerHTML=xmlhttp.responseText.trim();	
}
function registrarCategoriaBien(){
	var categoriaBien= document.getElementById("categoriaBien").value;  
  categoriaBien=ucwords(categoriaBien.toLowerCase());
	//alert(categoriaBien);
	if(categoriaBien==""){
		alert("Por favor, ingrese una categoria de bien. Por ejemplo, \"Muebles\".");
		document.getElementById("categoriaBien").focus();
		return false;
	}else{
		var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "../bdCategorias/03-crearCategoriaBien.php?categoriaBien="+categoriaBien, false);
    	xmlhttp.send();
	    if(xmlhttp.responseText.trim()=="si"){
	    	//alert("La categoria de bien "+categoriaBien+" fue registrada con exito.");
			xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET","../bdCategorias/02-cargarCategoriasBienes.php",false);
			xmlhttp.send();
			document.getElementById("actualizable").innerHTML=""
			document.getElementById("actualizable").innerHTML=xmlhttp.responseText.trim();	
        }else{
        	alert("La categoria de bien "+categoriaBien+" ya está registrada.");
        	document.getElementById("almacenamiento").value="";
    		document.getElementById("almacenamiento").focus();
    		return false;
        }    
	}		
}
function actualizarInputCategoria(tdId,numReg,campo,inpId){
	//alert(tdId+", "+numReg+", "+campo+", "+inpId);
	cancelarAccionCategoria();

	var td=document.getElementById(tdId);
	var contenido =	'<input type="text" id="'+inpId+'" value="'+td.innerHTML+'">'+" "+
		   			'<input type="image" style="width:10px; height:10px; position:relative; top:5px" src="../art/ok.svg" onclick="actualizarRegistroCategoria('+numReg+','+inpId+'.value,\''+campo+'\')">'+" "+
    				'<input type="image" style="width:10px; height:10px; position:relative; top: 5px" src="../art/cancelar.svg" onclick="cancelarAccionCategoria()">';
	td.innerHTML=contenido;
	td.onclick="";
	var obj =document.getElementById(inpId);
	obj.focus();
	if(obj.value!=""){
		obj.value+="";
	}	
}
function actualizarRegistroCategoria(id,valor,campo){
	//alert(id+", "+valor+", "+campo);  
	valor=ucwords(valor.toLowerCase());
	//alert(valor);
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", "../bdCategorias/04-actualizarCategoriaBien.php?id="+id+"&valor="+valor+"&campo="+campo, false);
	xmlhttp.send();
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET","../bdCategorias/02-cargarCategoriasBienes.php",false);
	xmlhttp.send();
	document.getElementById("actualizable").innerHTML=""
	document.getElementById("actualizable").innerHTML=xmlhttp.responseText.trim();	
}
function cancelarAccionCategoria(){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET","../bdCategorias/02-cargarCategoriasBienes.php",false);
	xmlhttp.send();
	document.getElementById("actualizable").innerHTML=""
	document.getElementById("actualizable").innerHTML=xmlhttp.responseText.trim();
}
function eliminarRegistroCategoria(id){
	//alert(id);
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET","../bdCategorias/05-eliminarCategoriaBien.php?codCategoria="+id,false);
	xmlhttp.send();
		
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET","../bdCategorias/02-cargarCategoriasBienes.php",false);
	xmlhttp.send();
	document.getElementById("actualizable").innerHTML=""
	document.getElementById("actualizable").innerHTML=xmlhttp.responseText.trim();
}