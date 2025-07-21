<?php
// Se define la clase UsuariosModel que hereda de la clase Query, encargada de las operaciones con la base de datos
class UsuariosModel extends Query {
    
    // Declaración de propiedades privadas para posibles usos futuros dentro del modelo
    private $usuario, $nombre, $clave, $id, $estado;

    // Constructor que llama al constructor de la clase padre para inicializar la conexión a la base de datos
    public function __construct()
    {
        parent::__construct();
    }

    // Método para obtener un usuario válido con nombre de usuario y clave (siempre que el estado sea activo = 1)
    public function getUsuario($usuario, $clave)
    {
        // Se define la consulta SQL con los parámetros recibidos
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave' AND estado = 1";

        // Se ejecuta la consulta y se obtiene el primer resultado coincidente
        $data = $this->select($sql);

        // Se retorna el resultado de la búsqueda (puede ser un arreglo de datos o null)
        return $data;
    }
}

?>
