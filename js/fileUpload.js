function _(el){
	return document.getElementById(el);
}

//funcion para el archivo etapa 1, subetapa 1
function uploadFile11(){
    
       document.getElementById("divProgress11").removeAttribute('hidden');

	var file = _("archivo11").files[0];
	// alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("archivo11", file);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler11, false);
	ajax.addEventListener("load", completeHandler11, false);
	ajax.addEventListener("error", errorHandler11, false);
	ajax.addEventListener("abort", abortHandler11, false);
	ajax.open("POST", "funcionalidad/parser_File.php");
	ajax.send(formdata);
        

}
function progressHandler11(event){
    
        $("#guardarArchivo11").addClass('disabled');
        $("#guardarArchivo11").attr('disabled','true');
	_("loaded_n_total11").innerHTML = "<b>Subida Exitosa: </b> "+event.loaded+" bytes de "+event.total+" bytes";
	var percent = (event.loaded / event.total) * 100;
	_("progressBar11").style.width = Math.round(percent)+"%"; 
        
        if(parseInt(_("progressBar11").style.width) < 40){
            $("#progressBar11").removeClass("progress-bar-success").addClass("progress-bar-danger");
        }
        if(parseInt(_("progressBar11").style.width) > 40){
            $("#progressBar11").removeClass("progress-bar-danger").addClass("progress-bar-warning");
        }
        if(parseInt(_("progressBar11").style.width) > 70){
            $("#progressBar11").removeClass("progress-bar-warning").addClass("progress-bar-success");
        }
        if(parseInt(_("progressBar11").style.width) === 100){
            $("#progressBar11").removeClass("progress-bar-success").addClass("progress-bar-default");
        }
	_("status11").innerHTML = Math.round(percent)+"% Subido... por favor espere";
}
function completeHandler11(event){
	_("status11").innerHTML = event.target.responseText;
	$("#guardarArchivo11").removeClass('disabled');
        $("#guardarArchivo11").removeAttr('disabled');
}
function errorHandler11(event){
	_("status11").innerHTML = "Subida Fallida";
}
function abortHandler11(event){
	_("status11").innerHTML = "Subida Abortada";
}
//Subetapas, etapa 2

function uploadFile21(){
    
       document.getElementById("divProgress21").removeAttribute('hidden');

	var file = _("archivo21").files[0];
	// alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("archivo21", file);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler21, false);
	ajax.addEventListener("load", completeHandler21, false);
	ajax.addEventListener("error", errorHandler21, false);
	ajax.addEventListener("abort", abortHandler21, false);
	ajax.open("POST", "funcionalidad/parser_File.php");
	ajax.send(formdata);
        

}
function progressHandler21(event){
    
        $("#guardarArchivo21").addClass('disabled');
        $("#guardarArchivo21").attr('disabled','true');
	_("loaded_n_total21").innerHTML = "<b>Subida Exitosa: </b> "+event.loaded+" bytes de "+event.total+" bytes";
	var percent = (event.loaded / event.total) * 100;
	_("progressBar21").style.width = Math.round(percent)+"%"; 
        
        if(parseInt(_("progressBar21").style.width) < 40){
            $("#progressBar21").removeClass("progress-bar-success").addClass("progress-bar-danger");
        }
        if(parseInt(_("progressBar21").style.width) > 40){
            $("#progressBar21").removeClass("progress-bar-danger").addClass("progress-bar-warning");
        }
        if(parseInt(_("progressBar21").style.width) > 70){
            $("#progressBar21").removeClass("progress-bar-warning").addClass("progress-bar-success");
        }
        if(parseInt(_("progressBar21").style.width) === 100){
            $("#progressBar21").removeClass("progress-bar-success").addClass("progress-bar-default");
        }
	_("status21").innerHTML = Math.round(percent)+"% Subido... por favor espere";
}
function completeHandler21(event){
	_("status21").innerHTML = event.target.responseText;
	$("#guardarArchivo21").removeClass('disabled');
        $("#guardarArchivo21").removeAttr('disabled');
}
function errorHandler21(event){
	_("status21").innerHTML = "Subida Fallida";
}
function abortHandler21(event){
	_("status13").innerHTML = "Subida Abortada";
}

// subir archivo etapa 1 sub etapa 2
function uploadFile22(){
    
       document.getElementById("divProgress22").removeAttribute('hidden');

	var file = _("archivo22").files[0];
	// alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("archivo22", file);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler22, false);
	ajax.addEventListener("load", completeHandler22, false);
	ajax.addEventListener("error", errorHandler22, false);
	ajax.addEventListener("abort", abortHandler22, false);
	ajax.open("POST", "funcionalidad/parser_File.php");
	ajax.send(formdata);
        

}
function progressHandler22(event){
    
        $("#guardarArchivo22").addClass('disabled');
        $("#guardarArchivo22").attr('disabled','true');
	_("loaded_n_total22").innerHTML = "<b>Subida Exitosa: </b> "+event.loaded+" bytes de "+event.total+" bytes";
	var percent = (event.loaded / event.total) * 100;
	_("progressBar22").style.width = Math.round(percent)+"%"; 
        
        if(parseInt(_("progressBar22").style.width) < 40){
            $("#progressBar22").removeClass("progress-bar-success").addClass("progress-bar-danger");
        }
        if(parseInt(_("progressBar22").style.width) > 40){
            $("#progressBar22").removeClass("progress-bar-danger").addClass("progress-bar-warning");
        }
        if(parseInt(_("progressBar22").style.width) > 70){
            $("#progressBar22").removeClass("progress-bar-warning").addClass("progress-bar-success");
        }
        if(parseInt(_("progressBar22").style.width) === 100){
            $("#progressBar22").removeClass("progress-bar-success").addClass("progress-bar-default");
        }
	_("status22").innerHTML = Math.round(percent)+"% Subido... por favor espere";
}
function completeHandler22(event){
	_("status22").innerHTML = event.target.responseText;
	$("#guardarArchivo22").removeClass('disabled');
        $("#guardarArchivo22").removeAttr('disabled');
}
function errorHandler22(event){
	_("status22").innerHTML = "Subida Fallida";
}
function abortHandler22(event){
	_("status22").innerHTML = "Subida Abortada";
}

// subir archivo etapa 2 sub etapa 3
function uploadFile23(){
    
       document.getElementById("divProgress23").removeAttribute('hidden');

	var file = _("archivo23").files[0];
	// alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("archivo23", file);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler23, false);
	ajax.addEventListener("load", completeHandler23, false);
	ajax.addEventListener("error", errorHandler23, false);
	ajax.addEventListener("abort", abortHandler23, false);
	ajax.open("POST", "funcionalidad/parser_File.php");
	ajax.send(formdata);
        

}
function progressHandler23(event){
    
        $("#guardarArchivo23").addClass('disabled');
        $("#guardarArchivo23").attr('disabled','true');
	_("loaded_n_total23").innerHTML = "<b>Subida Exitosa: </b> "+event.loaded+" bytes de "+event.total+" bytes";
	var percent = (event.loaded / event.total) * 100;
	_("progressBar23").style.width = Math.round(percent)+"%"; 
        
        if(parseInt(_("progressBar23").style.width) < 40){
            $("#progressBar23").removeClass("progress-bar-success").addClass("progress-bar-danger");
        }
        if(parseInt(_("progressBar23").style.width) > 40){
            $("#progressBar23").removeClass("progress-bar-danger").addClass("progress-bar-warning");
        }
        if(parseInt(_("progressBar23").style.width) > 70){
            $("#progressBar23").removeClass("progress-bar-warning").addClass("progress-bar-success");
        }
        if(parseInt(_("progressBar23").style.width) === 100){
            $("#progressBar23").removeClass("progress-bar-success").addClass("progress-bar-default");
        }
	_("status23").innerHTML = Math.round(percent)+"% Subido... por favor espere";
}
function completeHandler23(event){
	_("status23").innerHTML = event.target.responseText;
	$("#guardarArchivo23").removeClass('disabled');
        $("#guardarArchivo23").removeAttr('disabled');
}
function errorHandler23(event){
	_("status23").innerHTML = "Subida Fallida";
}
function abortHandler23(event){
	_("status23").innerHTML = "Subida Abortada";
}

function uploadFile31(){
    
       document.getElementById("divProgress31").removeAttribute('hidden');

	var file = _("archivo31").files[0];
	// alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("archivo31", file);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler31, false);
	ajax.addEventListener("load", completeHandler31, false);
	ajax.addEventListener("error", errorHandler31, false);
	ajax.addEventListener("abort", abortHandler31, false);
	ajax.open("POST", "funcionalidad/parser_File.php");
	ajax.send(formdata);
        

}
function progressHandler31(event){
    
        $("#guardarArchivo31").addClass('disabled');
        $("#guardarArchivo31").attr('disabled','true');
	_("loaded_n_total31").innerHTML = "<b>Subida Exitosa: </b> "+event.loaded+" bytes de "+event.total+" bytes";
	var percent = (event.loaded / event.total) * 100;
	_("progressBar31").style.width = Math.round(percent)+"%"; 
        
        if(parseInt(_("progressBar31").style.width) < 40){
            $("#progressBar31").removeClass("progress-bar-success").addClass("progress-bar-danger");
        }
        if(parseInt(_("progressBar31").style.width) > 40){
            $("#progressBar31").removeClass("progress-bar-danger").addClass("progress-bar-warning");
        }
        if(parseInt(_("progressBar31").style.width) > 70){
            $("#progressBar31").removeClass("progress-bar-warning").addClass("progress-bar-success");
        }
        if(parseInt(_("progressBar31").style.width) === 100){
            $("#progressBar31").removeClass("progress-bar-success").addClass("progress-bar-default");
        }
	_("status31").innerHTML = Math.round(percent)+"% Subido... por favor espere";
}
function completeHandler31(event){
	_("status31").innerHTML = event.target.responseText;
	$("#guardarArchivo31").removeClass('disabled');
        $("#guardarArchivo31").removeAttr('disabled');
}
function errorHandler31(event){
	_("status31").innerHTML = "Subida Fallida";
}
function abortHandler31(event){
	_("status31").innerHTML = "Subida Abortada";
}


function uploadFile32(){
    
       document.getElementById("divProgress32").removeAttribute('hidden');
    

	var file = _("archivo32").files[0];
	// alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("archivo32", file);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler32, false);
	ajax.addEventListener("load", completeHandler32, false);
	ajax.addEventListener("error", errorHandler32, false);
	ajax.addEventListener("abort", abortHandler32, false);
	ajax.open("POST", "funcionalidad/parser_File.php");
	ajax.send(formdata);
        

}
function progressHandler32(event){
        
        $("#guardarArchivo32").addClass('disabled');
        $("#guardarArchivo32").attr('disabled','true');
	_("loaded_n_total32").innerHTML = "<b>Subido: </b> "+event.loaded+" bytes de "+event.total+" bytes";
	var percent = (event.loaded / event.total) * 100;
	_("progressBar32").style.width = Math.round(percent)+"%"; 
        
        if(parseInt(_("progressBar32").style.width) < 40){
            $("#progressBar32").removeClass("progress-bar-success").addClass("progress-bar-danger");
        }
        if(parseInt(_("progressBar32").style.width) > 40){
            $("#progressBar32").removeClass("progress-bar-danger").addClass("progress-bar-warning");
        }
        if(parseInt(_("progressBar32").style.width) > 70){
            $("#progressBar32").removeClass("progress-bar-warning").addClass("progress-bar-success");
        }
        if(parseInt(_("progressBar32").style.width) === 100){
            $("#progressBar32").removeClass("progress-bar-success").addClass("progress-bar-default");
        }
	_("status32").innerHTML = Math.round(percent)+"% Subido... por favor espere";
}
function completeHandler32(event){
	_("status32").innerHTML = event.target.responseText;
	$("#guardarArchivo32").removeClass('disabled');
        $("#guardarArchivo32").removeAttr('disabled');
}
function errorHandler32(event){
	_("status32").innerHTML = "Subida Fallida";
}
function abortHandler32(event){
	_("status32").innerHTML = "Subida Abortada";
}

function uploadFile33(){
    
       document.getElementById("divProgress33").removeAttribute('hidden');
    

	var file = _("archivo33").files[0];
	// alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("archivo33", file);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler33, false);
	ajax.addEventListener("load", completeHandler33, false);
	ajax.addEventListener("error", errorHandler33, false);
	ajax.addEventListener("abort", abortHandler33, false);
	ajax.open("POST", "funcionalidad/parser_File.php");
	ajax.send(formdata);
        

}
function progressHandler33(event){
        
        $("#guardarArchivo33").addClass('disabled');
        $("#guardarArchivo33").attr('disabled','true');
	_("loaded_n_total33").innerHTML = "<b>Subido: </b> "+event.loaded+" bytes de "+event.total+" bytes";
	var percent = (event.loaded / event.total) * 100;
	_("progressBar33").style.width = Math.round(percent)+"%"; 
        
        if(parseInt(_("progressBar33").style.width) < 40){
            $("#progressBar33").removeClass("progress-bar-success").addClass("progress-bar-danger");
        }
        if(parseInt(_("progressBar33").style.width) > 40){
            $("#progressBar33").removeClass("progress-bar-danger").addClass("progress-bar-warning");
        }
        if(parseInt(_("progressBar33").style.width) > 70){
            $("#progressBar33").removeClass("progress-bar-warning").addClass("progress-bar-success");
        }
        if(parseInt(_("progressBar33").style.width) === 100){
            $("#progressBar33").removeClass("progress-bar-success").addClass("progress-bar-default");
        }
	_("status33").innerHTML = Math.round(percent)+"% Subido... por favor espere";
}
function completeHandler33(event){
	_("status33").innerHTML = event.target.responseText;
	$("#guardarArchivo33").removeClass('disabled');
        $("#guardarArchivo33").removeAttr('disabled');
}
function errorHandler33(event){
	_("status33").innerHTML = "Subida Fallida";
}
function abortHandler33(event){
	_("status33").innerHTML = "Subida Abortada";
}


