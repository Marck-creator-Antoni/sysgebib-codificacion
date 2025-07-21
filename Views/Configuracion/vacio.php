<?php include "Views/Templates/header.php"; ?> <!-- Inclusión del encabezado general de la plantilla -->

<div class="row">
    <div class="col-md-5 mx-auto"> <!-- Contenedor centrado con ancho de 5 columnas -->
        <div class="card"> <!-- Tarjeta de Bootstrap -->
            <div class="card-header text-center bg-primary"> <!-- Encabezado centrado con fondo azul -->
                <h4 class="text-white">No hay datos</h4> <!-- Título en color blanco -->
            </div>
            <div class="card-body"> <!-- Cuerpo de la tarjeta -->
                <a href="<?php echo base_url; ?>Configuracion/admin" class="btn btn-danger btn-block">Regresar</a> <!-- Botón para regresar a la configuración -->
            </div>
        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?> <!-- Inclusión del pie de página general de la plantilla -->
