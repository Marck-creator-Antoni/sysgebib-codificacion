<?php
// Clase PrestamosModel que extiende de Query para manejar operaciones con préstamos
class PrestamosModel extends Query
{
    // Constructor que llama al constructor del padre (Query)
    public function __construct()
    {
        parent::__construct();
    }


    // Método para insertar un nuevo préstamo
    public function insertarPrestamo($estudiante, $libro, $cantidad, string $fecha_prestamo, string $fecha_devolucion, string $observacion)
    {
        // Verifica si ya existe un préstamo activo para el mismo estudiante y libro
        $verificar = "SELECT * FROM prestamo WHERE id_libro = '$libro' AND id_estudiante = $estudiante AND estado = 1";
        $existe = $this->select($verificar);

        if (empty($existe)) {
            // Si no existe, inserta el préstamo
            $query = "INSERT INTO prestamo(id_estudiante, id_libro, fecha_prestamo, fecha_devolucion, cantidad, observacion) VALUES (?,?,?,?,?,?)";
            $datos = array($estudiante, $libro, $fecha_prestamo, $fecha_devolucion, $cantidad, $observacion);
            $data = $this->insert($query, $datos); // Inserta el préstamo

            if ($data > 0) {
                // Si la inserción fue exitosa, se actualiza el stock del libro
                $lib = "SELECT * FROM libro WHERE id = $libro"; // Consulta para obtener el libro
                $resLibro = $this->select($lib);
                $total = $resLibro['cantidad'] - $cantidad; // Calcula nuevo stock

                // Actualiza la cantidad del libro
                $libroUpdate = "UPDATE libro SET cantidad = ? WHERE id = ?";
                $datosLibro = array($total, $libro);
                $this->save($libroUpdate, $datosLibro);
                $res = $data; // Retorna ID del préstamo insertado
            } else {
                $res = 0; // Falla al insertar
            }
        } else {
            $res = "existe"; // Ya hay un préstamo activo con los mismos datos
        }

        return $res; // Devuelve el resultado final
    }

    // Método para actualizar el estado de un préstamo (por ejemplo: devolver)
    public function actualizarPrestamo($estado, $id)
    {
        // Actualiza el estado del préstamo (0 = devuelto)
        $sql = "UPDATE prestamo SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = $this->save($sql, $datos);

        if ($data == 1) {
            // Si se actualiza correctamente, se incrementa el stock del libro
            $lib = "SELECT * FROM prestamo WHERE id = $id"; // Obtener datos del préstamo
            $resLibro = $this->select($lib);
            $id_libro = $resLibro['id_libro'];

            // Obtener libro relacionado
            $lib = "SELECT * FROM libro WHERE id = $id_libro";
            $residLibro = $this->select($lib);
            $total = $residLibro['cantidad'] + $resLibro['cantidad']; // Sumar cantidad devuelta

            // Actualizar stock
            $libroUpdate = "UPDATE libro SET cantidad = ? WHERE id = ?";
            $datosLibro = array($total, $id_libro);
            $this->save($libroUpdate, $datosLibro);

            $res = "ok"; // Retorna éxito
        } else {
            $res = "error"; // Retorna error
        }

        return $res;
    }

    // Método para obtener la configuración del sistema
    public function selectDatos()
    {
        $sql = "SELECT * FROM configuracion"; // Consulta para obtener datos de configuración
        $res = $this->select($sql); // Ejecuta la consulta
        return $res; // Retorna los datos
    }

    // Método para obtener los datos de un libro por su ID
    public function getCantLibro($libro)
    {
        $sql = "SELECT * FROM libro WHERE id = $libro"; // Consulta para obtener libro
        $res = $this->select($sql); // Ejecuta la consulta
        return $res; // Retorna los datos del libro
    }

    // Método para obtener todos los préstamos pendientes (estado = 1)
    public function selectPrestamoDebe()
    {
        $sql = "SELECT e.id, e.nombre, l.id, l.titulo, p.id, p.id_estudiante, p.id_libro, p.fecha_prestamo, p.fecha_devolucion, p.cantidad, p.observacion, p.estado 
                FROM estudiante e 
                INNER JOIN libro l 
                INNER JOIN prestamo p ON p.id_estudiante = e.id 
                WHERE p.id_libro = l.id AND p.estado = 1 
                ORDER BY e.nombre ASC"; // Consulta con JOIN y filtro de préstamos pendientes
        $res = $this->selectAll($sql); // Ejecuta la consulta
        return $res; // Retorna resultados
    }

    // Método para obtener un préstamo específico por su ID (para mostrar detalle)
    public function getPrestamos($fechaInicio = null, $fechaFin = null)
{
    $sql = "SELECT e.nombre, l.titulo, p.* 
            FROM estudiante e 
            INNER JOIN prestamo p ON p.id_estudiante = e.id 
            INNER JOIN libro l ON p.id_libro = l.id";

    if ($fechaInicio && $fechaFin) {
        $sql .= " WHERE p.fecha_prestamo BETWEEN '$fechaInicio' AND '$fechaFin'";
    }

    return $this->selectAll($sql);
}

}
