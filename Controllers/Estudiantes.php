<?php
// Controlador Estudiantes - maneja las operaciones CRUD sobre estudiantes
class Estudiantes extends Controller
{
    // Constructor: protege el acceso y llama al constructor padre
    public function __construct()
    {
        session_start(); // Inicia la sesión
        if (empty($_SESSION['activo'])) {
            // Si no hay sesión activa, redirecciona a la base
            header("location: " . base_url);
        }
        parent::__construct(); // Llama al constructor del Controller base
    }

    // Método principal: carga la vista del módulo
    public function index()
    {
        $this->views->getView($this, "index");
    }

    // Método para listar todos los estudiantes
    public function listar()
    {
        $data = $this->model->getEstudiantes(); // Obtiene los datos desde el modelo
        for ($i = 0; $i < count($data); $i++) {
            // Verifica el estado del estudiante y define las acciones disponibles
            if ($data[$i]['estado'] == 1) {
                // Si está activo, muestra botones para editar y eliminar
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                    <button class="btn btn-primary btn-sm" type="button" onclick="btnEditarEst(' . $data[$i]['id'] . ');"><i class="fa fa-pencil-square-o"></i></button>
                    <button class="btn btn-danger btn-sm" type="button" onclick="btnEliminarEst(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>
                    <div/>';
            } else {
                // Si está inactivo, muestra botón para reingresar
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                    <button class="btn btn-success btn-sm" type="button" onclick="btnReingresarEst(' . $data[$i]['id'] . ');"><i class="fa fa-reply-all"></i></button>
                    <div/>';
            }
        }
        // Devuelve el arreglo en formato JSON para ser procesado por el frontend
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método para registrar o actualizar un estudiante
    public function registrar()
    {
        // Limpieza de entradas del formulario
        $codigo = strClean($_POST['codigo']);
        $dni = strClean($_POST['dni']);
        $nombre = strClean($_POST['nombre']);
        $carrera = strClean($_POST['carrera']);
        $direccion = strClean($_POST['direccion']);
        $telefono = strClean($_POST['telefono']);
        $id = strClean($_POST['id']);

        // Validación de campos obligatorios
        if (empty($codigo) || empty($dni) || empty($nombre) || empty($carrera)) {
            $msg = array('msg' => 'Todo los campos son requeridos', 'icono' => 'warning');
        } else {
            // Si es nuevo registro
            if ($id == "") {
                $data = $this->model->insertarEstudiante($codigo, $dni, $nombre, $carrera, $direccion, $telefono);
                if ($data == "ok") {
                    $msg = array('msg' => 'Estudiante registrado', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El estudiante ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                // Si se está actualizando
                $data = $this->model->actualizarEstudiante($codigo, $dni, $nombre, $carrera, $direccion, $telefono, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Estudiante modificado', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                }
            }
        }
        // Se devuelve el mensaje como JSON al frontend
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método para obtener los datos de un estudiante específico (por ID)
    public function editar($id)
    {
        $data = $this->model->editEstudiante($id); // Llama al modelo para obtener datos del estudiante
        echo json_encode($data, JSON_UNESCAPED_UNICODE); // Devuelve datos en formato JSON
        die();
    }

    // Método para desactivar un estudiante (cambia estado a inactivo)
    public function eliminar($id)
    {
        $data = $this->model->estadoEstudiante(0, $id); // Cambia el estado a 0 (inactivo)
        if ($data == 1) {
            $msg = array('msg' => 'Estudiante dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método para reactivar un estudiante (cambia estado a activo)
    public function reingresar($id)
    {
        $data = $this->model->estadoEstudiante(1, $id); // Cambia el estado a 1 (activo)
        if ($data == 1) {
            $msg = array('msg' => 'Estudiante restaurado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método para búsqueda dinámica de estudiantes desde el frontend (input autocomplete)
    public function buscarEstudiante()
    {
        if (isset($_GET['est'])) {
            $valor = $_GET['est']; // Valor que llega por la URL (AJAX)
            $data = $this->model->buscarEstudiante($valor); // Llama al modelo para buscar coincidencias
            echo json_encode($data, JSON_UNESCAPED_UNICODE); // Retorna resultados al frontend
            die();
        }
    }
}
