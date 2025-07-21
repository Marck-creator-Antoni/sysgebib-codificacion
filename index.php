<?php
    // Carga los archivos de configuración y funciones auxiliares
    require_once "Config/Config.php";
    require_once "Config/Helpers.php";

    // Obtiene la URL desde el parámetro 'url'; si no existe, asigna 'Home/index' como predeterminado
    $ruta = !empty($_GET['url']) ? $_GET['url'] : "Home/index";

    // Separa la URL en partes mediante '/'
    $array = explode("/", $ruta);

    // Define el nombre del controlador desde el primer segmento
    $controller = $array[0];
    $metodo = "index";     // Método por defecto
    $parametro = "";       // Parámetro inicial vacío

    // Si se especifica un segundo segmento en la URL, se considera como método
    if (!empty($array[1])) {
        if (!empty($array[1] != "")) {
            $metodo = $array[1];
        }
    }

    // Si hay más segmentos en la URL, se concatenan como parámetros separados por coma
    if (!empty($array[2])) {
        if (!empty($array[2] != "")) {
            for ($i = 2; $i < count($array); $i++) {
                $parametro .= $array[$i] . ",";
            }
            // Elimina la coma final del string de parámetros
            $parametro = trim($parametro, ",");
        }
    }

    // Carga automática de clases necesarias para el framework
    require_once "Config/App/Autoload.php";

    // Define la ruta completa hacia el archivo del controlador
    $dirControllers = "Controllers/" . $controller . ".php";

    // Verifica que el archivo del controlador exista
    if (file_exists($dirControllers)) {
        require_once $dirControllers;      // Carga el archivo del controlador
        $controller = new $controller();   // Instancia el controlador

        // Verifica que el método solicitado exista dentro del controlador
        if (method_exists($controller, $metodo)) {
            $controller->$metodo($parametro); // Ejecuta el método con parámetros (si los hay)
        } else {
            // Redirige a una vista de error si el método no existe
            header('Location:' . base_url . 'Configuracion/Error');
        }
    } else {
        // Redirige a una vista de error si el controlador no existe
        header('Location:' . base_url . 'Configuracion/Error');
    }
?>
