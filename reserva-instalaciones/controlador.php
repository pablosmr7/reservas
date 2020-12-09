<?php
include_once("vista.php");
include_once("modelos/seguridad.php");
include_once("modelos/usuario.php");
include_once("modelos/instalacion.php");
//include_once("modelos/libro.php");
//include_once("modelos/persona.php");
//

class Controlador
{

	private $vista, $usuario, $instalacion;//, $libro, $persona;

	/**
	 * Constructor. Crea las variables de los modelos y la vista
	 */
	public function __construct()
	{
		$this->vista = new Vista();
		$this->usuario = new Usuario();
		$this->seguridad = new Seguridad();
		$this->instalacion = new Instalacion();
		/*$this->libro = new Libro();
		$this->persona = new Persona();
		*/
	}


	/*********************************************** INCIO SESION *****************************************/


	/**
	 * Muestra el formulario de login
	 */
	public function mostrarFormularioLogin()
	{
		$this->vista->mostrar("usuario/formularioLogin");
	}

	/**
	 * Procesa el formulario de login e inicia la sesión
	 */
	public function procesarLogin()
	{
		$usr = $_REQUEST["usr"];
		$pass = $_REQUEST["pass"];

		$usuario = $this->usuario->buscarUsuario($usr, $pass);
		
		if ($usuario) {
			$this->seguridad->abrirSesion($usuario[0]);
			$this->mostrarListaUsuarios(); /*CAMBIAR A vistaCalendario CUANDO SE IMPLEMENTEN USUARIOS */
		} else {
			// Error al iniciar la sesión
			$data['msjError'] = "Nombre de usuario o contraseña incorrectos";
			$this->vista->mostrar("usuario/formularioLogin", $data);
		}
	}

	/**
	 * Cierra la sesión
	 */
	public function cerrarSesion()
	{
		$this->seguridad->cerrarSesion();
		$data['msjInfo'] = "Sesión cerrada correctamente";
		$this->vista->mostrar("usuario/formularioLogin", $data);
	}


	/************************************************CRUD USUARIOS************************************************ */

	public function formularioInsertarUsuario(){

			$this->vista->mostrar('usuario/formularioInsertarUsuario', $data);

	}


	public function insertarUsuario()
	{

		if ($this->seguridad->haySesionIniciada()) {
			// Vamos a procesar el formulario de alta de libros
			// Primero, recuperamos todos los datos del formulario
			// Ahora insertamos el libro en la BD
			$result = $this->usuario->insert();

			if ($result == 1) {

				$data['msjInfo'] = "Libro insertado con éxito";
			} else {
				// Si la inserción del libro ha fallado, mostramos mensaje de error
				$data['msjError'] = "Ha ocurrido un error al insertar el libro. Por favor, inténtelo más tarde.";
			}
			// Terminamos mostrando la lista de libros actualizada
			$data['listaUsuarios'] = $this->usuario->getAll();
			$this->vista->mostrar("usuario/listaUsuarios", $data);
		} else {
			$this->seguridad->errorAccesoNoPermitido();
		}
	}


	/**
	 * Muestra una lista con todos los libros
	 */
	public function mostrarListaUsuarios()
	{
		$data['listaUsuarios'] = $this->usuario->getAll();
		$this->vista->mostrar("usuario/listaUsuarios", $data);
	}


	/**
	 * Elimina un libro de la base de datos
	 */
	public function borrarUsuario()
	{
		if ($this->seguridad->haySesionIniciada()) {
			// Recuperamos el id del libro
			$idUsuario = $_REQUEST["idUsuario"];
			// Eliminamos el libro de la BD
			$result = $this->usuario->delete($idUsuario);
			if ($result == 0) {
				$data['msjError'] = "Ha ocurrido un error al borrar el Usuario. Por favor, inténtelo de nuevo";
			} else {
				$data['msjInfo'] = "Usuario borrado con éxito";
			}
			// Mostramos la lista de libros actualizada
			$data['listaUsuarios'] = $this->usuario->getAll();
			$this->vista->mostrar("usuario/listaUsuarios", $data);
		} else {
			$this->seguridad->errorAccesoNoPermitido();
		}
	}


	/**
	 * Elimina un libro de la base de datos (petición por ajax)
	 */
	public function borrarUsuarioAjax()
	{
		if ($this->seguridad->haySesionIniciada()) {
			// Recuperamos el id del libro
			$idUsuario = $_REQUEST["idUsuario"];
			// Eliminamos el libro de la BD
			$result = $this->usuario->delete($idUsuario);
			if ($result == 0) {
				// Error al borrar. Enviamos el código -1 al JS
				echo "-1";
			}
			else {
				// Borrado con éxito. Enviamos el id del libro a JS
				echo $idUsuario;
			}
		} else {
			echo "-1";
		}
	}

	public function formularioModificarUsuario() {
		if ($this->seguridad->haySesionIniciada()) {

			$id = $_REQUEST["idUsuario"];
			$data['usuario'] = $this->usuario->get($id);
			
			$this->vista->mostrar('usuario/formularioModificarUsuario', $data);
		} else {
			$this->seguridad->errorAccesoNoPermitido();
		}
	}


	public function modificarUsuario() {

		if ($this->seguridad->haySesionIniciada()) {

			//lanzamos la consulta pa la bd
			$result = $this->usuario->update();
			
			if ($result == 1) {
			// Si la modificación del libro ha funcionado, continuamos actualizando la tabla "escriben".
				$data['msjInfo'] = "Usuario actualizado con éxito";
			}else {
				$data['msjError'] = "Error al actualizar el usuario";
			}
			$data['listaUsuarios'] = $this->usuario->getAll();
			$this->vista->mostrar("usuario/listaUsuarios", $data);
		} else {
			$this->seguridad->errorAccesoNoPermitido();
		}
	}





/************************************************* INSTALACIONES **********************************************************/



/**
* Muestra una lista con todos los libros
*/
public function mostrarListaInstalaciones(){

	$data['listaInstalaciones'] = $this->instalacion->getAll();
	$this->vista->mostrar("instalacion/listaInstalaciones", $data);
	}


public function formularioInsertarInstalaciones(){

	$this->vista->mostrar('instalacion/formularioInsertarInstalaciones', $data);

}


public function insertarInstalacion(){

if ($this->seguridad->haySesionIniciada()) {
	// Vamos a procesar el formulario de alta de libros
	// Primero, recuperamos todos los datos del formulario
	// Ahora insertamos el libro en la BD
	$result = $this->instalacion->insert();

	if ($result == 1) {

			$data['msjInfo'] = "Instalacion insertada con éxito";
		} else {
			// Si la inserción del libro ha fallado, mostramos mensaje de error
			$data['msjError'] = "Ha ocurrido un error al insertar la instalacion. Por favor, inténtelo más tarde.";
		}
	// Terminamos mostrando la lista de libros actualizada
	$data['listaInstalaciones'] = $this->instalacion->getAll();
	$this->vista->mostrar("instalacion/listaInstalaciones", $data);
	} else {
	$this->seguridad->errorAccesoNoPermitido();
	}
}



/**
* Elimina un libro de la base de datos
*/
public function borrarInstalaciones(){

	if ($this->seguridad->haySesionIniciada()) {
			// Recuperamos el id del libro
			$idInstalacion = $_REQUEST["idInstalacion"];
			// Eliminamos el libro de la BD
			$result = $this->instalacion->delete($idInstalacion);
			if ($result == 0) {
				$data['msjError'] = "Ha ocurrido un error al borrar la instalacion. Por favor, inténtelo de nuevo";
			} else {
				$data['msjInfo'] = "Instalacion borrada con éxito";
			}
			// Mostramos la lista de libros actualizada
			$data['listaInstalaciones'] = $this->instalacion->getAll();
			$this->vista->mostrar("instalacion/listaInstalaciones", $data);
		} else {
			$this->seguridad->errorAccesoNoPermitido();
		}
	}


/**
* Elimina un libro de la base de datos (petición por ajax)
*/
public function borrarInstalacionAjax()
	{
	if ($this->seguridad->haySesionIniciada()) {
		// Recuperamos el id del libro
		$idInstalacion = $_REQUEST["idInstalacion"];
		// Eliminamos el libro de la BD
		$result = $this->instalacion->delete($idInstalacion);
			if ($result == 0) {
				// Error al borrar. Enviamos el código -1 al JS
				echo "-1";
			}else {
				// Borrado con éxito. Enviamos el id del libro a JS
				echo $idInstalacion;
			}
		} else {
		echo "-1";
		}
	}


	public function formularioModificarInstalacion(){

		if ($this->seguridad->haySesionIniciada()) {
			// Recuperamos el libro con id = $idLibro y lo preparamos para pasárselo a la vista
			$idInstalacion = $_REQUEST["idInstalacion"];
			$data['instalacion'] = $this->instalacion->get($idInstalacion);
			
			$this->vista->mostrar('instalacion/formularioModificarInstalacion', $data);
		} else {
			$this->seguridad->errorAccesoNoPermitido();
		}
	}



	public function modificarInstalacion(){
		if ($this->seguridad->haySesionIniciada()) {
	
			$result = $this->instalacion->update();
	
			if ($result == 1) {
				// Si la modificación del libro ha funcionado, continuamos actualizando la tabla "escriben".
				$id= $_REQUEST["idInstalacion"];
				
			} else {
				// Si la modificación del libro ha fallado, mostramos mensaje de error
				$data['msjError'] = "Ha ocurrido un error al modificar la instalacion. Por favor, inténtelo más tarde.";
			}
			$data['listaInstalaciones'] = $this->instalacion->getAll();
			$this->vista->mostrar("instalacion/listaInstalaciones", $data);
		} else {
			$this->seguridad->errorAccesoNoPermitido();
		}
	}


	/**
	 * Lanza una búsqueda de libros y muestra el resultado
	 */
	public function buscarInstalacion()
	{
		// Recuperamos el texto de búsqueda de la variable de formulario
		$textoBusqueda = $_REQUEST["textoBusqueda"];
		// Lanzamos la búsqueda y enviamos los resultados a la vista de lista de libros
		$data['listaInstalaciones'] = $this->instalacion->busquedaAproximada($textoBusqueda);
		$data['msjInfo'] = "Resultados de la búsqueda: \"$textoBusqueda\"";
		$this->vista->mostrar("instalacion/listaInstalaciones", $data);

	}



}
