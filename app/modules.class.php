<?php
session_start();
require_once 'data.php';
//error_reporting(0);

class Modules{

    private $pdo;

    public function __CONSTRUCT()
    {
        try {
            $this->pdo 		    = Database::StartUp();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getModules(){
        try{

            $datos = [];
            $id = $_SESSION['datos_usuario'][0];
            $cont = 0;

            $sql = "SELECT m.id_Module as id_Module, m.name_Module as name_Module, m.status_Module as status_Module, m.icon_Module as icon_Module, m.menu_Module as menu_Module, m.is_submenu_Module as is_submenu_Module, m.link_Module as link_Module, m.date_start_Module as date_start_Module, m.date_edit_Module as date_edit_Module, m.user_start_Module as user_start_Module, m.user_edit_Module as user_edit_Module, p.id_Permission as id_Permission, p.usr_id_User as usr_id_User, p.module_Permission as module_Permission, p.action_Permission as action_Permission, p.permits_Permission as permits_Permission, p.date_start_Permission as date_start_Permission, p.date_edit_Permission as date_edit_Permission
                    FROM modules_pm as m 
                    INNER JOIN permission_pm as p
                        ON p.module_Permission = m.id_Module and p.usr_id_User = {$id}
                WHERE m.status_Module = 1 ";

            $stm    = $this->pdo->prepare($sql);
    		$stm->execute();

            while ($result = $stm->fetch(PDO::FETCH_ASSOC)) {

                $mod = ["id_Module" => $result['id_Module'], "name_Module" => $result['name_Module'], "status_Module" => $result['status_Module'], "icon_Module" => $result['icon_Module'], "menu_Module" => $result['menu_Module'], "is_submenu_Module" => $result['is_submenu_Module'], "link_Module" => $result['link_Module'], "date_start_Module" => $result['date_start_Module'], "date_edit_Module" => $result['date_edit_Module'], "user_start_Module" => $result['user_start_Module'], "user_edit_Module" => $result['user_edit_Module'], "id_Permission" => $result['id_Permission'], "usr_id_User" => $result['usr_id_User'], "module_Permission" => $result['module_Permission'], "action_Permission" => $result['action_Permission'], "permits_Permission" => $result['permits_Permission'], "date_start_Permission" => $result['date_start_Permission'], "date_edit_Permission" => $result['date_edit_Permission']];
                // Agrega cada $mod al array $datos
                $datos[] = $mod;
            }

            return json_encode($datos);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function guardaUsuario($data){
        try{
                
            $datos = json_decode($data,true);
            $nom = trim($datos['nom']);
            $ape = trim($datos['ape']);
            $tel = trim($datos['tel']);
            $cor = trim($datos['cor']);
            $pai = trim($datos['pai']);
            $est = trim($datos['est']);

            $sql = "SELECT count(*) AS conteo
                    FROM tbl_usuario 
                    WHERE correo_usr LIKE '%".$cor."%' OR tel_usr LIKE '%".$tel."%'";

            $stm    = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_OBJ);

            if(intval($result->conteo) === 0){
                
                $insert = "INSERT INTO tbl_usuario (nom_usr, apellidos_usr, tel_usr, correo_usr, pais_usr, estado_usr) VALUES ('$nom','$ape','$tel','$cor','$pai','$est')";

                $stm = $this->pdo->prepare($insert);
                
                if($stm->execute()){
                    $return['insertedOk']   = true;
                    $return['mensaje']      = 'Se genero al usuario '.$nom.' correctamente.';
                    $return['query']        = $insert;
                }else{
                    $return['insertedOk']   = false;
                    $return['mensaje']      = 'Hubo un error al generar el registro del usuario '.$nom.'.';
                    $return['query']        = $insert;
                }

            }else{
                $return['insertedOk']   = false;
                $return['mensaje']      = 'El usuario ya esta registrado, verifica el teléfono y correo.';
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

    public function infoUsuario($data){
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

            $return['idU'] = $result->id_usuario;
            $return['nom'] = $result->nom_usr;
            $return['ape'] = $result->apellidos_usr;
            $return['tel'] = $result->tel_usr;
            $return['cor'] = $result->correo_usr;
            $return['pai'] = $result->pais_usr;
            $return['est'] = $result->estado_usr;
           
            return json_encode($return);
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
