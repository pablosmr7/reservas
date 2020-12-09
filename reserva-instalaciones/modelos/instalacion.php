<?php

include_once("DB.php");

/**
 * Clase Instalacion. Es el modelo de instalacion
 */
class Instalacion
{
    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    /**
     * Busca un libro con idLibro = $id en la base de datos.
     * @param id El id del libro que se quiere buscar.
     * @return Un objeto con el libro de la BD, o null si no lo encuentra.
     */
    public function get($id)
    {
        $result = $this->db->consulta("SELECT * FROM instalaciones
                                            WHERE instalaciones.idInstalacion = '$id'");
        return $result;
    }

    

    /**
     * Busca todos los libros de la BD
     * @return Todos los libros como objetos de un array o null en caso de error
     */
    public function getAll()
    {
        $arrayResult = array();
        $result = $this->db->consulta("SELECT * FROM instalaciones

                                            ORDER BY instalaciones.idInstalacion");

        return $result;
    }


    public function insert()
    {
        $nombre = $_REQUEST["nombre"];
        $descripcion = $_REQUEST["descripcion"];
        $dir_subida = 'imgs/instalacion/';
        $fichero_subido = $dir_subida . basename($_FILES['imagen']['name']);
        $precio = $_REQUEST["precio"];
        
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
            $result = $this->db->manipulacion("INSERT INTO instalaciones (nombre,descripcion,imagen,precio) 
                                             VALUES ('$nombre', '$descripcion', '$fichero_subido', '$precio')"); 
        } else {
            $result = -1;
        }
                
        return $result;
        
    }

    public function update()
    {
        // Primero, recuperamos todos los datos del formulario
        $id = $_REQUEST["idInstalacion"];
        $nombre = $_REQUEST["nombre"];
        $descripcion = $_REQUEST["descripcion"];
        $dir_subida = 'imgs/instalacion/';
        $fichero_subido = $dir_subida . basename($_FILES['imagen']['name']);
        $precio = $_REQUEST["precio"];

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
            $result = $this->db->manipulacion("UPDATE instalaciones SET nombre = '$nombre', descripcion = '$descripcion', precio = '$precio', imagen = '$fichero_subido' WHERE idInstalacion = '$id'");
        } else if($fichero_subido == "imgs/instalacion/"){
            $result = $this->db->manipulacion("UPDATE instalaciones SET nombre = '$nombre', descripcion = '$descripcion', precio = '$precio' WHERE idInstalacion = '$id'");
        } else {
            $result = -1;
        }

        return $result;
    }




    public function delete($id)
    {
        $r = $this->db->manipulacion("DELETE FROM instalaciones WHERE idInstalacion = '$id'");
        return $r;
    }



    public function getLastId()
    {
        $result = $this->db->consulta("SELECT MAX(idInstalacion) AS ultimoIdInstalacion FROM instalaciones");
        $idInstalacion = $result->ultimoIdInstalacion;
        return $idInstalacion;
    }

  

    public function busquedaAproximada($textoBusqueda)
    {
        $arrayResult = array();
        // Buscamos los libros de la biblioteca que coincidan con el texto de búsqueda
        if ($result = $this->db->consulta("SELECT * FROM instalaciones
					WHERE instalaciones.nombre LIKE '%$textoBusqueda%'
					OR instalaciones.descripcion LIKE '%$textoBusqueda%'
					OR instalaciones.precio LIKE '%$textoBusqueda%'
					OR instalaciones.idInstalacion LIKE '%$textoBusqueda%'
					ORDER BY instalaciones.idInstalacion")) {
            while ($fila = $result->fetch_object()) {
                $arrayResult[] = $fila;
            }
        } else {
            $arrayResult = null;
        }
        return $arrayResult;
    }
}
