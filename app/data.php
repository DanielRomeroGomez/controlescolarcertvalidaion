<?php
class Database{

    public function __CONSTRUCT(){
        die("La conexión no se realizó correctamente");
    }

    public static function StartUp(){
        
        $conn       = null;
        $dbName     = 'id21358205_controlescolar';
        $server     = 'localhost';
        /*$user       = 'id21358205_control_escolar';
        $pass       = 'ControlE$colar1';*/

        /*$conn       = null;
        $dbName     = 'pm';
        $server     = 'localhost';*/
        $user       = 'root';
        $pass       = '';

        try{
            //$conn= new PDO('mysql:host=localhost;dbname=id19712314_usuarios', $user, $pass);
            $conn= new PDO('mysql:host='.$server.';dbname='.$dbName, $user, $pass);
        }catch(PDOException $e) {
            echo "Error al intentar conectar.";
        }

        return $conn;
    }

    public function Desconectar(){
        $conn = null;
    }
}
