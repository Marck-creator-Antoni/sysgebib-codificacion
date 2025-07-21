<?php
// Clase que maneja las operaciones relacionadas con libros en la base de datos
class LibrosModel extends Query
{
    // Constructor que llama al constructor de la clase padre 'Query'
    public function __construct()
    {
        parent::__construct(); // ejecuta constructor del padre Query
    }

    // Método para obtener todos los libros con su respectiva materia, autor y editorial
    public function getLibros() // obtener libros
    {
        // Consulta que une tablas relacionadas: libro, materia, autor y editorial
        $sql = "SELECT l.*, m.materia, a.autor, e.editorial 
        FROM libro l INNER JOIN materia m ON l.id_materia = m.id 
        INNER JOIN autor a ON l.id_autor = a.id 
        INNER JOIN editorial e ON l.id_editorial = e.id";
        $res = $this->selectAll($sql); // ejecuta la consulta
        return $res; // retorna los resultados
    }

    // Método para insertar un nuevo libro en la base de datos
    public function insertarLibros($titulo,$id_autor,$id_editorial,$id_materia,$cantidad,$num_pagina,$anio_edicion,$descripcion,$imgNombre)
    {
        // Consulta para verificar si ya existe un libro con el mismo título
        $verificar = "SELECT * FROM libro WHERE titulo = '$titulo'";
        $existe = $this->select($verificar); // ejecuta la verificación

        // Si no existe el libro, procede a insertarlo
        if (empty($existe)) {
            // Consulta para insertar un nuevo libro
            $query = "INSERT INTO libro(titulo, id_autor, id_editorial, id_materia, cantidad, num_pagina, anio_edicion, descripcion, imagen) VALUES (?,?,?,?,?,?,?,?,?)";
            // Arreglo con los datos a insertar
            $datos = array($titulo, $id_autor, $id_editorial, $id_materia, $cantidad, $num_pagina, $anio_edicion, $descripcion, $imgNombre);
            // Ejecuta el guardado
            $data = $this->save($query, $datos);
            // Retorna 'ok' si se guardó correctamente, sino 'error'
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            // Retorna 'existe' si ya hay un libro con ese título
            $res = "existe";
        }
        return $res; // retorna la respuesta
    }

    // Método para obtener los datos de un libro específico por su ID
    public function editLibros($id)
    {
        $sql = "SELECT * FROM libro WHERE id = $id"; // consulta por ID
        $res = $this->select($sql); // ejecuta la consulta
        return $res; // retorna el resultado
    }

    // Método para actualizar los datos de un libro existente
    public function actualizarLibros($titulo, $id_autor, $id_editorial, $id_materia, $cantidad, $num_pagina, $anio_edicion, $descripcion, $imgNombre, $id)
    {
        // Consulta de actualización de libro
        $query = "UPDATE libro SET titulo = ?, id_autor=?, id_editorial=?, id_materia=?, cantidad=?, num_pagina=?, anio_edicion=?, descripcion=?, imagen=? WHERE id = ?";
        // Arreglo con los datos actualizados
        $datos = array($titulo, $id_autor, $id_editorial, $id_materia, $cantidad, $num_pagina, $anio_edicion, $descripcion, $imgNombre, $id);
        $data = $this->save($query, $datos); // ejecuta la actualización

        // Retorna 'modificado' si se actualizó correctamente, sino 'error'
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res; // retorna la respuesta
    }

    // Método para cambiar el estado (activo/inactivo) de un libro
    public function estadoLibros($estado, $id)
    {
        $query = "UPDATE libro SET estado = ? WHERE id = ?"; // consulta de actualización de estado
        $datos = array($estado, $id); // datos a actualizar
        $data = $this->save($query, $datos); // ejecuta la consulta
        return $data; // retorna resultado
    }

    // Método para buscar libros por título (autocompletado)
    public function buscarLibro($valor)
    {
        // Consulta para buscar libros activos cuyo título coincida con el valor buscado (máx. 10 resultados)
        $sql = "SELECT id, titulo AS text FROM libro WHERE titulo LIKE '%" . $valor . "%' AND estado = 1 LIMIT 10";
        $data = $this->selectAll($sql); // ejecuta la consulta
        return $data; // retorna los resultados
    }

}
