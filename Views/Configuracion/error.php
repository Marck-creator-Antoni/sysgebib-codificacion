<?php 
// Incluye el archivo de cabecera que contiene elementos comunes como el menú y la configuración inicial del HTML
include "Views/Templates/header.php"; 
?>

<div class="row"> <!-- Fila de Bootstrap para la distribución en columnas -->
    <div class="col-md-12"> <!-- Columna que ocupa todo el ancho en pantallas medianas hacia arriba -->

        <!-- Componente visual que muestra el error 404 con estilo tile -->
        <div class="page-error tile">
            <!-- Título del mensaje de error con un ícono de Bootstrap -->
            <h1 class="text-danger"><i class="bi bi-exclamation-circle"></i> Error 404: Page not found</h1>

            <!-- Descripción breve del error -->
            <p>The page you have requested is not found.</p>

            <!-- Botón que permite volver a la página de configuración del administrador -->
            <p>
                <a class="btn btn-primary" href="<?php echo base_url; ?>Configuracion/admin">Go Back</a>
            </p>
        </div>

    </div>
</div>

<?php 
// Incluye el archivo de pie de página que cierra etiquetas abiertas y puede contener scripts comunes
include "Views/Templates/footer.php"; 
?>
