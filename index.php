<?php
    // Incluye archivos de configuración y funciones auxiliares
    require_once "Config/Config.php";
    require_once "Config/Helpers.php";

    // Obtiene la URL solicitada o asigna una URL por defecto
    $ruta = !empty($_GET['url']) ? $_GET['url'] : "Home/index";

    // Divide la URL en partes usando el carácter "/"
    $array = explode("/", $ruta);

    // Define el controlador por defecto
    $controller = $array[0];
    $metodo = "index"; // Método por defecto
    $parametro = "";   // Parámetro vacío por defecto

    // Verifica si existe un método en la URL
    if (!empty($array[1])) {
        if (!empty($array[1] != "")) {
            $metodo = $array[1];
        }
    }

    // Verifica si existen parámetros adicionales en la URL
    if (!empty($array[2])) {
        if (!empty($array[2] != "")) {
            for ($i=2; $i < count($array); $i++) { 
                $parametro .= $array[$i]. ",";
            }
            // Elimina la última coma del string de parámetros
            $parametro = trim($parametro, ",");
        }
    }

    // Carga automáticamente las clases requeridas
    require_once "Config/App/Autoload.php";

    // Define la ruta al controlador
    $dirControllers = "Controllers/".$controller.".php";

    // Verifica si el archivo del controlador existe
    if (file_exists($dirControllers)) {
        require_once $dirControllers; // Carga el controlador
        $controller = new $controller(); // Instancia el controlador

        // Verifica si el método existe dentro del controlador
        if (method_exists($controller, $metodo)) {
            $controller->$metodo($parametro); // Ejecuta el método con parámetros
        } else {
            // Redirige a la página de error si el método no existe
            header('Location:' . base_url . 'Configuracion/Error');
        }
    } else {
        // Redirige a la página de error si el controlador no existe
        header('Location:' . base_url . 'Configuracion/Error');
    }

?>
