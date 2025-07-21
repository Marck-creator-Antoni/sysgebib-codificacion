<?php include "Views/Templates/header.php"; ?> <!-- Inclusión del encabezado común -->

<!-- Contenedor principal de botones y título -->
<div class="row">
    <div class="col-md-12">
        <div class="tile" style="border-radius: 5px; padding: 10px;">
            <div class="tile-body">
                <div class="row invoice-info d-flex">

                    <!-- Contenedor de botones dinámicos (vacío por ahora) -->
                    <div class="col-8 text-left input-group" id="botonesContainer">
                    </div>

                    <!-- Título de sección y botón para agregar nuevo autor -->
                    <div class="col-4 text-right d-flex">
                        <h5 class="title_max-width992">
                            <i class="fa fa-list"></i>&nbsp;Lista de Autores/
                        </h5>
                        <button class="btn btn-primary btn-sm ml-auto" onclick="frmAutor()">
                            <i class="fa fa-plus-circle" aria-hidden="true" style="color: white;"></i>&nbsp;Nuevo
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla que lista los autores registrados -->
<div class="row">
    <div class="col-md-12">
        <div class="tile clase_header" style="border-radius: 5px; padding: 10px;">
            <h5 class="title_max-width767 text-center">
                <i class="fa fa-list"></i>&nbsp;Lista de Autores
            </h5>
            <div class="tile-body">

                <!-- Tabla responsive que se llenará dinámicamente vía JS -->
                <table class="display responsive nowrap table table-sm" id="tblAutor" style="width: 100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>N°</th>          <!-- Número de fila o identificador -->
                            <th>Foto</th>        <!-- Imagen del autor -->
                            <th>Nombre</th>      <!-- Nombre del autor -->
                            <th>Estado</th>      <!-- Estado activo/inactivo -->
                            <th></th>            <!-- Columna para acciones (editar, eliminar, etc.) -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody> <!-- El contenido se inyecta dinámicamente -->
                </table>

            </div>
        </div>
    </div>
</div>

<!-- Modal para registrar o editar autores -->
<div id="nuevoAutor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <!-- Encabezado del modal -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="title">Registro Autor</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span> <!-- Botón para cerrar el modal -->
                </button>
            </div>

            <!-- Cuerpo del modal con formulario -->
            <div class="modal-body">
                <!-- Formulario de autor, se ejecuta función JS al enviar -->
                <form id="frmAutor" onsubmit="registrarAutor(event)">
                    <div class="row">

                        <!-- Campo para ingresar el nombre del autor -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="autor">Nombre</label>
                                <input type="hidden" id="id" name="id"> <!-- ID oculto para edición -->
                                <input id="autor" class="form-control" type="text" name="autor" required placeholder="Nombre de Autor" required>
                            </div>
                        </div>

                        <!-- Campo para cargar la imagen del autor -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Logo</label>
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <input type="hidden" id="foto_actual" name="foto_actual"> <!-- Imagen actual en caso de edición -->
                                        
                                        <!-- Botón personalizado para subir imagen -->
                                        <label for="imagen" id="icon-image" class="btn btn-primary btn-sm">
                                            <i class="fa fa-cloud-upload"></i>
                                        </label>
                                        
                                        <span id="icon-cerrar"></span> <!-- Ícono para cerrar vista previa -->
                                        
                                        <!-- Campo oculto de carga de imagen -->
                                        <input id="imagen" class="d-none" type="file" name="imagen" onchange="preview(event)">
                                        
                                        <!-- Vista previa de la imagen -->
                                        <img class="img-thumbnail" id="img-preview" width="150">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción: registrar o cancelar -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" id="btnAccion">Registrar</button>
                                <button class="btn btn-danger" type="button" data-dismiss="modal">Atras</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?> <!-- Inclusión del pie de página común -->
