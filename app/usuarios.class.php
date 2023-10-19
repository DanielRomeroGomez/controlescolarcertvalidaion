<?php
session_start();
require_once 'data.php';
//error_reporting(0);

class Usuarios{

    private $pdo;

    public function __CONSTRUCT()
    {
        try {
            $this->pdo 		    = Database::StartUp();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function gridPrincipal(){
        try{

            $sql = "SELECT id_usuario, 
                            nom_usr,
                            apellidos_usr,
                            tel_usr,
                            correo_usr,
                            pais_usr,
                            estado_usr,
                            img_usr
                    FROM tbl_usuario 
                    WHERE 1";

            $stm    = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            
            $contador = 1;

            $style = '';

            if ($_SESSION['estado_sesion'] && $_SESSION['datos_usuario'][4] == 3 || $_SESSION['datos_usuario'][4] == 6) {
                $btn = '';
                $style = 'display:none;';
            }

            $tabla = "<div class='table-responsive'>
            <table class='table' id='gridUsuarios' style='width:100%;'>
            <thead>
                <tr>
                    <th class='text-center'>No.</th>
                    <th class='text-center'>Nombre</th>
                    <th class='text-center'>Teléfono</th>
                    <th class='text-center'>Correo</th>
                    <th class='text-center'>País</th>
                    <th class='text-center'>Estado</th>
                    <th class='text-center' style='".$style."'>Acciones</th>
                </tr>
            </thead>
            <tbody>";
            
            foreach ($result as $key) {

                $btn = "<div class='btn-group' role='group' aria-label='Basic example'>
                                <button type='button' class='btn btn-primary' onclick=\"infoUsuario('$key->id_usuario','$key->nom_usr');\"><i class='fas fa-edit'></i></button>
                                <button type='button' class='btn btn-danger' onclick=\"eliminaUsuario('$key->id_usuario','$key->nom_usr');\"><i class='fas fa-trash-alt'></i></button>
                            </div>";

            $style = 'display:block;';
            if ($_SESSION['estado_sesion'] && $_SESSION['datos_usuario'][4] == 3 || $_SESSION['datos_usuario'][4] == 6) {
                $btn = '';
                $style = 'display:none;';
            }else if ($_SESSION['estado_sesion'] && $_SESSION['datos_usuario'][4] == 4) {
                $btn = "<div class='btn-group' role='group' aria-label='Basic example'>
                                <button type='button' class='btn btn-primary' onclick=\"infoUsuario('$key->id_usuario','$key->nom_usr');\"><i class='fas fa-edit'></i></button>
                            </div>";
                $style = 'display:block;';
            }else if ($_SESSION['estado_sesion'] && $_SESSION['datos_usuario'][4] == 5) {
                $btn = "<div class='btn-group' role='group' aria-label='Basic example'>
                                <button type='button' class='btn btn-danger' onclick=\"eliminaUsuario('$key->id_usuario','$key->nom_usr');\"><i class='fas fa-trash-alt'></i></button>
                            </div>";
                $style = 'display:block;';
            }

                $tabla .= "<tr>";
                $tabla .= "<td class='text-center'><b>".$contador."</b></td>";
                $tabla .= "<td class='text-left'><b>".$key->nom_usr." " .$key->apellidos_usr."</b></td>";
                $tabla .= "<td class='text-left'><b>".$key->tel_usr. "</b></td>";
                $tabla .= "<td class='text-left'><b>".$key->correo_usr."</b></td>";
                $tabla .= "<td class='text-left'><b>".$key->pais_usr."</b></td>";
                $tabla .= "<td class='text-left'><b>".$key->estado_usr."</b></td>";
                $tabla .= "<td class='text-center' style='".$style."'>
                            ".$btn."
                            </td>";
                $tabla .= "</tr>";
                $contador++;
           }
           
            $tabla .= "</tbody></table></div>";
           
            return($tabla);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function saveData($data){
        try{
            $return = [];
            $datos = json_decode($data,true);

            $name_User = trim($datos['nameUsr']);
            $last_name_User = trim($datos['lastUsr']);
            $email_User = trim($datos['emailUsr']);
            $usr_User = trim($datos['usrUsr']);
            $psw_User = trim($datos['passUsr']);
            $phone_User = trim($datos['phoneUsr']);

            $sql = "UPDATE users_pm
                    SET name_User = '".$name_User."',
                        last_name_User = '".$last_name_User."',
                        email_User = '".$email_User."',
                        usr_User = '".$usr_User."',
                        psw_User ='".$psw_User."', 
                        phone_User = '".$phone_User."'
                    WHERE id_User = ".$_SESSION['datos_usuario'][0];

            $stm = $this->pdo->prepare($sql);
            
            if($stm->execute()){
                $return['insertedOk']   = true;
                $return['mensaje']      = 'Se actualizó al usuario '.$name_User.' correctamente.';
                //$return['query']        = $insert;
            }else{
                $return['insertedOk']   = false;
                $return['mensaje']      = 'Hubo un error al actualizar el registro del usuario '.$name_User.'.';
                //$return['query']        = $insert;
            
            }
           
            return json_encode($return);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function eliminarUsuario($data){
        try{
            
            $sql = "SELECT id_usuario, 
                            nom_usr,
                            apellidos_usr,
                            tel_usr,
                            correo_usr,
                            pais_usr,
                            estado_usr,
                            img_usr
                    FROM tbl_usuario 
                    WHERE id_usuario = ".$data;

            $stm    = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_OBJ);

            $nom = $result->nom_usr;
            $ape = $result->apellidos_usr;
            $tel = $result->tel_usr;
            $cor = $result->correo_usr;
            $pai = $result->pais_usr;
            $est = $result->estado_usr;

            $delete = "DELETE FROM tbl_usuario WHERE id_usuario = ".$data;

            $stm = $this->pdo->prepare($delete);
            
            if($stm->execute()){
                $return['insertedOk']   = true;
                $return['mensaje']      = 'Se elimino el usuario de '.$nom.' '. $ape. ' correctamente.';
                //$return['query']        = $insert;
            }else{
                $return['insertedOk']   = false;
                $return['mensaje']      = 'Hubo un error al eliminar el usuario '.$nom.' '. $ape. '.';
                //$return['query']        = $insert;
            }
           
            return json_encode($return);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function infoUsuario(){
        try{
            
            $sql = "SELECT id_User,
                            name_User,
                            last_name_User,
                            email_User,
                            usr_User,
                            psw_User,
                            phone_User,
                            status_User,
                            img_User,
                            role_User,
                            create_date_User,
                            position_User
                    FROM  users_pm 
                    WHERE id_User = ".$_SESSION['datos_usuario'][0];

            $stm    = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_OBJ);
            return json_encode($result);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function editarUsuario($data){
        try{
            $datos = json_decode($data,true);
            $idU = intval($datos['idU']);
            $nom = trim($datos['nom']);
            $ape = trim($datos['ape']);
            $tel = trim($datos['tel']);
            $cor = trim($datos['cor']);
            $pai = trim($datos['pai']);
            $est = trim($datos['est']);
            
            $insert = "UPDATE tbl_usuario SET nom_usr = '$nom', apellidos_usr = '$ape', tel_usr = '$tel', correo_usr = '$cor', pais_usr = '$pai', estado_usr =  '$est' WHERE id_usuario = ".$idU;

            $stm = $this->pdo->prepare($insert);
            
            if($stm->execute()){
                $return['insertedOk']   = true;
                $return['mensaje']      = 'Se actualizó al usuario '.$nom.' correctamente.';
                //$return['query']        = $insert;
            }else{
                $return['insertedOk']   = false;
                $return['mensaje']      = 'Hubo un error al actualizar el registro del usuario '.$nom.'.';
                //$return['query']        = $insert;
            }
           
            return json_encode($return);           
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

}