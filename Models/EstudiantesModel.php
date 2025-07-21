<?php
// La clase EstudiantesModel hereda de la clase Query, que se encarga de ejecutar las consultas a la base de datos.
class EstudiantesModel extends Query {
    
    // Constructor que llama al constructor de la clase padre para establecer la conexión
    public function __construct() {
        parent::__construct();
    }

    // Método para obtener todos los registros de estudiantes
    public function getEstudiantes() {
        $sql = "SELECT * FROM estudiante"; // Consulta SQL que selecciona todos los campos de la tabla estudiante
        $res = $this->selectAll($sql);     // Ejecuta la consulta y guarda el resultado
        return $res;                       // Retorna la lista de estudiantes
    }

    // Método para insertar un nuevo estudiante en la base de datos
    public function insertarEstudiante($codigo, $dni, $nombre, $carrera, $direccion, $telefono) {
        // Verifica si ya existe un estudiante con el mismo código
        $verificar = "SELECT * FROM estudiante WHERE codigo = '$codigo'";
        $existe = $this->select($verificar); // Ejecuta la consulta de verificación

        // Si no existe el estudiante, procede a insertarlo
        if (empty($existe)) {
            $query = "INSERT INTO estudiante(codigo,dni,nombre,carrera,direccion,telefono) VALUES (?,?,?,?,?,?)";
            $datos = array($codigo, $dni, $nombre, $carrera, $direccion, $telefono); // Arreglo con los datos a insertar
            $data = $this->save($query, $datos); // Ejecuta la inserción con los datos proporcionados

            // Verifica si la inserción fue exitosa
            if ($data == 1) {
                $res = "ok";       // Retorna "ok" si se insertó correctamente
            } else {
                $res = "error";    // Retorna "error" si ocurrió algún problema
            }
        } else {
            $res = "existe";       // Si el código ya está registrado, retorna "existe"
        }
        return $res;               // Devuelve el resultado final del proceso
    }

    // Método para obtener los datos de un estudiante en específico, usando su ID
    public function editEstudiante($id) {
        $sql = "SELECT * FROM estudiante WHERE id = $id"; // Consulta SQL para buscar el estudiante por ID
        $res = $this->select($sql);                       // Ejecuta la consulta
        return $res;                                      // Retorna los datos del estudiante
    }

    // Método para actualizar los datos de un estudiante existente
    public function actualizarEstudiante($codigo, $dni, $nombre, $carrera, $direccion, $telefono, $id) {
        $query = "UPDATE estudiante SET codigo = ?, dni = ?, nombre = ?, carrera = ?, direccion = ?, telefono = ? WHERE id = ?";
        $datos = array($codigo, $dni, $nombre, $carrera, $direccion, $telefono, $id); // Arreglo con los datos nuevos
        $data = $this->save($query, $datos); // Ejecuta la actualización

        // Verifica si la actualización fue exitosa
        if ($data == 1) {
            $res = "modificado";  // Retorna "modificado" si se actualizó correctamente
        } else {
            $res = "error";       // Retorna "error" si ocurrió un problema
        }
        return $res;              // Devuelve el resultado final
    }

    // Método para cambiar el estado (activo/inactivo) de un estudiante
    public function estadoEstudiante($estado, $id) {
        $query = "UPDATE estudiante SET estado = ? WHERE id = ?"; // Consulta para actualizar el estado
        $datos = array($estado, $id);                             // Parámetros: nuevo estado e ID
        $data = $this->save($query, $datos);                      // Ejecuta la actualización
        return $data;                                             // Devuelve el resultado (1 o error)
    }

    // Método para buscar estudiantes por código o nombre, usado en autocompletado o búsquedas rápidas
    public function buscarEstudiante($valor) {
        $sql = "SELECT id, codigo, nombre AS text FROM estudiante 
                WHERE (codigo LIKE '%" . $valor . "%' OR nombre LIKE '%" . $valor . "%') 
                AND estado = 1 LIMIT 10"; // Búsqueda por coincidencia en código o nombre, solo si están activos
        $data = $this->selectAll($sql); // Ejecuta la consulta y devuelve un array de resultados
        return $data;
    }
}
