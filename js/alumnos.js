$(document).ready(function(){
	getAlumnos();
	
	$("#nuevo_alumno").click(function(){
		$(this).hide();
		$("#data_response").empty();
		$("#formAlumnos").show();
		
		$("#lista_alumnos").show();
    });

	$("#lista_alumnos").click(function(){
        ListaFormAlumnos();
		$("#editAlumno").hide();
    }); 

	$("#cargarArchivo").click(function () {
		$("#cargarArchivo").prop("disabled", true);
		var archivoInput = document.getElementById("archivoExcel");
		var archivo = archivoInput.files[0];

		if (archivo) {
			var formData = new FormData();
			formData.append("ir", "ajx");
			formData.append("p1", "alumnosExcel");
			formData.append("p2", archivo);

			$.ajax({
				//url: "app/ajx.php", // URL del script PHP que procesará el archivo
				url: urlajx+"app/ajx.php",
				type: "POST",
				data: formData,
				processData: false,
				contentType: false,
				success: function (response) {
					data = JSON.parse(response);

					var res = ''
					
					if(data.insertedOk){
						res = '<div class="alert alert-info alert-dismissible fade show" role="alert">'+
						'<strong>Aviso! </strong>'+ data.mensaje+
						'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
						  '</div>';
					}else{
						res = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
						'<strong>Aviso! </strong>'+ data.mensaje+
						'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
						  '</div>';
					}
					

					$("#resultado").empty().html(res);
					$("#cargarArchivo").prop("disabled", false);
					
				},
				error: function (xhr, status, error) {
					console.error("Error al cargar el archivo:", error);
				}
			});
		} else {
			alert("Selecciona un archivo Excel válido antes de hacer clic en Subir Archivo.");
		}
	});

	$("#save_data_cert").click(function(){
        var id_Students = $("#id_Students").val()
		var name_Student = $("#name_Student").val()

		var autoridad_certificado_Certificates = $("#autoridad_certificado_Certificates").val()
		var ciclo_escolar_Certificates = $("#ciclo_escolar_Certificates").val()
		var nivel_educativo_Certificates = $("#nivel_educativo_Certificates").val()
		var cct_Certificates = $("#cct_Certificates").val()
		var turno_Certificates = $("#turno_Certificates").val()
		var promedio_final_Certificates = $("#promedio_final_Certificates").val()
		var nombre_escuela_Certificates = $("#nombre_escuela_Certificates").val()
		var domicilio_Certificates = $("#domicilio_Certificates").val()
		var municipio_Certificates = $("#municipio_Certificates").val()
		var localidad_Certificates = $("#localidad_Certificates").val()
		var numero_folio_Certificates = $("#numero_folio_Certificates").val()
		var numero_certificado_Certificates = $("#numero_certificado_Certificates").val()

		var obj = new Object();
    	    obj.id_Students = id_Students;
			obj.name_Student = name_Student;
        	obj.autoridad_certificado_Certificates = autoridad_certificado_Certificates;
			obj.ciclo_escolar_Certificates = ciclo_escolar_Certificates;
			obj.nivel_educativo_Certificates = nivel_educativo_Certificates;
			obj.cct_Certificates = cct_Certificates;
			obj.turno_Certificates = turno_Certificates;
			obj.promedio_final_Certificates = promedio_final_Certificates;
			obj.nombre_escuela_Certificates = nombre_escuela_Certificates;
			obj.domicilio_Certificates = domicilio_Certificates;
			obj.municipio_Certificates = municipio_Certificates;
			obj.localidad_Certificates = localidad_Certificates;
			obj.numero_folio_Certificates = numero_folio_Certificates;
			obj.numero_certificado_Certificates = numero_certificado_Certificates;

	    var data = JSON.stringify(obj);

		$.ajax({
			method: "POST",
			global: false, 
			//url:    "app/ajx.php",
			url: urlajx+"app/ajx.php",
			dataType: "html",
			data:   "ir=ajx&p1=saveCert&p2="+data
		}).done(function(result){
			
			data = JSON.parse(result);
			
			if(data.insertedOk){
				Swal.fire({
					title: 'Actializado',
					text: data.mensaje,
					icon: 'success',
					showCancelButton: false,
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'Aceptar',
					allowOutsideClick: false
				});
			}else{
				Swal.fire({
					title: 'Alumno',
					text: data.mensaje,
					icon: 'warning',
					showCancelButton: false,
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'Aceptar',
					allowOutsideClick: false
				});
			}
	
		});

    });

	$("#save_data_user").click(function(){

		var id_Students = $("#id_Students").val()
        var name_Student = $("#name_Student").val()
		var paternal_surname_Student = $("#paternal_surname_Student").val()
		var mother_surname_Student = $("#mother_surname_Student").val()
		var curp_Student = $("#curp_Student").val()
		var sex_Student = $("#sex_Student").val()

		var obj = new Object();
    	    obj.id_Students = id_Students;
        	obj.name_Student = name_Student;
			obj.paternal_surname_Student = paternal_surname_Student;
			obj.mother_surname_Student = mother_surname_Student;
			obj.curp_Student = curp_Student;
			obj.sex_Student = sex_Student;

	    var data = JSON.stringify(obj);

		$.ajax({
			method: "POST",
			global: false, 
			//url:    "app/ajx.php",
			url: urlajx+"app/ajx.php",
			dataType: "html",
			data:   "ir=ajx&p1=saveAlumno&p2="+data
		}).done(function(result){
			
			data = JSON.parse(result);
			
			if(data.insertedOk){
				Swal.fire({
					title: 'Actializado',
					text: data.mensaje,
					icon: 'success',
					showCancelButton: false,
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'Aceptar',
					allowOutsideClick: false
				});
			}else{
				Swal.fire({
					title: 'Alumno',
					text: data.mensaje,
					icon: 'warning',
					showCancelButton: false,
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'Aceptar',
					allowOutsideClick: false
				});
			}
	
		});

    }); 
	
});

function getAlumnos(){
	$.ajax({
        method: "POST",
        global: false, 
        //url:    "app/ajx.php",
		url: urlajx+"app/ajx.php",
		dataType: "html",
        data:   "ir=ajx&p1=getAlumnos"
    }).done(function(result){
		$("#data_response").empty().append(result);

		$(document).ready(function () {
            
			var table = new DataTable('#gridAlumnos', {
				language: {
					url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
				},
			});
        });
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
	$("#editAlumno").css({ "display": "none"});
	$("#data_response").css({ "display": "block"});
	getAlumnos();	
}

function codeqr(nombre, curp){

	var obj = new Object();
        obj.no = nombre;
        obj.cu = curp;

    var data = JSON.stringify(obj);

	$.ajax({
        method: "POST",
        global: false, 
        //url:    "app/ajx.php",
		url: urlajx+"app/ajx.php",
		dataType: "html",
        data:   "ir=ajx&p1=getQRAlumnos&p2="+data
    }).done(function(result){
		data = JSON.parse(result);
		$("#qrName").empty().append('QR DE '+nombre);
		$("#resp_qr").empty().html(data.mensaje);
    });
}

function infoAlumno(id,curp){
	$("#data_response").hide();
	$("#nuevo_alumno").hide();
	$("#editAlumno").show();
	$("#lista_alumnos").show();

	var obj = new Object();
        obj.id = id;
        obj.curp = curp;

    var data = JSON.stringify(obj);


	$.ajax({
        method: "POST",
        global: false, 
        //url:    "app/ajx.php",
		url: urlajx+"app/ajx.php",
		dataType: "html",
        data:   "ir=ajx&p1=getAlumno&p2="+data
    }).done(function(result){
		
		data = JSON.parse(result);
		
		$("#id_Students").val(data.id_Students)
		$("#name_Student").val(data.name_Student)
		$("#paternal_surname_Student").val(data.paternal_surname_Student)
		$("#mother_surname_Student").val(data.mother_surname_Student)
		$("#curp_Student").val(data.curp_Student)
		$("#sex_Student").val(data.sex_Student)

		$("#autoridad_certificado_Certificates").val(data.autoridad_certificado_Certificates)
		$("#ciclo_escolar_Certificates").val(data.ciclo_escolar_Certificates)
		$("#nivel_educativo_Certificates").val(data.nivel_educativo_Certificates)
		$("#cct_Certificates").val(data.cct_Certificates)
		$("#turno_Certificates").val(data.turno_Certificates)
		$("#promedio_final_Certificates").val(data.promedio_final_Certificates)
		$("#nombre_escuela_Certificates").val(data.nombre_escuela_Certificates)
		$("#domicilio_Certificates").val(data.domicilio_Certificates)
		$("#municipio_Certificates").val(data.municipio_Certificates)
		$("#localidad_Certificates").val(data.localidad_Certificates)
		$("#numero_folio_Certificates").val(data.numero_folio_Certificates)
		$("#numero_certificado_Certificates").val(data.numero_certificado_Certificates)

    });

}

function eliminaAlumno(id,curp){

	var name_Student = $("#name_Student").val()

	var obj = new Object();
        obj.id = id;
        obj.curp = curp;
		obj.name_Student = name_Student

    var data = JSON.stringify(obj);

	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
		  confirmButton: 'btn btn-success',
		  cancelButton: 'btn btn-danger'
		},
		buttonsStyling: false
	  })
	  
	  swalWithBootstrapButtons.fire({
		title: 'Eliminar alumno',
		text: "¿Estas seguro de eliminar al alumno "+name_Student+"?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Si, eliminar',
		cancelButtonText: 'No, Cancelar!',
		reverseButtons: true
	  }).then((result) => {
		if (result.isConfirmed) {

			$.ajax({
				method: "POST",
				global: false, 
				//url:    "app/ajx.php",
				url: urlajx+"app/ajx.php",
				dataType: "html",
				data:   "ir=ajx&p1=eliminaAlumno&p2="+data
			}).done(function(result){
				
				data = JSON.parse(result);
				if(data.insertedOk){
					swalWithBootstrapButtons.fire(
						'Alumno Eliminado Correctamente!',
						data.mensaje,
						'success'
					)
					getAlumnos();
				}else{
					swalWithBootstrapButtons.fire(
						'Aviso Alumno!',
						data.mensaje,
						'warning'
					)
				}
				/*
				
				
				*/
			});
		  
		} else if (
		  /* Read more about handling dismissals below */
		  result.dismiss === Swal.DismissReason.cancel
		) {
		  swalWithBootstrapButtons.fire(
			'Eliminar Alumno Cancelado.',
			'',
			'error'
		  )
		}
	  })

}
