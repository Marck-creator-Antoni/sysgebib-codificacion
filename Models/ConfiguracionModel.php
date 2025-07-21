<?php
// Clase ConfiguracionModel que extiende de Query y gestiona operaciones relacionadas con la configuración general del sistema
class ConfiguracionModel extends Query {
    // Atributos protegidos (aunque no se usan directamente aquí)
    protected $id, $nombre, $telefono, $direccion, $correo, $img;

    // Constructor que invoca al constructor de la clase padre
    public function __construct() {
        parent::__construct();
    }

    // Método que obtiene toda la información de la tabla 'configuracion'
    public function selectConfiguracion() {
        $sql = "SELECT * FROM configuracion";
        $res = $this->select($sql); // Ejecuta una consulta que retorna un solo registro
        return $res;
    }

    // Método que retorna la cantidad de registros activos (estado = 1) en una tabla específica
    public function selectDatos($nombre) {
        $sql = "SELECT COUNT(*) AS total FROM $nombre WHERE estado = 1";
        $res = $this->select($sql); // Ejecuta una consulta de conteo por tabla dinámica
        return $res;
    }

    // Método que obtiene la suma de cantidades de préstamos devueltos (estado = 0) agrupados por mes
    public function getReportes() {
        $sql = "SELECT DATE(fecha_prestamo) AS fechas, SUM(cantidad) AS cantidad_sum 
                FROM prestamo 
                WHERE estado = 0 
                GROUP BY MONTH(fecha_prestamo)";
        $res = $this->selectAll($sql); // Ejecuta una consulta que retorna múltiples registros
        return $res;
    }

    // Método que obtiene la suma de cantidades de préstamos pendientes (estado = 1) agrupados por mes
    public function getReportespendientes() {
        $sql = "SELECT DATE(fecha_prestamo) AS fechas, SUM(cantidad) AS cantidad_sum 
                FROM prestamo 
                WHERE estado = 1 
                GROUP BY MONTH(fecha_prestamo)";
        $res = $this->selectAll($sql); // Ejecuta una consulta que retorna múltiples registros
        return $res;
    }

    // Método que obtiene la lista de préstamos vencidos cuya fecha de devolución es menor a la actual y aún no han sido devueltos (estado = 1)
    public function getVerificarPrestamos($date) {
        $sql = "SELECT 
                    p.id, 
                    p.id_estudiante, 
                    p.fecha_prestamo,
                    p.fecha_devolucion, 
                    p.cantidad,
                    p.estado, 
                    e.id, 
                    e.nombre, 
                    l.id, 
                    l.titulo 
                FROM prestamo p 
                INNER JOIN estudiante e ON p.id_estudiante = e.id 
                INNER JOIN libro l ON p.id_libro = l.id 
                WHERE p.fecha_devolucion < '$date' AND p.estado = 1";
        $res = $this->selectAll($sql); // Ejecuta una consulta que devuelve todos los préstamos vencidos aún pendientes de devolución
        return $res;
    }
}
