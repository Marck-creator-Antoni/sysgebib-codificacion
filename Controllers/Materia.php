<?php
/**
 * Controlador Materia
 * Gestiona las operaciones CRUD para materias académicas: registro, edición, eliminación, activación y búsqueda.
 */
class Materia extends Controller
{
    /**
     * Constructor: valida la sesión activa y ejecuta el constructor del padre.
     */
    public function __construct()
    {
        session_start(); // Inicia sesión
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url); // Redirige si no hay sesión iniciada
        }
        parent::__construct(); // Llama al constructor del controlador padre
    }

    /**
     * Carga la vista principal del módulo de materias
     */
    public function index()
    {
        $this->views->getView($this, "index");
    }

    /**
     * Obtiene y lista todas las materias registradas
     * Formatea la salida y acciones dependiendo del estado (activo o inactivo)
     */
    public function listar()
    {
        $data = $this->model->getMaterias(); // Consulta materias en el modelo

        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                // Si la materia está activa
                $data[$i]['estado'] = '<span class="badge badge-primary">Activo</span>';
                $data[$i]['acciones'] = '<div>
                    <button class="btn btn-primary btn-sm " type="button" onclick="btnEditarMat(' . $data[$i]['id'] . ');"><i class="fa fa-pencil-square-o"></i></button>
                    <button class="btn btn-danger btn-sm" type="button" onclick="btnEliminarMat(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>
                <div/>';
            } else {
                // Si la materia está inactiva
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                    <button class="btn btn-success btn-sm" type="button" onclick="btnReingresarMat(' . $data[$i]['id'] . ');"><i class="fa fa-reply-all"></i></button>
                <div/>';
            }
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE); // Retorna la respuesta como JSON
        die();
    }

    /**
     * Registra o actualiza una materia según si viene o no con ID
     */
    public function registrar()
    {
        // Limpieza de datos recibidos desde el formulario
        $materia = strClean($_POST['materia']);
        $id = strClean($_POST['id']);

        // Validación de campo obligatorio
        if (empty($materia)) {
            $msg = array('msg' => 'El nombre es requerido', 'icono' => 'warning');
        } else {
            if ($id == "") {
                // Registrar nueva materia
                $data = $this->model->insertarMateria($materia);
                if ($data == "ok") {
                    $msg = array('msg' => 'Materia registrado', 'icono' => 'success');
                } elseif ($data == "existe") {
                    $msg = array('msg' => 'La materia ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                // Actualizar materia existente
                $data = $this->model->actualizarMateria($materia, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Materia modificado', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                }
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE); // Respuesta en formato JSON
        die();
    }

    /**
     * Devuelve los datos de una materia específica para edición
     * @param int $id ID de la materia a editar
     */
    public function editar($id)
    {
        $data = $this->model->editMateria($id); // Obtiene los datos de la materia
        echo json_encode($data, JSON_UNESCAPED_UNICODE); // Devuelve la respuesta
        die();
    }

    /**
     * Cambia el estado de una materia a inactiva (eliminación lógica)
     * @param int $id ID de la materia a eliminar
     */
    public function eliminar($id)
    {
        $data = $this->model->estadoMateria(0, $id); // Cambia estado a inactivo
        if ($data == 1) {
            $msg = array('msg' => 'Materia dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    /**
     * Restaura una materia inactiva
     * @param int $id ID de la materia a reactivar
     */
    public function reingresar($id)
    {
        $data = $this->model->estadoMateria(1, $id); // Cambia estado a activo
        if ($data == 1) {
            $msg = array('msg' => 'Materia restaurado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    /**
     * Busca materias que coincidan con una cadena ingresada por el usuario
     * Utilizado normalmente para autocompletado o filtros dinámicos
     */
    public function buscarMateria()
    {
        if (isset($_GET['q'])) {
            $valor = $_GET['q']; // Obtiene valor de búsqueda
            $data = $this->model->buscarMateria($valor); // Busca materias por nombre
            echo json_encode($data, JSON_UNESCAPED_UNICODE); // Devuelve resultado
            die();
        }
    }
}
