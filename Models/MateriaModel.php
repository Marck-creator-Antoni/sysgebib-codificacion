<?php
// Se define la clase MateriaModel que hereda de la clase Query
class MateriaModel extends Query
{
    // Constructor que llama al constructor de la clase padre (Query)
    public function __construct()
    {
        parent::__construct();
    }

    // Método para obtener todas las materias de la base de datos
    public function getMaterias()
    {
        $sql = "SELECT * FROM materia"; // Consulta SQL para obtener todas las materias
        $res = $this->selectAll($sql); // Ejecuta la consulta y almacena el resultado
        return $res; // Retorna los datos obtenidos
    }

    // Método para insertar una nueva materia en la base de datos
    public function insertarMateria($materia)
    {
        // Se verifica si ya existe una materia con el mismo nombre
        $verificar = "SELECT * FROM materia WHERE materia = '$materia'";
        $existe = $this->select($verificar);

        if (empty($existe)) {
            // Si no existe, se procede con la inserción
            $query = "INSERT INTO materia(materia) VALUES (?)"; // Consulta de inserción con parámetro
            $datos = array($materia); // Parámetros a insertar
            $data = $this->save($query, $datos); // Ejecuta la inserción

            // Verifica si la inserción fue exitosa
            if ($data == 1) {
                $res = "ok"; // Inserción exitosa
            } else {
                $res = "error"; // Error al insertar
            }
        } else {
            $res = "existe"; // La materia ya existe en la base de datos
        }

        return $res; // Retorna el resultado de la operación
    }

    // Método para obtener los datos de una materia específica por su ID
    public function editMateria($id)
    {
        $sql = "SELECT * FROM materia WHERE id = $id"; // Consulta SQL para obtener la materia por ID
        $res = $this->select($sql); // Ejecuta la consulta y almacena el resultado
        return $res; // Retorna los datos de la materia
    }

    // Método para actualizar el nombre de una materia existente
    public function actualizarMateria($materia, $id)
    {
        $query = "UPDATE materia SET materia = ? WHERE id = ?"; // Consulta de actualización con parámetros
        $datos = array($materia, $id); // Parámetros a actualizar
        $data = $this->save($query, $datos); // Ejecuta la actualización

        // Verifica si la actualización fue exitosa
        if ($data == 1) {
            $res = "modificado"; // Actualización exitosa
        } else {
            $res = "error"; // Error al actualizar
        }

        return $res; // Retorna el resultado
    }

    // Método para cambiar el estado de una materia (activo o inactivo)
    public function estadoMateria($estado, $id)
    {
        $query = "UPDATE materia SET estado = ? WHERE id = ?"; // Consulta para actualizar el estado
        $datos = array($estado, $id); // Parámetros de estado e ID
        $data = $this->save($query, $datos); // Ejecuta la actualización
        return $data; // Retorna el resultado de la operación
    }

    // Método para buscar materias activas por coincidencia parcial con el nombre
    public function buscarMateria($valor)
    {
        // Consulta para buscar materias cuyo nombre contenga el valor ingresado, y que estén activas
        $sql = "SELECT id, materia AS text FROM materia WHERE materia LIKE '%" . $valor . "%'  AND estado = 1 LIMIT 10";
        $data = $this->selectAll($sql); // Ejecuta la búsqueda
        return $data; // Retorna los resultados encontrados
    }
}
