<?php
session_start();
require_once 'data.php';
error_reporting(0);

class Alumnos{

    private $pdo;

    public function __CONSTRUCT()
    {
        try {
            $this->pdo 		    = Database::StartUp();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getAlumnos(){
        try{

            $sql = "SELECT spm.id_Students,
                           spm.name_Student,
                           spm.paternal_surname_Student,
                           spm.mother_surname_Student,
                           spm.curp_Student,
                           spm.birth_date_Student,
                           spm.adress_Student,
                           spm.phone_Student,
                           spm.email_Student,
                           spm.status_Student,
                           spm.date_create_Student,
                           spm.user_create_Student,
                           spm.date_edit_Student,
                           spm.user_edit_Student,
                           upm.id_User,
                           upm.name_User,
                           upm.last_name_User,
                           upm.email_User,
                           upm.usr_User,
                           upm.psw_User,
                           upm.phone_User,
                           upm.status_User,
                           upm.img_User,
                           upm.role_User,
                           upm.create_date_User,
                           upm.position_User 
                    FROM students_pm as spm 
                    INNER JOIN users_pm AS upm ON spm.user_create_Student = upm.id_User
                    WHERE spm.status_Student = 1";

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
            <table class='table' id='gridAlumnos' style='width:100%;'>
            <thead>
                <tr>
                    <th class='text-center'>No.</th>
                    <th class='text-center'>Nombre del Alumno</th>
                    <th class='text-center'>Correo</th>
                    <th class='text-center'>CURP</th>
                    <th class='text-center'>Alta</th>
                    <th class='text-center' style='".$style."'>Acciones</th>
                </tr>
            </thead>
            <tbody>";
            
            foreach ($result as $key) {

                $btn = "<div class='btn-group' role='group' aria-label='Basic example'>
                                <button type='button' class='btn btn-primary' onclick=\"infoAlumno('$key->id_Students','$key->curp_Student');\"><i class='fa fa-pencil-square-o'></i></button>
                                <button type='button' class='btn btn-danger' onclick=\"eliminaAlumno('$key->id_Students','$key->curp_Student');\"><i class='fa fa-trash-o'></i></button>
                                <button type='button' class='btn btn-info' data-toggle='modal' data-target='.qrcode' onclick=\"codeqr('$key->name_Student $key->paternal_surname_Student','$key->curp_Student');\"><i class='fa fa-qrcode'></i></button>
                            </div>";

            $style = 'display:block;';
            if ($_SESSION['estado_sesion'] && $_SESSION['datos_usuario'][4] == 3 || $_SESSION['datos_usuario'][4] == 6) {
                $btn = '';
                $style = 'display:none;';
            }else if ($_SESSION['estado_sesion'] && $_SESSION['datos_usuario'][4] == 4) {
                $btn = "<div class='btn-group' role='group' aria-label='Basic example'>
                                <button type='button' class='btn btn-primary' onclick=\"infoUsuario('$key->id_Students','$key->curp_Student');\"><i class='fa fa-pencil-square-o'></i></button>
                            </div>";
                $style = 'display:block;';
            }else if ($_SESSION['estado_sesion'] && $_SESSION['datos_usuario'][4] == 5) {
                $btn = "<div class='btn-group' role='group' aria-label='Basic example'>
                                <button type='button' class='btn btn-danger' onclick=\"eliminaUsuario('$key->id_Students','$key->curp_Student');\"><i class='fa fa-trash-o'></i></button>
                            </div>";
                $style = 'display:block;';
            }

                $tabla .= "<tr>";
                $tabla .= "<td class='text-center'><b>".$contador."</b></td>";
                $tabla .= "<td class='text-left'><b>".$key->name_Student." " .$key->paternal_surname_Student." " .$key->mother_surname_Student."</b></td>";
                $tabla .= "<td class='text-left'><b>".$key->email_Student. "</b></td>";
                $tabla .= "<td class='text-left'><b>".$key->curp_Student."</b></td>";
                $tabla .= "<td class='text-left'><b>".$key->name_User." " .$key->last_name_User."</b></td>";
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

    public function alumnosExcel(){
        require '../assets/php-excel/PHPExcel.php';
        require 'logs.class.php';

        $logs = new Logs(); 

        $dataLog = [];
        
        try{
            $return = [];
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                // Verifica si se recibió un archivo
                if (isset($_FILES["p2"]) && $_FILES["p2"]["error"] === UPLOAD_ERR_OK) {

                    /* DATA STUDENTS */
                    $name_Student = '';
                    $paternal_surname_Student= '';
                    $mother_surname_Student= '';
                    $curp_Student= '';
                    $sex_Student= '';
                    $status_Student = 0;
                    $date_create_Student = '';
                    $user_create_Student = '';

                    /* DATA CERTIFICATES */

                    $id_Student_Certificates = 0;
                    $autoridad_certificado_Certificates = '';
                    $ciclo_escolar_Certificates = '';
                    $nivel_educativo_Certificates = '';
                    $cct_Certificates = '';
                    $turno_Certificates = '';
                    $promedio_final_Certificates = 0.0;
                    $nombre_escuela_Certificates = '';
                    $domicilio_Certificates = '';
                    $municipio_Certificates = '';
                    $localidad_Certificates = '';
                    $numero_folio_Certificates = '';
                    $numero_certificado_Certificates = '';

                    $nombreArchivo = $_FILES["p2"]["name"];
                    $rutaTemporal = $_FILES["p2"]["tmp_name"];
                    // Mueve el archivo a una ubicación deseada en el servidor
                    //$rutaDestino = "../files/" . $nombreArchivo;
                    $rutaDestino = "../files/". $nombreArchivo;
                    if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                        //echo "El archivo $nombreArchivo se ha subido con éxito.";
            
                        // Ruta del archivo Excel a abrir
                        $archivoExcel = $rutaDestino;
                        try {
                            // Crea un objeto PHPExcel
                            $objPHPExcel = PHPExcel_IOFactory::load($archivoExcel);

                            // Selecciona la hoja de trabajo (worksheet) por su índice
                            $objPHPExcel->setActiveSheetIndex(0);
                            $worksheet = $objPHPExcel->getActiveSheet();

                            // Obtén el número de filas y columnas utilizadas en la hoja
                            $filas = $worksheet->getHighestRow();
                            $columnas = $worksheet->getHighestColumn();

                            // Recorre las filas y columnas para obtener los datos
                            for ($fila = 2; $fila <= $filas; $fila++) {
                                //for ($col = 'A'; $col <= 'P'; $col++) {
                                    // Obtiene el valor en cada celda
                                    //$valor = $worksheet->getCell($col . $fila)->getValue();
                                    //$valor = $worksheet->getCell('A' . $fila)->getValue();
                                    $autoridad_certificado_Certificates = $worksheet->getCell('A' . $fila)->getValue();
                                    $ciclo_escolar_Certificates = $worksheet->getCell('B' . $fila)->getValue();
                                    $nivel_educativo_Certificates = $worksheet->getCell('C' . $fila)->getValue();
                                    $name_Student = $worksheet->getCell('D' . $fila)->getValue();
                                    $paternal_surname_Student = $worksheet->getCell('E' . $fila)->getValue();
                                    $mother_surname_Student = $worksheet->getCell('F' . $fila)->getValue();
                                    $curp_Student = $worksheet->getCell('G' . $fila)->getValue();
                                    $sex_Student = $worksheet->getCell('H' . $fila)->getValue();
                                    $cct_Certificates = $worksheet->getCell('I' . $fila)->getValue();
                                    $turno_Certificates = $worksheet->getCell('J' . $fila)->getValue();
                                    $promedio_final_Certificates = $worksheet->getCell('K' . $fila)->getValue();
                                    $nombre_escuela_Certificates = $worksheet->getCell('L' . $fila)->getValue();
                                    $domicilio_Certificates = $worksheet->getCell('M' . $fila)->getValue();
                                    $municipio_Certificates = $worksheet->getCell('N' . $fila)->getValue();
                                    $localidad_Certificates = $worksheet->getCell('O' . $fila)->getValue();
                                    $numero_folio_Certificates = $worksheet->getCell('P' . $fila)->getValue();
                                    $numero_certificado_Certificates = $worksheet->getCell('Q' . $fila)->getValue();

                                    $sql = "SELECT id_Students
                                            FROM students_pm
                                            WHERE curp_Student = '".$curp_Student."'
                                            LIMIT 1";

                                    $stm    = $this->pdo->prepare($sql);
                                    $stm->execute();
                                    $result = $stm->fetchAll(PDO::FETCH_OBJ);

                                    if(count($result) == 0){

                                        $status_Student = 1; 

                                        $sql = 'INSERT INTO students_pm (name_Student, paternal_surname_Student, mother_surname_Student, curp_Student, sex_Student, status_Student, date_create_Student, user_create_Student)
                                            VALUES (:name_Student, :paternal_surname_Student, :mother_surname_Student, :curp_Student, :sex_Student, :status_Student, NOW(), :user_create_Student)';

                                        $stm    = $this->pdo->prepare($sql);
                                        $stm->bindParam(':name_Student', $name_Student, PDO::PARAM_STR);
                                        $stm->bindParam(':paternal_surname_Student', $paternal_surname_Student, PDO::PARAM_STR);
                                        $stm->bindParam(':mother_surname_Student', $mother_surname_Student, PDO::PARAM_STR);
                                        $stm->bindParam(':curp_Student', $curp_Student, PDO::PARAM_STR);
                                        $stm->bindParam(':sex_Student', $sex_Student, PDO::PARAM_STR);
                                        $stm->bindParam(':status_Student', $status_Student, PDO::PARAM_INT);
                                        $stm->bindParam(':user_create_Student', $_SESSION['datos_usuario'][0], PDO::PARAM_STR);

                                        try {
                                            $stm->execute();
                                            //echo 'Inserción exitosa.';

                                            $dataLog['descrip'] = 'Agregó Alumnos';
                                            $dataLog['instruccion'] = addslashes($stm->queryString);
                                            $dataLog['user'] = $_SESSION['datos_usuario'][0];

                                            $logs->aplyLogs($dataLog);
                                            
                                            
                                        } catch (PDOException $e) {
                                            echo 'Error al insertar en la base de datos: ' . $e->getMessage();
                                        }

                                    }

                                    $sqlId = "SELECT id_Students
                                            FROM students_pm
                                            WHERE curp_Student = '".$curp_Student."'
                                            LIMIT 1";

                                        
                                    $stm    = $this->pdo->prepare($sqlId);
                                    $stm->execute();
                                    $result = $stm->fetchAll(PDO::FETCH_OBJ);

                                    foreach ($result as $res) {
                                        $id_Student_Certificates = intval($res->id_Students);
                                    }

                                    $sqlCer = "SELECT id_Certificates
                                    FROM student_certificates_pm
                                    WHERE numero_certificado_Certificates = '".$numero_certificado_Certificates."'
                                    LIMIT 1";

                                    $stm    = $this->pdo->prepare($sqlCer);
                                    $stm->execute();
                                    $resultCer = $stm->fetchAll(PDO::FETCH_OBJ);

                                    if(count($resultCer) == 0){
                                        /*$sqlCert = 'INSERT INTO student_certificates_pm (autoridad_certificado_Certificates, ciclo_escolar_Certificates, nivel_educativo_Certificates, id_Student_Certificates, cct_Certificates, turno_Certificates, promedio_final_Certificates, nombre_escuela_Certificates, domicilio_Certificates, municipio_Certificates, localidad_Certificates, numero_folio_Certificates, numero_certificado_Certificates)
                                            VALUES (:autoridad_certificado_Certificates, :ciclo_escolar_Certificates, :nivel_educativo_Certificates, :id_Student_Certificates, :cct_Certificates, :turno_Certificates, :promedio_final_Certificates, :nombre_escuela_Certificates, :domicilio_Certificates, :municipio_Certificates, :localidad_Certificates, :numero_folio_Certificates, :numero_certificado_Certificates)';*/
                                        
                                        $sqlCert = "INSERT INTO student_certificates_pm (autoridad_certificado_Certificates, ciclo_escolar_Certificates, nivel_educativo_Certificates, id_Student_Certificates, cct_Certificates, turno_Certificates, promedio_final_Certificates, nombre_escuela_Certificates, domicilio_Certificates, municipio_Certificates, localidad_Certificates, numero_folio_Certificates, numero_certificado_Certificates)
                                            VALUES ('".$autoridad_certificado_Certificates."', '".$ciclo_escolar_Certificates."', '".$nivel_educativo_Certificates."', ".$id_Student_Certificates.", '".$cct_Certificates."', '".$turno_Certificates."', '".$promedio_final_Certificates."', '".$nombre_escuela_Certificates."', '".$domicilio_Certificates."', '".$municipio_Certificates."', '".$localidad_Certificates."', '".$numero_folio_Certificates."', '".$numero_certificado_Certificates."')";
                                        
                                        $stmCer    = $this->pdo->prepare($sqlCert);
                                        /*$stmCer->bindParam(':autoridad_certificado_Certificates', $autoridad_certificado_Certificates, PDO::PARAM_STR);
                                        $stmCer->bindParam(':ciclo_escolar_Certificates', $ciclo_escolar_Certificates, PDO::PARAM_STR);
                                        $stmCer->bindParam(':nivel_educativo_Certificates', $nivel_educativo_Certificates, PDO::PARAM_STR);
                                        $stmCer->bindParam(':id_Student_Certificates', $id_Student_Certificates, PDO::PARAM_INT);
                                        $stmCer->bindParam(':cct_Certificates', $cct_Certificates, PDO::PARAM_STR);
                                        $stmCer->bindParam(':turno_Certificates', $turno_Certificates, PDO::PARAM_STR);
                                        $stmCer->bindParam(':promedio_final_Certificates', $promedio_final_Certificates, PDO::PARAM_STR);
                                        $stmCer->bindParam(':nombre_escuela_Certificates', $nombre_escuela_Certificates, PDO::PARAM_STR);
                                        $stmCer->bindParam(':domicilio_Certificates', $domicilio_Certificates, PDO::PARAM_STR);
                                        $stmCer->bindParam(':municipio_Certificates', $municipio_Certificates, PDO::PARAM_STR);
                                        $stmCer->bindParam(':localidad_Certificates', $localidad_Certificates, PDO::PARAM_STR);
                                        $stmCer->bindParam(':numero_folio_Certificates', $numero_folio_Certificates, PDO::PARAM_STR);
                                        $stmCer->bindParam(':numero_certificado_Certificates', $numero_certificado_Certificates, PDO::PARAM_STR);*/

                                        try {
                                            $stmCer->execute();

                                            $dataLog = [];

                                            $dataLog['descrip'] = 'Agregó Certificados a nuevos Alumnos';
                                            $dataLog['instruccion'] = addslashes($sqlCert);
                                            $dataLog['user'] = $_SESSION['datos_usuario'][0];

                                            $logs->aplyLogs($dataLog);
                                        } catch (PDOException $e) {
                                            echo 'Error al insertar en la base de datos: ' . $e->getMessage();
                                        }
                                    }

                                //}
                            }

                            $return['insertedOk']   = true;
                            $return['mensaje']      = 'Alumnos cargados correctamente';
                        } catch (Exception $e) {
                            $return['insertedOk']   = false;
                            $return['mensaje']      = 'Error al abrir el archivo Excel: '.$e->getMessage();
                        }
                        
                    } else {
                        $return['insertedOk']   = false;
                        $return['mensaje']      = 'Error al mover el archivo.';
                    }
                } else {
                    $return['insertedOk']   = false;
                    $return['mensaje']      = 'No se ha seleccionado ningún archivo o ha ocurrido un error en la carga.';
                }
            } else {
                $return['insertedOk']   = false;
                $return['mensaje']      = 'Solicitud no válida.';
            }
            
            if (file_exists($rutaDestino)) {
                if (unlink($rutaDestino)) {
                    
                } else {
                    
                }
            } else {
                
            }
            
           
            return json_encode($return);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function getQRAlumnos($data){
        try{
            $datos = json_decode($data,true);
            $idE = intval($datos['no']);
            $curp = trim($datos['cu']);
            
            /*$sql = "SELECT spm.id_Students,
                            spm.name_Student,
                            spm.paternal_surname_Student,
                            spm.mother_surname_Student,
                            spm.curp_Student,
                            spm.birth_date_Student,
                            spm.adress_Student,
                            spm.phone_Student,
                            spm.email_Student,
                            spm.status_Student,
                            spm.date_create_Student,
                            spm.user_create_Student,
                            spm.date_edit_Student,
                            spm.user_edit_Student,
                            upm.id_User,
                            upm.name_User,
                            upm.last_name_User,
                            upm.email_User,
                            upm.usr_User,
                            upm.psw_User,
                            upm.phone_User,
                            upm.status_User,
                            upm.img_User,
                            upm.role_User,
                            upm.create_date_User,
                            upm.position_User,
                            scpm.id_Certificates,
                            scpm.autoridad_certificado_Certificates,
                            scpm.ciclo_escolar_Certificates,
                            scpm.nivel_educativo_Certificates,
                            scpm.id_Student_Certificates,
                            scpm.cct_Certificates,
                            scpm.turno_Certificates,
                            scpm.promedio_final_Certificates,
                            scpm.nombre_escuela_Certificates,
                            scpm.domicilio_Certificates,
                            scpm.municipio_Certificates,
                            scpm.localidad_Certificates,
                            scpm.numero_folio_Certificates,
                            scpm.numero_certificado_Certificates
                    FROM students_pm as spm 
                    INNER JOIN users_pm AS upm ON spm.user_create_Student = upm.id_User
                    INNER JOIN student_certificates_pm AS scpm ON scpm.id_Student_Certificates = spm.id_Students
                    WHERE spm.curp_Student = '".$curp."'";

            $stm    = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_OBJ);

            var_dump($result);*/

            // Dato a encriptar
            $dato = $curp;

            // Encripta el dato (ejemplo utilizando OpenSSL)
            $clave = "unidadeducativa";
            
            // Encripta el dato
            $iv = openssl_random_pseudo_bytes(16); // IV con 16 bytes
            $dato_encriptado = openssl_encrypt($dato, "aes-256-cbc", $clave, 0, $iv);

            // Codifica el IV y el dato encriptado a formato seguro para URL (base64url)
            $iv_seguro = rtrim(strtr(base64_encode($iv), '+/', '-_'), '=');
            $dato_encriptado_seguro = rtrim(strtr(base64_encode($dato_encriptado), '+/', '-_'), '=');

            // Crea la URL que llevará el IV y el dato encriptado como parámetros
            //$url = "http://localhost/pm/caratula?iv={$iv_seguro}&dato={$dato_encriptado_seguro}";
            $url = "http://controlescolar.site/caratula.php?iv={$iv_seguro}&dato={$dato_encriptado_seguro}";

            // Incluye la biblioteca QR Code
            require '../assets/phpqrcode/qrlib.php';

            // Texto que deseas codificar en el QR Code
            $texto = $url;

            // Directorio donde se guardará la imagen del QR Code
            $directorio = '../codeqr/';

            // Nombre del archivo de imagen del QR Code (puede ser algo como qr_codigo.png)
            $nombre_archivo = $curp.'.png';

            // Ruta completa del archivo de imagen
            $ruta_archivo = $directorio . $nombre_archivo;

            // Configuración del QR Code
            $tamaño = 200; // Tamaño en píxeles
            $nivel_corrección = 'L'; // Nivel de corrección de errores (L, M, Q, H)

            // Crea el QR Code
            QRcode::png($texto, $ruta_archivo, $nivel_corrección, $tamaño);

            // Muestra la imagen del QR Code
            $res = '<a href="codeqr/' . $nombre_archivo . '" download><center><img src="codeqr/' . $nombre_archivo . '" alt="QR Code" style="width: 70%;"></center></a><div style="text-align:center; font-weight: bold;">*Nota: Da clic sobre el Código QR para descargar.*</div>';
            
            $return['insertedOk']   = true;
            $return['mensaje']      = $res;
            return json_encode($return);           
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function getAlumnosEntradas(){
        try{
            

            $sqlTotal = "SELECT count(*) AS conteoTotal
                    FROM students_pm ";

            $stm    = $this->pdo->prepare($sqlTotal);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_OBJ);

            $conteoTotal = intval($result->conteoTotal);

            $sqlActivos = "SELECT count(*) AS conteoActivos
                    FROM students_pm 
                    WHERE status_Student = 1";

            $stm    = $this->pdo->prepare($sqlActivos);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_OBJ);

            $conteoActivos = intval($result->conteoActivos);

            $sqlCertificados = "SELECT COUNT(*) AS conteoCertificados
            FROM students_pm as spm
            INNER JOIN student_certificates_pm as stpm ON stpm.id_Student_Certificates = spm.id_Students";

            $stm    = $this->pdo->prepare($sqlCertificados);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_OBJ);

            $conteoCertificados = intval($result->conteoCertificados);
            
            $datos = ["conteoTotal" => $conteoTotal, "conteoActivos" => $conteoActivos, "conteoCertificados" => $conteoCertificados];
            
            $return['insertedOk']   = true;
            $return['datos']      = $datos;
           
            return json_encode($return);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function getAlumnosUltimos(){
        try{

            $sql = "SELECT spm.id_Students,
                            spm.name_Student,
                            spm.paternal_surname_Student,
                            spm.mother_surname_Student,
                            spm.curp_Student,
                            spm.birth_date_Student,
                            spm.adress_Student,
                            spm.phone_Student,
                            spm.email_Student,
                            spm.status_Student
                    FROM students_pm as spm 
                    ORDER BY spm.id_Students DESC
                    LIMIT 5";

            $stm    = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            
            $contador = 1;

            $tabla = '<table class="table table-hover">
            <thead class="text-primary">
                <tr>
                    <th>No.</th>
                    <th>Nombre</th>
                    <th>CURP</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';
            
            foreach ($result as $key) {

                $tabla .= "<tr>";
                $tabla .= "<td class='text-center'><b>".$contador."</b></td>";
                $tabla .= "<td class='text-left'><b>".$key->name_Student." " .$key->paternal_surname_Student." " .$key->mother_surname_Student."</b></td>";
                $tabla .= "<td class='text-left'><b>".$key->curp_Student."</b></td>";
                $tabla .= "<td class='text-left'></td>";
                $tabla .= "</tr>";
                $contador++;
           }
           
            $tabla .= "</tbody>
            </table>";
           
            return($tabla);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function getAlumno($data){
        try{

            $return = [];
            $datos = json_decode($data,true);
            $idU = intval($datos['id']);
            $curp = trim($datos['curp']);
            
            $sql = "SELECT spm.id_Students, 
                            spm.name_Student,
                            spm.paternal_surname_Student,
                            spm.mother_surname_Student,
                            spm.curp_Student,
                            spm.sex_Student,
                            spm.birth_date_Student,
                            spm.adress_Student,
                            spm.phone_Student,
                            spm.email_Student,
                            spm.status_Student,
                            spm.date_create_Student,
                            spm.user_create_Student,
                            spm.date_edit_Student,
                            spm.user_edit_Student,
                            scpm.id_Certificates,
                            scpm.autoridad_certificado_Certificates,
                            scpm.ciclo_escolar_Certificates,
                            scpm.nivel_educativo_Certificates,
                            scpm.id_Student_Certificates,
                            scpm.cct_Certificates,
                            scpm.turno_Certificates,
                            scpm.promedio_final_Certificates,
                            scpm.nombre_escuela_Certificates,
                            scpm.domicilio_Certificates,
                            scpm.municipio_Certificates,
                            scpm.localidad_Certificates,
                            scpm.numero_folio_Certificates,
                            scpm.numero_certificado_Certificates
                    FROM students_pm as spm 
                    INNER JOIN student_certificates_pm as scpm ON scpm.id_Student_Certificates = spm.id_Students
                    WHERE spm.id_Students = ".$idU." AND spm.curp_Student = '".$curp."'";

            $stm    = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_OBJ);
            
            $return['id_Students'] = $result->id_Students;
            $return['name_Student'] = $result->name_Student;
            $return['paternal_surname_Student'] = $result->paternal_surname_Student;
            $return['mother_surname_Student'] = $result->mother_surname_Student;
            $return['curp_Student'] = $result->curp_Student;
            $return['sex_Student'] = $result->sex_Student;
            $return['birth_date_Student'] = $result->birth_date_Student;
            $return['adress_Student'] = $result->adress_Student;
            $return['phone_Student'] = $result->phone_Student;
            $return['email_Student'] = $result->email_Student;
            $return['status_Student'] = $result->status_Student;
            $return['date_create_Student'] = $result->date_create_Student;
            $return['user_create_Student'] = $result->user_create_Student;
            $return['date_edit_Student'] = $result->date_edit_Student;
            $return['user_edit_Student'] = $result->user_edit_Student;

            $return['autoridad_certificado_Certificates'] = $result->autoridad_certificado_Certificates;
            $return['ciclo_escolar_Certificates'] = $result->ciclo_escolar_Certificates;
            $return['nivel_educativo_Certificates'] = $result->nivel_educativo_Certificates;
            $return['id_Student_Certificates'] = $result->id_Student_Certificates;
            $return['cct_Certificates'] = $result->cct_Certificates;
            $return['turno_Certificates'] = $result->turno_Certificates;
            $return['promedio_final_Certificates'] = $result->promedio_final_Certificates;
            $return['nombre_escuela_Certificates'] = $result->nombre_escuela_Certificates;
            $return['domicilio_Certificates'] = $result->domicilio_Certificates;
            $return['municipio_Certificates'] = $result->municipio_Certificates;
            $return['localidad_Certificates'] = $result->localidad_Certificates;
            $return['numero_folio_Certificates'] = $result->numero_folio_Certificates;
            $return['numero_certificado_Certificates'] = $result->numero_certificado_Certificates;
           
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

    public function saveAlumno($data){
        try{
            $datos = json_decode($data,true);
            $id_Students = intval($datos['id_Students']);
            $name_Student = trim($datos['name_Student']);
            $paternal_surname_Student = trim($datos['paternal_surname_Student']);
            $mother_surname_Student = trim($datos['mother_surname_Student']);
            $curp_Student = trim($datos['curp_Student']);
            $sex_Student = trim($datos['sex_Student']);
            
            $insert = "UPDATE students_pm 
                        SET name_Student='".$name_Student."',
                            paternal_surname_Student='".$paternal_surname_Student."',
                            mother_surname_Student='".$mother_surname_Student."',
                            curp_Student='".$curp_Student."',
                            sex_Student='".$sex_Student."',
                            date_edit_Student=NOW(),
                            user_edit_Student=".$_SESSION['datos_usuario'][0]."
                        WHERE id_Students =".$id_Students;

            $stm = $this->pdo->prepare($insert);
            
            if($stm->execute()){
                $return['insertedOk']   = true;
                $return['mensaje']      = 'Se actualizó al alumno '.$name_Student.' correctamente.';
                //$return['query']        = $insert;
            }else{
                $return['insertedOk']   = false;
                $return['mensaje']      = 'Hubo un error al actualizar el registro del alumno '.$name_Student.'.';
                //$return['query']        = $insert;
            }
           
            return json_encode($return);           
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function saveCert($data){
        try{
            $datos = json_decode($data,true);
            
            $id_Students = intval($datos['id_Students']);
            $name_Student = trim($datos['name_Student']);
            $autoridad_certificado_Certificates = trim($datos['autoridad_certificado_Certificates']);
            $ciclo_escolar_Certificates = trim($datos['ciclo_escolar_Certificates']);
            $nivel_educativo_Certificates = trim($datos['nivel_educativo_Certificates']);
            $cct_Certificates = trim($datos['cct_Certificates']);
            $turno_Certificates = trim($datos['turno_Certificates']);
            $promedio_final_Certificates = trim($datos['promedio_final_Certificates']);
            $nombre_escuela_Certificates = trim($datos['nombre_escuela_Certificates']);
            $domicilio_Certificates = trim($datos['domicilio_Certificates']);
            $municipio_Certificates = trim($datos['municipio_Certificates']);
            $localidad_Certificates = trim($datos['localidad_Certificates']);
            $numero_folio_Certificates = trim($datos['numero_folio_Certificates']);
            $numero_certificado_Certificates = trim($datos['numero_certificado_Certificates']);
            
            $insert = "UPDATE student_certificates_pm
                        SET autoridad_certificado_Certificates='".$autoridad_certificado_Certificates."',
                            ciclo_escolar_Certificates='".$ciclo_escolar_Certificates."',
                            nivel_educativo_Certificates='".$nivel_educativo_Certificates."',
                            cct_Certificates='".$cct_Certificates."',
                            turno_Certificates='".$turno_Certificates."',
                            promedio_final_Certificates='".$promedio_final_Certificates."',
                            nombre_escuela_Certificates='".$nombre_escuela_Certificates."',
                            domicilio_Certificates='".$domicilio_Certificates."',
                            municipio_Certificates='".$municipio_Certificates."',
                            localidad_Certificates='".$localidad_Certificates."',
                            numero_folio_Certificates='".$numero_folio_Certificates."',
                            numero_certificado_Certificates='".$numero_certificado_Certificates."'
                        WHERE id_Student_Certificates = ".$id_Students;

            $stm = $this->pdo->prepare($insert);
            
            if($stm->execute()){
                $return['insertedOk']   = true;
                $return['mensaje']      = 'Se actualizó la información del certificado de '.$name_Student.' correctamente.';
                //$return['query']        = $insert;
            }else{
                $return['insertedOk']   = false;
                $return['mensaje']      = 'Hubo un error al actualizar el la informacion de certificado de '.$name_Student.'.';
                //$return['query']        = $insert;
            }
           
            return json_encode($return);           
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function eliminaAlumno($data){
        try{
            $datos = json_decode($data,true);

            $id = intval($datos['id']);
            $curp = trim($datos['curp']);

            
            $sql = "UPDATE students_pm
            SET status_Student = 0
            WHERE id_Students = $id AND curp_Student = '".$curp."'";

            $stm = $this->pdo->prepare($sql);
            
            if($stm->execute()){
                $return['insertedOk']   = true;
                $return['mensaje']      = 'Se aliminó la información del alumno correctamente.';
                //$return['query']        = $insert;
            }else{
                $return['insertedOk']   = false;
                $return['mensaje']      = 'Hubo un error al eliminar la informacion del alumno.';
                //$return['query']        = $insert;
            }
           
            return json_encode($return);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

}
