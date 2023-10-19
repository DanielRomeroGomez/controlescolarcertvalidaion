

$(document).ready(function(){

	getCuenta();
	
	$("#save_data_user").click(function(){
		saveData();
    });
});

function getCuenta(){
	$.ajax({
        method: "POST",
        global: false, 
        //url:    "app/ajx.php",
		url: urlajx+"app/ajx.php",
		dataType: "html",
        data:   "ir=ajx&p1=getCuenta"
    }).done(function(result){
		var data = JSON.parse(result);
		
		$("#name_user").val(data.name_User);
		$("#last_name_user").val(data.last_name_User);
		$("#email_user").val(data.email_User);
		$("#usr_user").val(data.usr_User);
		$("#psw_user").val(data.psw_User);
		$("#phone_user").val(data.phone_User);
    });
}

function nuevoAlumnoForm(){
	$("#data_response").empty();
	$("#formAlumnos").css({ "display": "block"});
	$("#nuevo_alumno").css({ "display": "none"});
	$("#lista_alumnos").css({ "display": "block"});
	
}

function ListaFormAlumnos(){
	$("#nuevo_alumno").css({ "display": "block"});
	$("#lista_alumnos").css({ "display": "none"});

	$("#formAlumnos").css({ "display": "none"});
	getAlumnos();	
}

function saveData(){

	var nameUsr = $("#name_user").val();
	var lastUsr = $("#last_name_user").val();
	var emailUsr = $("#email_user").val();
	var usrUsr = $("#usr_user").val();
	var passUsr = $("#psw_user").val();
	var phoneUsr = $("#phone_user").val();

	if(nameUsr == ''){
		Swal.fire({
			title: 'Error Usuario',
			text: 'El campo Nombre no puede quedar vacio.',
			icon: 'warning',
			showCancelButton: false,
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'Aceptar',
			allowOutsideClick: false
		});

		return false;
	}

	if(lastUsr == ''){
		Swal.fire({
			title: 'Error Usuario',
			text: 'El campo Apellido no puede quedar vacio.',
			icon: 'warning',
			showCancelButton: false,
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'Aceptar',
			allowOutsideClick: false
		});

		return false;
	}

	if(emailUsr == ''){
		Swal.fire({
			title: 'Error Usuario',
			text: 'El campo Correo Electrónico no puede quedar vacio.',
			icon: 'warning',
			showCancelButton: false,
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'Aceptar',
			allowOutsideClick: false
		});

		return false;
	}

	if(usrUsr == ''){
		Swal.fire({
			title: 'Error Usuario',
			text: 'El campo Usuario no puede quedar vacio.',
			icon: 'warning',
			showCancelButton: false,
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'Aceptar',
			allowOutsideClick: false
		});

		return false;
	}
	
	if(passUsr == ''){
		Swal.fire({
			title: 'Error Usuario',
			text: 'El campo Contraseña no puede quedar vacio.',
			icon: 'warning',
			showCancelButton: false,
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'Aceptar',
			allowOutsideClick: false
		});

		return false;
	}

	var obj = new Object();
        obj.nameUsr = nameUsr;
        obj.lastUsr = lastUsr;
		obj.emailUsr = emailUsr;
        obj.usrUsr = usrUsr;
		obj.passUsr = passUsr;
        obj.phoneUsr = phoneUsr;

    var data = JSON.stringify(obj);

	$.ajax({
        method: "POST",
        global: false, 
		url: urlajx+"app/ajx.php",
		dataType: "html",
        data:   "ir=ajx&p1=saveData&p2="+data
    }).done(function(result){
		data = JSON.parse(result);

		if(data.insertedOk){
			Swal.fire({
				title: 'Usuario Actializado',
				text: data.mensaje,
				icon: 'success',
				showCancelButton: false,
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Aceptar',
				allowOutsideClick: false
			});

		}else{
			Swal.fire({
				title: 'Error Actualizar Usuario',
				text: data.mensaje,
				icon: 'warning',
				showCancelButton: false,
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Aceptar',
				allowOutsideClick: false
			});
		}
    });
}
