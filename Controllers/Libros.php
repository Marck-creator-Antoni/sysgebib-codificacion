<?php
/**
 * Controlador Libros
 * Maneja operaciones CRUD, carga de imágenes, verificación de stock y búsqueda de libros.
 */
class Libros extends Controller
{
    /**
     * Constructor: valida la sesión y llama al constructor padre.
     */
    public function __construct()
    {
        session_start(); // Inicia sesión
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url); // Redirige si no hay sesión activa
        }
        parent::__construct(); // Llama al constructor del controlador padre
    }

    /**
     * Carga la vista principal de libros
     */
    public function index()
    {
        $this->views->getView($this, "index");
    }

    /**
     * Lista todos los libros registrados desde el modelo
     * Incluye estado, acciones y previsualización de imagen
     */
    public function listar()
    {
        $data = $this->model->getLibros(); // Obtiene todos los libros

        for ($i = 0; $i < count($data); $i++) {
            // Agrega imagen del libro con clase img-thumbnail
            $data[$i]['foto'] = '<img class="img-thumbnail" src="' . base_url . "Assets/img/libros/" . $data[$i]['imagen'] . '" width="100">';
            
            if ($data[$i]['estado'] == 1) {
                // Libro activo
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div class="d-flex">
                    <button class="btn btn-primary btn-sm" type="button" onclick="btnEditarLibro(' . $data[$i]['id'] . ');"><i class="fa fa-pencil-square-o"></i></button>&nbsp;
                    <button class="btn btn-danger btn-sm" type="button" onclick="btnEliminarLibro(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>
                <div/>';
            } else {
                // Libro inactivo
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                    <button class="btn btn-success btn-sm" type="button" onclick="btnReingresarLibro(' . $data[$i]['id'] . ');"><i class="fa fa-reply-all"></i></button>
                <div/>';
            }
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE); // Devuelve datos en JSON
        die();
    }

    /**
     * Registra o actualiza libros según se reciba o no un ID
     * También gestiona subida de imagen
     */
    public function registrar()
    {
        // Se reciben y limpian los datos del formulario
        $titulo = strClean($_POST['titulo']);
        $autor = strClean($_POST['autor']);
        $editorial = strClean($_POST['editorial']);
        $materia = strClean($_POST['materia']);
        $cantidad = strClean($_POST['cantidad']);
        $num_pagina = strClean($_POST['num_pagina']);
        $anio_edicion = strClean($_POST['anio_edicion']);
        $descripcion = strClean($_POST['descripcion']);
        $id = strClean($_POST['id']);

        // Manejo de imagen (si existe)
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $fecha = date("YmdHis"); // Marca de tiempo para evitar duplicados
        $tmpName = $img['tmp_name'];

        // Validación de campos obligatorios
        if (empty($titulo) || empty($autor) || empty($editorial) || empty($materia) || empty($cantidad)) {
            $msg = array('msg' => 'Todo los campos son requeridos', 'icono' => 'warning');
        } else {
            // Validación y tratamiento de imagen
            if (!empty($name)) {
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $formatos_permitidos = array('png', 'jpeg', 'jpg');

                if (!in_array($extension, $formatos_permitidos)) {
                    $msg = array('msg' => 'Archivo no permitido', 'icono' => 'warning');
                } else {
                    $imgNombre = $fecha . ".jpg"; // Renombra imagen
                    $destino = "Assets/img/libros/" . $imgNombre;
                }
            } else if (!empty($_POST['foto_actual']) && empty($name)) {
                $imgNombre = $_POST['foto_actual']; // Usa imagen actual
            } else {
                $imgNombre = "libro-defecto.png"; // Imagen por defecto
            }

            // Inserción de nuevo libro
            if ($id == "") {
                $data = $this->model->insertarLibros(
                    $titulo, $autor, $editorial, $materia, $cantidad,
                    $num_pagina, $anio_edicion, $descripcion, $imgNombre
                );

                if ($data == "ok") {
                    if (!empty($name)) {
                        move_uploaded_file($tmpName, $destino); // Guarda imagen
                    }
                    $msg = array('msg' => 'Libro registrado', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El libro ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }

            } else {
                // Actualización de libro existente
                $imgDelete = $this->model->editLibros($id);
                if ($imgDelete['imagen'] != 'logo.png') {
                    if (file_exists("Assets/img/libros/" . $imgDelete['imagen'])) {
                        unlink("Assets/img/libros/" . $imgDelete['imagen']); // Elimina imagen anterior
                    }
                }

                $data = $this->model->actualizarLibros(
                    $titulo, $autor, $editorial, $materia, $cantidad,
                    $num_pagina, $anio_edicion, $descripcion, $imgNombre, $id
                );

                if ($data == "modificado") {
                    if (!empty($name)) {
                        move_uploaded_file($tmpName, $destino); // Guarda nueva imagen
                    }
                    $msg = array('msg' => 'Libro modificado', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                }
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE); // Respuesta en JSON
        die();
    }

    /**
     * Devuelve los datos de un libro específico por su ID
     * @param int $id
     */
    public function editar($id)
    {
        $data = $this->model->editLibros($id); // Consulta libro
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    /**
     * Elimina lógicamente un libro (cambia estado a inactivo)
     * @param int $id
     */
    public function eliminar($id)
    {
        $data = $this->model->estadoLibros(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Libro dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    /**
     * Restaura un libro dado de baja (cambia estado a activo)
     * @param int $id
     */
    public function reingresar($id)
    {
        $data = $this->model->estadoLibros(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Libro restaurado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    /**
     * Verifica la cantidad de un libro específico
     * @param int $id_libro
     */
    public function verificar($id_libro)
    {
        if (is_numeric($id_libro)) {
            $data = $this->model->editLibros($id_libro); // Consulta cantidad
            if (!empty($data)) {
                $msg = array('cantidad' => $data['cantidad'], 'icono' => 'success');
            }
        } else {
            $msg = array('msg' => 'Error Fatal', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    /**
     * Busca libros por coincidencia parcial en nombre u otro criterio
     * Utilizado normalmente en autocompletado o búsqueda dinámica
     */
    public function buscarLibro()
    {
        if (isset($_GET['lb'])) {
            $valor = $_GET['lb'];
            $data = $this->model->buscarLibro($valor);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
}
