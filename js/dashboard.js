$(document).ready(function(){
	getAlumnosEntradas();
	getAlumnosUltimos();
	getActividades();
	
});

function getAlumnosEntradas(){
	$.ajax({
        method: "POST",
        global: false, 
        //url:    "app/ajx.php",
		url: urlajx+"app/ajx.php",
		dataType: "html",
        data:   "ir=ajx&p1=getAlumnosEntradas"
    }).done(function(result){
		data = JSON.parse(result);

		$("#totalAlumnos").empty().append(data.datos.conteoTotal);
		$("#alumnosActivos").empty().append(data.datos.conteoActivos);
		$("#alumnosCertificado").empty().append(data.datos.conteoCertificados);
    });
}

function getAlumnosUltimos(){
	$.ajax({
        method: "POST",
        global: false, 
        //url:    "app/ajx.php",
		url: urlajx+"app/ajx.php",
		dataType: "html",
        data:   "ir=ajx&p1=getAlumnosUltimos"
    }).done(function(result){
		$("#ultimosAlumnos").empty().append(result);
		
    });
}

function getActividades(){
	$.ajax({
        method: "POST",
        global: false, 
        //url:    "app/ajx.php",
		url: urlajx+"app/ajx.php",
		dataType: "html",
        data:   "ir=ajx&p1=getActividades"
    }).done(function(result){
		$("#actividades").empty().append(result);
		
    });
}
