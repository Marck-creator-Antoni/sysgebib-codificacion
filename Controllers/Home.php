<?php
// Se define la clase Home que extiende de la clase base Controller, aplicando el patrón MVC.
class Home extends Controller
{
    // Constructor de la clase Home
    public function __construct() {
        // Se inicia la sesión para trabajar con variables de sesión
        session_start();

        // Verifica si existe una sesión activa (es decir, si el usuario ya está autenticado)
        // En caso afirmativo, redirige automáticamente al controlador Usuarios
        if (!empty($_SESSION['activo'])) {
            header("location: " . base_url . "Usuarios");
        }

        // Llama al constructor de la clase padre (Controller)
        parent::__construct();
    }

    // Método index, se ejecuta por defecto al acceder al controlador Home
    public function index()
    {
        // Carga la vista "index" asociada a este controlador mediante el método getView
        $this->views->getView($this, "index");
    }
}
