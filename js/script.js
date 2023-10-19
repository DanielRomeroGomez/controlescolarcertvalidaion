$(document).ready(function(){
	$( "#btn-sesion" ).click(function() {
		
        var usr = $("#username").val();
        var pas = $("#password").val();

        if(usr == ''){
        	Swal.fire({
                title: 'Error Usuario',
                text: 'El campo usuario no puede ir vacio.',
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar',
                allowOutsideClick: false
            });
        }else{
        	if(pas == ''){
        		Swal.fire({
	                title: 'Error Contraseña',
	                text: 'El campo contraseña no puede ir vacio.',
	                icon: 'warning',
	                showCancelButton: false,
	                confirmButtonColor: '#3085d6',
	                confirmButtonText: 'Aceptar',
	                allowOutsideClick: false
	            });
        	}else{

        		var obj = new Object();
                    obj.usr = usr;
                    obj.pas = pas;

                var data = JSON.stringify(obj);

        		$.ajax({
	                method: "POST",
	                global: false, 
	                url:    "app/ajx.php",
	                data:   "ir=ajx&p1=login&p2="+data
	            }).done(function(result){
					console.log(result)
	                data = JSON.parse(result);

	                if (data.selectOk) {
	                	location.href = 'dashboard.php';
	                }else{
	                	Swal.fire({
		                title: 'Iniciar Sesión',
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
        }
    });
});