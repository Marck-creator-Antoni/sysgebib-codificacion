<?php include "Views/Templates/header.php"; ?>

<!-- Encabezado y botón para registrar nuevo préstamo -->
<div class="row">
    <div class="col-md-12">
        <div class="tile" style="border-radius: 5px;padding: 10px;">
            <div class="tile-body">
                <div class="row invoice-info d-flex">
                    <!-- Contenedor opcional para botones -->
                    <div class="col-8 text-left input-group" id="botonesContainer">
                    </div>

                    <!-- Título y botón para abrir formulario de préstamo -->
                    <div class="col-4 text-right d-flex">
                        <h5 class="title_max-width992 ">
                            <i class="fa fa-list"></i>&nbsp;Lista de Préstamos/
                        </h5>
                        <button class="btn btn-primary btn-sm ml-auto" onclick="frmPrestar()">
                            <i class="fa fa-plus-circle" aria-hidden="true" style="color: white;"></i>&nbsp;Nuevo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla con la lista de préstamos existentes -->
<div class="row">
    <div class="col-md-12">
        <div class="tile clase_header" style="border-radius: 5px;padding: 10px;">
            <h5 class="title_max-width767 text-center">
                <i class="fa fa-list"></i>&nbsp;Lista de Préstamos
            </h5>
            <div class="tile-body">
                <table class="display responsive nowrap table table-sm" id="tblPrestar" style="width: 100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>N°</th>
                            <th>Libro</th>
                            <th>Estudiante</th>
                            <th>Fecha Préstamo</th>
                            <th>Fecha Devolución</th>
                            <th>Cant(Uni.)</th>
                            <th>Observación</th>
                            <th>Estado</th>
                            <th></th> <!-- Acciones (editar, eliminar, devolver, etc.) -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Cuerpo dinámico llenado por JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para registrar préstamo de libro -->
<div id="prestar" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Cabecera del modal -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="title">Prestar Libro</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Formulario de préstamo -->
            <div class="modal-body">
                <form id="frmPrestar" onsubmit="registroPrestamos(event)">
                    <!-- Selección de libro -->
                    <div class="form-group">
                        <label for="libro">Libro</label><br>
                        <select id="libro" class="form-control libro" name="libro" onchange="verificarLibro()" required style="width: 100%;">
                        </select>
                    </div>

                    <!-- Selección de estudiante y cantidad -->
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="estudiante">Estudiante</label><br>
                                <select name="estudiante" id="estudiante" class="form-control estudiante" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cantidad">Cant</label>
                                <input id="cantidad" class="form-control" min="1" type="number" name="cantidad" required onkeyup="verificarLibro()">
                                <strong id="msg_error"></strong>
                            </div>
                        </div>

                        <!-- Fechas de préstamo y devolución -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_prestamo">Fecha de Prestamo</label>
                                <input id="fecha_prestamo" class="form-control" type="date" name="fecha_prestamo" value="<?php echo date("Y-m-d"); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_devolucion">Fecha de Devolución</label>
                                <input id="fecha_devolucion" class="form-control" type="date" name="fecha_devolucion" value="<?php echo date("Y-m-d"); ?>" required>
                            </div>
                        </div>
                    </div>

                    <!-- Observación opcional -->
                    <div class="form-group">
                        <label for="observacion">Observación</label>
                        <textarea id="observacion" class="form-control" placeholder="Observación" name="observacion" rows="3"></textarea>
                    </div>

                    <!-- Botones del formulario -->
                    <button class="btn btn-primary" type="submit" id="btnAccion">Prestar</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>

<!-- Paginación para la lista de préstamos -->
<nav aria-label="Navegación de páginas">
    <ul class="pagination justify-content-end pagination-sm" style="margin-bottom: 0px; margin-top: 0px;">
        <!-- Botón ir al inicio -->
        <li class="page-item">
            <a class="page-link" href="/domain/565ca56a12ad5b13bc71f8f7?p=1">
                <div class="valign-center">
                    <i class="material-icons" style="line-height:0.7;">fast_rewind</i>
                </div>
            </a>
        </li>

        <!-- Página anterior -->
        <li class="page-item">
            <a class="page-link" href="/domain/565ca56a12ad5b13bc71f8f7?p=1">
                <div class="valign-center ">
                    <i class="material-icons" style="line-height:0.7;">skip_previous</i>
                </div>
            </a>
        </li>

        <!-- Números de página -->
        <li class="page-item active">
            <a class="page-link" href="">1</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="/domain/565ca56a12ad5b13bc71f8f7?p=2">2</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="/domain/565ca56a12ad5b13bc71f8f7?p=3">3</a>
        </li>

        <!-- Página siguiente -->
        <li class="page-item">
            <a class="page-link" href="/domain/565ca56a12ad5b13bc71f8f7?p=2" aria-label="Próximo">
                <div class="valign-center ">
                    <i class="material-icons" style="line-height:0.7;">skip_next</i>
                </div>
            </a>
        </li>

        <!-- Ir al final -->
        <li class="page-item">
            <a class="page-link" href="/domain/565ca56a12ad5b13bc71f8f7?p=3" aria-label="Próximo">
                <div class="valign-center ">
                    <i class="material-icons" style="line-height:0.7;">fast_forward</i>
                </div>
            </a>
        </li>
    </ul>
</nav>
