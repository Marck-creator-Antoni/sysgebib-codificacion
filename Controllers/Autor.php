<?php
// Controlador para la gestión de autores en el sistema
class Autor extends Controller
{
    // Constructor: inicia sesión y verifica autenticación del usuario
    public function __construct()
    {
        session_start(); // Inicia sesión
        if (empty($_SESSION['activo'])) {
            // Si no hay sesión activa, redirige al inicio
            header("location: " . base_url);
        }
        parent::__construct(); // Llama al constructor de la clase padre (Controller)
    }

    // Muestra la vista principal del módulo de autores
    public function index()
    {
        $this->views->getView($this, "index");
    }
    
    // Obtiene la lista de autores y formatea los datos para la tabla dinámica
    public function listar()
    {
        $data = $this->model->getAutor(); // Llama al modelo para obtener autores

        // Itera sobre cada autor para dar formato a la imagen y los botones de acción
        for ($i = 0; $i < count($data); $i++) {
            // Muestra la imagen del autor
            $data[$i]['imagen'] = '<img class="img-thumbnail" src="' . base_url . "Assets/img/autor/" . $data[$i]['imagen'] . '" >';

            // Evalúa el estado del autor (activo/inactivo)
            if ($data[$i]['estado'] == 1) {
                // Activo
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                    <button class="btn btn-primary btn-sm" type="button" onclick="btnEditarAutor(' . $data[$i]['id'] . ');"><i class="fa fa-pencil-square-o"></i></button>
                    <button class="btn btn-danger btn-sm" type="button" onclick="btnEliminarAutor(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>
                <div/>';
            } else {
                // Inactivo
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                    <button class="btn btn-success btn-sm" type="button" onclick="btnReingresarAutor(' . $data[$i]['id'] . ');"><i class="fa fa-reply-all"></i></button>
                <div/>';
            }
        }

        // Retorna los datos formateados como JSON
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Registra o actualiza un autor (según si se recibe o no un ID)
    public function registrar()
    {
        // Limpieza y recepción de variables del formulario
        $autor = strClean($_POST['autor']);
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $id = strClean($_POST['id']);
        $fecha = date("YmdHis"); // Marca de tiempo para nombrar imagen
        $tmpName = $img['tmp_name'];

        // Validación: el campo nombre es obligatorio
        if (empty($autor)) {
            $msg = array('msg' => 'El nombre es requerido', 'icono' => 'warning');
        } else {
            // Procesamiento de imagen si se subió un archivo
            if (!empty($name)) {
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $formatos_permitidos =  array('png', 'jpeg', 'jpg');
                if (!in_array($extension, $formatos_permitidos)) {
                    $msg = array('msg' => 'Archivo no permitido', 'icono' => 'warning');
                } else {
                    // Se renombra el archivo con timestamp
                    $imgNombre = $fecha . ".jpg";
                    $destino = "Assets/img/autor/" . $imgNombre;
                }
            } else if (!empty($_POST['foto_actual']) && empty($name)) {
                // Si no se subió nueva imagen, se conserva la actual
                $imgNombre = $_POST['foto_actual'];
            } else {
                // Si no se tiene imagen previa ni nueva, se asigna una por defecto
                $imgNombre = "autor-defecto.jpg";
            }

            // Lógica para insertar un nuevo autor
            if ($id == "") {
                $data = $this->model->insertarAutor($autor, $imgNombre);
                if ($data == "ok") {
                    $msg = array('msg' => 'Autor registrado', 'icono' => 'success');
                    if (!empty($name)) {
                        move_uploaded_file($tmpName, $destino); // Guarda imagen
                    }
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El autor ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                // Lógica para actualizar un autor existente
                $imgDelete = $this->model->editAutor($id);
                if ($imgDelete['imagen'] != 'logo.png') {
                    if (file_exists("Assets/img/autor/" . $imgDelete['imagen'])) {
                        unlink("Assets/img/autor/" . $imgDelete['imagen']); // Borra imagen anterior
                    }
                }
                $data = $this->model->actualizarAutor($autor, $imgNombre, $id);
                if ($data == "modificado") {
                    if (!empty($name)) {
                        move_uploaded_file($tmpName, $destino); // Guarda nueva imagen
                    }
                    $msg = array('msg' => 'Autor modificado', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                }
            }
        }

        // Retorna el mensaje como JSON
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Obtiene los datos de un autor específico para editar
    public function editar($id)
    {
        $data = $this->model->editAutor($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Cambia el estado de un autor a inactivo (eliminar lógico)
    public function eliminar($id)
    {
        $data = $this->model->estadoAutor(0, $id); // 0 = inactivo
        if ($data == 1) {
            $msg = array('msg' => 'Autor dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Restaura un autor previamente inactivado
    public function reingresar($id)
    {
        $data = $this->model->estadoAutor(1, $id); // 1 = activo
        if ($data == 1) {
            $msg = array('msg' => 'Autor restaurado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Permite buscar autores por término (usualmente desde un campo de búsqueda)
    public function buscarAutor()
    {
        if (isset($_GET['q'])) {
            $valor = $_GET['q'];
            $data = $this->model->buscarAutor($valor); // Busca por coincidencia
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
}
