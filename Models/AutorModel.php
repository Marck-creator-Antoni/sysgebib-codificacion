<?php
// Clase AutorModel que hereda de la clase Query
class AutorModel extends Query
{
    // Constructor de la clase, llama al constructor de la clase padre
    public function __construct()
    {
        parent::__construct();
    }

    // Método para obtener todos los autores de la base de datos
    public function getAutor()
    {
        $sql = "SELECT * FROM autor"; // Consulta para seleccionar todos los registros de la tabla 'autor'
        $res = $this->selectAll($sql); // Ejecuta la consulta y guarda el resultado
        return $res; // Retorna el resultado
    }

    // Método para insertar un nuevo autor, validando si ya existe previamente
    public function insertarAutor($autor, $img)
    {
        $verificar = "SELECT * FROM autor WHERE autor = '$autor'"; // Consulta para verificar si el autor ya existe
        $existe = $this->select($verificar); // Ejecuta la consulta de verificación
        if (empty($existe)) {
            // Si no existe el autor, se inserta en la base de datos
            $query = "INSERT INTO autor(autor, imagen) VALUES (?, ?)"; // Consulta con parámetros
            $datos = array($autor, $img); // Arreglo con los datos a insertar
            $data = $this->save($query, $datos); // Ejecuta el insert con la función save
            if ($data == 1) {
                $res = "ok"; // Inserción exitosa
            } else {
                $res = "error"; // Error al insertar
            }
        } else {
            $res = "existe"; // Ya existe un autor con ese nombre
        }
        return $res; // Retorna el resultado del proceso
    }

    // Método para obtener los datos de un autor según su ID (para editar)
    public function editAutor($id)
    {
        $sql = "SELECT * FROM autor WHERE id = $id"; // Consulta para obtener el autor con el ID especificado
        $res = $this->select($sql); // Ejecuta la consulta
        return $res; // Retorna los datos del autor
    }

    // Método para actualizar los datos de un autor
    public function actualizarAutor($autor, $img, $id)
    {
        $query = "UPDATE autor SET autor = ?, imagen = ? WHERE id = ?"; // Consulta de actualización con parámetros
        $datos = array($autor, $img, $id); // Arreglo con los datos a actualizar
        $data = $this->save($query, $datos); // Ejecuta la actualización
        if ($data == 1) {
            $res = "modificado"; // Actualización exitosa
        } else {
            $res = "error"; // Error en la actualización
        }
        return $res; // Retorna el resultado del proceso
    }

    // Método para cambiar el estado (activo/inactivo) de un autor
    public function estadoAutor($estado, $id)
    {
        $query = "UPDATE autor SET estado = ? WHERE id = ?"; // Consulta para actualizar el estado del autor
        $datos = array($estado, $id); // Arreglo con el nuevo estado y el ID
        $data = $this->save($query, $datos); // Ejecuta la actualización
        return $data; // Retorna el resultado
    }

    // Método para buscar autores por nombre, utilizado generalmente en autocompletado
    public function buscarAutor($valor)
    {
        // Consulta que busca autores cuyo nombre coincida parcialmente con el valor ingresado, y que estén activos
        $sql = "SELECT id, autor AS text FROM autor WHERE autor LIKE '%" . $valor . "%'  AND estado = 1 LIMIT 10";
        $data = $this->selectAll($sql); // Ejecuta la consulta y guarda los resultados
        return $data; // Retorna los autores encontrados
    }
}
