<?php
    include_once("DB.php");

    class Usuario {
        private $db;
        
        /**
         * Constructor. Establece la conexión con la BD y la guarda
         * en una variable de la clase
         */
        public function __construct() {
            $this->db = new DB();
        }

       
        /**
         * Busca un usuario por nombre de usuario y password
         * @param usuario El nombre del usuario
         * @param password La contraseña del usuario
         * @return True si existe un usuario con ese nombre y contraseña, false en caso contrario
         */
        public function buscarUsuario($usuario,$password) {

            $usuario = $this->db->consulta("SELECT idUsuario, email, imagen, tipo FROM usuarios WHERE email = '$usuario' AND password = '$password'");
            if ($usuario) {
                return $usuario;
            } else {
                return null;
            }

        }

        public function get($id)
        {
            $result = $this->db->consulta("SELECT * FROM usuarios
                                                WHERE usuarios.idUsuario = '$id'");
            return $result;
        }


        public function getAll()
        {
            $arrayResult = array();
            $result = $this->db->consulta("SELECT * FROM usuarios
                                                ORDER BY usuarios.idUsuario");
    
            return $result;
        }

        public function insert(){
            
            $email = $_REQUEST["email"];
            $password = $_REQUEST["password"];
            $nombre = $_REQUEST["nombre"];
            $apellido1 = $_REQUEST["apellido1"];
            $apellido2 = $_REQUEST["apellido2"];
            $dni = $_REQUEST["dni"];
            $dir_subida = 'imgs/usuario/';
            $fichero_subido = $dir_subida . basename($_FILES['imagen']['name']);
            $tipo = $_REQUEST["tipo"];
              
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
                $result = $this->db->manipulacion("INSERT INTO usuarios (email,password,nombre,apellido1,apellido2,dni,imagen,tipo) 
                        VALUES ('$email', '$password', '$nombre', '$apellido1', '$apellido2', '$dni', '$fichero_subido', '$tipo')");        
            } else {
                 $result = -1;
            }

            
            return $result;
        }
    
        public function update() {
            $idUsuario = $_REQUEST["idUsuario"];
            $email = $_REQUEST["email"];
            $password = $_REQUEST["password"];
            $nombre = $_REQUEST["nombre"];
            $apellido1 = $_REQUEST["apellido1"];
            $apellido2 = $_REQUEST["apellido2"];
            $dni = $_REQUEST["dni"];
            $tipo = $_REQUEST["tipo"];
            $dir_subida = 'imgs/usuario/';
            $fichero_subido = $dir_subida . basename($_FILES['imagen']['name']);

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
                $result = $this->db->manipulacion("UPDATE usuarios SET email = '$email', password = '$password', nombre = '$nombre', apellido1 = '$apellido1', apellido2 = '$apellido2', dni = '$dni', imagen = '$fichero_subido', tipo = '$tipo' WHERE idUsuario = '$id'");
            } else if($fichero_subido == "imgs/usuario/"){
                $result = $this->db->manipulacion("UPDATE usuarios SET email = '$email', password = '$password', nombre = '$nombre', apellido1 = '$apellido1', apellido2 = '$apellido2', dni = '$dni', tipo = '$tipo' WHERE idUsuario = '$id'");
            } else{
                 $result = -1;
            }
            return $result;
        }




        public function delete($id){
            
            $r = $this->db->manipulacion("DELETE FROM usuarios WHERE idUsuario = '$id'");
            return $r;
        }

        public function existeNombre($nombreUsuario) {
            $result = $this->db->consulta("SELECT * FROM usuarios WHERE nombre = '$nombreUsuario'");
            if ($result != null)
                return 1;
            else  
                return 0;

        }

    }