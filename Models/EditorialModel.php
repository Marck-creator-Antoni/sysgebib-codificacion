<?php
// Clase que hereda de la clase Query y maneja las operaciones relacionadas con la tabla 'editorial'
class EditorialModel extends Query
{
    // Constructor que llama al constructor de la clase padre
    public function __construct()
    {
        parent::__construct();
    }

    // Obtiene todos los registros de la tabla editorial
    public function getEditorial()
    {
        $sql = "SELECT * FROM editorial";
        $res = $this->selectAll($sql);
        return $res;
    }

    // Inserta una nueva editorial si no existe previamente
    public function insertarEditorial($editorial)
    {
        // Verifica si ya existe una editorial con el mismo nombre
        $verificar = "SELECT * FROM editorial WHERE editorial = '$editorial'";
        $existe = $this->select($verificar);

        // Si no existe, realiza la inserción
        if (empty($existe)) {
            $query = "INSERT INTO editorial(editorial) VALUES (?)";
            $datos = array($editorial);
            $data = $this->save($query, $datos);

            // Verifica si la inserción fue exitosa
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            // Si ya existe, retorna el mensaje 'existe'
            $res = "existe";
        }
        return $res;
    }

    // Obtiene los datos de una editorial específica por ID para su edición
    public function editEditorial($id)
    {
        $sql = "SELECT * FROM editorial WHERE id = $id";
        $res = $this->select($sql);
        return $res;
    }

    // Actualiza el nombre de una editorial existente
    public function actualizarEditorial($editorial, $id)
    {
        $query = "UPDATE editorial SET editorial = ? WHERE id = ?";
        $datos = array($editorial, $id);
        $data = $this->save($query, $datos);

        // Verifica si la actualización fue exitosa
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }

    // Cambia el estado (activo/inactivo) de una editorial
    public function estadoEditorial($estado, $id)
    {
        $query = "UPDATE editorial SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = $this->save($query, $datos);
        return $data;
    }

    // Busca editoriales activas cuyo nombre coincida parcialmente con el valor ingresado
    public function buscarEditorial($valor)
    {
        $sql = "SELECT id, editorial AS text FROM editorial 
                WHERE editorial LIKE '%" . $valor . "%'  
                AND estado = 1 
                LIMIT 10";
        $data = $this->selectAll($sql);
        return $data;
    }
}
