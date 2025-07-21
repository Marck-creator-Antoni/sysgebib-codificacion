<?php
class ConfiguracionModel extends Query{
    protected $id, $nombre, $telefono, $direccion, $correo, $img;
    public function __construct()
    {
        parent::__construct();
    }
    public function selectConfiguracion()
    {
        $sql = "SELECT * FROM configuracion";
        $res = $this->select($sql);
        return $res;
    }
    public function selectDatos($nombre)
    {
        $sql = "SELECT COUNT(*) AS total FROM $nombre WHERE estado = 1";
        $res = $this->select($sql);
        return $res;
    }
    public function getReportes()
    {
        $sql = "SELECT DATE(fecha_prestamo) AS fechas, SUM(cantidad) AS cantidad_sum FROM prestamo WHERE estado =0 GROUP BY MONTH(fecha_prestamo)";
       // $sql = "SELECT titulo, cantidad FROM libro WHERE estado = 1";
        $res = $this->selectAll($sql);
        return $res;
    }

      public function getReportespendientes()
    {
        $sql = "SELECT DATE(fecha_prestamo) AS fechas, SUM(cantidad) AS cantidad_sum FROM prestamo WHERE estado = 1 GROUP BY MONTH(fecha_prestamo)";
       // $sql = "SELECT titulo, cantidad FROM libro WHERE estado = 1";
        $res = $this->selectAll($sql);
        return $res;
    }


    public function getVerificarPrestamos($date)
    {
        $sql = "SELECT p.id, p.id_estudiante, p.fecha_prestamo,p.fecha_devolucion, p.cantidad,p.estado, e.id, e.nombre, l.id, l.titulo FROM prestamo p INNER JOIN estudiante e ON p.id_estudiante = e.id INNER JOIN libro l ON p.id_libro = l.id WHERE p.fecha_devolucion < '$date' AND p.estado = 1";
        $res = $this->selectAll($sql);
        return $res;
    }
}
