<?php include "Views/Templates/header.php"; ?>
// Versión actualizada con filtrado por fechas


<!-- Contenedor superior con título y botón "Nuevo" -->
<div class="row">
    <div class="col-md-12">
        <div class="tile" style="border-radius: 5px;padding: 10px;">
            <div class="tile-body">
                <div class="row invoice-info d-flex">
                    <!-- Contenedor vacío donde se pueden insertar botones adicionales mediante JS -->
                    <div class="col-8 text-left input-group" id="botonesContainer">
                    </div>

                    <!-- Título y botón para abrir el formulario de registro -->
                    <div class="col-4 text-right d-flex">
                        <h5 class="title_max-width992">
                            <i class="fa fa-list"></i>&nbsp;Lista de Editorial/
                        </h5>
                        <button class="btn btn-primary btn-sm ml-auto" onclick="frmEditorial()">
                            <i class="fa fa-plus-circle" aria-hidden="true" style="color: white;"></i>&nbsp;Nuevo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de listado de editoriales -->
<div class="row">
    <div class="col-lg-12">
        <div class="tile clase_header" style="border-radius: 5px;padding: 10px;">
            <h5 class="title_max-width767 text-center">
                <i class="fa fa-list"></i>&nbsp;Lista de Editorial
            </h5>
            <div class="tile-body">
                <table class="display responsive nowrap table table-sm" id="tblEditorial" style="width: 100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>N°</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th></th> <!-- Columna para acciones (editar/eliminar) -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los datos serán cargados dinámicamente vía JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para registrar o editar una editorial -->
<div id="nuevoEditorial" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Cabecera del modal -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="title">Registro Editorial</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Cuerpo del modal con formulario -->
            <div class="modal-body">
                <form id="frmEditorial">
                    <div class="row">
                        <!-- Campo para el nombre de la editorial -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="editorial">Nombre</label>
                                <input type="hidden" id="id" name="id"> <!-- Campo oculto para el ID (en caso de edición) -->
                                <input id="editorial" class="form-control" type="text" name="editorial" required placeholder="Nombre de Editorial">
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" onclick="registrarEditorial(event)" id="btnAccion">Registrar</button>
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
