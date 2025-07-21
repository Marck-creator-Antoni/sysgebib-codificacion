<?php
// Controlador para la gestión de Editoriales
class Editorial extends Controller
{
    // Constructor: inicia sesión y verifica autenticación
    public function __construct()
    {
        session_start(); // Inicia la sesión
        if (empty($_SESSION['activo'])) {
            // Si no hay sesión activa, redirige al login
            header("location: " . base_url);
        }
        parent::__construct(); // Llama al constructor del controlador base
    }

    // Carga la vista principal del módulo
    public function index()
    {
        $this->views->getView($this, "index");
    }

    // Método para listar todas las editoriales registradas
    public function listar()
    {
        $data = $this->model->getEditorial(); // Obtiene los datos desde el modelo

        // Recorre cada registro para formatear estado y acciones
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                // Si está activa, muestra estado y botones para editar/eliminar
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                    <button class="btn btn-primary btn-sm" type="button" onclick="btnEditarEdi(' . $data[$i]['id'] . ');"><i class="fa fa-pencil-square-o"></i></button>
                    <button class="btn btn-danger btn-sm" type="button" onclick="btnEliminarEdi(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>
                <div/>';
            } else {
                // Si está inactiva, muestra estado y botón para reingresar
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                    <button class="btn btn-success btn-sm" type="button" onclick="btnReingresarEdi(' . $data[$i]['id'] . ');"><i class="fa fa-reply-all"></i></button>
                <div/>';
            }
        }

        // Devuelve el arreglo en formato JSON para el frontend
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método para registrar o actualizar una editorial
    public function registrar()
    {
        // Sanitiza los valores recibidos por POST
        $editorial = strClean($_POST['editorial']);
        $id = strClean($_POST['id']);

        // Validación del campo requerido
        if (empty($editorial)) {
            $msg = array('msg' => 'El nombre es requerido', 'icono' => 'warning');
        } else {
            if ($id == "") {
                // Registro nuevo
                $data = $this->model->insertarEditorial($editorial);
                if ($data == "ok") {
                    $msg = array('msg' => 'Editorial registrado', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El editorial ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                // Actualización de editorial existente
                $data = $this->model->actualizarEditorial($editorial, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Editorial modificado', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                }
            }
        }

        // Devuelve mensaje JSON al cliente
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método para obtener datos de una editorial por ID (para edición)
    public function editar($id)
    {
        $data = $this->model->editEditorial($id); // Obtiene la editorial por su ID
        echo json_encode($data, JSON_UNESCAPED_UNICODE); // Devuelve en JSON
        die();
    }

    // Método para desactivar una editorial (baja lógica)
    public function eliminar($id)
    {
        $data = $this->model->estadoEditorial(0, $id); // Cambia el estado a inactivo (0)
        if ($data == 1) {
            $msg = array('msg' => 'Editorial dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método para reactivar una editorial
    public function reingresar($id)
    {
        $data = $this->model->estadoEditorial(1, $id); // Cambia el estado a activo (1)
        if ($data == 1) {
            $msg = array('msg' => 'Editorial restaurado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método para buscar editoriales por texto (autocomplete o buscador)
    public function buscarEditorial()
    {
        if (isset($_GET['q'])) {
            $valor = $_GET['q']; // Obtiene valor de búsqueda
            $data = $this->model->buscarEditorial($valor); // Consulta al modelo
            echo json_encode($data, JSON_UNESCAPED_UNICODE); // Devuelve resultados
            die();
        }
    }
}
