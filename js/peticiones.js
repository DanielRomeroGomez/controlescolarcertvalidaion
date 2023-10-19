let cargaAlumnosjs = false;
//var urlajx = "http://controlescolar.site/";

var urlajx = ""


$(document).ready(function () {

    getModules();


    // Obtén referencias a los elementos del DOM
    var dashboard = $("#dashboard");
    var alumnos = $("#alumnos");
    var miCuenta = $("#miCuenta");
    var miCuentah = $("#miCuenta-h");
    var contenido = $("#main-content");

    cargarContenido("pages/dashboard.php");

    // Agrega manejadores de eventos para los enlaces del menú
    dashboard.on("click", function (event) {
        event.preventDefault();
        cargarContenido("pages/dashboard.php");
    });

    alumnos.on("click", function (event) {
        event.preventDefault();
        cargarContenido("pages/alumnos.php");
    });

    miCuenta.on("click", function (event) {
        event.preventDefault();
        cargarContenido("pages/micuenta.php");
    });

    miCuentah.on("click", function (event) {
        event.preventDefault();
        cargarContenido("pages/micuenta.php");
    });

    // Función para cargar el contenido de una página
    function cargarContenido(url) {
        // Utiliza AJAX para cargar el contenido de la página
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html',
            success: function (data) {
                contenido.html(data);
            },
            error: function (error) {
                console.error("Error al cargar la página:", error);
            }
        });
    }

});

$(".cerrarSesion").click(function () {
    $.ajax({
        method: "POST",
        global: false,
        //url: "app/ajx.php",
        url: urlajx+"app/ajx.php",
        data: "ir=ajx&p1=cerrarSesion"
    }).done(function (result) {
        data = JSON.parse(result);

        if (data.session) {
            location.href = 'index.php';
        }
    });
});

$("#cerrarSes").click(function () {
    $.ajax({
        method: "POST",
        global: false,
        //url: "app/ajx.php",
        url: urlajx+"app/ajx.php",
        data: "ir=ajx&p1=cerrarSesion"
    }).done(function (result) {
        data = JSON.parse(result);

        if (data.session) {
            location.href = 'index.php';
        }
    });
});

function getModules() {

    $.ajax({
        method: "POST",
        global: false,
        //url: "app/ajx.php",
        url: urlajx+"app/ajx.php",
        data: "ir=ajx&p1=getModules"
    }).done(function (result) {
        data = JSON.parse(result);

        // Recorre los registros en 'datos'
        for (var i = 0; i < data.length; i++) {
            var registro = data[i];
            //console.log(registro);
            // Accede a otros campos de la misma manera
        }
        /*for (let i = 0; i < data.length; i++) {
            var datos = data[i]
            console.log(datos['id_Module'])
        }*/
    });
}