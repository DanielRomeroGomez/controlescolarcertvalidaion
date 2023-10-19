<?php
// Obtén el dato encriptado desde la URL
if (isset($_GET['iv']) && isset($_GET['dato'])) {

    $iv_seguro = $_GET['iv'];
    $dato_encriptado_seguro = $_GET['dato'];

    // Decodifica el IV y el dato encriptado (base64url)
    $iv = base64_decode(str_pad(strtr($iv_seguro, '-_', '+/'), strlen($iv_seguro) % 4, '=', STR_PAD_RIGHT));
    $dato_encriptado = base64_decode(str_pad(strtr($dato_encriptado_seguro, '-_', '+/'), strlen($dato_encriptado_seguro) % 4, '=', STR_PAD_RIGHT));

    // Clave para encriptación y desencriptación (debe ser la misma)
    $clave = "unidadeducativa";
    
    // Desencripta el dato
    $curp = openssl_decrypt($dato_encriptado, "aes-256-cbc", $clave, 0, $iv);

    // Realiza la consulta utilizando el dato desencriptado
    // Aquí debes adaptar esta parte según tu base de datos y consulta

    require 'app/data.php';

    $db = Database::StartUp();
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

            $stm    = $db->prepare($sql);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_ASSOC);

} else {
    echo "Falta el parámetro 'dato' en la URL.";
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>
        Validación de Certificados de Educación Básica
    </title>
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/caratula.css" rel="stylesheet">
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/ChecaMod.js"></script>
    <script src="js/myfunction.js"></script>
    <!--[if IE]><link rel="shortcut icon" href="css/img/g.gif" /><![endif]-->
    <link rel="icon" href="css/img/M.gif">
</head>

<body>

    <!--PARA EL ENCABEZADO DE LA PAGINA MAZO OK-->

    <div class="container-fluid">
        <div class="row">
            <table border="0" style="width: 100%;">
                <tbody>
                    <tr style="background-color: #eee; height: 80px;">
                        <td class="visible-lg visible-md enImg1G" style="width: 308px;"></td>
                        <td class="visible-sm visible-xs enImg2G" style="width: 110px;"></td>
                        <td style="border-left: solid; border-color: #aeaeae; border-width: 1px; padding-left: 10px;">
                            <div class="container-fluid">
                                <div class="row">
                                    <span class="TitEnc visible-lg visible-md visible-sm">Validación de Certificados y
                                        Certificaciones de Educación Básica (CERTELEC-SEDUC)</span>

                                </div>
                                <div class="row mbmboro">
                                    <span class="SubTitEnc visible-lg visible-md visible-sm">Secretaría de
                                        Educación</span>

                                </div>
                            </div>
                        </td>
                        <td style="padding: 5px 5px 5px 5px;" width="260px;">
                            <table border="0">
                                <tbody>
                                    <tr>
                                        <td class="enImgLog2" style="height: 70px; width: 240px;"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div style="height: 3px; background-color: #aeaeae;">
                &nbsp;
            </div>
        </div>
    </div>
    <div style="height: 10px;"></div>

    <br>
    <div class="container">

        <div class="supRedondo ">
            <div class="row">
                <div class="col-md-8 input-group">
                    <label for="AutoridadEspide" class="text-right cmp"> Autoridad Expide el Certificado:</label>
                    <span id="AutoridadEspide" class="input-group-append">&nbsp;
                        <?php echo $result['autoridad_certificado_Certificates'];?></span>
                </div>
                <div class="col-md-4 input-group">
                    <label for="Nivel2" class="text-right cmp"> Ciclo Escolar:</label>
                    <span id="cEscolar" class="input-group-append">&nbsp;
                        <?php echo $result['ciclo_escolar_Certificates'];?></span>
                </div>
            </div>

            <div class="row">
                <strong class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center titGral">&nbsp;</strong>
            </div>

            <div class="row">
                <div class="col-md-8 input-group">

                </div>
                <div class="col-md-4 input-group">
                    <label for="Nivel2" class="text-right cmp"> Nivel Educativo:</label>
                    <span id="cEscolar" class="input-group-append">&nbsp;
                        <?php echo $result['nivel_educativo_Certificates'];?></span>
                </div>
            </div>

            <div class="row">
                <strong class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center titGral">DATOS DEL ALUMNO(A)</strong>
            </div>

            <div class="row">
                <div class="col-md-4 input-group">
                    <label for="NombreAlumno2" class="text-right cmp">Nombre:</label>
                    <div class="input-group-append">
                        <span id="NombreAlumno2"><?php echo $result['paternal_surname_Student']." ".$result['mother_surname_Student']." ".$result['name_Student'];?></span>
                    </div>
                </div>
                <div class="col-md-4 input-group">
                    <label for="Nivel2" class="text-right cmp"> CURP:</label>
                    <span id="cEscolar" class="input-group-append">&nbsp; <?php echo $result['curp_Student'];?></span>
                </div>

                <div class="col-md-4 input-group">
                    <label for="Nivel2" class="text-right cmp"> Sexo:</label>
                    <span id="cEscolar" class="input-group-append">&nbsp; <?php echo $result['sex_Student'];?></span>
                </div>
            </div>

            <div class="row">
                <strong class="col-md-7 text-center titGral">DATOS DE LA ESCUELA</strong>
                <strong class="col-md-5 text-center titGral">PROMEDIO FINAL</strong>
            </div>

            <!---->

            <div class="row">
                <div class="container col-lg-7 col-md-7">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 input-group">
                            <label for="CCT2" class="text-right cmp"> C.C.T.:</label>
                            <span id="CCT2" class="input-group-append">&nbsp; <?php echo $result['cct_Certificates'];?></span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 input-group">
                            <label for="Turno2" class="text-right cmp"> Turno:</label>
                            <span id="Turno2" class="input-group-append">&nbsp; <?php echo $result['turno_Certificates'];?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <label for="Escuela2" class="text-right cmp"> Nombre:</label>
                            <span id="Escuela2">&nbsp; <?php echo $result['nombre_escuela_Certificates'];?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <label for="Domicilio2" class=" text-right cmp"> Domicilio:</label>
                            <span id="Domicilio2">&nbsp;<?php echo $result['domicilio_Certificates'];?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <label for="Municipio2" class=" text-right cmp"> Municipio:</label>
                            <span id="Municipio2">&nbsp;<?php echo $result['municipio_Certificates'];?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <label for="Localidad2" class=" text-right cmp"> Localidad:</label>
                            <span id="Localidad2">&nbsp;<?php echo $result['localidad_Certificates'];?></span>
                        </div>
                    </div>
                </div>
                <div class="container col-lg-5 col-md-5">
                    <div class="row" style="justify-content:center;">
                        <h1 >
                            <span id="PromedioGeneral2" ><?php echo $result['promedio_final_Certificates'];?></span>
                        </h1>
                        <span class="visible-lg visible-md visible-sm">&nbsp;</span>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12">

                            <label for="Rodac2" class="visible-md col-md-7 text-right cmp">
                                Número de Folio</label>
                            <span id="Rodac2" class="col-lg-12 col-md-5 col-sm-12 col-xs-12 text-center"></span>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-6">
                            <label for="Certificacion2"
                                class=" text-center cmp">
                                Número de Certificado</label>
                            <span id="Certificacion2"
                                class=" text-center"><?php echo $result['numero_certificado_Certificates'];?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="width: inherit">
            <hr class="mhr">
        </div>
        <div class="container ">

        </div>


    </div>
    <!-- INICIA PIE DE PÁGINA -->
    <table border="0">
        <tbody>
            <tr>
                <td style="height: 120px;">&nbsp;
                </td>
            </tr>
        </tbody>
    </table>
    <div id="inferior" class="container-fluid" style="background-color: #EEEEED; color: black;">

        <div class="col-lg-5 col-md-5 col-sm-4 col-xs-12 text-right">
            <span>Gobierno del Estado de México<br>
                Secretaría de Eucación </span>
        </div>
        <div class="visible-lg visible-md visible-sm col-lg-7 col-md-7 col-sm-8">
            <span>Avenida Independencia Oriente, Número 407, Tercer Piso, Colonia Santa Clara<br>
                Toluca México, Código Postal 50060<br>
                Teléfono : (01 722) 2 14 72 58&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                CERTELEC-SEDUC Ver. 01.06.15<br>
            </span>
        </div>
        <div class="visible-xs col-xs-12 text-right">
            Av. Independencia Ote, # 407, 3° Piso,<br>
            Col.Santa Clara, Toluca Méx, CP.50060
        </div>
    </div>
    <!--FIN DE PIE DE PÁGINA-->


</body>

</html>