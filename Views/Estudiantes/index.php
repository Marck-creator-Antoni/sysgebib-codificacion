<?php include "Views/Templates/header.php"; ?>

<!-- Encabezado y botón para registrar nuevo estudiante -->
<div class="row">
    <div class="col-md-12">
        <div class="tile" style="border-radius: 5px; padding: 10px;">
            <div class="tile-body">
                <div class="row align-items-center flex-wrap">

                    <!-- Botones de exportación -->
                    <div class="col-12 col-md-4 d-flex flex-wrap justify-content-start mb-2" id="botonesContainer">
                        <!-- DataTables inyectará aquí -->
                    </div>

                    <!-- Filtros de fecha -->
                    <div class="col-12 col-md-4 d-flex flex-wrap justify-content-center mb-2">
                        <div class="form-group mb-0 mr-2">
                            <label for="fechaInicio" class="mb-0 small">Desde:</label>
                            <input type="date" id="fechaInicio" class="form-control form-control-sm">
                        </div>
                        <div class="form-group mb-0 mr-2">
                            <label for="fechaFin" class="mb-0 small">Hasta:</label>
                            <input type="date" id="fechaFin" class="form-control form-control-sm">
                        </div>
                        <div class="form-group mb-0 mr-2 d-flex align-items-end">
                            <button id="btnFiltrarFechas" class="btn btn-sm btn-primary" title="Filtrar">
                                <i class="fa fa-filter"></i>
                            </button>
                        </div>
                        <div class="form-group mb-0 d-flex align-items-end">
                            <button id="btnLimpiarFechas" class="btn btn-sm btn-secondary" title="Limpiar filtro">
                                <i class="fa fa-refresh"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Título y botón "Nuevo" -->
                    <div class="col-12 col-md-4 d-flex justify-content-end align-items-center mb-2">
                        <h5 class="mb-0 mr-2">
                            <i class="fa fa-list"></i>&nbsp;Lista de Estudiantes/
                        </h5>
                        <button class="btn btn-primary btn-sm" onclick="frmEstudiante()">
                            <i class="fa fa-plus-circle" style="color: white;"></i>&nbsp;Nuevo
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- Tabla de estudiantes -->
<div class="row">
    <div class="col-lg-12">
        <div class="tile clase_header" style="border-radius: 5px;padding: 10px;">
            <h5 class="title_max-width767 text-center">
                <i class="fa fa-list"></i>&nbsp;Lista de Estudiantes
            </h5>
            <div class="tile-body">
                <table class="display responsive nowrap table table-sm" id="tblEst" style="width: 100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>N°</th>
                            <th>Código</th>
                            <th>Dni</th>
                            <th>Nombres</th>
                            <th>Ciclo</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Acción</th> <!-- Acciones como editar o eliminar -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí se insertarán dinámicamente los datos desde JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Registro o edición de estudiante -->
<div id="nuevoEstudiante" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
            <!-- Encabezado del modal -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="title">Registro Estudiante</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Cuerpo del modal con formulario -->
            <div class="modal-body">
                <form id="frmEstudiante">
                    <div class="row">
                        
                        <!-- Campo: Código del estudiante -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="codigo">Código</label>
                                <input type="hidden" id="id" name="id"> <!-- Campo oculto para edición -->
                                <input id="codigo" class="form-control" type="text" name="codigo" required placeholder="Codigo del estudiante">
                            </div>
                        </div>

                        <!-- Campo: DNI del estudiante -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dni">Dni</label>
                                <input id="dni" class="form-control" type="text" name="dni" required placeholder="Dni">
                            </div>
                        </div>

                        <!-- Campo: Nombre completo -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input id="nombre" class="form-control" type="text" name="nombre" required placeholder="Nombre completo">
                            </div>
                        </div>

                        <!-- Campo: Ciclo del estudiante -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="carrera">Ciclo</label>
                                <input id="carrera" class="form-control" type="text" name="carrera" required placeholder="Ciclo">
                            </div>
                        </div>

                        <!-- Campo: Teléfono -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="telefono">Télefono</label>
                                <input id="telefono" class="form-control" type="text" name="telefono" required placeholder="Teléfono">
                            </div>
                        </div>

                        <!-- Campo: Dirección -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <input id="direccion" class="form-control" type="text" name="direccion" required placeholder="Dirección">
                            </div>
                        </div>

                        <!-- Botones: Registrar y Atrás -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" onclick="registrarEstudiante(event)" id="btnAccion">Registrar</button>
                                <button class="btn btn-danger" type="button" data-dismiss="modal">Atras</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>
