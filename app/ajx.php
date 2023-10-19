<?php

header("Access-Control-Allow-Origin: http://www.controlescolar.site");

if ((isset($_POST["ir"])) or (isset($_GET["ir"]))) {
	if (($_POST["ir"] == "ajx") || ($_GET["ir"] == "ajx")) {
        $error = 0;

		if (isset($_POST["p1"])) { $param1 = $_POST["p1"]; } else { $param1 = $_GET["p1"]; }
        if (isset($_POST["p2"])) { $param2 = $_POST["p2"]; } elseif (isset($_GET["p2"])) { $param2 = $_GET["p2"]; }
        if (isset($_POST["p3"])) { $param3 = $_POST["p3"]; } elseif (isset($_GET["p3"])) { $param3 = $_GET["p3"]; }
        if (isset($_POST["p4"])) { $param4 = $_POST["p4"]; } elseif (isset($_GET["p4"])) { $param4 = $_GET["p4"]; }
        
        if($param1 == 'gridPrincipalUsr'){
            require_once("usuarios.class.php");
            $buffer = new Usuarios();
            print_r($buffer->gridPrincipal());
        }

        if($param1 == 'eliminarUsuario'){
            require_once("usuarios.class.php");
            $buffer = new Usuarios();
            print_r($buffer->eliminarUsuario($param2));
        }

        if($param1 == 'infoUsuario'){
            require_once("usuarios.class.php");            
            $buffer = new Usuarios();
            print_r($buffer->infoUsuario($param2));
        }

        if($param1 == 'editarUsuario'){
            require_once("usuarios.class.php");            
            $buffer = new Usuarios();
            print_r($buffer->editarUsuario($param2));
        }
        if($param1 == 'login'){
            require_once("login.php");            
            $buffer = new Sesion();
            print_r($buffer->iniciaSesion($param2));
        }

        if($param1 == 'cerrarSesion'){
            require_once("login.php");            
            $buffer = new Sesion();
            print_r($buffer->cerrarSesion());
        }

        if($param1 == 'getModules'){
            require_once("modules.class.php");            
            $buffer = new Modules();
            print_r($buffer->getModules());
        }
        
        if($param1 == 'getAlumnos'){
            require_once("alumnos.class.php");            
            $buffer = new Alumnos();
            print_r($buffer->getAlumnos());
        }

        if($param1 == 'alumnosExcel'){
            require_once("alumnos.class.php");            
            $buffer = new Alumnos();
            print_r($buffer->alumnosExcel());
        }

        if($param1 == 'getQRAlumnos'){
            require_once("alumnos.class.php");            
            $buffer = new Alumnos();
            print_r($buffer->getQRAlumnos($param2));
        }

        if($param1 == 'getAlumnosEntradas'){
            require_once("alumnos.class.php");            
            $buffer = new Alumnos();
            print_r($buffer->getAlumnosEntradas());
        }

        if($param1 == 'getAlumnosUltimos'){
            require_once("alumnos.class.php");            
            $buffer = new Alumnos();
            print_r($buffer->getAlumnosUltimos());
        }

        if($param1 == 'getActividades'){
            require_once("logs.class.php");            
            $buffer = new Logs();
            print_r($buffer->getActividades());
        }

        if($param1 == 'getCuenta'){
            require_once("usuarios.class.php");            
            $buffer = new Usuarios();
            print_r($buffer->infoUsuario());
        }

        if($param1 == 'saveData'){
            require_once("usuarios.class.php");            
            $buffer = new Usuarios();
            print_r($buffer->saveData($param2));
        }

        if($param1 == 'getAlumno'){
            require_once("alumnos.class.php");            
            $buffer = new Alumnos();
            print_r($buffer->getAlumno($param2));
        }

        if($param1 == 'saveAlumno'){
            require_once("alumnos.class.php");            
            $buffer = new Alumnos();
            print_r($buffer->saveAlumno($param2));
        }

        if($param1 == 'saveCert'){
            require_once("alumnos.class.php");            
            $buffer = new Alumnos();
            print_r($buffer->saveCert($param2));
        }

        if($param1 == 'eliminaAlumno'){
            require_once("alumnos.class.php");            
            $buffer = new Alumnos();
            print_r($buffer->eliminaAlumno($param2));
        }
        
        
	} 
}
?>
