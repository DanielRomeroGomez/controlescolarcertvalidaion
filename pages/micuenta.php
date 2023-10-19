<div class="row">
    <div class="col-md-12">
        <div class="card" style="min-height:485px; padding: 30px;">

            <div class="card-header card-header-text">
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="card-title">Mi Cuenta</h4>
                        <!--p class="category"></p-->
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                </div>
                <hr>
            </div>
            <div class="card-content" id="formMiCuenta">

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Nombre</label>
                        <input type="text" class="form-control" id="name_user" placeholder="Nombre">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Apellidos</label>
                        <input type="text" class="form-control" id="last_name_user" placeholder="Apellidos">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Correo Electrónico</label>
                        <input type="text" class="form-control" id="email_user" placeholder="Correo Electrónico">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="usr_user" placeholder="Nombre de Usuario">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Contraseña</label>
                        <input type="text" class="form-control" id="psw_user" placeholder="Contraseña">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Teléfono</label>
                        <input type="txt" class="form-control" id="phone_user" placeholder="Teléfono">
                    </div>
                </div>
                <!--div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4"></label>
                        <input type="text" class="form-control" id="inputEmail4" placeholder="Email">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Password</label>
                        <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                    </div>
                </div-->
                <div class="row" style="text-align: center;">

                    <div class="form-group col-md-4"></div>
                    <div class="form-group col-md-4">
                        <br>
                        <button type="submit" class="btn btn-primary" id="save_data_user"><span class="material-icons">save</span>Guardar Información</button>
                    </div>
                    <div class="form-group col-md-4"></div>
                </div>

            </div>
        </div>
        <script src="js/micuenta.js?v=<?php echo time();?>"></script>