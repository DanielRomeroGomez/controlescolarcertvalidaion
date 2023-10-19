<?php
session_start();
require_once 'data.php';
error_reporting(0);

class Logs{

    private $pdo;

    public function __CONSTRUCT()
    {
        try {
            $this->pdo 		    = Database::StartUp();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function aplyLogs($data){
        try{

            $descrip_Log = $data['descrip'];
            $instruccion_Log = $data['instruccion'];
            $user_action_Log = intval($data['user']);

            $sql = 'INSERT INTO logs_pm (descrip_Log, user_action_Log, date_create_Log, instruccion_Log)
                    VALUES ("'.$descrip_Log.'", '.$user_action_Log.', NOW(),"'.$instruccion_Log.'")';

            $stm    = $this->pdo->prepare($sql);
            /*$stm->bindParam(':descrip_Log', $descrip_Log, PDO::PARAM_STR);
            $stm->bindParam(':user_action_Log', $user_action_Log, PDO::PARAM_INT);
            $stm->bindParam(':instruccion_Log', $instruccion_Log, PDO::PARAM_STR);*/
            

            try {
                $stm->execute();
                //echo $sql;
                //echo 'Inserción exitosa.';
            } catch (PDOException $e) {
                echo 'Error al insertar en la base de datos: ' . $e->getMessage();
            }
           
            return("");
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function getActividades(){
        $sql = "SELECT lpm.descrip_Log, 
                        lpm.user_action_Log, 
                        lpm.date_create_Log,
                        lpm.instruccion_Log,
                        upm.name_User,
                        upm.last_name_User
                FROM logs_pm as lpm
                INNER JOIN users_pm upm ON lpm.user_action_Log = upm.id_User
                ORDER BY lpm.id_Log DESC
                LIMIT 6";

        $stm    = $this->pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    
        $actividadesList = '';
        
        $clases = ['','sl-primary','sl-danger','sl-success','sl-warning',''];

        foreach ($result as $key) {

            $claveAleatoria = array_rand($clases);
            $elementoAleatorio = $clases[$claveAleatoria];

            $actividadesList .= '<div class="sl-item '.$elementoAleatorio.' ">
            <div class="sl-content">
                <small class="text-muted">'.$key->date_create_Log.'</small>
                <p>'.$key->name_User.' '. $key->last_name_User .' '. $key->descrip_Log .'</p>
            </div>
        </div>';
        }

        return($actividadesList);
    }

}
