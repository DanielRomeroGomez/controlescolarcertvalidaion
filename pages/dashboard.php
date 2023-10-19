<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header">
                <div class="icon icon-rose">
                    <span class="material-icons">perm_identity</span>
                </div>
            </div>
            <div class="card-content">
                <p class="category"><strong>Total</strong></p>
                <h3 class="card-title" id="totalAlumnos"></h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons text-info">info</i> Número de alumnos <b>cargados</b> en sistema.
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header">
                <div class="icon icon-success">
                    <span class="material-icons">perm_identity</span>

                </div>
            </div>
            <div class="card-content">
                <p class="category"><strong>Activos</strong></p>
                <h3 class="card-title" id="alumnosActivos"></h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                <i class="material-icons text-info">info</i> Número de alumnos <b>activos</b> en sistema.
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header">
                <div class="icon icon-info">
                    <span class="material-icons">perm_identity</span>
                </div>
            </div>
            <div class="card-content">
                <p class="category"><strong>Con Certificados</strong></p>
                <h3 class="card-title" id="alumnosCertificado"></h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                <i class="material-icons text-info">info</i> Número de alumnos <b>con Certificados</b> en sistema.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-7 col-md-12">
        <div class="card" style="min-height:485px">
            <div class="card-header card-header-text">
                <h4 class="card-title">Últimos Alumnos Registrados</h4>
                <!--p class="category">New employees on 15th December, 2016</p-->
            </div>
            <div class="card-content table-responsive" id="ultimosAlumnos">
                
            </div>
        </div>
        <div>
        </div>

    </div>

    <div class="col-lg-5 col-md-12">
        <div class="card" style="min-height:485">
            <div class="card-header card-header-text">
                <h4 class="card-title">Últimas Actividades</h4>
            </div>

            <div class="card-content" >
                <div class="steamline" id="actividades">
                </div>    
            </div>
        </div>
    </div>
</div>

<script src="js/dashboard.js?v=<?php echo time();?>"></script>