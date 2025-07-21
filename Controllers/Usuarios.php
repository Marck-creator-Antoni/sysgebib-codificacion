<?php

/**
 * Controlador Usuarios
 * 
 * Gestiona la autenticación del sistema SysGebib.
 * Implementa el patrón MVC y gestiona las sesiones de usuario.
 */
class Usuarios extends Controller {

    /**
     * Constructor de la clase Usuarios.
     * Inicia la sesión y ejecuta el constructor padre.
     */
    public function __construct() {
        session_start(); // Inicia o reanuda la sesión del usuario
        parent::__construct(); // Llama al constructor de la clase Controller
    }

    /**
     * Método para validar las credenciales de acceso.
     * 
     * Recibe usuario y contraseña mediante POST,
     * verifica que los campos no estén vacíos,
     * encripta la contraseña y consulta en el modelo si el usuario existe.
     * Si es válido, almacena los datos en la sesión.
     * Devuelve respuesta JSON con el resultado.
     * 
     * @return void
     */
    public function validar()
    {
        // Sanitiza los datos ingresados por el usuario
        $usuario = strClean($_POST['usuario']);
        $clave = strClean($_POST['clave']);

        // Verifica que ambos campos hayan sido completados
        if (empty($usuario) || empty($clave)) {
            $msg = array('msg' => 'Todo los campos son requeridos', 'icono' => 'warning');
        } else {
            // Encripta la contraseña usando SHA-256
            $hash = hash("SHA256", $clave);

            // Consulta al modelo si existe un usuario con esas credenciales
            $data = $this->model->getUsuario($usuario, $hash);

            if ($data) {
                // Si el usuario es válido, guarda información clave en sesión
                $_SESSION['id_usuario'] = $data['id'];
                $_SESSION['usuario'] = $data['usuario'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['activo'] = true;

                $msg = array('msg' => 'Procesando', 'icono' => 'success');
            } else {
                // Si las credenciales no coinciden
                $msg = array('msg' => 'Usuario o contraseña incorrecta', 'icono' => 'warning');
            }
        }

        // Devuelve la respuesta al cliente en formato JSON
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die(); // Finaliza la ejecución del script
    }

    /**
     * Método para cerrar sesión.
     * 
     * Destruye la sesión del usuario y redirige a la página principal.
     * 
     * @return void
     */
    public function salir()
    {
        session_destroy(); // Elimina todos los datos de sesión
        header("location: " . base_url); // Redirecciona al inicio
    }
}
