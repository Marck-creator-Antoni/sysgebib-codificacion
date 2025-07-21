<?php include "Views/Templates/header.php"; ?>

<!-- Contenedor principal de la interfaz -->
<div class="row">
    <div class="col-md-12">
        <div class="tile" style="border-radius: 5px;padding: 10px;">
            <div class="tile-body">
                <div class="row invoice-info d-flex">
                    <!-- Contenedor para botones adicionales (actualmente vacío) -->
                    <div class="col-8 text-left input-group" id="botonesContainer">
                    </div>

                    <!-- Encabezado y botón para nuevo registro de materia -->
                    <div class="col-4 text-right d-flex">
                        <h5 class="title_max-width992 ">
                            <i class="fa fa-list"></i>&nbsp;Lista de Materias/
                        </h5>
                        <button class="btn btn-primary btn-sm ml-auto" onclick="frmMateria()">
                            <i class="fa fa-plus-circle" aria-hidden="true" style="color: white;"></i>&nbsp;Nuevo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla que muestra la lista de materias registradas -->
<div class="row">
    <div class="col-lg-12">
        <div class="tile clase_header" style="border-radius: 5px;padding: 10px;">
            <h5 class="title_max-width767 text-center">
                <i class="fa fa-list"></i>&nbsp;Lista de Materias
            </h5>
            <div class="tile-body">
                <!-- Tabla responsive que será llenada dinámicamente por JavaScript -->
                <table class="display responsive nowrap table table-sm" id="tblMateria" style="width: 100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>N°</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th class="text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- El contenido será generado dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para registrar o editar una materia -->
<div id="nuevoMateria" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Encabezado del modal -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="title">Registro Materia</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Cuerpo del modal con el formulario -->
            <div class="modal-body">
                <form id="frmMateria">
                    <div class="row">
                        <!-- Campo de nombre de materia -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="materia">Nombre</label>
                                <!-- Campo oculto para el ID (útil al editar) -->
                                <input type="hidden" id="id" name="id">
                                <input id="materia" class="form-control" type="text" name="materia" required placeholder="Nombre de Materia">
                            </div>
                        </div>

                        <!-- Botones para registrar o cerrar el formulario -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" onclick="registrarMateria(event)" id="btnAccion">Registrar</button>
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
