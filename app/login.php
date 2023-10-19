<?php 

require_once 'data.php';

class Sesion{

    private $pdo;

    public function __CONSTRUCT()
    {
        try {
            $this->pdo 		    = Database::StartUp();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function iniciaSesion($data){
    	try {
    	
    		$datos = json_decode($data,true);
            
		  	$usr = $datos['usr'];
  			$pas = $datos['pas'];

  			$sql = "SELECT u.* FROM users_pm as u INNER JOIN role_pm as r on u.role_User = r.id_Role WHERE usr_User = '{$usr}' and psw_User = '{$pas}' LIMIT 1";

    		$stm    = $this->pdo->prepare($sql);
    		$stm->execute();
    		$result = $stm->fetch(PDO::FETCH_OBJ);

    		if (!$result) {
    			$res['selectOk'] = false;
    			$res['mensaje'] = 'El usuario/contraseña ingresados no existe, verificalo.';
    		}else{
    			session_start();
    			$_SESSION['datos_usuario'] = array($result->id_User, $result->usr_User, $result->name_User, $result->last_name_User,$result->role_User, $result->img_User, );
    			$_SESSION['estado_sesion'] = true;

         		$res['selectOk'] = true;
    			$res['mensaje'] = '';
    			$res['session'] = $_SESSION;
     		}

    		return json_encode($res);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }
    public function validarSesion(){
	  if ($_SESSION['estado_sesion'] == NULL) {
	  	session_destroy();
	  	header("Location: ../");
	  }
	}

	public function sessionExiste(){
	  if(isset($_SESSION['estado_sesion']) && $_SESSION['estado_sesion'] == true) {
	    header("Location: dashboard.php");
	  }
	}

	public function cerrarSesion(){
		try {
			session_start();
			session_destroy();

			$result['session'] = true;
			$result['mensaje'] = '';
			
			return json_encode($result);
		}catch (Exception $e){
            die($e->getMessage());
        }
	}

}
?>