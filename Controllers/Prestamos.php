<?php
/**
 * Controlador Prestamos
 * Encargado de gestionar los préstamos de libros a estudiantes,
 * así como el registro, listado y devolución de los mismos.
 */
class Prestamos extends Controller
{
    /**
     * Constructor del controlador Prestamos
     * Verifica si hay una sesión activa, caso contrario redirige al login.
     * Llama también al constructor padre.
     */
    public function __construct()
    {
        session_start(); // Inicia sesión para el control de acceso
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url); // Redirige si no hay sesión activa
        }
        parent::__construct(); // Llama al constructor del controlador padre
    }

    /**
     * Carga la vista principal del módulo de préstamos
     */
    public function index()
    {
        $this->views->getView($this, "index"); // Carga la vista index del módulo
    }

    /**
     * Lista los préstamos registrados en el sistema
     * Cambia el formato visual del estado y agrega botones de acción según corresponda
     * Devuelve los datos en formato JSON
     */
    public function listar()
    {
    $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : null;
    $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : null;

    $data = $this->model->getPrestamos($fechaInicio, $fechaFin); // Ahora pasas fechas al modelo

    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i]['estado'] == 1) {
            $data[$i]['estado'] = '<span class="badge badge-secondary">Prestado</span>';
            $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary btn-sm" type="button" onclick="btnEntregar(' . $data[$i]['id'] . ');"><i class="fa fa-hourglass-start"></i></button>
                <a class="btn btn-secondary btn-sm" target="_blank" href="' . base_url . 'Prestamos/ticked/' . $data[$i]['id'] . '"><i class="fa fa-file-pdf-o"></i></a>
            </div>';
        } else {
            $data[$i]['estado'] = '<span class="badge badge-primary">Devuelto</span>';
            $data[$i]['acciones'] = '<div>
                <a class="btn btn-secondary btn-sm" target="_blank" href="' . base_url . 'Prestamos/ticked/' . $data[$i]['id'] . '"><i class="fa fa-print"></i></a>
            </div>';
        }
    }

    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
    }


    /**
     * Registra un nuevo préstamo de libro
     * Verifica disponibilidad del libro antes de registrar
     * Devuelve el resultado del proceso en JSON
     */
    public function registrar()
    {
        // Sanitiza los datos recibidos por POST
        $libro = strClean($_POST['libro']);
        $estudiante = strClean($_POST['estudiante']);
        $cantidad = strClean($_POST['cantidad']);
        $fecha_prestamo = strClean($_POST['fecha_prestamo']);
        $fecha_devolucion = strClean($_POST['fecha_devolucion']);
        $observacion = strClean($_POST['observacion']);

        // Validación de campos obligatorios
        if (empty($libro) || empty($estudiante) || empty($cantidad) || empty($fecha_prestamo) || empty($fecha_devolucion)) {
            $msg = array('msg' => 'Todo los campos son requeridos', 'icono' => 'warning');
        } else {
            // Verifica si hay suficiente stock del libro
            $verificar_cant = $this->model->getCantLibro($libro);
            if ($verificar_cant['cantidad'] >= $cantidad) {
                // Inserta el préstamo en la base de datos
                $data = $this->model->insertarPrestamo($estudiante, $libro, $cantidad, $fecha_prestamo, $fecha_devolucion, $observacion);
                if ($data > 0) {
                    $msg = array('msg' => 'Libro Prestado', 'icono' => 'success', 'id' => $data);
                } elseif ($data == "existe") {
                    $msg = array('msg' => 'El libro ya esta prestado', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al prestar', 'icono' => 'error');
                }
            } else {
                $msg = array('msg' => 'Stock no disponible', 'icono' => 'warning');
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE); // Retorna el mensaje de respuesta
        die(); // Termina la ejecución
    }

    /**
     * Marca un préstamo como devuelto
     * Cambia el estado del préstamo en la base de datos
     * @param int $id ID del préstamo a actualizar
     */
    public function entregar($id)
    {
        $datos = $this->model->actualizarPrestamo(0, $id); // Actualiza el estado del préstamo a "devuelto"
        if ($datos == "ok") {
            $msg = array('msg' => 'Libro recibido', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al recibir el libro', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE); // Envía respuesta al frontend
        die(); // Termina ejecución del método
    }
}
