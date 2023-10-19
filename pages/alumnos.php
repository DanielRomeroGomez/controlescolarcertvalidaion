<div class="row">
    <div class="col-md-12">
        <div class="card" style="min-height:485px; padding: 30px;">

            <div class="card-header card-header-text">
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="card-title">Administración de Alumnos</h4>
                        <!--p class="category"></p-->
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <button class="btn btn-primary" id="nuevo_alumno" style="display: block;">Cargar
                            Alumnos</button>
                        <button class="btn btn-primary" id="lista_alumnos" style="display: none;">Lista de
                            Alumnos</button>
                    </div>
                </div>
                <hr>
            </div>
            <div class="card-content table-responsive" id="data_response">
            </div>
            <div class="card-content" id="formAlumnos" style="display: none;">
                <!--ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
                  <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
                  <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
               </ul-->

                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" data-toggle="tab" href="#home">Alta masiva de
                            Alumnos</a>
                    </li>
                    <!--li class="nav-item">
                        <a class="nav-link disabled" data-toggle="tab" href="#menu1">Alta de Alumno</a>
                    </li-->
                    <!--li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#menu2">Link</a>
                  </li-->
                    <!--li class="nav-item">
                     <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                  </li-->
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane active">
                        <div class="col-md-12">
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <h2>Subir Archivo Excel</h2>
                                </div>
                                <div class="col-md-6 text-center">
                                    <a href="../assets/resource/datos-alumnos.xlsx" download
                                        class="btn btn-md btn-info">Descargar Template</a>
                                </div>
                            </div>
                            <div class="input-group">
                                <input class="form-control form-control-lg" id="archivoExcel" type="file"
                                    accept=".xlsx, .xls">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary btn-lg" id="cargarArchivo">Cargar
                                        Archivo</button>
                                </div>
                            </div>
                            <br>
                            <div id="resultado"></div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-content" id="editAlumno" style="display: none;">

                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" data-toggle="tab" href="#dAlumno">Datos del Alumnos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#dCert">Datos del Certificado</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="dAlumno" class="tab-pane active">
                        <div class="col-md-12">
                            <br>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Nombre del Alumno</label>
                                    <input type="text" class="form-control" id="name_Student" placeholder="Nombre">
                                    <input type="hidden" id="id_Students">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Apellido Paterno</label>
                                    <input type="text" class="form-control" id="paternal_surname_Student"
                                        placeholder="Apellidos">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Apellido Materno</label>
                                    <input type="text" class="form-control" id="mother_surname_Student"
                                        placeholder="Apellidos">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">CURP</label>
                                    <input type="text" class="form-control" id="curp_Student" placeholder="CURP">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Género</label>
                                    <input type="text" class="form-control" id="sex_Student" placeholder="Género del Alumno">
                                    <!--select id="inputState" class="form-control">
                                        <option selected>Choose...</option>
                                        <option>...</option>
                                    </select-->
                                </div>
                            </div>
                            <div class="row" style="text-align: center;">

                                <div class="form-group col-md-4"></div>
                                <div class="form-group col-md-4">
                                    <br>
                                    <button type="submit" class="btn btn-primary" id="save_data_user"><span
                                            class="material-icons">save</span>Guardar Información</button>
                                </div>
                                <div class="form-group col-md-4"></div>
                            </div>
                            <br>
                            <div id="resultado"></div>
                        </div>

                    </div>

                    <div id="dCert" class="tab-pane">
                        <div class="col-md-12">
                            <br>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Autoriadad que Expide el Certificado</label>
                                    <input type="text" class="form-control" id="autoridad_certificado_Certificates"
                                        placeholder="Autoriadad que Expide el Certificado">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Ciclo Escolar</label>
                                    <input type="text" class="form-control" id="ciclo_escolar_Certificates"
                                        placeholder="Ciclo Escolar">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Nivel Educativo</label>
                                    <input type="text" class="form-control" id="nivel_educativo_Certificates"
                                        placeholder="Nivel Educativo">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">CCT</label>
                                    <input type="text" class="form-control" id="cct_Certificates" placeholder="CCT">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Turno</label>
                                    <input type="text" class="form-control" id="turno_Certificates" placeholder="Turno">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4"></label>
                                    <input type="text" class="form-control" id="promedio_final_Certificates"
                                        placeholder="Promedio Final">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Nombre de la Escuela</label>
                                    <input type="text" class="form-control" id="nombre_escuela_Certificates"
                                        placeholder="Nombre de la Escuela">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Domicilio de la Escuela</label>
                                    <input type="text" class="form-control" id="domicilio_Certificates"
                                        placeholder="Domicilio de la Escuela">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Municipio de la Escuela</label>
                                    <input type="text" class="form-control" id="municipio_Certificates"
                                        placeholder="Municipio de la Escuela">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Localidad de la Escuela</label>
                                    <input type="text" class="form-control" id="localidad_Certificates"
                                        placeholder="Localidad de la Escuela">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Numero de Folio</label>
                                    <input type="text" class="form-control" id="numero_folio_Certificates"
                                        placeholder="Numero de Folio">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Numero de Certificado</label>
                                    <input type="text" class="form-control" id="numero_certificado_Certificates"
                                        placeholder="Numero de Certificado">
                                </div>
                            </div>

                            <div class="row" style="text-align: center;">

                                <div class="form-group col-md-4"></div>
                                <div class="form-group col-md-4">
                                    <br>
                                    <button type="submit" class="btn btn-primary" id="save_data_cert">
                                        <span class="material-icons">save</span>Guardar Información
                                    </button>
                                </div>
                                <div class="form-group col-md-4"></div>
                            </div>
                            <br>
                            <div id="resultado"></div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <div class="modal fade qrcode" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="qrName"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="resp_qr">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--div class="col-lg-5 col-md-12">
         <div class="card" style="min-height:485">
            <div class="card-header card-header-text">
               <h4 class="card-title">activities</h4>
            </div>

            <div class="card-content">
               <div class="steamline">
                  <div class="sl-item sl-primary">
                     <div class="sl-content">
                        <small class="text-muted">5 min Ago</small>
                        <p>Willims has just Joined Projectx</p>
                     </div>
                  </div>


                  <div class="sl-item sl-danger">
                     <div class="sl-content">
                        <small class="text-muted">25 min Ago</small>
                        <p>Willims has just Joined Projectx</p>
                     </div>
                  </div>

                  <div class="sl-item sl-success">
                     <div class="sl-content">
                        <small class="text-muted">40 min Ago</small>
                        <p>Willims has just team Joined Projectx</p>
                     </div>
                  </div>

                  <div class="sl-item">
                     <div class="sl-content">
                        <small class="text-muted">45 min Ago</small>
                        <p>Willims has just team Joined Projectx</p>
                     </div>
                  </div>

                  <div class="sl-item  sl-warning">
                     <div class="sl-content">
                        <small class="text-muted">55 min Ago</small>
                        <p>Willims JIm shared a folder with You</p>
                     </div>
                  </div>

                  <div class="sl-item">
                     <div class="sl-content">
                        <small class="text-muted">60 min Ago</small>
                        <p>Willims has just team Joined Projectx</p>
                     </div>
                  </div>

               </div>
            </div>
         </div>
      </div-->
</div>
<script src="js/alumnos.js?v=<?php echo time();?>"></script>