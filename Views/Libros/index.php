<?php include "Views/Templates/header.php"; ?>

<!-- Contenedor superior: Cabecera del módulo con botón para nuevo libro -->
<div class="row">
    <div class="col-md-12">
        <div class="tile" style="border-radius: 5px; padding: 10px;">
            <div class="tile-body">
                <div class="row invoice-info d-flex">

                    <!-- Contenedor de botones adicionales -->
                    <div class="col-8 text-left input-group" id="botonesContainer">
                    </div>

                    <!-- Sección para registrar un nuevo libro -->
                    <div class="col-4 text-right d-flex">
                        <h5 class="title_max-width992">
                            <i class="fa fa-list"></i>&nbsp;Lista de Libros/
                        </h5>
                        <button class="btn btn-primary btn-sm ml-auto" onclick="frmLibros()">
                            <i class="fa fa-plus-circle" aria-hidden="true" style="color: white;"></i>&nbsp;Nuevo
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla para visualizar la lista de libros -->
<div class="row">
    <div class="col-lg-12">
        <div class="tile clase_header" style="border-radius: 5px; padding: 10px;">
            <h5 class="title_max-width767 text-center">
                <i class="fa fa-list"></i>&nbsp;Lista de Libros
            </h5>
            <div class="tile-body">
                <table class="display responsive nowrap table table-sm" id="tblLibros" style="width: 100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>N°</th>
                            <th>Titulo</th>
                            <th>Cant</th>
                            <th>Autor</th>
                            <th>Editorial</th>
                            <th>Materia</th>
                            <th>Foto</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th></th> <!-- Columna para acciones -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los datos se insertan dinámicamente desde JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para registrar o editar un libro -->
<div id="nuevoLibro" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <!-- Cabecera del modal -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="title">Registro Libro</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Formulario del modal -->
            <div class="modal-body">
                <form id="frmLibro" class="row" onsubmit="registrarLibro(event)">

                    <!-- Campo: Título del libro -->
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="hidden" id="id" name="id">
                            <input id="titulo" class="form-control" type="text" name="titulo" placeholder="Título del libro" required>
                        </div>
                    </div>

                    <!-- Campo: Autor del libro -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="autor">Autor</label><br>
                            <select id="autor" class="form-control autor" name="autor" required style="width: 100%;">
                                <!-- Opciones cargadas dinámicamente -->
                            </select>
                        </div>
                    </div>

                    <!-- Campo: Editorial del libro -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="editorial">Editorial</label><br>
                            <select id="editorial" class="form-control editorial" name="editorial" required style="width: 100%;">
                                <!-- Opciones cargadas dinámicamente -->
                            </select>
                        </div>
                    </div>

                    <!-- Campo: Materia -->
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="materia">Materia</label><br>
                            <select id="materia" class="form-control materia" name="materia" required style="width: 100%;">
                                <!-- Opciones cargadas dinámicamente -->
                            </select>
                        </div>
                    </div>

                    <!-- Campo: Cantidad de libros disponibles -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input id="cantidad" class="form-control" type="text" name="cantidad" placeholder="Cantidad" required>
                        </div>
                    </div>

                    <!-- Campo: Número de páginas -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="num_pagina">Cantidad de página</label>
                            <input id="num_pagina" class="form-control" type="number" name="num_pagina" placeholder="Cantidad Página" required>
                        </div>
                    </div>

                    <!-- Campo: Año de edición -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="anio_edicion">Año Edición</label>
                            <input id="anio_edicion" class="form-control" type="date" name="anio_edicion" value="<?php echo date("Y-m-d"); ?>" required>
                        </div>
                    </div>

                    <!-- Campo: Descripción del libro -->
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" class="form-control" name="descripcion" rows="2" placeholder="Descripción"></textarea>
                        </div>
                    </div>

                    <!-- Campo: Imagen (foto de portada del libro) -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Logo</label>
                            <div class="card border-primary">
                                <div class="card-body">
                                    <input type="hidden" id="foto_actual" name="foto_actual">
                                    <label for="imagen" id="icon-image" class="btn btn-primary">
                                        <i class="fa fa-cloud-upload"></i>
                                    </label>
                                    <span id="icon-cerrar"></span>
                                    <input id="imagen" class="d-none" type="file" name="imagen" onchange="preview(event)">
                                    <img class="img-thumbnail" id="img-preview" src="" width="150">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones: Registrar y Cancelar -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" id="btnAccion">Registrar</button>
                            <button class="btn btn-danger" data-dismiss="modal" type="button">Cancelar</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>
